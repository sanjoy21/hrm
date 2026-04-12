<?php

namespace App\Http\Controllers;
use App\Services\GeocodingService;
use App\Models\Attendance;
use App\Models\Leave;
use App\Models\LeaveType;
use App\Models\LeaveAttachment;
use App\Models\Project;
use App\Models\Office;
use App\Models\Warning;
use App\Models\Notice;
use App\Models\NocApplication;
use App\Models\User;
use App\Models\HourlyWorkUpdate;
use App\Models\Salary;
use App\Models\Promotion;
use App\Models\Resign;
use App\Models\Department;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\ProjectComment;

class EmployeeController extends Controller
{

    public function login()
    {
        return view('employee.login');
    }

    public function authenticate(Request $request)
    {

        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            if ($user->role != 'employee') {
                Auth::logout();

                return redirect()->route('employee.login')->with('error', 'Unauthorized User. Access Denied.');
            }

            if ($user->status != 'active') {
                Auth::logout();

                return redirect()->route('employee.login')->with('error', 'Your account is inactive. Please contact support.');
            }

            return redirect()->route('employee.dashboard');

        } else {
            return redirect()->route('employee.login')->with('error', 'Invalid credentials. Please try again.');
        }
    }


    public function dashboard()
{
    $user = Auth::user();
    $today = \Carbon\Carbon::today()->toDateString();

    // Check if employee is on leave today
    $isOnLeaveToday = Leave::where('employee_id', $user->id)
        ->where('status', 'Approved')->where('total_day', '>', 0)
        ->whereDate('from_date', '<=', $today)
        ->whereDate('to_date', '>=', $today)
        ->exists();

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
                'title' => 'On Leave',
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

    $warning = Warning::where('to_employee', $user->id)->count();
    $new_warnings = Warning::where('to_employee', $user->id)->where('mark_as_read',0)->orderBy('created_at', 'desc')->get();

    // $notice = Notice::orderBy('created_at', 'desc')
    //                     ->get();

    // Get unread notices only
    $notice = Notice::where('expire_date', '>=', $today)
        ->orderBy('created_at', 'desc')
        ->whereDoesntHave('readBy', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })
        ->get();

    $projects = Project::where('employee',$user->id)->where('status','Assigned')->get();
    $totalLeaves = Leave::where('employee_id', $user->id)
        ->where('status','Approved')
        ->whereYear('created_at', now()->year)
        ->sum('total_day');

    $employees = User::where('status','active')->get();


    $lateThresholdTime = Carbon::createFromTimeString('09:20:59');

    // Get deliverymen (map markers) with office filtering
    $deliverymenQuery = Attendance::with('employee:id,name,image,office')
        ->select('employee_id', 'date', 'check_in_lat', 'check_in_long', 'check_in', 'check_out', 'check_out_lat', 'check_out_long')
        ->whereDate('date', $today)
        ->whereNotNull('check_in_lat')
        ->where('employee_id', Auth::user()->id);


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

    return view('employee.dashboard', compact(
        'attendance',
        'statusMessage',
        'calendarData',
        'warning',
        'new_warnings',
        'notice',
        'totalLeaves',
        'employees',
        'projects',
        'deliverymen',
        'isOnLeaveToday' // Added this variable
    ));
}

