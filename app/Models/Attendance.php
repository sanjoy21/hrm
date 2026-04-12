<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'office',
        'date',
        'check_in',
        'check_in_lat',
        'check_in_long',
        'check_in_address',
        'check_out',
        'check_out_lat',
        'check_out_long',
        'check_out_address',
    ];

    public function employee()
    {
        return $this->belongsTo(User::class, 'employee_id');
    }
}
