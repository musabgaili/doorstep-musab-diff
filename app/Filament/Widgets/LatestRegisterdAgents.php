<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\AgentResource;
use App\Models\User;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestRegisterdAgents extends BaseWidget
{
    protected static ?int $sort = 4;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                // TODO: Customize this query to return the data you want to display
                // Example: Order::query()->latest()->limit(5)
                User::query()->where('user_type', 'agent')->latest()->limit(5)
            )
            ->columns([
                // TODO: Define your table columns here
                // Example:
                Tables\Columns\TextColumn::make('name')->label('Name')->url(fn($record) => AgentResource::getUrl('view', ['record' => $record])),
                Tables\Columns\TextColumn::make('email')->label('Email'),
                // Tables\Columns\TextColumn::make('id')->label('Order ID'),
                // Tables\Columns\TextColumn::make('customer.name')->label('Customer'),
                // Tables\Columns\TextColumn::make('total')->money('usd'),
            ]);
    }
}
