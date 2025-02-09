<?php

namespace App\Filament\Resources\TicketResource\Pages;

use App\Filament\Resources\TicketResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use App\Models\Evidance;
use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Notifications\Actions\Action;

class EditTicket extends EditRecord
{
    protected static string $resource = TicketResource::class;

    protected function getHeaderActions(): array
{
    return [
        Actions\DeleteAction::make()
            ->requiresConfirmation()
            ->modalHeading('Konfirmasi Hapus Ticket')
            ->modalDescription('Apakah Anda yakin ingin menghapus ticket ini? Tindakan ini tidak dapat dibatalkan.')
            ->modalSubmitActionLabel('Ya, Hapus')
            ->modalCancelActionLabel('Batal')
            ->successNotificationTitle('🗑️ Ticket Berhasil Dihapus!')
            ->after(function () {
                Notification::make()
                    ->success()
                    ->title('🗑️ Ticket Telah Dihapus!')
                    ->body('Ticket ini telah dihapus secara permanen.')
                    ->send();
            }),
    ];
}

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\Select::make('service')
                ->label('Layanan')
                ->options([
                    'ISP-JAKINET' => 'ISP-JAKINET',
                    'ISP-JELANTIK' => 'ISP-JELANTIK',
                ])
                ->required(),
            Forms\Components\TextInput::make('ticket_number')
                ->label('No Ticket')
                ->disabled()
                ->default(fn () => 'TFTTH-' . strtoupper(uniqid()))
                ->required(),
            Forms\Components\Select::make('customer_id')
                ->label('Id Pelanggan')
                ->relationship('customer', 'composite_data')
                ->searchable()
                ->required(),
            Forms\Components\Select::make('problem_summary')
                ->required()
                ->label('Problem Summary')
                ->options([
                    'INDIKATOR LOS' => 'INDIKATOR LOS',
                    'LOW SPEED' => 'LOW SPEED',
                    'MODEM HANG' => 'MODEM HANG',
                    'NO INTERNET ACCESS' => 'NO INTERNET ACCESS',
                ]),
            Forms\Components\Textarea::make('extra_description')
                ->label('Extra Description')
                ->placeholder('Masukkan deskripsi tambahan di sini...')
                ->rows(4)
                ->required(),
            Forms\Components\DateTimePicker::make('report_date')
                ->label('Report Date')
                ->default(now())
                ->disabled(),
            Forms\Components\Select::make('status')
                ->label('Status')
                ->options([
                    'OPEN' => 'OPEN',
                    'PENDING' => 'PENDING',
                    'CLOSED' => 'CLOSED',
                ])
                ->default('OPEN')
                ->required(),


                Forms\Components\FileUpload::make('evidance_path')
                ->label('Upload Evidence')
                ->acceptedFileTypes(['image/*', 'video/*', 'application/pdf'])
                ->maxSize(10240) // max 10MB
                ->directory('evidances') // direktori penyimpanan
                ->preserveFilenames(), // menjaga nama file asli


            Forms\Components\TextInput::make('pending_clock')
                ->label('Pending Clock')
                ->disabled()
                ->placeholder('Belum ada Pending'),
            Forms\Components\TextInput::make('closed_date')
                ->label('Closed Date')
                ->disabled()
                ->placeholder('Belum ada Ticket Closed'),
            Forms\Components\Select::make('sla_id')
                ->label('SLA')
                ->relationship('sla', 'name')
                ->required(),

            // Tambahkan bagian untuk menampilkan evidences
            Forms\Components\Section::make('Evidences')
            ->schema([
                Forms\Components\Repeater::make('evidances')
                    ->relationship('evidances')
                    ->schema([
                        Forms\Components\TextInput::make('file_path')->label('Evidance Path')->disabled(),
                        Forms\Components\TextInput::make('file_type')->label('Evidance Type')->disabled(),
                    ])
                    ->columns(2)
                    ->disabled() // Pastikan repeater ini hanya untuk menampilkan data, tidak bisa diubah
            ])
            ->collapsible()
            ->collapsed(false)
    ];
    }


    protected function getSavedNotification(): ?Notification
{
    return Notification::make()
        ->success()
        ->color('success')
        ->title('✅ Ticket Berhasil Diperbarui!')
        ->body('Perubahan pada ticket telah disimpan. Klik tombol di bawah untuk melihat detailnya.')
        ->actions([
            Action::make('Lihat Ticket')
                ->url($this->getResource()::getUrl('edit', ['record' => $this->record]))
                ->button(),
        ])
        ->send();
}



}