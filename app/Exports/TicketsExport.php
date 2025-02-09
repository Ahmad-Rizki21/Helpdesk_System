<?php

namespace App\Exports;

use App\Models\Ticket;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TicketsExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    public function collection()
    {
        return Ticket::with(['customer', 'createdBy'])->get();
    }

    public function headings(): array
    {
        return [
            'No Ticket',
            'Layanan',
            'Id Pelanggan',
            'Problem Summary',
            'Extra Description',
            'Report Date',
            'Status',
            'Pending Clock',
            'Closed Date',
            'Created By',
        ];
    }

    public function map($ticket): array
    {
        return [
            $ticket->ticket_number,
            $ticket->service,
            $ticket->customer->composite_data ?? 'No Data',
            $ticket->problem_summary,
            $ticket->extra_description,
            $ticket->report_date,
            $ticket->status,
            $ticket->pending_clock,
            $ticket->closed_date,
            optional($ticket->createdBy)->name ?? 'Unknown',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1    => ['font' => ['bold' => true]], // Header dibuat bold
            'A'  => ['alignment' => ['horizontal' => 'left']],  // No Ticket rata kiri
            'B'  => ['alignment' => ['horizontal' => 'left']],  // Layanan rata kiri
            'C'  => ['alignment' => ['horizontal' => 'left']],  // Id Pelanggan rata kiri
            'D'  => ['alignment' => ['horizontal' => 'left']],  // Problem Summary rata kiri
            'E'  => ['alignment' => ['horizontal' => 'center']], // Extra Description rata tengah
            'F'  => ['alignment' => ['horizontal' => 'center']], // Report Date rata tengah
            'G'  => ['alignment' => ['horizontal' => 'center']], // Status rata tengah
            'H'  => ['alignment' => ['horizontal' => 'center']], // Pending Clock rata tengah
            'I'  => ['alignment' => ['horizontal' => 'center']], // Closed Date rata tengah
            'J'  => ['alignment' => ['horizontal' => 'left']],  // Created By rata kiri
        ];
    }
}