<?php

namespace App\Filament\Resources;

use App\Exports\UserMeasurementExport;
use App\Filament\Resources\UserMeasurementResource\Pages;
use App\Models\UserMeasurement;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;

class UserMeasurementResource extends Resource
{
    protected static ?string $model = UserMeasurement::class;

    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';

    protected static ?string $navigationGroup = 'Hasil Tes';

    protected static ?string $navigationLabel = 'Pengukuran LILA';

    protected static ?string $pluralModelLabel = 'Pengukuran LILA';

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('lingkar_lengan')->label('Lingkar Lengan (cm)')->numeric()->disabled(),
            TextInput::make('panjang_lengan')->label('Panjang Lengan (cm)')->numeric()->disabled(),
            TextInput::make('ratio')->label('Rasio')->numeric()->disabled(),
            TextInput::make('risk_status')->label('Status Risiko')->disabled(),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('Pengguna')
                    ->searchable(),
                TextColumn::make('lingkar_lengan')
                    ->label('Lingkar Lengan (cm)')
                    ->formatStateUsing(fn ($state) => number_format((float) $state, 1)),
                TextColumn::make('panjang_lengan')
                    ->label('Panjang Lengan (cm)')
                    ->formatStateUsing(fn ($state) => number_format((float) $state, 1)),
                TextColumn::make('ratio')
                    ->label('Rasio')
                    ->formatStateUsing(fn ($state) => number_format((float) $state, 3)),
                BadgeColumn::make('risk_status')
                    ->label('Status Risiko')
                    ->colors([
                        'success' => 'Anda Tidak Berisiko KEK',
                        'danger' => 'Anda Berisiko Tinggi KEK',
                    ])
                    ->color(fn ($state) => str_contains($state, 'Tidak') ? 'success' : 'danger'),
                TextColumn::make('created_at')
                    ->label('Tanggal Pengukuran')
                    ->dateTime('d M Y H:i'),
            ])
            ->filters([
                SelectFilter::make('risk_status')
                    ->options(fn () => UserMeasurement::query()
                        ->select('risk_status')
                        ->distinct()
                        ->pluck('risk_status', 'risk_status')
                        ->filter()
                        ->all()),
            ])
            ->headerActions([
                Action::make('export')
                    ->label('Export Pengukuran')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('success')
                    ->action(function () {
                        $fileName = 'Pengukuran-LILA-' . now()->format('Y-m-d') . '.xlsx';

                        return Excel::download(new UserMeasurementExport, $fileName);
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
            'index' => Pages\ListUserMeasurements::route('/'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with('user');
    }
}
