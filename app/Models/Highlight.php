<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Highlight extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'video_url',
        'video_type',
        'thumbnail_path',
        'is_active',
        'order',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    /**
     * Get active highlights
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get highlights ordered by order field
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }

    /**
     * Get embed URL for video
     */
    public function getEmbedUrlAttribute(): string
    {
        if ($this->video_type === 'youtube') {
            // Extract YouTube video ID from various URL formats
            preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i', $this->video_url, $matches);
            $videoId = $matches[1] ?? null;
            return $videoId ? "https://www.youtube.com/embed/{$videoId}" : $this->video_url;
        } elseif ($this->video_type === 'vimeo') {
            // Extract Vimeo video ID
            preg_match('/vimeo\.com\/(\d+)/', $this->video_url, $matches);
            $videoId = $matches[1] ?? null;
            return $videoId ? "https://player.vimeo.com/video/{$videoId}" : $this->video_url;
        }

        // For local videos, return storage path
        return asset('storage/' . $this->video_url);
    }

    /**
     * Get thumbnail URL for video
     */
    public function getThumbnailUrlAttribute(): string
    {
        // If custom thumbnail is uploaded
        if ($this->thumbnail_path) {
            // Check if it's from storage (user uploaded)
            if (str_starts_with($this->thumbnail_path, 'highlights/')) {
                return asset('storage/' . $this->thumbnail_path);
            }
            // Otherwise it's from public directory (seeded data)
            return asset($this->thumbnail_path);
        }

        // For YouTube, get auto thumbnail
        if ($this->video_type === 'youtube') {
            preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i', $this->video_url, $matches);
            $videoId = $matches[1] ?? null;
            if ($videoId) {
                // Use high quality YouTube thumbnail
                return "https://img.youtube.com/vi/{$videoId}/maxresdefault.jpg";
            }
        }

        // Default fallback to logo
        return asset('front/img/logo f.png');
    }

    /**
     * Get status badge color
     */
    public function getStatusBadgeColorAttribute(): string
    {
        return $this->is_active ? 'success' : 'secondary';
    }

    /**
     * Get status text
     */
    public function getStatusTextAttribute(): string
    {
        return $this->is_active ? 'Active' : 'Inactive';
    }
}
