<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MenuItemResource\Pages;
use App\Models\MenuItem;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class MenuItemResource extends Resource
{
    protected static ?string $model = MenuItem::class;

    protected static ?string $navigationIcon = 'heroicon-o-cake';

    protected static ?string $navigationGroup = 'Menu & Produk';

    protected static ?string $navigationLabel = 'Menu Items';

    protected static ?string $modelLabel = 'Menu Item';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Informasi Menu')
                ->columns(2)
                ->schema([
                    Forms\Components\Select::make('brand_id')
                        ->label('Brand')
                        ->relationship('brand', 'name')
                        ->required()
                        ->live()
                        ->preload(),
                    Forms\Components\Select::make('menu_category_id')
                        ->label('Kategori')
                        ->relationship(
                            'category',
                            'name',
                            fn ($query, Forms\Get $get) => $query->when(
                                $get('brand_id'),
                                fn ($q, $brandId) => $q->where('brand_id', $brandId)
                            )
                        )
                        ->searchable()
                        ->preload(),
                    Forms\Components\TextInput::make('name')
                        ->required()
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn (Forms\Set $set, ?string $state) => $set('slug', Str::slug((string) $state))),
                    Forms\Components\TextInput::make('slug')
                        ->required()
                        ->helperText('Otomatis dari nama; boleh diubah.'),
                    Forms\Components\TextInput::make('short_description')
                        ->label('Deskripsi singkat')
                        ->maxLength(255)
                        ->columnSpanFull(),
                    Forms\Components\Textarea::make('description')
                        ->label('Deskripsi lengkap')
                        ->rows(3)
                        ->columnSpanFull(),
                ]),

            Forms\Components\Section::make('Harga & Gambar')
                ->columns(2)
                ->schema([
                    Forms\Components\TextInput::make('price')
                        ->label('Harga')
                        ->numeric()
                        ->prefix('Rp')
                        ->helperText('Kosongkan bila harga menyesuaikan.'),
                    Forms\Components\TextInput::make('discount_price')
                        ->label('Harga diskon')
                        ->numeric()
                        ->prefix('Rp'),
                    Forms\Components\TextInput::make('price_note')
                        ->label('Catatan harga')
                        ->placeholder('mis. per porsi'),
                    Forms\Components\FileUpload::make('image_path')
                        ->label('Foto menu')
                        ->image()
                        ->imageEditor()
                        ->directory('menu')
                        ->maxSize(4096),
                    Forms\Components\TextInput::make('image_alt')
                        ->label('Alt text gambar (SEO)')
                        ->maxLength(255),
                    Forms\Components\FileUpload::make('gallery')
                        ->label('Galeri tambahan')
                        ->image()
                        ->multiple()
                        ->reorderable()
                        ->directory('menu/gallery')
                        ->maxSize(4096)
                        ->columnSpanFull(),
                ]),

            Forms\Components\Section::make('Label & CTA')
                ->columns(3)
                ->schema([
                    Forms\Components\Toggle::make('is_available')->label('Tersedia')->default(true),
                    Forms\Components\Toggle::make('is_favorite')->label('Favorit'),
                    Forms\Components\Toggle::make('is_best_seller')->label('Best seller'),
                    Forms\Components\Toggle::make('is_spicy')->label('Pedas'),
                    Forms\Components\Toggle::make('is_new')->label('Baru'),
                    Forms\Components\TextInput::make('sort_order')->label('Urutan')->numeric()->default(0),
                    Forms\Components\TextInput::make('cta_label')
                        ->label('Label tombol')
                        ->placeholder('Pesan via WhatsApp'),
                    Forms\Components\Textarea::make('wa_message_template')
                        ->label('Template pesan WhatsApp')
                        ->rows(2)
                        ->placeholder('Halo, saya ingin pesan {name} ...')
                        ->helperText('Gunakan {name} untuk menyisipkan nama menu.')
                        ->columnSpan(2),
                ]),

            Forms\Components\Section::make('SEO (opsional)')
                ->collapsed()
                ->schema([
                    Forms\Components\TextInput::make('meta_title'),
                    Forms\Components\Textarea::make('meta_description')->rows(2),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->columns([
                Tables\Columns\ImageColumn::make('image_path')->label('Foto')->square(),
                Tables\Columns\TextColumn::make('name')->label('Nama')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('brand.name')->label('Brand')->badge()->sortable(),
                Tables\Columns\TextColumn::make('category.name')->label('Kategori')->sortable()->toggleable(),
                Tables\Columns\TextColumn::make('price')->label('Harga')->money('IDR')->placeholder('menyesuaikan')->sortable(),
                Tables\Columns\IconColumn::make('is_favorite')->label('Favorit')->boolean(),
                Tables\Columns\IconColumn::make('is_best_seller')->label('Best')->boolean(),
                Tables\Columns\IconColumn::make('is_available')->label('Aktif')->boolean(),
                Tables\Columns\TextColumn::make('sort_order')->label('Urutan')->sortable()->toggleable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('brand')->relationship('brand', 'name'),
                Tables\Filters\SelectFilter::make('category')->relationship('category', 'name'),
                Tables\Filters\TernaryFilter::make('is_available')->label('Tersedia'),
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMenuItems::route('/'),
            'create' => Pages\CreateMenuItem::route('/create'),
            'edit' => Pages\EditMenuItem::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([\Illuminate\Database\Eloquent\SoftDeletingScope::class]);
    }
}
