<x-layouts.app :title="__('Edit Jadwal Rapat')">
    <div class="min-h-screen relative overflow-hidden page-fade">
        <div class="fixed inset-0" style="background: url('{{ asset('images/foto_bapperida.png') }}') center/cover; filter: blur(5px); transform: scale(1.05);"></div>
        <div class="fixed inset-0 bg-black/25"></div>

        <div class="relative z-10 min-h-screen py-8">
            <div class="w-full px-4 sm:px-6 lg:px-8">
                <div class="max-w-3xl mx-auto">
                    <div class="bg-white dark:bg-zinc-800 shadow-lg rounded-xl overflow-hidden border border-zinc-200 dark:border-zinc-700">
                        <div class="px-6 py-5 border-b border-zinc-200 dark:border-zinc-700 bg-gray-50 dark:bg-zinc-900">
                            <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Edit Jadwal Rapat</h2>
                            <p class="text-gray-500 dark:text-gray-400 mt-1 text-sm">Perbarui detail rapat berikut.</p>
                        </div>

                        <form method="POST" action="{{ route('meetings.update', $meeting) }}" class="p-6 space-y-5">
                            @csrf
                            @method('PUT')
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Agenda</label>
                                <input type="text" name="agenda" value="{{ old('agenda', $meeting->agenda) }}" class="w-full rounded-md border border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 text-gray-900 dark:text-white text-sm px-3 py-2 placeholder-zinc-400 dark:placeholder-zinc-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                                @error('agenda')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Penanggung Jawab (PIC)</label>
                                <input type="text" name="pic" value="{{ old('pic', $meeting->pic) }}" class="w-full rounded-md border border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 text-gray-900 dark:text-white text-sm px-3 py-2 placeholder-zinc-400 dark:placeholder-zinc-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                                @error('pic')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tanggal</label>
                                    <input type="date" name="date" value="{{ old('date', optional($meeting->date)->format('Y-m-d')) }}" class="w-full rounded-md border border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 text-gray-900 dark:text-white text-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                                    @error('date')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Waktu Mulai</label>
                                    <input type="time" name="start_time" value="{{ old('start_time', substr($meeting->start_time, 0, 5)) }}" class="w-full rounded-md border border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 text-gray-900 dark:text-white text-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                                    @error('start_time')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Waktu Selesai</label>
                                    <input type="time" name="end_time" value="{{ old('end_time', $meeting->end_time ? substr($meeting->end_time, 0, 5) : '') }}" class="w-full rounded-md border border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 text-gray-900 dark:text-white text-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                                    @error('end_time')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Catatan</label>
                                <input type="text" name="notes" value="{{ old('notes', $meeting->notes) }}" placeholder="Tambahkan catatan" class="w-full rounded-md border border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 text-gray-900 dark:text-white text-sm px-3 py-2 placeholder-zinc-400 dark:placeholder-zinc-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                                @error('notes')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Ruang Rapat</label>
                                <select name="ruang_rapat" class="w-full rounded-md border border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 text-gray-900 dark:text-white text-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                                    <option value="">Pilih Ruang Rapat</option>
                                    <option value="Ibdis" @selected(old('ruang_rapat', $meeting->ruang_rapat) === 'Ibdis')>Ibdis</option>
                                    <option value="LT1" @selected(old('ruang_rapat', $meeting->ruang_rapat) === 'LT1')>LT1</option>
                                    <option value="LT2" @selected(old('ruang_rapat', $meeting->ruang_rapat) === 'LT2')>LT2</option>
                                </select>
                                @error('ruang_rapat')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                            </div>

                            <div class="flex items-center justify-between gap-3 pt-2">
                                <a href="{{ route('meetings.index') }}" class="inline-flex items-center px-4 py-2 rounded-md text-zinc-700 dark:text-zinc-200 bg-white dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-600 text-sm cursor-pointer transform hover:scale-105 transition-all">Kembali</a>
                                <div class="space-x-2">
                                    <button class="inline-flex items-center px-4 py-2 rounded-md text-white bg-blue-600 hover:bg-blue-700 text-sm cursor-pointer transform hover:scale-105 transition-all">Simpan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
