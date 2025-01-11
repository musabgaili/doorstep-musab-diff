<?php

namespace App\Filament\Resources\ApartmentResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Database\Eloquent\Model;

class ApartmentStatsOverview extends BaseWidget
{
    public ?Model $record = null;
    protected function getStats(): array
    {
        //'pending', 'approved', 'rejected'
        return [
            Stat::make('Apartment Total View Requests', $this->record->visits->count()),
            Stat::make('Apartment Approved View Requests', $this->record->visits->where('status', 'approved')->count()),
            Stat::make('Apartment Rejected View Requests', $this->record->visits->where('status', 'rejected')->count()),
        ];
    }
}
