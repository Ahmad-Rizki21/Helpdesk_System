<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TicketBackboneExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    public function collection()
    {
        // Ambil data dari session (data yang tampil di Filament)
        return collect(session('filtered_tickets', []));
    }

    public function headings(): array
    {
        return [
            'No Ticket', 'CID', 'Jenis ISP', 'Lokasi', 'Status', 
            'Open Date', 'Pending Date', 'Closed Date', 'Created By'
        ];
    }

    public function map($ticket): array
    {
        return [
            $ticket['no_ticket'] ?? 'N/A',
            "'" . ($ticket['cid'] ?? 'N/A'), // Tambahkan kutip agar CID tetap teks di Excel
            $ticket['jenis_isp'] ?? 'N/A',
            self::lokasiList()[$ticket['lokasi_id'] ?? null] ?? ($ticket['lokasi'] ?? 'Lokasi Tidak Diketahui'),
            $ticket['status'] ?? 'N/A',
            $ticket['open_date'] ?? 'N/A',
            $ticket['pending_date'] ?? 'Belum ada Pending',
            $ticket['closed_date'] ?? 'Belum ada Ticket Closed',
            $ticket['created_by'] ?? 'Unknown',
        ];
    }

    public static function lokasiList(): array
    {
        return [
            1 => 'Jakarta',
            2 => 'Bandung',
            3 => 'Surabaya',
            4 => 'Medan',
            5 => 'Bali',
            // Tambahkan lokasi lainnya sesuai kebutuhan
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1    => ['font' => ['bold' => true]], // Header dibuat bold
            'A'  => ['alignment' => ['horizontal' => 'left']],  // No Ticket rata kiri
            'B'  => ['alignment' => ['horizontal' => 'left']],  // CID rata kiri
            'C'  => ['alignment' => ['horizontal' => 'left']],  // Jenis ISP rata kiri
            'D'  => ['alignment' => ['horizontal' => 'left']],  // Lokasi rata kiri
            'E'  => ['alignment' => ['horizontal' => 'center']], // Status rata tengah
            'F'  => ['alignment' => ['horizontal' => 'center']], // Open Date rata tengah
            'G'  => ['alignment' => ['horizontal' => 'center']], // Pending Date rata tengah
            'H'  => ['alignment' => ['horizontal' => 'center']], // Closed Date rata tengah
            'I'  => ['alignment' => ['horizontal' => 'left']],  // Created By rata kiri
        ];
    }
}
