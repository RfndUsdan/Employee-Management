<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmployeeResource\Pages;
use App\Filament\Resources\EmployeeResource\RelationManagers;
use App\Models\Employee;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class EmployeeResource extends Resource
{
    protected static ?string $model = Employee::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'Settings';

    // 1. Munculkan Angkanya (Badge)
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count(); // Ini akan menampilkan jumlah total karyawan
    }

    // 2. Munculkan Pesannya saat di-hover (Tooltip)
    public static function getNavigationBadgeTooltip(): ?string
    {
        return 'Total Karyawan Terdaftar';
    }

    // 3. Opsional: Mengubah Warna Badge
    public static function getNavigationBadgeColor(): ?string
    {
        return 'success'; // Warna hijau
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            // Bagian Foto Tetap Sama
            \Filament\Forms\Components\Section::make('Foto Profil')
                ->schema([
                    \Filament\Forms\Components\FileUpload::make('photo')
                        ->image()->avatar()->directory('employees')->imageEditor()->columnSpanFull(),
                ]),

            \Filament\Forms\Components\Section::make('Informasi Karyawan & Akun Login')
                ->description('Email ini akan digunakan untuk login.')
                ->schema([
                    \Filament\Forms\Components\TextInput::make('full_name')
                        ->label('Nama Lengkap')
                        ->required(),

                    \Filament\Forms\Components\TextInput::make('email')
                        ->label('Alamat Email')
                        ->email()
                        ->required()
                        ->unique(User::class, 'email', ignoreRecord: true), // Cek unik ke tabel User

                    \Filament\Forms\Components\TextInput::make('password')
                        ->label('Password Login')
                        ->password()
                        ->required(fn (string $context): bool => $context === 'create')
                        ->dehydrated(false), // PENTING: Jangan simpan ke tabel Employee

                    \Filament\Forms\Components\Select::make('department_id')
                        ->label('Departemen')
                        ->relationship('department', 'name')
                        ->required()
                        ->live()
                        ->afterStateUpdated(fn (callable $set) => $set('position_id', null)),

                    \Filament\Forms\Components\Select::make('position_id')
                        ->label('Jabatan')
                        ->options(function (\Filament\Forms\Get $get) {
                            $departmentId = $get('department_id');
                            return $departmentId ? \App\Models\Position::where('department_id', $departmentId)->pluck('name', 'id') : [];
                        })
                        ->required(),

                    \Filament\Forms\Components\TextInput::make('phone')
                        ->label('Nomor Telepon')->mask('9999-9999-9999')->tel()->required(),

                    \Filament\Forms\Components\DatePicker::make('join_date')
                        ->label('Tanggal Bergabung')->required()->native(false)->displayFormat('d/m/Y'),
                ])->columns(2),
        ]);
    }
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                \Filament\Tables\Columns\ImageColumn::make('photo')
                    ->label('Foto')
                    ->circular(), // Menampilkan gambar bulat

                \Filament\Tables\Columns\TextColumn::make('full_name')
                    ->label('Nama Lengkap')
                    ->searchable()
                    ->sortable(),

                \Filament\Tables\Columns\TextColumn::make('department.name')
                    ->label('Departemen')
                    ->badge()
                    ->color('info')
                    ->sortable(),

                \Filament\Tables\Columns\TextColumn::make('phone')
                    ->label('Telepon'),

                \Filament\Tables\Columns\TextColumn::make('join_date')
                    ->label('Bergabung')
                    ->date('d M Y')
                    ->sortable(),
                \Filament\Tables\Columns\TextColumn::make('position.name')
                    ->label('Jabatan')
                    ->badge()
                    ->color('gray')
                    ->sortable(),
            ])
            ->filters([
                \Filament\Tables\Filters\SelectFilter::make('department')
                    ->relationship('department', 'name')
            ])
            // --- TAMBAHKAN KODE DI BAWAH INI ---
            ->actions([
                \Filament\Tables\Actions\ActionGroup::make([
                    \Filament\Tables\Actions\ViewAction::make(),
                    \Filament\Tables\Actions\EditAction::make(),
                    \Filament\Tables\Actions\DeleteAction::make(),
                ])
            ])
            ->bulkActions([
                \Filament\Tables\Actions\BulkActionGroup::make([
                    \Filament\Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEmployees::route('/'),
            'create' => Pages\CreateEmployee::route('/create'),
            'edit' => Pages\EditEmployee::route('/{record}/edit'),
        ];
    }
}
