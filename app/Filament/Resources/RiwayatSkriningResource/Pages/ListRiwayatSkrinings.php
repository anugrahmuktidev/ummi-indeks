<?php

namespace App\Filament\Resources\RiwayatSkriningResource\Pages;

use App\Filament\Resources\RiwayatSkriningResource;
use Filament\Resources\Pages\ListRecords;

class ListRiwayatSkrinings extends ListRecords
{
    protected static string $resource = RiwayatSkriningResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
