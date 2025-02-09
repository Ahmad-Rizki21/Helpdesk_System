<?php

namespace App\Filament\Resources\TicketBackboneResource\Pages;

use App\Filament\Resources\TicketBackboneResource;
use Filament\Actions;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TicketBackboneExport;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions\Action;
use App\Filament\Widgets\FooterWidget;


class ListTicketBackbones extends ListRecords
{
    protected static string $resource = TicketBackboneResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Action::make('export')
                ->label('Export to Excel')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('success')
                ->action(fn () => Excel::download(new TicketBackboneExport, 'ticket-backbone.xlsx')),
       
        ];
    }

    protected function getFooterWidgets(): array
    {
        return [
            FooterWidget::class, // Menambahkan widget footer
        ];
    }

}
