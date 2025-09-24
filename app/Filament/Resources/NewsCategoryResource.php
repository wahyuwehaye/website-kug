<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NewsCategoryResource\Pages;
use App\Models\NewsCategory;
use Filament\Forms\Components\Section;
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
use Filament\Tables\Table;

class NewsCategoryResource extends Resource
{
    protected static ?string $model = NewsCategory::class;

    protected static ?string $navigationIcon = 'heroicon-o-bookmark';

    protected static ?string $navigationGroup = 'Manajemen Berita';

    protected static ?string $modelLabel = 'Kategori Berita';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Detail Kategori')
                    ->schema([
                        Tabs::make('category_translations')
                            ->tabs([
                                Tab::make('Bahasa Indonesia')
                                    ->schema([
                                        TextInput::make('name.id')
                                            ->label('Nama Kategori')
                                            ->required()
                                            ->maxLength(255),
                                        Textarea::make('description.id')
                                            ->label('Deskripsi')
                                            ->rows(3),
                                    ]),
                                Tab::make('English')
                                    ->schema([
                                        TextInput::make('name.en')
                                            ->label('Category Name')
                                            ->maxLength(255),
                                        Textarea::make('description.en')
                                            ->label('Description')
                                            ->rows(3),
                                    ]),
                            ])
                            ->columnSpanFull(),
                        TextInput::make('slug')
                            ->label('Slug')
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
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
                TextColumn::make('name.id')
                    ->label('Nama')
                    ->searchable()
                    ->limit(30),
                IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),
                TextColumn::make('updated_at')
                    ->label('Diperbarui')
                    ->since(),
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
            'index' => Pages\ListNewsCategories::route('/'),
            'create' => Pages\CreateNewsCategory::route('/create'),
            'edit' => Pages\EditNewsCategory::route('/{record}/edit'),
        ];
    }
}
