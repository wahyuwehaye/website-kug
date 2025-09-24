<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HeroSlideResource\Pages;
use App\Models\HeroSlide;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class HeroSlideResource extends Resource
{
    protected static ?string $model = HeroSlide::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';

    protected static ?string $navigationGroup = 'Konten Landing Page';

    protected static ?string $modelLabel = 'Slider Beranda';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Konten Slider')
                    ->schema([
                        Tabs::make('hero_translations')
                            ->tabs([
                                Tab::make('Bahasa Indonesia')
                                    ->schema([
                                        TextInput::make('title.id')
                                            ->label('Judul')
                                            ->required()
                                            ->maxLength(255),
                                        TextInput::make('subtitle.id')
                                            ->label('Subjudul')
                                            ->maxLength(255),
                                        Textarea::make('description.id')
                                            ->label('Deskripsi Singkat')
                                            ->rows(3),
                                        TextInput::make('cta_label.id')
                                            ->label('Teks Tombol')
                                            ->maxLength(120),
                                    ])
                                    ->columns(2),
                                Tab::make('English')
                                    ->schema([
                                        TextInput::make('title.en')
                                            ->label('Title')
                                            ->maxLength(255),
                                        TextInput::make('subtitle.en')
                                            ->label('Subtitle')
                                            ->maxLength(255),
                                        Textarea::make('description.en')
                                            ->label('Description')
                                            ->rows(3),
                                        TextInput::make('cta_label.en')
                                            ->label('Button Text')
                                            ->maxLength(120),
                                    ])
                                    ->columns(2),
                            ])
                            ->columnSpanFull(),
                        TextInput::make('cta_url')
                            ->label('URL Tombol')
                            ->url()
                            ->maxLength(255),
                    ])->columns(2),
                Section::make('Media & Penjadwalan')
                    ->schema([
                        Select::make('media_type')
                            ->label('Tipe Media')
                            ->options([
                                'image' => 'Gambar',
                                'video' => 'Video',
                            ])
                            ->required()
                            ->default('image'),
                        FileUpload::make('media_path')
                            ->label('Media Utama')
                            ->image()
                            ->directory('hero')
                            ->imageEditor()
                            ->maxSize(2048)
                            ->visible(fn (callable $get) => $get('media_type') === 'image'),
                        TextInput::make('video_url')
                            ->label('URL Video (YouTube/Vimeo)')
                            ->url()
                            ->visible(fn (callable $get) => $get('media_type') === 'video'),
                        TextInput::make('sort')
                            ->label('Urutan')
                            ->numeric()
                            ->default(0),
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
                ImageColumn::make('media_path')
                    ->label('Media')
                    ->square(),
                TextColumn::make('title.id')
                    ->label('Judul')
                    ->limit(40),
                TextColumn::make('media_type')
                    ->label('Tipe')
                    ->badge(),
                TextColumn::make('sort')
                    ->label('Urutan')
                    ->sortable(),
                IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),
                TextColumn::make('updated_at')
                    ->label('Diperbarui')
                    ->since(),
            ])
            ->defaultSort('sort')
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
            'index' => Pages\ListHeroSlides::route('/'),
            'create' => Pages\CreateHeroSlide::route('/create'),
            'edit' => Pages\EditHeroSlide::route('/{record}/edit'),
        ];
    }
}
