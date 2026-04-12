<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ArmyController;
use App\Http\Controllers\ManagementController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\LoginController;


// Admin Route Starts from Here

Route::group(['middleware' => 'admin.guest'], function () {
    Route::get('/', [AdminController::class, 'login'])->name('login');

    Route::get('/register', [AdminController::class, 'register'])->name('admin.register');
    Route::post('login', [AdminController::class, 'authenticate'])->name('authenticate');

});

Route::middleware(['admin.auth'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::post('check-in', [AdminController::class, 'checkIn'])->name('checkIn');
    Route::post('check-out', [AdminController::class, 'checkOut'])->name('checkOut');
    Route::get('/profile', [AdminController::class, 'profile'])->name('admin.profile');
    Route::post('/profile_update', [AdminController::class,'profile_update'])->name('admin.profile_update');
    Route::get('/logout', [AdminController::class, 'logout'])->name('admin.logout');

    Route::get('/employee_add', [AdminController::class, 'add_employee'])->name('add.employee');
    Route::post('/employee/store', [AdminController::class, 'employee_store'])->name('employee.store');
    Route::get('/employee', [AdminController::class, 'all_employee'])->name('all.employee');
    Route::get('/employee_profile/{id}', [AdminController::class, 'employee_profile'])->name('employee_profile');
    Route::post('/employee_profile_update/{id}', [AdminController::class, 'employee_profile_update'])->name('employee_profile_update');
    Route::get('/employee_delete/{id}', [AdminController::class, 'employee_delete'])->name('employee_delete');

    Route::get('/departments', [AdminController::class, 'departments'])->name('departments');
    Route::post('/departments_store', [AdminController::class, 'departments_store'])->name('departments_store');
    Route::get('/edit_department/{id}', [AdminController::class, 'edit_department'])->name('edit_department');
    Route::post('/department_update/{id}', [AdminController::class, 'department_update'])->name('department_update');
    Route::get('/department_delete/{id}', [AdminController::class, 'department_delete'])->name('department_delete');

    Route::get('/office', [AdminController::class, 'office'])->name('office');
    Route::post('/office_store', [AdminController::class, 'office_store'])->name('office_store');
    Route::get('/edit_office/{id}', [AdminController::class, 'edit_office'])->name('edit_office');
    Route::post('/office_update/{id}', [AdminController::class, 'office_update'])->name('office_update');
    Route::get('/office_delete/{id}', [AdminController::class, 'office_delete'])->name('office_delete');

    Route::get('/leave_type', [AdminController::class, 'leave_type'])->name('leave_type');
    Route::post('/leave_type_store', [AdminController::class, 'leave_type_store'])->name('leave_type_store');
    Route::get('/leave_type_edit/{id}', [AdminController::class, 'leave_type_edit'])->name('leave_type_edit');
    Route::post('/leave_type_update/{id}', [AdminController::class, 'leave_type_update'])->name('leave_type_update');
    Route::get('/leave_type_delete/{id}', [AdminController::class, 'leave_type_delete'])->name('leave_type_delete');

    Route::get('leave_application', [AdminController::class,'leave_application'])->name('leave_application');
    Route::post('leave_application_store', [AdminController::class,'leave_application_store'])->name('leave_application_store');
    Route::get('leave_all', [AdminController::class,'leave_all'])->name('leave_all');
    Route::get('leave_details/{id}', [AdminController::class,'leave_details'])->name('leave_details');
    Route::get('leave_print/{id}', [AdminController::class,'leave_print'])->name('leave_print');

    Route::get('/notice_all', [AdminController::class, 'notice_all'])->name('notice_all');
    Route::get('/notice_add', [AdminController::class, 'notice_add'])->name('notice_add');
    Route::post('/notice_add_store', [AdminController::class, 'notice_add_store'])->name('notice_add_store');
    Route::get('/notice/{id}', [AdminController::class, 'notice'])->name('notice');
    Route::get('/notice_edit/{id}', [AdminController::class, 'notice_edit'])->name('notice_edit');
    Route::post('/notice_update/{id}', [AdminController::class, 'notice_update'])->name('notice_update');
    Route::get('/notice_delete/{id}', [AdminController::class, 'notice_delete'])->name('notice_delete');

    Route::get('/warning_all', [AdminController::class, 'warning_all'])->name('warning_all');
    Route::get('/warning_add', [AdminController::class, 'warning_add'])->name('warning_add');
    Route::post('/warning_add_store', [AdminController::class, 'warning_add_store'])->name('warning_add_store');
    Route::get('/warning/{id}', [AdminController::class, 'warning'])->name('warning');
    Route::get('/warning_edit/{id}', [AdminController::class, 'warning_edit'])->name('warning_edit');
    Route::post('/warning_update/{id}', [AdminController::class, 'warning_update'])->name('warning_update');
    Route::get('/warning_delete/{id}', [AdminController::class, 'warning_delete'])->name('warning_delete');

    Route::get('/project_all', [AdminController::class, 'project_all'])->name('project_all');
    Route::get('/project_add', [AdminController::class, 'project_add'])->name('project_add');
    Route::post('/project_add_store', [AdminController::class, 'project_add_store'])->name('project_add_store');
    Route::get('/project_add', [AdminController::class, 'project_add'])->name('project_add');
    Route::get('/project/{id}', [AdminController::class, 'project'])->name('project');
    Route::get('/project_edit/{id}', [AdminController::class, 'project_edit'])->name('project_edit');
    Route::post('/project_update/{id}', [AdminController::class, 'project_update'])->name('project_update');
    Route::get('/project_delete/{id}', [AdminController::class, 'project_delete'])->name('project_delete');

    Route::post('/project/{id}/comment', [AdminController::class, 'project_comment'])->name('admin.project_comment');

    Route::get('/application_all', [AdminController::class, 'application_all'])->name('application_all');
    Route::get('/application/{id}', [AdminController::class, 'application'])->name('application');
    Route::put('/application/{id}/status', [AdminController::class, 'application_status'])->name('application_status');
    Route::get('/application/download-attachment/{id}', [AdminController::class, 'download_attachment'])->name('leave.download_attachment');

    Route::get('/manual_leave_approval', [AdminController::class,'manual_leave_approval'])->name('manual_leave_approval');
    Route::post('/manual_leave_approval_store', [AdminController::class,'manual_leave_approval_store'])->name('manual_leave_approval_store');


    Route::get('/promotion', [AdminController::class, 'promotion'])->name('promotion');
    Route::post('/promotion_store', [AdminController::class, 'promotion_store'])->name('promotion_store');
    Route::get('/promotion_all', [AdminController::class, 'promotion_all'])->name('promotion_all');

    Route::get('/salary_structure', [AdminController::class, 'salary_structure'])->name('salary_structure');
    Route::post('/salary_structure_store', [AdminController::class, 'salary_structure_store'])->name('salary_structure_store');
    Route::get('/salary_structure_view', [AdminController::class, 'salary_structure_view'])->name('salary_structure_view');
    Route::get('/salary_structure_edit/{id}', [AdminController::class, 'edit_salary_structure'])->name('edit_salary_structure');
    Route::get('/salary_structure_delete/{id}', [AdminController::class, 'salary_structure_delete'])->name('salary_structure_delete');
    Route::post('salary_structure_update/{id}', [AdminController::class, 'salary_structure_update'])->name('salary_structure_update');

    Route::get('/attendance_report',[AdminController::class,'attendance_report'])->name('attendance_report');
    Route::get('/attendance',[AdminController::class,'attendance'])->name('attendance');

    Route::get('/salary_sheet_add', [AdminController::class, 'salary_sheet_add'])->name('salary_sheet_add');
    Route::post('/salary_sheet_store', [AdminController::class, 'salary_sheet_store'])->name('salary_sheet_store');
    Route::get('/salary_sheet_view', [AdminController::class, 'salary_sheet_view'])->name('salary_sheet_view');
    Route::get('/salary_sheet/{id}', [AdminController::class, 'salary_sheet'])->name('salary_sheet');
    Route::post('/upload', [AdminController::class, 'uploadexcel'])->name('uploadexcel');

    Route::get('/download-sample-salary-sheet', function() {
    $file = public_path('sample-salary-sheet.xlsx');

    if (!file_exists($file)) {
        abort(404, 'Sample file not found.');
    }

    return response()->download($file, 'sample_salary_sheet.xlsx', [
        'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
    ]);
})->name('download.sample');


    Route::get('/initial_salary_sheet', [AdminController::class, 'initial_salary_sheet'])->name('initial_salary_sheet');

    Route::get('/noc_type', [AdminController::class, 'noc_type'])->name('noc_type');
    Route::post('/noc_type_store', [AdminController::class, 'noc_type_store'])->name('noc_type_store');
    Route::get('/noc_type_edit/{id}', [AdminController::class, 'noc_type_edit'])->name('noc_type_edit');
    Route::post('/noc_type_update/{id}', [AdminController::class, 'noc_type_update'])->name('noc_type_update');
    Route::get('/noc_type_delete/{id}', [AdminController::class, 'noc_type_delete'])->name('noc_type_delete');

    Route::get('/noc_all', [AdminController::class, 'noc_all'])->name('noc_all');
    Route::get('/noc_add', [AdminController::class, 'noc_add'])->name('noc_add');
    Route::post('/noc_add_store', [AdminController::class, 'noc_add_store'])->name('noc_add_store');
    Route::get('/noc/{id}', [AdminController::class, 'noc'])->name('noc');
    Route::get('/noc_edit/{id}', [AdminController::class, 'noc_edit'])->name('noc_edit');
    Route::post('/noc_update/{id}', [AdminController::class, 'noc_update'])->name('noc_update');
    Route::get('/noc_delete/{id}', [AdminController::class, 'noc_delete'])->name('noc_delete');

    Route::get('/noc_application_all', [AdminController::class, 'noc_application_all'])->name('noc_application_all');
    Route::get('/noc_application/{id}', [AdminController::class, 'noc_application'])->name('noc_application');
    Route::put('/noc_application/{id}/status', [AdminController::class, 'noc_application_status'])->name('noc_application_status');

    Route::get('/apply_for_noc', [AdminController::class, 'apply_for_noc'])->name('apply_for_noc');
    Route::post('/apply_for_noc_store', [AdminController::class, 'apply_for_noc_store'])->name('apply_for_noc_store');
    Route::get('/my_noc_list', [AdminController::class, 'my_noc_list'])->name('my_noc_list');
    Route::get('/my_noc_details/{id}', [AdminController::class, 'my_noc_details'])->name('my_noc_details');

    Route::get('/appointment_letter_add', [AdminController::class, 'appointment_letter_add'])->name('appointment_letter_add');
    Route::post('/appointment_letter_add_store', [AdminController::class, 'appointment_letter_add_store'])->name('appointment_letter_add_store');
    Route::get('/appointment_letter_all', [AdminController::class, 'appointment_letter_all'])->name('appointment_letter_all');
    Route::get('/appointment_letter/{id}', [AdminController::class, 'appointment_letter'])->name('appointment_letter');

    Route::get('/resign_add', [AdminController::class, 'resign_add'])->name('resign_add');
    Route::post('/resign_add_store', [AdminController::class, 'resign_add_store'])->name('resign_add_store');
    Route::get('/resign_all', [AdminController::class, 'resign_all'])->name('resign_all');
    Route::get('/resign_delete/{id}', [AdminController::class, 'resign_delete'])->name('resign_delete');


});

