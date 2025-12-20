<?php

namespace App\Filament\Pages;

use App\Models\Transaction;
use App\Models\TransactionMember;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Widgets;
use Flowframe\Trend\Trend;

class Dashboard extends BaseDashboard
{
    public function getHeading(): string
    {
        return 'Dashboard Keuangan';
    }

    public function getSubheading(): ?string
    {
        return 'Ringkasan laporan keuangan kas kelas';
    }

    protected function getHeaderWidgets(): array
    {
        return [
            Widgets\StatsOverviewWidget::class,
        ];
    }

    public function getWidgets(): array
    {
        return [
            // Baris pertama: Grafik total uang dan grafik pemasukan vs pengeluaran
            [
                \App\Filament\Widgets\TotalMoneyChart::class,
                \App\Filament\Widgets\IncomeExpenseChart::class,
            ],

            // Baris kedua: Pendapatan mingguan anggota dan pendapatan mingguan
            [
                \App\Filament\Widgets\WeeklyMemberIncomeChart::class,
                \App\Filament\Widgets\WeeklyIncomeChart::class,
            ],
        ];
    }

    public function getColumns(): int | array
    {
        return [
            'default' => 1,  // Default satu kolom untuk semua widget (menyusun vertikal)
            'sm' => 1,       // Tetap satu kolom di ukuran kecil
            'md' => 2,       // Dua kolom di ukuran menengah
            'lg' => 3,       // Tiga kolom di ukuran besar
        ];
    }

    protected function getHeaderWidgetColumns(): int | array
    {
        return 3;
    }
}
