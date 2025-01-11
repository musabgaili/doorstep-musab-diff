<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AgentResource\Pages;
use App\Filament\Resources\AgentResource\RelationManagers;
use App\Filament\Resources\AgentResource\Widgets\AgentsStatsOverview;
use App\Models\Agent;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AgentResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $label = 'Agents';

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
                TextColumn::make('name'),
                TextColumn::make('email'),
                TextColumn::make('phone_number'),
                TextColumn::make('created_at')->dateTime('d-m-Y H:i'),
                // TextColumn::make('updated_at')->dateTime('d-m-Y H:i'),
                // TextColumn::make('is_blocked')->badge(),
                ToggleColumn::make('is_blocked'),



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
            ])->modifyQueryUsing(function(Builder $query){
                $query->where('user_type','agent');
            });
    }

    public static function getRelations(): array
    {
        return [
            //
            RelationManagers\ApartmentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAgents::route('/'),
            'create' => Pages\CreateAgent::route('/create'),
            'view' => Pages\ViewAgent::route('/{record}'),
            'edit' => Pages\EditAgent::route('/{record}/edit'),
        ];
    }


    public static function getWidgets(): array
    {
        return [
            AgentsStatsOverview::class,
        ];
    }

    // public static function getHeaderWidgets(): array
    // {
    //     return [
    //         AgentsStatsOverview::class,
    //     ];
    // }
}
