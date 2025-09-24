<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\Translatable\HasTranslations;

class FinancialDocument extends Model
{
    use HasFactory;
    use HasTranslations;

    protected $guarded = [];

    /**
     * @var array<int, string>
     */
    public $translatable = ['title', 'description'];

    protected $casts = [
        'title' => 'array',
        'description' => 'array',
        'published_at' => 'datetime',
        'effective_at' => 'datetime',
        'is_featured' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::saving(function (self $document): void {
            if (empty($document->slug) && ! empty($document->getTranslation('title', app()->getLocale()))) {
                $document->slug = Str::slug($document->getTranslation('title', app()->getLocale()));
            }
        });
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function scopeCategory($query, string $category)
    {
        return $query->where('category', $category);
    }
}
