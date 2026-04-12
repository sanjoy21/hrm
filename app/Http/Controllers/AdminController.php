<?php

namespace App\Http\Controllers;
use App\Services\GeocodingService;
use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Department;
use App\Models\Office;
use App\Models\LeaveType;
use App\Models\LeaveAttachment;
use App\Models\Notice;
use App\Models\Warning;
use App\Models\Project;
use App\Models\Leave;
use App\Models\Promotion;
use App\Models\Salary;
use App\Models\MonthlySalarySheet;
use App\Models\HourlyWorkUpdate;
use App\Models\NocType;
use App\Models\Noc;
use App\Models\NocApplication;
use App\Models\AppointmentLetter;
use App\Models\Resign;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use App\Models\ProjectComment;

class AdminController extends Controller
{

    public function login()
    {
        return view('admin.login');
    }

    public function authenticate(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        if (Auth::guard('admin')->attempt([
            'email' => $request->email,
            'password' => $request->password
        ])) {
            if (Auth::guard('admin')->user()->role != 'admin') {
                Auth::guard('admin')->logout();
                return redirect()->route('login')->with('error', 'Access denied ! Unauthorised user.');
            }
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->route('login')->with('error', 'Something went wrong');
        }
    }



    public function dashboard(Request $request)
{
    $user = Auth::guard('admin')->user();
    $today = \Carbon\Carbon::today()->toDateString();

    // Check if admin is on leave today
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
    $attendances = Attendance::where('employee_id', $user->id)
        ->get(['date', 'check_in', 'check_out', 'check_in_lat', 'check_in_long', 'check_in_address','check_out_lat','check_out_long','check_out_address']);

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
        ->select('employee_id', 'date', 'check_in_lat', 'check_in_long','check_in_address', 'check_in', 'check_out', 'check_out_lat', 'check_out_long','check_out_address')
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

    // $notice = Notice::orderBy('created_at', 'desc')->get();

    // Get unread notices only
    $notice = Notice::where('expire_date', '>=', $today)
        ->orderBy('created_at', 'desc')
        ->whereDoesntHave('readBy', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })
        ->get();

    $applications = Leave::where('status', 'Applied')->get();
    $birthday = User::where('status', 'active')->get();
    $offices = Office::all();
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

    $nocApplications = NocApplication::where('status', 'Applied')->get();

    return view('admin.dashboard', compact(
        'attendance',
        'notice',
        'applications',
        'birthday',
        'statusMessage',
        'calendarData',
        'employees',
        'attend',
        'deliverymen',
        'totalLeaves',
        'offices',
        'selectedOfficeId',
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
        'nocApplications',
    ));
}

