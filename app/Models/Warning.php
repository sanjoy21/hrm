<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Warning extends Model
{
    protected $fillable =[
        'title',
        'message',
        'to_employee',
        'date',
        'mark_as_read'
    ];

    public function employee()
    {
        return $this->belongsTo(User::class,'to_employee');
    }
}
