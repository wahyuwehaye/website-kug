<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class ContactChannel extends Model
{
    use HasFactory;
    use HasTranslations;

    protected $guarded = [];

    /**
     * @var array<int, string>
     */
    public $translatable = ['name', 'notes'];

    protected $casts = [
        'name' => 'array',
        'notes' => 'array',
        'is_primary' => 'boolean',
    ];
}
