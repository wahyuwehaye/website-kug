<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LeadershipMessageResource\Pages;
use App\Models\LeadershipMessage;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
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

class LeadershipMessageResource extends Resource
{
    protected static ?string $model = LeadershipMessage::class;

    protected static ?string $navigationIcon = 'heroicon-o-identification';

    protected static ?string $navigationGroup = 'Konten Landing Page';

    protected static ?string $modelLabel = 'Sambutan Pimpinan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Profil Pimpinan')
                    ->schema([
                        TextInput::make('leader_name')
                            ->label('Nama')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('leader_title')
                            ->label('Jabatan')
                            ->maxLength(255),
                        TextInput::make('contact_email')
                            ->label('Email')
                            ->email(),
                        TextInput::make('contact_phone')
                            ->label('Telepon / WhatsApp'),
                        FileUpload::make('photo_path')
                            ->label('Foto Pimpinan')
                            ->directory('leadership')
                            ->image()
                            ->imageEditor()
                            ->maxSize(2048),
                        FileUpload::make('signature_path')
                            ->label('Tanda Tangan Digital')
                            ->directory('leadership')
                            ->image()
                            ->maxSize(1024),
                        Toggle::make('is_active')
                            ->label('Tampilkan di Landing Page')
                            ->default(true),
                    ])
                    ->columns(2),
                Section::make('Isi Sambutan')
                    ->schema([
                        Tabs::make('message_translations')
                            ->tabs([
                                Tab::make('Bahasa Indonesia')
                                    ->schema([
                                        RichEditor::make('message.id')
                                            ->label('Pesan Pimpinan')
                                            ->required(),
                                    ]),
                                Tab::make('English')
                                    ->schema([
                                        RichEditor::make('message.en')
                                            ->label('Leadership Message (EN)'),
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
                ImageColumn::make('photo_path')
                    ->label('Foto')
                    ->circular(),
                TextColumn::make('leader_name')
                    ->label('Nama')
                    ->searchable(),
                TextColumn::make('leader_title')
                    ->label('Jabatan'),
                IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),
                TextColumn::make('updated_at')
                    ->label('Diperbarui')
                    ->since(),
            ])
            ->defaultSort('updated_at', 'desc')
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
            'index' => Pages\ListLeadershipMessages::route('/'),
            'create' => Pages\CreateLeadershipMessage::route('/create'),
            'edit' => Pages\EditLeadershipMessage::route('/{record}/edit'),
        ];
    }
}
