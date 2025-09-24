<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

class NewsCategory extends Model
{
    use HasFactory;
    use HasTranslations;

    protected $guarded = [];

    /**
     * @var array<int, string>
     */
    public $translatable = ['name', 'description'];

    protected $casts = [
        'name' => 'array',
        'description' => 'array',
        'is_active' => 'boolean',
    ];

    public function posts(): HasMany
    {
        return $this->hasMany(NewsPost::class);
    }
}
