<?php

namespace App\Filament\Widgets;

use App\Models\TransactionMember;
use App\Models\Week;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;

class WeeklyIncomeChart extends ChartWidget
{
    protected static ?string $heading = 'Pemasukan Mingguan Anggota';
    protected static ?string $maxHeight = '300px';

    protected function getData(): array
    {
        // Ambil data pemasukan mingguan dari pembayaran anggota
        $weeklyData = TransactionMember::with('week')
            ->join('weeks', 'transaction_members.week_id', '=', 'weeks.id')
            ->selectRaw('weeks.name, weeks.start_date, SUM(transaction_members.amount) as total_amount')
            ->groupBy('weeks.id', 'weeks.name', 'weeks.start_date')
            ->orderBy('weeks.start_date', 'desc')
            ->limit(12) // Ambil 12 minggu terakhir
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Pemasukan Mingguan',
                    'data' => $weeklyData->pluck('total_amount'),
                    'borderColor' => '#3B82F6',
                    'backgroundColor' => '#DBEAFE',
                    'tension' => 0.4,
                ],
            ],
            'labels' => $weeklyData->pluck('name'),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}