<?php

namespace App\Filament\Resources\VisitRequestResource\Pages;

use App\Filament\Resources\ClientResource;
use App\Filament\Resources\VisitRequestResource;
use Filament\Actions;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\TextEntry\TextEntrySize;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;

class ViewVisitRequest extends ViewRecord
{
    protected static string $resource = VisitRequestResource::class;

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
                Section::make("Main Info")->schema([
                    TextEntry::make('apartment.title'),
                    TextEntry::make('status')->badge(),
                    TextEntry::make('user.name')->url(fn($record) => ClientResource::getUrl('view', ['record' => $record->user_id])),
                ])->columns(3),

                Section::make('Dates')
                ->schema([
                    TextEntry::make('requested_at')->dateTime(),
                    TextEntry::make('created_at')->dateTime(),
                    TextEntry::make('updated_at')->dateTime(),
                ])->columns(3),
            ]);
    }
}