//==================================================================
// Updated check-in and check-out methods with geocoding

    protected $geocodingService;

    public function __construct(GeocodingService $geocodingService)
    {
        $this->geocodingService = $geocodingService;
    }

    public function checkIn(Request $request)
    {
        $user = Auth::user();
        $office = Auth::user()->office;
        $today = Carbon::today()->toDateString();

        // Check if employee is on leave today
        $isOnLeaveToday = Leave::where('employee_id', $user->id)
            ->where('status', 'Approved')->where('total_day', '>', 0)
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
        $user = Auth::user();
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

//======================== Sanjoy Dey ==============================

//==================================================================
// Previous check-in and check-out methods without geocoding

    // public function checkIn(Request $request)
    // {

    //     $user = Auth::user();
    //     $office = Auth::user()->office;
    //     $today = \Carbon\Carbon::today()->toDateString();

    //     // Check if employee is on leave today
    //     $isOnLeaveToday = Leave::where('employee_id', $user->id)
    //     ->where('status', 'Approved')
    //     ->whereDate('from_date', '<=', $today)
    //     ->whereDate('to_date', '>=', $today)
    //     ->exists();

    //     if ($isOnLeaveToday) {
    //     return response()->json([
    //         'message' => 'You cannot check in as you are on leave today.',
    //         'is_on_leave' => true
    //     ], 400);
    //     }

    //     // Prevent multiple check-ins in a single day
    //     $attendance = Attendance::where('employee_id', $user->id)
    //     ->where('date', $today)
    //     ->first();

    //     if ($attendance) {
    //     return response()->json(['message' => 'Already checked in today'], 400);
    //     }

    //     $currentTime = \Carbon\Carbon::now();
    //     $lateThreshold = \Carbon\Carbon::createFromTime(9, 20, 59); // 09:20 AM

    //     $statusMessage = $currentTime->greaterThan($lateThreshold)
    //     ? 'You are late today!'
    //     : 'You are on time today!';

    //     Attendance::create([
    //     'employee_id' => $user->id,
    //     'office' => $office,
    //     'date' => $today,
    //     'check_in' => $currentTime->format('h:i:s A'),
    //     'check_in_lat' => $request->latitude,
    //     'check_in_long' => $request->longitude,
    //     ]);

    //     return response()->json([
    //     'message' => 'Check In Successful',
    //     'status' => $statusMessage,
    //     ]);
    // }

    // public function checkOut(Request $request)
    // {
    //     $user = Auth::user();
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

    public function profile()
    {
        // $data['employee'] = User::where('id',Auth::user()->id);
        $data['promotion'] = Promotion::where('employee_id', Auth::user()->id)->orderBy('id','desc')->get();
        $data['resigns'] = Resign::where('employee_id', Auth::user()->id)->get();
        $data['departments'] = Department::all();

        $data['assigned'] = Project::where('employee', Auth::user()->id)->count();
        $data['ongoing'] = Project::where('employee', Auth::user()->id)->where('status', 'Ongoing')->count();
        $data['pending'] = Project::where('employee', Auth::user()->id)->where('status', 'Pending')->count();
        $data['completed'] = Project::where('employee', Auth::user()->id)->where('status', 'Completed')->count();
        $data['onTimeDelivery'] = Project::where('employee', Auth::user()->id)->whereColumn('deadline', '>=', 'submission_date')->whereNotNull('submission_date')->count();
        $data['late_Delivery'] = Project::where('employee', Auth::user()->id)->whereColumn('deadline', '<', 'submission_date')->whereNotNull('submission_date')->count();

        $data['departments'] = Department::all();
        $data['offices'] = Office::all();

        $data['salaryStructure'] = Salary::where('employee_id', Auth::user()->id)->first(); // To view salary structure
        return view('employee.profile', $data);
    }

    public function profile_update(Request $request)
    {
        $user = User::find(Auth::user()->id);

        $request->validate([
            'name' => 'nullable|string|max:255',
            // 'email' => 'nullable|email|unique:users,email',

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
            'email.unique' => 'Email already exist!',
            'nid.unique' => 'NID already exist!',
            'mobile.unique' => 'Mobile number already exist!',
            'mobile.digits' => 'Mobile number must be exactly 11 digits.',
        ]);

        $data = [];


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

        return redirect()->route('employee.profile')->with('success', 'Profile updated successfully.');
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->route('employee.login')->with('success', 'You have successfully logged out.');
    }

    public function application()
    {
         return view('employee.application');
    }

    public function application_store(Request $request)
    {
    $request->validate([
        'employee_id' => 'required',
        'application' => 'required',
        'attachments.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx,txt,xls,xlsx|max:10240',
        'attachments' => 'max:5'
    ]);

    DB::beginTransaction();
    $today = \Carbon\Carbon::today()->toDateString();

    try {
        $data = new Leave;
        $data->employee_id = $request->employee_id;
        $data->leave_type = 6; //  6 is the ID for "General Application"
        $data->from_date = $today;
        $data->to_date = $today;
        $data->total_day = 0;
        $data->approved_by = null;
        $data->status = 'Applied';
        $data->application = $request->application;
        $data->save();

        // Handle multiple file uploads
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $originalName = $file->getClientOriginalName();
                $fileName = time() . '_' . uniqid() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $originalName);
                $filePath = $file->storeAs('leave_attachments/' . $data->id, $fileName, 'public');

                LeaveAttachment::create([
                    'leave_id' => $data->id,
                    'file_name' => $originalName,
                    'file_path' => $filePath,
                    'file_type' => $file->getMimeType(),
                    'file_size' => $file->getSize()
                ]);
            }
        }

        DB::commit();

        $attachmentCount = $request->hasFile('attachments') ? count($request->file('attachments')) : 0;
        return redirect()->route('employee.leave_all')->with('success', 'Application submitted successfully with ' . $attachmentCount . ' attachment(s).');

    } catch (\Exception $e) {
        DB::rollback();
        return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage())->withInput();
    }
    }


    public function leave_application()
    {
        $data['leave_types'] = LeaveType::where('leave_name', '!=', 'General Application')->get();

        return view('employee.leave_application', $data);
    }

    // public function leave_application_store(Request $request)
    // {
    //     $request->validate([

    //         'employee_id' => 'required',
    //         'leave_type' => 'required',
    //         'day_type' => 'required',
    //         'from_date' => 'required',
    //         'to_date' => 'required',
    //         'total_day' => 'required',
    //         'application' => 'required',
    //     ]);


    //     $data = new Leave;
    //     $data->employee_id = $request->employee_id;
    //     $data->leave_type = $request->leave_type;
    //     $data->from_date = $request->from_date;
    //     $data->to_date = $request->to_date;
    //     if($request->day_type == 'Half Day') {
    //         $data->total_day = 0;
    //     }
    //     else{
    //         $data->total_day = $request->total_day;
    //     }
    //     $data->approved_by = null;
    //     $data->status = 'Applied';
    //     $data->application = $request->application;

    //     $data->save();

    //     return redirect()->route('employee.leave_all')->with('success', 'Application submitted successfully.');
    // }

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
        'attachments.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx,txt,xls,xlsx|max:10240',
        'attachments' => 'max:5'
    ]);

    DB::beginTransaction();

    try {
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

        // Handle multiple file uploads
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $originalName = $file->getClientOriginalName();
                $fileName = time() . '_' . uniqid() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $originalName);
                $filePath = $file->storeAs('leave_attachments/' . $data->id, $fileName, 'public');

                LeaveAttachment::create([
                    'leave_id' => $data->id,
                    'file_name' => $originalName,
                    'file_path' => $filePath,
                    'file_type' => $file->getMimeType(),
                    'file_size' => $file->getSize()
                ]);
            }
        }

        DB::commit();

        $attachmentCount = $request->hasFile('attachments') ? count($request->file('attachments')) : 0;
        return redirect()->route('employee.leave_all')->with('success', 'Application submitted successfully with ' . $attachmentCount . ' attachment(s).');

    } catch (\Exception $e) {
        DB::rollback();
        return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage())->withInput();
    }
    }


    public function leave_all()
    {
        $data['my_leaves'] = Leave::orderBy('id', 'desc')->where('employee_id', Auth::user()->id)->get();
        $data['leave_types'] = LeaveType::all();

        return view('employee.my_leave', $data);
    }

    public function leave_details($id)
    {
        $data['details'] = Leave::with('attachments')->findOrFail($id);
        $data['leave_types'] = LeaveType::all();
        $data['employers'] = User::where('role', '!=', 'employee')->get();

        return view('employee.leave_details', $data);
    }

    public function download_attachment($attachment_id)
    {
        $attachment = LeaveAttachment::findOrFail($attachment_id);
        $leave = $attachment->leave;

        // Check if the user has permission to download this attachment
        if ($leave->employee_id != Auth::user()->id && Auth::user()->role == 'employee') {
        return redirect()->back()->with('error', 'Unauthorized access.');
        }

        if ($attachment->file_path && Storage::disk('public')->exists($attachment->file_path)) {
        return Storage::disk('public')->download($attachment->file_path, $attachment->file_name);
        }

        return redirect()->back()->with('error', 'File not found.');
    }

    // public function delete_attachment($attachment_id)
    // {
    //     $attachment = LeaveAttachment::findOrFail($attachment_id);
    //     $leave = $attachment->leave;

    //     // Check if the user has permission to delete this attachment
    //     if ($leave->employee_id != Auth::user()->id) {
    //     return response()->json(['error' => 'Unauthorized access.'], 403);
    //     }

    //     // Delete file from storage
    //     if ($attachment->file_path && Storage::disk('public')->exists($attachment->file_path)) {
    //     Storage::disk('public')->delete($attachment->file_path);
    //     }

    //     $attachment->delete();

    //     return response()->json(['success' => 'Attachment deleted successfully.']);
    // }

    public function noc_application()
    {
        return view('employee.noc_application');
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

        return redirect()->route('employee.noc_all')->with('success', 'NOC Application submitted successfully.');
    }

    public function noc_all()
    {
        $data['my_nocs'] = NocApplication::orderBy('id', 'desc')->where('employee_id', Auth::user()->id)->get();

        return view('employee.my_noc', $data);
    }

    public function noc_details($id)
    {
        $data['details'] = NocApplication::where('id', $id)->where('employee_id', Auth::user()->id)->firstOrFail();
        $data['employers'] = User::where('role', '!=', 'employee')->get();

        return view('employee.noc_details', $data);
    }

    public function project_all()
    {
        $data['projects'] = Project::orderBy('id', 'desc')->where('employee', Auth::user()->id)->get();
        $data['employers'] = User::where('role', '!=', 'employee')->where('status', 'active')->get();

        return view('employee.all_project', $data);
    }

    // public function project($id)
    // {
    //     $data['project'] = Project::where('id', $id)->where('employee', Auth::user()->id)->firstOrFail();
    //     $data['assigned'] = Project::where('employee', Auth::user()->id)->count();
    //     $data['ongoing'] = Project::where('employee', Auth::user()->id)->where('status', 'Ongoing')->count();
    //     $data['pending'] = Project::where('employee', Auth::user()->id)->where('status', 'Pending')->count();
    //     $data['completed'] = Project::where('employee', Auth::user()->id)->where('status', 'Completed')->count();
    //     $data['onTimeDelivery'] = Project::where('employee', Auth::user()->id)->whereColumn('deadline', '>=', 'submission_date')->whereNotNull('submission_date')->count();
    //     $data['late_Delivery'] = Project::where('employee', Auth::user()->id)->whereColumn('deadline', '<', 'submission_date')->whereNotNull('submission_date')->count();
    //     $data['emp'] = User::where('id', Auth::user()->id)->first();
    //     $data['employers'] = User::where('role', '!=', 'employee')->get();

    //     return view('employee.project', $data);
    // }

    // public function project_update(Request $request, $id)
    // {
    //     $data = Project::where('id', $id)->where('employee', Auth::user()->id)->firstOrFail();

    //     $request->validate([

    //         'status' => 'nullable',
    //         'progress' => 'nullable',
    //     ]);

    //     if ($request->filled('status')) {
    //         if ($request->status == 'Completed') {
    //             $data->progress = 100;
    //             $data->status = $request->status;
    //             $data->submission_date = Carbon::now()->toDateString();
    //         } else {
    //             $data->status = $request->status;
    //         }

    //     }

    //     if ($request->filled('progress')) {
    //         $data->progress = $request->progress;
    //     }

    //     if ($request->filled('comment')) {
    //         $data->comment = $request->comment;
    //     }

    //     $data->update();

    //     return redirect()->back()->with('success', 'Status updated sucessfully.');
    // }

    public function project($id)
{
    $data['project'] = Project::with(['allComments.user', 'assignedEmployer'])
        ->where('id', $id)
        ->where('employee', Auth::user()->id)
        ->firstOrFail();

    $data['assigned'] = Project::where('employee', Auth::user()->id)->count();
    $data['ongoing'] = Project::where('employee', Auth::user()->id)->where('status', 'Ongoing')->count();
    $data['pending'] = Project::where('employee', Auth::user()->id)->where('status', 'Pending')->count();
    $data['completed'] = Project::where('employee', Auth::user()->id)->where('status', 'Completed')->count();
    $data['onTimeDelivery'] = Project::where('employee', Auth::user()->id)->whereColumn('deadline', '>=', 'submission_date')->whereNotNull('submission_date')->count();
    $data['late_Delivery'] = Project::where('employee', Auth::user()->id)->whereColumn('deadline', '<', 'submission_date')->whereNotNull('submission_date')->count();
    $data['emp'] = User::where('id', Auth::user()->id)->first();
    $data['employers'] = User::where('role', '!=', 'employee')->get();
    $data['comments'] = $data['project']->allComments;

    // Mark comments as read for employee
    ProjectComment::where('project_id', $id)
        ->where('user_role', 'admin')
        ->where('is_read', false)
        ->update(['is_read' => true]);

    return view('employee.project', $data);
}

