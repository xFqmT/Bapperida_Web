<x-layouts.app :title="__('Kelola Slide')">
    <div class="min-h-screen relative overflow-hidden page-fade dashboard-wrapper">
        <div class="dashboard-bg fixed inset-0" style="background: url('{{ asset('images/foto_bapperida.png') }}') center/cover; filter: blur(5px); transform: scale(1.05);"></div>
        <div class="dashboard-overlay fixed inset-0 bg-black/25"></div>

        <div class="dashboard-content relative z-10 min-h-screen py-8">
            <div class="w-full px-4 sm:px-6 lg:px-8">
                <div class="max-w-7xl mx-auto space-y-6">
                    <div class="mb-6">
                        <a href="{{ route('meetings.index') }}" class="inline-flex items-center text-zinc-800 dark:text-white/90 hover:text-zinc-900 dark:hover:text-zinc-100 text-sm font-medium mb-4 bg-white/90 dark:bg-zinc-800/90 px-3 py-1.5 rounded-md shadow-md backdrop-blur-sm transition-all cursor-pointer transform hover:scale-105">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>
                            Kembali ke Jadwal Rapat
                        </a>
                    </div>

                    <div class="bg-white/80 dark:bg-zinc-800/80 backdrop-blur-sm shadow-lg rounded-xl overflow-hidden border border-zinc-200/50 dark:border-zinc-700/50">
                        <div class="px-6 py-5 border-b border-zinc-200/50 dark:border-zinc-700/50 bg-gray-50/80 dark:bg-zinc-900/80 backdrop-blur-sm flex items-center justify-between">
                            <div>
                                <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Kelola Slide Rapat</h2>
                                <p class="text-gray-500 dark:text-gray-400 mt-1 text-sm">Atur urutan, caption, dan status aktif slide rapat</p>
                            </div>
                            <button onclick="openAddSlideModal()" class="inline-flex items-center justify-center gap-2 rounded-lg bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 px-6 py-3 text-sm font-semibold text-white shadow-lg ring-1 ring-blue-600/20 transition-all duration-200 cursor-pointer transform hover:scale-105 active:scale-95">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                <span>Tambah Slide</span>
                            </button>
                        </div>

                        <div class="p-6 space-y-6">
                            @php
                                $activeSlides = $slides->filter(fn($s) => !$s->trashed());
                                $deletedSlides = $slides->filter(fn($s) => $s->trashed());
                            @endphp

                            <!-- Toggle Deleted Slides -->
                            @if($deletedSlides->count())
                                <div class="flex items-center gap-2 mb-6">
                                    <button onclick="toggleDeletedSlides()" id="toggleDeletedBtn" class="inline-flex items-center px-4 py-2 rounded-md text-sm font-medium bg-white dark:bg-zinc-700 text-zinc-700 dark:text-zinc-200 hover:bg-zinc-50 dark:hover:bg-zinc-600 shadow border border-zinc-200 dark:border-zinc-600 transition-all cursor-pointer transform hover:scale-105 active:scale-95">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        <span id="toggleDeletedText">Tampilkan Slide Disembunyikan</span>
                                    </button>
                                </div>
                            @endif

                            <div id="activeSlides">
                                @if($activeSlides->count())
                                    <div class="overflow-x-auto">
                                        <table class="w-full divide-y divide-zinc-200/50 dark:divide-zinc-700/50">
                                            <thead class="bg-zinc-50/50 dark:bg-zinc-900/50">
                                                <tr>
                                                    <th class="px-6 py-3 text-left text-xs font-medium text-zinc-600 dark:text-zinc-400 uppercase tracking-wider">Gambar</th>
                                                    <th class="px-6 py-3 text-left text-xs font-medium text-zinc-600 dark:text-zinc-400 uppercase tracking-wider">Caption</th>
                                                    <th class="px-6 py-3 text-left text-xs font-medium text-zinc-600 dark:text-zinc-400 uppercase tracking-wider">Urutan</th>
                                                    <th class="px-6 py-3 text-left text-xs font-medium text-zinc-600 dark:text-zinc-400 uppercase tracking-wider">Status</th>
                                                    <th class="px-6 py-3 text-right text-xs font-medium text-zinc-600 dark:text-zinc-400 uppercase tracking-wider">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white/50 dark:bg-zinc-800/50 divide-y divide-zinc-200/50 dark:divide-zinc-700/50">
                                                @foreach($activeSlides as $slide)
                                                    <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-700 transition-colors">
                                                        <td class="px-6 py-4 whitespace-nowrap">
                                                            <img src="{{ asset('storage/'.$slide->image_path) }}" alt="slide" class="h-16 w-24 object-cover rounded cursor-zoom-in" onclick="openImagePreview('{{ asset('storage/'.$slide->image_path) }}')">
                                                        </td>
                                                        <td class="px-6 py-4 text-sm text-zinc-800 dark:text-zinc-200">{{ $slide->caption ?? '(Tidak ada caption)' }}</td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-600 dark:text-zinc-400">{{ $slide->order }}</td>
                                                        <td class="px-6 py-4 whitespace-nowrap">
                                                            @if($slide->is_active)
                                                                <span class="px-3 py-1.5 inline-flex text-xs leading-4 font-semibold rounded-full bg-gradient-to-r from-emerald-500 to-green-600 text-white">✓ Aktif</span>
                                                            @else
                                                                <span class="px-3 py-1.5 inline-flex text-xs leading-4 font-semibold rounded-full bg-gradient-to-r from-slate-400 to-slate-500 text-white">○ Nonaktif</span>
                                                            @endif
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right">
                                                            <div class="flex items-center justify-end gap-1.5">
                                                                <button onclick="openEditSlideModal({{ $slide->id }}, '{{ $slide->caption ?? '' }}', {{ $slide->order }}, '{{ asset('storage/'.$slide->image_path) }}')" class="inline-flex items-center px-2.5 py-1 text-xs font-medium rounded border border-blue-300 dark:border-blue-600 text-blue-700 dark:text-blue-300 bg-blue-50 dark:bg-blue-900/20 hover:bg-blue-100 dark:hover:bg-blue-900/30 transition cursor-pointer active:scale-95">Edit</button>
                                                                <form action="{{ route('slides.toggle', $slide) }}" method="POST" class="inline-block">@csrf @method('PUT')
                                                                    <button type="submit" class="inline-flex items-center px-2.5 py-1 text-xs font-medium rounded border {{ $slide->is_active ? 'border-yellow-300 dark:border-yellow-600 text-yellow-700 dark:text-yellow-300 bg-yellow-50 dark:bg-yellow-900/20 hover:bg-yellow-100 dark:hover:bg-yellow-900/30' : 'border-green-300 dark:border-green-600 text-green-700 dark:text-green-300 bg-green-50 dark:bg-green-900/20 hover:bg-green-100 dark:hover:bg-green-900/30' }} transition cursor-pointer active:scale-95">{{ $slide->is_active ? 'Nonaktif' : 'Aktif' }}</button>
                                                                </form>
                                                                <form action="{{ route('slides.destroy', $slide) }}" method="POST" class="inline-block" onsubmit="return confirm('Sembunyikan slide ini?')">@csrf @method('DELETE')
                                                                    <button type="submit" class="inline-flex items-center px-2.5 py-1 text-xs font-medium rounded border border-red-300 dark:border-red-600 text-red-700 dark:text-red-300 bg-red-50 dark:bg-red-900/20 hover:bg-red-100 dark:hover:bg-red-900/30 transition cursor-pointer active:scale-95">Sembunyikan</button>
                                                                </form>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="text-center py-12 text-zinc-600 dark:text-zinc-300">Belum ada slide</div>
                                @endif
                            </div>

                            <div id="deletedSlides" class="hidden">
                                <h3 class="text-lg font-semibold text-zinc-800 dark:text-white mb-4">Slide Disembunyikan</h3>
                                @if($deletedSlides->count())
                                    <div class="overflow-x-auto">
                                        <table class="w-full divide-y divide-zinc-200/50 dark:divide-zinc-700/50">
                                            <thead class="bg-zinc-50/50 dark:bg-zinc-900/50">
                                                <tr>
                                                    <th class="px-6 py-3 text-left text-xs font-medium text-zinc-600 dark:text-zinc-400 uppercase tracking-wider">Gambar</th>
                                                    <th class="px-6 py-3 text-left text-xs font-medium text-zinc-600 dark:text-zinc-400 uppercase tracking-wider">Caption</th>
                                                    <th class="px-6 py-3 text-left text-xs font-medium text-zinc-600 dark:text-zinc-400 uppercase tracking-wider">Urutan</th>
                                                    <th class="px-6 py-3 text-left text-xs font-medium text-zinc-600 dark:text-zinc-400 uppercase tracking-wider">Status</th>
                                                    <th class="px-6 py-3 text-right text-xs font-medium text-zinc-600 dark:text-zinc-400 uppercase tracking-wider">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white/50 dark:bg-zinc-800/50 divide-y divide-zinc-200/50 dark:divide-zinc-700/50 opacity-75">
                                                @foreach($deletedSlides as $slide)
                                                    <tr>
                                                        <td class="px-6 py-4 whitespace-nowrap"><img src="{{ asset('storage/'.$slide->image_path) }}" class="h-16 w-24 object-cover rounded"></td>
                                                        <td class="px-6 py-4 text-sm text-zinc-800 dark:text-zinc-200">{{ $slide->caption ?? '(Tidak ada caption)' }}</td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-600 dark:text-zinc-400">{{ $slide->order }}</td>
                                                        <td class="px-6 py-4 whitespace-nowrap"><span class="px-3 py-1.5 inline-flex text-xs leading-4 font-semibold rounded-full bg-gradient-to-r from-red-500 to-rose-600 text-white">✕ Disembunyikan</span></td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right">
                                                            <form action="{{ route('slides.restore', $slide->id) }}" method="POST" class="inline-block">@csrf
                                                                <button type="submit" class="inline-flex items-center px-2.5 py-1 text-xs font-medium rounded border border-green-300 dark:border-green-600 text-green-700 dark:text-green-300 bg-green-50 dark:bg-green-900/20 hover:bg-green-100 dark:hover:bg-green-900/30 transition cursor-pointer active:scale-95">Restore</button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @elsehapus
                                    <p class="text-center text-zinc-500 dark:text-zinc-400 py-8">Tidak ada slide yang disembunyikan</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Slide Modal -->
    <div id="addSlideModal" class="hidden fixed inset-0 z-50 flex items-center justify-center" role="dialog" aria-modal="true" aria-labelledby="addSlideTitle">
        <div class="absolute inset-0 bg-white/30 backdrop-blur-sm" onclick="closeAddSlideModal()"></div>
        <div class="relative w-full max-w-lg mx-4 max-h-[calc(100vh-4rem)] overflow-y-auto transform rounded-lg bg-white dark:bg-zinc-800 text-left shadow-xl transition-all opacity-0 scale-95" id="addSlideModalPanel">
            <div class="bg-white dark:bg-zinc-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                        <h3 id="addSlideTitle" class="text-lg leading-6 font-medium text-zinc-900 dark:text-white">Tambah Slide Baru</h3>
                        <form id="addSlideForm" action="{{ route('slides.store') }}" method="POST" enctype="multipart/form-data" class="mt-4 space-y-4">@csrf
                            <div>
                                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Gambar Slide</label>
                                <input type="file" name="image" accept="image/*" class="block w-full text-sm text-gray-900 dark:text-gray-100 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-600 file:text-white hover:file:bg-blue-700 dark:file:bg-blue-500 dark:hover:file:bg-blue-600 file:cursor-pointer file:transition-all file:shadow-sm hover:file:shadow-md cursor-pointer border border-zinc-300 dark:border-zinc-600 rounded-md px-3 py-2 transition-all" required>
                                <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-1">JPG, PNG, atau WebP (Max 2MB)</p>
                                @error('image')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Caption</label>
                                <input type="text" name="caption" placeholder="Masukkan caption (opsional)" class="w-full rounded-md border border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 text-gray-900 dark:text-white text-sm px-3 py-2 placeholder-zinc-400 dark:placeholder-zinc-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Urutan</label>
                                <input type="number" name="order" min="1" value="{{ $nextOrder }}" class="w-full rounded-md border border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 text-gray-900 dark:text-white text-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                                @error('order')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div class="pt-2">
                                <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-lg bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 px-5 py-2.5 text-sm font-semibold text-white shadow-lg ring-1 ring-blue-600/20 transition-all cursor-pointer active:scale-95">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 dark:bg-zinc-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button onclick="closeAddSlideModal()" class="inline-flex w-full justify-center rounded-md bg-white dark:bg-zinc-700 px-4 py-2 text-sm font-medium text-zinc-700 dark:text-zinc-200 shadow-sm ring-1 ring-inset ring-zinc-300 dark:ring-zinc-600 hover:bg-zinc-50 dark:hover:bg-zinc-600 sm:ml-3 sm:w-auto cursor-pointer active:scale-95">Tutup</button>
            </div>
        </div>
    </div>

    <!-- Edit Slide Modal -->
    <div id="editSlideModal" class="hidden fixed inset-0 z-50 flex items-center justify-center">
        <div class="absolute inset-0 bg-white/30 backdrop-blur-sm" onclick="closeEditSlideModal()"></div>
        <div class="relative w-full max-w-lg mx-4 max-h-[calc(100vh-4rem)] overflow-y-auto transform rounded-lg bg-white dark:bg-zinc-800 text-left shadow-xl">
            <div class="bg-white dark:bg-zinc-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <h3 class="text-lg leading-6 font-medium text-zinc-900 dark:text-white mb-4">Edit Slide</h3>
                <form id="editForm" action="" method="POST" enctype="multipart/form-data">@csrf @method('PUT')
                    <input type="hidden" id="editId" name="id">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Gambar</label>
                            <input type="file" name="image" accept="image/*" class="block w-full text-sm text-gray-900 dark:text-gray-100 border border-zinc-300 dark:border-zinc-600 rounded-md px-3 py-2">
                            <div class="mt-2 relative overflow-hidden rounded border border-zinc-300 dark:border-zinc-600 bg-zinc-100 dark:bg-zinc-900" style="height: 200px;">
                                <img id="editPreview" src="" class="w-full h-full object-cover cursor-zoom-in" style="transition: transform 0.2s ease-in-out;">
                            </div>
                            <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-1">Scroll untuk zoom gambar</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Caption</label>
                            <input type="text" id="editCaption" name="caption" class="w-full rounded-md border border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 text-gray-900 dark:text-white text-sm px-3 py-2">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Urutan</label>
                            <input type="number" id="editOrder" name="order" min="0" class="w-full rounded-md border border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 text-gray-900 dark:text-white text-sm px-3 py-2">
                        </div>
                    </div>
                    <div class="mt-4">
                        <button class="inline-flex items-center justify-center gap-2 rounded-lg bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 px-5 py-2.5 text-sm font-semibold text-white shadow-lg cursor-pointer active:scale-95">Simpan</button>
                    </div>
                </form>
            </div>
            <div class="bg-gray-50 dark:bg-zinc-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button onclick="closeEditSlideModal()" class="inline-flex w-full justify-center rounded-md bg-white dark:bg-zinc-700 px-4 py-2 text-sm font-medium text-zinc-700 dark:text-zinc-200 shadow-sm ring-1 ring-inset ring-zinc-300 dark:ring-zinc-600 hover:bg-zinc-50 dark:hover:bg-zinc-600 sm:ml-3 sm:w-auto cursor-pointer active:scale-95">Tutup</button>
            </div>
        </div>
    </div>

    <!-- Image Preview Modal -->
    <div id="imagePreviewModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/80 backdrop-blur-sm">
        <div class="relative w-full h-full max-w-4xl max-h-[90vh] flex flex-col items-center justify-center overflow-hidden">
            <button onclick="closeImagePreview()" class="absolute top-4 right-4 z-10 p-2 bg-white/20 hover:bg-white/30 rounded-full transition-all cursor-pointer transform hover:scale-110">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
            <div class="w-full h-full flex items-center justify-center overflow-auto">
                <img id="previewImage" src="" alt="Preview" class="max-w-full max-h-full object-contain cursor-zoom-in" style="transition: transform 0.2s ease-in-out;">
            </div>
            <p class="absolute bottom-4 left-4 right-4 text-white text-xs text-center bg-black/50 px-3 py-2 rounded">Scroll untuk zoom gambar</p>
        </div>
    </div>

    <script>
        function openAddSlideModal(){document.getElementById('addSlideModal').classList.remove('hidden');setTimeout(()=>document.getElementById('addSlideModalPanel').classList.remove('opacity-0','scale-95'),10)}
        function closeAddSlideModal(){document.getElementById('addSlideModal').classList.add('hidden');document.getElementById('addSlideModalPanel').classList.add('opacity-0','scale-95')}
        function openEditSlideModal(id, caption, order, imgUrl){
            const form = document.getElementById('editForm');
            document.getElementById('editId').value = id;
            document.getElementById('editCaption').value = caption || '';
            document.getElementById('editOrder').value = order;
            document.getElementById('editPreview').src = imgUrl;
            document.getElementById('editSlideModal').classList.remove('hidden');
        }
        function closeEditSlideModal(){document.getElementById('editSlideModal').classList.add('hidden')}
        function toggleDeletedSlides(){
            const del = document.getElementById('deletedSlides');
            del.classList.toggle('hidden');
        }
        function openImagePreview(src){
            document.getElementById('previewImage').src = src;
            document.getElementById('imagePreviewModal').classList.remove('hidden');
        }
        function closeImagePreview(){
            document.getElementById('imagePreviewModal').classList.add('hidden');
        }

        document.addEventListener('DOMContentLoaded', function(){
            const form = document.getElementById('editForm');
            if(form){
                form.addEventListener('submit', function(){
                    const id = document.getElementById('editId').value;
                    form.action = `{{ url('/slides') }}/${id}`;
                });
            }

            // Add zoom functionality to edit preview image
            const editPreview = document.getElementById('editPreview');
            if(editPreview){
                let scale = 1;
                const maxScale = 3;
                const minScale = 1;

                editPreview.addEventListener('wheel', function(e){
                    e.preventDefault();
                    const delta = e.deltaY > 0 ? -0.1 : 0.1;
                    scale = Math.max(minScale, Math.min(maxScale, scale + delta));
                    editPreview.style.transform = `scale(${scale})`;
                }, { passive: false });

                // Reset zoom when modal opens
                const originalOpenEditSlideModal = window.openEditSlideModal;
                window.openEditSlideModal = function(id, caption, order, imgUrl){
                    scale = 1;
                    originalOpenEditSlideModal(id, caption, order, imgUrl);
                    if(editPreview) editPreview.style.transform = 'scale(1)';
                };
            }

            // Add zoom functionality to image preview modal
            const previewImage = document.getElementById('previewImage');
            if(previewImage){
                let previewScale = 1;
                const previewMaxScale = 3;
                const previewMinScale = 1;

                previewImage.addEventListener('wheel', function(e){
                    e.preventDefault();
                    const delta = e.deltaY > 0 ? -0.1 : 0.1;
                    previewScale = Math.max(previewMinScale, Math.min(previewMaxScale, previewScale + delta));
                    previewImage.style.transform = `scale(${previewScale})`;
                }, { passive: false });

                // Reset zoom when preview modal opens
                const originalOpenImagePreview = window.openImagePreview;
                window.openImagePreview = function(src){
                    previewScale = 1;
                    originalOpenImagePreview(src);
                    if(previewImage) previewImage.style.transform = 'scale(1)';
                };
            }
        });
    </script>
</x-layouts.app>
