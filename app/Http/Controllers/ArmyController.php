<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Department;
use App\Models\Office;
use App\Models\LeaveType;
use App\Models\Notice;
use App\Models\Warning;
use App\Models\Project;
use App\Models\Leave;
use App\Models\Promotion;
use App\Models\Salary;
use App\Models\Attendance;
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

class ArmyController extends Controller
{
    public function login()
    {
        return view('army.login');
    }

    public function authenticate(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        if (Auth::guard('army')->attempt([
            'email' => $request->email,
            'password' => $request->password
        ])) {
            if (Auth::guard('army')->user()->role != 'army') {
                Auth::guard('army')->logout();
                return redirect()->route('army.login')->with('error', 'Access denied ! Unauthorised user.');
            }
            return redirect()->route('army.dashboard');
        } else {
            return redirect()->route('army.login')->with('error', 'Something went wrong');
        }
    }


    public function dashboard(Request $request)
    {
    $user = Auth::guard('army')->user();
    $today = \Carbon\Carbon::today()->toDateString();

    // Get the selected office from request
    $selectedOfficeId = 2;

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
        ->get(['date', 'check_in', 'check_out', 'check_in_lat', 'check_in_long']);

    // Prepare calendar data
    $calendarData = $attendances->map(function ($item) {
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
            'check_out' => $item->check_out,
        ];
    });

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

    $notice = Notice::orderBy('created_at', 'desc')->first();
    $applications = Leave::where('status', 'Applied')->get();
    $birthday = User::where('status', 'active')->get();
    $offices = Office::all();

    $total = User::where('status','active')
    ->where('role','employee')
    ->where('office',2)->count();

    $male = User::where('status','active')
    ->where('role','employee')
    ->where('office',2)
    ->where('gender','male')->count();

    $female = User::where('status','active')
    ->where('role','employee')
    ->where('office',2)
    ->where('gender','female')->count();

    $at_today = Attendance::whereDate('date', $today)
        ->where('office',2)->count();

    return view('army.dashboard', compact(
        'attendance',
        'notice',
        'applications',
        'birthday',
        'statusMessage',
        'calendarData',
        'employees',
        'attend',
        'deliverymen',
        'offices',
        'total',
        'male',
        'female',
        'at_today',
        'selectedOfficeId' // Pass selected office ID to view
    ));
    }

    // public function checkIn(Request $request)
    // {
    //     $user = Auth::guard('army')->user();
    //     $today = \Carbon\Carbon::today()->toDateString();

    //     // Prevent multiple check-ins in a single day
    //     $attendance = Attendance::where('employee_id', $user->id)
    //         ->where('date', $today)
    //         ->first();

    //     if ($attendance) {
    //         return response()->json(['message' => 'Already checked in today'], 400);
    //     }

    //     $currentTime = \Carbon\Carbon::now();
    //     $lateThreshold = \Carbon\Carbon::createFromTime(9, 20, 0); // 09:20 AM

    //     $statusMessage = $currentTime->greaterThan($lateThreshold)
    //         ? 'You are late today!'
    //         : 'You are on time today!';

    //     Attendance::create([
    //         'employee_id' => $user->id,
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
    //     $user = Auth::guard('army')->user();
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

    public function profile()
    {
        return view('army.profile');
    }

    public function profile_update(Request $request)
    {
        $user = Auth::guard('army')->user();

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

        return redirect()->route('army.profile')->with('success', 'Profile updated successfully.');
    }

    public function notice($id)
    {
        $data['notice'] = Notice::findOrFail($id);
        return view('army.notice', $data);
    }

    public function employee_profile($id)
    {
        $data['employee'] = User::where('id',$id)->where('status','active')->where('department',10)->firstOrFail();
        $data['promotion'] = Promotion::where('employee_id', $id)->orderBy('id','desc')->get();
        $data['resigns'] = Resign::where('employee_id', $id)->get();
        $data['department'] = Department::where('department_name','DNCC Zone')->first();
        $data['offices'] = Office::all();

    // All attendance for calendar
    $attendances = Attendance::where('employee_id', $id)->get(['date', 'check_in', 'check_out','check_in_lat','check_in_long']);

    // Get approved leaves for this employee
    $approvedLeaves = Leave::where('employee_id', $id)
        ->where('status', 'Approved')
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
                'check_out' => null,
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
            'check_out' => $item->check_out,
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
                'check_out' => null,
                'is_leave' => true,
                'leave_type' => $leaveInfo['leave_type']
            ]);
        }
    }

    // Sort calendar data by date
    $calendarData = $calendarData->sortBy('date')->values();

    $data['calendarData'] = $calendarData;
    $data['attendances'] = $attendances;

        return view('army.employee_profile', $data);
    }

    public function employees()
    {
        $data['department'] = Department::where('department_name','DNCC Zone')->first();

        // $query = User::whereIn('role', ['admin', 'management','employee']);

        // Filter by Department if selected
    // if ($request->filled('department')) {
    //     $query->where('department', $request->department);
    // }

    // $records = $query->get();

    $data['employees'] = User::where('status','active')->where('role','employee')->get();

        return view('army.all_employee', $data);
    }

    public function attendance_report(Request $request)
{
    // Get distinct years from attendance records
    $data['distinct_years'] = Attendance::selectRaw('YEAR(date) as year')
        ->distinct()
        ->orderBy('year', 'desc')
        ->pluck('year');

    // Start query with relationships
    $query = Attendance::with('employee')->orderBy('date', 'desc')->where('office',2);

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
    $data['employees'] = User::where('office',2)->where('role','employee')->orderBy('name')->get();
    $data['selected_month'] = $request->input('month');
    $data['selected_year'] = $request->input('year');
    $data['selected_employee_id'] = $request->input('employee');

    return view('army.attendance_report', $data);
}

    public function attendance(Request $request)
    {
        // Get distinct years from attendance records
    $data['distinct_years'] = Attendance::selectRaw('YEAR(date) as year')
        ->distinct()
        ->orderBy('year', 'desc')
        ->pluck('year');

    // Start query with relationships
    $query = Attendance::with('employee')->orderBy('date', 'desc')->where('office',2);

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
        $data['attendance'] = Attendance::where('office',2)->orderBy('date','desc')->get();
        $data['employees'] = User::where('role','employee')->where('status','active')
        ->where('office',2)->orderBy('name')->get();


        $data['selected_month'] = $request->input('month');
        $data['selected_year'] = $request->input('year');
        $data['selected_employee_id'] = $request->input('employee');
        return view('army.attendance', $data);
    }


    public function logout()
    {
        Auth::guard('army')->logout();
        return redirect()->route('army.login')->with('success', 'Logged out successfully');
    }


}
