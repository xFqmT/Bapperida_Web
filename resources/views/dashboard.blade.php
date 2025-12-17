<x-layouts.app :title="('Dashboard')">
    <div class="min-h-screen relative overflow-hidden page-fade">
        <div class="fixed inset-0" style="background: url('{{ asset('images/foto_bapperida.png') }}') center/cover; filter: blur(5px); transform: scale(1.05);"></div>
        <div class="fixed inset-0 bg-black/25"></div>
        
        <div class="relative z-10 min-h-screen py-2 pb-32">
            <div class="w-full px-4 sm:px-6 lg:px-8">

                @php
                    $now = \Carbon\Carbon::now();
                    $todayDate = $now->toDateString();
                    $slides = \App\Models\DashboardSlide::where('is_active', true)->orderBy('order')->get();
                    $todayMeetings = \App\Models\Meeting::whereDate('date', $todayDate)->orderBy('start_time')->get();
                @endphp

                <div class="bg-gradient-to-r from-red-700 to-red-600 rounded-xl shadow-lg border border-red-800/30 text-white px-2 sm:px-4 lg:px-6 py-1.5 sm:py-2.5 lg:py-3 mb-3 sm:mb-4 lg:mb-6">
                    <div class="flex items-center justify-between gap-1 sm:gap-2 lg:gap-3">
                        <div class="flex items-center gap-1 sm:gap-2 lg:gap-3">
                            <img src="{{ asset('images/logo_bapperida.png') }}" alt="Logo Bapperida" class="w-6 h-6 sm:w-8 sm:h-8 lg:w-10 lg:h-12 rounded-full bg-white p-1 shadow">
                            <div>
                                <div class="text-[10px] sm:text-xs lg:text-sm uppercase tracking-widest opacity-90">DIGITAL INFORMATION CENTER</div>
                                <div class="text-sm sm:text-base lg:text-lg xl:text-xl 2xl:text-2xl font-extrabold leading-tight">BAPPERIDA</div>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-xs sm:text-sm lg:text-base xl:text-lg">{{ $now->translatedFormat('l, d F Y') }}</div>
                            <div id="clockNow" class="text-base sm:text-lg lg:text-xl xl:text-2xl 2xl:text-3xl font-black">{{ $now->format('H.i') }}</div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-4">
                    <div class="lg:col-span-8">
                        <div class="bg-white dark:bg-zinc-800 shadow-lg rounded-xl overflow-hidden border border-zinc-200 dark:border-zinc-700 h-full flex flex-col slide-container">
                            <div class="px-2 sm:px-3 lg:px-4 py-1 sm:py-1.5 lg:py-2 bg-zinc-900 text-white text-xs sm:text-sm lg:text-base font-semibold flex items-center justify-between">
                                <span class="text-xs sm:text-sm lg:text-base">Foto Kegiatan Terbaru</span>
                                @if(auth()->user()->isAdmin())
                                    <a href="{{ route('dashboard_slides.manage') }}" class="inline-flex items-center gap-1 sm:gap-2 rounded-md bg-zinc-700/90 px-1.5 sm:px-2.5 lg:px-3 py-0.5 sm:py-1 lg:py-1.5 text-xs sm:text-sm font-medium text-white shadow ring-1 ring-zinc-600/20 hover:bg-zinc-700 transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 sm:h-4 sm:w-4 lg:h-5 lg:w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        <span class="text-xs sm:text-sm">Kelola</span>
                                    </a>
                                @endif
                            </div>
                            <div class="p-4 flex-1 flex flex-col">
                                <div class="rounded-lg overflow-hidden">
                                    <div class="relative w-full aspect-[16/9] bg-zinc-100 dark:bg-zinc-900">
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

                            </div>
                        </div>
                    </div>
                    

                    <div class="lg:col-span-4">
                        <div class="bg-white dark:bg-zinc-800 shadow-lg rounded-xl overflow-hidden border border-zinc-200 dark:border-zinc-700 h-full flex flex-col">
                            <div class="px-2 sm:px-3 lg:px-4 py-1 sm:py-1.5 lg:py-2 bg-zinc-900 text-white text-xs sm:text-sm lg:text-base font-semibold flex items-center gap-1 sm:gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 sm:h-4 sm:w-4 lg:h-5 lg:w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                <span class="text-xs sm:text-sm lg:text-base">Jadwal Rapat Hari Ini</span>
                            </div>
                            <div class="p-0 flex-1 overflow-y-auto">
                                <table class="w-full text-xs sm:text-sm lg:text-base">
                                    <thead class="bg-red-700/90 text-white sticky top-0">
                                        <tr>
                                            <th class="px-1.5 sm:px-2 lg:px-3 py-1 sm:py-1.5 lg:py-2 text-center w-20 sm:w-28 lg:w-36 text-xs sm:text-sm lg:text-base">Waktu</th>
                                            <th class="px-1.5 sm:px-2 lg:px-3 py-1 sm:py-1.5 lg:py-2 text-left text-xs sm:text-sm lg:text-base">Agenda</th>
                                            <th class="px-1.5 sm:px-2 lg:px-3 py-1 sm:py-1.5 lg:py-2 text-left w-16 sm:w-24 lg:w-32 text-xs sm:text-sm lg:text-base">Ruangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($todayMeetings as $m)
                                            <tr class="odd:bg-white even:bg-red-50/60 dark:odd:bg-zinc-800 dark:even:bg-zinc-800/60 border-b border-zinc-200 dark:border-zinc-700">
                                                <td class="px-1.5 sm:px-2 lg:px-3 py-1 sm:py-2 lg:py-3 align-top text-zinc-700 dark:text-zinc-300 text-center whitespace-nowrap font-mono text-xs sm:text-sm lg:text-base">{{ substr($m->start_time,0,5) }}@if($m->end_time) – {{ substr($m->end_time,0,5) }}@endif</td>
                                                <td class="px-1.5 sm:px-2 lg:px-3 py-1 sm:py-2 lg:py-3 align-top text-zinc-900 dark:text-white text-xs sm:text-sm lg:text-base">{{ $m->agenda }}</td>
                                                <td class="px-1.5 sm:px-2 lg:px-3 py-1 sm:py-2 lg:py-3 align-top text-zinc-700 dark:text-zinc-300 text-xs sm:text-sm lg:text-base">{{ $m->ruang_rapat ?? '-' }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="px-1.5 sm:px-2 lg:px-3 py-3 sm:py-6 lg:py-8 text-center text-zinc-400 dark:text-zinc-500 text-xs sm:text-sm lg:text-base">Tidak ada rapat hari ini</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="fixed left-0 right-0 bottom-0 z-20">
                    <div class="bg-red-700 text-white text-xs sm:text-sm lg:text-base py-1 sm:py-1.5 lg:py-2">
                        <div class="overflow-hidden">
                            <div class="whitespace-nowrap animate-[marquee_25s_linear_infinite] px-2 sm:px-4 lg:px-6 text-xs sm:text-sm lg:text-base">BAPPERIDA Provinsi Bengkulu | Badan Perencanaan Pembangunan, Penelitian dan Pengembangan Daerah | Melayani dengan Sepenuh Hati untuk Kemajuan Bengkulu</div>
                        </div>
                    </div>
                </div>

                <!-- Image Lightbox Modal -->
                <div id="imageLightbox" class="fixed inset-0 z-50 bg-black/80 backdrop-blur-sm flex items-center justify-center opacity-0 invisible transition-all duration-300">
                    <div id="lightboxContent" class="relative w-full h-full max-w-4xl max-h-[90vh] flex flex-col items-center justify-center scale-95 transition-transform duration-300">
                        <button onclick="closeImageLightbox()" class="absolute top-4 right-4 z-10 p-2 bg-white/20 hover:bg-white/30 rounded-full transition-all cursor-pointer transform hover:scale-110">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                        </button>
                        <div class="relative w-full h-full flex items-center justify-center px-4">
                            <img id="lightboxImage" src="" alt="Full Size Image" class="max-w-full max-h-full object-contain rounded-lg shadow-2xl">
                        </div>
                        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 to-transparent p-6 text-white">
                            <p id="lightboxCaption" class="text-lg font-medium text-center break-words"></p>
                        </div>
                    </div>
                </div>

                <style>
                    @keyframes marquee { 0% { transform: translateX(100%);} 100% { transform: translateX(-100%);} }
                    
                    .dashboard-container {
                        min-height: calc(100vh - 200px);
                    }
                    
                    .slide-container .swiper-slide {
                        position: relative;
                    }
                    
                    .slide-container .swiper-slide img {
                        width: 100%;
                        height: 100%;
                        object-fit: cover;
                    }
                    
                    @media (max-width: 768px) {
                        .slide-container {
                            min-height: 300px;
                            max-height: 450px !important;
                        }
                        
                        .slide-container .swiper {
                            max-height: 400px !important;
                        }
                    }
                </style>

                @if($slides->count())
                    <link rel="stylesheet" href="https://unpkg.com/swiper@10/swiper-bundle.min.css" />
                    <script src="https://unpkg.com/swiper@10/swiper-bundle.min.js"></script>
                @endif

                <script>
                    let dashboardSwiper = null;
                    let clockInterval = null;
                    
                    function initDashboardSlides() {
                        // Destroy old swiper if exists
                        if (dashboardSwiper) {
                            dashboardSwiper.destroy();
                            dashboardSwiper = null;
                        }
                        
                        if (document.querySelector('.swiper')) {
                            dashboardSwiper = new Swiper('.swiper', {
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
                            
                            setTimeout(() => {
                                if (dashboardSwiper) dashboardSwiper.autoplay.start();
                            }, 500);
                        }
                    }
                    
                    function initClock() {
                        if (clockInterval) clearInterval(clockInterval);
                        
                        const el = document.getElementById('clockNow');
                        if (el) {
                            const upd = () => {
                                const d = new Date();
                                el.textContent = `${String(d.getHours()).padStart(2,'0')}.${String(d.getMinutes()).padStart(2,'0')}`;
                            };
                            clockInterval = setInterval(upd, 1000);
                            upd();
                        }
                    }
                    
                    // Lightbox helpers with zoom functionality
                    window.openImageLightbox = function(src, caption) {
                        const modal = document.getElementById('imageLightbox');
                        const img = document.getElementById('lightboxImage');
                        const cap = document.getElementById('lightboxCaption');
                        img.src = src; 
                        cap.textContent = caption || '';
                        modal.classList.remove('invisible');
                        setTimeout(()=>{ modal.style.opacity = '1'; }, 10);
                        
                        // Add zoom functionality
                        let scale = 1;
                        const maxScale = 3;
                        const minScale = 1;
                        
                        img.addEventListener('wheel', function(e) {
                            e.preventDefault();
                            const delta = e.deltaY > 0 ? -0.1 : 0.1;
                            scale = Math.max(minScale, Math.min(maxScale, scale + delta));
                            img.style.transform = `scale(${scale})`;
                        }, { passive: false });
                    }
                    
                    window.closeImageLightbox = function(){
                        const modal = document.getElementById('imageLightbox');
                        const img = document.getElementById('lightboxImage');
                        modal.style.opacity = '0';
                        img.style.transform = 'scale(1)';
                        setTimeout(()=>{ modal.classList.add('invisible'); }, 200);
                    }
                    
                    // Initialize on page load and on Livewire updates
                    document.addEventListener('DOMContentLoaded', function() {
                        initClock();
                        // Wait for Swiper library to be available
                        if (typeof Swiper !== 'undefined') {
                            initDashboardSlides();
                        } else {
                            setTimeout(initDashboardSlides, 100);
                        }
                    });
                    
                    // Support for Livewire navigation
                    document.addEventListener('livewire:navigated', function() {
                        initClock();
                        if (typeof Swiper !== 'undefined') {
                            initDashboardSlides();
                        } else {
                            setTimeout(initDashboardSlides, 100);
                        }
                    });
                    
                    // Also initialize when Swiper library loads
                    if (document.readyState === 'loading') {
                        document.addEventListener('DOMContentLoaded', function() {
                            setTimeout(initDashboardSlides, 200);
                        });
                    } else {
                        setTimeout(initDashboardSlides, 200);
                    }
                </script>
            </div>
        </div>
    </div>
</x-layouts.app>