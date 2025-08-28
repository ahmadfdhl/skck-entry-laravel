<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Daftar SKCK
            </h2>
            <a href="{{ route('skck.create') }}" 
               class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                <i class="bi bi-plus-lg px-2"> </i> Buat Baru
            </a>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <!-- Filter dan Search -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-6">
                    <!-- Search Form -->
                    <div>
                        <form action="{{ route('skck.list') }}" method="GET" class="flex">
                            <input type="text" 
                                   class="flex-1 px-3 py-2 border border-gray-300 rounded-l-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                                   placeholder="Cari nama/NIK/no SKCK..." 
                                   name="search" 
                                   value="{{ request('search') }}">
                            <button type="submit" 
                                    class="inline-flex items-center px-4 py-2 bg-gray-50 border border-gray-300 border-l-0 rounded-r-md text-sm font-medium text-gray-700 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
                               <i class="bi bi-search"></i>
                            </button>
                        </form>
                    </div>
                    
                    <!-- Date Range Filter -->
                    <div>
                        <form action="{{ route('skck.list') }}" method="GET" class="flex gap-2">
                            <input type="date" 
                                   class="px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                                   name="start_date" 
                                   value="{{ request('start_date') }}"
                                   placeholder="Tanggal Mulai">
                            <input type="date" 
                                   class="px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                                   name="end_date" 
                                   value="{{ request('end_date') }}"
                                   placeholder="Tanggal Akhir">
                            <button type="submit" 
                                    class="inline-flex items-center px-4 py-2 bg-gray-50 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <i class="bi bi-filter"></i>
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Table -->
                <div class="overflow-hidden border border-gray-200 rounded-lg">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        No. SKCK
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Nama
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        NIK
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Tanggal Dibuat
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($skckList as $skck)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $skck->nomor_skck }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $skck->nama_lengkap }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $skck->nik }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $skck->created_at->format('d-m-Y H:i') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('skck.show', $skck->id) }}" 
                                               class="inline-flex items-center px-3 py-1 bg-blue-100 border border-transparent rounded-md text-xs text-blue-700 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-blue-500 transition ease-in-out duration-150"
                                               title="Detail">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('skck.docx', $skck->id) }}" 
                                               class="inline-flex items-center px-3 py-1 bg-green-100 border border-transparent rounded-md text-xs text-green-700 hover:bg-green-200 focus:outline-none focus:ring-2 focus:ring-green-500 transition ease-in-out duration-150"
                                               title="Download DOCX">
                                                <i class="bi bi-file-earmark-word"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-sm text-gray-500">
                                        <div class="flex flex-col items-center">
                                            <i class="fas fa-folder-open text-4xl text-gray-300 mb-4"></i>
                                            <p class="text-lg font-medium text-gray-900 mb-2">Tidak ada data SKCK</p>
                                            <p class="text-gray-500">Belum ada SKCK yang dibuat atau sesuai dengan filter pencarian.</p>
                                            <a href="{{ route('skck.create') }}" 
                                               class="mt-4 inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                                <i class="bi bi-plus-lg px-2"> </i>  Buat SKCK Baru
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Pagination -->
                @if($skckList->hasPages())
                <div class="mt-6 flex justify-center">
                    <div class="pagination-wrapper">
                        {{ $skckList->links() }}
                    </div>
                </div>
                @endif

                <!-- Summary Info -->
                @if($skckList->count() > 0)
                <div class="mt-4 text-sm text-gray-600 text-center">
                    Menampilkan {{ $skckList->firstItem() }} sampai {{ $skckList->lastItem() }} dari {{ $skckList->total() }} hasil
                </div>
                @endif
            </div>
        </div>
    </div>

    @push('styles')
    <style>
        /* Custom pagination styling untuk kompatibilitas dengan Tailwind */
        .pagination-wrapper .pagination {
            display: flex;
            justify-content: center;
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .pagination-wrapper .pagination li {
            margin: 0 2px;
        }
        
        .pagination-wrapper .pagination li a,
        .pagination-wrapper .pagination li span {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.5rem 0.75rem;
            text-decoration: none;
            color: #374151;
            background-color: #ffffff;
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            font-size: 0.875rem;
            transition: all 0.15s ease-in-out;
        }
        
        .pagination-wrapper .pagination li a:hover {
            background-color: #f3f4f6;
            border-color: #9ca3af;
        }
        
        .pagination-wrapper .pagination li.active span {
            background-color: #3b82f6;
            border-color: #3b82f6;
            color: #ffffff;
        }
        
        .pagination-wrapper .pagination li.disabled span {
            color: #9ca3af;
            cursor: not-allowed;
        }
    </style>
    @endpush
</x-app-layout>