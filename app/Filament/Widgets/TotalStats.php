<?php

namespace App\Filament\Widgets;

use App\Models\Transaction;
use App\Models\TransactionMember;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TotalStats extends BaseWidget
{
    protected function getStats(): array
    {
        // Total pemasukan dari transaksi umum
        $totalIncome = Transaction::where('type', 'income')
            ->sum('amount');
        
        // Total pengeluaran dari transaksi umum
        $totalExpense = Transaction::where('type', 'expense')
            ->sum('amount');
            
        // Total dari member/anggota yang telah dibayar
        $totalMemberPayments = TransactionMember::sum('amount');
        
        // Total kas keseluruhan (pemasukan dari member + transaksi umum - pengeluaran)
        $totalCash = $totalMemberPayments + $totalIncome - $totalExpense;

        return [
            Stat::make('Total Kas Keseluruhan', 'Rp ' . number_format($totalCash, 0, ',', '.'))
                ->description('Jumlah keseluruhan kas saat ini')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color($totalCash >= 0 ? 'success' : 'danger'),
                
            Stat::make('Pemasukan dari Anggota', 'Rp ' . number_format($totalMemberPayments, 0, ',', '.'))
                ->description('Dari pembayaran mingguan anggota')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('success'),
                
            Stat::make('Total Pemasukan', 'Rp ' . number_format($totalIncome + $totalMemberPayments, 0, ',', '.'))
                ->description('Pemasukan dari semua sumber')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
        ];
    }
}