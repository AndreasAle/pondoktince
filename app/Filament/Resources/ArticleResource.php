<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ArticleResource\Pages;
use App\Models\Article;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class ArticleResource extends Resource
{
    protected static ?string $model = Article::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    protected static ?string $navigationGroup = 'Blog / Artikel';

    protected static ?string $navigationLabel = 'Artikel';

    protected static ?string $modelLabel = 'Artikel';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Konten')->columns(2)->schema([
                Forms\Components\TextInput::make('title')->label('Judul')->required()->columnSpanFull()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (Forms\Set $set, ?string $s) => $set('slug', Str::slug((string) $s))),
                Forms\Components\TextInput::make('slug')->required()->unique(ignoreRecord: true),
                Forms\Components\Select::make('article_category_id')->label('Kategori')->relationship('category', 'name')->searchable()->preload()->createOptionForm([
                    Forms\Components\TextInput::make('name')->required()->live(onBlur: true)
                        ->afterStateUpdated(fn (Forms\Set $set, ?string $s) => $set('slug', Str::slug((string) $s))),
                    Forms\Components\TextInput::make('slug')->required(),
                ]),
                Forms\Components\Select::make('brand_scope')->label('Brand')->options([
                    'global' => 'Global', 'pondok-tince' => 'Pondok Tince', 'pempek-tince' => 'Pempek Tince',
                ])->default('global')->required(),
                Forms\Components\TextInput::make('author')->label('Penulis')->default('Tim Pondok Tince'),
                Forms\Components\Textarea::make('excerpt')->label('Ringkasan')->rows(2)->columnSpanFull(),
                Forms\Components\RichEditor::make('content')->label('Isi artikel')->columnSpanFull(),
                Forms\Components\FileUpload::make('featured_image_path')->label('Gambar utama')->image()->imageEditor()->directory('articles')->maxSize(4096),
                Forms\Components\TextInput::make('featured_image_alt')->label('Alt text gambar (SEO)'),
                Forms\Components\TextInput::make('reading_time')->label('Waktu baca (menit)')->numeric(),
            ]),

            Forms\Components\Section::make('SEO')->columns(2)->collapsed()->schema([
                Forms\Components\TextInput::make('focus_keyword')->label('Focus keyword'),
                Forms\Components\TextInput::make('canonical_url')->label('Canonical URL'),
                Forms\Components\TextInput::make('meta_title')->label('Meta title'),
                Forms\Components\Textarea::make('meta_description')->label('Meta description')->rows(2),
                Forms\Components\TextInput::make('og_title')->label('OG title'),
                Forms\Components\Textarea::make('og_description')->label('OG description')->rows(2),
                Forms\Components\FileUpload::make('og_image_path')->label('OG image')->image()->directory('articles/og'),
                Forms\Components\Toggle::make('noindex')->label('Noindex'),
            ]),

            Forms\Components\Section::make('Publikasi')->columns(2)->schema([
                Forms\Components\Toggle::make('is_published')->label('Terbit'),
                Forms\Components\DateTimePicker::make('published_at')->label('Tanggal terbit')->default(now()),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('published_at', 'desc')
            ->columns([
                Tables\Columns\ImageColumn::make('featured_image_path')->label('Gambar')->square(),
                Tables\Columns\TextColumn::make('title')->label('Judul')->searchable()->limit(50),
                Tables\Columns\TextColumn::make('category.name')->label('Kategori')->badge()->toggleable(),
                Tables\Columns\TextColumn::make('brand_scope')->label('Brand')->badge()->toggleable(),
                Tables\Columns\IconColumn::make('is_published')->label('Terbit')->boolean(),
                Tables\Columns\TextColumn::make('published_at')->label('Tgl')->date()->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')->relationship('category', 'name'),
                Tables\Filters\TernaryFilter::make('is_published')->label('Terbit'),
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make()])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make(),
                Tables\Actions\ForceDeleteBulkAction::make(),
                Tables\Actions\RestoreBulkAction::make(),
            ])]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListArticles::route('/'),
            'create' => Pages\CreateArticle::route('/create'),
            'edit' => Pages\EditArticle::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->withoutGlobalScopes([SoftDeletingScope::class]);
    }
}
