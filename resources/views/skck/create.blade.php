<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Buat SKCK Baru
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="mb-6">
                    <h4 class="text-lg font-semibold text-gray-900">Formulir Permohonan SKCK</h4>
                </div>

                <!-- Tampilkan Error Validation -->
                @if($errors->any())
                <div class="mb-6 bg-red-50 border border-red-200 rounded-md p-4">
                    <h5 class="font-medium text-red-800">Terjadi kesalahan:</h5>
                    <ul class="mt-2 list-disc list-inside text-sm text-red-600">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form action="{{ route('skck.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Kolom Kiri - Data Pribadi -->
                        <div class="space-y-4">
                            <h5 class="font-medium text-gray-900 mb-4">Data Pribadi</h5>

                            <!-- Nama Lengkap -->
                            <div>
                                <label for="nama_lengkap" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nama Lengkap <span class="text-red-500">*</span>
                                </label>
                                <input type="text"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('nama_lengkap') border-red-500 @enderror"
                                    id="nama_lengkap" name="nama_lengkap" required 
                                    value="{{ old('nama_lengkap') }}">
                                @error('nama_lengkap')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Kewarganegaraan -->
                            <div>
                                <label for="kewarganegaraan" class="block text-sm font-medium text-gray-700 mb-2">
                                    Kewarganegaraan <span class="text-red-500">*</span>
                                </label>
                                <select
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('kewarganegaraan') border-red-500 @enderror"
                                    id="kewarganegaraan" name="kewarganegaraan" required>
                                    <option value="">Pilih Kewarganegaraan</option>
                                    <option value="Indonesia" {{ old('kewarganegaraan') == 'Indonesia' ? 'selected' : '' }}>Warga Negara Indonesia (WNI)</option>
                                    <option value="Asing" {{ old('kewarganegaraan') == 'Asing' ? 'selected' : '' }}>Warga Negara Asing (WNA)</option>
                                </select>
                                @error('kewarganegaraan')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- NIK Group -->
                            <div id="nik_group">
                                <label for="nik" class="block text-sm font-medium text-gray-700 mb-2">
                                    NIK <span class="text-red-500">*</span>
                                </label>
                                <input type="text"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('nik') border-red-500 @enderror"
                                    id="nik" name="nik" pattern="[0-9]{16}" title="NIK harus 16 digit angka"
                                    maxlength="16" value="{{ old('nik') }}">
                                @error('nik')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Passport Group -->
                            <div id="passport_group" style="display:none;">
                                <label for="passport" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nomor Passport <span class="text-red-500">*</span>
                                </label>
                                <input type="text"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('passport') border-red-500 @enderror"
                                    id="passport" name="passport" value="{{ old('passport') }}">
                                @error('passport')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Tempat dan Tanggal Lahir -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="tempat_lahir" class="block text-sm font-medium text-gray-700 mb-2">
                                        Tempat Lahir <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('tempat_lahir') border-red-500 @enderror"
                                        id="tempat_lahir" name="tempat_lahir" required 
                                        value="{{ old('tempat_lahir') }}">
                                    @error('tempat_lahir')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="tanggal_lahir" class="block text-sm font-medium text-gray-700 mb-2">
                                        Tanggal Lahir <span class="text-red-500">*</span>
                                    </label>
                                    <input type="date"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('tanggal_lahir') border-red-500 @enderror"
                                        id="tanggal_lahir" name="tanggal_lahir" 
                                        value="{{ old('tanggal_lahir') }}" required>
                                    @error('tanggal_lahir')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Jenis Kelamin -->
                            <div>
                                <label for="jenis_kelamin" class="block text-sm font-medium text-gray-700 mb-2">
                                    Jenis Kelamin <span class="text-red-500">*</span>
                                </label>
                                <select
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('jenis_kelamin') border-red-500 @enderror"
                                    id="jenis_kelamin" name="jenis_kelamin" required>
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                                @error('jenis_kelamin')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Agama -->
                            <div>
                                <label for="agama" class="block text-sm font-medium text-gray-700 mb-2">
                                    Agama <span class="text-red-500">*</span>
                                </label>
                                <select
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('agama') border-red-500 @enderror"
                                    id="agama" name="agama" required>
                                    <option value="">Pilih Agama</option>
                                    <option value="Islam" {{ old('agama') == 'Islam' ? 'selected' : '' }}>Islam</option>
                                    <option value="Kristen" {{ old('agama') == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                                    <option value="Katolik" {{ old('agama') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                                    <option value="Hindu" {{ old('agama') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                    <option value="Buddha" {{ old('agama') == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                                    <option value="Khonghucu" {{ old('agama') == 'Khonghucu' ? 'selected' : '' }}>Khonghucu</option>
                                </select>
                                @error('agama')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Jenis Pembayaran -->
                            <div>
                                <label for="jenis_pembayaran" class="block text-sm font-medium text-gray-700 mb-2">
                                    Jenis Pembayaran <span class="text-red-500">*</span>
                                </label>
                                <select
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('jenis_pembayaran') border-red-500 @enderror"
                                    id="jenis_pembayaran" name="jenis_pembayaran" required>
                                    <option value="">Pilih Jenis Pembayaran</option>
                                    <option value="tunai" {{ old('jenis_pembayaran') == 'tunai' ? 'selected' : '' }}>Tunai (Bayar Sekarang)</option>
                                    <option value="online" {{ old('jenis_pembayaran') == 'online' ? 'selected' : '' }}>Online (Belum Bayar)</option>
                                    <option value="online_sudah_bayar" {{ old('jenis_pembayaran') == 'online_sudah_bayar' ? 'selected' : '' }}>Online (Sudah Bayar SKCK, Tinggal Legalisir)</option>
                                </select>
                                @error('jenis_pembayaran')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                        </div>

                        <!-- Kolom Kanan - Data Tambahan -->
                        <div class="space-y-4">
                            <h5 class="font-medium text-gray-900 mb-4">Data Tambahan</h5>

                            <!-- Tanggal Masuk -->
                            <div>
                                <label for="tanggal_masuk" class="block text-sm font-medium text-gray-700 mb-2">
                                    Terhitung Sejak Tanggal <span class="text-red-500">*</span>
                                </label>
                                <input type="date"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('tanggal_masuk') border-red-500 @enderror"
                                    id="tanggal_masuk" name="tanggal_masuk" 
                                    value="{{ old('tanggal_masuk') }}" required>
                                <p class="text-sm text-gray-500 mt-1">Untuk WNI mengikuti tanggal lahir, untuk WNA
                                    tanggal masuk ke Indonesia</p>
                                @error('tanggal_masuk')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Alamat -->
                            <div>
                                <label for="alamat" class="block text-sm font-medium text-gray-700 mb-2">
                                    Alamat Lengkap <span class="text-red-500">*</span>
                                </label>
                                <textarea
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('alamat') border-red-500 @enderror"
                                    id="alamat" name="alamat" rows="3" required>{{ old('alamat') }}</textarea>
                                @error('alamat')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Pekerjaan -->
                            <div>
                                <label for="pekerjaan" class="block text-sm font-medium text-gray-700 mb-2">
                                    Pekerjaan <span class="text-red-500">*</span>
                                </label>
                                <input type="text"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('pekerjaan') border-red-500 @enderror"
                                    id="pekerjaan" name="pekerjaan" 
                                    value="{{ old('pekerjaan') }}" required>
                                @error('pekerjaan')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Keperluan -->
                            <div>
                                <label for="keperluan" class="block text-sm font-medium text-gray-700 mb-2">
                                    Keperluan SKCK <span class="text-red-500">*</span>
                                </label>
                                <textarea
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('keperluan') border-red-500 @enderror"
                                    id="keperluan" name="keperluan" rows="2" required>{{ old('keperluan') }}</textarea>
                                @error('keperluan')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Masa Berlaku -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Masa Berlaku</label>
                                <div
                                    class="w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-md text-gray-700">
                                    {{ now()->format('d-m-Y') }} s/d {{ now()->addMonths($expiryMonths)->format('d-m-Y') }}
                                </div>
                                <input type="hidden" name="masa_berlaku"
                                    value="{{ now()->addMonths($expiryMonths)->format('Y-m-d') }}">
                            </div>

                            <!-- Upload Foto -->
                            <div>
                                <label for="foto" class="block text-sm font-medium text-gray-700 mb-2">
                                    Upload Foto (Opsional)
                                </label>
                                <input type="file"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('foto') border-red-500 @enderror"
                                    id="foto" name="foto" accept="image/*">
                                <p class="text-sm text-gray-500 mt-1">Format: JPG/PNG, Maksimal 2MB</p>
                                @error('foto')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex flex-col sm:flex-row gap-3 sm:justify-end pt-6 border-t border-gray-200">
                        <button type="reset"
                            class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            <i class="fas fa-undo mr-2"></i> Reset Form
                        </button>
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            <i class="fas fa-save mr-2"></i> Simpan & Generate SKCK
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const kewarganegaraanSelect = document.getElementById('kewarganegaraan');
                const nikGroup = document.getElementById('nik_group');
                const passportGroup = document.getElementById('passport_group');
                const tanggalLahirInput = document.getElementById('tanggal_lahir');
                const tanggalMasukInput = document.getElementById('tanggal_masuk');

                // Set nilai old value untuk kewarganegaraan jika ada
                @if(old('kewarganegaraan'))
                    kewarganegaraanSelect.value = '{{ old('kewarganegaraan') }}';
                @endif

                // Fungsi untuk toggle form WNA/WNI
                function toggleKewarganegaraan() {
                    if (kewarganegaraanSelect.value === 'Asing') {
                        nikGroup.style.display = 'none';
                        nikGroup.querySelector('input').required = false;
                        passportGroup.style.display = 'block';
                        passportGroup.querySelector('input').required = true;
                    } else {
                        nikGroup.style.display = 'block';
                        nikGroup.querySelector('input').required = true;
                        passportGroup.style.display = 'none';
                        passportGroup.querySelector('input').required = false;
                    }
                }

                // Inisialisasi pertama kali
                toggleKewarganegaraan();

                // Event listener untuk perubahan kewarganegaraan
                kewarganegaraanSelect.addEventListener('change', function() {
                    toggleKewarganegaraan();

                    // Update tanggal masuk sesuai tanggal lahir jika WNI
                    if (this.value === 'Indonesia' && tanggalLahirInput.value) {
                        tanggalMasukInput.value = tanggalLahirInput.value;
                    }
                });

                // Event listener untuk perubahan tanggal lahir
                tanggalLahirInput.addEventListener('change', function() {
                    if (kewarganegaraanSelect.value === 'Indonesia') {
                        tanggalMasukInput.value = this.value;
                    }
                });

                // Validasi input NIK (hanya angka, 16 digit)
                document.getElementById('nik').addEventListener('input', function(e) {
                    this.value = this.value.replace(/[^0-9]/g, '');
                    if (this.value.length > 16) {
                        this.value = this.value.slice(0, 16);
                    }
                });

                // Set max date untuk semua input tanggal
                const today = new Date().toISOString().split('T')[0];
                document.getElementById('tanggal_lahir').max = today;
                document.getElementById('tanggal_masuk').max = today;

                // Set nilai tanggal masuk jika WNI dan tanggal lahir sudah diisi
                @if(old('kewarganegaraan') == 'Indonesia' && old('tanggal_lahir'))
                    document.getElementById('tanggal_masuk').value = '{{ old('tanggal_lahir') }}';
                @endif
            });
        </script>
    @endpush
</x-app-layout>