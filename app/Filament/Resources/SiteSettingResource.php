<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SiteSettingResource\Pages;
use App\Models\SiteSetting;
use Filament\Forms;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SiteSettingResource extends Resource
{
    protected static ?string $model = SiteSetting::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationGroup = 'Konfigurasi';

    protected static ?string $modelLabel = 'Pengaturan Situs';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Identitas Direktorat')
                    ->description('Informasi utama sesuai standar konten Direktorat Telkom University.')
                    ->schema([
                        Tabs::make('identity_translations')
                            ->tabs([
                                Tab::make('Bahasa Indonesia')
                                    ->schema([
                                        TextInput::make('name.id')
                                            ->label('Nama Direktorat')
                                            ->required()
                                            ->maxLength(255),
                                        TextInput::make('tagline.id')
                                            ->label('Tagline')
                                            ->maxLength(255),
                                        Textarea::make('short_description.id')
                                            ->label('Deskripsi Singkat')
                                            ->rows(3),
                                        RichEditor::make('about.id')
                                            ->label('Tentang Direktorat')
                                            ->columnSpanFull(),
                                        RichEditor::make('vision.id')
                                            ->label('Visi')
                                            ->columnSpanFull(),
                                        RichEditor::make('mission.id')
                                            ->label('Misi')
                                            ->columnSpanFull(),
                                    ])
                                    ->columns(2),
                                Tab::make('English')
                                    ->schema([
                                        TextInput::make('name.en')
                                            ->label('Directorate Name')
                                            ->maxLength(255),
                                        TextInput::make('tagline.en')
                                            ->label('Tagline (EN)')
                                            ->maxLength(255),
                                        Textarea::make('short_description.en')
                                            ->label('Brief Description')
                                            ->rows(3),
                                        RichEditor::make('about.en')
                                            ->label('About Directorate')
                                            ->columnSpanFull(),
                                        RichEditor::make('vision.en')
                                            ->label('Vision')
                                            ->columnSpanFull(),
                                        RichEditor::make('mission.en')
                                            ->label('Mission')
                                            ->columnSpanFull(),
                                    ])
                                    ->columns(2),
                            ])
                            ->columnSpanFull(),
                        FileUpload::make('logo_path')
                            ->label('Logo Utama')
                            ->image()
                            ->directory('site-settings')
                            ->imageEditor()
                            ->maxSize(1024)
                            ->columnSpan(1),
                        FileUpload::make('dark_logo_path')
                            ->label('Logo Versi Gelap')
                            ->image()
                            ->directory('site-settings')
                            ->imageEditor()
                            ->maxSize(1024)
                            ->columnSpan(1),
                        TextInput::make('presskit_url')
                            ->label('Pranala Press Kit')
                            ->url()
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
                Section::make('Kontak & Operasional')
                    ->schema([
                        TextInput::make('email')
                            ->label('Email Utama')
                            ->email(),
                        TextInput::make('phone')
                            ->label('Telepon Kantor'),
                        TextInput::make('whatsapp')
                            ->label('Hotline WhatsApp'),
                        TextInput::make('hotline')
                            ->label('Hotline Kebijakan'),
                        TextInput::make('feedback_email')
                            ->label('Email Feedback')
                            ->email(),
                        TextInput::make('feedback_url')
                            ->label('URL Form Feedback')
                            ->url(),
                        TextInput::make('sso_login_url')
                            ->label('URL Login SSO')
                            ->url(),
                        TextInput::make('office_hours')
                            ->label('Jam Operasional')
                            ->maxLength(255),
                    ])
                    ->columns(2),
                Section::make('Alamat & Peta')
                    ->schema([
                        Tabs::make('address_translations')
                            ->tabs([
                                Tab::make('Bahasa Indonesia')
                                    ->schema([
                                        Textarea::make('address.id')
                                            ->label('Alamat')
                                            ->rows(3),
                                    ]),
                                Tab::make('English')
                                    ->schema([
                                        Textarea::make('address.en')
                                            ->label('Address')
                                            ->rows(3),
                                    ]),
                            ])
                            ->columnSpanFull(),
                        Textarea::make('map_embed')
                            ->label('Iframe Peta (Embed)')
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),
                Section::make('Branding Digital')
                    ->schema([
                        ColorPicker::make('primary_color')
                            ->label('Warna Primer'),
                        ColorPicker::make('secondary_color')
                            ->label('Warna Sekunder'),
                        TextInput::make('facebook_url')
                            ->label('Facebook')
                            ->url(),
                        TextInput::make('instagram_url')
                            ->label('Instagram')
                            ->url(),
                        TextInput::make('linkedin_url')
                            ->label('LinkedIn')
                            ->url(),
                        TextInput::make('twitter_url')
                            ->label('X (Twitter)')
                            ->url(),
                        TextInput::make('youtube_url')
                            ->label('YouTube')
                            ->url(),
                        TextInput::make('tiktok_url')
                            ->label('TikTok')
                            ->url(),
                    ])
                    ->columns(2),
                Section::make('SEO Metadata')
                    ->schema([
                        Tabs::make('meta_translations')
                            ->tabs([
                                Tab::make('Bahasa Indonesia')
                                    ->schema([
                                        Textarea::make('meta_description.id')
                                            ->label('Meta Description')
                                            ->rows(3),
                                        Textarea::make('meta_keywords.id')
                                            ->label('Meta Keywords (pisahkan dengan koma)')
                                            ->rows(2),
                                    ]),
                                Tab::make('English')
                                    ->schema([
                                        Textarea::make('meta_description.en')
                                            ->label('Meta Description (EN)')
                                            ->rows(3),
                                        Textarea::make('meta_keywords.en')
                                            ->label('Meta Keywords (EN)')
                                            ->rows(2),
                                    ]),
                            ])
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name.id')
                    ->label('Nama Situs')
                    ->limit(30)
                    ->searchable(),
                TextColumn::make('email')
                    ->label('Email')
                    ->icon('heroicon-m-envelope'),
                TextColumn::make('phone')
                    ->label('Telepon')
                    ->icon('heroicon-m-phone'),
                TextColumn::make('updated_at')
                    ->label('Diperbarui')
                    ->dateTime('d M Y H:i'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                // Pengaturan situs tidak mendukung aksi massal
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSiteSettings::route('/'),
            'create' => Pages\CreateSiteSetting::route('/create'),
            'edit' => Pages\EditSiteSetting::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return SiteSetting::query()->doesntExist();
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name'];
    }
}
