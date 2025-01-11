<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VisitRequestResource\Pages;
use App\Filament\Resources\VisitRequestResource\RelationManagers;
use App\Models\VisitRequest;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class VisitRequestResource extends Resource
{
    protected static ?string $model = VisitRequest::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('apartment.title'),
                TextColumn::make('user.name'),
                TextColumn::make('requested_at'),
                TextColumn::make('status')
                    ->badge()
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVisitRequests::route('/'),
            'create' => Pages\CreateVisitRequest::route('/create'),
            'view' => Pages\ViewVisitRequest::route('/{record}'),
            'edit' => Pages\EditVisitRequest::route('/{record}/edit'),
        ];
    }
}
