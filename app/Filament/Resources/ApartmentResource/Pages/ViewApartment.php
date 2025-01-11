<?php

namespace App\Filament\Resources\ApartmentResource\Pages;

use App\Filament\Resources\AgentResource;
use App\Filament\Resources\ApartmentResource;
use App\Filament\Resources\ApartmentResource\Widgets\ApartmentStatsOverview;
use Filament\Actions;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;

class ViewApartment extends ViewRecord
{
    protected static string $resource = ApartmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }


    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Basic Information')
                    ->schema([
                        TextEntry::make('title'),
                        TextEntry::make('price'),
                        TextEntry::make('description'),
                        TextEntry::make('address'),
                    ])
                    ->columns(2),

                Section::make('Property Details')
                    ->schema([
                        TextEntry::make('available'),
                        TextEntry::make('rooms'),
                        TextEntry::make('area'),
                        TextEntry::make('building_age'),
                    ])
                    ->columns(4),

                Section::make('Additional Information')
                    ->schema([
                        TextEntry::make('user.name')
                            ->label('Agent')
                            ->url(
                                fn($record) =>
                                AgentResource::getUrl('edit', ['record' => $record->user])
                            ),
                    ])
                    ->columns(2),
                Section::make('Amenities')
                    ->schema([
                        TextEntry::make('amenities.name'),
                    ])
                    ->columns(2),
            ]);
    }

    public function getHeaderWidgets(): array
    {
        return [
            ApartmentStatsOverview::class,
        ];
    }

}
