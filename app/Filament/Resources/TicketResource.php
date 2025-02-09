<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TicketResource\Pages;
use App\Filament\Resources\TicketResource\RelationManagers;
use App\Models\Ticket;
use App\Models\Evidance;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TicketsExport;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Support\Facades\Auth;

class TicketResource extends Resource
{
    protected static ?string $model = Ticket::class;

    protected static ?string $navigationIcon = 'heroicon-o-ticket';
    protected static ?string $navigationLabel = 'Tickets';
    protected static ?string $navigationGroup = 'Helpdesk';

    // Fungsi form
    public static function form(Form $form): Form
    {
        return $form->schema([
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

                Forms\Components\Hidden::make('created_by')
                ->default(fn () => Auth::user()->id) // Simpan user yang sedang login
                ->disabled(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('ticket_number')->label('No Ticket')->searchable(),
                Tables\Columns\TextColumn::make('service')->label('Layanan')->searchable(),
                Tables\Columns\TextColumn::make('customer.composite_data')->label('Id Pelanggan')->searchable(),
                Tables\Columns\TextColumn::make('problem_summary')->label('Problem Summary')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('extra_description')->label('Extra Description')->limit(50)->sortable()->searchable(),
                Tables\Columns\TextColumn::make('report_date')->label('Report Date')->searchable(),
                Tables\Columns\TextColumn::make('status')->label('Status')->badge()->color(fn (string $state): string => match ($state) {
                    'OPEN' => 'danger',
                    'PENDING' => 'warning',
                    'CLOSED' => 'success',
                    default => 'gray',
                })->searchable(),

                // Tables\Columns\TextColumn::make('evidances.file_path')->label(label: 'Evidance')->searchable(),

                Tables\Columns\TextColumn::make('pending_clock')->label('Pending Clock')->searchable(),
                Tables\Columns\TextColumn::make('sla.name')->label('SLA')->badge()->color(fn ($state): string => match ($state) {
                    'HIGH' => 'danger',
                    'MEDIUM' => 'warning',
                    'LOW' => 'primary',
                    default => 'gray',
                })->searchable(),
                Tables\Columns\TextColumn::make('closed_date')->label('Closed Date')->searchable(),
                Tables\Columns\TextColumn::make('creator.name')
                ->label('Created By')
                ->sortable()
                ->searchable(),
                ])

                ->filters([
                    SelectFilter::make('status')
                        ->label('Filter Status')
                        ->options([
                            'OPEN' => 'OPEN',
                            'PENDING' => 'PENDING',
                            'CLOSED' => 'CLOSED',
                        ]),
                ])
            

            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->requiresConfirmation()
                    ->modalHeading('Konfirmasi Hapus Ticket')
                    ->modalDescription('Apakah Anda yakin ingin menghapus ticket ini? Tindakan ini tidak dapat dibatalkan.')
                    ->modalSubmitActionLabel('Ya, Hapus')
                    ->modalCancelActionLabel('Batal')
                    ->successNotificationTitle('🗑️ Ticket Berhasil Dihapus!')
                    ->after(function () {
                        \Filament\Notifications\Notification::make()
                            ->success()
                            ->title('🗑️ Ticket Telah Dihapus!')
                            ->body('Ticket ini telah dihapus secara permanen.')
                            ->send();
                    }),

            ])



            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    // public static function exportToExcel()
    // {
    //     return Excel::download(new TicketsExport(), 'laporan_tickets.xlsx');

    //     // Membersihkan output buffer
    //     ob_clean();
    //     flush();

    //     // Buat spreadsheet baru
    //     $spreadsheet = new Spreadsheet();
    //     $sheet = $spreadsheet->getActiveSheet();

    //     // Set header
    //     $sheet->setCellValue('A1', 'No Ticket');
    //     $sheet->setCellValue('B1', 'Layanan');
    //     $sheet->setCellValue('C1', 'Id Pelanggan');
    //     $sheet->setCellValue('D1', 'Problem Summary');
    //     $sheet->setCellValue('E1', 'Extra Description');
    //     $sheet->setCellValue('F1', 'Report Date');
    //     $sheet->setCellValue('G1', 'Status');
    //     $sheet->setCellValue('H1', 'Pending Clock');
    //     $sheet->setCellValue('I1', 'SLA');
    //     $sheet->setCellValue('J1', 'Closed Date');
    //     $sheet->setCellValue('K1', 'Evidence Path');  // Menambahkan header kolom untuk bukti


    //     // Ambil data dari model Ticket
    //     $tickets = Ticket::all();

    //     // Menambahkan data ke spreadsheet
    //     $row = 2; // Mulai dari baris kedua
    //     foreach ($tickets as $ticket) {
    //         $sheet->setCellValue('A' . $row, $ticket->ticket_number);
    //         $sheet->setCellValue('B' . $row, $ticket->service);
    //         $sheet->setCellValue('C' . $row, $ticket->customer->composite_data);
    //         $sheet->setCellValue('D' . $row, $ticket->problem_summary);
    //         $sheet->setCellValue('E' . $row, $ticket->extra_description);
    //         $sheet->setCellValue('F' . $row, $ticket->report_date);
    //         $sheet->setCellValue('G' . $row, $ticket->status);
    //         $sheet->setCellValue('H' . $row, $ticket->pending_clock);
    //         $sheet->setCellValue('I' . $row, $ticket->sla->name);
    //         $sheet->setCellValue('J' . $row, $ticket->closed_date);
    //         // Menambahkan path bukti (file path) ke kolom baru
    //         $sheet->setCellValue('K' . $row, $ticket->evidance_path);  // Path bukti
    
    //         $row++;
    //     }

    //     // Mengatur header untuk download
    //     header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    //     header('Content-Disposition: attachment; filename="laporan_tickets.xlsx"');
    //     header('Cache-Control: max-age=0');

    //     // Buat writer dan simpan file
    //     $writer = new Xlsx($spreadsheet);
    //     $writer->save('php://output');
    //     exit;
    // }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTickets::route('/'),
            'create' => Pages\CreateTicket::route('/create'),
            'edit' => Pages\EditTicket::route('/{record}/edit'),
            'view' => Pages\ViewTicket::route('/{record}'), // Add this line
        ];
    }
}