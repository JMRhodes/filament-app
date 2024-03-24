<?php

namespace App\Filament\Resources\TournamentResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use App\Models\Player;
use Illuminate\Database\Eloquent\Builder;

class ResultsRelationManager extends RelationManager {
    protected static string $relationship = 'results';

    public function form( Form $form ): Form {
        return $form
            ->schema( [
                Forms\Components\Select::make( 'player_id' )
                    ->relationship( 'players',
                        modifyQueryUsing: fn( Builder $query ) => $query->orderBy( 'last_name' )
                            ->orderBy( 'first_name' ),
                    )
                    ->required()
                    ->preload()
                    ->getOptionLabelFromRecordUsing( fn( Player $record ) => "{$record->first_name} {$record->last_name}" )
                    ->searchable( [ 'first_name', 'last_name' ] )
                    ->columnSpanFull(),
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
            ->recordTitleAttribute( 'position' )
            ->columns( [
                Tables\Columns\TextColumn::make( 'position' )->numeric(),
                Tables\Columns\TextColumn::make( 'players.first_name' )
                    ->label( 'First Name' ),
                Tables\Columns\TextColumn::make( 'players.last_name' )
                    ->label( 'Last Name' ),
                Tables\Columns\TextColumn::make( 'points' )->numeric(),
            ] )
            ->filters( [
                //
            ] )
            ->headerActions( [
                Tables\Actions\CreateAction::make(),
            ] )
            ->actions( [
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ] )
            ->bulkActions( [
                Tables\Actions\BulkActionGroup::make( [
                    Tables\Actions\DeleteBulkAction::make(),
                ] ),
            ] );
    }
}
