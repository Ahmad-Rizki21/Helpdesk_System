<?php

namespace App\Filament\Resources\LogResource\Pages;

use App\Filament\Resources\LogResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Widgets\FooterWidget;

class CreateLog extends CreateRecord
{
    protected static string $resource = LogResource::class;

    protected function getFooterWidgets(): array
    {
        return [
            FooterWidget::class, // Menambahkan widget footer
        ];
    }
}
