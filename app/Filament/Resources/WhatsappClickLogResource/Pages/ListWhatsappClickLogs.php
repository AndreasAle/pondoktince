<?php

namespace App\Filament\Resources\WhatsappClickLogResource\Pages;

use App\Filament\Resources\WhatsappClickLogResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListWhatsappClickLogs extends ListRecords
{
    protected static string $resource = WhatsappClickLogResource::class;

    protected function getHeaderActions(): array
    {
        // Read-only log.
        return [];
    }
}
