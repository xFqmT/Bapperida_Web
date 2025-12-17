<x-layouts.app :title="__('Gaji Berkala')">
    <div class="min-h-screen relative overflow-hidden">
        <!-- Background -->
        <div class="fixed inset-0" style="background: url('{{ asset('images/foto_bapperida.png') }}') center/cover; filter: blur(5px); transform: scale(1.05);"></div>
        <div class="fixed inset-0 bg-black/25"></div>
        
        <!-- Content -->
        <div class="relative z-10 min-h-screen py-8">
            <div class="w-full px-4 sm:px-6 lg:px-8">
                <!-- Responsive container that adapts to sidebar state -->
                <div class="max-w-7xl mx-auto">
                    <!-- Header Section -->
                    <div class="mb-8">
                        <h1 class="text-3xl font-bold text-white flex items-center text-shadow">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mr-3 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Daftar Periode Gaji Berkala
                        </h1>
                        <p class="mt-2 text-lg text-white/90 text-shadow">
                            Daftar nama pegawai beserta masa berlaku periode gaji berkala.
                        </p>
                    </div>

                    <!-- Filter Section -->
                    <div class="mb-6">
                        <!-- Search and Filter Controls -->
                        <form action="{{ route('periods.index') }}" method="get" class="mb-4">
                            @csrf
                            <div class="flex flex-wrap items-end gap-3">
                                <div class="flex-1 min-w-[200px]">
                                    <label class="mb-1 block text-sm font-medium text-white dark:text-white">Pencarian</label>
                                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama..." class="w-full rounded-md border border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-700 px-3 py-2 text-sm text-zinc-900 dark:text-white placeholder:text-zinc-400 dark:placeholder:text-zinc-400 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:focus:border-blue-400" />
                                </div>
                                <div class="min-w-[150px]">
                                    <label class="mb-1 block text-sm font-medium text-white dark:text-white">Tanggal awal</label>
                                    <input type="date" name="from" value="{{ request('from') }}" class="w-full rounded-md border border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-700 px-3 py-2 text-sm text-zinc-900 dark:text-white focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:focus:border-blue-400" />
                                </div>
                                <div class="min-w-[150px]">
                                    <label class="mb-1 block text-sm font-medium text-white dark:text-white">Tanggal akhir</label>
                                    <input type="date" name="to" value="{{ request('to') }}" class="w-full rounded-md border border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-700 px-3 py-2 text-sm text-zinc-900 dark:text-white focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:focus:border-blue-400" />
                                </div>
                                <div class="min-w-[160px]">
                                    <label class="mb-1 block text-sm font-medium text-white dark:text-white">Status</label>
                                    <select name="status" class="w-full rounded-md border border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-700 px-3 py-2 text-sm text-zinc-900 dark:text-white focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:focus:border-blue-400">
                                        @php $s = request('status'); @endphp
                                        <option value="" {{ $s==='' ? 'selected' : '' }}>Semua</option>
                                        <option value="terlambat" {{ $s==='terlambat' ? 'selected' : '' }}>Terlambat</option>
                                        <option value="deadline" {{ $s==='deadline' ? 'selected' : '' }}>Deadline</option>
                                        <option value="segera" {{ $s==='segera' ? 'selected' : '' }}>Segera</option>
                                        <option value="proses" {{ $s==='proses' ? 'selected' : '' }}>Proses</option>
                                        <option value="selesai" {{ $s==='selesai' ? 'selected' : '' }}>Selesai</option>
                                    </select>
                                </div>
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('periods.index') }}" class="rounded-md px-4 py-2 text-sm font-medium text-white hover:bg-white/10 dark:hover:bg-white/20 transition-all duration-200 cursor-pointer">Reset</a>
                                    <button type="submit" class="rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 transition-all duration-200 cursor-pointer">Terapkan</button>
                                </div>
                            </div>
                        </form>

                        <!-- Action Buttons -->
                        <div class="flex flex-wrap items-center gap-2">
                            <form action="{{ route('periods.export') }}" method="POST" class="inline">
                                @csrf
                                <!-- Forward current filters to export -->
                                <input type="hidden" name="q" value="{{ request('q') }}" />
                                <input type="hidden" name="from" value="{{ request('from') }}" />
                                <input type="hidden" name="to" value="{{ request('to') }}" />
                                <input type="hidden" name="status" value="{{ request('status') }}" />
                                <button type="submit" class="inline-flex items-center gap-2 rounded-md bg-blue-600/90 px-4 py-2 text-sm font-medium text-white shadow ring-1 ring-blue-600/20 hover:bg-blue-600 dark:bg-blue-500 dark:ring-blue-500/20 transition-all duration-200 cursor-pointer">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    Export Excel
                                </button>
                            </form>
                            <a href="{{ route('periods.create') }}" class="inline-flex items-center gap-2 rounded-md bg-blue-600/90 px-4 py-2 text-sm font-medium text-white shadow ring-1 ring-blue-600/20 hover:bg-blue-600 dark:bg-blue-500 dark:ring-blue-500/20 transition-all duration-200 cursor-pointer">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                Tambah Data
                            </a>
                            <a href="{{ route('periods.import') }}" class="inline-flex items-center gap-2 rounded-md bg-blue-600/90 px-4 py-2 text-sm font-medium text-white shadow ring-1 ring-blue-600/20 hover:bg-blue-600 dark:bg-blue-500 dark:ring-blue-500/20 transition-all duration-200 cursor-pointer">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                </svg>
                                Import Excel
                            </a>
                        </div>

                        @if(request('q') || request('from') || request('to'))
                            <div class="flex flex-wrap items-center gap-2 text-sm mt-3">
                                <span class="text-zinc-700 dark:text-zinc-300">Filter aktif:</span>
                                @if(request('q'))   <span class="rounded-full bg-white/80 dark:bg-zinc-700/80 px-3 py-1 ring-1 ring-zinc-200/50 dark:ring-zinc-600/50 text-zinc-800 dark:text-zinc-200">q: "{{ request('q') }}"</span> @endif
                                @if(request('from'))<span class="rounded-full bg-white/80 dark:bg-zinc-700/80 px-3 py-1 ring-1 ring-zinc-200/50 dark:ring-zinc-600/50 text-zinc-800 dark:text-zinc-200">from: {{ request('from') }}</span>@endif
                                @if(request('to'))  <span class="rounded-full bg-white/80 dark:bg-zinc-700/80 px-3 py-1 ring-1 ring-zinc-200/50 dark:ring-zinc-600/50 text-zinc-800 dark:text-zinc-200">to: {{ request('to') }}</span>   @endif
                            </div>
                        @endif
                    </div>

                    <!-- Status Indicators (Clean Version) -->
                    <div class="mb-4 text-sm text-white dark:text-white">
                        <div class="flex items-center space-x-6">
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


                    <!-- Active Periods Table -->
                    <div id="activePeriods" class="bg-white dark:bg-zinc-800 shadow-lg rounded-xl overflow-hidden border border-zinc-200 dark:border-zinc-700 mb-6">
                        <div class="px-6 py-5 border-b border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-900">
                            <h2 class="text-xl font-bold text-zinc-800 dark:text-white flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Periode Aktif
                            </h2>
                            <p class="text-zinc-600 dark:text-zinc-400 mt-1 text-sm">Data periode yang masih berjalan</p>
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

                                            // Tentukan kelas warna latar dengan tema (berdasarkan status_period)
                                            $rowClass = 'bg-white dark:bg-zinc-800';
                                            if ($period->status === 'active') {
                                                $statusPeriod = $period->status_period;
                                                if ($statusPeriod === 'terlambat') {
                                                    $rowClass = 'bg-purple-50 dark:bg-purple-900/20 border-l-4 border-purple-500'; // Ungu - Terlambat
                                                } elseif ($statusPeriod === 'deadline') {
                                                    $rowClass = 'bg-red-50 dark:bg-red-900/20 border-l-4 border-red-500'; // Merah - Deadline (≤ 2 bulan)
                                                } elseif ($statusPeriod === 'segera') {
                                                    $rowClass = 'bg-yellow-50 dark:bg-yellow-900/20 border-l-4 border-yellow-500'; // Kuning - Segera (≤ 4 bulan)
                                                }
                                            }
                                        @endphp

                                        <tr class="{{ $rowClass }} hover:bg-zinc-50 dark:hover:bg-zinc-700 transition-colors">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-zinc-900 dark:text-white">
                                                    {{ $period->nama }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-600 dark:text-zinc-400">
                                                {{ \Carbon\Carbon::parse($period->tanggal_awal)->format('d-m-Y') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-600 dark:text-zinc-400">
                                                {{ \Carbon\Carbon::parse($period->tanggal_akhir)->format('d-m-Y') }}
                                                @if($period->status === 'active')
                                                    @php
                                                        $statusPeriod = $period->status_period;
                                                        $parts = $period->time_left_parts; // ['sign'=>1|-1,'months'=>int,'days'=>int]
                                                        $mTxt = $parts['months'] > 0 ? ($parts['months'].' bulan ') : '';
                                                        $dTxt = $parts['days'] > 0 ? ($parts['days'].' hari') : '';
                                                    @endphp
                                                    <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium
                                                        @if($statusPeriod === 'terlambat')
                                                            bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-300
                                                        @elseif($statusPeriod === 'deadline')
                                                            bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300
                                                        @elseif($statusPeriod === 'segera')
                                                            bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300
                                                        @else
                                                            bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300
                                                        @endif">
                                                        @if($statusPeriod === 'terlambat')
                                                            Terlambat {{ trim($mTxt.$dTxt) }}
                                                        @else
                                                            {{ trim($mTxt.$dTxt) }} lagi
                                                        @endif
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($period->status === 'active')
                                                    @php
                                                        $statusPeriod = $period->status_period;
                                                    @endphp
                                                    @if($statusPeriod === 'terlambat')
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-300">
                                                            Terlambat
                                                        </span>
                                                    @elseif($statusPeriod === 'deadline')
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300">
                                                            Deadline
                                                        </span>
                                                    @elseif($statusPeriod === 'segera')
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300">
                                                            Segera
                                                        </span>
                                                    @elseif($statusPeriod === 'proses')
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300">
                                                            Proses
                                                        </span>
                                                    @endif
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                <div class="flex items-center space-x-2">
                                                    @if($period->status === 'active')
                                                        <button onclick="completePeriod({{ $period->id }})"
                                                            class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-full shadow-sm text-white bg-green-600 hover:bg-green-700 dark:bg-green-500 dark:hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition cursor-pointer"
                                                            title="Selesaikan periode ini">
                                                            Selesai
                                                        </button>
                                                    @endif
                                                    
                                                    <a href="{{ route('periods.edit', $period) }}" 
                                                       class="inline-flex items-center px-3 py-1.5 border border-zinc-300 dark:border-zinc-600 text-xs font-medium rounded-md shadow-sm text-zinc-700 dark:text-zinc-200 bg-white dark:bg-zinc-700 hover:bg-zinc-50 dark:hover:bg-zinc-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-zinc-500 transition cursor-pointer">
                                                        Edit
                                                    </a>
                                                    
                                                    <button onclick="hidePeriod({{ $period->id }})"
                                                        class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-full shadow-sm text-white bg-red-600 hover:bg-red-700 dark:bg-red-500 dark:hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition cursor-pointer"
                                                        title="Sembunyikan periode ini">
                                                        Sembunyikan
                                                    </button>
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

                        <!-- Pagination for Active Periods -->
                        <div class="px-6 py-4 bg-zinc-50 dark:bg-zinc-900 border-t border-zinc-200 dark:border-zinc-700">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                                <div class="text-sm text-zinc-600 dark:text-zinc-400 mb-2 sm:mb-0">
                                    Menampilkan {{ $activePeriods->firstItem() }}-{{ $activePeriods->lastItem() }} dari {{ $activePeriods->total() }} periode aktif
                                </div>
                                <div class="flex items-center space-x-1">
                                    @if($activePeriods->hasPages())
                                        <!-- Page Dropdown -->
                                        <select class="px-3 py-1 text-sm border border-zinc-300 dark:border-zinc-600 rounded bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                                onchange="window.location.href='{{ request()->url() }}?{{ request()->getQueryString() }}&active_page='+this.value">
                                            @for($i = 1; $i <= $activePeriods->lastPage(); $i++)
                                                <option value="{{ $i }}" {{ $activePeriods->currentPage() == $i ? 'selected' : '' }}>
                                                    {{ $i }}
                                                </option>
                                            @endfor
                                        </select>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Completed Periods Table -->
                    <div id="completedPeriods" class="bg-white dark:bg-zinc-800 shadow-lg rounded-xl overflow-hidden border border-zinc-200 dark:border-zinc-700 mb-6">
                        <div class="px-6 py-5 border-b border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-900">
                            <h2 class="text-xl font-bold text-zinc-800 dark:text-white flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-600 dark:text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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
                                        <tr class="bg-gray-50 dark:bg-gray-900/20 hover:bg-gray-100 dark:hover:bg-gray-900/30 transition-colors">
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
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-300">
                                                    Selesai
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                <div class="flex items-center space-x-2">
                                                    <a href="{{ route('periods.edit', $period) }}" 
                                                       class="inline-flex items-center px-3 py-1.5 border border-zinc-300 dark:border-zinc-600 text-xs font-medium rounded-md shadow-sm text-zinc-700 dark:text-zinc-200 bg-white dark:bg-zinc-700 hover:bg-zinc-50 dark:hover:bg-zinc-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-zinc-500 transition cursor-pointer">
                                                        Edit
                                                    </a>
                                                    
                                                    <button onclick="hidePeriod({{ $period->id }})"
                                                        class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-full shadow-sm text-white bg-red-600 hover:bg-red-700 dark:bg-red-500 dark:hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition cursor-pointer"
                                                        title="Sembunyikan periode ini">
                                                        Sembunyikan
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="px-6 py-12 text-center text-zinc-500 dark:text-zinc-400">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-zinc-300 dark:text-zinc-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                                <p class="mt-2 text-lg font-medium">Belum ada data periode selesai.</p>
                                                <p class="mt-1 text-sm">Periode yang selesai akan ditampilkan di sini.</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination for Completed Periods -->
                        <div class="px-6 py-4 bg-zinc-50 dark:bg-zinc-900 border-t border-zinc-200 dark:border-zinc-700">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                                <div class="text-sm text-zinc-600 dark:text-zinc-400 mb-2 sm:mb-0">
                                    Menampilkan {{ $completedPeriods->firstItem() }}-{{ $completedPeriods->lastItem() }} dari {{ $completedPeriods->total() }} periode selesai
                                </div>
                                <div class="flex items-center space-x-1">
                                    @if($completedPeriods->hasPages())
                                        <!-- Page Dropdown -->
                                        <select class="px-3 py-1 text-sm border border-zinc-300 dark:border-zinc-600 rounded bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                                onchange="window.location.href='{{ request()->url() }}?{{ request()->getQueryString() }}&completed_page='+this.value">
                                            @for($i = 1; $i <= $completedPeriods->lastPage(); $i++)
                                                <option value="{{ $i }}" {{ $completedPeriods->currentPage() == $i ? 'selected' : '' }}>
                                                    {{ $i }}
                                                </option>
                                            @endfor
                                        </select>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Toggle Hidden Periods Button - Below Completed Periods Table -->
                    <div class="mt-6">
                        <button onclick="toggleTable('hiddenPeriods')" id="toggleHiddenBtn" class="w-full inline-flex items-center justify-center px-4 py-3 rounded-md text-sm font-medium bg-blue-600 dark:bg-blue-700 text-white hover:bg-blue-700 dark:hover:bg-blue-800 shadow border border-blue-600/30 dark:border-blue-700/30 transition-all cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                            </svg>
                            <span id="toggleHiddenText">Tampilkan Periode Disembunyikan</span>
                        </button>
                    </div>

                    <!-- Hidden Periods Table -->
                    <div id="hiddenPeriods" class="bg-white dark:bg-zinc-800 shadow-lg rounded-xl overflow-hidden border border-zinc-200 dark:border-zinc-700 hidden">
                        <div class="px-6 py-5 border-b border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-900">
                            <h2 class="text-xl font-bold text-zinc-800 dark:text-white flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-red-600 dark:text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                </svg>
                                Periode Disembunyikan
                            </h2>
                            <p class="text-zinc-600 dark:text-zinc-400 mt-1 text-sm">Data periode yang telah disembunyikan (soft delete)</p>
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
                                            Dihapus pada
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">
                                            Aksi
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-zinc-800 divide-y divide-zinc-200 dark:divide-zinc-700">
                                    @forelse($hiddenPeriods as $period)
                                        <tr class="bg-red-50 dark:bg-red-900/20 hover:bg-red-100 dark:hover:bg-red-900/30 transition-colors duration-150">
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
                                                    <button onclick="restorePeriod({{ $period->id }})"
                                                        class="inline-flex items-center px-2.5 py-1 text-xs font-medium rounded border border-green-300 dark:border-green-600 text-green-700 dark:text-green-300 bg-green-50 dark:bg-green-900/20 hover:bg-green-100 dark:hover:bg-green-900/30 transition cursor-pointer"
                                                        title="Pulihkan periode ini">
                                                        Pulihkan
                                                    </button>
                                                    
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="px-6 py-12 text-center text-zinc-500 dark:text-zinc-400">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-zinc-300 dark:text-zinc-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                                </svg>
                                                <p class="mt-2 text-lg font-medium">Tidak ada data yang disembunyikan.</p>
                                                <p class="mt-1 text-sm">Data yang disembunyikan akan ditampilkan di sini.</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination for Hidden Periods -->
                        <div class="px-6 py-4 bg-zinc-50 dark:bg-zinc-900 border-t border-zinc-200 dark:border-zinc-700">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                                <div class="text-sm text-zinc-600 dark:text-zinc-400 mb-2 sm:mb-0">
                                    Menampilkan {{ $hiddenPeriods->firstItem() }}-{{ $hiddenPeriods->lastItem() }} dari {{ $hiddenPeriods->total() }} periode disembunyikan
                                </div>
                                <div class="flex items-center space-x-1">
                                    @if($hiddenPeriods->hasPages())
                                        <!-- Page Dropdown -->
                                        <select class="px-3 py-1 text-sm border border-zinc-300 dark:border-zinc-600 rounded bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                                onchange="window.location.href='{{ request()->url() }}?{{ request()->getQueryString() }}&hidden_page='+this.value">
                                            @for($i = 1; $i <= $hiddenPeriods->lastPage(); $i++)
                                                <option value="{{ $i }}" {{ $hiddenPeriods->currentPage() == $i ? 'selected' : '' }}>
                                                    {{ $i }}
                                                </option>
                                            @endfor
                                        </select>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Loading Overlay -->
    <div id="loadingOverlay" class="fixed inset-0 bg-black/50 z-50 hidden items-center justify-center">
        <div class="bg-white dark:bg-zinc-800 rounded-lg p-6 flex items-center space-x-3">
            <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-blue-600"></div>
            <span class="text-zinc-700 dark:text-zinc-300">Loading...</span>
        </div>
    </div>

    <script>
        // Simple toggle function for hidden periods table
        function toggleTable(tableId) {
            const table = document.getElementById(tableId);
            const toggleText = document.getElementById('toggleHiddenText');
            
            if (table && toggleText) {
                if (table.classList.contains('hidden')) {
                    table.classList.remove('hidden');
                    toggleText.textContent = 'Sembunyikan Periode Disembunyikan';
                } else {
                    table.classList.add('hidden');
                    toggleText.textContent = 'Tampilkan Periode Disembunyikan';
                }
            }
        }

        // Hide period function
        function hidePeriod(periodId) {
            if (confirm('Apakah Anda yakin ingin menyembunyikan periode ini?')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/periods/${periodId}`;
                form.innerHTML = `
                    @csrf
                    @method('DELETE')
                `;
                document.body.appendChild(form);
                form.submit();
            }
        }

        // Complete period function
        function completePeriod(periodId) {
            if (confirm('Apakah Anda yakin ingin menyelesaikan periode ini? Periode baru akan dibuat otomatis.')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/periods/${periodId}/complete`;
                form.innerHTML = `
                    @csrf
                `;
                document.body.appendChild(form);
                form.submit();
            }
        }

        // Restore period function
        function restorePeriod(periodId) {
            if (confirm('Apakah Anda yakin ingin menampilkan kembali periode ini?')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/periods/${periodId}/restore`;
                form.innerHTML = `
                    @csrf
                `;
                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>
</x-layouts.app>