// Update your existing project_update method:
public function project_update(Request $request, $id)
{
    $data = Project::where('id', $id)->where('employee', Auth::user()->id)->firstOrFail();

    $request->validate([
        'status' => 'nullable',
        'progress' => 'nullable',
        'comment' => 'nullable|string|max:1000'
    ]);

    if ($request->filled('status')) {
        if ($request->status == 'Completed') {
            $data->progress = 100;
            $data->status = $request->status;
            $data->submission_date = Carbon::now()->toDateString();
        } else {
            $data->status = $request->status;
        }
    }

    if ($request->filled('progress')) {
        $data->progress = $request->progress;
    }

    // Handle comment separately in new table
    if ($request->filled('comment')) {
        // Save to new comments table
        ProjectComment::create([
            'project_id' => $id,
            'user_id' => Auth::id(),
            'user_role' => 'employee',
            'comment' => $request->comment,
            'is_read' => false
        ]);

        // Also save to old comments column for backward compatibility
        $oldComments = $data->comment;
        $newCommentText = "Employee (" . Auth::user()->name . "): " . $request->comment . " [" . now()->format('Y-m-d H:i:s') . "]\n";
        $data->comment = $oldComments ? $oldComments . "\n" . $newCommentText : $newCommentText;
    }

    $data->update();

    return redirect()->back()->with('success', 'Status updated successfully.');
}

