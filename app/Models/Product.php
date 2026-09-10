<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory;

    public const STATUS_ACTIVE = 'active';
    public const STATUS_INACTIVE = 'inactive';

    protected $fillable = ['category_id', 'name', 'description', 'price', 'image', 'sizes', 'is_featured', 'status'];

    protected $casts = [
        'price' => 'decimal:2',
        'category_id' => 'integer',
        'is_featured' => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function getImageUrlAttribute(): ?string
    {
        if (!$this->image) {
            return null;
        }

        if (str_starts_with($this->image, 'http://') || str_starts_with($this->image, 'https://')) {
            return $this->image;
        }

        return Storage::disk($this->imageDisk())->url($this->image);
    }

    public function getSizesListAttribute(): array
    {
        if (!$this->sizes) {
            return ['UK 10', 'UK 12', 'UK 14', 'UK 16', 'UK 18', 'UK 20', 'UK 22'];
        }
        return array_map('trim', explode(',', $this->sizes));
    }

    protected function imageDisk(): string
    {
        return config('filesystems.default');
    }
}
