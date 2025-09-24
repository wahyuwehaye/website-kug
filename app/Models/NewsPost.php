<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
use Spatie\Translatable\HasTranslations;

class NewsPost extends Model
{
    use HasFactory;
    use HasTranslations;

    protected $guarded = [];

    /**
     * @var array<int, string>
     */
    public $translatable = [
        'title',
        'excerpt',
        'body',
        'meta_description',
        'meta_keywords',
    ];

    protected $casts = [
        'title' => 'array',
        'excerpt' => 'array',
        'body' => 'array',
        'meta_description' => 'array',
        'meta_keywords' => 'array',
        'published_at' => 'datetime',
        'is_featured' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::saving(function (self $post): void {
            if (empty($post->slug) && ! empty($post->getTranslation('title', app()->getLocale()))) {
                $post->slug = Str::slug($post->getTranslation('title', app()->getLocale()));
            }
        });
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(NewsCategory::class, 'news_category_id');
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published')->whereNotNull('published_at')->where('published_at', '<=', now());
    }
}
