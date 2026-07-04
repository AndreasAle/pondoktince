<?php

namespace App\Filament\Resources\WhatsappContactResource\Pages;

use App\Filament\Resources\WhatsappContactResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditWhatsappContact extends EditRecord
{
    protected static string $resource = WhatsappContactResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
