<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NewsPostResource\Pages;
use App\Models\NewsCategory;
use App\Models\NewsPost;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
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
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class NewsPostResource extends Resource
{
    protected static ?string $model = NewsPost::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    protected static ?string $navigationGroup = 'Manajemen Berita';

    protected static ?string $modelLabel = 'Berita & Artikel';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi Konten')
                    ->schema([
                        Select::make('news_category_id')
                            ->label('Kategori')
                            ->options(NewsCategory::query()->pluck('name->id', 'id'))
                            ->searchable()
                            ->preload()
                            ->nullable(),
                        Tabs::make('news_translations')
                            ->tabs([
                                Tab::make('Bahasa Indonesia')
                                    ->schema([
                                        TextInput::make('title.id')
                                            ->label('Judul')
                                            ->required()
                                            ->maxLength(255),
                                        Textarea::make('excerpt.id')
                                            ->label('Ringkasan')
                                            ->rows(3),
                                        RichEditor::make('body.id')
                                            ->label('Konten')
                                            ->columnSpanFull(),
                                        Textarea::make('meta_description.id')
                                            ->label('Meta Description')
                                            ->rows(3),
                                        Textarea::make('meta_keywords.id')
                                            ->label('Meta Keywords (pisahkan dengan koma)')
                                            ->rows(2),
                                    ])
                                    ->columns(2),
                                Tab::make('English')
                                    ->schema([
                                        TextInput::make('title.en')
                                            ->label('Title')
                                            ->maxLength(255),
                                        Textarea::make('excerpt.en')
                                            ->label('Summary')
                                            ->rows(3),
                                        RichEditor::make('body.en')
                                            ->label('Content (EN)')
                                            ->columnSpanFull(),
                                        Textarea::make('meta_description.en')
                                            ->label('Meta Description (EN)')
                                            ->rows(3),
                                        Textarea::make('meta_keywords.en')
                                            ->label('Meta Keywords (EN)')
                                            ->rows(2),
                                    ])
                                    ->columns(2),
                            ])
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
                Section::make('Pengaturan Publikasi')
                    ->schema([
                        TextInput::make('slug')
                            ->label('Slug')
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                        TextInput::make('author_name')
                            ->label('Penulis')
                            ->maxLength(255),
                        TextInput::make('read_time_minutes')
                            ->label('Perkiraan Waktu Baca (menit)')
                            ->numeric()
                            ->default(3),
                        Select::make('status')
                            ->label('Status')
                            ->options([
                                'draft' => 'Draft',
                                'scheduled' => 'Terjadwal',
                                'published' => 'Publikasi',
                            ])
                            ->default('draft'),
                        DateTimePicker::make('published_at')
                            ->label('Tayang Pada')
                            ->seconds(false),
                        FileUpload::make('cover_image_path')
                            ->label('Gambar Sampul')
                            ->directory('news')
                            ->image()
                            ->imageEditor()
                            ->maxSize(4096),
                        FileUpload::make('attachment_path')
                            ->label('Lampiran')
                            ->directory('news/attachments')
                            ->downloadable(),
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
                ImageColumn::make('cover_image_path')
                    ->label('Sampul')
                    ->square(),
                TextColumn::make('title.id')
                    ->label('Judul')
                    ->searchable()
                    ->limit(40),
                TextColumn::make('category.name.id')
                    ->label('Kategori')
                    ->badge(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state) => match ($state) {
                        'published' => 'success',
                        'scheduled' => 'warning',
                        default => 'gray',
                    }),
                TextColumn::make('published_at')
                    ->label('Tayang')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
                IconColumn::make('is_featured')
                    ->label('Unggulan')
                    ->boolean(),
            ])
            ->defaultSort('published_at', 'desc')
            ->filters([
                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'draft' => 'Draft',
                        'scheduled' => 'Terjadwal',
                        'published' => 'Publikasi',
                    ]),
                SelectFilter::make('news_category_id')
                    ->label('Kategori')
                    ->options(NewsCategory::query()->pluck('name->id', 'id')),
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
            'index' => Pages\ListNewsPosts::route('/'),
            'create' => Pages\CreateNewsPost::route('/create'),
            'edit' => Pages\EditNewsPost::route('/{record}/edit'),
        ];
    }
}
