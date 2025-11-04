<?php

namespace App\Filament\Resources\SoalResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class JawabansRelationManager extends RelationManager
{
    protected static string $relationship = 'jawaban';

    protected static ?string $recordTitleAttribute = 'jawaban';

    public function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            TextInput::make('jawaban')
                ->required()
                ->maxLength(255),
            TextInput::make('poin_soal')
                ->numeric()
                ->default(0)
                ->required(),
            Checkbox::make('kunci_jawaban')
                ->label('Kunci jawaban'),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('jawaban')->wrap()->label('Jawaban'),
                IconColumn::make('kunci_jawaban')
                    ->label('Benar?')
                    ->boolean(),
                TextColumn::make('poin_soal'),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}
