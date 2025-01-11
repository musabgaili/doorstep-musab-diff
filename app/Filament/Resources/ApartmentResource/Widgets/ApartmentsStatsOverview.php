<?php

namespace App\Filament\Resources\ApartmentResource\Widgets;

use App\Models\Apartment;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ApartmentsStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Apartments', Apartment::count()),
            Stat::make('Total Available Apartments', Apartment::where('available', true)->count()),
            // apartments added this month
            Stat::make('Apartments Added This Month', Apartment::whereMonth('created_at', now()->month)->count()),
        ];
    }
}
