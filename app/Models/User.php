<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\ProjectComment;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'dob',
        'blood_group',
        'mobile',
        'nid',
        'role',
        'status',
        'address',
        'image',
        'joining_date',
        'resigning_date',
        'emergency_contact',
        'emergency_person',
        'relation',
        'department',
        'office',
        'educational_qualification',
        'experience',
        'designation',
        'joined_as',
        'starting_salary',
        'account_no',
    ];

    public function projectComments(): HasMany
{
    return $this->hasMany(ProjectComment::class, 'user_id');
}

public function unreadCommentsCount()
{
    return $this->hasMany(ProjectComment::class, 'user_id')
        ->where('is_read', false)
        ->where('user_id', '!=', $this->id) // Don't count own comments as unread
        ->count();
}

    public function departmentRelation()
    {
        return $this->belongsTo(Department::class, 'department');
    }

    public function leaves()
    {
        return $this->hasMany(Leave::class, 'employee_id');
    }

    public function office()
    {
        return $this->belongsTo(Office::class,'office');
    }

    /**
    * Notices read by the user
     */
    public function readNotices(): BelongsToMany
    {
    return $this->belongsToMany(Notice::class, 'notice_user')
                ->withPivot('read_at')
                ->withTimestamps();
    }


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }




}
