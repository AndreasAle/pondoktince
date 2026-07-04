<?php

namespace App\Filament\Resources\WhatsappClickLogResource\Pages;

use App\Filament\Resources\WhatsappClickLogResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditWhatsappClickLog extends EditRecord
{
    protected static string $resource = WhatsappClickLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
