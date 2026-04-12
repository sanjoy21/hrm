<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppointmentLetter extends Model
{
    protected $fillable = [
        'name',
        'date',
        'letter',
    ];
}
