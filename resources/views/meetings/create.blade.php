<x-layouts.app :title="__('Tambah Jadwal Rapat')">
    <div class="min-h-screen relative overflow-hidden page-fade">
        <div class="fixed inset-0" style="background: url('{{ asset('images/foto_bapperida.png') }}') center/cover; filter: blur(5px); transform: scale(1.05);"></div>
        <div class="fixed inset-0 bg-black/25"></div>

        <div class="relative z-10 min-h-screen py-8">
            <div class="w-full px-4 sm:px-6 lg:px-8">
                <div class="max-w-3xl mx-auto">
                    <div class="bg-white dark:bg-zinc-800 shadow-lg rounded-xl overflow-hidden border border-zinc-200 dark:border-zinc-700">
                        <div class="px-6 py-5 border-b border-zinc-200 dark:border-zinc-700 bg-gray-50 dark:bg-zinc-900">
                            <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Tambah Jadwal Rapat</h2>
                            <p class="text-gray-500 dark:text-gray-400 mt-1 text-sm">Isi detail rapat berikut.</p>
                        </div>

                        <form method="POST" action="{{ route('meetings.store') }}" class="p-6 space-y-5">
                            @csrf
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Agenda</label>
                                <input type="text" name="agenda" value="{{ old('agenda') }}" class="w-full rounded-md border border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 text-gray-900 dark:text-white text-sm px-3 py-2 placeholder-zinc-400 dark:placeholder-zinc-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                                @error('agenda')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Penanggung Jawab (PIC)</label>
                                <input type="text" name="pic" value="{{ old('pic') }}" class="w-full rounded-md border border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 text-gray-900 dark:text-white text-sm px-3 py-2 placeholder-zinc-400 dark:placeholder-zinc-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                                @error('pic')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tanggal</label>
                                    <input type="date" name="date" value="{{ old('date') }}" class="w-full rounded-md border border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 text-gray-900 dark:text-white text-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                                    @error('date')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Waktu Mulai</label>
                                    <input type="time" name="start_time" value="{{ old('start_time') }}" class="w-full rounded-md border border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 text-gray-900 dark:text-white text-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                                    @error('start_time')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Waktu Selesai</label>
                                    <input type="time" name="end_time" value="{{ old('end_time') }}" class="w-full rounded-md border border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 text-gray-900 dark:text-white text-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                                    @error('end_time')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Catatan</label>
                                <input type="text" name="notes" value="{{ old('notes') }}" placeholder="Tambahkan catatan" class="w-full rounded-md border border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 text-gray-900 dark:text-white text-sm px-3 py-2 placeholder-zinc-400 dark:placeholder-zinc-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                                @error('notes')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Ruang Rapat</label>
                                <select name="ruang_rapat" class="w-full rounded-md border border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 text-gray-900 dark:text-white text-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                                    <option value="">Pilih Ruang Rapat</option>
                                    <option value="Ibdis" @selected(old('ruang_rapat') === 'Ibdis')>Ibdis</option>
                                    <option value="LT1" @selected(old('ruang_rapat') === 'LT1')>LT1</option>
                                    <option value="LT2" @selected(old('ruang_rapat') === 'LT2')>LT2</option>
                                </select>
                                @error('ruang_rapat')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                            </div>
                            <input type="hidden" name="status" value="scheduled">

                            <div class="flex items-center justify-end gap-3 pt-2">
                                <a href="{{ route('meetings.index') }}" class="inline-flex items-center px-4 py-2 rounded-md text-zinc-700 dark:text-zinc-200 bg-white dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-600 text-sm cursor-pointer transform hover:scale-105 transition-all">Batal</a>
                                <button class="inline-flex items-center px-4 py-2 rounded-md text-white bg-blue-600 hover:bg-blue-700 text-sm cursor-pointer transform hover:scale-105 transition-all">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Show error notification if there are validation errors
        @if($errors->any())
            @foreach($errors->all() as $error)
                showNotification('{{ $error }}', 'error');
            @endforeach
        @endif

        // Modern Notification System
        function showNotification(message, type = 'success') {
            const notificationId = 'notification-' + Date.now();
            let bgColor, iconColor, textColor, bgHover, borderColor;
            
            if (type === 'success') {
                bgColor = 'bg-green-600';
                iconColor = 'text-white';
                textColor = 'text-white';
                bgHover = 'hover:bg-green-700';
                borderColor = 'border-green-700';
            } else if (type === 'warning') {
                bgColor = 'bg-yellow-50';
                iconColor = 'text-yellow-500';
                textColor = 'text-yellow-800';
                bgHover = 'hover:bg-yellow-100';
                borderColor = 'border-yellow-200';
            } else {
                bgColor = 'bg-red-50';
                iconColor = 'text-red-500';
                textColor = 'text-red-800';
                bgHover = 'hover:bg-red-100';
                borderColor = 'border-red-200';
            }
            
            const notification = document.createElement('div');
            notification.id = notificationId;
            notification.className = `fixed top-4 right-4 ${bgColor} border ${borderColor} rounded-lg p-4 shadow-lg z-50 max-w-sm animate-in fade-in slide-in-from-top-2 duration-300`;
            notification.innerHTML = `
                <div class="flex items-start gap-3">
                    <div class="flex-shrink-0">
                        ${type === 'success' ? `<svg class="h-5 w-5 ${iconColor}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>` : `<svg class="h-5 w-5 ${iconColor}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>`}
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-medium ${textColor}">${message}</p>
                    </div>
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
