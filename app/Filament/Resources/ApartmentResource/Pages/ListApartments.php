<?php

namespace App\Filament\Resources\ApartmentResource\Pages;

use App\Filament\Resources\ApartmentResource;
use App\Filament\Resources\ApartmentResource\Widgets\ApartmentsStatsOverview;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListApartments extends ListRecords
{
    protected static string $resource = ApartmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getHeaderWidgets(): array
    {
        return [
            ApartmentsStatsOverview::class,
        ];
    }
}
