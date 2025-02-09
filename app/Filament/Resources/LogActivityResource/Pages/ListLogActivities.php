<?php

namespace App\Filament\Resources\LogActivityResource\Pages;

use App\Filament\Resources\LogActivityResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Widgets\FooterWidget;

class ListLogActivities extends ListRecords
{
    protected static string $resource = LogActivityResource::class;

    // protected function getHeaderActions(): array
    // {
    //     // return [
    //     //     Actions\CreateAction::make(),
    //     // ];
    // }

    protected function getFooterWidgets(): array
    {
        return [
            FooterWidget::class, // Menambahkan widget footer
        ];
    }
}


