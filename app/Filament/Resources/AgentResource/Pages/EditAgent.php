<?php

namespace App\Filament\Resources\AgentResource\Pages;

use App\Filament\Resources\AgentResource;
use Filament\Actions;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Pages\EditRecord;
use Filament\Forms\Components\Toggle;

class EditAgent extends EditRecord
{
    protected static string $resource = AgentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }


    public  function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                Section::make('Block/Unblock Agent')
                ->schema([
                Toggle::make('is_blocked'),
                ]),
                Section::make('Agent Information')
                ->schema([
                    TextInput::make('name'),
                    TextInput::make('email'),
                    TextInput::make('phone_number'),
                ])->columns(2),
            ]);
    }

}