// Admin Route Ends Here


// BD Army Route starts from here

Route::group(['prefix' => 'army'], function () {

    Route::group(['middleware' => 'army.guest'], function () {

        Route::get('login', [ArmyController::class, 'login'])->name('army.login');
        Route::post('login', [ArmyController::class, 'authenticate'])->name('army.authenticate');
    });


    Route::group(['middleware' => 'army.auth'], function () {

        Route::get('dashboard',[ArmyController::class,'dashboard'])->name('army.dashboard');
        Route::post('check-in', [ArmyController::class, 'checkIn'])->name('army.checkIn');
        Route::post('check-out', [ArmyController::class, 'checkOut'])->name('army.checkOut');
        Route::get('profile', [ArmyController::class,'profile'])->name('army.profile');
        Route::post('/profile_update', [ArmyController::class,'profile_update'])->name('army.profile_update');
        Route::get('notice/{id}', [ArmyController::class,'notice'])->name('army.notice');
        Route::get('/employees', [ArmyController::class, 'employees'])->name('army.employees');
        Route::get('/employee_profile/{id}', [ArmyController::class, 'employee_profile'])->name('army.employee_profile');
        Route::get('/attendance', [ArmyController::class, 'attendance'])->name('army.attendance');
        Route::get('/attendance_report', [ArmyController::class, 'attendance_report'])->name('army.attendance_report');
        Route::get('logout',[ArmyController::class,'logout'])->name('army.logout');


    });
});
// BD Army Route ends here



