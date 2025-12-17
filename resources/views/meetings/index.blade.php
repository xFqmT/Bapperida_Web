<x-layouts.app :title="__('Jadwal Rapat')">
    <div class="min-h-screen relative overflow-hidden page-fade">
        <div class="fixed inset-0" style="background: url('{{ asset('images/foto_bapperida.png') }}') center/cover; filter: blur(5px); transform: scale(1.05);"></div>
        <div class="fixed inset-0 bg-black/25"></div>

        <div class="relative z-10 min-h-screen py-8">
            <div class="w-full px-4 sm:px-6 lg:px-8">
                <div class="max-w-7xl mx-auto space-y-6">
                    <!-- Slider Card (separated from table) -->
                    <div class="bg-white dark:bg-zinc-800 shadow-lg rounded-xl overflow-hidden border border-zinc-200 dark:border-zinc-700">
                        <div class="p-6">
                            <div class="rounded-lg overflow-hidden">
                                <div class="relative w-full aspect-[16/6] bg-zinc-100 dark:bg-zinc-900">
                                    @if($slides->count())
                                        <div class="swiper w-full h-full">
                                            <div class="swiper-wrapper">
                                                @foreach($slides as $slide)
                                                    <div class="swiper-slide relative cursor-pointer group" onclick="openImageLightbox('{{ asset('storage/'.$slide->image_path) }}', '{{ $slide->caption ?? '' }}')">
                                                        <img src="{{ asset('storage/'.$slide->image_path) }}" alt="slide" class="w-full h-full object-cover group-hover:brightness-75 transition-all duration-300">
                                                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-colors duration-300 flex items-center justify-center">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-white opacity-0 group-hover:opacity-100 transition-opacity duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v6m3-3H7" />
                                                            </svg>
                                                        </div>
                                                        @if($slide->caption)
                                                            <div class="absolute bottom-0 inset-x-0 bg-black/40 text-white px-4 py-2 text-sm">{{ $slide->caption }}</div>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div class="swiper-pagination"></div>
                                            <div class="swiper-button-prev"></div>
                                            <div class="swiper-button-next"></div>
                                        </div>
                                    @else
                                        <div class="flex items-center justify-center w-full h-full text-zinc-500">Belum ada slide</div>
                                    @endif
                                </div>
                            </div>

                            <!-- Slide actions placed below the slider - Admin only -->
                            @if(auth()->user()->isAdmin())
                                <div class="mt-6 pt-6 border-t border-zinc-200 dark:border-zinc-700">
                                    <div class="flex items-center justify-center">
                                        <a href="{{ route('slides.manage') }}" class="inline-flex items-center justify-center gap-2 rounded-md bg-zinc-600/90 px-4 py-2.5 text-sm font-medium text-white shadow ring-1 ring-zinc-600/20 hover:bg-zinc-600 dark:bg-zinc-700 dark:ring-zinc-700/20 transition-all duration-200 cursor-pointer transform hover:scale-105">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                            <span>Kelola Slide</span>
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Main Card: Actions + Table (with top margin spacing from slider) -->
                    <div class="bg-white dark:bg-zinc-800 shadow-lg rounded-xl overflow-hidden border border-zinc-200 dark:border-zinc-700">
                        <div class="px-6 py-5 border-b border-zinc-200 dark:border-zinc-700 bg-gray-50 dark:bg-zinc-900">
                            <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Jadwal Rapat</h2>
                            <p class="text-gray-500 dark:text-gray-400 mt-1 text-sm">Kelola jadwal rapat beserta slide gambar.</p>
                        </div>

                        <div class="p-6 space-y-4">

                            <form action="{{ route('meetings.index') }}" method="get" class="space-y-4">
                                <div class="flex flex-wrap items-end gap-3">
                                    <div class="flex-1 min-w-[150px]">
                                        <label class="block text-xs text-zinc-600 dark:text-zinc-400 font-medium mb-1">Agenda</label>
                                        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari agenda..." class="w-full rounded-md border border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 text-gray-900 dark:text-white text-sm px-2 py-1.5 placeholder-zinc-400 dark:placeholder-zinc-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                                    </div>
                                    <div class="flex-1 min-w-[150px]">
                                        <label class="block text-xs text-zinc-600 dark:text-zinc-400 font-medium mb-1">PIC</label>
                                        <input type="text" name="pic" value="{{ request('pic') }}" placeholder="Filter PIC" class="w-full rounded-md border border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 text-gray-900 dark:text-white text-sm px-2 py-1.5 placeholder-zinc-400 dark:placeholder-zinc-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                                    </div>
                                    <div class="flex-1 min-w-[140px]">
                                        <label class="block text-xs text-zinc-600 dark:text-zinc-400 font-medium mb-1">Dari</label>
                                        <input type="date" name="from" value="{{ request('from') }}" class="w-full rounded-md border border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 text-gray-900 dark:text-white text-sm px-2 py-1.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                                    </div>
                                    <div class="flex-1 min-w-[140px]">
                                        <label class="block text-xs text-zinc-600 dark:text-zinc-400 font-medium mb-1">Sampai</label>
                                        <input type="date" name="to" value="{{ request('to') }}" class="w-full rounded-md border border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 text-gray-900 dark:text-white text-sm px-2 py-1.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                                    </div>
                                    <div class="flex-1 min-w-[140px]">
                                        <label class="block text-xs text-zinc-600 dark:text-zinc-400 font-medium mb-1">Status</label>
                                        <select name="status" class="w-full rounded-md border border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 text-gray-900 dark:text-white text-sm px-2 py-1.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                                            <option value="">Semua</option>
                                            @foreach(['scheduled'=>'Terjadwal','ongoing'=>'Berlangsung','done'=>'Selesai'] as $val=>$label)
                                                <option value="{{ $val }}" @selected(request('status')===$val)>{{ $label }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <button type="submit" class="rounded-md px-3 py-1.5 text-xs font-medium text-white bg-blue-600 hover:bg-blue-700 transition-all duration-200 cursor-pointer whitespace-nowrap">Terapkan</button>
                                        <a href="{{ route('meetings.index') }}" class="rounded-md px-3 py-1.5 text-xs font-medium text-white bg-blue-600 hover:bg-blue-700 transition-all duration-200 cursor-pointer whitespace-nowrap">Reset</a>
                                        <a href="{{ route('meetings.export', request()->query()) }}" class="inline-flex items-center px-3 py-1.5 rounded-md text-white bg-green-600 hover:bg-green-700 text-xs font-medium cursor-pointer transform hover:scale-105 transition-all whitespace-nowrap">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            Export
                                        </a>
                                        <a href="{{ route('meetings.create') }}" class="inline-flex items-center px-3 py-1.5 rounded-md text-white bg-blue-600 hover:bg-blue-700 text-xs font-medium cursor-pointer transform hover:scale-105 transition-all whitespace-nowrap">Tambah Jadwal</a>
                                    </div>
                                </div>
                            </form>

                            <div class="overflow-x-auto">
                                <table class="w-full divide-y divide-zinc-200 dark:divide-zinc-700">
                                    <thead class="bg-zinc-50 dark:bg-zinc-900">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">PIC</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Agenda</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Tanggal</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Hari</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Waktu</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Ruang Rapat</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Status</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white dark:bg-zinc-800 divide-y divide-zinc-200 dark:divide-zinc-700">
                                        @forelse($meetings as $m)
                                            <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-700 transition-colors">
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-800 dark:text-zinc-200">{{ $m->pic }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-800 dark:text-zinc-200">{{ $m->agenda }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-600 dark:text-zinc-400">{{ 
                                                    \Carbon\Carbon::parse($m->date)->format('d-m-Y')
                                                }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-600 dark:text-zinc-400">{{ $m->day_name }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-600 dark:text-zinc-400">{{ $m->start_time }}{{ $m->end_time ? ' - '.$m->end_time : '' }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-600 dark:text-zinc-400">{{ $m->ruang_rapat ?? '-' }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    @if($m->status==='done')
                                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300">Selesai</span>
                                                    @elseif($m->status==='ongoing')
                                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300">Berlangsung</span>
                                                    @else
                                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300">Terjadwal</span>
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-left">
                                                    @if(auth()->user()->isAdmin())
                                                        <div class="flex items-center gap-1.5">
                                                            <a href="{{ route('meetings.edit',$m) }}" class="inline-flex items-center px-2.5 py-1 text-xs font-medium rounded border border-blue-300 dark:border-blue-600 text-blue-700 dark:text-blue-300 bg-blue-50 dark:bg-blue-900/20 hover:bg-blue-100 dark:hover:bg-blue-900/30 transition cursor-pointer">Edit</a>
                                                            <form action="{{ route('meetings.destroy', $m) }}" method="POST" style="display: inline;" onsubmit="return confirm('Sembunyikan jadwal ini?')">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="inline-flex items-center px-2.5 py-1 text-xs font-medium rounded border border-red-300 dark:border-red-600 text-red-700 dark:text-red-300 bg-red-50 dark:bg-red-900/20 hover:bg-red-100 dark:hover:bg-red-900/30 transition cursor-pointer">Sembunyikan</button>
                                                            </form>
                                                        </div>
                                                    @else
                                                        <span class="text-zinc-400 text-xs">-</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8" class="px-6 py-12 text-center text-zinc-500 dark:text-zinc-400">
                                                    Belum ada jadwal
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination for Meetings -->
                            <div class="px-6 py-4 bg-zinc-50 dark:bg-zinc-900 border-t border-zinc-200 dark:border-zinc-700">
                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                                    <div class="text-sm text-zinc-600 dark:text-zinc-400 mb-2 sm:mb-0">
                                        Menampilkan {{ $meetings->firstItem() }}-{{ $meetings->lastItem() }} dari {{ $meetings->total() }} jadwal rapat
                                    </div>
                                    <div class="flex items-center space-x-1">
                                        @if($meetings->hasPages())
                                            <!-- Previous Button -->
                                            @if($meetings->onFirstPage())
                                                <span class="px-3 py-1 text-sm text-zinc-400 bg-white dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-600 rounded cursor-not-allowed">
                                                    ←
                                                </span>
                                            @else
                                                <a href="{{ $meetings->previousPageUrl() }}" class="px-3 py-1 text-sm text-zinc-700 dark:text-zinc-300 bg-white dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-600 rounded hover:bg-zinc-50 dark:hover:bg-zinc-700 transition">
                                                    ←
                                                </a>
                                            @endif

                                            <!-- Page Dropdown -->
                                            <select class="px-3 py-1 text-sm border border-zinc-300 dark:border-zinc-600 rounded bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                                onchange="window.location.href='{{ request()->url() }}?{{ request()->getQueryString() }}&page='+this.value">
                                                @for($i = 1; $i <= $meetings->lastPage(); $i++)
                                                    <option value="{{ $i }}" {{ $meetings->currentPage() == $i ? 'selected' : '' }}>
                                                        {{ $i }}
                                                    </option>
                                                @endfor
                                            </select>

                                            <!-- Next Button -->
                                            @if($meetings->hasMorePages())
                                                <a href="{{ $meetings->nextPageUrl() }}" class="px-3 py-1 text-sm text-zinc-700 dark:text-zinc-300 bg-white dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-600 rounded hover:bg-zinc-50 dark:hover:bg-zinc-700 transition">
                                                    →
                                                </a>
                                            @else
                                                <span class="px-3 py-1 text-sm text-zinc-400 bg-white dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-600 rounded cursor-not-allowed">
                                                    →
                                                </span>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Hidden Meetings Section -->
                    @if(auth()->user()->isAdmin())
                        <div class="bg-white/80 dark:bg-zinc-800/80 backdrop-blur-sm shadow-lg rounded-xl overflow-hidden border border-zinc-200/50 dark:border-zinc-700/50">
                            <div class="px-6 py-5 border-b border-zinc-200/50 dark:border-zinc-700/50 bg-gray-50/80 dark:bg-zinc-900/80 backdrop-blur-sm flex items-center justify-between">
                                <h2 class="text-lg font-semibold text-zinc-800 dark:text-white">Jadwal Disembunyikan</h2>
                                <button onclick="toggleTable('hiddenMeetings')" class="inline-flex items-center gap-2 rounded-md bg-blue-600/90 px-3 py-1.5 text-sm font-medium text-white shadow ring-1 ring-blue-600/20 hover:bg-blue-600 dark:bg-blue-500 dark:ring-blue-500/20 transition-all duration-200 cursor-pointer">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    <span id="toggleHiddenText">Tampilkan Jadwal Disembunyikan</span>
                                </button>
                            </div>

                            <div id="hiddenMeetings" class="hidden">
                                <h3 class="text-lg font-semibold text-zinc-800 dark:text-white mb-4 px-6 pt-6">Jadwal Disembunyikan</h3>
                                @if($hiddenMeetings->count())
                                    <div class="overflow-x-auto">
                                        <table class="w-full divide-y divide-zinc-200 dark:divide-zinc-700">
                                            <thead class="bg-zinc-50 dark:bg-zinc-900">
                                                <tr>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">PIC</th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Agenda</th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Tanggal</th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Waktu</th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Status</th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Dihapus pada</th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white dark:bg-zinc-800 divide-y divide-zinc-200 dark:divide-zinc-700">
                                                @forelse($hiddenMeetings as $m)
                                                    <tr class="bg-red-50 dark:bg-red-900/20 hover:bg-red-100 dark:hover:bg-red-900/30 transition-colors">
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-800 dark:text-zinc-200">{{ $m->pic }}</td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-800 dark:text-zinc-200">{{ $m->agenda }}</td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-600 dark:text-zinc-400">{{ \Carbon\Carbon::parse($m->date)->format('d-m-Y') }}</td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-600 dark:text-zinc-400">{{ $m->start_time }}{{ $m->end_time ? ' - '.$m->end_time : '' }}</td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-600 dark:text-zinc-400">
                                                            @if($m->status==='done')
                                                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300">Selesai</span>
                                                            @elseif($m->status==='ongoing')
                                                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300">Berlangsung</span>
                                                            @else
                                                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300">Terjadwal</span>
                                                            @endif
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-500 dark:text-zinc-400">{{ \Carbon\Carbon::parse($m->deleted_at)->format('d-m-Y H:i') }}</td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                            <div class="flex items-center space-x-2">
                                                                <form action="{{ route('meetings.restore', $m->id) }}" method="POST" class="inline-block">@csrf
                                                                    <button type="submit" class="inline-flex items-center px-2.5 py-1 text-xs font-medium rounded border border-green-300 dark:border-green-600 text-green-700 dark:text-green-300 bg-green-50 dark:bg-green-900/20 hover:bg-green-100 dark:hover:bg-green-900/30 transition cursor-pointer">Restore</button>
                                                                </form>
                                            </div>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="7" class="px-6 py-12 text-center text-zinc-500 dark:text-zinc-400">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-zinc-300 dark:text-zinc-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                                            </svg>
                                                            <p class="mt-2 text-lg font-medium">Tidak ada jadwal yang disembunyikan.</p>
                                                            <p class="mt-1 text-sm">Jadwal yang disembunyikan akan ditampilkan di sini.</p>
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- Pagination for Hidden Meetings -->
                                    <div class="px-6 py-4 bg-zinc-50 dark:bg-zinc-900 border-t border-zinc-200 dark:border-zinc-700">
                                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                                            <div class="text-sm text-zinc-600 dark:text-zinc-400 mb-2 sm:mb-0">
                                                Menampilkan {{ $hiddenMeetings->firstItem() }}-{{ $hiddenMeetings->lastItem() }} dari {{ $hiddenMeetings->total() }} jadwal disembunyikan
                                            </div>
                                            <div class="flex items-center space-x-1">
                                                @if($hiddenMeetings->hasPages())
                                                    <!-- Page Dropdown -->
                                                    <select class="px-3 py-1 text-sm border border-zinc-300 dark:border-zinc-600 rounded bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                                            onchange="window.location.href='{{ request()->url() }}?{{ request()->getQueryString() }}&hidden_page='+this.value">
                                                        @for($i = 1; $i <= $hiddenMeetings->lastPage(); $i++)
                                                            <option value="{{ $i }}" {{ $hiddenMeetings->currentPage() == $i ? 'selected' : '' }}>
                                                                {{ $i }}
                                                            </option>
                                                        @endfor
                                                    </select>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <p class="text-center text-zinc-500 dark:text-zinc-400 py-8 px-6">Tidak ada jadwal yang disembunyikan</p>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Image Lightbox Modal -->
    <div id="imageLightbox" class="fixed inset-0 z-50 bg-black/80 backdrop-blur-sm flex items-center justify-center opacity-0 invisible transition-all duration-300">
        <div id="lightboxContent" class="relative w-full h-full max-w-4xl max-h-[90vh] flex flex-col items-center justify-center scale-95 transition-transform duration-300">
            <!-- Close Button -->
            <button onclick="closeImageLightbox()" class="absolute top-4 right-4 z-10 p-2 bg-white/20 hover:bg-white/30 rounded-full transition-all cursor-pointer transform hover:scale-110">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <!-- Image Container -->
            <div class="relative w-full h-full flex items-center justify-center px-4">
                <img id="lightboxImage" src="" alt="Full Size Image" class="max-w-full max-h-full object-contain rounded-lg shadow-2xl">
            </div>

            <!-- Caption -->
            <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 to-transparent p-6 text-white">
                <p id="lightboxCaption" class="text-lg font-medium text-center break-words"></p>
            </div>
        </div>
    </div>

    @if($slides->count())
        <link rel="stylesheet" href="https://unpkg.com/swiper@10/swiper-bundle.min.css" />
        <script src="https://unpkg.com/swiper@10/swiper-bundle.min.js"></script>
    @endif

    <script>
        let meetingsSwiper = null;
        
        // Toggle function for hidden meetings table
        function toggleTable(tableId) {
            const table = document.getElementById(tableId);
            const toggleText = document.getElementById('toggleHiddenText');
            
            if (table && toggleText) {
                if (table.classList.contains('hidden')) {
                    table.classList.remove('hidden');
                    toggleText.textContent = 'Sembunyikan Jadwal Disembunyikan';
                } else {
                    table.classList.add('hidden');
                    toggleText.textContent = 'Tampilkan Jadwal Disembunyikan';
                }
            }
        }
        
        function initMeetingsSlides() {
            // Destroy old swiper if exists
            if (meetingsSwiper) {
                meetingsSwiper.destroy();
                meetingsSwiper = null;
            }
            
            // Initialize Swiper if slides exist
            if (document.querySelector('.swiper')) {
                meetingsSwiper = new Swiper('.swiper', {
                    loop: true,
                    autoplay: { 
                        delay: 3000,
                        disableOnInteraction: false,
                        pauseOnMouseEnter: true
                    },
                    effect: 'slide',
                    speed: 800,
                    pagination: { 
                        el: '.swiper-pagination', 
                        clickable: true,
                        dynamicBullets: true
                    },
                    navigation: { 
                        nextEl: '.swiper-button-next', 
                        prevEl: '.swiper-button-prev' 
                    },
                    allowTouchMove: true,
                    grabCursor: true,
                    simulateTouch: true,
                    touchRatio: 1,
                    touchAngle: 45,
                    shortSwipes: true,
                    longSwipesRatio: 0.5,
                    longSwipesMs: 300,
                    followFinger: true
                });
                
                // Ensure autoplay starts properly
                setTimeout(() => {
                    if (meetingsSwiper) meetingsSwiper.autoplay.start();
                }, 500);
            }
        }
        
        function setupLightboxModal() {
            const modal = document.getElementById('imageLightbox');
            if (modal) {
                modal.removeEventListener('click', handleLightboxClick);
                modal.addEventListener('click', handleLightboxClick);
            }
        }
        
        function handleLightboxClick(e) {
            if (e.target === this) {
                closeImageLightbox();
            }
        }

        // Image Lightbox Functions
        window.openImageLightbox = function(imageSrc, caption) {
            const modal = document.getElementById('imageLightbox');
            const modalImg = document.getElementById('lightboxImage');
            const captionText = document.getElementById('lightboxCaption');
            
            modalImg.src = imageSrc;
            captionText.textContent = caption || 'Slide Image';
            
            modal.classList.remove('invisible');
            setTimeout(() => {
                modal.classList.add('opacity-100');
                document.getElementById('lightboxContent').classList.add('scale-100');
            }, 10);
        }

        window.closeImageLightbox = function() {
            const modal = document.getElementById('imageLightbox');
            modal.classList.remove('opacity-100');
            document.getElementById('lightboxContent').classList.remove('scale-100');
            setTimeout(() => {
                modal.classList.add('invisible');
            }, 300);
        }
        
        // Initialize on page load and on Livewire updates
        document.addEventListener('DOMContentLoaded', function() {
            // Wait for Swiper library to be available
            if (typeof Swiper !== 'undefined') {
                initMeetingsSlides();
            } else {
                setTimeout(initMeetingsSlides, 100);
            }
            setupLightboxModal();
        });
        
        // Support for Livewire navigation
        document.addEventListener('livewire:navigated', function() {
            if (typeof Swiper !== 'undefined') {
                initMeetingsSlides();
            } else {
                setTimeout(initMeetingsSlides, 100);
            }
            setupLightboxModal();
        });
        
        // Also initialize when Swiper library loads
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', function() {
                setTimeout(initMeetingsSlides, 200);
            });
        } else {
            setTimeout(initMeetingsSlides, 200);
        }
    </script>
</x-layouts.app>
