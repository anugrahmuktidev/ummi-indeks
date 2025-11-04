<?php

namespace App\Filament\Resources\SoalResource\Pages;

use App\Filament\Resources\SoalResource;
use App\Models\Soal;
use Filament\Resources\Pages\CreateRecord;

class CreateSoal extends CreateRecord
{
    protected static string $resource = SoalResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (empty($data['nomor_soal']) && ! empty($data['jenis_soal'])) {
            $data['nomor_soal'] = (Soal::where('jenis_soal', $data['jenis_soal'])->max('nomor_soal') ?? 0) + 1;
        }

        return $data;
    }

    protected function afterCreate(): void
    {
        Soal::reorderNomorSoal($this->record->jenis_soal);
    }
}
