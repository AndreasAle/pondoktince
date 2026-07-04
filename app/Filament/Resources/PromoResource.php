<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PromoResource\Pages;
use App\Models\Promo;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PromoResource extends Resource
{
    protected static ?string $model = Promo::class;

    protected static ?string $navigationIcon = 'heroicon-o-megaphone';

    protected static ?string $navigationGroup = 'Media & Sosial Proof';

    protected static ?string $navigationLabel = 'Promo / Banner';

    protected static ?string $modelLabel = 'Promo';

    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('title')->label('Judul')->required()->columnSpanFull(),
            Forms\Components\Textarea::make('description')->label('Deskripsi')->rows(2)->columnSpanFull(),
            Forms\Components\FileUpload::make('image_path')->label('Gambar')->image()->directory('promos')->maxSize(4096),
            Forms\Components\Select::make('brand_id')->label('Brand')->relationship('brand', 'name')->preload(),
            Forms\Components\TextInput::make('button_label')->label('Label tombol'),
            Forms\Components\TextInput::make('button_url')->label('URL tombol'),
            Forms\Components\DatePicker::make('start_date')->label('Mulai'),
            Forms\Components\DatePicker::make('end_date')->label('Selesai'),
            Forms\Components\TextInput::make('sort_order')->label('Urutan')->numeric()->default(0),
            Forms\Components\Toggle::make('is_active')->label('Aktif')->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('sort_order')
            ->columns([
                Tables\Columns\ImageColumn::make('image_path')->label('Gambar')->square(),
                Tables\Columns\TextColumn::make('title')->label('Judul')->searchable(),
                Tables\Columns\TextColumn::make('start_date')->label('Mulai')->date()->toggleable(),
                Tables\Columns\TextColumn::make('end_date')->label('Selesai')->date()->toggleable(),
                Tables\Columns\IconColumn::make('is_active')->label('Aktif')->boolean(),
            ])
            ->filters([Tables\Filters\SelectFilter::make('brand')->relationship('brand', 'name')])
            ->actions([Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make()])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPromos::route('/'),
            'create' => Pages\CreatePromo::route('/create'),
            'edit' => Pages\EditPromo::route('/{record}/edit'),
        ];
    }
}
