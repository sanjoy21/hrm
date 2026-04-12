<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Notice extends Model
{
    protected $fillable =[
        'title',
        'message',
        'date',
        'expire_date',
    ];

    protected $casts = [
        'date' => 'date',
        'expire_date' => 'date',
    ];

    /**
     * Users who have read this notice
     */
    public function readBy(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'notice_user')
                    ->withPivot('read_at')
                    ->withTimestamps();
    }

    /**
     * Check if notice has been read by a specific user
     */
    public function isReadBy($userId): bool
    {
        return $this->readBy()->where('user_id', $userId)->exists();
    }
}
