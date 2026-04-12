<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Project extends Model
{
    protected $fillable =[
        'employee',
        'employer',
        'project_name',
        'project_details',
        'assign_date',
        'deadline',
        'status',
        'progress',
        'submission_date',
    ];

    public function employee()
    {
        return $this->belongsTo(User::class,'employee');
    }

        // Relationship for all comments
    public function allComments(): HasMany
    {
        return $this->hasMany(ProjectComment::class, 'project_id')->orderBy('created_at', 'asc');
    }

    // Relationship for employee who is assigned
    public function assignedEmployee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'employee');
    }

    // Relationship for employer who assigned
    public function assignedEmployer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'employer');
    }
}
