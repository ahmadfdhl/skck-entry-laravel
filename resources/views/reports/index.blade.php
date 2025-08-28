<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Laporan Pendapatan') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Debug Info -->
            <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6">
                <div class="flex">
                    <div class="ml-3">
                        <p class="text-sm text-blue-700">
                            <strong>Info Debug:</strong><br>
                            Total Data di Sistem: {{ $totalDataInSystem }}<br>
                            Data dalam Periode: {{ $dataInRange }}<br>
                            Periode: {{ $startDate->format('d M Y') }} - {{ $endDate->format('d M Y') }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Filter Form -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6 p-6">
                <form action="{{ route('reports.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Dari Tanggal</label>
                        <input type="date" name="start_date" value="{{ $startDate->format('Y-m-d') }}" 
                               class="mt-1 block w-full border-gray-300 rounded-md">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Sampai Tanggal</label>
                        <input type="date" name="end_date" value="{{ $endDate->format('Y-m-d') }}" 
                               class="mt-1 block w-full border-gray-300 rounded-md">
                    </div>
                    <div class="flex items-end">
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">
                            Filter
                        </button>
                    </div>
                </form>
            </div>

            <!-- Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <div class="bg-white p-6 rounded-lg shadow">
                    <div class="text-2xl font-bold text-blue-600">{{ $totalSkck }}</div>
                    <div class="text-sm text-gray-600">Total SKCK</div>
                </div>
                <div class="bg-white p-6 rounded-lg shadow">
                    <div class="text-2xl font-bold text-green-600">{{ $tunaiCount }}</div>
                    <div class="text-sm text-gray-600">Pembayaran Tunai</div>
                </div>
                <div class="bg-white p-6 rounded-lg shadow">
                    <div class="text-2xl font-bold text-yellow-600">{{ $onlineCount }}</div>
                    <div class="text-sm text-gray-600">Pembayaran Online</div>
                </div>
                <div class="bg-white p-6 rounded-lg shadow">
                    <div class="text-2xl font-bold text-purple-600">{{ $onlineSudahBayarCount }}</div>
                    <div class="text-sm text-gray-600">Online Sudah Bayar</div>
                </div>
            </div>

            <!-- Pendapatan Per Kategori -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <div class="bg-white p-6 rounded-lg shadow">
                    <div class="text-2xl font-bold text-blue-600">Rp {{ number_format($totalPendapatanSkck, 0, ',', '.') }}</div>
                    <div class="text-sm text-gray-600">Total Pendapatan SKCK</div>
                </div>
                <div class="bg-white p-6 rounded-lg shadow">
                    <div class="text-2xl font-bold text-green-600">Rp {{ number_format($totalPendapatanLegalisir, 0, ',', '.') }}</div>
                    <div class="text-sm text-gray-600">Total Pendapatan Legalisir</div>
                </div>
                <div class="bg-white p-6 rounded-lg shadow">
                    <div class="text-2xl font-bold text-orange-600">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
                    <div class="text-sm text-gray-600">Total Pendapatan</div>
                </div>
            </div>

            <!-- Detail Pendapatan Per Jenis -->
            <div class="bg-gray-50 p-6 rounded-lg mb-6">
                <h3 class="text-lg font-semibold mb-4">Rincian Pendapatan</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Tunai -->
                    <div class="bg-white p-4 rounded-lg shadow">
                        <h4 class="font-semibold text-green-600 mb-2">Tunai</h4>
                        <p>SKCK: Rp {{ number_format($pendapatanSkckTunai, 0, ',', '.') }}</p>
                        <p>Legalisir: Rp {{ number_format($pendapatanLegalisirTunai, 0, ',', '.') }}</p>
                        <p class="font-semibold mt-2">Total: Rp {{ number_format($pendapatanTunai, 0, ',', '.') }}</p>
                    </div>
                    
                    <!-- Online -->
                    <div class="bg-white p-4 rounded-lg shadow">
                        <h4 class="font-semibold text-blue-600 mb-2">Online</h4>
                        <p>SKCK: Rp {{ number_format($pendapatanSkckOnline, 0, ',', '.') }}</p>
                        <p>Legalisir: Rp {{ number_format($pendapatanLegalisirOnline, 0, ',', '.') }}</p>
                        <p class="font-semibold mt-2">Total: Rp {{ number_format($pendapatanOnline, 0, ',', '.') }}</p>
                    </div>
                    
                    <!-- Online Sudah Bayar -->
                    <div class="bg-white p-4 rounded-lg shadow">
                        <h4 class="font-semibold text-purple-600 mb-2">Online Sudah Bayar</h4>
                        <p>SKCK: Rp {{ number_format($pendapatanSkckOnlineSudahBayar, 0, ',', '.') }}</p>
                        <p>Legalisir: Rp {{ number_format($pendapatanLegalisirOnlineSudahBayar, 0, ',', '.') }}</p>
                        <p class="font-semibold mt-2">Total: Rp {{ number_format($pendapatanOnlineSudahBayar, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>

            <!-- Info Harga -->
            <div class="bg-yellow-50 p-4 rounded-lg mb-6">
                <h3 class="font-semibold text-yellow-800">Info Harga:</h3>
                <p class="text-sm text-yellow-700">
                    • Harga SKCK: Rp {{ number_format($skckIssueFee, 0, ',', '.') }}<br>
                    • Harga Legalisir: Rp {{ number_format($skckLegalizeFee, 0, ',', '.') }}<br>
                    • <strong>Tunai & Online:</strong> Bayar full (SKCK + Legalisir)<br>
                    • <strong>Online Sudah Bayar:</strong> Bayar legalisir saja (tidak bayar SKCK lagi)
                </p>
            </div>

            <!-- Charts -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-lg font-semibold mb-4">Jumlah SKCK per Hari</h3>
                    <canvas id="skckChart" height="250"></canvas>
                </div>
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-lg font-semibold mb-4">Pendapatan per Hari</h3>
                    <canvas id="incomeChart" height="250"></canvas>
                </div>
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-lg font-semibold mb-4">Pendapatan SKCK vs Legalisir</h3>
                    <canvas id="categoryChart" height="250"></canvas>
                </div>
            </div>

            <!-- Detail Laporan Harian -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Detail Laporan Harian</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full table-auto">
                            <thead>
                                <tr class="bg-gray-50">
                                    <th class="px-4 py-2">Tanggal</th>
                                    <th class="px-4 py-2">Total</th>
                                    <th class="px-4 py-2">Tunai</th>
                                    <th class="px-4 py-2">Online</th>
                                    <th class="px-4 py-2">Online SB</th>
                                    <th class="px-4 py-2">Pendapatan SKCK</th>
                                    <th class="px-4 py-2">Pendapatan Legalisir</th>
                                    <th class="px-4 py-2">Total Pendapatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($dailyData as $data)
                                <tr class="border-b">
                                    <td class="px-4 py-2">{{ \Carbon\Carbon::parse($data->date)->format('d M Y') }}</td>
                                    <td class="px-4 py-2 text-center">{{ $data->total }}</td>
                                    <td class="px-4 py-2 text-center">{{ $data->tunai }}</td>
                                    <td class="px-4 py-2 text-center">{{ $data->online }}</td>
                                    <td class="px-4 py-2 text-center">{{ $data->online_sudah_bayar }}</td>
                                    <td class="px-4 py-2 text-right">Rp {{ number_format($data->total_skck, 0, ',', '.') }}</td>
                                    <td class="px-4 py-2 text-right">Rp {{ number_format($data->total_legalize, 0, ',', '.') }}</td>
                                    <td class="px-4 py-2 text-right font-semibold">Rp {{ number_format($data->total_pendapatan, 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // SKCK Count Chart
            const skckCtx = document.getElementById('skckChart').getContext('2d');
            new Chart(skckCtx, {
                type: 'bar',
                data: {
                    labels: @json($chartData['labels']),
                    datasets: [
                        {
                            label: 'Tunai',
                            data: @json($chartData['tunai']),
                            backgroundColor: 'rgba(34, 197, 94, 0.6)',
                            borderColor: 'rgba(34, 197, 94, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'Online',
                            data: @json($chartData['online']),
                            backgroundColor: 'rgba(59, 130, 246, 0.6)',
                            borderColor: 'rgba(59, 130, 246, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'Online Sudah Bayar',
                            data: @json($chartData['online_sudah_bayar']),
                            backgroundColor: 'rgba(139, 92, 246, 0.6)',
                            borderColor: 'rgba(139, 92, 246, 1)',
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            stacked: true
                        },
                        x: {
                            stacked: true
                        }
                    }
                }
            });

            // Income Chart
            const incomeCtx = document.getElementById('incomeChart').getContext('2d');
            new Chart(incomeCtx, {
                type: 'line',
                data: {
                    labels: @json($chartData['labels']),
                    datasets: [{
                        label: 'Total Pendapatan (Rp)',
                        data: @json($chartData['incomes']),
                        backgroundColor: 'rgba(249, 115, 22, 0.2)',
                        borderColor: 'rgba(249, 115, 22, 1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return 'Rp ' + value.toLocaleString();
                                }
                            }
                        }
                    }
                }
            });

            // Category Chart - SKCK vs Legalisir
            const categoryCtx = document.getElementById('categoryChart').getContext('2d');
            new Chart(categoryCtx, {
                type: 'bar',
                data: {
                    labels: @json($chartData['labels']),
                    datasets: [
                        {
                            label: 'Pendapatan SKCK',
                            data: @json($chartData['skck_incomes']),
                            backgroundColor: 'rgba(59, 130, 246, 0.6)',
                            borderColor: 'rgba(59, 130, 246, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'Pendapatan Legalisir',
                            data: @json($chartData['legalize_incomes']),
                            backgroundColor: 'rgba(34, 197, 94, 0.6)',
                            borderColor: 'rgba(34, 197, 94, 1)',
                            borderWidth: 1
                        }
                    ]   
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            stacked: false,
                            ticks: {
                                callback: function(value) {
                                    return 'Rp ' + value.toLocaleString();
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
    @endpush
</x-app-layout>