<?php

namespace App\Filament\Resources\ClientResource\Widgets;

use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ClientsStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $client = User::where('user_type', 'client')->count();
        $verifiedClient = User::where('user_type', 'client')->whereNotNull('email_verified_at')->count();
        return [
            Stat::make('Total Clients', $client)->color('success'),
            Stat::make('Verified Clients', $verifiedClient),
        ];
    }
}
