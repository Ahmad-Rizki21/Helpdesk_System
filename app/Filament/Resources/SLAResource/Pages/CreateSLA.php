<?php

namespace App\Filament\Resources\SLAResource\Pages;

use App\Filament\Resources\SLAResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Widgets\FooterWidget;

class CreateSLA extends CreateRecord
{
    protected static string $resource = SLAResource::class;
    protected function getFooterWidgets(): array
    {
        return [
            FooterWidget::class, // Menambahkan widget footer
        ];
    }
}


