<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SoalResource\Pages;
use App\Filament\Resources\SoalResource\RelationManagers\JawabansRelationManager;
use App\Models\Soal;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextArea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class SoalResource extends Resource
{
    protected static ?string $model = Soal::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';

    protected static ?string $navigationGroup = 'Manajemen Tes';

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('nomor_soal')
                ->numeric()
                ->minValue(1)
                ->required()
                ->unique(ignoreRecord: true),
            TextArea::make('soal')
                ->rows(4)
                ->required(),
            Select::make('jenis_soal')
                ->required()
                ->options([
                    'Pre Test' => 'Pre Test',
                    'Post Test' => 'Post Test',
                    'Skrining' => 'Skrining',
                ])->native(false),
        ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nomor_soal')
                    ->sortable()
                    ->label('Nomor'),
                TextColumn::make('soal')
                    ->limit(60)
                    ->label('Pertanyaan')
                    ->searchable(),
                BadgeColumn::make('jenis_soal')
                    ->colors([
                        'warning' => 'Pre Test',
                        'success' => 'Post Test',
                        'primary' => 'Skrining',
                    ]),
                TextColumn::make('jawaban_count')
                    ->label('Jumlah Jawaban')
                    ->sortable(),
                TextColumn::make('updated_at')
                    ->dateTime('d M Y H:i')
                    ->label('Diubah'),
            ])
            ->filters([
                SelectFilter::make('jenis_soal')
                    ->label('Jenis Soal')
                    ->options([
                        'Pre Test' => 'Pre Test',
                        'Post Test' => 'Post Test',
                        'Skrining' => 'Skrining',
                    ]),
            ])
            ->groups([
                Group::make('jenis_soal')
                    ->collapsible()
                    ->label('Jenis Soal'),
            ])
            ->defaultGroup('jenis_soal')
            ->defaultSort('jenis_soal')
            ->defaultSort('nomor_soal')
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            JawabansRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSoals::route('/'),
            'create' => Pages\CreateSoal::route('/create'),
            'edit' => Pages\EditSoal::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withCount('jawaban')
            ->orderBy('jenis_soal')
            ->orderBy('nomor_soal');
    }
}
