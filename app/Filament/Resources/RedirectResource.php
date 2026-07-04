<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RedirectResource\Pages;
use App\Models\Redirect;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class RedirectResource extends Resource
{
    protected static ?string $model = Redirect::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-path-rounded-square';

    protected static ?string $navigationGroup = 'SEO & Teknis';

    protected static ?string $navigationLabel = 'Redirects';

    protected static ?string $modelLabel = 'Redirect';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('old_path')->label('Path lama')->required()
                ->placeholder('/pempek')->helperText('Diawali "/" tanpa domain.'),
            Forms\Components\TextInput::make('new_path')->label('Tujuan')->required()
                ->placeholder('/pempek-tince'),
            Forms\Components\Select::make('status_code')->label('Kode')->options([
                301 => '301 (permanen)', 302 => '302 (sementara)',
            ])->default(301)->required(),
            Forms\Components\Toggle::make('is_active')->label('Aktif')->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('old_path')->label('Dari')->searchable(),
                Tables\Columns\TextColumn::make('new_path')->label('Ke')->searchable(),
                Tables\Columns\TextColumn::make('status_code')->label('Kode')->badge(),
                Tables\Columns\TextColumn::make('hits')->label('Hits')->sortable(),
                Tables\Columns\IconColumn::make('is_active')->label('Aktif')->boolean(),
            ])
            ->actions([Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make()])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRedirects::route('/'),
            'create' => Pages\CreateRedirect::route('/create'),
            'edit' => Pages\EditRedirect::route('/{record}/edit'),
        ];
    }
}
