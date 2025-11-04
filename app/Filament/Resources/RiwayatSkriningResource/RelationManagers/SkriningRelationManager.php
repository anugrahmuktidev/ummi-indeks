<?php

namespace App\Filament\Resources\RiwayatSkriningResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SkriningRelationManager extends RelationManager
{
    protected static string $relationship = 'jawabans';

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('soal.nomor_soal')->label('Nomor'),
                TextColumn::make('soal.soal')->label('Soal')->wrap()->limit(80),
                TextColumn::make('jawaban.jawaban')->label('Jawaban')->wrap()->limit(80),
                IconColumn::make('jawaban.kunci_jawaban')->label('Benar?')->boolean(),
            ])
            ->actions([])
            ->paginated(false);
    }
}
