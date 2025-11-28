<x-layouts.app :title="__('Daftar Periode Gaji Berkala')">
    <div class="min-h-screen relative overflow-hidden page-fade">
        <!-- Background -->
        <div class="fixed inset-0" style="background: url('{{ asset('images/foto_bapperida.png') }}') center/cover; filter: blur(5px); transform: scale(1.05);"></div>
        <div class="fixed inset-0 bg-black/25"></div>
        
        <!-- Content -->
        <div class="relative z-10 min-h-screen py-8">
            <div class="w-full px-4 sm:px-6 lg:px-8">
            
            <!-- Header Section -->
            <div class="mb-8">
                <h1 class="text-2xl lg:text-3xl font-bold text-white flex items-center text-shadow">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 lg:h-8 lg:w-8 mr-3 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Daftar Periode Gaji Berkala
                </h1>
                <p class="mt-2 text-base lg:text-lg text-white/90 text-shadow">
                    Daftar nama pegawai beserta masa berlaku periode gaji berkala.
                </p>
            </div>

            <!-- Filter Section -->
            <div class="mb-8 filter-section">
                <!-- Search and Filter Controls -->
                <form action="{{ route('dashboard') }}" method="GET" class="flex flex-col lg:flex-row lg:items-end gap-4">
                    <div class="flex-1 min-w-0">
                        <label for="q" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Pencarian</label>
                        <input type="text" id="q" name="q" value="{{ request('q') }}" 
                            class="w-full h-11 rounded-lg border-zinc-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white px-4 py-2"
                            placeholder="Cari nama...">
                    </div>
                    
                    <div class="w-full lg:w-40">
                        <label for="status" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Status</label>
                        <select id="status" name="status" 
                            class="w-full h-11 rounded-lg border-zinc-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white px-3 py-2">
                            <option value="">Semua Status</option>
                            <option value="terlambat" {{ request('status') == 'terlambat' ? 'selected' : '' }}>Terlambat</option>
                            <option value="deadline" {{ request('status') == 'deadline' ? 'selected' : '' }}>Deadline</option>
                            <option value="segera" {{ request('status') == 'segera' ? 'selected' : '' }}>Segera</option>
                            <option value="proses" {{ request('status') == 'proses' ? 'selected' : '' }}>Proses</option>
                            <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        </select>
                    </div>
                    
                    <div class="w-full lg:w-40">
                        <label for="from" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Tanggal Awal</label>
                        <input type="date" id="from" name="from" value="{{ request('from') }}" 
                            class="w-full h-11 rounded-lg border-zinc-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white px-3 py-2">
                    </div>
                    
                    <div class="w-full lg:w-40">
                        <label for="to" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Tanggal Akhir</label>
                        <input type="date" id="to" name="to" value="{{ request('to') }}" 
                            class="w-full h-11 rounded-lg border-zinc-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-zinc-700 dark:border-zinc-600 dark:text-white px-3 py-2">
                    </div>
                    
                    <div class="flex items-center gap-3 pt-6 lg:pt-0">
                        <a href="{{ route('dashboard') }}" class="rounded-lg px-4 py-2.5 text-sm font-medium text-white hover:bg-white/10 dark:hover:bg-white/20 transition-all duration-200 cursor-pointer whitespace-nowrap">Reset</a>
                        <button type="submit" class="rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 transition-all duration-200 cursor-pointer whitespace-nowrap">Terapkan</button>
                    </div>
                </form>

                @if(request('q') || request('status') || request('from') || request('to'))
                    <div class="flex flex-wrap items-center gap-2 text-sm mt-4">
                        <span class="text-zinc-700 dark:text-zinc-300">Filter aktif:</span>
                        @if(request('q'))   <span class="rounded-full bg-white/80 dark:bg-zinc-700/80 px-3 py-1 ring-1 ring-zinc-200/50 dark:ring-zinc-600/50 text-zinc-800 dark:text-zinc-200">q: "{{ request('q') }}"</span> @endif
                        @if(request('status'))<span class="rounded-full bg-white/80 dark:bg-zinc-700/80 px-3 py-1 ring-1 ring-zinc-200/50 dark:ring-zinc-600/50 text-zinc-800 dark:text-zinc-200">status: {{ request('status') }}</span>@endif
                        @if(request('from'))<span class="rounded-full bg-white/80 dark:bg-zinc-700/80 px-3 py-1 ring-1 ring-zinc-200/50 dark:ring-zinc-600/50 text-zinc-800 dark:text-zinc-200">from: {{ request('from') }}</span>@endif
                        @if(request('to'))  <span class="rounded-full bg-white/80 dark:bg-zinc-700/80 px-3 py-1 ring-1 ring-zinc-200/50 dark:ring-zinc-600/50 text-zinc-800 dark:text-zinc-200">to: {{ request('to') }}</span>   @endif
                    </div>
                @endif
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row sm:items-center gap-2 mb-6 action-buttons">
                <a href="{{ route('periods.create') }}" class="inline-flex items-center justify-center gap-2 rounded-md bg-blue-600/90 px-4 py-2.5 text-sm font-medium text-white shadow ring-1 ring-blue-600/20 hover:bg-blue-600 dark:bg-blue-500 dark:ring-blue-500/20 transition-all duration-200 cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <span>Tambah Data</span>
                </a>
                <button onclick="openExportModal()" class="inline-flex items-center justify-center gap-2 rounded-md bg-blue-600/90 px-4 py-2.5 text-sm font-medium text-white shadow ring-1 ring-blue-600/20 hover:bg-blue-600 dark:bg-blue-500 dark:ring-blue-500/20 transition-all duration-200 cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span>Export Excel</span>
                </button>
                <a href="{{ route('periods.import') }}" class="inline-flex items-center justify-center gap-2 rounded-md bg-blue-600/90 px-4 py-2.5 text-sm font-medium text-white shadow ring-1 ring-blue-600/20 hover:bg-blue-600 dark:bg-blue-500 dark:ring-blue-500/20 transition-all duration-200 cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                    </svg>
                    <span>Import Excel</span>
                </a>
            </div>

            <!-- Export Modal -->
            <div id="exportModal" class="hidden fixed inset-0 z-50 flex items-center justify-center">
                <!-- Background overlay - blur and transparent -->
                <div class="absolute inset-0 bg-white/30 backdrop-blur-sm transition-opacity" onclick="closeExportModal()"></div>

                <!-- Modal panel (centered in viewport, scrollable if tall) -->
                <div class="relative w-full max-w-lg mx-4 max-h-[calc(100vh-4rem)] overflow-y-auto transform rounded-lg bg-white dark:bg-zinc-800 text-left shadow-xl transition-all opacity-0 scale-95" id="modalPanel">
                        <div class="bg-white dark:bg-zinc-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                                    <h3 class="text-lg leading-6 font-medium text-zinc-900 dark:text-white" id="modal-title">
                                        Export Data Periode
                                    </h3>
                                    <div class="mt-4">
                                        <label for="exportTitle" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">
                                            Judul File Excel
                                        </label>
                                        <input type="text" id="exportTitle" name="exportTitle" 
                                            class="mt-1 block w-full rounded-md border-zinc-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm dark:bg-zinc-700 dark:border-zinc-600 dark:text-white"
                                            placeholder="Contoh: Data Periode Gaji Berkala - November 2025"
                                            value="Data Periode Gaji Berkala - {{ \Carbon\Carbon::now()->format('F Y') }}">
                                    </div>
                                    <div class="mt-4">
                                        <div class="text-sm text-zinc-600 dark:text-zinc-400">
                                            <p><strong>Filter yang aktif:</strong></p>
                                            @if(request('q') || request('status') || request('from') || request('to'))
                                                @if(request('q'))   <p>• Pencarian: "{{ request('q') }}"</p> @endif
                                                @if(request('status'))<p>• Status: "{{ ucfirst(request('status')) }}"</p>@endif
                                                @if(request('from'))<p>• Tanggal awal: {{ request('from') }}</p>@endif
                                                @if(request('to'))  <p>• Tanggal akhir: {{ request('to') }}</p>@endif
                                            @else
                                                <p>• Semua data akan diexport</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 dark:bg-zinc-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button type="button" onclick="performExport()" class="export-btn w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm transition-all duration-200">
                                Export Excel
                            </button>
                            <button type="button" onclick="closeExportModal()" class="cancel-btn w-full inline-flex justify-center rounded-md border border-zinc-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-zinc-700 hover:bg-zinc-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-zinc-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm dark:bg-zinc-800 dark:border-zinc-600 dark:text-zinc-300 dark:hover:bg-zinc-700 transition-all duration-200">
                                Batal
                            </button>
                        </div>
                    </div>
                </div>
            </div>

                <!-- Status Indicators (Clean Version) -->
            <div class="mb-4 text-sm text-white dark:text-white status-indicators">
                <div class="flex flex-col sm:flex-row sm:items-center gap-3 sm:gap-6">
                    <div class="flex items-center">
                        <span class="inline-block w-3 h-3 bg-purple-500 rounded-full mr-2"></span>
                        <span>Terlambat</span>
                    </div>
                    <div class="flex items-center">
                        <span class="inline-block w-3 h-3 bg-red-500 rounded-full mr-2"></span>
                        <span>2 bulan sebelum akhir</span>
                    </div>
                    <div class="flex items-center">
                        <span class="inline-block w-3 h-3 bg-yellow-500 rounded-full mr-2"></span>
                        <span>4 bulan sebelum akhir</span>
                    </div>
                    <div class="flex items-center">
                        <span class="inline-block w-3 h-3 bg-green-500 rounded-full mr-2"></span>
                        <span>Proses</span>
                    </div>
                    <div class="flex items-center">
                        <span class="inline-block w-3 h-3 bg-gray-500 rounded-full mr-2"></span>
                        <span>Selesai</span>
                    </div>
                </div>
            </div>

            <!-- Main Content Area -->
            <div class="content-wrapper">
                <!-- Active Periods Table -->
                <div class="bg-white dark:bg-zinc-800 shadow-lg rounded-xl overflow-hidden border border-zinc-200 dark:border-zinc-700 mb-6 table-container">
                    <div class="px-6 py-5 border-b border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-900">
                        <h2 class="text-xl font-bold text-zinc-800 dark:text-white flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Periode Aktif
                        </h2>
                        <p class="text-zinc-600 dark:text-zinc-400 mt-1 text-sm">Data periode yang masih berjalan</p>
                    </div>

                    <div class="overflow-x-auto -mx-4 px-4 lg:mx-0 lg:px-0">
                        <table class="w-full min-w-[600px] divide-y divide-zinc-200 dark:divide-zinc-700">
                            <thead class="bg-zinc-50 dark:bg-zinc-900">
                                <tr>
                                    <th scope="col" class="px-4 lg:px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">
                                        Nama
                                    </th>
                                <th scope="col" class="px-4 lg:px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">
                                    Tanggal Awal
                                </th>
                                <th scope="col" class="px-4 lg:px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">
                                    Tanggal Akhir
                                </th>
                                <th scope="col" class="px-4 lg:px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">
                                    Status
                                </th>
                                <th scope="col" class="px-4 lg:px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-zinc-800 divide-y divide-zinc-200 dark:divide-zinc-700">
                            @forelse($activePeriods as $period)
                                @php
                                    $now = \Carbon\Carbon::now();
                                    $endDate = \Carbon\Carbon::parse($period->tanggal_akhir);
                                    $daysLeft = $now->diffInDays($endDate, false);
                                    
                                    // Calculate months and days properly
                                    if ($daysLeft >= 0) {
                                        $monthsLeft = intdiv($daysLeft, 30);
                                        $remainingDays = $daysLeft % 30;
                                    } else {
                                        $monthsLeft = -intdiv(abs($daysLeft), 30);
                                        $remainingDays = -(abs($daysLeft) % 30);
                                    }

                                    // Tentukan kelas warna latar dengan tema
                                    $rowClass = 'bg-white dark:bg-zinc-800';
                                    if ($period->status === 'active') {
                                        if ($daysLeft < 0) {
                                            $rowClass = 'bg-purple-50 dark:bg-purple-900/20 border-l-4 border-purple-500'; // 🟦 Ungu - Telat
                                        } elseif ($monthsLeft <= 2 && $monthsLeft >= 0) {
                                            $rowClass = 'bg-red-50 dark:bg-red-900/20 border-l-4 border-red-500'; // 🟥 Merah - Deadline (≤ 2 bulan)
                                        } elseif ($monthsLeft <= 4 && $monthsLeft > 2) {
                                            $rowClass = 'bg-yellow-50 dark:bg-yellow-900/20 border-l-4 border-yellow-500'; // 🟨 Kuning - Segera (4 bulan)
                                        }
                                    }
                                @endphp

                                <tr class="{{ $rowClass }} hover:bg-zinc-50 dark:hover:bg-zinc-700 transition-colors">
                                    <td class="px-4 lg:px-6 py-3 lg:py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-zinc-900 dark:text-white">
                                            {{ $period->nama }}
                                        </div>
                                    </td>
                                    <td class="px-4 lg:px-6 py-3 lg:py-4 whitespace-nowrap text-sm text-zinc-600 dark:text-zinc-400">
                                        {{ \Carbon\Carbon::parse($period->tanggal_awal)->format('d-m-Y') }}
                                    </td>
                                    <td class="px-4 lg:px-6 py-3 lg:py-4 whitespace-nowrap text-sm text-zinc-600 dark:text-zinc-400">
                                        <div class="space-y-1">
                                            <div>{{ \Carbon\Carbon::parse($period->tanggal_akhir)->format('d-m-Y') }}</div>
                                            @if($period->status === 'active')
                                                @if($daysLeft < 0)
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-300 border border-purple-200 dark:border-purple-700">
                                                        @if(abs($monthsLeft) > 0)
                                                            Telat {{ abs($monthsLeft) }}b {{ abs($remainingDays) > 0 ? abs($remainingDays) . 'h' : '' }}
                                                        @else
                                                            Telat {{ abs($remainingDays) }}h
                                                        @endif
                                                    </span>
                                                @elseif($monthsLeft <= 4)
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium
                                                        @if($monthsLeft <= 2) bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300
                                                        @elseif($monthsLeft <= 4) bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300 @endif">
                                                        @if($monthsLeft > 0)
                                                            {{ $monthsLeft }}b {{ $remainingDays > 0 ? $remainingDays . 'h' : '' }} lagi
                                                        @else
                                                            {{ $remainingDays }}h lagi
                                                        @endif
                                                    </span>
                                                @endif
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-4 lg:px-6 py-3 lg:py-4 whitespace-nowrap">
                                        @if($period->status === 'active')
                                            @if($daysLeft < 0)
                                                <span class="inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-300 dark:bg-purple-900/30 dark:text-purple-300 border border-purple-200 dark:border-purple-700 px-2 py-1">
                                                    Terlambat
                                                </span>
                                            @elseif($monthsLeft > 4)
                                                <span class="inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300 px-2 py-1">
                                                    Proses
                                                </span>
                                            @elseif($monthsLeft > 2)
                                                <span class="inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300 px-2 py-1">
                                                    Segera
                                                </span>
                                            @else
                                                <span class="inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300 px-2 py-1">
                                                    Deadline
                                                </span>
                                            @endif
                                        @endif
                                    </td>
                                    <td class="px-4 lg:px-6 py-3 lg:py-4 whitespace-nowrap text-sm">
                                        <div class="flex flex-col sm:flex-row gap-1 sm:gap-2">
                                            @if($period->status === 'active')
                                                <form action="{{ route('periods.complete', $period) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit"
                                                        class="inline-flex items-center px-2 py-1 border border-transparent text-xs font-medium rounded-full shadow-sm text-white bg-green-600 hover:bg-green-700 dark:bg-green-500 dark:hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition cursor-pointer whitespace-nowrap"
                                                        onclick="return confirm('Apakah Anda yakin ingin menyelesaikan periode ini? Tanggal awal baru akan dihitung dari hari ini.')">
                                                        Selesai
                                                    </button>
                                                </form>
                                            @endif
                                            
                                            <a href="{{ route('periods.edit', $period) }}" 
                                               class="inline-flex items-center px-2 py-1 border border-zinc-300 dark:border-zinc-600 text-xs font-medium rounded-md shadow-sm text-zinc-700 dark:text-zinc-200 bg-white dark:bg-zinc-700 hover:bg-zinc-50 dark:hover:bg-zinc-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-zinc-500 transition cursor-pointer whitespace-nowrap">
                                                Edit
                                            </a>
                                            
                                            <form action="{{ route('periods.hide', $period) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menyembunyikan data ini? Data tidak akan dihapus permanen.')">
                                                @csrf
                                                <button type="submit"
                                                    class="inline-flex items-center px-2 py-1 border border-transparent text-xs font-medium rounded-full shadow-sm text-white bg-red-600 hover:bg-red-700 dark:bg-red-500 dark:hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition cursor-pointer whitespace-nowrap">
                                                    Sembunyikan
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-zinc-500 dark:text-zinc-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-zinc-300 dark:text-zinc-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        <p class="mt-2 text-lg font-medium">Belum ada data periode aktif.</p>
                                        <p class="mt-1 text-sm">Silakan tambah data manual atau import file Excel untuk memulai.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Completed Periods Table -->
            <div class="bg-white dark:bg-zinc-800 shadow-lg rounded-xl overflow-hidden border border-zinc-200 dark:border-zinc-700">
                <div class="px-6 py-5 border-b border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-900">
                    <h2 class="text-xl font-bold text-zinc-800 dark:text-white flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-zinc-600 dark:text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Periode Selesai
                    </h2>
                    <p class="text-zinc-600 dark:text-zinc-400 mt-1 text-sm">Data periode yang telah selesai</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full divide-y divide-zinc-200 dark:divide-zinc-700">
                        <thead class="bg-zinc-50 dark:bg-zinc-900">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                                    Nama
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                                    Tanggal Awal
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                                    Tanggal Akhir
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                                    Status
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-zinc-800 divide-y divide-zinc-200 dark:divide-zinc-700">
                            @forelse($completedPeriods as $period)
                                <tr class="bg-zinc-50 dark:bg-zinc-700/50 hover:bg-zinc-100 dark:hover:bg-zinc-700 transition-colors duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-zinc-600 dark:text-zinc-300">
                                            {{ $period->nama }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-500 dark:text-zinc-400">
                                        {{ \Carbon\Carbon::parse($period->tanggal_awal)->format('d-m-Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-500 dark:text-zinc-400">
                                        {{ \Carbon\Carbon::parse($period->tanggal_akhir)->format('d-m-Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-zinc-100 text-zinc-600 dark:bg-zinc-700 dark:text-zinc-300 border border-zinc-200 dark:border-zinc-600">
                                            Selesai
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <div class="flex items-center space-x-2">
                                            <a href="{{ route('periods.edit', $period) }}" 
                                               class="inline-flex items-center px-3 py-1.5 border border-zinc-300 dark:border-zinc-600 text-xs font-medium rounded-md shadow-sm text-zinc-700 dark:text-zinc-200 bg-white dark:bg-zinc-700 hover:bg-zinc-50 dark:hover:bg-zinc-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-zinc-500 transition cursor-pointer">
                                                Edit
                                            </a>
                                            
                                            <form action="{{ route('periods.hide', $period) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menyembunyikan data ini? Data tidak akan dihapus permanen.')">
                                                @csrf
                                                <button type="submit"
                                                    class="inline-flex items-center px-3 py-1.5 border border-zinc-300 dark:border-zinc-600 text-xs font-medium rounded-full text-zinc-700 dark:text-zinc-200 bg-white dark:bg-zinc-700 hover:bg-zinc-50 dark:hover:bg-zinc-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-zinc-500 transition cursor-pointer">
                                                    Sembunyikan
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-zinc-500 dark:text-zinc-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-zinc-300 dark:text-zinc-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        <p class="mt-2 text-lg font-medium">Belum ada periode yang selesai.</p>
                                        <p class="mt-1 text-sm">Periode yang selesai akan ditampilkan di sini.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="px-6 py-4 bg-zinc-50 dark:bg-zinc-900 border-t border-zinc-200 dark:border-zinc-700">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                        <div class="text-sm text-zinc-600 dark:text-zinc-400">
                            Total: <span class="font-semibold">{{ $periods->count() }}</span> periode
                        </div>
                    </div>
                </div>
            </div>

            <!-- Hidden Periods Toggle Button -->
            @if($hiddenPeriods->count() > 0)
            <div class="mb-8">
                <button onclick="toggleHiddenPeriods()" id="toggleHiddenBtn" class="w-full flex items-center justify-center gap-2 rounded-md bg-red-600/90 px-4 py-3 text-sm font-medium text-white shadow ring-1 ring-red-600/20 hover:bg-red-600 dark:bg-red-500 dark:ring-red-500/20 transition-all duration-200 cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                    </svg>
                    <span id="toggleText">Tampilkan Periode Disembunyikan ({{ $hiddenPeriods->count() }})</span>
                </button>
            </div>

            <div class="mb-4"></div>

            <!-- Hidden Periods Table (Initially Hidden) -->
            <div id="hiddenPeriodsTable" class="hidden bg-white dark:bg-zinc-800 shadow-lg rounded-xl overflow-hidden border border-zinc-200 dark:border-zinc-700 mb-6">
                <div class="px-6 py-5 border-b border-zinc-200 dark:border-zinc-700 bg-red-50 dark:bg-red-900/20">
                    <h2 class="text-xl font-bold text-zinc-800 dark:text-white flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-red-600 dark:text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                        </svg>
                        Periode yang Disembunyikan
                    </h2>
                    <p class="text-zinc-600 dark:text-zinc-400 mt-1 text-sm">Data periode yang telah disembunyikan</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full divide-y divide-zinc-200 dark:divide-zinc-700">
                        <thead class="bg-zinc-50 dark:bg-zinc-900">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                                    Nama
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                                    Tanggal Awal
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                                    Tanggal Akhir
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                                    Disembunyikan
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-zinc-800 divide-y divide-zinc-200 dark:divide-zinc-700">
                            @foreach($hiddenPeriods as $period)
                                <tr class="bg-red-50 dark:bg-red-900/10 hover:bg-red-100 dark:hover:bg-red-900/20 transition-colors duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-zinc-600 dark:text-zinc-300">
                                            {{ $period->nama }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-500 dark:text-zinc-400">
                                        {{ \Carbon\Carbon::parse($period->tanggal_awal)->format('d-m-Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-500 dark:text-zinc-400">
                                        {{ \Carbon\Carbon::parse($period->tanggal_akhir)->format('d-m-Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-500 dark:text-zinc-400">
                                        {{ \Carbon\Carbon::parse($period->deleted_at)->format('d-m-Y H:i') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <div class="flex items-center space-x-2">
                                            <form action="{{ route('periods.restore', $period->id) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit"
                                                    class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-full shadow-sm text-white bg-green-600 hover:bg-green-700 dark:bg-green-500 dark:hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition cursor-pointer">
                                                    Tampilkan Kembali
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
            </div>
            </div>
        </div>
    </div>

    <style>
        /* Export button hover effects */
        .export-btn {
            transform: translateY(0);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
        
        .export-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
        
        .export-btn:active {
            transform: translateY(0);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
        
        .cancel-btn {
            transform: translateY(0);
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        }
        
        .cancel-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
        
        .cancel-btn:active {
            transform: translateY(0);
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        }
        
        /* Modal animations */
        #exportModal {
            transition: opacity 0.3s ease-in-out;
        }
        
        #exportModal .inline-block {
            transition: transform 0.3s ease-in-out, opacity 0.3s ease-in-out;
        }
        
        /* Input focus effects */
        input[type="text"]:focus {
            transform: scale(1.01);
            transition: transform 0.2s ease-in-out;
        }
        
        /* Keep table/layout styles simple to avoid stretching when sidebar toggles */
        .content-wrapper {
            position: relative;
        }
    </style>
    <script>
        function toggleHiddenPeriods() {
            const table = document.getElementById('hiddenPeriodsTable');
            const btn = document.getElementById('toggleHiddenBtn');
            const toggleText = document.getElementById('toggleText');
            
            if (table.classList.contains('hidden')) {
                table.classList.remove('hidden');
                toggleText.textContent = 'Sembunyikan Tabel Periode';
            } else {
                table.classList.add('hidden');
                toggleText.textContent = 'Tampilkan Periode Disembunyikan ({{ $hiddenPeriods->count() }})';
            }
        }

        function openExportModal() {
            const modal = document.getElementById('exportModal');
            const modalPanel = document.getElementById('modalPanel');
            
            // Show modal
            modal.classList.remove('hidden');
            
            // Trigger animation after a tiny delay
            setTimeout(() => {
                modalPanel.classList.remove('opacity-0', 'scale-95');
                modalPanel.classList.add('opacity-100', 'scale-100');
            }, 10);
        }

        function closeExportModal() {
            const modal = document.getElementById('exportModal');
            const modalPanel = document.getElementById('modalPanel');
            
            // Add closing animation
            modalPanel.classList.add('opacity-0', 'scale-95');
            modalPanel.classList.remove('opacity-100', 'scale-100');
            
            // Hide modal after animation completes
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }

        function performExport() {
            const title = document.getElementById('exportTitle').value;
            const currentUrl = new URL(window.location);
            
            // Create form for POST request
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("periods.export") }}';
            
            // Add CSRF token
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';
            form.appendChild(csrfToken);
            
            // Add custom title
            const titleInput = document.createElement('input');
            titleInput.type = 'hidden';
            titleInput.name = 'export_title';
            titleInput.value = title;
            form.appendChild(titleInput);
            
            // Add current filters
            if (currentUrl.searchParams.has('q')) {
                const qInput = document.createElement('input');
                qInput.type = 'hidden';
                qInput.name = 'q';
                qInput.value = currentUrl.searchParams.get('q');
                form.appendChild(qInput);
            }
            
            if (currentUrl.searchParams.has('status')) {
                const statusInput = document.createElement('input');
                statusInput.type = 'hidden';
                statusInput.name = 'status';
                statusInput.value = currentUrl.searchParams.get('status');
                form.appendChild(statusInput);
            }
            
            if (currentUrl.searchParams.has('from')) {
                const fromInput = document.createElement('input');
                fromInput.type = 'hidden';
                fromInput.name = 'from';
                fromInput.value = currentUrl.searchParams.get('from');
                form.appendChild(fromInput);
            }
            
            if (currentUrl.searchParams.has('to')) {
                const toInput = document.createElement('input');
                toInput.type = 'hidden';
                toInput.name = 'to';
                toInput.value = currentUrl.searchParams.get('to');
                form.appendChild(toInput);
            }
            
            // Close modal before submitting
            closeExportModal();
            
            // Submit form after animation
            setTimeout(() => {
                document.body.appendChild(form);
                form.submit();
                document.body.removeChild(form);
            }, 300);
        }
    </script>
</x-layouts.app>
