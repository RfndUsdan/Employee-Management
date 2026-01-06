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

class EmployeeResource extends Resource
{
    protected static ?string $model = Employee::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Kita bagi menjadi 2 baris agar tampilannya tidak terlalu panjang ke bawah
                \Filament\Forms\Components\Section::make('Foto Profil')
                    ->description('Unggah foto resmi karyawan di sini.')
                    ->schema([
                        \Filament\Forms\Components\FileUpload::make('photo')
                            ->label('')
                            ->image()
                            ->avatar() // Menampilkan preview bulat
                            ->directory('employees') // Folder di storage/app/public/employees
                            ->imageEditor() // Fitur Filament: bisa crop gambar langsung!
                            ->columnSpanFull(),
                    ]),

                \Filament\Forms\Components\Section::make('Informasi Karyawan')
                    ->schema([
                        \Filament\Forms\Components\TextInput::make('full_name')
                            ->label('Nama Lengkap')
                            ->required(),

                        \Filament\Forms\Components\TextInput::make('email')
                            ->label('Alamat Email')
                            ->email()
                            ->required()
                            ->unique(ignoreRecord: true),

                        \Filament\Forms\Components\Select::make('department_id')
                            ->label('Departemen')
                            ->relationship('department', 'name') // Mengambil data dari tabel departments
                            ->required()
                            ->searchable() // Bisa diketik untuk mencari
                            ->preload(), // Memuat data di awal agar cepat

                        \Filament\Forms\Components\TextInput::make('phone')
                            ->label('Nomor Telepon')
                            ->mask('9999-9999-9999') // Masking sesuai permintaan Anda
                            ->tel()
                            ->required(),

                        \Filament\Forms\Components\DatePicker::make('join_date')
                            ->label('Tanggal Bergabung')
                            ->required()
                            ->native(false) // Menggunakan kalender popup yang lebih cantik
                            ->displayFormat('d/m/Y'),
                    ])->columns(2), // Membuat inputan menjadi 2 kolom (berjejer)
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
            ])
            ->filters([
                \Filament\Tables\Filters\SelectFilter::make('department')
                    ->relationship('department', 'name')
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
