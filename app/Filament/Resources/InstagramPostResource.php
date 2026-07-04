<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InstagramPostResource\Pages;
use App\Models\InstagramPost;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class InstagramPostResource extends Resource
{
    protected static ?string $model = InstagramPost::class;

    protected static ?string $navigationIcon = 'heroicon-o-camera';

    protected static ?string $navigationGroup = 'Media & Sosial Proof';

    protected static ?string $navigationLabel = 'Instagram Feed';

    protected static ?string $modelLabel = 'Postingan Instagram';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Konten Instagram')
                ->description('Upload foto kontennya, lalu tempel link postingan Instagram aslinya. Tampil rapi sesuai tema website & nge-link ke Instagram.')
                ->columns(2)
                ->schema([
                    Forms\Components\FileUpload::make('image_path')
                        ->label('Foto konten')
                        ->image()->imageEditor()
                        ->directory('instagram')->maxSize(4096)
                        ->columnSpanFull(),
                    Forms\Components\TextInput::make('permalink')
                        ->label('Link postingan Instagram')
                        ->url()
                        ->placeholder('https://www.instagram.com/p/xxxxxxxx/')
                        ->columnSpanFull(),
                    Forms\Components\Textarea::make('caption')->label('Caption singkat')->rows(2)->columnSpanFull(),
                    Forms\Components\TextInput::make('image_alt')->label('Alt text (SEO)'),
                    Forms\Components\Select::make('brand_key')->label('Brand')->options([
                        'pondok-tince' => 'Pondok Tince',
                        'pempek-tince' => 'Pempek Tince',
                    ])->placeholder('Umum'),
                    Forms\Components\Toggle::make('is_reel')->label('Ini Reel / video'),
                    Forms\Components\Toggle::make('is_active')->label('Tampilkan')->default(true),
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
                Tables\Columns\ImageColumn::make('image_path')->label('Foto')->square(),
                Tables\Columns\TextColumn::make('caption')->label('Caption')->limit(50),
                Tables\Columns\IconColumn::make('is_reel')->label('Reel')->boolean()->toggleable(),
                Tables\Columns\TextColumn::make('brand_key')->label('Brand')->badge()->toggleable(),
                Tables\Columns\IconColumn::make('is_active')->label('Aktif')->boolean(),
            ])
            ->actions([Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make()])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListInstagramPosts::route('/'),
            'create' => Pages\CreateInstagramPost::route('/create'),
            'edit' => Pages\EditInstagramPost::route('/{record}/edit'),
        ];
    }
}