// Management Route starts from here

Route::group(['prefix' => 'management'], function () {

    Route::group(['middleware' => 'management.guest'], function () {

        Route::get('/login', [ManagementController::class, 'login'])->name('management.login');
        Route::post('/login', [ManagementController::class, 'authenticate'])->name('management.authenticate');
    });


    Route::group(['middleware' => 'management.auth'], function () {

        Route::get('/dashboard',[ManagementController::class,'dashboard'])->name('management.dashboard');
        Route::post('/check-in', [ManagementController::class, 'checkIn'])->name('management.checkIn');
        Route::post('/check-out', [ManagementController::class, 'checkOut'])->name('management.checkOut');
        Route::get('/profile', [ManagementController::class,'profile'])->name('management.profile');
        Route::post('/profile_update', [ManagementController::class,'profile_update'])->name('management.profile_update');

        Route::get('/project_all', [ManagementController::class, 'project_all'])->name('management.project_all');
        Route::get('/project_add', [ManagementController::class, 'project_add'])->name('management.project_add');
        Route::post('/project_add_store', [ManagementController::class, 'project_add_store'])->name('management.project_add_store');
        Route::get('/project_add', [ManagementController::class, 'project_add'])->name('management.project_add');
        Route::get('/project/{id}', [ManagementController::class, 'project'])->name('management.project');
        Route::get('/project_edit/{id}', [ManagementController::class, 'project_edit'])->name('management.project_edit');
        Route::post('/project_update/{id}', [ManagementController::class, 'project_update'])->name('management.project_update');
        Route::get('/project_delete/{id}', [ManagementController::class, 'project_delete'])->name('management.project_delete');

        Route::get('/notice/{id}', [ManagementController::class,'notice'])->name('management.notice');
        Route::get('/notice', [ManagementController::class,'notice_all'])->name('management.notice_all');

        Route::get('/leave_application', [ManagementController::class,'leave_application'])->name('management.leave_application');
        Route::post('/leave_application_store', [ManagementController::class,'leave_application_store'])->name('management.leave_application_store');
        Route::get('/leave_all', [ManagementController::class,'leave_all'])->name('management.leave_all');
        Route::get('/leave_details/{id}', [ManagementController::class,'leave_details'])->name('management.leave_details');
        Route::get('/leave_print/{id}', [ManagementController::class,'leave_print'])->name('management.leave_print');

        Route::get('/noc_application', [ManagementController::class,'noc_application'])->name('management.noc_application');
        Route::post('/noc_application_store', [ManagementController::class,'noc_application_store'])->name('management.noc_application_store');
        Route::get('/noc_all', [ManagementController::class,'noc_all'])->name('management.noc_all');
        Route::get('/noc_details/{id}', [ManagementController::class,'noc_details'])->name('management.noc_details');

        Route::get('/employees', [ManagementController::class, 'all_employee'])->name('management.employees');
        Route::get('/employee_profile/{id}', [ManagementController::class, 'employee_profile'])->name('management.employee_profile');
        Route::get('/logout',[ManagementController::class,'logout'])->name('management.logout');


    });
});
// Management Route ends here



