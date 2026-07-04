<?php

namespace App\Filament\Resources\BookingLeadResource\Pages;

use App\Filament\Resources\BookingLeadResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBookingLead extends EditRecord
{
    protected static string $resource = BookingLeadResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
