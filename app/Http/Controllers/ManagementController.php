<?php

namespace App\Http\Controllers;
use App\Services\GeocodingService;
use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Department;
use App\Models\LeaveType;
use App\Models\Notice;
use App\Models\NocApplication;
use App\Models\Office;
use App\Models\Warning;
use App\Models\Project;
use App\Models\Leave;
use App\Models\Promotion;
use App\Models\Salary;
use App\Models\MonthlySalarySheet;
use App\Models\HourlyWorkUpdate;
use App\Models\NocType;
use App\Models\Noc;
use App\Models\Resign;
use App\Models\AppointmentLetter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ManagementController extends Controller
{

    public function login()
    {
        return view('management.login');
    }

    public function authenticate(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        if (Auth::guard('management')->attempt([
            'email' => $request->email,
            'password' => $request->password
        ])) {
            if (Auth::guard('management')->user()->role != 'management') {
                Auth::guard('management')->logout();
                return redirect()->route('management.login')->with('error', 'Access denied ! Unauthorised user.');
            }
            return redirect()->route('management.dashboard');
        } else {
            return redirect()->route('management.login')->with('error', 'Something went wrong');
        }
    }

    public function profile()
    {
        $data['departments'] = Department::all();
        $data['offices'] = Office::all();
        $data['salaryStructure'] = Salary::where('employee_id', Auth::guard('management')->user()->id)->first(); // To view salary structure
        return view('management.profile', $data);
    }

    public function profile_update(Request $request)
    {
        $user = Auth::guard('management')->user();

        $request->validate([
            'name' => 'nullable|string',
            'email' => 'nullable|email',
            'nid' => 'nullable',
            'password' => 'nullable|min:6', // optional with confirmation
            'mobile' => [
                'nullable',
                'digits:11',
                'numeric',
                Rule::unique('users', 'mobile')->ignore(Auth::id()),
            ],
            'emergency_contact' => [
                'nullable',
                'digits:11',
                'numeric',
                Rule::unique('users', 'emergency_contact')->ignore(Auth::id()),
            ],
            'emergency_person' => 'nullable|string|max:255',
            'relation' => 'nullable|string|max:255',
            'address'  => 'nullable|string|max:255',
            'blood_group'  => 'nullable|string|max:255',
        ], [
            'password.min' => 'Password must be at least 6 characters.',
            'mobile.unique' => 'Mobile number is already exist!',
            'mobile.digits' => 'Mobile number must be exactly 11 digits.',
        ]);

        $data = [];

        if ($request->filled('name')) {
            $data['name'] = $request->name;
        }

        if ($request->filled('email')) {
            $data['email'] = $request->email;
        }

        if ($request->filled('nid')) {
            $data['nid'] = $request->nid;
        }

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        if ($request->filled('mobile')) {
            $data['mobile'] = $request->mobile;
        }

        if ($request->filled('address')) {
            $data['address'] = $request->address;
        }

        if ($request->filled('blood_group')) {
            $data['blood_group'] = $request->blood_group;
        }

        if ($request->filled('emergency_contact')) {
            $data['emergency_contact'] = $request->emergency_contact;
        }

        if ($request->filled('emergency_person')) {
            $data['emergency_person'] = $request->emergency_person;
        }

        if ($request->filled('relation')) {
            $data['relation'] = $request->relation;
        }

        if ($request->hasFile('image')) {

            $request->validate([
                'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            ]);

            // Delete old profile picture if exists
            if ($user->image && Storage::disk('public')->exists($user->image)) {
                Storage::disk('public')->delete($user->image);
            }

            $data['image'] = $request->file('image')->store('profiles', 'public');
        }

        $user->update($data);

        return redirect()->route('management.profile')->with('success', 'Profile updated successfully.');
    }


    public function dashboard(Request $request)
    {
    $user = Auth::guard('management')->user();
    $today = \Carbon\Carbon::today()->toDateString();

    // Check if management is on leave today
    $isOnLeaveToday = Leave::where('employee_id', $user->id)
        ->where('status', 'Approved')->where('total_day', '>', 0)
        ->whereDate('from_date', '<=', $today)
        ->whereDate('to_date', '>=', $today)
        ->exists();

    // Get the selected office from request
    $selectedOfficeId = $request->input('office');

    // Today's attendance
    $attendance = Attendance::where('employee_id', $user->id)
        ->where('date', $today)
        ->first();

    $statusMessage = null;
    if ($attendance && $attendance->check_in) {
        $checkInTime = \Carbon\Carbon::createFromFormat('h:i:s A', $attendance->check_in);
        $lateThreshold = \Carbon\Carbon::createFromTime(9, 20, 59);

        $statusMessage = $checkInTime->greaterThan($lateThreshold)
            ? 'You are late today!'
            : 'You are on time today!';
    }

    // All attendance for calendar
    $attendances = Attendance::where('employee_id', $user->id)->get(['date', 'check_in', 'check_out','check_in_lat','check_in_long','check_in_address','check_out_lat','check_out_long','check_out_address']);

    // Get approved leaves for this employee
    $approvedLeaves = Leave::where('employee_id', $user->id)
        ->where('status', 'Approved')->where('total_day', '>', 0)
        ->get(['from_date', 'to_date', 'leave_type']);

    // Create an array of all leave dates
    $leaveDates = [];
    foreach ($approvedLeaves as $leave) {
        $startDate = \Carbon\Carbon::parse($leave->from_date);
        $endDate = \Carbon\Carbon::parse($leave->to_date);

        // Generate all dates between from_date and to_date (inclusive)
        for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
            $leaveDates[$date->format('Y-m-d')] = [
                'leave_type' => $leave->leave_type,
                'is_leave' => true
            ];
        }
    }

    // Prepare calendar data
    $calendarData = $attendances->map(function ($item) use ($leaveDates) {
        // Check if this date is a leave day
        if (isset($leaveDates[$item->date])) {
            return [
                'date' => $item->date,
                'title' => 'On Leave - ' . $leaveDates[$item->date]['leave_type'],
                'color' => 'blue',
                'check_in' => null,
                'check_in_lat' => null,
                'check_in_long' => null,
                'check_in_address' => null,
                'check_out' => null,
                'check_out_lat' => null,
                'check_out_long' => null,
                'check_out_address' => null,
                'is_leave' => true,
                'leave_type' => $leaveDates[$item->date]['leave_type']
            ];
        }

        // Normal attendance day
        $checkInTime = \Carbon\Carbon::createFromFormat('h:i:s A', $item->check_in);
        $lateThreshold = \Carbon\Carbon::createFromTime(9, 20, 59);
        $isLate = $checkInTime->greaterThan($lateThreshold);

        return [
            'date' => $item->date,
            'title' => $isLate ? 'Late' : 'On Time',
            'color' => $isLate ? 'red' : 'green',
            'check_in' => $item->check_in,
            'check_in_lat' => $item->check_in_lat,
            'check_in_long' => $item->check_in_long,
            'check_in_address' => $item->check_in_address,
            'check_out' => $item->check_out,
            'check_out_lat' => $item->check_out_lat,
            'check_out_long' => $item->check_out_long,
            'check_out_address' => $item->check_out_address,
            'is_leave' => false,
            'leave_type' => null
        ];
    });

    // Add leave days that don't have attendance records
    foreach ($leaveDates as $date => $leaveInfo) {
        // Check if this date already exists in calendarData
        $exists = $calendarData->first(function ($item) use ($date) {
            return $item['date'] === $date;
        });

        if (!$exists) {
            $calendarData->push([
                'date' => $date,
                'title' => 'On Leave' ,
                'color' => 'blue',
                'check_in' => null,
                'check_in_lat' => null,
                'check_in_long' => null,
                'check_in_address' => null,
                'check_out' => null,
                'check_out_lat' => null,
                'check_out_long' => null,
                'check_out_address' => null,
                'is_leave' => true,
                'leave_type' => $leaveInfo['leave_type']
            ]);
        }
    }

    // Sort calendar data by date
    $calendarData = $calendarData->sortBy('date')->values();



    $warning = Warning::where('to_employee',$user->id)->count();
    // $notice = Notice::orderBy('created_at', 'desc')->get();

    // Get unread notices only
    $notice = Notice::where('expire_date', '>=', $today)
        ->orderBy('created_at', 'desc')
        ->whereDoesntHave('readBy', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })
        ->get();

    // Get attendance data with office filtering
    $attendQuery = Attendance::query();
    if ($selectedOfficeId) {
        $attendQuery->whereHas('employee', function ($query) use ($selectedOfficeId) {
            $query->where('office', $selectedOfficeId);
        });
    }
    $attend = $attendQuery->orderBy(DB::raw("STR_TO_DATE(check_in, '%h:%i:%s %p')"), 'asc')->get();

    // Get employees with office filtering
    $employeesQuery = User::query();
    if ($selectedOfficeId) {
        $employeesQuery->where('office', $selectedOfficeId);
    }
    $employees = $employeesQuery->get();

    $today = Carbon::today()->toDateString();
    $lateThresholdTime = Carbon::createFromTimeString('09:20:59');

    // Get deliverymen (map markers) with office filtering
    $deliverymenQuery = Attendance::with('employee:id,name,image,office')
        ->select('employee_id', 'date', 'check_in_lat', 'check_in_long', 'check_in', 'check_out', 'check_out_lat', 'check_out_long')
        ->whereDate('date', $today)
        ->whereNotNull('check_in_lat');

    // Apply office filter to deliverymen query
    if ($selectedOfficeId) {
        $deliverymenQuery->whereHas('employee', function ($query) use ($selectedOfficeId) {
            $query->where('office', $selectedOfficeId);
        });
    }

    $deliverymen = $deliverymenQuery->get()
        ->map(function ($dm) use ($lateThresholdTime) {
            $defaultImagePath = 'dist/img/user.jpg';
            $imagePath = $dm->employee->image ?? '';

            $dm->image = asset('storage/' . ($imagePath ?: $defaultImagePath));
            $dm->employee_name = $dm->employee->name ?? 'Unknown Employee';
            $dm->office = $dm->employee->office ?? null;

            // Attendance logic
            $dm->is_on_time = false;
            if ($dm->check_in) {
                $checkInTime = Carbon::parse($dm->check_in);
                if ($checkInTime->lessThanOrEqualTo($lateThresholdTime)) {
                    $dm->is_on_time = true;
                }
            }

            // Clean up the object
            unset($dm->employee);

            return $dm;
        });

            $offices = Office::all();

            $birthday = User::where('status','active')->get();
            $totalLeaves = Leave::where('employee_id', $user->id)
        ->where('status','Approved')
        ->whereYear('created_at', now()->year)
        ->sum('total_day');

    $totalEmployee = User::where('status','active')->whereIn('role',['admin','management','employee'])->count();
    $male = User::where('status','active')->whereIn('role',['admin','management','employee'])->where('gender','male')->count();
    $female = User::where('status','active')->whereIn('role',['admin','management','employee'])->where('gender','female')->count();

    $hq = User::where('status','active')->whereIn('role',['admin','management','employee'])->where('office',1)->count();
    $hqMale = User::where('status','active')->whereIn('role',['admin','management','employee'])->where('office',1)->where('gender','male')->count();
    $hqFemale = User::where('status','active')->whereIn('role',['admin','management','employee'])->where('office',1)->where('gender','female')->count();

    $dncc = User::where('status','active')->whereIn('role',['admin','management','employee'])->where('office',2)->count();
    $dnccMale = User::where('status','active')->whereIn('role',['admin','management','employee'])->where('office',2)->where('gender','male')->count();
    $dnccFemale = User::where('status','active')->whereIn('role',['admin','management','employee'])->where('office',2)->where('gender','female')->count();

    $ccc = User::where('status','active')->whereIn('role',['admin','management','employee'])->where('office',3)->count();
    $cccMale = User::where('status','active')->whereIn('role',['admin','management','employee'])->where('office',3)->where('gender','male')->count();
    $cccFemale = User::where('status','active')->whereIn('role',['admin','management','employee'])->where('office',3)->where('gender','female')->count();

    return view('management.dashboard',compact(
        'attendance',
        'birthday',
        'offices',
        'selectedOfficeId',
        'statusMessage',
        'calendarData',
        'warning',
        'notice',
        'totalLeaves',
        'employees',
        'attend',
        'deliverymen',
        'isOnLeaveToday',
        'totalEmployee',
        'male',
        'female',
        'hq',
        'hqMale',
        'hqFemale',
        'dncc',
        'dnccMale',
        'dnccFemale',
        'ccc',
        'cccMale',
        'cccFemale',

    ));
    }

//==================================================================
// Previous check-in and check-out methods without geocoding

    // public function checkIn(Request $request)
    // {
    //     $user = Auth::guard('management')->user();
    //     $today = \Carbon\Carbon::today()->toDateString();

    //     // Check if admin is on leave today
    //     $isOnLeaveToday = Leave::where('employee_id', $user->id)
    //     ->where('status', 'Approved')
    //     ->whereDate('from_date', '<=', $today)
    //     ->whereDate('to_date', '>=', $today)
    //     ->exists();

    //     if ($isOnLeaveToday)
    //     {
    //     return response()->json([
    //         'message' => 'You cannot check in as you are on leave today.',
    //         'is_on_leave' => true
    //     ], 400);
    //     }

    //     // Prevent multiple check-ins in a single day
    //     $attendance = Attendance::where('employee_id', $user->id)
    //         ->where('date', $today)
    //         ->first();

    //     if ($attendance) {
    //         return response()->json(['message' => 'Already checked in today'], 400);
    //     }

    //     $currentTime = \Carbon\Carbon::now();
    //     $lateThreshold = \Carbon\Carbon::createFromTime(9, 20, 59); // 09:20:59 AM

    //     $statusMessage = $currentTime->greaterThan($lateThreshold)
    //         ? 'You are late today!'
    //         : 'You are on time today!';

    //     Attendance::create([
    //         'employee_id' => $user->id,
    //         'office' => $user->office,
    //         'date' => $today,
    //         'check_in' => $currentTime->format('h:i:s A'),
    //         'check_in_lat' => $request->latitude,
    //         'check_in_long' => $request->longitude,
    //     ]);

    //     return response()->json([
    //         'message' => 'Check In Successful',
    //         'status' => $statusMessage,
    //     ]);
    // }

    // public function checkOut(Request $request)
    // {
    //     $user = Auth::guard('management')->user();
    //     $today = \Carbon\Carbon::today()->toDateString();

    //     $attendance = Attendance::where('employee_id', $user->id)
    //         ->where('date', $today)
    //         ->first();

    //     if (! $attendance || $attendance->check_out) {
    //         return response()->json(['message' => 'Already checked out or not checked in yet'], 400);
    //     }

    //     $attendance->update([
    //         'check_out' => \Carbon\Carbon::now()->format('h:i:s A'), // fixed to match check-in format
    //         'check_out_lat' => $request->latitude,
    //         'check_out_long' => $request->longitude,
    //     ]);

    //     return response()->json(['message' => 'Check Out Successful']);
    // }
//==================================================================

//======================== Sanjoy Dey ==============================

//==================================================================
// Updated check-in and check-out methods with geocoding

    protected $geocodingService;

    public function __construct(GeocodingService $geocodingService)
    {
        $this->geocodingService = $geocodingService;
    }

    public function checkIn(Request $request)
    {
        $user = Auth::guard('management')->user();
        $office = $user->office;
        $today = Carbon::today()->toDateString();

        // Check if employee is on leave today
        $isOnLeaveToday = Leave::where('employee_id', $user->id)
            ->where('status', 'Approved')
            ->whereDate('from_date', '<=', $today)
            ->whereDate('to_date', '>=', $today)
            ->exists();

        if ($isOnLeaveToday) {
            return response()->json([
                'message' => 'You cannot check in as you are on leave today.',
                'is_on_leave' => true
            ], 400);
        }

        // Prevent multiple check-ins in a single day
        $attendance = Attendance::where('employee_id', $user->id)
            ->where('date', $today)
            ->first();

        if ($attendance) {
            return response()->json(['message' => 'Already checked in today'], 400);
        }

        $currentTime = Carbon::now();
        $lateThreshold = Carbon::createFromTime(9, 20, 59); // 09:20 AM

        $statusMessage = $currentTime->greaterThan($lateThreshold)
            ? 'You are late today!'
            : 'You are on time today!';

        // Get address from coordinates
        $address = null;
        if ($request->latitude && $request->longitude) {
            $address = $this->geocodingService->getAddressFromCoordinates(
                $request->latitude,
                $request->longitude
            );
        }

        // Create attendance record with address
        $attendance = Attendance::create([
            'employee_id' => $user->id,
            'office' => $office,
            'date' => $today,
            'check_in' => $currentTime->format('h:i:s A'),
            'check_in_lat' => $request->latitude,
            'check_in_long' => $request->longitude,
            'check_in_address' => $address, // Store the full address
        ]);

        return response()->json([
            'message' => 'Check In Successful',
            'status' => $statusMessage,
            'address' => $address,
            'time' => $currentTime->format('h:i:s A'),
        ]);
    }

    public function checkOut(Request $request)
    {
        $user = Auth::guard('management')->user();
        $today = Carbon::today()->toDateString();

        $attendance = Attendance::where('employee_id', $user->id)
            ->where('date', $today)
            ->first();

        if (!$attendance || $attendance->check_out) {
            return response()->json(['message' => 'Already checked out or not checked in yet'], 400);
        }

        // Get address from coordinates
        $address = null;
        if ($request->latitude && $request->longitude) {
            $address = $this->geocodingService->getAddressFromCoordinates(
                $request->latitude,
                $request->longitude
            );
        }

        $currentTime = Carbon::now();

        $attendance->update([
            'check_out' => $currentTime->format('h:i:s A'),
            'check_out_lat' => $request->latitude,
            'check_out_long' => $request->longitude,
            'check_out_address' => $address, // Store the full address
        ]);

        return response()->json([
            'message' => 'Check Out Successful',
            'address' => $address,
            'time' => $currentTime->format('h:i:s A'),
        ]);
    }

//==================================================================

    public function project_add()
    {
        $data['employees'] = User::where('role','employee')->get();
        $data['employers'] = User::where('role','!=','employee')->get();
        return view('management.add_project', $data);
    }

    public function project_add_store(Request $request)
    {
        $request->validate([

            'employee' => 'required',
            'employer' => 'required',
            'assign_date' => 'required',
            'deadline' => 'required',
            'project_name' => 'required',
            'details' => 'required',
            'status' => 'required',
        ]);

        $data = new Project();
        $data->employee = $request->employee;
        $data->employer = $request->employer;
        $data->assign_date = $request->assign_date;
        $data->deadline = $request->deadline;
        $data->delivery_date = null;
        $data->project_name = $request->project_name;
        $data->project_details = $request->details;
        $data->status = $request->status;
        $data->progress = 0;

        $data->save();

        return redirect()->back()->with('success','Project assigned successfully.');
    }

    public function project_all(Request $request)
    {
        $query = Project::with('employee');

       if ($request->employee) {
            $query->orderBy('id','desc')->where('employee', $request->employee)->where('employer',Auth::guard('management')->user()->id);
            $data['employees'] = $query->get();
        } else {
            $data['employees'] = Project::orderBy('id','desc')->where('employer',Auth::guard('management')->user()->id)->get();
        }

        $data['employee'] = User::where('role', 'employee')->get();

        return view('management.all_project', $data);
    }

    public function project_delete($id)
    {
        $data = Project::findOrFail($id)->where('employer', Auth::guard('management')->user()->id)->where('id',$id);
        if(empty($data))
            {
                return redirect()->route('management.project_all')->with('error', 'Sorry! Project cannot be deleted.');
            }
        $data->delete();

        return redirect()->route('management.project_all')->with('success', 'Project deleted successfully.');
    }

    public function project($id)
    {
        $data['project'] = Project::findOrFail($id);
        $data['assigned'] = Project::count();
        $data['employees'] = User::where('role','employee')->get();
        $data['employers'] = User::where('role','!=','employee')->get();

        return view('management.project', $data);
    }

    public function project_edit($id)
    {
        $data['project'] = Project::findOrFail($id);
        $data['employees'] = User::where('role','employee')->where('status','active')->get();
        $data['employers'] = User::where('role','!=','employee')->where('status','active')->get();
        return view('management.edit_project', $data);
    }

    public function project_update(Request $request,$id)
    {
        $project = Project::findOrFail($id);

        $request->validate([
            'employee' => 'nullable',
            'employer' => 'nullable',
            'assign_date' => 'nullable',
            'deadline' => 'nullable',
            'project_name' => 'nullable',
            'project_details' => 'nullable',
            'status' => 'nullable',

        ]);

        $data = [];

        if ($request->filled('employee')) {
            $data['employee'] = $request->employee;
        }

        if ($request->filled('employer')) {
            $data['employer'] = $request->employer;
        }

        if ($request->filled('assign_date')) {
            $data['assign_date'] = $request->assign_date;
        }

        if ($request->filled('deadline')) {
            $data['deadline'] = $request->deadline;
        }

        if ($request->filled('project_name')) {
            $data['project_name'] = $request->project_name;
        }

        if ($request->filled('details')) {
            $data['project_details'] = $request->details;
        }

        if ($request->filled('status')) {
            $data['status'] = $request->status;
        }


        $project->update($data);

        return redirect()->route('management.project',$id)->with('success', 'Project updated successfully.');
    }

    public function notice($id)
    {
        $notice = Notice::findOrFail($id);
        $user = Auth::guard('management')->user();

        // Mark the notice as read if not already read
        if (!$notice->isReadBy($user->id)) {
        $notice->readBy()->attach($user->id, ['read_at' => now()]);
        }
        return view('management.notice', compact('notice'));
    }

    public function notice_all()
    {
        $data['notices'] = Notice::orderBy('id','desc')->get();
        return view('management.all_notice', $data);
    }

    public function all_employee(Request $request)
    {

        $data['departments'] = Department::all();

        $query = User::whereIn('role', ['admin', 'management','employee']);

        // Filter by Department if selected
    if ($request->filled('department')) {
        $query->where('department', $request->department);
    }

    $records = $query->get();

    $data['employees'] = $records;

        return view('management.all_employee', $data);
    }

    public function employee_profile($id)
    {
        $data['employee'] = User::findOrFail($id);
        $data['promotion'] = Promotion::where('employee_id', $id)->orderBy('id','desc')->get();
        $data['resigns'] = Resign::where('employee_id', $id)->get();
        $data['departments'] = Department::all();
        $data['offices'] = Office::all();


        // All attendance for calendar
    $attendances = Attendance::where('employee_id', $id)->get(['date', 'check_in', 'check_out','check_in_lat','check_in_long','check_in_address','check_out_lat','check_out_long','check_out_address']);

    // Get approved leaves for this employee
    $approvedLeaves = Leave::where('employee_id', $id)
        ->where('status', 'Approved')->where('total_day','>',0)
        ->get(['from_date', 'to_date', 'leave_type']);

    // Create an array of all leave dates
    $leaveDates = [];
    foreach ($approvedLeaves as $leave) {
        $startDate = \Carbon\Carbon::parse($leave->from_date);
        $endDate = \Carbon\Carbon::parse($leave->to_date);

        // Generate all dates between from_date and to_date (inclusive)
        for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
            $leaveDates[$date->format('Y-m-d')] = [
                'leave_type' => $leave->leave_type,
                'is_leave' => true
            ];
        }
    }

    // Prepare calendar data
    $calendarData = $attendances->map(function ($item) use ($leaveDates) {
        // Check if this date is a leave day
        if (isset($leaveDates[$item->date])) {
            return [
                'date' => $item->date,
                'title' => 'On Leave - ' . $leaveDates[$item->date]['leave_type'],
                'color' => 'blue',
                'check_in' => null,
                'check_in_lat' => null,
                'check_in_long' => null,
                'check_in_address' => null,
                'check_out' => null,
                'check_out_lat' => null,
                'check_out_long' => null,
                'check_out_address' => null,
                'is_leave' => true,
                'leave_type' => $leaveDates[$item->date]['leave_type']
            ];
        }

        // Normal attendance day
        $checkInTime = \Carbon\Carbon::createFromFormat('h:i:s A', $item->check_in);
        $lateThreshold = \Carbon\Carbon::createFromTime(9, 20, 59);
        $isLate = $checkInTime->greaterThan($lateThreshold);

        return [
            'date' => $item->date,
            'title' => $isLate ? 'Late' : 'On Time',
            'color' => $isLate ? 'red' : 'green',
            'check_in' => $item->check_in,
            'check_in_lat' => $item->check_in_lat,
            'check_in_long' => $item->check_in_long,
            'check_in_address' => $item->check_in_address,
            'check_out' => $item->check_out,
            'check_out_lat' => $item->check_out_lat,
            'check_out_long' => $item->check_out_long,
            'check_out_address' => $item->check_out_address,
            'is_leave' => false,
            'leave_type' => null
        ];
    });

    // Add leave days that don't have attendance records
    foreach ($leaveDates as $date => $leaveInfo) {
        // Check if this date already exists in calendarData
        $exists = $calendarData->first(function ($item) use ($date) {
            return $item['date'] === $date;
        });

        if (!$exists) {
            $calendarData->push([
                'date' => $date,
                'title' => 'On Leave' ,
                'color' => 'blue',
                'check_in' => null,
                'check_in_lat' => null,
                'check_in_long' => null,
                'check_in_address' => null,
                'check_out' => null,
                'check_out_lat' => null,
                'check_out_long' => null,
                'check_out_address' => null,
                'is_leave' => true,
                'leave_type' => $leaveInfo['leave_type']
            ]);
        }
    }

    // Sort calendar data by date
    $calendarData = $calendarData->sortBy('date')->values();

    $data['calendarData'] = $calendarData;
    $data['attendances'] = $attendances;

    $data['all_project'] = Project::where('employee',$id)->count();
    $data['completed'] = Project::where('employee',$id)->where('status','Completed')->count();
    $data['ongoing'] = Project::where('employee',$id)->where('status','Ongoing')->count();
    $data['pending'] = Project::where('employee',$id)->where('status','Pending')->count();
    $data['onTimeDelivery'] = Project::where('employee', $id)->whereColumn('deadline', '>=', 'submission_date')->whereNotNull('submission_date')->count();
    $data['late_Delivery'] = Project::where('employee', $id)->whereColumn('deadline', '<', 'submission_date')->whereNotNull('submission_date')->count();

        return view('management.employee_profile', $data);
    }

    public function leave_application()
    {
        $data['leave_types'] = LeaveType::all();

        return view('management.leave_application', $data);
    }

    public function leave_application_store(Request $request)
    {
        $request->validate([

            'employee_id' => 'required',
            'leave_type' => 'required',
            'day_type' => 'required',
            'from_date' => 'required',
            'to_date' => 'required',
            'total_day' => 'required',
            'application' => 'required',
        ]);

        $data = new Leave;
        $data->employee_id = $request->employee_id;
        $data->leave_type = $request->leave_type;
        $data->from_date = $request->from_date;
        $data->to_date = $request->to_date;
        if($request->day_type == 'Half Day') {
            $data->total_day = 0;
        }
        else{
            $data->total_day = $request->total_day;
        }
        $data->approved_by = null;
        $data->status = 'Applied';
        $data->application = $request->application;

        $data->save();

        return redirect()->route('management.leave_all')->with('success', 'Application submitted successfully.');
    }

    public function leave_all()
    {
        $data['my_leaves'] = Leave::orderBy('id', 'desc')->where('employee_id', Auth::guard('management')->user()->id)->get();
        $data['leave_types'] = LeaveType::all();

        return view('management.my_leave', $data);
    }

    public function leave_details($id)
    {
        $data['details'] = Leave::findOrFail($id);
        $data['leave_types'] = LeaveType::all();
        $data['employers'] = User::where('role', '!=', 'employee')->get();

        return view('management.leave_details', $data);
    }

    public function noc_application()
    {
        return view('management.noc_application');
    }

    public function noc_application_store(Request $request)
    {
        $request->validate([

            'application' => 'required',
        ]);

        $data = new NocApplication;
        $data->employee_id = $request->employee_id;
        $data->approved_by = null;
        $data->status = 'Applied';
        $data->application = $request->application;

        $data->save();

        return redirect()->route('management.noc_all')->with('success', 'NOC Application submitted successfully.');
    }

    public function noc_all()
    {
        $data['my_nocs'] = NocApplication::orderBy('id', 'desc')->where('employee_id', Auth::guard('management')->user()->id)->get();

        return view('management.my_noc', $data);
    }

    public function noc_details($id)
    {
        $data['details'] = NocApplication::where('id', $id)->where('employee_id', Auth::guard('management')->user()->id)->firstOrFail();
        $data['employers'] = User::where('role', '!=', 'employee')->get();

        return view('management.noc_details', $data);
    }


    public function logout()
    {
        Auth::guard('management')->logout();
        return redirect()->route('management.login')->with('success', 'Logged out successfully');
    }
}
