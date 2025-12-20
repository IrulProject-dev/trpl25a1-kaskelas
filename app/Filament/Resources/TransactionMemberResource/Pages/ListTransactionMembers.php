<?php

namespace App\Filament\Resources\TransactionMemberResource\Pages;

use App\Filament\Resources\TransactionMemberResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ListTransactionMembers extends ListRecords
{
    protected static string $resource = TransactionMemberResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\Action::make('generate_bills')
                ->label('Generate Tagihan Tahun Ini')
                ->color('success')
                ->icon('heroicon-o-arrow-path')
                ->requiresConfirmation()
                ->modalHeading('Generate Slot Tagihan?')
                ->modalDescription('Sistem akan membuat data Minggu 1-52 untuk tahun ini dan menyiapkan slot kosong untuk semua member. Lanjutkan?')
                ->action(function () {
                    // Panggil command yang kita buat di Langkah 1
                    Artisan::call('bills:generate', ['year' => Carbon::now()->year]);

                    Notification::make()
                        ->title('Berhasil!')
                        ->body('Data tagihan setahun berhasil dibuat.')
                        ->success()
                        ->send();

                    // Refresh halaman biar datanya muncul
                    return Redirect::back();
                }),
        ];
    }
}
