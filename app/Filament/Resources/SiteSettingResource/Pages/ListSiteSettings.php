<?php

namespace App\Filament\Resources\SiteSettingResource\Pages;

use App\Filament\Resources\SiteSettingResource;
use App\Models\SiteSetting;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSiteSettings extends ListRecords
{
    protected static string $resource = SiteSettingResource::class;

    protected function getHeaderActions(): array
    {
        if (SiteSetting::query()->exists()) {
            return [];
        }

        return [
            Actions\CreateAction::make()
                ->label('Inisialisasi Pengaturan'),
        ];
    }
}
