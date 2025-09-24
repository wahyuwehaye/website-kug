<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\Translatable\HasTranslations;

class Program extends Model
{
    use HasFactory;
    use HasTranslations;

    protected $guarded = [];

    /**
     * @var array<int, string>
     */
    public $translatable = ['name', 'summary', 'body'];

    protected $casts = [
        'name' => 'array',
        'summary' => 'array',
        'body' => 'array',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::saving(function (self $program): void {
            if (empty($program->slug) && ! empty($program->getTranslation('name', app()->getLocale()))) {
                $program->slug = Str::slug($program->getTranslation('name', app()->getLocale()));
            }
        });
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
