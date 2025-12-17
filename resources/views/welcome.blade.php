<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Landing Page' }} - {{ config('app.name') }}</title>

    <link rel="icon" href="{{ asset('images/logo_bapperida.png') }}" type="image/png">
    <link rel="apple-touch-icon" href="{{ asset('images/logo_bapperida.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600&display=swap');
        
        .font-times-new-roman {
            font-family: "Times New Roman", Times, serif;
        }
        
        .text-shadow {
            text-shadow: 0 2px 8px rgba(0, 0, 0, 0.6);
        }

        .tight-text > *:not(:last-child) {
            margin-bottom: 0.1rem;
        }
    </style>
</head>
<body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] flex p-3 sm:p-4 md:p-6 lg:p-8 items-center justify-center min-h-screen">
    <div class="fixed inset-0 flex items-center justify-center font-times-new-roman text-white overflow-hidden z-40">
        <!-- Background -->
        <div class="absolute inset-0 bg-cover bg-center scale-105 blur-sm bg-[url('{{ asset('images/foto_bapperida.png') }}')]"></div>
        <div class="absolute inset-0 bg-black/25"></div>

        <!-- ✅ CENTERED CONTENT CONTAINER -->
        <div class="relative z-10 flex flex-col md:flex-row gap-2 md:gap-3 lg:gap-4 p-4 sm:p-6 md:p-8 max-w-5xl w-full mx-auto items-center justify-center">

            <!-- Text Block -->
            <div class="text-center md:text-left text-shadow space-y-2 max-w-[60%] md:max-w-[50%]">
                <div class="text-lg sm:text-xl md:text-2xl font-medium leading-tight tight-text">
                    Website Pengingat Gaji Berkala
                </div>
                <h1 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-bold leading-tight">
                    Bapperida Provinsi<br>Bengkulu
                </h1>

                @if (Route::has('login'))
                    <div class="mt-3">
                        <a href="{{ route('login') }}"
                           class="inline-block px-6 py-1 sm:px-7 sm:py-1 rounded-full border border-white/70 bg-gradient-to-b from-white to-[#d9d9d9] text-[#555] font-semibold tracking-wider uppercase no-underline shadow-md hover:translate-y-[-1px] hover:shadow-lg hover:bg-gradient-to-b hover:from-white hover:to-[#e4e4e4] transition-all duration-150 text-xs sm:text-sm md:text-base">
                            LOGIN
                        </a>
                    </div>
                @endif
            </div>

            <!-- Logo -->
            <div class="flex justify-center md:justify-start">    
                <img src="{{ asset('images/logo_bapperida.png') }}"
                     alt="Logo Bapperida Provinsi Bengkulu"
                     class="max-w-[140px] sm:max-w-[180px] md:max-w-[220px] lg:max-w-[260px] h-auto drop-shadow-lg">
            </div>
        </div>
    </div>
</body>
</html>