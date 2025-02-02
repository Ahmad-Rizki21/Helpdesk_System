<?php

namespace App\Filament\Resources\SLAResource\Pages;

use App\Filament\Resources\SLAResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Widgets\FooterWidget;

class EditSLA extends EditRecord
{
    protected static string $resource = SLAResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
    protected function getFooterWidgets(): array
    {
        return [
            FooterWidget::class, // Menambahkan widget footer
        ];
    }
}
