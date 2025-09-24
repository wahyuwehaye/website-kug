<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FinancialDocumentResource\Pages;
use App\Models\FinancialDocument;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class FinancialDocumentResource extends Resource
{
    protected static ?string $model = FinancialDocument::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = 'Repositori Dokumen';

    protected static ?string $modelLabel = 'Dokumen Keuangan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Deskripsi Dokumen')
                    ->schema([
                        Tabs::make('document_translations')
                            ->tabs([
                                Tab::make('Bahasa Indonesia')
                                    ->schema([
                                        TextInput::make('title.id')
                                            ->label('Judul')
                                            ->required()
                                            ->maxLength(255),
                                        Textarea::make('description.id')
                                            ->label('Ringkasan')
                                            ->rows(4),
                                    ]),
                                Tab::make('English')
                                    ->schema([
                                        TextInput::make('title.en')
                                            ->label('Title')
                                            ->maxLength(255),
                                        Textarea::make('description.en')
                                            ->label('Summary')
                                            ->rows(4),
                                    ]),
                            ])
                            ->columnSpanFull(),
                        TextInput::make('slug')
                            ->label('Slug')
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                        TextInput::make('document_number')
                            ->label('Nomor Dokumen')
                            ->maxLength(255),
                        Select::make('category')
                            ->label('Kategori')
                            ->options([
                                'policy' => 'Kebijakan',
                                'budget' => 'RBA & Anggaran',
                                'report' => 'Laporan Keuangan',
                                'transparency' => 'Transparansi & Keterbukaan',
                                'service_standard' => 'Standar Layanan',
                                'guideline' => 'Panduan & Prosedur',
                            ])
                            ->required()
                            ->default('report'),
                        TextInput::make('year')
                            ->label('Tahun')
                            ->numeric()
                            ->minValue(2000)
                            ->maxValue(2100),
                        FileUpload::make('file_path')
                            ->label('Berkas Dokumen (PDF)')
                            ->acceptedFileTypes(['application/pdf'])
                            ->directory('documents')
                            ->downloadable(),
                        FileUpload::make('cover_image_path')
                            ->label('Gambar Sampul')
                            ->image()
                            ->directory('documents/covers')
                            ->imageEditor()
                            ->maxSize(2048),
                        TextInput::make('external_url')
                            ->label('URL Eksternal')
                            ->url()
                            ->maxLength(255),
                    ])
                    ->columns(2),
                Section::make('Publikasi & Penanda')
                    ->schema([
                        DateTimePicker::make('published_at')
                            ->label('Tanggal Publikasi')
                            ->seconds(false),
                        DateTimePicker::make('effective_at')
                            ->label('Tanggal Efektif')
                            ->seconds(false),
                        TextInput::make('display_order')
                            ->label('Urutan Tampil')
                            ->numeric()
                            ->default(0),
                        Toggle::make('is_featured')
                            ->label('Tandai sebagai unggulan'),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title.id')
                    ->label('Judul')
                    ->searchable()
                    ->limit(60),
                TextColumn::make('category')
                    ->label('Kategori')
                    ->badge(),
                TextColumn::make('document_number')
                    ->label('Nomor Dokumen')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('year')
                    ->label('Tahun')
                    ->sortable(),
                IconColumn::make('is_featured')
                    ->label('Unggulan')
                    ->boolean(),
                TextColumn::make('published_at')
                    ->label('Publikasi')
                    ->date('Y'),
            ])
            ->defaultSort('published_at', 'desc')
            ->filters([
                SelectFilter::make('category')
                    ->label('Kategori')
                    ->options([
                        'policy' => 'Kebijakan',
                        'budget' => 'RBA & Anggaran',
                        'report' => 'Laporan Keuangan',
                        'transparency' => 'Transparansi & Keterbukaan',
                        'service_standard' => 'Standar Layanan',
                        'guideline' => 'Panduan & Prosedur',
                    ]),
            ])
            ->actions([
                Actions\EditAction::make(),
                Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFinancialDocuments::route('/'),
            'create' => Pages\CreateFinancialDocument::route('/create'),
            'edit' => Pages\EditFinancialDocument::route('/{record}/edit'),
        ];
    }
}
