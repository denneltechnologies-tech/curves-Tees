<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeroSlide extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'subtitle',
        'tag',
        'media_type',
        'image_path',
        'video_url',
        'button_text',
        'button_link',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Get image URL handling both external and local uploads.
     */
    public function getImageUrlAttribute(): ?string
    {
        if (empty($this->image_path)) {
            return null;
        }

        if (str_starts_with($this->image_path, 'http://') || str_starts_with($this->image_path, 'https://')) {
            return $this->image_path;
        }

        return '/storage/' . ltrim($this->image_path, '/');
    }

    /**
     * Convert Google Drive, YouTube, or relative links into embeddable / streaming format.
     */
    public function getEmbedVideoUrlAttribute(): ?string
    {
        return self::formatVideoUrl($this->video_url);
    }

    /**
     * Convert any video URL (Google Drive, YouTube, direct MP4) into standard playable URL.
     */
    public static function formatVideoUrl(?string $url): ?string
    {
        if (empty($url)) {
            return null;
        }

        $url = trim($url);

        // Google Drive link conversion (e.g. drive.google.com/file/d/ID/view, open?id=ID, uc?id=ID)
        if (preg_match('#drive\.google\.com/(?:file/d/|open\?id=|uc\?id=)([a-zA-Z0-9_-]+)#', $url, $matches)) {
            return 'https://drive.google.com/file/d/' . $matches[1] . '/preview';
        }

        // YouTube link conversion
        if (preg_match('#(?:youtube\.com/(?:watch\?v=|embed/)|youtu\.be/)([a-zA-Z0-9_-]+)#', $url, $matches)) {
            return 'https://www.youtube.com/embed/' . $matches[1] . '?autoplay=1&mute=1&loop=1&playlist=' . $matches[1];
        }

        // If it's a relative local file stored in storage
        if (!str_starts_with($url, 'http://') && !str_starts_with($url, 'https://')) {
            return '/storage/' . ltrim($url, '/');
        }

        return $url;
    }
}