//==================================================================
// Previous check-in and check-out methods without geocoding

    // public function checkIn(Request $request)
    // {
    //     $user = Auth::guard('admin')->user();
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
    //     $user = Auth::guard('admin')->user();
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
        $user = Auth::guard('admin')->user();
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
        $user = Auth::guard('admin')->user();
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
    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('login')->with('success', 'You have successfully logged out.');
    }

    public function register()
    {
        $user = new User();
        $user->name = 'admin';
        $user->email = 'admin@gmail.com';
        $user->password = Hash::make('123456');
        $user->dob = '1960-10-10';
        $user->mobile = '01712345678';
        $user->nid = '1234567891';
        $user->role = 'admin';
        $user->status = 'active';
        $user->address = '';
        $user->image = '';

        $user->save();

        return redirect()->back()->with(
            'success',
            'Admin added successfully.'
        );
    }

    public function profile()
    {
        $data['departments'] = Department::all();
        $data['offices'] = Office::all();
        $data['salaryStructure'] = Salary::where('employee_id', Auth::guard('admin')->user()->id)->first(); // To view salary structure
        return view('admin.profile', $data);
    }

    public function profile_update(Request $request)
    {
        $user = Auth::guard('admin')->user();

        $request->validate([
            'name' => 'nullable|string',
            'email' => 'nullable|email',
            'nid' => 'nullable',
            'blood_group' => 'nullable',
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

        if ($request->filled('account_no')) {
            $data['account_no'] = $request->account_no;
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

        return redirect()->route('admin.profile')->with('success', 'Profile updated successfully.');
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

        return view('admin.all_employee', $data);
    }

    public function add_employee()
    {
        $data['departments'] = Department::all();
        $data['offices'] = Office::all();
        return view('admin.add_employee', $data);
    }

    public function employee_store(Request $request)
    {
        $request->validate([

            'office' => 'required',
            'department' => 'required',
            'role' => 'required',
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'dob' => 'required',
            'gender' => 'required',
            'mobile' => 'required|unique:users,mobile',
            'nid' => 'required|unique:users,nid',
            'designation' => 'required',
            'emergency_contact' => 'required',
            'emergency_person' => 'required',
            'relation' => 'required',
            'joining_date' => 'required',

        ], [
            'email.unique' => 'Email already exists.',
            'mobile.unique' => 'Mobile number already exists.',
            'nid.unique' => 'NID already exists.',

        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->dob = $request->dob;
        $user->gender = $request->gender;
        $user->mobile = $request->mobile;
        $user->nid = $request->nid;
        $user->role = $request->role;
        $user->status = 'active';
        $user->joining_date = $request->joining_date;
        $user->emergency_contact = $request->emergency_contact;
        $user->emergency_person = $request->emergency_person;
        $user->relation = $request->relation;
        $user->department = $request->department;
        $user->office = $request->office;
        $user->designation = $request->designation;
        $user->joined_as = $request->designation;
        $user->starting_salary = $request->salary;

        $user->save();

        return redirect()->back()->with('success','Employee added successfully.');
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

    // Prepare calendar data
    // $data['calendarData'] = $data['attendances']->map(function ($item) {
    //     $checkInTime = \Carbon\Carbon::createFromFormat('h:i:s A', $item->check_in);
    //     $lateThreshold = \Carbon\Carbon::createFromTime(9, 20, 59);
    //     $isLate = $checkInTime->greaterThan($lateThreshold);

    //     return [
    //         'date' => $item->date,
    //         'title' => $isLate ? 'Late' : 'On Time',
    //         'color' => $isLate ? 'red' : 'green',
    //         'check_in' => $item->check_in,
    //         'check_in_lat' => $item->check_in_lat,
    //         'check_in_long' => $item->check_in_long,
    //         'check_out' => $item->check_out,
    //     ];
    // });

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

    $data['totalLeaves'] = Leave::where('employee_id', $id)
        ->where('status','Approved')
        ->whereYear('created_at', now()->year)
        ->sum('total_day');

    $data['warning'] = Warning::where('to_employee', $id)->count();

    $data['all_project'] = Project::where('employee',$id)->count();
    $data['completed'] = Project::where('employee',$id)->where('status','Completed')->count();
    $data['ongoing'] = Project::where('employee',$id)->where('status','Ongoing')->count();
    $data['pending'] = Project::where('employee',$id)->where('status','Pending')->count();
    $data['onTimeDelivery'] = Project::where('employee', $id)->whereColumn('deadline', '>=', 'submission_date')->whereNotNull('submission_date')->count();
    $data['late_Delivery'] = Project::where('employee', $id)->whereColumn('deadline', '<', 'submission_date')->whereNotNull('submission_date')->count();

        return view('admin.employee_profile', $data);
    }

    public function employee_profile_update(Request $request, $id)
    {
        $user = User::find($id);

        $request->validate([
            'status' => 'nullable',
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|unique:users,email',
            'nid' => 'nullable|unique:users,nid',
            'blood_group' => 'nullable|string|max:255',

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
        ], [
            'password.min' => 'Password must be at least 6 characters.',
            'email.unique' => 'Email already exist!',
            'nid.unique' => 'NID already exist!',
            'mobile.unique' => 'Mobile number already exist!',
            'mobile.digits' => 'Mobile number must be exactly 11 digits.',
        ]);

        $data = [];

        if ($request->filled('status')) {
            $data['status'] = $request->status;
        }

        if ($request->filled('zone')) {
            $data['zone'] = $request->zone;
        }

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

        if ($request->filled('account_no')) {
            $data['account_no'] = $request->account_no;
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

        return redirect()->route('employee_profile',$id)->with('success', 'Profile updated successfully.');
    }

    public function  employee_delete($id)
    {
        $data = User::findOrFail($id);
        $data->delete();

        return redirect()->back()->with('success', 'Employee deleted successfully.');
    }

    public function departments()
    {
        $data['employees'] = Department::withCount('users')->get();
        return view('admin.departments', $data);
    }

    public function departments_store(Request $request)
    {
        $request->validate([
            'department_name' => 'required',

        ]);

        $department = Department::where('department_name',$request->department_name)->get()->first();

        if(!$department)
        {
            $data = new Department();
            $data->department_name = $request->department_name;

            $data->save();
            return redirect()->back()->with('success', 'Department added successfully.');

        }

        else
        {
            return redirect()->back()->with('error','Department already exist!');
        }
    }

    public function edit_department($id)
    {
        $data['department'] = Department::findOrFail($id);
        return view('admin.edit_department', $data);
    }

    public function department_update(Request $request,$id)
    {
        $department = Department::findOrFail($id);

        $request->validate([
            'department_name' => 'nullable',
        ]);

        $data = [];

        if ($request->filled('department_name')) {
            $data['department_name'] = $request->department_name;
        }

        $department->update($data);

        return redirect()->route('departments')->with('success', 'Department updated successfully.');
    }

    public function department_delete($id)
    {
        $data = Department::findOrFail($id);
        $data->delete();

        return redirect()->back()->with('success', 'Department deleted successfully.');
    }

    public function leave_type()
    {
        $data['leave_types'] = LeaveType::all();
        return view('admin.leave_type', $data);
    }

    public function leave_type_store(Request $request)
    {
        $request->validate([
            'leave_name' => 'required',

        ]);

        $leave_type = LeaveType::where('leave_name',$request->leave_name)->get()->first();

        if(!$leave_type)
        {
            $data = new LeaveType();
            $data->leave_name = $request->leave_name;

            $data->save();
            return redirect()->back()->with('success', 'Leave type added successfully.');

        }

        else
        {
            return redirect()->back()->with('error','Leave type already exist!');
        }
    }

    public function leave_type_edit($id)
    {
        $data['leave_types'] = LeaveType::findOrFail($id);
        return view('admin.edit_leave_type', $data);
    }

    public function leave_type_update(Request $request,$id)
    {
        $leave = LeaveType::findOrFail($id);

        $request->validate([
            'leave_name' => 'nullable',
        ]);

        $data = [];

        if ($request->filled('leave_name')) {
            $data['leave_name'] = $request->leave_name;
        }

        $leave->update($data);

        return redirect()->route('leave_type')->with('success', 'Leave type updated successfully.');
    }

    public function leave_type_delete($id)
    {
        $data = LeaveType::findOrFail($id);
        $data->delete();

        return redirect()->back()->with('success', 'Leave type deleted successfully.');
    }

    public function notice_all()
    {
        $data['notices'] = Notice::orderBy('id','desc')->get();
        return view('admin.all_notice', $data);
    }

    public function notice($id)
    {
        $notice = Notice::findOrFail($id);
        $user = Auth::guard('admin')->user();

        // Mark the notice as read if not already read
        if (!$notice->isReadBy($user->id)) {
        $notice->readBy()->attach($user->id, ['read_at' => now()]);
        }
        return view('admin.notice', compact('notice'));
    }

    public function notice_edit($id)
    {
        $data['notice'] = Notice::findOrFail($id);
        return view('admin.edit_notice', $data);
    }

    public function notice_update(Request $request,$id)
    {
        $notice = Notice::findOrFail($id);

        $request->validate([
            'date' => 'nullable',
            'title' => 'nullable',
            'message' => 'nullable',
        ]);

        $data = [];

        if ($request->filled('date')) {
            $data['date'] = $request->date;
        }

        if ($request->filled('title')) {
            $data['title'] = $request->title;
        }

        if ($request->filled('message')) {
            $data['message'] = $request->message;
        }

        $notice->update($data);

        return redirect()->route('notice',$id)->with('success', 'Notice updated successfully.');
    }

    public function notice_delete($id)
    {
        $data = Notice::findOrFail($id);
        $data->delete();

        return redirect()->back()->with('success', 'Notice deleted successfully.');
    }

    public function notice_add()
    {
        return view('admin.add_notice');
    }

    public function notice_add_store(Request $request)
    {
        $request->validate([

            'title' => 'required',
            'message' => 'required',
            'date' => 'required',
            'expire_date' => 'required',

        ]);

        $data = new Notice();
        $data->title = $request->title;
        $data->message = $request->message;
        $data->date = $request->date;
        $data->expire_date = $request->expire_date;

        $data->save();

        return redirect()->back()->with('success','Notice added successfully.');
    }

    public function warning_all(Request $request)
    {
        $query = Warning::with('employee');

       if ($request->employee) {
            $query->orderBy('id','desc')->where('to_employee', $request->employee);
            $data['employees'] = $query->get();
        } else {
            $data['employees'] = Warning::orderBy('id','desc')->get();
        }

        $data['employee'] = User::whereIn('role', ['admin','management','employee'])->where('status', 'active')->get();

        return view('admin.all_warning', $data);
    }

    public function warning($id)
    {
        $data['warning'] = Warning::findOrFail($id);
        $data['employees'] = User::whereIn('role', ['admin','management','employee'])->where('status','active')->get();

        return view('admin.warning', $data);
    }

    public function warning_edit($id)
    {
        $data['warning'] = Warning::findOrFail($id);
        $data['employees'] = User::whereIn('role', ['admin','management','employee'])->where('status','active')->get();
        return view('admin.edit_warning', $data);
    }

    public function warning_update(Request $request,$id)
    {
        $warning = Warning::findOrFail($id);

        $request->validate([
            'employee' => 'nullable',
            'date' => 'nullable',
            'title' => 'nullable',
            'message' => 'nullable',

        ]);

        $data = [];

        if ($request->filled('employee')) {
            $data['to_employee'] = $request->employee;
        }

        if ($request->filled('date')) {
            $data['date'] = $request->date;
        }

        if ($request->filled('title')) {
            $data['title'] = $request->title;
        }

        if ($request->filled('message')) {
            $data['message'] = $request->message;
        }


        $warning->update($data);

        return redirect()->route('warning',$id)->with('success', 'Warning updated successfully.');
    }

    public function warning_delete($id)
    {
        $data = Warning::findOrFail($id);
        $data->delete();

        return redirect()->back()->with('success', 'Warning deleted successfully.');
    }

    public function warning_add()
    {
        $data['employees'] = User::whereIn('role', ['admin','management','employee'])->where('status','active')->get();
        return view('admin.add_warning', $data);
    }

    public function warning_add_store(Request $request)
    {
        $request->validate([

            'employee' => 'required',
            'date' => 'required',
            'title' => 'required',
            'message' => 'required',
        ]);

        $data = new Warning();
        $data->to_employee = $request->employee;
        $data->date = $request->date;
        $data->mark_as_read = 0;
        $data->title = $request->title;
        $data->message = $request->message;

        $data->save();

        return redirect()->back()->with('success','Warning send successfully.');
    }

    public function project_add()
    {
        $data['employees'] = User::where('role','employee')->get();
        $data['employers'] = User::whereIn('role', ['admin', 'management'])->get();
        return view('admin.add_project', $data);
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
        $data->submission_date = null;
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
            $query->orderBy('id','desc')->where('employee', $request->employee);
            $data['employees'] = $query->get();
        } else {
            $data['employees'] = Project::orderBy('id','desc')->get();
        }

        $data['employee'] = User::where('role', 'employee')->get();

        return view('admin.all_project', $data);
    }

    public function project_delete($id)
    {
        $data = Project::findOrFail($id);
        $data->delete();

        return redirect()->route('project_all')->with('success', 'Project deleted successfully.');
    }

    // public function project($id)
    // {
    //     $data['project'] = Project::findOrFail($id);
    //     $data['assigned'] = Project::count();
    //     $data['employees'] = User::where('role','employee')->get();
    //     $data['employers'] = User::where('role','!=','employee')->get();

    //     return view('admin.project', $data);
    // }

    public function project($id)
{
    $data['project'] = Project::with(['allComments.user', 'assignedEmployee', 'assignedEmployer'])->findOrFail($id);
    $data['assigned'] = Project::count();
    $data['employees'] = User::where('role', 'employee')->get();
    $data['employers'] = User::where('role', '!=', 'employee')->get();
    $data['comments'] = $data['project']->allComments;

    // Mark comments as read for admin
    ProjectComment::where('project_id', $id)
        ->where('user_role', 'employee')
        ->where('is_read', false)
        ->update(['is_read' => true]);

    return view('admin.project', $data);
}

// Add new method to handle admin comments
public function project_comment(Request $request, $id)
{
    $request->validate([
        'comment' => 'required|string|max:1000'
    ]);

    $project = Project::findOrFail($id);

    $comment = ProjectComment::create([
        'project_id' => $id,
        'user_id' => Auth::guard('admin')->user()->id,
        'user_role' => 'admin',
        'comment' => $request->comment,
        'is_read' => false
    ]);

    // // Also store in old comments column for backward compatibility
    // $oldComments = $project->comment;
    // $newCommentText = "Admin (" . Auth::guard('admin')->user()->name . "): " . $request->comment . " [" . now()->format('Y-m-d H:i:s') . "]\n";
    // $project->comment = $oldComments ? $oldComments . "\n" . $newCommentText : $newCommentText;
    // $project->save();

    return redirect()->back();
}

    public function project_edit($id)
    {
        $data['project'] = Project::findOrFail($id);
        $data['employees'] = User::where('role','employee')->where('status','active')->get();
        $data['employers'] = User::where('role','!=','employee')->where('status','active')->get();
        return view('admin.edit_project', $data);
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

        return redirect()->route('project',$id)->with('success', 'Project updated successfully.');
    }

    public function application_all(Request $request)
    {
        $query = Leave::with('employee');

       if ($request->employee) {
            $query->orderBy('id','desc')->where('employee_id', $request->employee);
            $data['applications'] = $query->get();
        } else {
            $data['applications'] = Leave::orderBy('id','desc')->get();
        }

        $data['employee'] = User::where('status', 'active')->whereIn('role', ['admin', 'management', 'employee'])->get();
        $data['leave_types'] = LeaveType::all();

        return view('admin.all_application', $data);
    }

    public function application($id)
    {
        $data['application'] = Leave::with('attachments')->findOrFail($id);
        $data['leave_types'] = LeaveType::all();
        $data['employees'] = User::whereIn('role',['admin','management','employee'])->get();
        $data['employers'] = User::where('role','admin')->get();

        return view('admin.application', $data);
    }

    public function application_status(Request $request, $id)
    {
    $request->validate([
        'status' => 'required|in:Approved,Rejected',
        'comment' => 'nullable|string|max:500'
    ]);

    $application = Leave::findOrFail($id);

    $application->approved_by = $request->approved_by;
    $application->status = $request->status;
    $application->comment = $request->comment;
    $application->save();

    $status_text = strtolower($request->status);

    return redirect()->back()->with('success', 'Application '.$status_text.' successfully!');
    }

    public function download_attachment($attachment_id)
    {
        $attachment = LeaveAttachment::findOrFail($attachment_id);
        $leave = $attachment->leave;

        // Check if the user has permission to download this attachment
        // if ($leave->employee_id != Auth::user()->id && Auth::user()->role == 'employee') {
        // return redirect()->back()->with('error', 'Unauthorized access.');
        // }

        if ($attachment->file_path && Storage::disk('public')->exists($attachment->file_path)) {
        return Storage::disk('public')->download($attachment->file_path, $attachment->file_name);
        }

        return redirect()->back()->with('error', 'File not found.');
    }

    // public function application_status(Request $request, $id)
    // {
    // $application = Leave::findOrFail($id);

    // $status = $request->input('status');

    // if($status == 'Approved')
    // {
    //     $updated_status = 'approved';
    // }

    // if($status == 'Rejected')
    // {
    //     $updated_status = 'rejected';
    // }

    // // Save status from button value
    // $application->approved_by = $request->approved_by;
    // $application->status = $request->status;
    // $application->save();

    // return redirect()->back()->with('success', 'Application '.$updated_status.' successfully!');
    // }

    public function manual_leave_approval()
    {
        $data['leave_types'] = LeaveType::all();
        $data['employees'] = User::whereIn('role',['admin','management','employee'])->get();
        $data['employers'] = User::where('role','admin')->get();

        return view('admin.manual_leave_approval', $data);
    }

    public function manual_leave_approval_store(Request $request)
    {
        $request->validate([

            'employee' => 'required',
            'leave_type' => 'required',
            'day_type' => 'required',
            'date' => 'required',
            'comment' => 'required',
        ]);

        $data = new Leave();
        $data->employee_id = $request->employee;
        $data->leave_type = $request->leave_type;
        $data->from_date = $request->date;
        $data->to_date = $request->date;
        if($request->day_type == 'Half Day') {
            $data->total_day = 0;
        }
        else{
            $data->total_day = 1;
        }
        $data->status = "Approved";
        $data->approved_by = $request->approved_by;
        $data->application = "Application submited earlier. Manually approved by admin.";
        $data->comment = $request->comment;

        $data->save();

        return redirect()->back()->with('success','Leave approved successfully.');
    }

    public function promotion()
    {
        $data['employees'] = User::where('status','active')->whereIn('role', ['admin', 'management', 'employee'])->get();
        $data['departments'] = Department::all();
        return view('admin.promotion', $data);
    }

    public function promotion_store(Request $request)
    {
        $request->validate([

            'employee' => 'required',
            'type' => 'required',
            'department' => 'required',
            'designation' => 'required',
            'total_salary' => 'required',
            'date' => 'required',
            'comment' => 'nullable',
        ]);

        $emp = User::where('id',$request->employee)->first();


            if($emp->id == $request->employee )
            {
            $name = $emp->name;
            }

            if($request->type == "Promotion" )
            {
            $type = "promoted";
            }
            else{
                $type = "demoted";
            }

            $emp->department = $request->department;
            $emp->designation = $request->designation;
            $emp->update();


        $data = new Promotion();
        $data->employee_id = $request->employee;
        $data->promotion_type = $request->type;
        $data->department = $request->department;
        $data->designation = $request->designation;
        $data->total_salary = $request->total_salary;
        $data->date = $request->date;

        if ($request->filled('comment')) {
            $data->comment = $request->comment;
        }

        $data->save();

        return redirect()->back()->with('success', $name ." ". $type . ' successfully as '. $request->designation);
    }


    // public function promotion_all(Request $request)
    // {

    //     $data['departments'] = Department::all();

    //     $query = Promotion::all();


    // if ($request->filled('department')) {
    //     $query->where('department', $request->department);
    // }


    // $records = $query->get();

    // $data['employees'] = $records;

    //     return view('admin.all_promotion', $data);
    // }

    public function promotion_all()
    {
        $data['promotions'] = Promotion::orderBy('id','desc')->get();
        $data['departments'] = Department::all();
        $data['employees'] = User::all();
        return view('admin.all_promotion', $data);
    }

    public function salary_structure()
    {
        $data['employees'] = User::where('status','active')->whereIn('role', ['admin', 'management', 'employee'])->get();
        return view('admin.salary_structure', $data);
    }

    public function salary_structure_store(Request $request)
    {
        $request->validate([

            'employee' => 'required',
            'basic' => 'required',
            'house_rent' => 'required',
            'convenience' => 'required',
            'medical' => 'required',
            'total' => 'required',
        ]);

        $employee = Salary::where('employee_id',$request->employee)->exists();
        if($employee)
        {
            return redirect()->back()->with('error','Salary structure for this employee already exists.');
        }

        $data = new Salary();
        $data->employee_id = $request->employee;
        $data->basic = $request->basic;
        $data->house_rent = $request->house_rent;
        $data->convenience = $request->convenience;
        $data->medical = $request->medical;
        $data->total = $request->total;

        $data->save();

        return redirect()->back()->with('success','Salary structure added successfully.');
    }

    public function salary_structure_view()
    {
        $data['salaries'] = Salary::all();
        $data['departments'] = Department::all();
        $data['employees'] = User::all();
        return view('admin.all_salary_structure', $data);
    }

    public function edit_salary_structure($id)
    {
        $data['salary'] = Salary::findOrFail($id);
        $data['employees'] = User::all();
        return view('admin.edit_salary_structure', $data);
    }

    public function salary_structure_update(Request $request,$id)
    {
        $salary = Salary::findOrFail($id);

        $request->validate([
            'basic' => 'nullable',
            'house_rent' => 'nullable',
            'convenience' => 'nullable',
            'medical' => 'nullable',
            'total' => 'nullable',
        ]);

        $data = [];

        if ($request->filled('basic')) {
            $data['basic'] = $request->basic;
        }

        if ($request->filled('house_rent')) {
            $data['house_rent'] = $request->house_rent;
        }

        if ($request->filled('convenience')) {
            $data['convenience'] = $request->convenience;
        }

        if ($request->filled('medical')) {
            $data['medical'] = $request->medical;
        }

        if ($request->filled('total')) {
            $data['total'] = $request->total;
        }

        $salary->update($data);

        return redirect()->back()->with('success', 'Salary structure updated successfully.');
    }

    public function salary_structure_delete($id)
    {
        $data = Salary::findOrFail($id);
        $data->delete();

        return redirect()->back()->with('success', 'Salary structure deleted successfully.');
    }

    public function salary_sheet_add()
    {
        $data['employees'] = User::where('status','active')->whereIn('role', ['admin', 'management', 'employee'])->get();
        return view('admin.add_salary_sheet', $data);
    }

    public function salary_sheet_store(Request $request)
    {
        $request->validate([

            'employee' => 'required',
            'month' => 'required',
            'year' => 'required',
            'salary' => 'nullable',
            'bonus' => 'nullable',
            'performance_bonus' => 'nullable',
            'other_add' => 'nullable',
            'advance' => 'nullable',
            'ait' => 'nullable',
            'revenue_stamp' => 'nullable',
            'late_attendance' => 'nullable',
            'other' => 'nullable',
            'total_paid' => 'required',
            'date_of_payment' => 'required',
            'comment' => 'nullable',
        ]);

        $data = new MonthlySalarySheet();
        $data->employee_id = $request->employee;
        $data->month = $request->month;
        $data->year = $request->year;
        $data->salary = $request->salary;
        $data->bonus = $request->bonus;
        $data->performance_bonus = $request->performance_bonus;
        $data->other_add = $request->other_add;
        $data->advance = $request->advance;
        $data->ait = $request->ait;
        $data->revenue_stamp = $request->revenue_stamp;
        $data->late_attendance = $request->late_attendance;
        $data->other = $request->other;
        $data->total_paid = $request->total_paid;
        $data->date_of_payment = $request->date_of_payment;
        $data->comment = $request->comment;

        $data->save();

        return redirect()->back()->with('success','Salary sheet added successfully.');
    }

    // public function salary_sheet_view(Request $request)
    // {
    //     $data['all'] = MonthlySalarySheet::orderBy('id','desc')->get();
    //     $data['employees'] = User::all();
    //     return view('admin.all_salary_sheet', $data);
    // }

    public function salary_sheet_view(Request $request)
    {
    $data['distinct_years'] = MonthlySalarySheet::distinct()
                                                ->pluck('year') // Get only the 'year' column values
                                                ->sortDesc();   // Sort the years descending (newest first)

    $query = MonthlySalarySheet::orderBy('id', 'desc');

    if ($request->filled('month')) {
        $query->where('month', $request->input('month'));
    }

    if ($request->filled('year')) {
        $query->where('year', $request->input('year'));
    }

    if ($request->filled('employee')) {
        $query->where('employee_id', $request->input('employee'));
    }

    $data['all'] = $query->get();

    $data['employees'] = User::whereIn('role', ['admin', 'management', 'employee'])->get();
    $data['selected_month'] = $request->input('month');
    $data['selected_year'] = $request->input('year');
    $data['selected_employee_id'] = $request->input('employee');

    return view('admin.all_salary_sheet', $data);
    }

    public function noc_type()
    {
        $data['noc_types'] = NocType::all();
        return view('admin.noc_type', $data);
    }

    public function noc_type_store(Request $request)
    {
        $request->validate([
            'noc_name' => 'required',

        ]);

        $noc_type = NocType::where('noc_name',$request->noc_name)->get()->first();

        if(!$noc_type)
        {
            $data = new NocType();
            $data->noc_name = $request->noc_name;

            $data->save();
            return redirect()->back()->with('success', 'NOC type added successfully.');

        }

        else
        {
            return redirect()->back()->with('error','NOC type already exist!');
        }
    }

    public function noc_type_edit($id)
    {
        $data['noc_types'] = NocType::findOrFail($id);
        return view('admin.edit_noc_type', $data);
    }

    public function noc_type_update(Request $request,$id)
    {
        $noc = NocType::findOrFail($id);

        $request->validate([
            'noc_name' => 'nullable',
        ]);

        $data = [];

        if ($request->filled('noc_name')) {
            $data['noc_name'] = $request->noc_name;
        }

        $noc->update($data);

        return redirect()->route('noc_type')->with('success', 'NOC type updated successfully.');
    }

    public function noc_type_delete($id)
    {
        $data = NocType::findOrFail($id);
        $data->delete();

        return redirect()->back()->with('success', 'NOC type deleted successfully.');
    }


    public function noc_add()
    {
        $data['employees'] = User::where('status','active')->whereIn('role', ['admin', 'management', 'employee'])->get();
        $data['noc_types'] = NocType::all();
        return view('admin.add_noc', $data);
    }

    public function noc_add_store(Request $request)
    {
        $request->validate([

            'employee' => 'required',
            'salutation' => 'required',
            'noc_type' => 'required',
            'passport' => 'nullable',
            'country' => 'nullable',
            'reason' => 'nullable',
        ]);

        $data = new Noc();

        if ($request->filled('from_date')) {
            $data['from_date'] = $request->from_date;
        }

        if ($request->filled('to_date')) {
            $data['to_date'] = $request->to_date;
        }


        if ($request->filled('country')) {
            $data['country'] = $request->country;
        }

        if ($request->filled('country')) {
            $data['country'] = $request->country;
        }

        if ($request->filled('reason')) {
            $data['reason'] = $request->reason;
        }

        if ($request->filled('passport')) {
            $data['passport'] = $request->passport;
        }

        $data->employee_id = $request->employee;
        $data->salutation = $request->salutation;
        $data->noc_type = $request->noc_type;
        $data->date = $request->date;

        $data->save();

        return redirect()->back()->with('success','NOC generated successfully.');
    }

    public function noc_all()
    {
        $data['nocs'] = Noc::orderBy('id','desc')->get();
        $data['employees'] = User::all();
        return view('admin.all_noc', $data);
    }

    public function noc($id)
    {
        $data['noc'] = Noc::findOrFail($id);
        $data['noc_types'] = NocType::all();
        $data['employees'] = User::all();

        return view('admin.noc', $data);
    }

    public function noc_delete($id)
    {
        $data = Noc::findOrFail($id);
        $data->delete();

        return redirect()->back()->with('success', 'NOC deleted successfully.');
    }

    public function noc_application_all(Request $request)
    {
        $query = NocApplication::with('employee');

       if ($request->employee) {
            $query->orderBy('id','desc')->where('employee_id', $request->employee);
            $data['noc_applications'] = $query->get();
        } else {
            $data['noc_applications'] = NocApplication::orderBy('id','desc')->get();
        }

        $data['employee'] = User::where('status', 'active')->whereIn('role', ['admin', 'management', 'employee'])->get();

        return view('admin.all_noc_application', $data);
    }

    public function noc_application($id)
    {
        $data['application'] = NocApplication::findOrFail($id);
        $data['employees'] = User::whereIn('role',['admin','management','employee'])->get();
        $data['employers'] = User::where('role','admin')->get();

        return view('admin.noc_application', $data);
    }

    public function noc_application_status(Request $request, $id)
    {
    $application = NocApplication::findOrFail($id);

    $status = $request->input('status');

    if($status == 'Approved')
    {
        $updated_status = 'approved';
    }

    if($status == 'Rejected')
    {
        $updated_status = 'rejected';
    }

    // Save status from button value
    $application->approved_by = $request->approved_by;
    $application->status = $request->status;
    $application->save();

    return redirect()->back()->with('success', 'Application '.$updated_status.' successfully!');
    }

    public function appointment_letter_add()
    {
        return view('admin.add_appointment_letter');
    }

    public function appointment_letter_add_store(Request $request)
    {
        $request->validate([

            'name' => 'required',
            'date' => 'required',
            'letter' => 'required',
        ]);

        $data = new AppointmentLetter();

        $data->name = $request->name;
        $data->date = $request->date;
        $data->letter = $request->letter;

        $data->save();

        return redirect()->back()->with('success','Appointment letter generated successfully.');
    }

    public function appointment_letter_all()
    {
        $data['letters'] = AppointmentLetter::orderBy('id','desc')->get();
        return view('admin.all_appointment_letter', $data);
    }

    public function appointment_letter($id)
    {
        $data['letter'] = AppointmentLetter::findOrFail($id);
        return view('admin.appointment_letter', $data);
    }

    // public function resign($id)
    // {
    //     $data['resign'] = Resign::findOrFail($id);
    //     return view('admin.resign', $data);
    // }

    public function resign_all()
    {
        $data['employees'] = User::all();
        $data['resigns'] = Resign::all();
        return view('admin.all_resign', $data);
    }

    public function resign_add()
    {
        $data['employees'] = User::where('status','active')->whereIn('role', ['admin', 'management', 'employee'])->get();
        return view('admin.add_resign', $data);
    }

    public function resign_add_store(Request $request)
    {
        $request->validate([

            'employee' => 'required',
            'resign_date' => 'required',
            'reason' => 'required',
        ]);

        $emp = User::where('id',$request->employee)->first();


            if($emp->id == $request->employee )
            {
            $name = $emp->name;
            }

            $emp->resigning_date = $request->resign_date;
            $emp->status = "inactive";

            $emp->update();


        $data = new Resign();
        $data->employee_id = $request->employee;
        $data->date = $request->resign_date;
        $data->reason = $request->reason;

        $data->save();

        return redirect()->back()->with('success', $name .' resigned successfully.');
    }

    public function resign_delete($id)
    {
        $data = Resign::findOrFail($id);

        $emp = User::where('id',$data->employee_id)->first();
        $emp->resigning_date = null;
        $emp->status = "active";

        $emp->update();

        $data->delete();

        return redirect()->back()->with('success', 'Resign deleted successfully.');
    }

    public function office()
    {
        $data['employees'] = Office::withCount('users')->get();
        return view('admin.office', $data);
    }

    public function office_store(Request $request)
    {
        $request->validate([
            'name' => 'required',

        ]);

        $office = Office::where('name',$request->name)->get()->first();

        if(!$office)
        {
            $data = new Office();
            $data->name = $request->name;

            $data->save();
            return redirect()->back()->with('success', 'Office added successfully.');

        }

        else
        {
            return redirect()->back()->with('error','Office already exist!');
        }
    }

    public function edit_office($id)
    {
        $data['office'] = Office::findOrFail($id);
        return view('admin.edit_office', $data);
    }

    public function office_update(Request $request,$id)
    {
        $office = Office::findOrFail($id);

        $request->validate([
            'name' => 'nullable',
        ]);

        $data = [];

        if ($request->filled('name')) {
            $data['name'] = $request->name;
        }

        $office->update($data);

        return redirect()->route('office')->with('success', 'Office updated successfully.');
    }

    public function office_delete($id)
    {
        $data = Office::findOrFail($id);
        $data->delete();

        return redirect()->back()->with('success', 'Office deleted successfully.');
    }


    public function attendance_report(Request $request)
{
    // Get distinct years from attendance records
    $data['distinct_years'] = Attendance::selectRaw('YEAR(date) as year')
        ->distinct()
        ->orderBy('year', 'desc')
        ->pluck('year');

    // Start query with relationships
    $query = Attendance::with('employee')->orderBy('date', 'desc');

    // Filter by month
    if ($request->filled('month')) {
        $query->whereMonth('date', $request->month);
    }

    // Filter by year
    if ($request->filled('year')) {
        $query->whereYear('date', $request->input('year'));
    }

    // Filter by employee
    if ($request->filled('employee')) {
        $query->where('employee_id', $request->input('employee'));
    }

    $data['all'] = $query->get();
    $data['employees'] = User::whereIn('role',['admin','management','employee'])->orderBy('name')->get();
    $data['selected_month'] = $request->input('month');
    $data['selected_year'] = $request->input('year');
    $data['selected_employee_id'] = $request->input('employee');

    return view('admin.attendance_report', $data);
}

    public function attendance(Request $request)
    {
        // Get distinct years from attendance records
    $data['distinct_years'] = Attendance::selectRaw('YEAR(date) as year')
        ->distinct()
        ->orderBy('year', 'desc')
        ->pluck('year');

    // Start query with relationships
    $query = Attendance::with('employee')->orderBy('date', 'desc');

    // Filter by month
    if ($request->filled('month')) {
        $query->whereMonth('date', $request->month);
    }

    // Filter by year
    if ($request->filled('year')) {
        $query->whereYear('date', $request->input('year'));
    }

    // Filter by employee
    if ($request->filled('employee')) {
        $query->where('employee_id', $request->input('employee'));
    }

        $data['all'] = $query->get();
        $data['attendance'] = Attendance::orderBy('date','desc')->get();
        $data['employees'] = User::whereIn('role',['admin','management','employee'])->where('status','active')->orderBy('name')->get();


        $data['selected_month'] = $request->input('month');
        $data['selected_year'] = $request->input('year');
        $data['selected_employee_id'] = $request->input('employee');
        return view('admin.attendance', $data);
    }

    public function apply_for_noc()
    {
        return view('admin.apply_for_noc');
    }

    public function apply_for_noc_store(Request $request)
    {
        $request->validate([

            'application' => 'required',
        ]);

        $data = new NocApplication;
        $data->employee_id = $request->employee_id;
        $data->application = $request->application;
        $data->status = 'Applied';
        $data->approved_by = null;

        $data->save();

        return redirect()->route('my_noc_list')->with('success', 'NOC application submitted successfully.');
    }

    public function my_noc_list()
    {
        $data['my_nocs'] = NocApplication::orderBy('id', 'desc')->where('employee_id', Auth::guard('admin')->user()->id)->get();

        return view('admin.my_noc', $data);
    }

    public function my_noc_details($id)
    {
        $data['details'] = NocApplication::findOrFail($id);
        $data['employees'] = User::whereIn('role',['admin','management','employee'])->get();
        $data['employers'] = User::where('role','admin')->get();

        return view('admin.my_noc_details', $data);
    }

    public function leave_application()
    {
        $data['leave_types'] = LeaveType::all();

        return view('admin.leave_application', $data);
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

        return redirect()->route('leave_all')->with('success', 'Application submitted successfully.');
    }

    public function leave_all()
    {
        $data['my_leaves'] = Leave::orderBy('id', 'desc')->where('employee_id', Auth::guard('admin')->user()->id)->get();
        $data['leave_types'] = LeaveType::all();

        return view('admin.my_leave', $data);
    }

    public function leave_details($id)
    {
        $data['details'] = Leave::findOrFail($id);
        $data['leave_types'] = LeaveType::all();
        $data['employers'] = User::where('role', '!=', 'employee')->get();

        return view('admin.leave_details', $data);
    }



   public function initial_salary_sheet(Request $request)
{
    // Get distinct years from attendances table
    $data['distinct_years'] = Attendance::selectRaw('YEAR(date) as year')
        ->distinct()
        ->pluck('year')
        ->sortDesc();

    // Get all employees
    $data['employees'] = User::whereIn('role', ['admin', 'management', 'employee'])->where('status', 'active')->orderBy('name')->get();

    // Get filter values
    $selected_month = $request->input('month');
    $selected_year = $request->input('year');
    $selected_employee_id = $request->input('employee');

    $data['selected_month'] = $selected_month;
    $data['selected_year'] = $selected_year;
    $data['selected_employee_id'] = $selected_employee_id;

    // Initialize empty collection
    $processed_salaries = collect();

    // Only process if month and year are selected
    if ($selected_month && $selected_year) {
        // Check if there are any attendances for the selected month and year
        $month_number = date('n', strtotime($selected_month . ' 1 ' . $selected_year));
        $start_date = $selected_year . '-' . str_pad($month_number, 2, '0', STR_PAD_LEFT) . '-01';
        $end_date = date('Y-m-t', strtotime($start_date));

        $has_attendance_data = Attendance::whereBetween('date', [$start_date, $end_date])->exists();

        // Only proceed if there's attendance data
        if ($has_attendance_data) {
            // Get all salaries
            $salaries = Salary::all();

            // If employee filter is applied, filter salaries
            if ($selected_employee_id) {
                $salaries = $salaries->where('employee_id', $selected_employee_id);
            }

            // Process each salary record to calculate late attendance deductions
            foreach ($salaries as $salary) {
                // Count late attendances for the employee in the selected month and year
                $late_days = $this->countLateAttendances(
                    $salary->employee_id,
                    $selected_month,
                    $selected_year
                );

                // Calculate deduction based on late days
                // If 3 late days = 1 day salary deduction
                $deduction_days = floor($late_days / 3);

                // Calculate per day salary (assuming 30 days month)
                $per_day_salary = $salary->total / 30;

                // Calculate late deduction amount (days to deduct * per day salary)
                // Use intval() or floor() to ensure integer value
                $late_deduction = intval($deduction_days * $per_day_salary);

                // Store late attendance data in the salary object for blade view
                $salary->late_days = $late_days;
                $salary->deduction_days = $deduction_days;
                $salary->late_deduction = $late_deduction; // Now integer

                // Calculate total paid after all deductions
                $revenue_stamp = 10; // Fixed revenue stamp
                $total_deductions = ($salary->late_deduction ?? 0) + $revenue_stamp + ($salary->ait ?? 0) + ($salary->advance ?? 0) + ($salary->other ?? 0);
                $total_additions = ($salary->bonus ?? 0) + ($salary->performance_bonus ?? 0) + ($salary->other_add ?? 0);

                $salary->calculated_total_paid = round($salary->total + $total_additions - $total_deductions, 2);

                // Add month and year for display
                $salary->display_month = $selected_month;
                $salary->display_year = $selected_year;

                $processed_salaries->push($salary);
            }
        }
    }

    $data['all'] = $processed_salaries;

    return view('admin.initial_salary_sheet', $data);
}

/**
 * Count late attendances for an employee in a specific month and year
 * Month and year are extracted from the date column in attendances table
 */
private function countLateAttendances($employee_id, $month, $year)
{
    // Convert month name to month number (e.g., "January" to 1)
    $month_number = date('n', strtotime($month . ' 1 ' . $year));

    // Create date range for the entire month
    $start_date = $year . '-' . str_pad($month_number, 2, '0', STR_PAD_LEFT) . '-01';
    $end_date = date('Y-m-t', strtotime($start_date));

    // Define late cutoff time (09:20:59 AM)
    // Convert to 24-hour format for proper comparison
    $late_cutoff = '09:20:59';

    // Get all attendances for this employee in the date range
    $attendances = Attendance::where('employee_id', $employee_id)
        ->whereBetween('date', [$start_date, $end_date])
        ->get();

    $late_count = 0;

    foreach ($attendances as $attendance) {
        // Convert check_in to 24-hour format for accurate comparison
        $check_in = date('H:i:s', strtotime($attendance->check_in));

        // Compare times
        if ($check_in > $late_cutoff) {
            $late_count++;
        }
    }

    return $late_count;
}

    public function uploadExcel(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|mimes:xlsx,xls',
        ]);

        $path = $request->file('excel_file')->getRealPath();
        $data = Excel::toArray([], $request->file('excel_file'));

        if (empty($data) || count($data[0]) == 0) {
            return back()->with('success', 'Excel file is empty.');
        }

        $rows = $data[0]; // Get the first sheet
        $header = array_map('trim', $rows[0]); // First row is the header

        // Mapping Excel headers to DB columns
        $columnMapping = [
            'Month' => 'month',
            'Year' => 'year',
            'Employee ID' => 'employee_id',
            'Salary' => 'salary',
            'Bonus' => 'bonus',
            'Performance Bonus' => 'performance_bonus',
            'Other Add' => 'other_add',
            'Advance' => 'advance',
            'AIT' => 'ait',
            'Revenue Stamp' => 'revenue_stamp',
            'Late Deduction' => 'late_attendance',
            'Other Deduction' => 'other',
            'Total Paid' => 'total_paid',
            'Date of Payment' => 'date_of_payment',
            'Comment' => 'comment',

        ];

        unset($rows[0]); // Remove the header row

        foreach ($rows as $row) {
    $row = array_combine($header, $row);

    $insertData = [];

    foreach ($columnMapping as $excelColumn => $dbColumn) {
        $value = $row[$excelColumn] ?? null;

        // Convert Excel serial date to MySQL date format for date_of_payment
        if ($excelColumn === 'Date of Payment' && is_numeric($value))
        {
            $value = $this->excelSerialDateToMySQLDate($value);
        }

        $insertData[$dbColumn] = $value;
    }

    MonthlySalarySheet::create($insertData);
}
    return back()->with('success', 'Excel file imported successfully.');
    }

    /**
    * Convert Excel serial date to MySQL date format (Y-m-d)
    *
    * @param int $excelDate
    * @return string
    */
    private function excelSerialDateToMySQLDate($excelDate)
    {
    // Unix epoch (1970-01-01) is 25569 in Excel
    // Excel date 1 = 1900-01-01
    $unixTime = ($excelDate - 25569) * 86400;
    return gmdate('Y-m-d', $unixTime);
    }

}
