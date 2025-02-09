<?php

// namespace App\Filament\Pages;

// use Filament\Pages\Page;
// use Illuminate\Support\Facades\DB;
// use App\Filament\Widgets\FooterWidget;

// class Dashboard extends Page
// {
//     protected static ?string $navigationIcon = 'heroicon-o-home';
//     protected static string $view = 'filament.pages.dashboard';

//      protected static ?string $navigationLabel = 'Dashboard';
//      protected static ?string $title = 'ARTACOM FTTH HELPDESK SYSTEM'; // Ubah teks di sini

//     public function mount()
//     {
//         // Custom logic for your dashboard can be added here
//     }
//     protected function getViewData(): array
//     {
//         // Query the database to get ticket counts
//         $openTickets = DB::table('tickets')->where('status', 'OPEN')->count();
//         $pendingTickets = DB::table('tickets')->where('status', 'PENDING')->count();
//         $closedTickets = DB::table('tickets')->where('status', 'CLOSED')->count();

//         return [
//             'openTickets' => $openTickets,
//             'pendingTickets' => $pendingTickets,
//             'closedTickets' => $closedTickets,
//         ];
//     }
//     protected function getFooterWidgets(): array
//     {
//         return [
//             FooterWidget::class, // Menambahkan widget footer
//         ];
//     }
// }


namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Support\Facades\DB;
use App\Filament\Widgets\FooterWidget;
use App\Models\TicketBackbone; // Pastikan Anda mengimpor model TicketBackbone

class Dashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static string $view = 'filament.pages.dashboard';

    protected static ?string $navigationLabel = 'Dashboard';
    protected static ?string $title = 'ARTACOM FTTH HELPDESK SYSTEM'; // Ubah teks di sini

    public function mount()
    {
        // Custom logic for your dashboard can be added here
    }

    protected function getViewData(): array
    {
        // Query the database to get ticket counts
        $openTickets = DB::table('tickets')->where('status', 'OPEN')->count();
        $pendingTickets = DB::table('tickets')->where('status', 'PENDING')->count();
        $closedTickets = DB::table('tickets')->where('status', 'CLOSED')->count();

        // Hitung jumlah tiket untuk TicketBackbone
        $openBackboneTickets = TicketBackbone::where('status', 'OPEN')->count();
        $pendingBackboneTickets = TicketBackbone::where('status', 'PENDING')->count();
        $closedBackboneTickets = TicketBackbone::where('status', 'CLOSED')->count();

        return [
            'openTickets' => $openTickets,
            'pendingTickets' => $pendingTickets,
            'closedTickets' => $closedTickets,
            'openBackboneTickets' => $openBackboneTickets, // Tambahkan ini
            'pendingBackboneTickets' => $pendingBackboneTickets, // Tambahkan ini
            'closedBackboneTickets' => $closedBackboneTickets, // Tambahkan ini
        ];
    }

    protected function getFooterWidgets(): array
    {
        return [
            FooterWidget::class, // Menambahkan widget footer
        ];
    }
}