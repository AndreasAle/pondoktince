<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductPackageResource\Pages;
use App\Models\Brand;
use App\Models\ProductPackage;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class ProductPackageResource extends Resource
{
    protected static ?string $model = ProductPackage::class;

    protected static ?string $navigationIcon = 'heroicon-o-gift';

    protected static ?string $navigationGroup = 'Menu & Produk';

    protected static ?string $navigationLabel = 'Paket Produk (Pempek)';

    protected static ?string $modelLabel = 'Paket Produk';

    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Paket')
                ->columns(2)
                ->schema([
                    Forms\Components\Select::make('brand_id')
                        ->label('Brand')
                        ->relationship('brand', 'name')
                        ->default(fn () => Brand::where('key', Brand::KEY_PEMPEK)->value('id'))
                        ->required()
                        ->preload(),
                    Forms\Components\TextInput::make('name')
                        ->label('Nama paket')
                        ->required()
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn (Forms\Set $set, ?string $s) => $set('slug', Str::slug((string) $s))),
                    Forms\Components\TextInput::make('slug')->required(),
                    Forms\Components\TextInput::make('price')->label('Harga')->numeric()->prefix('Rp')
                        ->helperText('Kosongkan bila menyesuaikan.'),
                    Forms\Components\TextInput::make('price_note')->label('Catatan harga'),
                    Forms\Components\Textarea::make('description')->label('Deskripsi')->rows(3)->columnSpanFull(),
                    Forms\Components\Repeater::make('contents')
                        ->label('Isi paket')
                        ->simple(Forms\Components\TextInput::make('item')->placeholder('mis. 10 pempek lenjer'))
                        ->addActionLabel('Tambah item')
                        ->columnSpanFull(),
                ]),

            Forms\Components\Section::make('Gambar & Status')
                ->columns(2)
                ->schema([
                    Forms\Components\FileUpload::make('image_path')->label('Foto paket')->image()->imageEditor()
                        ->directory('packages')->maxSize(4096),
                    Forms\Components\TextInput::make('image_alt')->label('Alt text (SEO)'),
                    Forms\Components\Toggle::make('is_active')->label('Aktif')->default(true),
                    Forms\Components\Toggle::make('is_frozen')->label('Frozen'),
                    Forms\Components\Toggle::make('is_recommended')->label('Rekomendasi'),
                    Forms\Components\TextInput::make('sort_order')->label('Urutan')->numeric()->default(0),
                    Forms\Components\TextInput::make('cta_label')->label('Label tombol')->placeholder('Pesan Pempek'),
                    Forms\Components\Textarea::make('wa_message_template')->label('Template pesan WhatsApp')->rows(2)
                        ->helperText('Gunakan {name} untuk nama paket.'),
                ]),

            Forms\Components\Section::make('SEO (opsional)')->collapsed()->schema([
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
                Tables\Columns\TextColumn::make('brand.name')->label('Brand')->badge(),
                Tables\Columns\TextColumn::make('price')->label('Harga')->money('IDR')->placeholder('menyesuaikan'),
                Tables\Columns\IconColumn::make('is_frozen')->label('Frozen')->boolean(),
                Tables\Columns\IconColumn::make('is_recommended')->label('Rekom')->boolean(),
                Tables\Columns\IconColumn::make('is_active')->label('Aktif')->boolean(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('brand')->relationship('brand', 'name'),
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
            'index' => Pages\ListProductPackages::route('/'),
            'create' => Pages\CreateProductPackage::route('/create'),
            'edit' => Pages\EditProductPackage::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->withoutGlobalScopes([SoftDeletingScope::class]);
    }
}
