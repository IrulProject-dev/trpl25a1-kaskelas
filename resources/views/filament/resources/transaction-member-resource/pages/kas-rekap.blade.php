<x-filament-panels::page>
    <div class="w-full overflow-x-auto rounded-xl shadow-sm bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700">
        <div class="overflow-x-auto">
            <table class="w-full text-sm border-collapse text-center min-w-max">
                <thead class="bg-primary-50 dark:bg-primary-900/30 font-semibold text-gray-700 dark:text-gray-200 uppercase">
                    <tr>
                        <th rowspan="2" class="p-4 border-r border-b border-gray-200 dark:border-gray-700 sticky left-0 z-30 bg-inherit text-left min-w-[60px]">
                            <span class="text-primary-600 dark:text-primary-400 font-bold">No</span>
                        </th>
                        <th rowspan="2" class="p-4 border-r border-b border-gray-200 dark:border-gray-700 sticky left-16 z-30 bg-inherit text-left min-w-[200px]">
                            <span class="text-primary-600 dark:text-primary-400 font-bold">Nama Lengkap</span>
                        </th>
                        <th rowspan="2" class="p-4 border-r border-b border-gray-200 dark:border-gray-700 sticky left-64 z-30 bg-inherit text-center min-w-[120px]">
                            <span class="text-primary-600 dark:text-primary-400 font-bold">NIM</span>
                        </th>

                        @foreach($months as $monthName => $weeksInMonth)
                            <th colspan="{{ count($weeksInMonth) }}" class="p-3 border-b border-r border-gray-200 dark:border-gray-700 text-primary-600 dark:text-primary-400 bg-primary-100/70 dark:bg-primary-900/50">
                                <span class="font-bold text-sm">{{ $monthName }}</span>
                            </th>
                        @endforeach
                        <th rowspan="2" class="p-4 border-r border-b border-gray-200 dark:border-gray-700 sticky right-0 z-30 bg-inherit text-center min-w-[120px]">
                            <span class="text-primary-600 dark:text-primary-400 font-bold">Info Minggu Ini</span>
                        </th>
                    </tr>

                    <tr>
                        @foreach($months as $weeksInMonth)
                            @foreach($weeksInMonth as $index => $week)
                                <th class="p-2 border-b border-gray-200 dark:border-gray-700 text-primary-700 dark:text-primary-300 bg-primary-50 dark:bg-primary-900/40 text-xs font-medium min-w-[70px]">
                                    <span class="block">M{{ $index + 1 }}</span>
                                </th>
                            @endforeach
                        @endforeach
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($members as $index => $member)
                    <tr>
                        <td class="p-4 border-r border-gray-200 dark:border-gray-700 sticky left-0 z-10 bg-white dark:bg-gray-800 font-semibold text-primary-600 dark:text-primary-400">
                            {{ $index + 1 }}
                        </td>

                        <td class="p-4 border-r border-gray-200 dark:border-gray-700 sticky left-16 z-10 bg-white dark:bg-gray-800 text-left font-medium text-gray-800 dark:text-gray-200">
                            {{ $member->name }}
                        </td>

                        <td class="p-4 border-r border-gray-200 dark:border-gray-700 sticky left-64 z-10 bg-white dark:bg-gray-800 text-center text-gray-600 dark:text-gray-300">
                            {{ $member->nim }}
                        </td>

                        @foreach($months as $weeksInMonth)
                            @foreach($weeksInMonth as $week)
                                @php
                                    // Cek pembayaran member ini di minggu ini
                                    $trx = $member->transaction_members->firstWhere('week_id', $week->id);
                                    $amount = $trx ? $trx->amount : 0;
                                    $target = $week->nominal;

                                    // Logika status pembayaran: hijau=lunas, kuning=kurang bayar, merah=tidak bayar
                                    if ($amount >= $target) {
                                        $textClass = 'text-green-600 dark:text-green-400'; // Lunas (Hijau)
                                    } elseif ($amount > 0 && $amount < $target) {
                                        $textClass = 'text-yellow-500 dark:text-yellow-300'; // Kurang bayar (Kuning)
                                    } else {
                                        $textClass = 'text-red-600 dark:text-red-400'; // Tidak bayar (Merah)
                                    }
                                @endphp

                                <td class="p-1 border border-gray-200 dark:border-gray-700 cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700"
                                    wire:click="openInput({{ $member->id }}, {{ $week->id }}, {{ $amount }}, {{ $target }})"
                                    title="{{ $amount > 0 ? 'Rp ' . number_format($amount, 0, ',', '.') : 'Belum Bayar' }} / Rp {{ number_format($target, 0, ',', '.') }}">

                                    <div class="h-10 w-full flex items-center justify-center text-xs font-bold {{ $textClass }} min-h-[2.5rem] flex items-center justify-center">
                                        @if($amount > 0)
                                            {{ 'Rp ' . number_format($amount, 0, ',', '.') }}
                                        @else
                                            <span class="{{ $textClass }} text-xs">-</span>
                                        @endif
                                    </div>
                                </td>
                            @endforeach
                        @endforeach

                        <td class="p-4 border-l border-gray-200 dark:border-gray-700 sticky right-0 z-10 bg-white dark:bg-gray-800 text-center text-gray-600 dark:text-gray-300"
                            title="Tanggal hari ini dan informasi minggu aktif">
                            <div class="flex flex-col items-center justify-center h-full space-y-2">
                                <span class="block text-sm font-bold">{{ \Carbon\Carbon::now()->isoFormat('DD/MM/YYYY') }}</span>
                                <span class="block text-xs text-gray-500 dark:text-gray-400">
                                    @php
                                        // Temukan minggu saat ini berdasarkan tanggal
                                        $today = \Carbon\Carbon::now();
                                        $currentWeek = null;
                                        $weekNumber = 0;
                                        $found = false;
                                        $overallWeekIndex = 1;

                                        foreach($months as $monthName => $weeksInMonth) {
                                            foreach($weeksInMonth as $idx => $week) {
                                                $weekStartDate = \Carbon\Carbon::parse($week->start_date);
                                                $weekEndDate = $weekStartDate->copy()->addDays(6); // Minggu berakhir 7 hari kemudian

                                                if ($today->between($weekStartDate, $weekEndDate)) {
                                                    $currentWeek = $week;
                                                    $weekNumber = $overallWeekIndex;
                                                    $found = true;
                                                    break;
                                                }
                                                $overallWeekIndex++;
                                            }
                                            if($found) break;
                                        }

                                        if($currentWeek) {
                                            echo "Minggu ke-" . $weekNumber;
                                        } else {
                                            echo "Tidak ada";
                                        }
                                    @endphp
                                </span>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <x-filament-actions::modals />
</x-filament-panels::page>
