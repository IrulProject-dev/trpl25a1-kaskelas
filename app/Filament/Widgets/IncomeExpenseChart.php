<?php

namespace App\Filament\Widgets;

use App\Models\Transaction;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;

class IncomeExpenseChart extends ChartWidget
{
    protected static ?string $heading = 'Pemasukan vs Pengeluaran';
    protected static ?string $maxHeight = '300px';

    protected function getData(): array
    {
        $incomeData = Trend::query(Transaction::where('type', 'income'))
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear(),
            )
            ->perMonth()
            ->sum('amount');

        $expenseData = Trend::query(Transaction::where('type', 'expense'))
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear(),
            )
            ->perMonth()
            ->sum('amount');

        return [
            'datasets' => [
                [
                    'label' => 'Pemasukan',
                    'data' => $incomeData->map(fn ($value) => $value->aggregate),
                    'borderColor' => '#10B981',
                    'backgroundColor' => '#ECFDF5',
                    'tension' => 0.4,
                ],
                [
                    'label' => 'Pengeluaran',
                    'data' => $expenseData->map(fn ($value) => $value->aggregate),
                    'borderColor' => '#EF4444',
                    'backgroundColor' => '#FEF2F2',
                    'tension' => 0.4,
                ],
            ],
            'labels' => $incomeData->map(fn ($value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}