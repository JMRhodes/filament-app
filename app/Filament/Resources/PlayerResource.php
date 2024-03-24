<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PlayerResource\Pages;
use App\Filament\Resources\PlayerResource\RelationManagers;
use App\Models\Player;
use Filament\Forms\Components;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Number;

class PlayerResource extends Resource {
    protected static ?string $model = Player::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form( Form $form ): Form {
        return $form
            ->schema( [
                Components\Split::make( [
                    Components\Section::make( 'Player Info' )->schema( [
                        Components\TextInput::make( 'first_name' )
                            ->required()
                            ->columnSpan( 6 )
                            ->maxLength( 255 ),
                        Components\TextInput::make( 'last_name' )
                            ->required()
                            ->columnSpan( 6 )
                            ->maxLength( 255 ),
                        Components\TextInput::make( 'salary' )
                            ->required()
                            ->columnSpan( 3 )
                            ->numeric(),
                    ] )
                        ->columns( [
                            'sm' => 6,
                            'md' => 12,
                        ] ),
                    Components\Section::make( [
                        Components\FileUpload::make( 'photo' )
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
                Tables\Columns\Layout\Split::make( [
                    Tables\Columns\Layout\Split::make( [
                        Tables\Columns\ImageColumn::make( 'photo' )
                            ->circular()
                            ->grow( false ),
                        Tables\Columns\TextColumn::make( 'id' )
                            ->searchable( [ 'first_name', 'last_name' ] )
                            ->grow( false )
                            ->weight( FontWeight::Bold )
                            ->formatStateUsing( fn( Player $record ): string => __( "{$record->first_name} {$record->last_name}" ) )
                            ->description( fn( Player $record ): string => Number::currency( $record->salary ) ),
                    ] ),
                ] )
            ] )
            ->defaultSort( 'salary', 'desc' )
            ->defaultPaginationPageOption( 1 )
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
            'index'  => Pages\ListPlayers::route( '/' ),
            'create' => Pages\CreatePlayer::route( '/create' ),
            'edit'   => Pages\EditPlayer::route( '/{record}/edit' ),
        ];
    }
}
