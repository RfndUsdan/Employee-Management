<?php

namespace App\Filament\Widgets;

use App\Models\Department;
use App\Models\Employee;
use App\Models\Position;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Karyawan', Employee::count())
                ->description('Jumlah SDM terdaftar')
                ->descriptionIcon('heroicon-m-users')
                ->color('success'),

            Stat::make('Total Departemen', Department::count())
                ->description('Unit kerja aktif')
                ->descriptionIcon('heroicon-m-building-office')
                ->color('info'),

            Stat::make('Total Jabatan', Position::count())
                ->description('Variasi peran')
                ->descriptionIcon('heroicon-m-briefcase')
                ->color('warning'),
        ];
    }
}