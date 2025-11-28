<x-layouts.app :title="__('Edit Periode')">
    <div class="min-h-screen relative overflow-hidden page-fade">
        <!-- Background -->
        <div class="fixed inset-0" style="background: url('{{ asset('images/foto_bapperida.png') }}') center/cover; filter: blur(5px); transform: scale(1.05);"></div>
        <div class="fixed inset-0 bg-black/25"></div>
        
        <!-- Content -->
        <div class="relative z-10 min-h-screen py-8">
            <div class="w-full px-4 sm:px-6 lg:px-8">
                <!-- Responsive container that adapts to sidebar state -->
                <div class="max-w-2xl mx-auto">
                    <div class="bg-white dark:bg-zinc-800 shadow-lg rounded-xl overflow-hidden border border-zinc-200 dark:border-zinc-700">
                    <div class="px-6 py-5 border-b border-zinc-200 dark:border-zinc-700 bg-gray-50 dark:bg-zinc-900">
                        <h2 class="text-2xl font-bold text-white flex items-center text-shadow">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Edit Periode
                        </h2>
                        <p class="text-white/80 text-sm text-shadow">
                            Ubah data periode untuk {{ $period->nama }}.
                        </p>
                    </div>

                    <form method="POST" action="{{ route('periods.update', $period) }}" class="p-6 space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Nama -->
                        <div>
                            <label for="nama" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                                Nama Pegawai
                            </label>
                            <input
                                type="text"
                                name="nama"
                                id="nama"
                                required
                                value="{{ old('nama', $period->nama) }}"
                                class="block w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-md shadow-sm placeholder-zinc-400 dark:placeholder-zinc-500 focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-700 dark:text-white sm:text-sm"
                                placeholder="Masukkan nama pegawai">
                            @error('nama')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tanggal Awal -->
                        <div>
                            <label for="tanggal_awal" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                                Tanggal Awal
                            </label>
                            <input
                                type="date"
                                name="tanggal_awal"
                                id="tanggal_awal"
                                required
                                value="{{ old('tanggal_awal', $period->tanggal_awal) }}"
                                class="block w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-md shadow-sm placeholder-zinc-400 dark:placeholder-zinc-500 focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-zinc-700 dark:text-white sm:text-sm">
                            @error('tanggal_awal')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">
                                Tanggal awal periode. Tanggal akhir akan otomatis dihitung +2 tahun.
                            </p>
                            <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">
                                Tanggal akhir saat ini: <strong>{{ \Carbon\Carbon::parse($period->tanggal_akhir)->format('d-m-Y') }}</strong>
                            </p>
                        </div>

                        <!-- Status Info -->
                        <div class="bg-zinc-50 dark:bg-zinc-700 p-4 rounded-lg">
                            <h3 class="text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Informasi Status</h3>
                            <div class="flex items-center space-x-4 text-sm">
                                @if($period->status === 'active')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300">
                                        Aktif
                                    </span>
                                    @php
                                        $now = \Carbon\Carbon::now();
                                        $endDate = \Carbon\Carbon::parse($period->tanggal_akhir);
                                        $monthsLeft = $now->diffInMonths($endDate, false);
                                    @endphp
                                    <span class="text-zinc-500 dark:text-zinc-400">
                                        {{ $monthsLeft >= 0 ? $monthsLeft . ' bulan lagi' : 'Sudah lewat ' . abs($monthsLeft) . ' bulan' }}
                                    </span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800 dark:bg-zinc-700 dark:text-zinc-300">
                                        Selesai
                                    </span>
                                @endif
                            </div>
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
                                Update
                            </button>
                        </div>
                    </form>
                </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
