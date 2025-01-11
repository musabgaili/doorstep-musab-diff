<?php

namespace App\Filament\Resources\AgentResource\Widgets;

use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AgentsStatsOverview extends BaseWidget
{


    protected function getStats(): array
    {
        $agent = User::where('user_type', 'agent')->count();
        $verifiedAgent = User::where('user_type', 'agent')->whereNotNull('email_verified_at')->count();
        return [
            Stat::make('Total Agents', $agent)->color('success'),
            Stat::make('Verified Agents', $verifiedAgent),
        ];
    }
}
