<?php

namespace App\Filament\Resources\ClientResource\Pages;

use App\Filament\Resources\ClientResource;
use Filament\Actions;
use Filament\Forms\Components\Toggle;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;

class ViewClient extends ViewRecord
{
    protected static string $resource = ClientResource::class;



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
                Section::make('Client Information')
                    ->schema([
                        TextEntry::make('name'),
                        TextEntry::make('email'),
                        TextEntry::make('phone_number'),
                        TextEntry::make('is_blocked')
                        // ->badge(fn (string $state): string => match ($state) {
                        //     0 => 'Unblocked',
                        //     1 => 'Blocked',
                        //     default => 'Unknown',
                        // })
                        ->badge()
                        ->color(fn (string $state): string => match ($state) {
                            0 => 'green',
                            1 => 'danger',
                            default => 'gray',
                        })

                    ])
                    ->columns(2),

                    Section::make("More Information")
                    ->schema([
                        TextEntry::make('created_at')->dateTime('d-m-Y H:i'),
                        TextEntry::make('updated_at')->dateTime('d-m-Y H:i'),
                        ])
                    ->columns(2),
            ]);
    }
}
