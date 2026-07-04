<?php

namespace App\Filament\Widgets;

use App\Models\BookingLead;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestBookingsWidget extends BaseWidget
{
    protected static ?int $sort = 2;

    protected int|string|array $columnSpan = 'full';

    protected static ?string $heading = 'Booking Leads Terbaru';

    public function table(Table $table): Table
    {
        return $table
            ->query(BookingLead::query()->latest())
            ->paginated([5, 10])
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Nama'),
                Tables\Columns\TextColumn::make('whatsapp_number')->label('WhatsApp'),
                Tables\Columns\TextColumn::make('date')->label('Tanggal')->date(),
                Tables\Columns\TextColumn::make('people_count')->label('Org'),
                Tables\Columns\TextColumn::make('purpose')->label('Keperluan')->limit(24),
                Tables\Columns\TextColumn::make('status')->label('Status')->badge()
                    ->color(fn ($state) => match ($state) {
                        'new' => 'warning', 'confirmed', 'done' => 'success', 'cancelled' => 'danger', default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('created_at')->label('Masuk')->since(),
            ])
            ->actions([
                Tables\Actions\Action::make('open')
                    ->label('Buka')
                    ->url(fn (BookingLead $r) => \App\Filament\Resources\BookingLeadResource::getUrl('edit', ['record' => $r])),
            ]);
    }
}
