<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactChannelResource\Pages;
use App\Models\ContactChannel;
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

class ContactChannelResource extends Resource
{
    protected static ?string $model = ContactChannel::class;

    protected static ?string $navigationIcon = 'heroicon-o-phone';

    protected static ?string $navigationGroup = 'Repositori Dokumen';

    protected static ?string $modelLabel = 'Kanal Kontak';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Detail Kanal Kontak')
                    ->schema([
                        Tabs::make('contact_translations')
                            ->tabs([
                                Tab::make('Bahasa Indonesia')
                                    ->schema([
                                        TextInput::make('name.id')
                                            ->label('Nama Kanal')
                                            ->required()
                                            ->maxLength(255),
                                        Textarea::make('notes.id')
                                            ->label('Catatan')
                                            ->rows(3),
                                    ]),
                                Tab::make('English')
                                    ->schema([
                                        TextInput::make('name.en')
                                            ->label('Channel Name')
                                            ->maxLength(255),
                                        Textarea::make('notes.en')
                                            ->label('Notes')
                                            ->rows(3),
                                    ]),
                            ])
                            ->columnSpanFull(),
                        Select::make('type')
                            ->label('Tipe Kanal')
                            ->options([
                                'hotline' => 'Hotline',
                                'phone' => 'Telepon',
                                'email' => 'Email',
                                'whatsapp' => 'WhatsApp',
                                'address' => 'Alamat',
                                'form' => 'Formulir',
                                'other' => 'Lainnya',
                            ])
                            ->required()
                            ->default('other'),
                        TextInput::make('value')
                            ->label('Nilai Kontak')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('icon')
                            ->label('Ikon (opsional)')
                            ->maxLength(100),
                        TextInput::make('sort')
                            ->label('Urutan')
                            ->numeric()
                            ->default(0),
                        Toggle::make('is_primary')
                            ->label('Prioritas utama'),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name.id')
                    ->label('Nama Kanal')
                    ->searchable()
                    ->limit(40),
                TextColumn::make('type')
                    ->label('Tipe')
                    ->badge(),
                TextColumn::make('value')
                    ->label('Kontak')
                    ->wrap(),
                IconColumn::make('is_primary')
                    ->label('Utama')
                    ->boolean(),
            ])
            ->defaultSort('sort')
            ->filters([
                SelectFilter::make('type')
                    ->label('Tipe')
                    ->options([
                        'hotline' => 'Hotline',
                        'phone' => 'Telepon',
                        'email' => 'Email',
                        'whatsapp' => 'WhatsApp',
                        'address' => 'Alamat',
                        'form' => 'Formulir',
                        'other' => 'Lainnya',
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
            'index' => Pages\ListContactChannels::route('/'),
            'create' => Pages\CreateContactChannel::route('/create'),
            'edit' => Pages\EditContactChannel::route('/{record}/edit'),
        ];
    }
}
