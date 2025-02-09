<?php

namespace App\Filament\Resources\TicketResource\Pages;

use App\Filament\Resources\TicketResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;
use App\Filament\Widgets\FooterWidget;
use Filament\Notifications\Actions\Action;


class CreateTicket extends CreateRecord
{
    protected static string $resource = TicketResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotification(): ?Notification
{
    return Notification::make()
        ->success()
        ->color('success')
        ->title('🎉 Ticket Berhasil Dibuat!')
        ->body('Ticket baru telah dibuat. Klik tombol di bawah untuk melihat detailnya.')
        ->actions([
            Action::make('Lihat Ticket') // Pakai Filament\Notifications\Actions\Action
                ->url($this->getResource()::getUrl('edit', ['record' => $this->record]))
                ->button(),
        ])
        ->send();
}
    protected function getFooterWidgets(): array
    {
        return [
            FooterWidget::class, // Menambahkan widget footer
        ];
    }
}
