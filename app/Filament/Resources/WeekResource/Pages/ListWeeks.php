<?php

namespace App\Filament\Resources\WeekResource\Pages;

use App\Filament\Resources\WeekResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Carbon\Carbon;
use App\Models\Week;
use Filament\Notifications\Notification;
use Filament\Forms\Components\Select;

class ListWeeks extends ListRecords
{
    protected static string $resource = WeekResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\Action::make('generate_year')
                ->label('Generate Mingguan Tahun')
                ->icon('heroicon-o-calendar-days')
                ->color('success')
                ->form([
                    Select::make('tahun')
                        ->label('Tahun')
                        ->options([
                            2024 => '2024',
                            2025 => '2025',
                            2026 => '2026',
                            2027 => '2027',
                            2028 => '2028',
                            2029 => '2029',
                            2030 => '2030',
                        ])
                        ->default(now()->year)
                        ->required(),
                    Select::make('nominal_wajib')
                        ->label('Nominal Wajib per Minggu')
                        ->options([
                            5000 => 'Rp 5.000',
                            10000 => 'Rp 10.000',
                            15000 => 'Rp 15.000',
                            20000 => 'Rp 20.000',
                        ])
                        ->default(5000)
                        ->required(),
                ])
                ->action(function (array $data) {
                    $tahun = $data['tahun'];
                    $nominalWajib = $data['nominal_wajib'];

                    // Mulai dari 1 Januari tahun yang dipilih
                    $startDate = Carbon::create($tahun, 1, 1);

                    // Pastikan tanggal ini adalah hari Senin (dimulai minggu 1)
                    while ($startDate->dayOfWeek !== 1) { // 1 = Monday
                        $startDate->addDay();
                    }

                    // Generate minggu-minggu hingga akhir tahun yang dipilih
                    $endDate = Carbon::create($tahun, 12, 31);
                    $weekCount = 0;

                    while ($startDate->lessThanOrEqualTo($endDate)) {
                        // Periksa apakah minggu ini sudah ada di database
                        $existingWeek = Week::whereDate('start_date', $startDate->format('Y-m-d'))->first();

                        if (!$existingWeek) {
                            // Buat minggu baru
                            Week::create([
                                'name' => 'Minggu ' . ($weekCount + 1) . ' - ' . $tahun,
                                'nominal' => $nominalWajib,
                                'start_date' => $startDate->format('Y-m-d'),
                            ]);

                            $weekCount++;
                        }

                        // Pindah ke minggu berikutnya
                        $startDate->addWeek();
                    }

                    if ($weekCount > 0) {
                        Notification::make()
                            ->title("Berhasil membuat {$weekCount} minggu")
                            ->body("Mingguan untuk tahun {$tahun} telah dibuat")
                            ->success()
                            ->send();
                    } else {
                        Notification::make()
                            ->title("Tidak ada minggu baru yang dibuat")
                            ->body("Mungkin mingguan tahun {$tahun} sudah pernah di-generate sebelumnya")
                            ->warning()
                            ->send();
                    }
                })
                ->requiresConfirmation()
                ->modalHeading('Generate Mingguan Tahun')
                ->modalDescription('Pilih tahun dan nominal wajib per minggu')
                ->modalSubmitActionLabel('Generate Sekarang'),
        ];
    }
}
