<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PageResource\Pages;
use App\Filament\Resources\PageResource\RelationManagers\SectionsRelationManager;
use App\Models\Page;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class PageResource extends Resource
{
    protected static ?string $model = Page::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = 'Konten Website';

    protected static ?string $navigationLabel = 'Halaman';

    protected static ?string $modelLabel = 'Halaman';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Tabs::make()->columnSpanFull()->tabs([

                Forms\Components\Tabs\Tab::make('Konten')->schema([
                    Forms\Components\TextInput::make('title')->label('Judul')->required()
                        ->live(onBlur: true)
                        ->afterStateUpdated(function (Forms\Set $set, Forms\Get $get, ?string $s) {
                            if (blank($get('slug'))) {
                                $set('slug', Str::slug((string) $s));
                            }
                        }),
                    Forms\Components\TextInput::make('slug')->label('Slug (path)')->required()->unique(ignoreRecord: true)
                        ->helperText('Path relatif, mis. kuliner-palembang atau pempek-tince/menu'),
                    Forms\Components\Grid::make(2)->schema([
                        Forms\Components\Select::make('brand_scope')->label('Brand')->options([
                            'global' => 'Global', 'pondok-tince' => 'Pondok Tince', 'pempek-tince' => 'Pempek Tince',
                        ])->default('global')->required(),
                        Forms\Components\Select::make('page_type')->label('Tipe halaman')->options([
                            'normal' => 'Normal', 'seo_pillar' => 'SEO Pillar', 'landing' => 'Landing',
                            'legal' => 'Legal', 'custom' => 'Custom',
                        ])->default('normal')->required(),
                    ]),
                    Forms\Components\RichEditor::make('intro_content')->label('Konten intro / body SEO')->columnSpanFull(),
                    Forms\Components\TextInput::make('view_key')->label('View key (opsional)')
                        ->helperText('Isi hanya bila halaman ini di-bind ke template Blade khusus (mis. home, pempek_tince).'),
                ]),

                Forms\Components\Tabs\Tab::make('Keunggulan & Langkah')->schema([
                    Forms\Components\Placeholder::make('fs_hint')->label('')
                        ->content('Dipakai pada halaman landing seperti Pempek Tince — untuk bagian "Keunggulan" dan "Cara Order".'),
                    Forms\Components\Repeater::make('features')
                        ->label('Keunggulan (kartu ikon)')
                        ->schema([
                            Forms\Components\Select::make('icon')->label('Ikon')->options([
                                'fish' => 'Ikan', 'fire' => 'Api / Pedas', 'gift' => 'Hadiah / Oleh-oleh',
                                'chat' => 'Chat', 'snowflake' => 'Frozen', 'star' => 'Bintang',
                                'truck' => 'Kirim', 'heart' => 'Hati', 'check-circle' => 'Centang',
                                'utensils' => 'Sendok-Garpu', 'sparkle' => 'Sparkle',
                            ])->default('star')->required(),
                            Forms\Components\TextInput::make('title')->label('Judul')->required(),
                        ])
                        ->columns(2)->reorderable()->collapsible()->addActionLabel('Tambah keunggulan')
                        ->itemLabel(fn (array $state): ?string => $state['title'] ?? null),
                    Forms\Components\Repeater::make('steps')
                        ->label('Cara Order (langkah)')
                        ->schema([
                            Forms\Components\TextInput::make('title')->label('Langkah')->required(),
                        ])
                        ->reorderable()->addActionLabel('Tambah langkah')
                        ->itemLabel(fn (array $state): ?string => $state['title'] ?? null),
                ]),

                Forms\Components\Tabs\Tab::make('Hero')->schema([
                    Forms\Components\TextInput::make('hero_title')->label('Judul hero'),
                    Forms\Components\Textarea::make('hero_subtitle')->label('Subjudul hero')->rows(2),
                    Forms\Components\FileUpload::make('hero_image_path')->label('Gambar hero')->image()->imageEditor()->directory('pages')->maxSize(4096),
                    Forms\Components\Grid::make(2)->schema([
                        Forms\Components\TextInput::make('hero_cta_label')->label('Label tombol hero'),
                        Forms\Components\TextInput::make('hero_cta_url')->label('URL tombol hero'),
                    ]),
                ]),

                Forms\Components\Tabs\Tab::make('SEO')->schema([
                    Forms\Components\TextInput::make('focus_keyword')->label('Focus keyword'),
                    Forms\Components\TextInput::make('meta_title')->label('Meta title')
                        ->helperText('Kosongkan untuk auto: Judul + nama brand.'),
                    Forms\Components\Textarea::make('meta_description')->label('Meta description')->rows(2)
                        ->helperText('Kosongkan untuk auto dari intro.'),
                    Forms\Components\TextInput::make('canonical_url')->label('Canonical URL')
                        ->helperText('Kosongkan untuk default (URL halaman).'),
                    Forms\Components\Grid::make(2)->schema([
                        Forms\Components\TextInput::make('og_title')->label('OG title'),
                        Forms\Components\FileUpload::make('og_image_path')->label('OG image')->image()->directory('pages/og'),
                    ]),
                    Forms\Components\Textarea::make('og_description')->label('OG description')->rows(2),
                    Forms\Components\TextInput::make('breadcrumb_title')->label('Judul breadcrumb'),
                    Forms\Components\Select::make('schema_type')->label('Schema type')->options([
                        'WebPage' => 'WebPage', 'Restaurant' => 'Restaurant', 'FoodEstablishment' => 'FoodEstablishment',
                        'Product' => 'Product', 'FAQPage' => 'FAQPage', 'Article' => 'Article',
                    ])->native(false),
                    Forms\Components\Grid::make(2)->schema([
                        Forms\Components\Toggle::make('noindex')->label('Noindex'),
                        Forms\Components\Toggle::make('nofollow')->label('Nofollow'),
                    ]),
                ]),

                Forms\Components\Tabs\Tab::make('Sitemap & Publikasi')->schema([
                    Forms\Components\Grid::make(2)->schema([
                        Forms\Components\Toggle::make('is_published')->label('Terbit')->default(false),
                        Forms\Components\DateTimePicker::make('published_at')->label('Tanggal terbit')->default(now()),
                    ]),
                    Forms\Components\Toggle::make('in_sitemap')->label('Sertakan di sitemap')->default(true),
                    Forms\Components\Grid::make(2)->schema([
                        Forms\Components\TextInput::make('sitemap_priority')->label('Prioritas sitemap')->numeric()
                            ->minValue(0)->maxValue(1)->step(0.1)->default(0.5),
                        Forms\Components\Select::make('sitemap_frequency')->label('Frekuensi')->options([
                            'always' => 'always', 'hourly' => 'hourly', 'daily' => 'daily',
                            'weekly' => 'weekly', 'monthly' => 'monthly', 'yearly' => 'yearly', 'never' => 'never',
                        ])->default('weekly'),
                    ]),
                    Forms\Components\TextInput::make('sort_order')->label('Urutan')->numeric()->default(0),
                ]),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('sort_order')
            ->columns([
                Tables\Columns\TextColumn::make('title')->label('Judul')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('slug')->label('Slug')->badge()->color('gray')->searchable(),
                Tables\Columns\TextColumn::make('brand_scope')->label('Brand')->badge()->toggleable(),
                Tables\Columns\TextColumn::make('page_type')->label('Tipe')->badge()->toggleable(),
                Tables\Columns\IconColumn::make('is_published')->label('Terbit')->boolean(),
                Tables\Columns\IconColumn::make('noindex')->label('Noindex')->boolean()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('brand_scope')->label('Brand')->options([
                    'global' => 'Global', 'pondok-tince' => 'Pondok Tince', 'pempek-tince' => 'Pempek Tince',
                ]),
                Tables\Filters\SelectFilter::make('page_type')->options([
                    'normal' => 'Normal', 'seo_pillar' => 'SEO Pillar', 'landing' => 'Landing', 'legal' => 'Legal', 'custom' => 'Custom',
                ]),
                Tables\Filters\TernaryFilter::make('is_published')->label('Terbit'),
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\Action::make('visit')
                    ->label('Lihat')
                    ->icon('heroicon-o-arrow-top-right-on-square')
                    ->url(fn (Page $r) => url('/'.ltrim($r->slug, '/')))
                    ->openUrlInNewTab(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make(),
                Tables\Actions\ForceDeleteBulkAction::make(),
                Tables\Actions\RestoreBulkAction::make(),
            ])]);
    }

    public static function getRelations(): array
    {
        return [
            SectionsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPages::route('/'),
            'create' => Pages\CreatePage::route('/create'),
            'edit' => Pages\EditPage::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->withoutGlobalScopes([SoftDeletingScope::class]);
    }
}
