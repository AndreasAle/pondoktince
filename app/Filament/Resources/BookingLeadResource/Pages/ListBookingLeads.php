<?php

namespace App\Filament\Resources\BookingLeadResource\Pages;

use App\Filament\Resources\BookingLeadResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBookingLeads extends ListRecords
{
    protected static string $resource = BookingLeadResource::class;

    protected function getHeaderActions(): array
    {
        // Booking leads are created from the public site, not the panel.
        return [];
    }
}
