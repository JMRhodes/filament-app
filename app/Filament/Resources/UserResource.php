<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\Team;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Spatie\Permission\Models\Role;

class UserResource extends Resource {
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    public static function form( Form $form ): Form {
        return $form
            ->schema( [
                Forms\Components\TextInput::make( 'name' )
                    ->required()
                    ->maxLength( 255 ),
                Forms\Components\TextInput::make( 'email' )
                    ->email()
                    ->required()
                    ->maxLength( 255 ),
                Forms\Components\DateTimePicker::make( 'email_verified_at' ),
                Forms\Components\TextInput::make( 'password' )
                    ->password()
                    ->required()
                    ->maxLength( 255 ),
            ] );
    }

    public static function table( Table $table ): Table {
        return $table
            ->columns( [
                Tables\Columns\TextColumn::make( 'name' )
                    ->searchable(),
                Tables\Columns\TextColumn::make( 'email' )
                    ->searchable(),
                Tables\Columns\TextColumn::make( 'teams.id' )
                    ->formatStateUsing( fn( Team $team ): string => $team->all()->count() ),
                Tables\Columns\TextColumn::make( 'roles' )
                    ->label( 'Role' )
                    ->formatStateUsing( fn( User $user ): string => $user->getRoleNames()->first() )
                    ->badge()
                    ->color( fn( Role $state ): string => match ( $state->name ) {
                        'Super-Admin' => 'success',
                        'Admin' => 'warning',
                        default => 'gray'
                    } ),
                Tables\Columns\TextColumn::make( 'created_at' )
                    ->dateTime()
                    ->sortable()
                    ->toggleable( isToggledHiddenByDefault: true ),
                Tables\Columns\TextColumn::make( 'updated_at' )
                    ->dateTime()
                    ->sortable()
                    ->toggleable( isToggledHiddenByDefault: true ),
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
            RelationManagers\TeamsRelationManager::class
        ];
    }

    public static function getPages(): array {
        return [
            'index'  => Pages\ListUsers::route( '/' ),
            'create' => Pages\CreateUser::route( '/create' ),
            'edit'   => Pages\EditUser::route( '/{record}/edit' ),
        ];
    }
}
