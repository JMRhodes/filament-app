<?php

namespace App\Filament\Resources\TournamentResource\RelationManagers;

use App\Models\Player;
use App\Models\Result;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ResultsRelationManager extends RelationManager
{
    protected static string $relationship = 'results';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('player_id')
                    ->relationship('players',
                        modifyQueryUsing: fn (Builder $query) => $query->orderBy('last_name')
                            ->orderBy('first_name'),
                    )
                    ->required()
                    ->preload()
                    ->getOptionLabelFromRecordUsing(fn (Player $record) => "{$record->first_name} {$record->last_name}")
                    ->searchable(['first_name', 'last_name'])
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('position')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('points')
                    ->required()
                    ->numeric(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('players.last_name')
            ->columns([
                Tables\Columns\TextColumn::make('position')->numeric(),
                Tables\Columns\TextColumn::make('players.first_name')
                    ->label('Name')
                    ->formatStateUsing(fn (Result $record): string => $record->players->first()->full_name),
                Tables\Columns\TextColumn::make('points')->numeric(),
            ])
            ->paginated(false)
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make()
                        ->modalHeading(__('Delete player?')),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
