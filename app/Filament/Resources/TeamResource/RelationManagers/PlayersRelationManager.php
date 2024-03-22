<?php

namespace App\Filament\Resources\TeamResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PlayersRelationManager extends RelationManager {
    protected static string $relationship = 'players';

    public function form( Form $form ): Form {
        return $form
            ->schema( [
                Forms\Components\TextInput::make( 'first' )
                    ->required()
                    ->maxLength( 255 ),
                Forms\Components\TextInput::make( 'last_name' )
                    ->required()
                    ->maxLength( 255 ),
            ] );
    }

    public function table( Table $table ): Table {
        return $table
            ->recordTitleAttribute( 'last_name' )
            ->columns( [
                Tables\Columns\TextColumn::make( 'first_name' ),
                Tables\Columns\TextColumn::make( 'last_name' ),
                Tables\Columns\TextColumn::make( 'salary' )->sortable(),
            ] )
            ->defaultSort( 'salary', 'desc' )
            ->filters( [
                //
            ] )
            ->headerActions( [
                Tables\Actions\AttachAction::make()
            ] )
            ->actions( [
                Tables\Actions\EditAction::make(),
                Tables\Actions\DetachAction::make()
            ] )
            ->bulkActions( [
                //
            ] );
    }
}
