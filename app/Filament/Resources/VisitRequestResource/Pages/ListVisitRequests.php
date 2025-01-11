<?php

namespace App\Filament\Resources\VisitRequestResource\Pages;

use App\Filament\Resources\VisitRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListVisitRequests extends ListRecords
{
    protected static string $resource = VisitRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