// Employee Route starts from here

Route::group(['prefix' => 'employee'], function () {

    Route::group(['middleware' => 'guest'],function(){

    Route::get('login', [EmployeeController::class,'login'])->name('employee.login');
    Route::post('authenticate', [EmployeeController::class,'authenticate'])->name('employee.authenticate');

    });


    Route::group(['middleware' => 'auth'],function(){

    Route::get('dashboard', [EmployeeController::class,'dashboard'])->name('employee.dashboard');

    Route::post('check-in', [EmployeeController::class, 'checkIn'])->name('employee.checkIn');
    Route::post('check-out', [EmployeeController::class, 'checkOut'])->name('employee.checkOut');

    Route::get('profile', [EmployeeController::class,'profile'])->name('employee.profile');
    Route::post('profile_update', [EmployeeController::class,'profile_update'])->name('employee.profile_update');

    Route::get('notice', [EmployeeController::class,'notice_all'])->name('employee.notice_all');
    Route::get('notice/{id}', [EmployeeController::class,'notice'])->name('employee.notice');

    Route::get('warning', [EmployeeController::class,'warning_all'])->name('employee.warning_all');
    Route::get('warning/{id}', [EmployeeController::class,'warning'])->name('employee.warning');
    Route::put('/warning/{id}/status', [EmployeeController::class, 'warning_read'])->name('warning_read');

    // Route::get('notice-dismiss/{id}', function ($id) {session()->put('notice_dismissed_'.$id, true);});
    Route::get('logout', [EmployeeController::class,'logout'])->name('employee.logout');

    Route::get('application', [EmployeeController::class,'application'])->name('employee.application');
    Route::post('application_store', [EmployeeController::class,'application_store'])->name('employee.application_store');

    Route::get('application_leave', [EmployeeController::class,'leave_application'])->name('employee.leave_application');
    Route::post('leave_application_store', [EmployeeController::class,'leave_application_store'])->name('employee.leave_application_store');
    Route::get('application_all', [EmployeeController::class,'leave_all'])->name('employee.leave_all');
    Route::get('application_details/{id}', [EmployeeController::class,'leave_details'])->name('employee.leave_details');
    Route::get('leave_print/{id}', [EmployeeController::class,'leave_print'])->name('employee.leave_print');
    Route::get('application/download-attachment/{id}', [EmployeeController::class, 'download_attachment'])->name('employee.leave.download_attachment');

    Route::get('noc_application', [EmployeeController::class,'noc_application'])->name('employee.noc_application');
    Route::post('noc_application_store', [EmployeeController::class,'noc_application_store'])->name('employee.noc_application_store');
    Route::get('noc_all', [EmployeeController::class,'noc_all'])->name('employee.noc_all');
    Route::get('noc_details/{id}', [EmployeeController::class,'noc_details'])->name('employee.noc_details');

    Route::get('project_all', [EmployeeController::class,'project_all'])->name('employee.project_all');
    Route::get('project/{id}', [EmployeeController::class,'project'])->name('employee.project');
    Route::post('project_update/{id}', [EmployeeController::class,'project_update'])->name('employee.project_update');
    Route::post('project/{id}/comment', [EmployeeController::class, 'project_comment'])->name('employee.project_comment');

    Route::get('hourly_work_update', [EmployeeController::class,'hourly_work_update'])->name('employee.hourly_work_update');
    Route::post('hourly_work_update_store', [EmployeeController::class,'hourly_work_update_store'])->name('employee.hourly_work_update_store');
    Route::get('hourly_work_update_all', [EmployeeController::class,'hourly_work_update_all'])->name('employee.hourly_work_update_all');


    });

});
// Employee Route ends here
