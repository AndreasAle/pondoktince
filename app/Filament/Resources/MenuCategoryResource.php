<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MenuCategoryResource\Pages;
use App\Models\MenuCategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class MenuCategoryResource extends Resource
{
    protected static ?string $model = MenuCategory::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';

    protected static ?string $navigationGroup = 'Menu & Produk';

    protected static ?string $navigationLabel = 'Kategori Menu';

    protected static ?string $modelLabel = 'Kategori Menu';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('brand_id')->label('Brand')->relationship('brand', 'name')->required()->preload(),
            Forms\Components\TextInput::make('name')->label('Nama')->required()
                ->live(onBlur: true)
                ->afterStateUpdated(fn (Forms\Set $set, ?string $s) => $set('slug', Str::slug((string) $s))),
            Forms\Components\TextInput::make('slug')->required(),
            Forms\Components\Textarea::make('description')->label('Deskripsi')->rows(2)->columnSpanFull(),
            Forms\Components\FileUpload::make('image_path')->label('Gambar')->image()->directory('menu-categories')->maxSize(4096),
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
                Tables\Columns\TextColumn::make('name')->label('Nama')->searchable(),
                Tables\Columns\TextColumn::make('brand.name')->label('Brand')->badge(),
                Tables\Columns\TextColumn::make('items_count')->counts('items')->label('Jumlah menu'),
                Tables\Columns\IconColumn::make('is_active')->label('Aktif')->boolean(),
            ])
            ->filters([Tables\Filters\SelectFilter::make('brand')->relationship('brand', 'name')])
            ->actions([Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make()])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMenuCategories::route('/'),
            'create' => Pages\CreateMenuCategory::route('/create'),
            'edit' => Pages\EditMenuCategory::route('/{record}/edit'),
        ];
    }
}
