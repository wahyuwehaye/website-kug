<?php

namespace App\Filament\Resources\FinancialDocumentResource\Pages;

use App\Filament\Resources\FinancialDocumentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFinancialDocuments extends ListRecords
{
    protected static string $resource = FinancialDocumentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
