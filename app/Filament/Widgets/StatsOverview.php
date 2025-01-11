<?php

namespace App\Filament\Widgets;

use App\Models\Apartment;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;
    protected function getStats(): array
    {
        return [
            //
            Stat::make('Total Apartments', Apartment::count()),
            Stat::make('Total Clients', User::where('user_type', 'client')->count()),
            Stat::make('Total Agents', User::where('user_type', 'agent')->count()),
        ];
    }
}
