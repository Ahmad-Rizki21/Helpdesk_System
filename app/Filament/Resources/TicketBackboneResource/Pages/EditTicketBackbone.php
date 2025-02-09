<?php

namespace App\Filament\Resources\TicketBackboneResource\Pages;

use App\Filament\Resources\TicketBackboneResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Widgets\FooterWidget;

class EditTicketBackbone extends EditRecord
{
    protected static string $resource = TicketBackboneResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getFooterWidgets(): array
    {
        return [
            FooterWidget::class, // Menambahkan widget footer
        ];
    }
}
