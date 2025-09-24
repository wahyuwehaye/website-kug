<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AnnouncementResource\Pages;
use App\Models\Announcement;
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

class AnnouncementResource extends Resource
{
    protected static ?string $model = Announcement::class;

    protected static ?string $navigationIcon = 'heroicon-o-megaphone';

    protected static ?string $navigationGroup = 'Manajemen Berita';

    protected static ?string $modelLabel = 'Pengumuman';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Konten Pengumuman')
                    ->schema([
                        Tabs::make('announcement_translations')
                            ->tabs([
                                Tab::make('Bahasa Indonesia')
                                    ->schema([
                                        TextInput::make('title.id')
                                            ->label('Judul')
                                            ->required()
                                            ->maxLength(255),
                                        Textarea::make('body.id')
                                            ->label('Isi Pengumuman')
                                            ->rows(5),
                                        TextInput::make('cta_label.id')
                                            ->label('Label Tombol')
                                            ->maxLength(120),
                                    ]),
                                Tab::make('English')
                                    ->schema([
                                        TextInput::make('title.en')
                                            ->label('Title')
                                            ->maxLength(255),
                                        Textarea::make('body.en')
                                            ->label('Announcement Body')
                                            ->rows(5),
                                        TextInput::make('cta_label.en')
                                            ->label('Button Label (EN)')
                                            ->maxLength(120),
                                    ]),
                            ])
                            ->columnSpanFull(),
                        TextInput::make('slug')
                            ->label('Slug')
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                        TextInput::make('cta_url')
                            ->label('URL Tindak Lanjut')
                            ->url()
                            ->maxLength(255),
                    ])
                    ->columns(2),
                Section::make('Penjadwalan & Status')
                    ->schema([
                        Select::make('type')
                            ->label('Tipe Pengumuman')
                            ->options([
                                'public' => 'Publik',
                                'internal' => 'Internal',
                                'alert' => 'Urgent Alert',
                            ])
                            ->default('public'),
                        Select::make('status')
                            ->label('Status')
                            ->options([
                                'draft' => 'Draft',
                                'published' => 'Publikasi',
                                'archived' => 'Arsip',
                            ])
                            ->default('draft'),
                        DateTimePicker::make('starts_at')
                            ->label('Mulai Berlaku')
                            ->seconds(false),
                        DateTimePicker::make('ends_at')
                            ->label('Berakhir')
                            ->seconds(false),
                        DateTimePicker::make('published_at')
                            ->label('Tanggal Publikasi')
                            ->seconds(false),
                        FileUpload::make('attachment_path')
                            ->label('Lampiran')
                            ->directory('announcements')
                            ->downloadable(),
                        Toggle::make('is_sticky')
                            ->label('Pin di bagian atas'),
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
                    ->limit(50),
                TextColumn::make('type')
                    ->label('Tipe')
                    ->badge(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge(),
                TextColumn::make('starts_at')
                    ->label('Mulai')
                    ->dateTime('d M Y H:i'),
                TextColumn::make('ends_at')
                    ->label('Selesai')
                    ->dateTime('d M Y H:i')
                    ->toggleable(isToggledHiddenByDefault: true),
                IconColumn::make('is_sticky')
                    ->label('Pin')
                    ->boolean(),
            ])
            ->defaultSort('starts_at', 'desc')
            ->filters([
                SelectFilter::make('type')
                    ->label('Tipe')
                    ->options([
                        'public' => 'Publik',
                        'internal' => 'Internal',
                        'alert' => 'Urgent Alert',
                    ]),
                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'draft' => 'Draft',
                        'published' => 'Publikasi',
                        'archived' => 'Arsip',
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
            'index' => Pages\ListAnnouncements::route('/'),
            'create' => Pages\CreateAnnouncement::route('/create'),
            'edit' => Pages\EditAnnouncement::route('/{record}/edit'),
        ];
    }
}
