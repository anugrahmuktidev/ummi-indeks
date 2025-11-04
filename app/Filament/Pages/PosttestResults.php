<?php

namespace App\Filament\Pages;

use App\Exports\PosttestExport;
use App\Models\RiwayatSkrining;
use Filament\Pages\Page;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Facades\Excel;

class PosttestResults extends Page implements HasTable
{
    use InteractsWithTable;

    protected static string $view = 'filament.pages.posttest-results';

    protected static ?string $navigationIcon = 'heroicon-o-check-badge';

    protected static ?string $navigationGroup = 'Hasil Tes';

    protected static ?string $navigationLabel = 'Posttest';

    protected static ?string $title = 'Hasil Posttest';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                RiwayatSkrining::query()
                    ->with('user')
                    ->withCount('jawabans')
                    ->where('jenis_sesi', 'Post Test')
                    ->where('status', 'Completed')
                    ->latest('tanggal')
            )
            ->columns([
                TextColumn::make('user.name')
                    ->label('Pengguna')
                    ->searchable(),
                TextColumn::make('jawabans_count')
                    ->label('Total Soal Terjawab')
                    ->counts('jawabans'),
                TextColumn::make('jawabans_count_benar')
                    ->label('Jawaban Benar')
                    ->state(fn (Model $record) => $record->jawabans()
                        ->whereHas('jawaban', fn ($query) => $query->where('kunci_jawaban', true))
                        ->count()),
                TextColumn::make('jumlah_edukasi')
                    ->label('Jumlah Edukasi'),
                TextColumn::make('tanggal')
                    ->label('Tanggal')
                    ->dateTime('d M Y H:i'),
            ])
            ->actions([
                Action::make('lihat_biodata')
                    ->label('Lihat Biodata')
                    ->icon('heroicon-o-user-circle')
                    ->modalHeading('Biodata Pengguna')
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Tutup')
                    ->modalContent(fn (Model $record) => view('filament.pages.partials.user-biodata', [
                        'user' => $record->user,
                    ])),
            ])
            ->headerActions([
                Action::make('export')
                    ->label('Export Posttest')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('success')
                    ->action(function () {
                        $fileName = 'Posttest-' . now()->format('Y-m-d') . '.xlsx';

                        return Excel::download(new PosttestExport, $fileName);
                    })
                    ->requiresConfirmation(),
            ]);
    }
}
