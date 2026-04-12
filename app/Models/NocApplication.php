<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NocApplication extends Model
{
    protected $fillable =[

        'employee_id',
        'application',
        'approved_by',
        'status',
    ];

    public function employee()
    {
        return $this->belongsTo(User::class, 'employee_id');
    }
}
