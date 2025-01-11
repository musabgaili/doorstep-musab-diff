<?php

namespace App\Filament\Resources\VisitRequestResource\Pages;

use App\Enums\VisitRequestStatus;
use App\Filament\Resources\VisitRequestResource;
use App\Models\Apartment;
use App\Models\User;
use Filament\Actions;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Pages\EditRecord;

class EditVisitRequest extends EditRecord
{
    protected static string $resource = VisitRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Status')
                    ->description('Update the status of the visit request')
                    ->schema([
                        Select::make('status')
                            ->options(VisitRequestStatus::class),
                    ]),

                Section::make('INFO')
                    ->description('Dont Update This')
                    ->schema([

                        Select::make('user_id')
                            ->label('Client')
                            ->options(User::find($this->record->user_id)->pluck('name', 'id'))
                            ->disabled(),
                        Select::make('apartment_id')
                            ->label('Property')
                            ->options(Apartment::find($this->record->apartment_id)->pluck('title', 'id'))
                            ->disabled(),
                        TextInput::make('requested_at')->disabled(),
                    ])->columns(3),

                    Section::make('Dates')
                        ->schema([
                            TextInput::make('created_at')->disabled(),
                            TextInput::make('updated_at')->disabled(),
                        ])->columns(2),
            ]);
    }
}
