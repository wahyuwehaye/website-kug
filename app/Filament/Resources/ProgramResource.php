<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProgramResource\Pages;
use App\Models\Program;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProgramResource extends Resource
{
    protected static ?string $model = Program::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';

    protected static ?string $navigationGroup = 'Konten Landing Page';

    protected static ?string $modelLabel = 'Program & Layanan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi Utama')
                    ->schema([
                        Tabs::make('program_translations')
                            ->tabs([
                                Tab::make('Bahasa Indonesia')
                                    ->schema([
                                        TextInput::make('name.id')
                                            ->label('Nama Program')
                                            ->required()
                                            ->maxLength(255),
                                        TextInput::make('summary.id')
                                            ->label('Ringkasan')
                                            ->maxLength(255),
                                        RichEditor::make('body.id')
                                            ->label('Deskripsi')
                                            ->toolbarButtons([
                                                'bold', 'italic', 'bulletList', 'orderedList', 'link', 'undo', 'redo',
                                            ]),
                                    ]),
                                Tab::make('English')
                                    ->schema([
                                        TextInput::make('name.en')
                                            ->label('Program Name')
                                            ->maxLength(255),
                                        TextInput::make('summary.en')
                                            ->label('Summary')
                                            ->maxLength(255),
                                        RichEditor::make('body.en')
                                            ->label('Description (EN)')
                                            ->toolbarButtons([
                                                'bold', 'italic', 'bulletList', 'orderedList', 'link', 'undo', 'redo',
                                            ]),
                                    ]),
                            ])
                            ->columnSpanFull(),
                        TextInput::make('slug')
                            ->label('Slug')
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        Select::make('type')
                            ->label('Kategori')
                            ->options([
                                'program' => 'Program Strategis',
                                'service' => 'Layanan Keuangan',
                                'policy' => 'Kebijakan & SOP',
                                'highlight' => 'Highlight Kinerja',
                            ])
                            ->default('program')
                            ->required(),
                        FileUpload::make('thumbnail_path')
                            ->label('Gambar Sampul')
                            ->directory('programs')
                            ->image()
                            ->imageEditor()
                            ->maxSize(2048),
                        TextInput::make('icon')
                            ->label('Ikon (heroicon/phosphor)')
                            ->maxLength(100),
                        TextInput::make('external_url')
                            ->label('URL Detail Eksternal')
                            ->url()
                            ->maxLength(255),
                        TextInput::make('sort')
                            ->label('Urutan')
                            ->numeric()
                            ->default(0),
                        Toggle::make('is_featured')
                            ->label('Tampilkan sebagai unggulan'),
                        Toggle::make('is_active')
                            ->label('Aktif')
                            ->default(true),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('thumbnail_path')
                    ->label('Sampul')
                    ->square(),
                TextColumn::make('name.id')
                    ->label('Nama')
                    ->searchable()
                    ->limit(35),
                TextColumn::make('type')
                    ->label('Kategori')
                    ->badge(),
                IconColumn::make('is_featured')
                    ->label('Unggulan')
                    ->boolean(),
                IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),
                TextColumn::make('updated_at')
                    ->label('Diperbarui')
                    ->since(),
            ])
            ->defaultSort('type')
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
            'index' => Pages\ListPrograms::route('/'),
            'create' => Pages\CreateProgram::route('/create'),
            'edit' => Pages\EditProgram::route('/{record}/edit'),
        ];
    }
}
