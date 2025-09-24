<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Spatie\Translatable\HasTranslations;

class Announcement extends Model
{
    use HasFactory;
    use HasTranslations;

    protected $guarded = [];

    /**
     * @var array<int, string>
     */
    public $translatable = ['title', 'body', 'cta_label'];

    protected $casts = [
        'title' => 'array',
        'body' => 'array',
        'cta_label' => 'array',
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'published_at' => 'datetime',
        'is_sticky' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::saving(function (self $announcement): void {
            if ($announcement->slug) {
                return;
            }

            $locale = app()->getLocale();
            $fallbackLocale = config('app.fallback_locale');
            $translations = $announcement->getTranslations('title');

            $rawTitle = $translations[$locale]
                ?? ($fallbackLocale ? ($translations[$fallbackLocale] ?? null) : null)
                ?? Arr::first($translations)
                ?? $announcement->title;

            if (is_array($rawTitle)) {
                $rawTitle = Arr::first($rawTitle);
            }

            if (! $rawTitle) {
                return;
            }

            $announcement->slug = Str::slug(Str::limit(strip_tags((string) $rawTitle), 70, ''));
        });
    }

    public function scopeActive($query)
    {
        $now = now();

        return $query
            ->where(function ($query) use ($now) {
                $query->whereNull('starts_at')->orWhere('starts_at', '<=', $now);
            })
            ->where(function ($query) use ($now) {
                $query->whereNull('ends_at')->orWhere('ends_at', '>=', $now);
            })
            ->where('status', 'published');
    }
}
