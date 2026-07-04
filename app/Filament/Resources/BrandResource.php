<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BrandResource\Pages;
use App\Models\Brand;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BrandResource extends Resource
{
    protected static ?string $model = Brand::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-storefront';

    protected static ?string $navigationGroup = 'Menu & Produk';

    protected static ?string $navigationLabel = 'Brands';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make()->columns(2)->schema([
                Forms\Components\TextInput::make('key')
                    ->label('Key (unik)')
                    ->helperText('mis. pondok-tince / pempek-tince. Dipakai di kode & URL.')
                    ->required()
                    ->unique(ignoreRecord: true),
                Forms\Components\TextInput::make('name')->label('Nama brand')->required(),
                Forms\Components\TextInput::make('brand_color')->label('Warna brand')->placeholder('#7a1f1f'),
                Forms\Components\TextInput::make('sort_order')->label('Urutan')->numeric()->default(0),
                Forms\Components\Textarea::make('description')->label('Deskripsi')->rows(3)->columnSpanFull(),
                Forms\Components\FileUpload::make('logo_path')->label('Logo')->image()->directory('brands')->maxSize(2048),
                Forms\Components\Toggle::make('is_active')->label('Aktif')->default(true),
                Forms\Components\TextInput::make('instagram')->label('Instagram URL')->url(),
                Forms\Components\TextInput::make('whatsapp_number')->label('Nomor WhatsApp')->tel()
                    ->helperText('Format internasional tanpa +, mis. 628123456789'),
                Forms\Components\Textarea::make('whatsapp_default_message')->label('Pesan WA default')->rows(2)->columnSpanFull(),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->columns([
                Tables\Columns\ImageColumn::make('logo_path')->label('Logo')->square(),
                Tables\Columns\TextColumn::make('name')->label('Nama')->searchable(),
                Tables\Columns\TextColumn::make('key')->label('Key')->badge(),
                Tables\Columns\TextColumn::make('whatsapp_number')->label('WhatsApp'),
                Tables\Columns\IconColumn::make('is_active')->label('Aktif')->boolean(),
            ])
            ->filters([Tables\Filters\TrashedFilter::make()])
            ->actions([Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make()])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBrands::route('/'),
            'create' => Pages\CreateBrand::route('/create'),
            'edit' => Pages\EditBrand::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->withoutGlobalScopes([SoftDeletingScope::class]);
    }
}
