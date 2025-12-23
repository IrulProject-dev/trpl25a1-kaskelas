<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Kas Kelas - Class Fund Management</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:100,200,300,400,500,600,700,800,900" rel="stylesheet" />

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Scripts -->
        @vite(['resources/css/app.css'])

        <!-- Tailwind CSS -->
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="antialiased bg-gray-50 dark:bg-gray-900">
        <div class="min-h-screen bg-white dark:bg-gray-900">
            <!-- Navigation -->
            <nav class="flex items-center justify-between p-6 bg-white dark:bg-gray-800 shadow-md">
                <div class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">TRPL25A1</div>
                <div class="hidden md:flex space-x-8">
                    <a href="#transactions" class="text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Transactions</a>
                    <a href="#excel-table" class="text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Excel Table</a>
                </div>
                <div class="flex items-center space-x-4">
                </div>
            </nav>

            <!-- Hero Section -->
            <div class="container mx-auto px-6 py-20 text-center">
                <h1 class="text-5xl md:text-7xl font-bold text-gray-800 dark:text-white mb-6">
                    Hello I'm <span class="text-indigo-600">Software Enginering </span>Tecnology
                </h1>
                <p class="text-xl text-gray-600 dark:text-gray-300 max-w-2xl mx-auto mb-10">
                    Paltfom rekap Keuangan TRPL25A1
                </p>
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <a href="#excel-table" class="border-2 border-indigo-600 text-indigo-600 hover:bg-indigo-50 px-8 py-4 rounded-full text-lg font-semibold transition-colors dark:border-indigo-400 dark:text-indigo-400 dark:hover:bg-gray-800">
                        View Excel Table
                    </a>
                </div>
            </div>

            <!-- Excel-like Table Section -->
            <div id="excel-table" class="container mx-auto px-6 py-10">
                <h2 class="text-4xl font-bold text-center text-gray-800 dark:text-white mb-8">Excel-like Financial Table</h2>
                <br>

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
                                                onclick="openInputModal({{ $member->id }}, {{ $week->id }}, {{ $amount }}, {{ $target }})"
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
<br>
                <!-- Modal for editing payment -->
                <div id="paymentModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
                    <div class="bg-white dark:bg-gray-800 rounded-lg p-6 w-96 max-w-90vw">
                        <h3 class="text-xl font-bold mb-4 text-gray-800 dark:text-white">Edit Payment</h3>
                        <form id="paymentForm">
                            <input type="hidden" id="memberId" name="member_id">
                            <input type="hidden" id="weekId" name="week_id">

                            <div class="mb-4">
                                <label class="block text-gray-700 dark:text-gray-300 mb-2">Member Name:</label>
                                <input type="text" id="memberName" class="w-full p-2 border border-gray-300 dark:border-gray-600 rounded bg-gray-50 dark:bg-gray-700 text-gray-800 dark:text-white" readonly>
                            </div>

                            <div class="mb-4">
                                <label class="block text-gray-700 dark:text-gray-300 mb-2">Week:</label>
                                <input type="text" id="weekName" class="w-full p-2 border border-gray-300 dark:border-gray-600 rounded bg-gray-50 dark:bg-gray-700 text-gray-800 dark:text-white" readonly>
                            </div>

                            <div class="mb-4">
                                <label class="block text-gray-700 dark:text-gray-300 mb-2">Target Amount:</label>
                                <input type="text" id="targetAmount" class="w-full p-2 border border-gray-300 dark:border-gray-600 rounded bg-gray-50 dark:bg-gray-700 text-gray-800 dark:text-white" readonly>
                            </div>

                            <div class="mb-4">
                                <label class="block text-gray-700 dark:text-gray-300 mb-2">Current Amount:</label>
                                <input type="number" id="currentAmount" name="amount" class="w-full p-2 border border-gray-300 dark:border-gray-600 rounded bg-gray-50 dark:bg-gray-700 text-gray-800 dark:text-white">
                            </div>

                            <div class="flex justify-end space-x-3">
                                <button type="button" onclick="closeModal()" class="px-4 py-2 bg-gray-300 dark:bg-gray-600 text-gray-800 dark:text-white rounded hover:bg-gray-400 dark:hover:bg-gray-500">Cancel</button>
                                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


            <!-- About Section -->
            <div class="py-20 bg-indigo-800 text-white">
                <div class="container mx-auto px-6 text-center">
                    <h2 class="text-4xl font-bold mb-6">Web Kas Kelas</h2>
                    <p class="text-xl max-w-3xl mx-auto mb-10">
                        Aplikasi pengelolaan kas kelas untuk mencatat pemasukan, pengeluaran,dan laporan keuangan secara transparan dan terstruktur.                    </p>
                    <a href="/" class="inline-block bg-white text-indigo-800 hover:bg-indigo-50 px-8 py-4 rounded-full text-lg font-semibold transition-colors shadow-lg">
                        Get Started Today
                    </a>
                </div>
            </div>

            <!-- Footer -->
            <footer class="py-10 bg-gray-800 text-white">
                <div class="container mx-auto px-6 text-center">
                    <p class="text-gray-400">© {{ date('Y') }}TRPL25A1. All rights reserved.</p>
                    <div class="mt-4 flex justify-center space-x-6">
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">Privacy Policy</a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">Terms of Service</a>
                        <a href="/admin" class="text-indigo-400 hover:text-white transition-colors">
                            Admin Login
                        </a>
                    </div>
                </div>
            </footer>
        </div>
    </body>
