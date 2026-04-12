<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Noc extends Model
{
    protected $fillable =[
        'noc_type',
        'employee_id',
        'salutation',
        'from_date',
        'to_date',
        'date',
        'passport',
        'country',
        'reason',
    ];
}
