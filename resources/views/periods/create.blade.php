<x-layouts.app :title="__('Tambah Periode')">
    <div class="min-h-screen bg-gray-50 dark:bg-zinc-900 py-8">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-zinc-800 shadow-lg rounded-xl overflow-hidden border border-zinc-200 dark:border-zinc-700">
                <div class="px-6 py-5 border-b border-zinc-200 dark:border-zinc-700 bg-gray-50 dark:bg-zinc-900">
                    <h2 class="text-2xl font-bold text-gray-800 dark:text-white flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Tambah Periode Baru
                    </h2>
                    <p class="text-gray-500 dark:text-gray-400 mt-1 text-sm">
                        Tambahkan periode gaji berkala untuk pegawai baru.
                    </p>
                </div>

                <form method="POST" action="{{ route('periods.store') }}" class="p-6 space-y-6">
                    @csrf

                    <!-- Nama -->
                    <div>
                        <label for="nama" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Nama Pegawai
                        </label>
                        <input
                            type="text"
                            name="nama"
                            id="nama"
                            required
                            value="{{ old('nama') }}"
                            class="block w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-md shadow-sm placeholder-zinc-400 dark:placeholder-zinc-500 focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-700 dark:text-white sm:text-sm"
                            placeholder="Masukkan nama pegawai">
                        @error('nama')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tanggal Awal -->
                    <div>
                        <label for="tanggal_awal" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Tanggal Awal
                        </label>
                        <input
                            type="date"
                            name="tanggal_awal"
                            id="tanggal_awal"
                            required
                            value="{{ old('tanggal_awal') }}"
                            class="block w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-md shadow-sm placeholder-zinc-400 dark:placeholder-zinc-500 focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-700 dark:text-white sm:text-sm">
                        @error('tanggal_awal')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            Tanggal awal periode. Tanggal akhir akan otomatis dihitung +2 tahun.
                        </p>
                    </div>

                    <!-- Buttons -->
                    <div class="flex justify-between pt-4">
                        <a href="{{ route('dashboard') }}" 
                           class="inline-flex items-center px-4 py-2 border border-zinc-300 dark:border-zinc-600 text-sm font-medium rounded-md shadow-sm text-zinc-700 dark:text-zinc-200 bg-white dark:bg-zinc-800 hover:bg-zinc-50 dark:hover:bg-zinc-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-zinc-500 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Kembali
                        </a>
                        
                        <button type="submit"
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.app>
