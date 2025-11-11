<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SoalResource\Pages;
use App\Filament\Resources\SoalResource\RelationManagers\JawabansRelationManager;
use App\Models\Soal;
use App\Rules\HasCorrectAnswer;
use Filament\Forms;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Validation\Rule;

class SoalResource extends Resource
{
    protected static ?string $model = Soal::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';

    protected static ?string $navigationGroup = 'Manajemen Tes';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi Soal')
                    ->schema([
                        Select::make('jenis_soal')
                            ->label('Jenis Soal')
                            ->options([
                                'Pre Test' => 'Pre Test',
                                'Post Test' => 'Post Test',
                            ])
                            ->live()
                            ->required()
                            ->native(false)
                            ->afterStateUpdated(function (Set $set, ?string $state): void {
                                if (! $state) {
                                    return;
                                }

                                $set('nomor_soal', Soal::getNextNomorSoal($state));
                            }),
                        TextInput::make('nomor_soal')
                            ->label('Nomor Soal')
                            ->numeric()
                            ->minValue(1)
                            ->helperText('Biarkan kosong untuk penomoran otomatis berdasarkan jenis soal.')
                            ->rule(function (Get $get, ?Soal $record) {
                                $jenis = $get('jenis_soal');

                                if (! $jenis) {
                                    return null;
                                }

                                return Rule::unique('soal', 'nomor_soal')
                                    ->where('jenis_soal', $jenis)
                                    ->ignore($record?->getKey());
                            }),
                        Textarea::make('soal')
                            ->label('Pertanyaan')
                            ->rows(4)
                            ->required()
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
                Section::make('Pilihan Jawaban')
                    ->description('Lengkapi minimal dua pilihan dan tandai kunci jawaban.')
                    ->schema([
                        Repeater::make('jawaban')
                            ->relationship('jawaban')
                            ->label('Pilihan Jawaban')
                            ->minItems(2)
                            ->reorderable()
                            ->createItemButtonLabel('Tambah Pilihan')
                            ->schema([
                                Textarea::make('jawaban')
                                    ->label('Teks Jawaban')
                                    ->rows(3)
                                    ->required()
                                    ->columnSpan(2),
                                TextInput::make('poin_soal')
                                    ->label('Poin')
                                    ->numeric()
                                    ->default(0)
                                    ->minValue(0),
                                Checkbox::make('kunci_jawaban')
                                    ->label('Kunci Jawaban')
                                    ->columnSpan(1),
                            ])
                            ->columns(3)
                            ->rules(['array', new HasCorrectAnswer()]),
                    ]),
            ]);
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
