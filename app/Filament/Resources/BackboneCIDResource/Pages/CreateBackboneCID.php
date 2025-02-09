<?php

namespace App\Filament\Resources\BackboneCIDResource\Pages;

use App\Filament\Resources\BackboneCIDResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Widgets\FooterWidget;

class CreateBackboneCID extends CreateRecord
{
    protected static string $resource = BackboneCIDResource::class;

    protected function getFooterWidgets(): array
    {
        return [
            FooterWidget::class, // Menambahkan widget footer
        ];
    }
}
