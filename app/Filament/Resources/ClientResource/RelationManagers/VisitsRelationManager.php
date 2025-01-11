<?php

namespace App\Filament\Resources\ClientResource\RelationManagers;

use App\Filament\Resources\AgentResource;
use App\Filament\Resources\ApartmentResource;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class VisitsRelationManager extends RelationManager
{
    protected static string $relationship = 'visits';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('status')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('status')
            ->columns([
                TextColumn::make('id'),
                TextColumn::make('requested_at'),
                TextColumn::make('apartment.title')->url(fn($record) => ApartmentResource::getUrl('view', ['record' => $record->apartment_id])),
                TextColumn::make('apartment.user.name')->url(fn($record) => AgentResource::getUrl('view', ['record' => $record->apartment->user_id])),
                TextColumn::make('status')->badge(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