// Add new method for employee comments
public function project_comment(Request $request, $id)
{
    $request->validate([
        'comment' => 'required|string|max:1000'
    ]);

    $project = Project::where('id', $id)->where('employee', Auth::user()->id)->firstOrFail();

    ProjectComment::create([
        'project_id' => $id,
        'user_id' => Auth::id(),
        'user_role' => 'employee',
        'comment' => $request->comment,
        'is_read' => false
    ]);

    // // Also store in old comments column
    // $oldComments = $project->comment;
    // $newCommentText = "Employee (" . Auth::user()->name . "): " . $request->comment . " [" . now()->format('Y-m-d H:i:s') . "]\n";
    // $project->comment = $oldComments ? $oldComments . "\n" . $newCommentText : $newCommentText;
    // $project->save();

    return redirect()->back();
}

    public function hourly_work_update()
    {
        return view('employee.hourly_work_update');
    }

    public function hourly_work_update_store(Request $request)
    {
        // 1. Validation
        $request->validate([
            // Since the form sends hidden fields for employee_id and date,
            // you should still validate them to ensure they are present and in the correct format.
            'employee_id' => 'required|numeric', // Ensures an employee ID is sent
            'date' => 'required|date',         // Ensures a valid date is sent
            'time' => 'required|in:9_10,10_11,11_12,12_1,1_2,2_3,3_4,4_5', // Validates time slot
            'work_list' => 'required|string', // Basic check for the work list
        ]);

        // Define the variables for clarity and security (only use the authenticated user's ID)
        $employeeId = Auth::user()->id;
        $date = $request->date;
        $timeKey = $request->time;
        $workList = $request->work_list;

        // 2. Dynamic Field Mapping
        // Map the form 'time' value (e.g., '9_10') to the database column name (e.g., 't9_10')
        $timeToFieldMap = [
            '9_10'  => 't9_10',
            '10_11' => 't10_11',
            '11_12' => 't11_12',
            '12_1'  => 't12_1',
            '1_2'   => 't1_2',
            '2_3'   => 't2_3',
            '3_4'   => 't3_4',
            '4_5'   => 't4_5',
        ];

        // Get the column name to update, or null if the time key is invalid
        $fieldToUpdate = $timeToFieldMap[$timeKey] ?? null;

        // Security check: Only proceed if a valid column was determined.
        if (is_null($fieldToUpdate)) {
             return redirect()->back()->with('error', 'Invalid time slot selected.')->withInput();
        }

        // 3. Find or Create the record
        // firstOrNew will either find the record or instantiate a new one with the given attributes.
        $update = HourlyWorkUpdate::firstOrNew(
            [
                'employee_id' => $employeeId,
                'date' => $date,
            ]
        );

        // 4. Update the Specific Time Slot Field
        // THIS IS THE MAIN FIX: Use the assignment operator (=) and dynamic property access.
        $update->{$fieldToUpdate} = $workList;

        // 5. Save the record
        // This will INSERT the new record if it was not found, or UPDATE the existing record.
        $update->save();

        return redirect()->back()->with('success', 'Hourly work update saved successfully.');
    }

    public function hourly_work_update_all()
    {
        $data['updates'] = HourlyWorkUpdate::where('employee_id', Auth::user()->id)->get();
        return view('employee.hourly_work_update_all', $data);
    }

    public function notice($id)
    {
    $notice = Notice::findOrFail($id);
    $user = Auth::user();

    // Mark the notice as read if not already read
    if (!$notice->isReadBy($user->id)) {
        $notice->readBy()->attach($user->id, ['read_at' => now()]);
    }

    return view('employee.notice', compact('notice'));
    }


    public function notice_all()
    {
        $data['notices'] = Notice::orderBy('id','desc')->get();
        return view('employee.all_notice', $data);
    }

    public function warning($id)
    {
        $data['warning'] = Warning::where('id', $id)->where('to_employee', Auth::user()->id)->firstOrFail();
        return view('employee.warning', $data);
    }

    public function warning_all()
    {
        $data['warnings'] = Warning::where('to_employee', Auth::user()->id)->orderBy('id','desc')->get();
        return view('employee.all_warning', $data);
    }

    public function warning_read(Request $request, $id)
    {
    $data = Warning::findOrFail($id);

    $data->mark_as_read = $request->mark_as_read;
    $data->save();

    return redirect()->back()->with('success', 'Warning marked as read!');
    }
}
