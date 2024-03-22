<?php

namespace App\Filament\Resources\PlayerResource\Pages;

use App\Filament\Imports\PlayerImporter;
use App\Filament\Resources\PlayerResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPlayers extends ListRecords
{
    protected static string $resource = PlayerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ImportAction::make()
                ->importer(PlayerImporter::class),
            Actions\CreateAction::make(),
        ];
    }
}
