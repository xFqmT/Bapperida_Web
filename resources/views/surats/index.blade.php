<x-layouts.app :title="__('Manajemen Surat')">
    <div class="min-h-screen relative overflow-hidden page-fade">
        <div class="fixed inset-0" style="background: url('{{ asset('images/foto_bapperida.png') }}') center/cover; filter: blur(5px); transform: scale(1.05);"></div>
        <div class="fixed inset-0 bg-black/25"></div>
        
        <div class="relative z-10 min-h-screen py-8">
            <div class="w-full px-4 sm:px-6 lg:px-8">
            <div class="max-w-7xl mx-auto">
                <!-- Header Section -->
                <div class="mb-8">
                    <h1 class="text-3xl font-bold text-white flex items-center text-shadow">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mr-3 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                        </svg>
                        Manajemen Surat
                    </h1>
                    <p class="mt-2 text-lg text-white/90 text-shadow">
                        Kelola surat masuk dan disposisi dengan sistem workflow.
                    </p>
                </div>

            <!-- Notifications will be displayed via JavaScript at top-right -->

            <!-- Tabs -->
            <div class="mb-6 border-b border-zinc-200 dark:border-zinc-700">
                <div class="flex gap-8">
                    <button onclick="switchTab('active')" id="activeTab" class="px-4 py-3 border-b-2 border-blue-600 text-blue-600 font-semibold cursor-pointer">
                        Surat Aktif
                    </button>
                    <button onclick="switchTab('hidden')" id="hiddenTab" class="px-4 py-3 border-b-2 border-transparent text-gray-600 dark:text-gray-400 font-semibold hover:text-gray-900 dark:hover:text-gray-300 cursor-pointer">
                        Surat Dihapus
                    </button>
                </div>
            </div>

            <!-- Active Surats Tab -->
            <div id="activeContent" class="space-y-6">
                <!-- Filters -->
                <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-6 border border-zinc-200 dark:border-zinc-700">
                    <form id="suratFilterForm" class="space-y-4" onsubmit="return false;">
                        <div class="flex flex-wrap gap-4 items-end">
                            <!-- Search -->
                            <div class="flex-1 min-w-[200px]">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Cari</label>
                                <input type="text" name="q" value="{{ request('q') }}" placeholder="Judul, Nomor, Pengirim..." 
                                    class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg dark:bg-zinc-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>

                            <!-- Status Filter -->
                            <div class="w-40">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status</label>
                                <select name="status" class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg dark:bg-zinc-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <option value="">Semua Status</option>
                                    @foreach(\App\Models\Surat::$statusList as $key => $label)
                                        <option value="{{ $key }}" {{ request('status') === $key ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Date From -->
                            <div class="w-36">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Dari</label>
                                <input type="date" name="from" value="{{ request('from') }}" 
                                    class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg dark:bg-zinc-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>

                            <!-- Date To -->
                            <div class="w-36">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Sampai</label>
                                <input type="date" name="to" value="{{ request('to') }}" 
                                    class="w-full px-3 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg dark:bg-zinc-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex gap-2">
                                <button type="submit" class="rounded-md px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 transition-all duration-200 cursor-pointer">
                                    Terapkan Filter
                                </button>
                                <a href="{{ route('surats.index') }}" class="rounded-md px-4 py-2 text-sm font-medium text-white bg-blue-600/90 hover:bg-blue-600 dark:bg-blue-500 dark:hover:bg-blue-600 transition-all duration-200 cursor-pointer">
                                    Reset
                                </a>
                                <a href="{{ route('surats.export', request()->query()) }}" class="inline-flex items-center gap-2 rounded-md bg-blue-600/90 px-4 py-2 text-sm font-medium text-white shadow ring-1 ring-blue-600/20 hover:bg-blue-600 dark:bg-blue-500 dark:ring-blue-500/20 transition-all duration-200 cursor-pointer">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    Export
                                </a>
                                <a href="{{ route('surats.create') }}" class="inline-flex items-center gap-2 rounded-md bg-blue-600/90 px-4 py-2 text-sm font-medium text-white shadow ring-1 ring-blue-600/20 hover:bg-blue-600 dark:bg-blue-500 dark:ring-blue-500/20 transition-all duration-200 cursor-pointer">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                    Tambah Surat
                                </a>
                            </div>
                        </div>
                    </form>
    <!-- Loading Overlay -->
    <div id="loadingOverlay" class="fixed inset-0 bg-black/50 z-50 hidden items-center justify-center">
        <div class="bg-white dark:bg-zinc-800 rounded-lg p-6 flex items-center space-x-3">
            <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-blue-600"></div>
            <span class="text-zinc-700 dark:text-zinc-300">Loading...</span>
        </div>
    </div>

    <script>
        // Tab switching
        function switchTab(tab) {
            const activeTab = document.getElementById('activeTab');
            const hiddenTab = document.getElementById('hiddenTab');
            const activeContent = document.getElementById('activeContent');
            const hiddenContent = document.getElementById('hiddenContent');
            
            if (tab === 'active') {
                activeTab.className = 'px-4 py-3 border-b-2 border-blue-600 text-blue-600 font-semibold';
                hiddenTab.className = 'px-4 py-3 border-b-2 border-transparent text-gray-600 dark:text-gray-400 font-semibold hover:text-gray-900 dark:hover:text-gray-300';
                activeContent.style.display = 'block';
                hiddenContent.style.display = 'none';
            } else {
                activeTab.className = 'px-4 py-3 border-b-2 border-transparent text-gray-600 dark:text-gray-400 font-semibold hover:text-gray-900 dark:hover:text-gray-300';
                hiddenTab.className = 'px-4 py-3 border-b-2 border-blue-600 text-blue-600 font-semibold';
                activeContent.style.display = 'none';
                hiddenContent.style.display = 'block';
            }
        }
        
        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            switchTab('active');
        });
    </script>
                </div>

                <!-- Table -->
                <div class="bg-white dark:bg-zinc-800 rounded-lg shadow border border-zinc-200 dark:border-zinc-700 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-zinc-50 dark:bg-zinc-900">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">No. Surat</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Judul</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Pengirim</th>
                                    <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Tanggal</th>
                                    <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Status</th>
                                    <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Disposisi</th>
                                    <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($activeSurats as $surat)
                                    <tr class="border-b border-zinc-200 dark:border-zinc-700 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-colors">
                                        <!-- No. Surat -->
                                        <td class="px-4 py-3 text-left text-zinc-900 dark:text-white font-medium">{{ $surat->nomor_surat }}</td>
                                        
                                        <!-- Judul -->
                                        <td class="px-4 py-3 text-left">
                                            <h3 class="font-semibold text-zinc-900 dark:text-white">{{ $surat->judul }}</h3>
                                        </td>
                                        
                                        <!-- Pengirim -->
                                        <td class="px-4 py-3 text-left text-zinc-700 dark:text-zinc-300">{{ $surat->pengirim }}</td>
                                        
                                        <!-- Tanggal -->
                                        <td class="px-4 py-3 text-center text-zinc-700 dark:text-zinc-300">{{ $surat->tanggal_surat->format('d-m-Y') }}</td>
                                        
                                        <!-- Status -->
                                        <td class="px-4 py-3 text-center">
                                            <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold text-white
                                                @if($surat->status === 'kasubbang_umum') bg-blue-600
                                                @elseif($surat->status === 'sekretaris') bg-purple-600
                                                @elseif($surat->status === 'kepala') bg-amber-600
                                                @elseif($surat->status === 'selesai') bg-green-600
                                                @elseif($surat->status === 'distribusi') bg-emerald-600
                                                @else bg-gray-600
                                                @endif">
                                                {{ \App\Models\Surat::$statusList[$surat->status] ?? $surat->status }}
                                            </span>
                                        </td>
                                        
                                        <!-- Disposisi -->
                                        <td class="px-4 py-3 text-center">
                                            @if($surat->disposisi)
                                                <span class="text-xs text-zinc-600 dark:text-zinc-400">{{ Str::limit($surat->disposisi, 30) }}</span>
                                            @else
                                                <span class="text-xs text-zinc-400 dark:text-zinc-500">-</span>
                                            @endif
                                        </td>
                                        
                                        <!-- Aksi -->
                                        <td class="px-4 py-3 text-center">
                                            <div class="flex gap-2 justify-center">
                                                <a href="{{ route('surats.edit', $surat) }}" class="p-2 bg-yellow-600 hover:bg-yellow-700 text-white rounded-lg transition-colors" title="Edit">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                </a>
                                                <form action="{{ route('surats.destroy', $surat) }}" method="POST" style="display: inline;" onsubmit="return confirm('Apakah Anda yakin ingin menyembunyikan surat ini?')">
                                                    @csrf
                                                    <button type="submit" class="p-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors cursor-pointer" title="Hapus">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    
                                    <!-- Workflow Timeline Row -->
                                    <tr class="bg-zinc-50 dark:bg-zinc-900/50 border-b border-zinc-200 dark:border-zinc-700">
                                        <td colspan="7" class="px-4 py-4">

                                                <!-- Progress Bar -->
                                                <div class="space-y-2">
                                                    <div class="flex justify-between items-center">
                                                        <span class="text-xs font-semibold text-zinc-600 dark:text-zinc-400">Progress Workflow</span>
                                                        <span class="text-xs font-semibold text-zinc-600 dark:text-zinc-400">{{ round($surat->progress_percentage) }}%</span>
                                                    </div>
                                                    <div class="w-full bg-zinc-200 dark:bg-zinc-700 rounded-full h-2">
                                                        <div class="bg-gradient-to-r from-blue-600 via-purple-600 to-emerald-600 h-2 rounded-full transition-all duration-300" style="width: {{ $surat->progress_percentage }}%"></div>
                                                    </div>
                                                </div>

                                                <!-- Workflow Timeline -->
                                                <div class="flex items-center justify-between gap-2 mt-4">
                                                    @foreach($surat->workflow_steps as $step)
                                                        <div class="flex-1">
                                                            @if($step['current'] && $surat->can_move_to_next)
                                                                <form action="{{ route('surats.move-status', $surat) }}" method="POST" style="width: 100%;" onsubmit="return confirm('Apakah Anda yakin ingin memindahkan status surat ini?')" data-method="POST">
                                                                    @csrf
                                                                    <button type="submit" class="w-full px-3 py-2 rounded-lg text-xs font-semibold transition-all duration-200 flex flex-col items-center gap-1 bg-{{ $step['color'] }}-600 hover:bg-{{ $step['color'] }}-700 text-white border border-{{ $step['color'] }}-700 shadow-lg cursor-pointer">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                                                        </svg>
                                                                        <span>{{ $step['label'] }}</span>
                                                                        @if($step['date'])
                                                                            <span class="text-xs opacity-75">{{ $step['date']->format('d-m') }}</span>
                                                                        @endif
                                                                    </button>
                                                            @else
                                                                <div class="w-full px-3 py-2 rounded-lg text-xs font-semibold transition-all duration-200 flex flex-col items-center gap-1
                                                                    @if($step['completed'])
                                                                        bg-{{ $step['color'] }}-100 dark:bg-{{ $step['color'] }}-900/30 text-{{ $step['color'] }}-700 dark:text-{{ $step['color'] }}-300 border border-{{ $step['color'] }}-300 dark:border-{{ $step['color'] }}-700
                                                                    @else
                                                                        bg-zinc-100 dark:bg-zinc-800 text-zinc-400 dark:text-zinc-600 border border-zinc-300 dark:border-zinc-700 cursor-not-allowed opacity-50
                                                                    @endif">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                        @if($step['completed'])
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                                        @else
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4v.01M12 4a8 8 0 110 16 8 8 0 010-16z" />
                                                                        @endif
                                                                    </svg>
                                                                    <span>{{ $step['label'] }}</span>
                                                                    @if($step['date'])
                                                                        <span class="text-xs opacity-75">{{ $step['date']->format('d-m') }}</span>
                                                                    @endif
                                                                </div>
                                                            @endif
                                                        </div>
                                                    @endforeach
                                                </div>

                                                </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-4 py-8 text-center text-zinc-500 dark:text-zinc-400">
                                            Tidak ada surat ditemukan
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($activeSurats->hasPages())
                        <div class="px-4 py-4 border-t border-zinc-200 dark:border-zinc-700">
                            <div class="flex flex-wrap items-center justify-between gap-4">
                                <div class="text-sm text-zinc-600 dark:text-zinc-400">
                                    Menampilkan {{ $activeSurats->firstItem() }}-{{ $activeSurats->lastItem() }} dari {{ $activeSurats->total() }} surat
                                </div>
                                <div class="flex items-center gap-2">
                                    @if($activeSurats->onFirstPage())
                                        <span class="px-3 py-1 text-sm text-zinc-400 border border-zinc-300 dark:border-zinc-600 rounded cursor-not-allowed">Previous</span>
                                    @else
                                        <a href="{{ $activeSurats->previousPageUrl() }}" class="px-3 py-1 text-sm text-zinc-700 dark:text-zinc-300 border border-zinc-300 dark:border-zinc-600 rounded hover:bg-zinc-50 dark:hover:bg-zinc-700">Previous</a>
                                    @endif
                                    
                                    <select onchange="window.location.href='{{ request()->url() }}?{{ request()->getQueryString() }}&active_page='+this.value" class="px-3 py-1 text-sm border border-zinc-300 dark:border-zinc-600 rounded bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100">
                                        @for($i = 1; $i <= $activeSurats->lastPage(); $i++)
                                            <option value="{{ $i }}" {{ $activeSurats->currentPage() == $i ? 'selected' : '' }}>{{ $i }}</option>
                                        @endfor
                                    </select>
                                    
                                    @if($activeSurats->hasMorePages())
                                        <a href="{{ $activeSurats->nextPageUrl() }}" class="px-3 py-1 text-sm text-zinc-700 dark:text-zinc-300 border border-zinc-300 dark:border-zinc-600 rounded hover:bg-zinc-50 dark:hover:bg-zinc-700">Next</a>
                                    @else
                                        <span class="px-3 py-1 text-sm text-zinc-400 border border-zinc-300 dark:border-zinc-600 rounded cursor-not-allowed">Next</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Hidden Surats Tab -->
            <div id="hiddenContent" class="space-y-6" style="display: none;">
                <div class="bg-white dark:bg-zinc-800 rounded-lg shadow border border-zinc-200 dark:border-zinc-700 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-zinc-50 dark:bg-zinc-900">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">No. Surat</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Judul</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Pengirim</th>
                                    <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Tanggal</th>
                                    <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($hiddenSurats as $surat)
                                    <tr class="border-b border-zinc-200 dark:border-zinc-700 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-colors">
                                        <td class="px-4 py-3 font-mono text-zinc-900 dark:text-white">{{ $surat->nomor_surat }}</td>
                                        <td class="px-4 py-3 text-zinc-900 dark:text-white">{{ $surat->judul }}</td>
                                        <td class="px-4 py-3 text-zinc-700 dark:text-zinc-300">{{ $surat->pengirim }}</td>
                                        <td class="px-4 py-3 text-center text-zinc-700 dark:text-zinc-300">{{ $surat->tanggal_surat->format('d-m-Y') }}</td>
                                        <td class="px-4 py-3">
                                            <div class="flex items-center justify-center">
                                                <form action="{{ route('surats.restore', $surat) }}" method="POST" style="display: inline;" onsubmit="return confirm('Apakah Anda yakin ingin menampilkan kembali surat ini?')">
                                                    @csrf
                                                    <button type="submit" class="p-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors cursor-pointer" title="Kembalikan">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-4 py-8 text-center text-zinc-500 dark:text-zinc-400">
                                            Tidak ada surat yang dihapus
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($hiddenSurats->hasPages())
                        <div class="px-4 py-4 border-t border-zinc-200 dark:border-zinc-700">
                            <div class="flex flex-wrap items-center justify-between gap-4">
                                <div class="text-sm text-zinc-600 dark:text-zinc-400">
                                    Menampilkan {{ $hiddenSurats->firstItem() }}-{{ $hiddenSurats->lastItem() }} dari {{ $hiddenSurats->total() }} surat
                                </div>
                                <div class="flex items-center gap-2">
                                    @if($hiddenSurats->onFirstPage())
                                        <span class="px-3 py-1 text-sm text-zinc-400 border border-zinc-300 dark:border-zinc-600 rounded cursor-not-allowed">Previous</span>
                                    @else
                                        <a href="{{ $hiddenSurats->previousPageUrl() }}" class="px-3 py-1 text-sm text-zinc-700 dark:text-zinc-300 border border-zinc-300 dark:border-zinc-600 rounded hover:bg-zinc-50 dark:hover:bg-zinc-700">Previous</a>
                                    @endif
                                    
                                    <select onchange="window.location.href='{{ request()->url() }}?{{ request()->getQueryString() }}&hidden_page='+this.value" class="px-3 py-1 text-sm border border-zinc-300 dark:border-zinc-600 rounded bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100">
                                        @for($i = 1; $i <= $hiddenSurats->lastPage(); $i++)
                                            <option value="{{ $i }}" {{ $hiddenSurats->currentPage() == $i ? 'selected' : '' }}>{{ $i }}</option>
                                        @endfor
                                    </select>
                                    
                                    @if($hiddenSurats->hasMorePages())
                                        <a href="{{ $hiddenSurats->nextPageUrl() }}" class="px-3 py-1 text-sm text-zinc-700 dark:text-zinc-300 border border-zinc-300 dark:border-zinc-600 rounded hover:bg-zinc-50 dark:hover:bg-zinc-700">Next</a>
                                    @else
                                        <span class="px-3 py-1 text-sm text-zinc-400 border border-zinc-300 dark:border-zinc-600 rounded cursor-not-allowed">Next</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        // Show notifications on page load
        document.addEventListener('DOMContentLoaded', function() {
            @if(session('success'))
                showNotification('{{ session('success') }}', 'success');
            @endif
            @if($errors->any())
                @foreach($errors->all() as $error)
                    showNotification('{{ $error }}', 'error');
                @endforeach
            @endif
        });

        function switchTab(tab) {
            const activeContent = document.getElementById('activeContent');
            const hiddenContent = document.getElementById('hiddenContent');
            const activeTab = document.getElementById('activeTab');
            const hiddenTab = document.getElementById('hiddenTab');

            if (tab === 'active') {
                activeContent.style.display = 'block';
                hiddenContent.style.display = 'none';
                activeTab.classList.add('border-blue-600', 'text-blue-600');
                activeTab.classList.remove('border-transparent', 'text-gray-600', 'dark:text-gray-400');
                hiddenTab.classList.remove('border-blue-600', 'text-blue-600');
                hiddenTab.classList.add('border-transparent', 'text-gray-600', 'dark:text-gray-400');
            } else {
                activeContent.style.display = 'none';
                hiddenContent.style.display = 'block';
                hiddenTab.classList.add('border-blue-600', 'text-blue-600');
                hiddenTab.classList.remove('border-transparent', 'text-gray-600', 'dark:text-gray-400');
                activeTab.classList.remove('border-blue-600', 'text-blue-600');
                activeTab.classList.add('border-transparent', 'text-gray-600', 'dark:text-gray-400');
            }
        }

        // Ensure form method is preserved for move-status forms
        document.addEventListener('DOMContentLoaded', function() {
            // Protect move-status forms specifically
            const moveStatusForms = document.querySelectorAll('form[data-method="POST"]');
            moveStatusForms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    // Force POST method and prevent any method spoofing
                    form.setAttribute('method', 'POST');
                    
                    // Remove any _method hidden input if it exists
                    const methodInput = form.querySelector('input[name="_method"]');
                    if (methodInput) {
                        methodInput.remove();
                    }
                });
            });
            
            // Prevent any global form listeners from changing our methods
            document.addEventListener('submit', function(e) {
                const form = e.target;
                if (form.tagName === 'FORM' && form.hasAttribute('data-method')) {
                    const intendedMethod = form.getAttribute('data-method');
                    form.setAttribute('method', intendedMethod);
                    
                    // Remove any _method hidden input
                    const methodInput = form.querySelector('input[name="_method"]');
                    if (methodInput) {
                        methodInput.remove();
                    }
                }
            }, true); // Use capture phase to intercept early
        });

        // Modern Notification System
        function showNotification(message, type = 'success') {
            const notificationId = 'notification-' + Date.now();
            let bgColor, iconColor, textColor, bgHover, borderColor;
            
            if (type === 'success') {
                bgColor = 'bg-green-50 dark:bg-green-900/20';
                iconColor = 'text-green-600 dark:text-green-400';
                textColor = 'text-green-800 dark:text-green-200';
                borderColor = 'border-green-200 dark:border-green-800';
            } else if (type === 'error') {
                bgColor = 'bg-red-50 dark:bg-red-900/20';
                iconColor = 'text-red-600 dark:text-red-400';
                textColor = 'text-red-800 dark:text-red-200';
                borderColor = 'border-red-200 dark:border-red-800';
            } else if (type === 'warning') {
                bgColor = 'bg-yellow-50 dark:bg-yellow-900/20';
                iconColor = 'text-yellow-600 dark:text-yellow-400';
                textColor = 'text-yellow-800 dark:text-yellow-200';
                borderColor = 'border-yellow-200 dark:border-yellow-800';
            }
            
            const notification = document.createElement('div');
            notification.id = notificationId;
            notification.className = `fixed top-4 right-4 ${bgColor} border ${borderColor} rounded-lg p-4 shadow-lg z-50 max-w-sm animate-in fade-in slide-in-from-top-2 duration-300`;
            notification.innerHTML = `
                <div class="flex items-start gap-3">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 ${iconColor}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            ${type === 'success' ? '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />' : '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />'}
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="${textColor} text-sm font-medium">${message}</p>
                    </div>
                    <button onclick="document.getElementById('${notificationId}').remove()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 cursor-pointer">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            `;
            document.body.appendChild(notification);
            
            // Auto-dismiss after 5 seconds
            setTimeout(() => {
                const el = document.getElementById(notificationId);
                if (el) {
                    el.classList.remove('fade-in', 'slide-in-from-top-2');
                    el.classList.add('fade-out', 'slide-out-to-top-2');
                    setTimeout(() => el.remove(), 300);
                }
            }, 5000);
        }
    </script>
</x-layouts.app>
