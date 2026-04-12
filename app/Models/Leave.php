<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    protected $fillable =[
        'employee_id',
        'leave_type',
        'from_date',
        'to_date',
        'total_day',
        'approved_by',
        'status',
        'application',
        'comment',
    ];

    public function employee()
    {
        return $this->belongsTo(User::class, 'employee_id');
    }

    public function leaveType()
    {
        return $this->belongsTo(LeaveType::class, 'leave_type');
    }

    public function attachments()
    {
        return $this->hasMany(LeaveAttachment::class);
    }

}
