<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TeamResource\Pages;
use App\Filament\Resources\TeamResource\RelationManagers;
use App\Models\Team;
use Filament\Forms\Components;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Table;

class TeamResource extends Resource {
    protected static ?string $model = Team::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form( Form $form ): Form {
        return $form
            ->schema( [
                Components\Split::make( [
                    Components\Section::make( 'Team Info' )->schema( [
                        Components\TextInput::make( 'name' )
                            ->required()
                            ->maxLength( 255 ),
                        Components\TextInput::make( 'year' )
                            ->required(),
                    ] )->columnSpan( 8 ),
                    Components\Section::make( [
                        Components\Select::make( 'user_id' )
                            ->relationship( 'user', 'name' )
                            ->label( 'Owner' )
                            ->required(),
                        Components\Toggle::make( 'locked' )
                            ->required(),
                    ] )->grow( false ),
                ] )
                    ->from( 'md' )
                    ->columnSpanFull()
            ] );
    }

    public static function table( Table $table ): Table {
        return $table
            ->columns( [
                Tables\Columns\TextColumn::make( 'name' )
                    ->weight( FontWeight::Bold )
                    ->searchable(),
                Tables\Columns\TextColumn::make( 'year' ),
                Tables\Columns\IconColumn::make( 'locked' )
                    ->boolean(),
                Tables\Columns\TextColumn::make( 'user.name' )
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make( 'created_at' )
                    ->dateTime()
                    ->sortable()
                    ->toggleable( isToggledHiddenByDefault: true ),
                Tables\Columns\TextColumn::make( 'updated_at' )
                    ->dateTime()
                    ->sortable()
                    ->toggleable( isToggledHiddenByDefault: true ),
            ] )
            ->filters( [
                //
            ] )
            ->actions( [
                Tables\Actions\EditAction::make(),
            ] )
            ->bulkActions( [
                Tables\Actions\BulkActionGroup::make( [
                    Tables\Actions\DeleteBulkAction::make(),
                ] ),
            ] );
    }

    public static function getRelations(): array {
        return [
            RelationManagers\PlayersRelationManager::class
        ];
    }

    public static function getPages(): array {
        return [
            'index'  => Pages\ListTeams::route( '/' ),
            'create' => Pages\CreateTeam::route( '/create' ),
            'edit'   => Pages\EditTeam::route( '/{record}/edit' ),
        ];
    }
}
