<?php

namespace App\Filament\Resources\TicketResource\Pages;

use App\Filament\Resources\TicketResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput as ComponentsTextInput;

class ViewTicket extends ViewRecord
{
    protected static string $resource = TicketResource::class;

    protected function getActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\TextInput::make('service')->label('Layanan')->disabled(),
            Forms\Components\TextInput::make('ticket_number')->label('No Ticket')->disabled(),
            Forms\Components\TextInput::make('customer.composite_data')->label('Id Pelanggan')->disabled(),
            Forms\Components\TextInput::make('problem_summary')->label('Problem Summary')->disabled(),
            Forms\Components\Textarea::make('extra_description')->label('Extra Description')->disabled(),
            Forms\Components\DateTimePicker::make('report_date')->label('Report Date')->disabled(),
            Forms\Components\TextInput::make('status')->label('Status')->disabled(),
            Forms\Components\DateTimePicker::make('pending_clock')->label('Pending Clock')->disabled(),
            Forms\Components\DateTimePicker::make('closed_date')->label('Closed Date')->disabled(),
            Forms\Components\TextInput::make('sla.name')->label('SLA')->disabled(),

            // Add a section for evidences
            Forms\Components\Section::make('Evidence')
            ->schema([
                Forms\Components\View::make('evidance_path')
                    ->label('Evidence File')
                    ->view('components.file-display') // Pastikan view ini ada
            ])
            ->collapsible()
            ->collapsed(false)
        ];
    }
}