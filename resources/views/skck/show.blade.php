<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Detail SKCK
            </h2>
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                {{ $skck->nomor_skck }}
            </span>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Detail SKCK - Kolom Utama -->
            <div class="lg:col-span-2">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h4 class="text-lg font-semibold text-gray-900 mb-6">Informasi Pemohon</h4>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Kolom Kiri -->
                            <div class="space-y-3">
                                <div class="flex flex-col">
                                    <dt class="text-sm font-medium text-gray-500">Nama Lengkap</dt>
                                    <dd class="text-sm text-gray-900 font-medium">{{ $skck->nama_lengkap }}</dd>
                                </div>
                                
                                <div class="flex flex-col">
                                    <dt class="text-sm font-medium text-gray-500">NIK</dt>
                                    <dd class="text-sm text-gray-900">{{ $skck->nik }}</dd>
                                </div>
                                
                                <div class="flex flex-col">
                                    <dt class="text-sm font-medium text-gray-500">Tempat/Tgl Lahir</dt>
                                    <dd class="text-sm text-gray-900">{{ $skck->tempat_lahir }}, {{ $skck->tanggal_lahir->format('d-m-Y') }}</dd>
                                </div>
                                
                                <div class="flex flex-col">
                                    <dt class="text-sm font-medium text-gray-500">Jenis Kelamin</dt>
                                    <dd class="text-sm text-gray-900">{{ $skck->jenis_kelamin }}</dd>
                                </div>
                            </div>
                            
                            <!-- Kolom Kanan -->
                            <div class="space-y-3">
                                <div class="flex flex-col">
                                    <dt class="text-sm font-medium text-gray-500">Agama</dt>
                                    <dd class="text-sm text-gray-900">{{ $skck->agama }}</dd>
                                </div>
                                
                                @if(isset($skck->status_perkawinan))
                                <div class="flex flex-col">
                                    <dt class="text-sm font-medium text-gray-500">Status Perkawinan</dt>
                                    <dd class="text-sm text-gray-900">{{ $skck->status_perkawinan }}</dd>
                                </div>
                                @endif
                                
                                <div class="flex flex-col">
                                    <dt class="text-sm font-medium text-gray-500">Pekerjaan</dt>
                                    <dd class="text-sm text-gray-900">{{ $skck->pekerjaan }}</dd>
                                </div>
                                
                                <div class="flex flex-col">
                                    <dt class="text-sm font-medium text-gray-500">Tanggal Dibuat</dt>
                                    <dd class="text-sm text-gray-900">{{ $skck->created_at->format('d-m-Y') }}</dd>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Alamat -->
                        <div class="mt-6">
                            <dt class="text-sm font-medium text-gray-500 mb-2">Alamat Lengkap</dt>
                            <dd class="text-sm text-gray-900 bg-gray-50 p-3 rounded-md border">{{ $skck->alamat }}</dd>
                        </div>
                        
                        <!-- Keperluan -->
                        <div class="mt-6">
                            <dt class="text-sm font-medium text-gray-500 mb-2">Keperluan</dt>
                            <dd class="text-sm text-gray-900 bg-gray-50 p-3 rounded-md border">{{ $skck->keperluan }}</dd>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="flex flex-col sm:flex-row justify-between gap-3 mt-8 pt-6 border-t border-gray-200">
                            <a href="{{ route('skck.create') }}" 
                               class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <i class="fas fa-plus mr-2"></i> Buat Baru
                            </a>
                            
                            <a href="{{ route('skck.docx', $skck->id) }}" 
                               class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <i class="fas fa-file-word mr-2"></i> Download DOCX
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Sidebar - Foto dan Tanda Tangan -->
            <div class="space-y-6">
                <!-- Foto Pemohon -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                        <h5 class="text-md font-semibold text-gray-900">Foto Pemohon</h5>
                    </div>
                    <div class="p-6 text-center">
                        @if(isset($skck->foto_path) && $skck->foto_path)
                            <img src="{{ Storage::url($skck->foto_path) }}" 
                                 alt="Foto Pemohon" 
                                 class="mx-auto rounded-lg border border-gray-200 max-h-72 object-cover">
                        @else
                            <div class="flex items-center justify-center h-48 bg-gray-100 rounded-lg">
                                <div class="text-center">
                                    <i class="fas fa-user text-gray-400 text-4xl mb-2"></i>
                                    <p class="text-gray-500 text-sm">Foto tidak tersedia</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                
                <!-- Tanda Tangan -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                        <h5 class="text-md font-semibold text-gray-900">Tanda Tangan</h5>
                    </div>
                    <div class="p-6 text-center">
                        @if(isset($skck->ttd_path) && $skck->ttd_path)
                            <img src="{{ Storage::url($skck->ttd_path) }}" 
                                 alt="Tanda Tangan" 
                                 class="mx-auto max-h-24 object-contain">
                        @else
                            <div class="flex items-center justify-center h-24 bg-gray-100 rounded-lg">
                                <div class="text-center">
                                    <i class="fas fa-signature text-gray-400 text-2xl mb-2"></i>
                                    <p class="text-gray-500 text-xs">Tanda tangan belum diupload</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Preview Dokumen SKCK -->
        <div class="mt-8 bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                <h5 class="text-md font-semibold text-gray-900">Preview Dokumen SKCK</h5>
            </div>
            <div class="p-8">
                <div class="max-w-4xl mx-auto bg-white" style="font-family: 'Times New Roman', serif;">
                    <!-- Header Dokumen -->
                    <div class="text-center mb-8">
                        <h4 class="text-lg font-bold mb-2 uppercase">Surat Keterangan Catatan Kepolisian</h4>
                        <h5 class="text-md font-bold">NOMOR: {{ $skck->nomor_skck }}</h5>
                    </div>
                    
                    <div class="text-sm leading-relaxed space-y-4">
                        <p>Yang bertanda tangan di bawah ini, menerangkan bahwa:</p>
                        
                        <!-- Data Pemohon -->
                        <div class="space-y-2">
                            <div class="flex">
                                <span class="w-40 flex-shrink-0">Nama Lengkap</span>
                                <span class="w-4">:</span>
                                <span class="font-medium">{{ $skck->nama_lengkap }}</span>
                            </div>
                            <div class="flex">
                                <span class="w-40 flex-shrink-0">NIK</span>
                                <span class="w-4">:</span>
                                <span>{{ $skck->nik }}</span>
                            </div>
                            <div class="flex">
                                <span class="w-40 flex-shrink-0">Tempat/Tgl Lahir</span>
                                <span class="w-4">:</span>
                                <span>{{ $skck->tempat_lahir }}, {{ $skck->tanggal_lahir->format('d-m-Y') }}</span>
                            </div>
                            <div class="flex">
                                <span class="w-40 flex-shrink-0">Jenis Kelamin</span>
                                <span class="w-4">:</span>
                                <span>{{ $skck->jenis_kelamin }}</span>
                            </div>
                            <div class="flex">
                                <span class="w-40 flex-shrink-0">Agama</span>
                                <span class="w-4">:</span>
                                <span>{{ $skck->agama }}</span>
                            </div>
                            <div class="flex">
                                <span class="w-40 flex-shrink-0">Pekerjaan</span>
                                <span class="w-4">:</span>
                                <span>{{ $skck->pekerjaan }}</span>
                            </div>
                            <div class="flex">
                                <span class="w-40 flex-shrink-0">Alamat</span>
                                <span class="w-4">:</span>
                                <span>{{ $skck->alamat }}</span>
                            </div>
                        </div>
                        
                        <p class="mt-6">Adalah benar-benar warga tersebut di atas dan berdasarkan catatan yang ada pada kami, yang bersangkutan:</p>
                        
                        <div class="text-center py-4">
                            <p class="font-bold text-lg">TIDAK MEMILIKI CATATAN KRIMINAL</p>
                        </div>
                        
                        <p>Surat Keterangan ini diberikan untuk keperluan:</p>
                        <p class="italic font-medium pl-4">"{{ $skck->keperluan }}"</p>
                        
                        <p class="mt-6">Demikian Surat Keterangan ini dibuat untuk dapat dipergunakan sebagaimana mestinya.</p>
                        
                        <!-- Footer dengan Tanggal dan Tanda Tangan -->
                        <div class="flex justify-end mt-12">
                            <div class="text-center">
                                <p class="mb-16">{{ $skck->created_at->format('d F Y') }}</p>
                                <p class="border-b border-black inline-block px-16 pb-1">
                                    &nbsp;
                                </p>
                                <p class="text-xs mt-1">Petugas</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>