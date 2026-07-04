<?php

namespace App\Filament\Resources\PageResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class SectionsRelationManager extends RelationManager
{
    protected static string $relationship = 'sections';

    protected static ?string $title = 'Section Halaman (Page Builder)';

    protected static ?string $recordTitleAttribute = 'title';

    public static array $types = [
        'hero' => 'Hero',
        'text' => 'Blok Teks',
        'image_text' => 'Gambar + Teks',
        'menu_grid' => 'Grid Menu',
        'product_grid' => 'Grid Produk/Paket',
        'gallery' => 'Galeri',
        'testimonial' => 'Testimoni',
        'faq' => 'FAQ',
        'cta' => 'Call To Action',
        'location_map' => 'Peta Lokasi',
        'brand_cards' => 'Kartu Brand',
        'article_list' => 'Daftar Artikel',
        'package_cards' => 'Kartu Paket',
        'seo_content' => 'Blok Konten SEO',
        'custom_html' => 'HTML Kustom',
    ];

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('type')->label('Tipe section')->options(static::$types)->required()->searchable(),
            Forms\Components\Grid::make(2)->schema([
                Forms\Components\TextInput::make('title')->label('Judul'),
                Forms\Components\TextInput::make('subtitle')->label('Subjudul'),
            ]),
            Forms\Components\RichEditor::make('content')->label('Konten')->columnSpanFull(),
            Forms\Components\FileUpload::make('image_path')->label('Gambar')->image()->directory('sections')->maxSize(4096),
            Forms\Components\Grid::make(2)->schema([
                Forms\Components\TextInput::make('button_label')->label('Label tombol'),
                Forms\Components\TextInput::make('button_url')->label('URL tombol'),
            ]),
            Forms\Components\Grid::make(3)->schema([
                Forms\Components\Select::make('background_style')->label('Gaya background')->options([
                    'default' => 'Default', 'muted' => 'Muted', 'dark' => 'Gelap', 'brand' => 'Brand',
                ])->default('default'),
                Forms\Components\TextInput::make('sort_order')->label('Urutan')->numeric()->default(0),
                Forms\Components\Toggle::make('is_active')->label('Aktif')->default(true),
            ]),
            Forms\Components\KeyValue::make('settings')->label('Pengaturan tambahan (opsional)')
                ->keyLabel('Kunci')->valueLabel('Nilai')
                ->helperText('mis. brand_key=pempek-tince, limit=6')
                ->columnSpanFull(),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->columns([
                Tables\Columns\TextColumn::make('sort_order')->label('#')->sortable(),
                Tables\Columns\TextColumn::make('type')->label('Tipe')->badge()
                    ->formatStateUsing(fn ($state) => static::$types[$state] ?? $state),
                Tables\Columns\TextColumn::make('title')->label('Judul')->limit(40),
                Tables\Columns\IconColumn::make('is_active')->label('Aktif')->boolean(),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()->label('Tambah section'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()]),
            ]);
    }
}
