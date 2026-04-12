<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HourlyWorkUpdate extends Model
{
    protected $fillable =[
        'employee_id',
        'date',
        't9_10',
        't10_11',
        't11_12',
        't12_1',
        't1_2',
        't2_3',
        't3_4',
        't4_5',
    ];
}
