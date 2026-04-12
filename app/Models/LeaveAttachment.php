<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LeaveAttachment extends Model
{
        use HasFactory;

    protected $fillable = [
        'leave_id',
        'file_name',
        'file_path',
        'file_type',
        'file_size'
    ];

    public function leave()
    {
        return $this->belongsTo(Leave::class);
    }
}
