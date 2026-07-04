<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NavigationMenuResource\Pages;
use App\Models\NavigationMenu;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class NavigationMenuResource extends Resource
{
    protected static ?string $model = NavigationMenu::class;

    protected static ?string $navigationIcon = 'heroicon-o-bars-3';

    protected static ?string $navigationGroup = 'Konten Website';

    protected static ?string $navigationLabel = 'Menu Navigasi';

    protected static ?string $modelLabel = 'Item Navigasi';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('location')->label('Lokasi')->options([
                'header' => 'Header', 'footer' => 'Footer', 'mobile' => 'Mobile',
            ])->default('header')->required(),
            Forms\Components\TextInput::make('label')->label('Label')->required(),
            Forms\Components\TextInput::make('url')->label('URL')->required()->placeholder('/menu atau https://...'),
            Forms\Components\Select::make('parent_id')->label('Parent (opsional)')
                ->relationship('parent', 'label')->searchable()->preload(),
            Forms\Components\TextInput::make('sort_order')->label('Urutan')->numeric()->default(0),
            Forms\Components\Toggle::make('open_new_tab')->label('Buka tab baru'),
            Forms\Components\Toggle::make('is_active')->label('Aktif')->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->groups(['location'])
            ->columns([
                Tables\Columns\TextColumn::make('label')->label('Label')->searchable(),
                Tables\Columns\TextColumn::make('url')->label('URL'),
                Tables\Columns\TextColumn::make('location')->label('Lokasi')->badge(),
                Tables\Columns\TextColumn::make('parent.label')->label('Parent')->toggleable(),
                Tables\Columns\IconColumn::make('is_active')->label('Aktif')->boolean(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('location')->options([
                    'header' => 'Header', 'footer' => 'Footer', 'mobile' => 'Mobile',
                ]),
            ])
            ->actions([Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make()])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListNavigationMenus::route('/'),
            'create' => Pages\CreateNavigationMenu::route('/create'),
            'edit' => Pages\EditNavigationMenu::route('/{record}/edit'),
        ];
    }
}
