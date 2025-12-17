<x-layouts.app :title="__('Import Excel')">
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
                        <h2 class="text-2xl font-bold text-gray-800 dark:text-white flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                            </svg>
                            Import Data Excel
                        </h2>
                        <p class="text-gray-500 dark:text-gray-400 mt-1 text-sm">
                            Upload file Excel untuk menambahkan data periode secara massal.
                        </p>
                    </div>

                <!-- Instructions -->
                <div class="px-6 py-4 bg-blue-50 dark:bg-blue-900/20 border-b border-zinc-200 dark:border-zinc-700">
                    <h3 class="text-sm font-medium text-blue-800 dark:text-blue-300 mb-2">📋 Format File Excel:</h3>
                    <ul class="text-sm text-blue-700 dark:text-blue-400 space-y-1">
                        <li>• File harus berformat .xlsx, .xls, atau .csv</li>
                        <li>• Kolom A: Nama</li>
                        <li>• Kolom B: Tanggal Awal (format: YYYY-MM-DD atau DD-MM-YYYY)</li>
                        <li>• Baris pertama adalah header (nama, tanggal_awal)</li>
                    </ul>
                </div>

                <form method="POST" action="{{ route('periods.import.store') }}" enctype="multipart/form-data" class="p-6 space-y-6">
                    @csrf

                    <!-- File Upload -->
                    <div>
                        <label for="file" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Pilih File Excel
                        </label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-zinc-300 dark:border-zinc-600 border-dashed rounded-md hover:border-zinc-400 dark:hover:border-zinc-500 transition-colors">
                            <div class="space-y-1 text-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-zinc-400 dark:text-zinc-500" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-zinc-600 dark:text-zinc-400">
                                    <label for="file" class="relative cursor-pointer bg-white dark:bg-zinc-800 rounded-md font-medium text-blue-600 dark:text-blue-400 hover:text-blue-500 dark:hover:text-blue-300 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                        <span>Upload file</span>
                                        <input id="file" name="file" type="file" class="sr-only" accept=".xlsx,.xls,.csv">
                                    </label>
                                    <p class="pl-1">atau drag and drop</p>
                                </div>
                                <p class="text-xs text-zinc-500 dark:text-zinc-400">
                                    Format yang didukung: XLSX, XLS, CSV (maks. 10MB)
                                </p>
                            </div>
                        </div>
                        <p id="file-name" class="mt-2 text-sm text-gray-600 dark:text-gray-400"></p>
                        @error('file')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Sample Download -->
                    <div class="bg-zinc-50 dark:bg-zinc-700 p-4 rounded-lg">
                        <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">📥 Contoh File:</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">
                            Download contoh file Excel untuk melihat format yang benar.
                        </p>
                        <a href="{{ route('periods.import.example') }}" 
                           class="inline-flex items-center px-3 py-2 border border-zinc-300 dark:border-zinc-600 text-sm font-medium rounded-md shadow-sm text-zinc-700 dark:text-zinc-200 bg-white dark:bg-zinc-800 hover:bg-zinc-50 dark:hover:bg-zinc-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-zinc-500 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Download Contoh
                        </a>
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
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                            </svg>
                            Import Data
                        </button>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // File upload UI fix
        document.getElementById('file').addEventListener('change', function(e) {
            const fileName = e.target.files[0]?.name || '';
            const fileNameDisplay = document.getElementById('file-name');
            
            if (fileName) {
                fileNameDisplay.textContent = `File selected: ${fileName}`;
                fileNameDisplay.className = 'mt-2 text-sm text-green-600 dark:text-green-400 font-medium';
            } else {
                fileNameDisplay.textContent = '';
                fileNameDisplay.className = 'mt-2 text-sm text-gray-600 dark:text-gray-400';
            }
        });

        // Drag and drop functionality
        const dropZone = document.querySelector('.border-dashed');
        
        dropZone.addEventListener('dragover', function(e) {
            e.preventDefault();
            this.classList.add('border-blue-500', 'bg-blue-50', 'dark:bg-blue-900/20');
        });
        
        dropZone.addEventListener('dragleave', function(e) {
            e.preventDefault();
            this.classList.remove('border-blue-500', 'bg-blue-50', 'dark:bg-blue-900/20');
        });
        
        dropZone.addEventListener('drop', function(e) {
            e.preventDefault();
            this.classList.remove('border-blue-500', 'bg-blue-50', 'dark:bg-blue-900/20');
            
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                const fileInput = document.getElementById('file');
                fileInput.files = files;
                
                // Trigger change event to update file name display
                const event = new Event('change', { bubbles: true });
                fileInput.dispatchEvent(event);
            }
        });
    </script>
</x-layouts.app>
