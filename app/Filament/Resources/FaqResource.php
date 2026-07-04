<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FaqResource\Pages;
use App\Models\Faq;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class FaqResource extends Resource
{
    protected static ?string $model = Faq::class;

    protected static ?string $navigationIcon = 'heroicon-o-question-mark-circle';

    protected static ?string $navigationGroup = 'Media & Sosial Proof';

    protected static ?string $navigationLabel = 'FAQ';

    protected static ?string $modelLabel = 'FAQ';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('question')->label('Pertanyaan')->required()->columnSpanFull(),
            Forms\Components\Textarea::make('answer')->label('Jawaban')->rows(3)->required()->columnSpanFull(),
            Forms\Components\Select::make('brand_id')->label('Brand')->relationship('brand', 'name')->preload(),
            Forms\Components\Select::make('page_id')->label('Halaman terkait (opsional)')->relationship('page', 'title')->searchable()->preload(),
            Forms\Components\TextInput::make('group')->label('Grup')->placeholder('mis. lokasi, pempek')
                ->helperText('Untuk mengelompokkan FAQ pada satu halaman.'),
            Forms\Components\TextInput::make('sort_order')->label('Urutan')->numeric()->default(0),
            Forms\Components\Toggle::make('is_active')->label('Aktif')->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->columns([
                Tables\Columns\TextColumn::make('question')->label('Pertanyaan')->searchable()->limit(60),
                Tables\Columns\TextColumn::make('group')->label('Grup')->badge()->toggleable(),
                Tables\Columns\TextColumn::make('brand.name')->label('Brand')->toggleable(),
                Tables\Columns\TextColumn::make('page.title')->label('Halaman')->toggleable(),
                Tables\Columns\IconColumn::make('is_active')->label('Aktif')->boolean(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('brand')->relationship('brand', 'name'),
                Tables\Filters\SelectFilter::make('page')->relationship('page', 'title'),
            ])
            ->actions([Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make()])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
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
