<?php

namespace App\Filament\Resources\UserMeasurementResource\Pages;

use App\Filament\Resources\UserMeasurementResource;
use Filament\Resources\Pages\ListRecords;

class ListUserMeasurements extends ListRecords
{
    protected static string $resource = UserMeasurementResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}

