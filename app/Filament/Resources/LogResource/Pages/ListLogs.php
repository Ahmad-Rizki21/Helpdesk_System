<?php

namespace App\Filament\Resources\LogResource\Pages;

use App\Filament\Widgets\FooterWidget;
use App\Filament\Resources\LogResource;
use Filament\Resources\Pages\ListRecords;

class ListLogs extends ListRecords
{
    protected static string $resource = LogResource::class;
    protected function getFooterWidgets(): array
    {
        return [
            FooterWidget::class, // Menambahkan widget footer
        ];
    }
}