</html>

        <script>
            // Function to open modal for editing payment
            function openInputModal(memberId, weekId, currentAmount, targetAmount) {
                document.getElementById('memberId').value = memberId;
                document.getElementById('weekId').value = weekId;
                document.getElementById('currentAmount').value = currentAmount;

                // Get member name from the table
                const rows = document.querySelectorAll('tbody tr');
                let memberNameText = '';
                for (let row of rows) {
                    const cellMemberId = row.querySelector('td:first-child').textContent.trim();
                    if (parseInt(cellMemberId) === memberId) {
                        memberNameText = row.querySelector('td:nth-child(2)').textContent.trim();
                        break;
                    }
                }

                document.getElementById('memberName').value = memberNameText;

                // Set target amount
                document.getElementById('targetAmount').value = `Rp ${targetAmount.toLocaleString('id-ID')}`;

                // Show modal
                document.getElementById('paymentModal').classList.remove('hidden');
            }

            function closeModal() {
                document.getElementById('paymentModal').classList.add('hidden');
            }

            // Handle form submission
            document.getElementById('paymentForm').addEventListener('submit', function(e) {
                e.preventDefault();

                // Get form data
                const formData = new FormData(this);
                const memberId = formData.get('member_id');
                const weekId = formData.get('week_id');
                const amount = parseFloat(formData.get('amount'));

                // Send to server
                fetch('/api/transactions/update-payment', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        member_id: memberId,
                        week_id: weekId,
                        amount: amount
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Payment updated successfully!');

                        // Update the table cell with the new amount
                        const cell = document.querySelector(`td[onclick*="${memberId}"][onclick*="${weekId}"] div`);
                        if (cell) {
                            const newAmountText = amount > 0 ? `Rp ${amount.toLocaleString('id-ID')}` : '-';

                            // Determine color based on payment status
                            let textColorClass = '';
                            const target = parseFloat(document.getElementById('targetAmount').value.replace(/[^\d]/g, ''));

                            if (amount >= target) {
                                textColorClass = 'text-green-600 dark:text-green-400'; // Lunas (Hijau)
                            } else if (amount > 0 && amount < target) {
                                textColorClass = 'text-yellow-500 dark:text-yellow-300'; // Kurang bayar (Kuning)
                            } else {
                                textColorClass = 'text-red-600 dark:text-red-400'; // Tidak bayar (Merah)
                            }

                            cell.innerHTML = newAmountText;
                            cell.className = `h-10 w-full flex items-center justify-center text-xs font-bold ${textColorClass} min-h-[2.5rem] flex items-center justify-center`;
                        }

                        closeModal();
                    } else {
                        alert('Error updating payment: ' + (data.message || 'Unknown error'));
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error updating payment: ' + error.message);
                });
            });
        </script>
    </body>
</html>
