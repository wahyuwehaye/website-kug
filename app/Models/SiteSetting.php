<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class SiteSetting extends Model
{
    use HasFactory;
    use HasTranslations;

    protected $guarded = [];

    /**
     * @var array<int, string>
     */
    public $translatable = [
        'name',
        'tagline',
        'short_description',
        'vision',
        'mission',
        'about',
        'address',
        'meta_description',
        'meta_keywords',
    ];

    protected $casts = [
        'name' => 'array',
        'tagline' => 'array',
        'short_description' => 'array',
        'vision' => 'array',
        'mission' => 'array',
        'about' => 'array',
        'address' => 'array',
        'meta_description' => 'array',
        'meta_keywords' => 'array',
    ];
}
