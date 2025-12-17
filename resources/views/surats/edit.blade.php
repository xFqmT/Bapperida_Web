<x-layouts.app :title="__('Edit Surat')">
    <div class="min-h-screen relative overflow-hidden page-fade">
        <div class="fixed inset-0" style="background: url('{{ asset('images/foto_bapperida.png') }}') center/cover; filter: blur(5px); transform: scale(1.05);"></div>
        <div class="fixed inset-0 bg-black/25"></div>
        
        <div class="relative z-10 min-h-screen py-8">
            <div class="w-full px-4 sm:px-6 lg:px-8">
                <div class="max-w-2xl mx-auto">
                    <!-- Header Section -->
                    <div class="mb-8">
                        <h1 class="text-3xl font-bold text-white flex items-center text-shadow">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mr-3 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                            </svg>
                            Edit Surat
                        </h1>
                        <p class="mt-2 text-lg text-white/90 text-shadow">
                            Perbarui data surat dan kelola workflow.
                        </p>
                    </div>

                    <!-- Form -->
                    <div class="bg-white dark:bg-zinc-800 rounded-lg shadow border border-zinc-200 dark:border-zinc-700 p-6">
                        <form action="{{ route('surats.update', $surat) }}" method="POST" class="space-y-6">
                            @csrf
                            @method('PUT')

                            <!-- Nomor Surat -->
                            <div>
                                <label for="nomor_surat" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                                    Nomor Surat <span class="text-red-600">*</span>
                                </label>
                                <input type="text" id="nomor_surat" name="nomor_surat" value="{{ old('nomor_surat', $surat->nomor_surat) }}" required
                                    placeholder="Contoh: 001/BAPPERIDA/2024"
                                    class="w-full px-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('nomor_surat') border-red-500 @enderror">
                                @error('nomor_surat')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Judul -->
                            <div>
                                <label for="judul" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                                    Judul Surat <span class="text-red-600">*</span>
                                </label>
                                <input type="text" id="judul" name="judul" value="{{ old('judul', $surat->judul) }}" required
                                    placeholder="Masukkan judul surat"
                                    class="w-full px-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('judul') border-red-500 @enderror">
                                @error('judul')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Pengirim -->
                            <div>
                                <label for="pengirim" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                                    Pengirim <span class="text-red-600">*</span>
                                </label>
                                <input type="text" id="pengirim" name="pengirim" value="{{ old('pengirim', $surat->pengirim) }}" required
                                    placeholder="Nama instansi/orang pengirim"
                                    class="w-full px-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('pengirim') border-red-500 @enderror">
                                @error('pengirim')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Tanggal Surat -->
                            <div>
                                <label for="tanggal_surat" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                                    Tanggal Surat <span class="text-red-600">*</span>
                                </label>
                                <input type="date" id="tanggal_surat" name="tanggal_surat" value="{{ old('tanggal_surat', $surat->tanggal_surat->format('Y-m-d')) }}" required
                                    class="w-full px-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('tanggal_surat') border-red-500 @enderror">
                                @error('tanggal_surat')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Disposisi (Hanya muncul jika status distribusi) -->
                            @if($surat->status === 'distribusi')
                                <div>
                                    <label for="disposisi" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">
                                        Disposisi
                                    </label>
                                    <textarea id="disposisi" name="disposisi" rows="4"
                                        placeholder="Masukkan disposisi atau instruksi untuk bidang terkait"
                                        class="w-full px-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-zinc-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('disposisi') border-red-500 @enderror">{{ old('disposisi', $surat->disposisi) }}</textarea>
                                    @error('disposisi')
                                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            @endif

                            <!-- Workflow Timeline -->
                            <div>
                                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-3">
                                    Workflow Surat
                                </label>
                                
                                <!-- Progress Bar -->
                                <div class="space-y-2 mb-4">
                                    <div class="flex justify-between items-center">
                                        <span class="text-xs font-semibold text-zinc-600 dark:text-zinc-400">Progress</span>
                                        <span class="text-xs font-semibold text-zinc-600 dark:text-zinc-400">{{ round($surat->progress_percentage) }}%</span>
                                    </div>
                                    <div class="w-full bg-zinc-200 dark:bg-zinc-700 rounded-full h-3">
                                        <div class="bg-gradient-to-r from-blue-600 via-purple-600 to-emerald-600 h-3 rounded-full transition-all duration-300" style="width: {{ $surat->progress_percentage }}%"></div>
                                    </div>
                                </div>

                                <!-- Timeline Steps -->
                                <div class="space-y-3">
                                    @foreach($surat->workflow_steps as $step)
                                        <div class="flex items-center gap-3 p-3 rounded-lg border-2 transition-all
                                            @if($step['completed'])
                                                bg-{{ $step['color'] }}-50 dark:bg-{{ $step['color'] }}-900/20 border-{{ $step['color'] }}-300 dark:border-{{ $step['color'] }}-700
                                            @elseif($step['current'])
                                                bg-{{ $step['color'] }}-100 dark:bg-{{ $step['color'] }}-900/60 border-{{ $step['color'] }}-500 dark:border-{{ $step['color'] }}-500 shadow-lg shadow-{{ $step['color'] }}-500/20
                                            @else
                                                bg-zinc-50 dark:bg-zinc-800 border-zinc-300 dark:border-zinc-700
                                            @endif">
                                            
                                            <div class="flex-shrink-0">
                                                <div class="flex items-center justify-center h-8 w-8 rounded-full
                                                    @if($step['completed'])
                                                        bg-{{ $step['color'] }}-600 text-white
                                                    @elseif($step['current'])
                                                        bg-{{ $step['color'] }}-600 text-white animate-pulse
                                                    @else
                                                        bg-zinc-300 dark:bg-zinc-700 text-zinc-600 dark:text-zinc-400
                                                    @endif">
                                                    @if($step['completed'])
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                                        </svg>
                                                    @elseif($step['current'])
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                        </svg>
                                                    @else
                                                        {{ $loop->iteration }}
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="flex-1">
                                                <p class="font-semibold text-sm
                                                    @if($step['completed'])
                                                        text-{{ $step['color'] }}-900 dark:text-{{ $step['color'] }}-100
                                                    @elseif($step['current'])
                                                        text-{{ $step['color'] }}-800 dark:text-{{ $step['color'] }}-50
                                                    @else
                                                        text-zinc-600 dark:text-zinc-400
                                                    @endif">
                                                    {{ $step['label'] }}
                                                </p>
                                                @if($step['date'])
                                                    <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-1">
                                                        {{ $step['date']->format('d M Y H:i') }}
                                                    </p>
                                                @elseif(!$step['completed'] && !$step['current'])
                                                    <p class="text-xs text-zinc-400 dark:text-zinc-500 mt-1">
                                                        Menunggu...
                                                    </p>
                                                @endif
                                            </div>

                                            @if($step['current'])
                                                <div class="flex-shrink-0">
                                                    <span class="inline-block px-2 py-1 bg-{{ $step['color'] }}-600 text-white text-xs font-semibold rounded">
                                                        Aktif
                                                    </span>
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>

                                <!-- Next Action -->
                                @if($surat->can_move_to_next)
                                    <div class="mt-4 p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg">
                                        <p class="text-sm text-blue-900 dark:text-blue-100 mb-3">
                                            <strong>Langkah Selanjutnya:</strong> Pindahkan ke <strong>{{ \App\Models\Surat::$statusList[$surat->next_status] }}</strong>
                                        </p>
                                        <form action="{{ route('surats.move-status', $surat) }}" method="POST" class="inline" data-method="POST">
                                            @csrf
                                            <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors font-medium text-sm cursor-pointer">
                                                Lanjutkan ke {{ \App\Models\Surat::$statusList[$surat->next_status] }}
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <div class="mt-4 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg">
                                        <p class="text-sm text-green-900 dark:text-green-100">
                                            ✓ Surat telah selesai diproses dan didistribusikan
                                        </p>
                                    </div>
                                @endif
                            </div>

                            
                            <!-- Buttons -->
                            <div class="flex gap-4 pt-6">
                                <button type="submit" class="flex-1 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors font-medium cursor-pointer">
                                    Simpan Perubahan
                                </button>
                                <a href="{{ route('surats.index') }}" class="flex-1 px-6 py-3 bg-gray-300 hover:bg-gray-400 dark:bg-zinc-700 dark:hover:bg-zinc-600 text-gray-900 dark:text-white rounded-lg transition-colors font-medium text-center">
                                    Batal
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
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
    </script>
</x-layouts.app>
