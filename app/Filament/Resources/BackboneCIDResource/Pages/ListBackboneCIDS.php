<?php

namespace App\Filament\Resources\BackboneCIDResource\Pages;

use App\Filament\Resources\BackboneCIDResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Widgets\FooterWidget;


class ListBackboneCIDS extends ListRecords
{
    protected static string $resource = BackboneCIDResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getFooterWidgets(): array
    {
        return [
            FooterWidget::class, // Menambahkan widget footer
        ];
    }

}
