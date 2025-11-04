<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JawabanResource\Pages;
use App\Models\Jawaban;
use Filament\Forms;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class JawabanResource extends Resource
{
    protected static ?string $model = Jawaban::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-bottom-center-text';

    protected static ?string $navigationGroup = 'Manajemen Tes';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Select::make('soal_id')
                ->label('Soal')
                ->relationship(
                    name: 'soal',
                    titleAttribute: 'soal'
                )
                ->searchable()
                ->preload()
                ->required(),
            TextInput::make('jawaban')
                ->required()
                ->maxLength(255),
            TextInput::make('poin_soal')
                ->numeric()
                ->default(0)
                ->required(),
            Checkbox::make('kunci_jawaban')
                ->label('Kunci jawaban'),
        ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        $soalGroup = Group::make('soal_id')
            ->label('Soal')
            ->collapsible()
            ->getTitleFromRecordUsing(fn (Jawaban $record) => sprintf('%s - %s. %s', $record->soal->jenis_soal, $record->soal->nomor_soal, $record->soal->soal));

        return $table
            ->columns([
                TextColumn::make('jawaban')
                    ->label('Jawaban')
                    ->wrap()
                    ->limit(80)
                    ->searchable(),
                IconColumn::make('kunci_jawaban')
                    ->label('Benar?')
                    ->boolean(),
                TextColumn::make('poin_soal')
                    ->label('Poin')
                    ->numeric(),
                TextColumn::make('updated_at')
                    ->label('Diubah')
                    ->dateTime('d M Y H:i'),
            ])
            ->filters([
                SelectFilter::make('jenis_soal')
                    ->label('Jenis Soal')
                    ->options([
                        'Pre Test' => 'Pre Test',
                        'Post Test' => 'Post Test',
                        'Skrining' => 'Skrining',
                    ])
                    ->query(function (Builder $query, array $data) {
                        $value = $data['value'] ?? null;

                        if (! $value) {
                            return;
                        }

                        $query->whereHas('soal', fn (Builder $soalQuery) => $soalQuery->where('jenis_soal', $value));
                    }),
                TernaryFilter::make('kunci_jawaban')
                    ->label('Kunci Jawaban'),
            ])
            ->groups([$soalGroup])
            ->defaultGroup($soalGroup)
            ->defaultSort('soal.jenis_soal')
            ->defaultSort('soal.nomor_soal')
            ->defaultSort('kunci_jawaban', 'desc')
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListJawabans::route('/'),
            'create' => Pages\CreateJawaban::route('/create'),
            'edit' => Pages\EditJawaban::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with(['soal']);
    }
}
