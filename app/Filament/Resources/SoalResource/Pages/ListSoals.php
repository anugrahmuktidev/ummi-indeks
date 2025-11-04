<?php

namespace App\Filament\Resources\SoalResource\Pages;

use App\Filament\Resources\SoalResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions;

class ListSoals extends ListRecords
{
    protected static string $resource = SoalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
