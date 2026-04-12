<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MonthlySalarySheet extends Model
{
    protected $fillable =[
        'employee_id',
        'month',
        'year',
        'salary',
        'bonus',
        'performance_bonus',
        'other_add',
        'advance',
        'ait',
        'revenue_stamp',
        'late_attendance',
        'other',
        'total_paid',
        'date_of_payment',
        'comment',
    ];
}
