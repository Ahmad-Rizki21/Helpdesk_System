<?php

namespace App\Filament\Resources\TicketResource\Pages;

use App\Filament\Resources\TicketResource;
use App\Filament\Widgets\FooterWidget;
use Filament\Actions;
use App\Mail\TicketCreated;
use Filament\Actions\Action;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TicketsExport;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables;

class ListTickets extends ListRecords
{
    protected static string $resource = TicketResource::class;


    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\Action::make('export')
                ->label('Ekspor ke Excel')
                ->color('success')
                ->icon('heroicon-o-arrow-down-tray')
                ->action(fn () => $this->exportToExcel()),
        ];
    }

    public function exportToExcel()
    {
        return Excel::download(new TicketsExport, 'laporan_tickets.xlsx');
    }

    protected function getTableRowClass($record): string
    {
        return match ($record->status) {
            'OPEN' => 'bg-red-100 text-red-600', // Merah untuk OPEN
            'PENDING' => 'bg-orange-100 text-orange-600', // Oranye untuk PENDING
            'CLOSED' => 'bg-green-100 text-green-600', // Hijau untuk CLOSED
            default => '',
        };
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('ticket_number')->label('No Ticket'),
            Tables\Columns\TextColumn::make('service')->label('Layanan'),
            Tables\Columns\TextColumn::make('customer.composite_data')->label('Id Pelanggan'),
            Tables\Columns\TextColumn::make('report_date')->label('Report Date'),
            Tables\Columns\TextColumn::make('status')->label('Status'),
            Tables\Columns\TextColumn::make('pending_clock')->label('Pending Clock'),
            Tables\Columns\TextColumn::make('closed_date')->label('Closed Date'),
        ];
    }

    protected function getFooterWidgets(): array
    {
        return [
            FooterWidget::class, // Menambahkan widget footer
        ];
    }
}