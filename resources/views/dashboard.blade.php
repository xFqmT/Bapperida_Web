<x-layouts.app :title="__('Daftar Periode Gaji Berkala')">
    <div class="min-h-screen bg-zinc-50 dark:bg-zinc-900 py-8">
        <div class="w-full px-4 sm:px-6 lg:px-8">
            
            <!-- Header Section -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-zinc-900 dark:text-white flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mr-3 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Daftar Periode Gaji Berkala
                </h1>
                <p class="mt-2 text-lg text-zinc-600 dark:text-zinc-400">
                    Daftar nama pegawai beserta masa berlaku periode gaji berkala.
                </p>
            </div>

            <!-- Filter Section -->
            <div class="mb-6">
                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                    <div class="flex flex-wrap items-center gap-2">
                        <form action="{{ route('periods.export') }}" method="POST" class="inline">
                            @csrf
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

                    <!-- FULL 1 ROW FILTER -->
                    <form action="{{ route('dashboard') }}" method="get" class="flex flex-wrap items-end gap-2">
                        @csrf
                        <div class="flex-1 min-w-[200px]">
                            <label class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-300">Pencarian</label>
                            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama..." class="w-full rounded-md border border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-700 px-3 py-2 text-sm text-zinc-900 dark:text-white placeholder:text-zinc-400 dark:placeholder:text-zinc-400 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:focus:border-blue-400" />
                        </div>
                        <div class="min-w-[150px]">
                            <label class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-300">Tanggal awal</label>
                            <input type="date" name="from" value="{{ request('from') }}" class="w-full rounded-md border border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-700 px-3 py-2 text-sm text-zinc-900 dark:text-white focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:focus:border-blue-400" />
                        </div>
                        <div class="min-w-[150px]">
                            <label class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-300">Tanggal akhir</label>
                            <input type="date" name="to" value="{{ request('to') }}" class="w-full rounded-md border border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-700 px-3 py-2 text-sm text-zinc-900 dark:text-white focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:focus:border-blue-400" />
                        </div>
                        <div class="flex items-center gap-2">
                            <a href="{{ route('dashboard') }}" class="rounded-md px-4 py-2 text-sm font-medium text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100/50 dark:hover:bg-zinc-700/50 transition-all duration-200 cursor-pointer">Reset</a>
                            <button type="submit" class="rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 transition-all duration-200 cursor-pointer">Terapkan</button>
                        </div>
                    </form>
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
            <div class="mb-4 text-sm text-zinc-600 dark:text-zinc-400">
                <div class="flex items-center space-x-6">
                    <div class="flex items-center">
                        <span class="inline-block w-3 h-3 bg-yellow-500 rounded-full mr-2"></span>
                        <span>4 bulan sebelum akhir</span>
                    </div>
                    <div class="flex items-center">
                        <span class="inline-block w-3 h-3 bg-red-500 rounded-full mr-2"></span>
                        <span>2 bulan sebelum akhir</span>
                    </div>
                </div>
            </div>

            <!-- Active Periods Table -->
            <div class="bg-white dark:bg-zinc-800 shadow-lg rounded-xl overflow-hidden border border-zinc-200 dark:border-zinc-700 mb-6">
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

                                    // Tentukan kelas warna latar dengan tema
                                    $rowClass = 'bg-white dark:bg-zinc-800';
                                    if ($period->status === 'active') {
                                        if ($monthsLeft <= 2 && $monthsLeft >= 0) {
                                            $rowClass = 'bg-red-50 dark:bg-red-900/20 border-l-4 border-red-500'; // 🟥 Merah - Deadline (≤ 2 bulan)
                                        } elseif ($monthsLeft <= 4 && $monthsLeft > 2) {
                                            $rowClass = 'bg-yellow-50 dark:bg-yellow-900/20 border-l-4 border-yellow-500'; // 🟨 Kuning - Segera (4 bulan)
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
                                        @if($period->status === 'active' && $monthsLeft >= 0 && $monthsLeft <= 4)
                                            <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium
                                                @if($monthsLeft <= 2) bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300
                                                @elseif($monthsLeft <= 4) bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300 @endif">
                                                @if($monthsLeft > 0)
                                                    {{ $monthsLeft }} bulan {{ $remainingDays > 0 ? $remainingDays . ' hari' : '' }} lagi
                                                @else
                                                    {{ $remainingDays }} hari lagi
                                                @endif
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($period->status === 'active')
                                            @if($monthsLeft > 4)
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300">
                                                    Proses
                                                </span>
                                            @elseif($monthsLeft > 2)
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300">
                                                    Segera
                                                </span>
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300">
                                                    Deadline
                                                </span>
                                            @endif
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <div class="flex items-center space-x-2">
                                            @if($period->status === 'active')
                                                <form action="{{ route('periods.complete', $period) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit"
                                                        class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-full shadow-sm text-white bg-green-600 hover:bg-green-700 dark:bg-green-500 dark:hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition cursor-pointer"
                                                        onclick="return confirm('Apakah Anda yakin ingin menyelesaikan periode ini? Tanggal awal baru akan dihitung dari hari ini.')">
                                                        Selesai
                                                    </button>
                                                </form>
                                            @endif
                                            
                                            <a href="{{ route('periods.edit', $period) }}" 
                                               class="inline-flex items-center px-3 py-1.5 border border-zinc-300 dark:border-zinc-600 text-xs font-medium rounded-md shadow-sm text-zinc-700 dark:text-zinc-200 bg-white dark:bg-zinc-700 hover:bg-zinc-50 dark:hover:bg-zinc-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-zinc-500 transition cursor-pointer">
                                                Edit
                                            </a>
                                            
                                            <form action="{{ route('periods.hide', $period) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menyembunyikan data ini? Data tidak akan dihapus permanen.')">
                                                @csrf
                                                <button type="submit"
                                                    class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-full shadow-sm text-white bg-red-600 hover:bg-red-700 dark:bg-red-500 dark:hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition cursor-pointer">
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
        </div>
    </div>
</x-layouts.app>
