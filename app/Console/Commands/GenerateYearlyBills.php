<?php

namespace App\Console\Commands;

use App\Models\Member;
use App\Models\TransactionMember;
use App\Models\Week;
use Carbon\Carbon;
use Illuminate\Console\Command;

class GenerateYearlyBills extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bills:generate {year?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate weekly bills for members for a given year';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $year = $this->argument('year') ?? now()->year;
        $this->info("Memulai generate data untuk tahun $year...");

        $startDate = Carbon::create($year, 1, 1)->startOfWeek();

        for ($i = 1; $i <= 52; $i++) {
            $weekName = "Minggu ke-$i ($year)";

            $week = Week::firstOrCreate(
                [
                    'name' => $weekName,
                    'start_date' => $startDate->format('Y-m-d'),
                ],
                ['nominal' => 5000] // Default tagihan
            );

            $members = Member::all();
            foreach ($members as $member) {
                TransactionMember::firstOrCreate(
                    [
                        'member_id' => $member->id,
                        'week_id' => $week->id,
                    ],
                    [
                        'amount' => 0 // Default 0 (Belum Bayar)
                    ]
                );
            }
            $startDate->addWeek();
        }
        $this->info("Selesai! Data minggu dan slot member tahun $year berhasil dibuat.");
    }
}
