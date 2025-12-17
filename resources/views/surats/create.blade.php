<x-layouts.app :title="__('Tambah Surat')">
    <div class="min-h-screen relative overflow-hidden page-fade">
        <div class="fixed inset-0" style="background: url('{{ asset('images/foto_bapperida.png') }}') center/cover; filter: blur(5px); transform: scale(1.05);"></div>
        <div class="fixed inset-0 bg-black/25"></div>
        
        <div class="relative z-10 min-h-screen py-8">
            <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header BAPPERIDA Style -->
            <div class="bg-gradient-to-r from-red-700 to-red-600 rounded-xl shadow-lg border border-red-800/30 text-white px-5 sm:px-6 py-4 mb-6">
                <div class="flex items-center justify-between gap-3">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('images/logo_bapperida.png') }}" alt="Logo Bapperida" class="w-12 h-12 rounded-full bg-white p-1 shadow">
                        <div>
                            <div class="text-xs uppercase tracking-widest opacity-90">TAMBAH SURAT</div>
                            <div class="text-xl sm:text-2xl font-extrabold leading-tight">Form Input</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form -->
            <div class="bg-white dark:bg-zinc-800 rounded-lg shadow border border-zinc-200 dark:border-zinc-700 p-6">
                <form action="{{ route('surats.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <!-- Nomor Surat -->
                    <div>
                        <label for="nomor_surat" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Nomor Surat <span class="text-red-600">*</span>
                        </label>
                        <input type="text" id="nomor_surat" name="nomor_surat" value="{{ old('nomor_surat') }}" required
                            placeholder="Contoh: 001/BAPPERIDA/2024"
                            class="w-full px-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg dark:bg-zinc-700 dark:text-white focus:ring-2 focus:ring-red-500 focus:border-transparent @error('nomor_surat') border-red-500 @enderror">
                        @error('nomor_surat')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Judul -->
                    <div>
                        <label for="judul" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Judul Surat <span class="text-red-600">*</span>
                        </label>
                        <input type="text" id="judul" name="judul" value="{{ old('judul') }}" required
                            placeholder="Masukkan judul surat"
                            class="w-full px-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg dark:bg-zinc-700 dark:text-white focus:ring-2 focus:ring-red-500 focus:border-transparent @error('judul') border-red-500 @enderror">
                        @error('judul')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Pengirim -->
                    <div>
                        <label for="pengirim" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Pengirim <span class="text-red-600">*</span>
                        </label>
                        <input type="text" id="pengirim" name="pengirim" value="{{ old('pengirim') }}" required
                            placeholder="Nama instansi/orang pengirim"
                            class="w-full px-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg dark:bg-zinc-700 dark:text-white focus:ring-2 focus:ring-red-500 focus:border-transparent @error('pengirim') border-red-500 @enderror">
                        @error('pengirim')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tanggal Surat -->
                    <div>
                        <label for="tanggal_surat" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Tanggal Surat <span class="text-red-600">*</span>
                        </label>
                        <input type="date" id="tanggal_surat" name="tanggal_surat" value="{{ old('tanggal_surat') }}" required
                            class="w-full px-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg dark:bg-zinc-700 dark:text-white focus:ring-2 focus:ring-red-500 focus:border-transparent @error('tanggal_surat') border-red-500 @enderror">
                        @error('tanggal_surat')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Buttons -->
                    <div class="flex gap-4 pt-6">
                        <button type="submit" class="flex-1 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors font-medium cursor-pointer">
                            Simpan Surat
                        </button>
                        <a href="{{ route('surats.index') }}" class="flex-1 px-6 py-3 bg-gray-300 hover:bg-gray-400 dark:bg-zinc-700 dark:hover:bg-zinc-600 text-gray-900 dark:text-white rounded-lg transition-colors font-medium text-center">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.app>
