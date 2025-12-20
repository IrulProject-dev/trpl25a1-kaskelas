<?php

namespace App\Filament\Widgets;

use App\Models\TransactionMember;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;

class WeeklyMemberIncomeChart extends ChartWidget
{
    protected static ?string $heading = 'Pendapatan Mingguan Anggota';
    protected static ?string $maxHeight = '300px';

    protected function getData(): array
    {
        // Ambil data transaksi anggota per minggu
        $weeklyIncome = Trend::query(TransactionMember::where('amount', '>', 0))
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear(),
            )
            ->perMonth() // Bisa diubah ke perWeek jika ingin per minggu
            ->sum('amount');

        return [
            'datasets' => [
                [
                    'label' => 'Pendapatan Anggota',
                    'data' => $weeklyIncome->map(fn ($value) => $value->aggregate),
                    'borderColor' => '#3B82F6',
                    'backgroundColor' => '#DBEAFE',
                    'tension' => 0.4,
                ],
            ],
            'labels' => $weeklyIncome->map(fn ($value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}