<?php

namespace App\Filament\Resources\TicketBackboneResource\Pages;

use App\Filament\Resources\TicketBackboneResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Widgets\FooterWidget;

class CreateTicketBackbone extends CreateRecord
{
    protected static string $resource = TicketBackboneResource::class;

    protected function getFooterWidgets(): array
    {
        return [
            FooterWidget::class, // Menambahkan widget footer
        ];
    }
}


