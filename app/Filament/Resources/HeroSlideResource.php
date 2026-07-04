<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HeroSlideResource\Pages;
use App\Models\HeroSlide;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class HeroSlideResource extends Resource
{
    protected static ?string $model = HeroSlide::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';

    protected static ?string $navigationGroup = 'Konten Website';

    protected static ?string $navigationLabel = 'Hero Carousel';

    protected static ?string $modelLabel = 'Slide Hero';

    protected static ?int $navigationSort = 0;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Gambar Background')
                ->description('Ukuran ideal 1920×900px (landscape). Overlay merah otomatis ditambahkan agar teks tetap terbaca.')
                ->schema([
                    Forms\Components\FileUpload::make('image_path')
                        ->label('Gambar slide')
                        ->image()
                        ->imageEditor()
                        ->directory('hero')
                        ->maxSize(6144)
                        ->columnSpanFull(),
                    Forms\Components\TextInput::make('image_alt')->label('Alt text (SEO)'),
                ]),

            Forms\Components\Section::make('Teks')
                ->columns(2)
                ->schema([
                    Forms\Components\TextInput::make('eyebrow')->label('Teks kecil (di atas judul)')
                        ->placeholder('Selamat Datang di Pondok Tince'),
                    Forms\Components\TextInput::make('title')->label('Judul utama')->required()->columnSpanFull(),
                    Forms\Components\Textarea::make('subtitle')->label('Subjudul')->rows(2)->columnSpanFull(),
                ]),

            Forms\Components\Section::make('Tombol (CTA)')
                ->columns(2)
                ->schema([
                    Forms\Components\TextInput::make('primary_label')->label('Tombol 1 — teks')->placeholder('Lihat Menu Kami'),
                    Forms\Components\TextInput::make('primary_url')->label('Tombol 1 — link')->placeholder('/menu'),
                    Forms\Components\TextInput::make('secondary_label')->label('Tombol 2 — teks')->placeholder('Pesan Pempek Tince'),
                    Forms\Components\TextInput::make('secondary_url')->label('Tombol 2 — link')->placeholder('/pempek-tince'),
                    Forms\Components\Toggle::make('show_whatsapp')->label('Tampilkan tombol WhatsApp')->default(true),
                    Forms\Components\TextInput::make('whatsapp_message')->label('Pesan WhatsApp otomatis')
                        ->placeholder('Halo Pondok Tince, saya ingin booking tempat.'),
                ]),

            Forms\Components\Section::make('Pengaturan')
                ->columns(2)
                ->schema([
                    Forms\Components\Toggle::make('is_active')->label('Aktif')->default(true),
                    Forms\Components\TextInput::make('sort_order')->label('Urutan')->numeric()->default(0),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->columns([
                Tables\Columns\ImageColumn::make('image_path')->label('Gambar')->square(),
                Tables\Columns\TextColumn::make('title')->label('Judul')->searchable()->limit(50),
                Tables\Columns\TextColumn::make('eyebrow')->label('Teks kecil')->limit(30)->toggleable(),
                Tables\Columns\IconColumn::make('show_whatsapp')->label('WA')->boolean()->toggleable(),
                Tables\Columns\IconColumn::make('is_active')->label('Aktif')->boolean(),
                Tables\Columns\TextColumn::make('sort_order')->label('Urutan')->sortable(),
            ])
            ->actions([Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make()])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHeroSlides::route('/'),
            'create' => Pages\CreateHeroSlide::route('/create'),
            'edit' => Pages\EditHeroSlide::route('/{record}/edit'),
        ];
    }
}
