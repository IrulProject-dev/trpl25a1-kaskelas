<?php

namespace App\Filament\Widgets;

use App\Models\Transaction;
use App\Models\TransactionMember;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;

class TotalMoneyChart extends ChartWidget
{
    protected static ?string $heading = 'Total Kas Keseluruhan (3 Bulan Terakhir)';
    protected static ?string $maxHeight = '300px';

    protected function getData(): array
    {
        // Calculate start date for the last 3 months
        $startDate = now()->subMonths(3)->startOfMonth();
        $endDate = now();

        // Calculate total income per week for the last 3 months
        $incomeData = Trend::query(Transaction::where('type', 'income'))
            ->between(
                start: $startDate,
                end: $endDate,
            )
            ->perWeek()
            ->sum('amount');

        // Calculate total expense per week for the last 3 months
        $expenseData = Trend::query(Transaction::where('type', 'expense'))
            ->between(
                start: $startDate,
                end: $endDate,
            )
            ->perWeek()
            ->sum('amount');

        // Calculate total member payments per week manually to avoid SQL issues
        $memberPaymentResults = collect();
        $currentDate = clone $startDate;
        $endDateClone = clone $endDate;

        while ($currentDate <= $endDateClone) {
            $weekStart = clone $currentDate;
            $weekEnd = (clone $currentDate)->addWeek()->subDay();

            // Ensure we don't go past the end date
            if ($weekEnd > $endDateClone) {
                $weekEnd = $endDateClone;
            }

            $paymentAmount = TransactionMember::whereBetween('created_at', [$weekStart, $weekEnd])
                ->sum('amount');

            $memberPaymentResults->push((object)[
                'aggregate' => $paymentAmount,
                'date' => $weekStart
            ]);

            $currentDate = $currentDate->addWeek();
        }

        // Calculate cumulative total over time
        $cumulativeTotals = [];
        $runningTotal = 0;

        $dataCount = max(count($incomeData), count($expenseData), count($memberPaymentResults));
        for ($index = 0; $index < $dataCount; $index++) {
            $weeklyIncome = $incomeData[$index]->aggregate ?? 0;
            $weeklyExpense = $expenseData[$index]->aggregate ?? 0;
            $weeklyMemberPayment = $memberPaymentResults[$index]->aggregate ?? 0;

            $weeklyChange = $weeklyIncome + $weeklyMemberPayment - $weeklyExpense;
            $runningTotal += $weeklyChange;
            $cumulativeTotals[] = $runningTotal;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Total Kas',
                    'data' => $cumulativeTotals,
                    'borderColor' => '#8B5CF6',
                    'backgroundColor' => '#F3E8FF',
                    'tension' => 0.4,
                ],
            ],
            'labels' => $incomeData->map(function ($value) {
                if (is_string($value->date)) {
                    return date('d M', strtotime($value->date));
                } else {
                    return $value->date->format('d M');
                }
            }),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}