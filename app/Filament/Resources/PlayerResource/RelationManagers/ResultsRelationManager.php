<?php

namespace App\Filament\Resources\PlayerResource\RelationManagers;

use App\Models\Result;
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
                    ->url( fn( Result $record ): string => "https://filament.lndo.site/admin/tournaments/{$record->tournament_id}/edit" )
            ] )
            ->bulkActions( [
            ] );
    }
}
