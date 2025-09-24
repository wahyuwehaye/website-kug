<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FaqResource\Pages;
use App\Models\Faq;
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

class FaqResource extends Resource
{
    protected static ?string $model = Faq::class;

    protected static ?string $navigationIcon = 'heroicon-o-question-mark-circle';

    protected static ?string $navigationGroup = 'Repositori Dokumen';

    protected static ?string $modelLabel = 'FAQ Layanan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Pertanyaan & Jawaban')
                    ->schema([
                        Tabs::make('faq_translations')
                            ->tabs([
                                Tab::make('Bahasa Indonesia')
                                    ->schema([
                                        TextInput::make('question.id')
                                            ->label('Pertanyaan')
                                            ->required()
                                            ->maxLength(255),
                                        Textarea::make('answer.id')
                                            ->label('Jawaban')
                                            ->rows(4)
                                            ->required(),
                                    ]),
                                Tab::make('English')
                                    ->schema([
                                        TextInput::make('question.en')
                                            ->label('Question')
                                            ->maxLength(255),
                                        Textarea::make('answer.en')
                                            ->label('Answer')
                                            ->rows(4),
                                    ]),
                            ])
                            ->columnSpanFull(),
                        TextInput::make('category')
                            ->label('Kategori')
                            ->maxLength(120),
                        TextInput::make('display_order')
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
                TextColumn::make('question.id')
                    ->label('Pertanyaan')
                    ->searchable()
                    ->limit(60),
                TextColumn::make('category')
                    ->label('Kategori')
                    ->badge(),
                IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),
            ])
            ->defaultSort('display_order')
            ->filters([
                SelectFilter::make('category')
                    ->label('Kategori')
                    ->options(fn () => Faq::query()
                        ->select('category')
                        ->distinct()
                        ->pluck('category', 'category')
                        ->filter()),
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
            'index' => Pages\ListFaqs::route('/'),
            'create' => Pages\CreateFaq::route('/create'),
            'edit' => Pages\EditFaq::route('/{record}/edit'),
        ];
    }
}
