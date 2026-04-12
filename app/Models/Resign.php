<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resign extends Model
{
    protected $fillable = [
        'employee_id',
        'date',
        'reason',
    ];
}
