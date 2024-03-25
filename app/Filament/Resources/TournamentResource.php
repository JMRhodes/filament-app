<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TournamentResource\Pages;
use App\Filament\Resources\TournamentResource\RelationManagers;
use App\Models\Tournament;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TournamentResource extends Resource {
    protected static ?string $model = Tournament::class;

    protected static ?string $navigationIcon = 'heroicon-o-table-cells';

    public static function form( Form $form ): Form {
        return $form
            ->schema( [
                Forms\Components\Split::make( [
                    Forms\Components\Section::make( 'Tournament Info' )->schema( [
                        Forms\Components\TextInput::make( 'name' )
                            ->required()
                            ->columnSpan( 12 )
                            ->maxLength( 255 ),
                        Forms\Components\DatePicker::make( 'started_at' )
                            ->columnSpan( 6 )
                            ->required(),
                        Forms\Components\DatePicker::make( 'ended_at' )
                            ->columnSpan( 6 )
                            ->required(),
                    ] )
                        ->columns( [
                            'sm' => 6,
                            'md' => 12,
                        ] ),
                    Forms\Components\Section::make( [
                        Forms\Components\FileUpload::make( 'photo' )
                            ->avatar()
                            ->columnSpanFull()
                            ->moveFiles()
                    ] )->grow( false )
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
                Tables\Columns\TextColumn::make( 'started_at' )
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make( 'ended_at' )
                    ->date()
                    ->sortable(),
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
            RelationManagers\ResultsRelationManager::class
        ];
    }

    public static function getPages(): array {
        return [
            'index'  => Pages\ListTournaments::route( '/' ),
            'create' => Pages\CreateTournament::route( '/create' ),
            'edit'   => Pages\EditTournament::route( '/{record}/edit' ),
        ];
    }
}
