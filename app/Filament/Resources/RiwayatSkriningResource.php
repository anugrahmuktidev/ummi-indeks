<?php

namespace App\Filament\Resources;

use App\Exports\SkriningExport;
use App\Filament\Resources\RiwayatSkriningResource\Pages;
use App\Models\UserRiskAssessment;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;

class RiwayatSkriningResource extends Resource
{
    protected static ?string $model = UserRiskAssessment::class;

    protected static ?string $navigationIcon = 'heroicon-o-heart';

    protected static ?string $navigationGroup = 'Hasil Tes';
    protected static ?string $navigationLabel = 'Riwayat Risiko KEK';
    protected static ?string $pluralModelLabel = 'Penilaian Risiko KEK';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Select::make('user_id')
                ->relationship('user', 'name')
                ->searchable()
                ->preload()
                ->disabled(),
            TextInput::make('probabilitas')
                ->numeric()
                ->suffix('%')
                ->disabled(),
            TextInput::make('total_skor')
                ->disabled(),
            TextInput::make('kategori')
                ->disabled(),
            TextInput::make('catatan')
                ->columnSpanFull()
                ->disabled(),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')->label('Pengguna')->searchable(),
                TextColumn::make('created_at')->label('Tanggal')->dateTime('d M Y H:i'),
                TextColumn::make('probabilitas')->label('Probabilitas (%)')->formatStateUsing(fn ($state) => number_format((float) $state, 2)),
                TextColumn::make('total_skor')->label('Total Skor'),
                TextColumn::make('kategori')
                    ->label('Kategori')
                    ->badge()
                    ->color(fn ($state) => str_contains($state, 'Tinggi') ? 'danger' : 'success'),
            ])
            ->filters([
                SelectFilter::make('kategori')
                    ->options(fn () => UserRiskAssessment::query()
                        ->select('kategori')
                        ->distinct()
                        ->pluck('kategori', 'kategori')
                        ->filter()
                        ->all()),
            ])
            ->headerActions([
                Action::make('export')
                    ->label('Export Penilaian Risiko')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('success')
                    ->action(function () {
                        $fileName = 'Penilaian-Risiko-' . now()->format('Y-m-d') . '.xlsx';

                        return Excel::download(new SkriningExport, $fileName);
                    })
                    ->requiresConfirmation(),
            ])
            ->actions([
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRiwayatSkrinings::route('/'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with('user');
    }
}
