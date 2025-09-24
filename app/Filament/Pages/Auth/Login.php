<?php

namespace App\Filament\Pages\Auth;

use Filament\Pages\Auth\Login as BaseLogin;
use Illuminate\Contracts\Support\Htmlable;

class Login extends BaseLogin
{
    protected static string $view = 'filament.auth.login';

    public function getHeading(): string | Htmlable
    {
        return 'Masuk ke Portal Direktorat Keuangan';
    }

    public function getSubheading(): string | Htmlable
    {
        return 'Kelola konten website dengan antarmuka terbaru yang lebih gesit dan intuitif.';
    }

    public function hasLogo(): bool
    {
        return false;
    }
}
