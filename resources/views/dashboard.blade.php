<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Dashboard Aplikasi SKCK') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <!-- Total SKCK Card -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-blue-500 text-white">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-file-alt text-2xl"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium">Total SKCK</p>
                                <p class="text-2xl font-bold">{{ $totalSkck }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-4 bg-white">
                        <p class="text-sm text-gray-600">Jumlah total SKCK yang dibuat</p>
                    </div>
                </div>

                <!-- SKCK Bulan Ini -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-green-500 text-white">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-calendar-check text-2xl"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium">SKCK Bulan Ini</p>
                                <p class="text-2xl font-bold">{{ $skckThisMonth }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-4 bg-white">
                        <p class="text-sm text-gray-600">SKCK dibuat bulan {{ now()->translatedFormat('F') }}</p>
                    </div>
                </div>

                <!-- SKCK Hari Ini -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-yellow-500 text-white">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-calendar-day text-2xl"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium">SKCK Hari Ini</p>
                                <p class="text-2xl font-bold">{{ $skckToday }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-4 bg-white">
                        <p class="text-sm text-gray-600">SKCK dibuat hari ini</p>
                    </div>
                </div>

                <!-- User Count -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-purple-500 text-white">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-users text-2xl"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium">Total Pengguna</p>
                                <p class="text-2xl font-bold">{{ $totalUsers }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-4 bg-white">
                        <p class="text-sm text-gray-600">Jumlah user terdaftar</p>
                    </div>
                </div>
            </div>

            <!-- Charts and Recent Activity -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                <!-- Monthly Chart -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-4">Statistik SKCK Bulanan</h3>
                    <div class="h-64">
                        <canvas id="monthlyChart"></canvas>
                    </div>
                </div>

                <!-- Recent SKCK -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-4">SKCK Terbaru</h3>
                    <div class="space-y-4">
                        @forelse($recentSkck as $skck)
                        <div class="border rounded-lg p-4 hover:bg-gray-50">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h4 class="font-semibold">{{ $skck->nama_lengkap }}</h4>
                                    <p class="text-sm text-gray-600">{{ $skck->nomor_skck }}</p>
                                    <p class="text-sm text-gray-600">{{ $skck->created_at->diffForHumans() }}</p>
                                </div>
                                <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">
                                    {{ $skck->kewarganegaraan }}
                                </span>
                            </div>
                        </div>
                        @empty
                        <p class="text-gray-500">Belum ada data SKCK</p>
                        @endforelse
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('skck.list') }}" class="text-blue-600 hover:text-blue-800 text-sm">
                            Lihat semua SKCK →
                        </a>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">Aksi Cepat</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <a href="{{ route('skck.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white p-4 rounded-lg text-center transition duration-200">
                        <i class="fas fa-plus-circle text-2xl mb-2"></i>
                        <p class="font-semibold">Buat SKCK Baru</p>
                        <p class="text-sm opacity-90">Buat surat keterangan baru</p>
                    </a>

                    <a href="{{ route('skck.list') }}" class="bg-green-500 hover:bg-green-600 text-white p-4 rounded-lg text-center transition duration-200">
                        <i class="fas fa-list text-2xl mb-2"></i>
                        <p class="font-semibold">Lihat Daftar SKCK</p>
                        <p class="text-sm opacity-90">Kelola semua data SKCK</p>
                    </a>

                    @can('manage-users')
                    <a href="{{ route('users.index') }}" class="bg-purple-500 hover:bg-purple-600 text-white p-4 rounded-lg text-center transition duration-200">
                        <i class="fas fa-users-cog text-2xl mb-2"></i>
                        <p class="font-semibold">Kelola Pengguna</p>
                        <p class="text-sm opacity-90">Manajemen user sistem</p>
                    </a>
                    @endcan
                </div>
            </div>

            <!-- System Status -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mt-6">
                <h3 class="text-lg font-semibold mb-4">Status Sistem</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="flex items-center p-4 bg-gray-50 rounded-lg">
                        <i class="fas fa-database text-2xl text-blue-500 mr-4"></i>
                        <div>
                            <p class="font-semibold">Database</p>
                            <p class="text-sm text-gray-600">Status: Normal</p>
                        </div>
                    </div>
                    <div class="flex items-center p-4 bg-gray-50 rounded-lg">
                        <i class="fas fa-server text-2xl text-green-500 mr-4"></i>
                        <div>
                            <p class="font-semibold">Server</p>
                            <p class="text-sm text-gray-600">Status: Online</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Monthly Chart
            const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
            const monthlyChart = new Chart(monthlyCtx, {
                type: 'bar',
                data: {
                    labels: @json($monthlyLabels),
                    datasets: [{
                        label: 'Jumlah SKCK',
                        data: @json($monthlyData),
                        backgroundColor: 'rgba(59, 130, 246, 0.6)',
                        borderColor: 'rgba(59, 130, 246, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    }
                }
            });
        });
    </script>
    @endpush
</x-app-layout>