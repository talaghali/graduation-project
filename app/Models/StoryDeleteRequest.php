<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoryDeleteRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'story_id',
        'user_id',
        'reason',
        'status',
        'handled_by',
        'handled_at',
        'admin_notes',
    ];

    protected $casts = [
        'handled_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the story that this delete request is for
     */
    public function story()
    {
        return $this->belongsTo(Story::class);
    }

    /**
     * Get the user who requested the deletion
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the admin who handled the request
     */
    public function handledBy()
    {
        return $this->belongsTo(User::class, 'handled_by');
    }

    /**
     * Scope for pending requests
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope for approved requests
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Scope for rejected requests
     */
    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }
}
