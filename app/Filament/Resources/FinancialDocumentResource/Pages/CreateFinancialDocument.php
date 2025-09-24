<?php

namespace App\Filament\Resources\FinancialDocumentResource\Pages;

use App\Filament\Resources\FinancialDocumentResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateFinancialDocument extends CreateRecord
{
    protected static string $resource = FinancialDocumentResource::class;
}
