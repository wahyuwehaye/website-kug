<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NavigationLinkResource\Pages;
use App\Models\NavigationLink;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Collection;

class NavigationLinkResource extends Resource
{
    protected static ?string $model = NavigationLink::class;

    protected static ?string $navigationIcon = 'heroicon-o-bars-3';

    protected static ?string $navigationGroup = 'Konten Landing Page';

    protected static ?string $modelLabel = 'Menu Navigasi';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Detail Menu')
                    ->schema([
                        Tabs::make('title_translations')
                            ->tabs([
                                Tab::make('Bahasa Indonesia')
                                    ->schema([
                                        TextInput::make('title.id')
                                            ->label('Judul Menu')
                                            ->required()
                                            ->maxLength(255),
                                    ]),
                                Tab::make('English')
                                    ->schema([
                                        TextInput::make('title.en')
                                            ->label('Menu Title')
                                            ->maxLength(255),
                                    ]),
                            ])
                            ->columnSpanFull(),
                        TextInput::make('slug')
                            ->label('Slug')
                            ->maxLength(255)
                            ->helperText('Opsional, gunakan untuk anchor internal atau referensi SEO.')
                            ->unique(ignoreRecord: true),
                        TextInput::make('url')
                            ->label('URL / Anchor')
                            ->required()
                            ->maxLength(255),
                        Select::make('parent_id')
                            ->label('Parent Menu')
                            ->options(fn (): Collection => NavigationLink::query()
                                ->whereNull('parent_id')
                                ->orderBy('sort')
                                ->pluck('title->id', 'id'))
                            ->searchable()
                            ->preload()
                            ->nullable(),
                        Select::make('location')
                            ->label('Lokasi Navigasi')
                            ->options([
                                'top' => 'Top Navigation',
                                'main' => 'Main Menu',
                                'footer' => 'Footer',
                                'quick' => 'Quick Links',
                            ])
                            ->required()
                            ->default('main'),
                        TextInput::make('sort')
                            ->label('Urutan')
                            ->numeric()
                            ->default(0),
                        Toggle::make('is_external')
                            ->label('Buka di tab baru'),
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
                TextColumn::make('title.id')
                    ->label('Judul')
                    ->searchable()
                    ->limit(40),
                TextColumn::make('parent.title.id')
                    ->label('Parent')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('location')
                    ->label('Lokasi')
                    ->badge(),
                TextColumn::make('sort')
                    ->label('Urutan')
                    ->sortable(),
                IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),
            ])
            ->defaultSort('location')
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
            'index' => Pages\ListNavigationLinks::route('/'),
            'create' => Pages\CreateNavigationLink::route('/create'),
            'edit' => Pages\EditNavigationLink::route('/{record}/edit'),
        ];
    }
}
