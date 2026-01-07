<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PositionResource\Pages;
use App\Filament\Resources\PositionResource\RelationManagers;
use App\Models\Position;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PositionResource extends Resource
{
    protected static ?string $model = Position::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    // Bagian Form
    public static function form(Form $form): Form
    {
        return $form->schema([
            \Filament\Forms\Components\Card::make()->schema([
                \Filament\Forms\Components\Select::make('department_id')
                    ->label('Departemen')
                    ->relationship('department', 'name')
                    ->required()
                    ->preload(),
            
            \Filament\Forms\Components\TextInput::make('name')
                    ->label('Nama Jabatan')
                    ->required()
                    ->unique(ignoreRecord: true),
            ])
        ]);
    }

    // Bagian Table
    public static function table(Table $table): Table
    {
        return $table->columns([
            \Filament\Tables\Columns\TextColumn::make('department.name')
                ->label('Departemen')
                ->badge()
                ->color('info')
                ->sortable(),
            
            \Filament\Tables\Columns\TextColumn::make('name')
                ->label('Jabatan')
                ->searchable()
                ->sortable(),
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
            'index' => Pages\ListPositions::route('/'),
            'create' => Pages\CreatePosition::route('/create'),
            'edit' => Pages\EditPosition::route('/{record}/edit'),
        ];
    }
}
