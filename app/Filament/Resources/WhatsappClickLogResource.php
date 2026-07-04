<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WhatsappClickLogResource\Pages;
use App\Models\WhatsappClickLog;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class WhatsappClickLogResource extends Resource
{
    protected static ?string $model = WhatsappClickLog::class;

    protected static ?string $navigationIcon = 'heroicon-o-cursor-arrow-ripple';

    protected static ?string $navigationGroup = 'Leads & WhatsApp';

    protected static ?string $navigationLabel = 'WhatsApp Clicks';

    protected static ?string $modelLabel = 'Klik WhatsApp';

    protected static ?int $navigationSort = 4;

    public static function canCreate(): bool
    {
        return false;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('created_at')->label('Waktu')->dateTime()->sortable(),
                Tables\Columns\TextColumn::make('button_label')->label('Tombol')->searchable(),
                Tables\Columns\TextColumn::make('brand_key')->label('Brand')->badge(),
                Tables\Columns\TextColumn::make('source_page')->label('Halaman')->searchable()->limit(40),
                Tables\Columns\TextColumn::make('destination_number')->label('Tujuan'),
                Tables\Columns\TextColumn::make('message_preview')->label('Pesan')->limit(40)->toggleable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('brand_key')->label('Brand')->options([
                    'pondok-tince' => 'Pondok Tince', 'pempek-tince' => 'Pempek Tince',
                ]),
            ])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWhatsappClickLogs::route('/'),
        ];
    }
}
