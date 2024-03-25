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

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

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
                Tables\Columns\ImageColumn::make( 'photo' )
                    ->label( '' )
                    ->circular()
                    ->grow( false ),
                Tables\Columns\TextColumn::make( 'first_name' )
                    ->label( 'Name' )
                    ->searchable( [ 'first_name', 'last_name' ] )
                    ->weight( FontWeight::Bold )
                    ->formatStateUsing( fn( Player $record ): string => __( "{$record->first_name} {$record->last_name}" ) )
                    ->description( fn( Player $record ): string => "$" . number_format( $record->salary, 0 ) ),
                Tables\Columns\TextColumn::make( 'id' )
                    ->label( 'Points' )
                    ->grow( false )
                    ->formatStateUsing( fn( Player $record ): string => $record->results->sum( 'points' ) )
            ] )
            ->defaultSort( 'salary', 'desc' )
            ->defaultPaginationPageOption( 25 )
            ->paginated( [ 25, 50, 100, 'all' ] )
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
