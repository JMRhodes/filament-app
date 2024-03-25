<?php

namespace App\Filament\Resources\PlayerResource\RelationManagers;

use App\Filament\Resources\TournamentResource;
use App\Models\Result;
use App\Models\Tournament;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class ResultsRelationManager extends RelationManager {
    protected static string $relationship = 'results';

    public function form( Form $form ): Form {
        return $form
            ->schema( [
                Forms\Components\TextInput::make( 'position' )
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make( 'points' )
                    ->required()
                    ->numeric(),
            ] );
    }

    public function table( Table $table ): Table {
        return $table
            ->recordTitleAttribute( 'id' )
            ->columns( [
                Tables\Columns\TextColumn::make( 'position' ),
                Tables\Columns\TextColumn::make( 'tournament.name' )
                    ->label( 'Tournament' ),
                Tables\Columns\TextColumn::make( 'points' ),
            ] )
            ->filters( [
                //
            ] )
            ->headerActions( [
            ] )
            ->actions( [
                Tables\Actions\EditAction::make()
                    ->url(
                        fn( Result $tournament ): string => TournamentResource::getUrl( 'edit', [ 'record' => Tournament::Find( $tournament->tournament_id ) ] )
                    ),
            ] )
            ->bulkActions( [
            ] );
    }
}
