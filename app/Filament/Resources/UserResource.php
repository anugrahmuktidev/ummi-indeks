<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'Manajemen Pengguna';

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('name')
                ->label('Nama')
                ->required()
                ->maxLength(255),
            TextInput::make('email')
                ->email()
                ->required()
                ->unique(ignoreRecord: true),
            TextInput::make('no_hp')
                ->tel()
                ->maxLength(20),
            DatePicker::make('tanggal_lahir')
                ->native(false),
            Select::make('jenis_kelamin')
                ->options([
                    'Laki-laki' => 'Laki-laki',
                    'Perempuan' => 'Perempuan',
                ])->native(false),
            TextInput::make('password')
                ->password()
                ->dehydrateStateUsing(fn ($state) => filled($state) ? Hash::make($state) : null)
                ->required(fn (string $context): bool => $context === 'create')
                ->label('Password')
                ->maxLength(255)
                ->dehydrated(fn ($state) => filled($state)),
            Select::make('role')
                ->required()
                ->options([
                    'admin' => 'Admin',
                    'user' => 'Pengguna',
                ])->native(false),
            Select::make('pendidikan')
                ->options([
                    'SD' => 'SD',
                    'SMP' => 'SMP',
                    'SMA' => 'SMA',
                    'Diploma' => 'Diploma',
                    'Sarjana' => 'Sarjana',
                    'Magister' => 'Magister',
                    'Doktor' => 'Doktor',
                ])->native(false),
            TextInput::make('pekerjaan')
                ->maxLength(255),
            TextInput::make('pekerjaan_lain')
                ->label('Pekerjaan Lain')
                ->maxLength(255),
            TextInput::make('alamat')
                ->maxLength(255),
            TextInput::make('kabupaten')
                ->maxLength(255),
            TextInput::make('provinsi')
                ->maxLength(255),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->searchable()->label('Nama'),
                TextColumn::make('email')->searchable(),
                BadgeColumn::make('role')
                    ->colors([
                        'success' => 'admin',
                        'primary' => 'user',
                    ])
                    ->label('Peran'),
                TextColumn::make('no_hp')->label('No HP'),
                TextColumn::make('tanggal_lahir')->date('d M Y'),
                TextColumn::make('created_at')->dateTime('d M Y H:i')->label('Dibuat'),
            ])
            ->filters([
                SelectFilter::make('role')
                    ->options([
                        'admin' => 'Admin',
                        'user' => 'Pengguna',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->visible(fn (User $record) => $record->id !== auth()->id()),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
