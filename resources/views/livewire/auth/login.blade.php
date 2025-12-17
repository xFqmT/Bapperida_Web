s<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $title ?? 'Login' }} - {{ config('app.name', 'Laravel') }}</title>

        <link rel="icon" href="{{ asset('images/logo_bapperida.png') }}" type="image/png">
        <link rel="apple-touch-icon" href="{{ asset('images/logo_bapperida.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
        <script src="https://cdn.tailwindcss.com"></script>
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600&display=swap');
            
            .font-times-new-roman {
                font-family: "Times New Roman", Times, serif;
            }
            
            .text-shadow {
                text-shadow: 0 4px 16px rgba(0, 0, 0, 0.7);
            }
        </style>
        @stack('styles')
    </head>
    <body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] flex items-center justify-center min-h-screen">
        <div class="fixed inset-0 flex items-center justify-center font-times-new-roman text-white overflow-hidden z-40">
            <!-- Background with blur effect -->
            <div class="absolute inset-0 bg-cover bg-center scale-105 blur-sm bg-[url('{{ asset('images/foto_bapperida.png') }}')]">
            </div>
            
            <!-- Overlay -->
            <div class="absolute inset-0 bg-black/25"></div>
            
            <!-- Content -->
            <div class="relative z-10 w-full max-w-md p-8 bg-white/30 dark:bg-neutral-900/30 backdrop-blur-md rounded-xl shadow-2xl mx-4 border border-white/20">
                <!-- Logo and Title -->
                <div class="flex justify-center items-center mb-8">
                    <a href="{{ route('home') }}" class="flex items-center space-x-6">
                        <div class="flex-shrink-0">
                            <img src="{{ asset('images/logo_bapperida.png') }}" alt="Logo Bapperida" class="h-24 w-24 object-contain">
                        </div>
                        <div class="text-left">
                            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">BAPPERIDA</h1>
                            <p class="text-sm text-gray-600 dark:text-gray-300">Badan Perencanaan Pembangunan,<br>Riset dan Inovasi Daerah</p>
                        </div>
                    </a>
                </div>

                <div class="space-y-6">
                    <div class="text-center">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('Log in to your account') }}</h2>
                        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                            {{ __('Enter your email and password below to log in') }}
                        </p>
                    </div>

                    <!-- Session Status -->
                    <x-auth-session-status class="text-center" :status="session('status')" />

                    <form method="POST" action="/custom-login" class="space-y-6">
                        @csrf

                        <!-- Username Field -->
                        <div>
                            <flux:input
                                name="username"
                                :label="('Username')"
                                type="username"
                                required
                                autofocus
                                autocomplete="username"
                                placeholder="username"
                                class="w-full"
                            />
                        </div>

                        <!-- Password -->
                        <div class="space-y-2">
                            <div class="relative">
                                <flux:input
                                    name="password"
                                    :label="('Password')"
                                    type="password"
                                    required
                                    autocomplete="current-password"
                                    :placeholder="('Password')"
                                    viewable
                                    class="w-full"
                                />
                            </div>

                        <div>
                            <flux:button variant="primary" type="submit" class="w-full" data-test="login-button">
                                {{ __('Log in') }}
                            </flux:button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
        @fluxScripts
        @stack('scripts')
    </body>
</html>