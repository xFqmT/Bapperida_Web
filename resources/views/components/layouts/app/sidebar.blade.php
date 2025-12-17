<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <!-- Floating Toggle Button (shown when sidebar is hidden) -->
        <button id="floatingToggle" class="fixed top-4 left-4 z-50 p-2 bg-white dark:bg-zinc-800 rounded-lg shadow-lg border border-zinc-200 dark:border-zinc-700 hover:bg-zinc-50 dark:hover:bg-zinc-700 transition-all duration-200 hidden cursor-pointer transform hover:scale-110">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-zinc-600 dark:text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </button>
        
        <flux:sidebar sticky stashable class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900 transition-all duration-300 ease-in-out" id="mainSidebar">
            <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

            <div class="flex items-center justify-between px-4 py-2">
                <a href="{{ route('meetings.index') }}" class="flex items-center space-x-2 rtl:space-x-reverse" wire:navigate>
                    <x-app-logo />
                </a>
                <button id="sidebarToggle" class="p-1.5 bg-white dark:bg-zinc-800 rounded-md shadow border border-zinc-200 dark:border-zinc-700 hover:bg-zinc-50 dark:hover:bg-zinc-700 transition-all duration-200 cursor-pointer transform hover:scale-110" style="display: block;">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-zinc-600 dark:text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
            </div>

            <flux:navlist variant="outline">
                <flux:navlist.group :heading="__('Platform')" class="grid">
                    @if(auth()->user()->isAdmin())
                    <flux:navlist.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>{{ __('Dashboard') }}</flux:navlist.item>
                    <flux:navlist.item icon="briefcase" :href="route('periods.index')" :current="request()->routeIs('periods.*')" wire:navigate>{{ __('Gaji Berkala') }}</flux:navlist.item>
                    <flux:navlist.item icon="envelope" :href="route('surats.index')" :current="request()->routeIs('surats.*')" wire:navigate>{{ __('Manajemen Surat') }}</flux:navlist.item>
                    @endif
                    <flux:navlist.item icon="calendar" :href="route('meetings.index')" :current="request()->routeIs('meetings.*')" wire:navigate>{{ __('Jadwal Rapat') }}</flux:navlist.item>
                </flux:navlist.group>
            </flux:navlist>

            <flux:spacer />

            <!-- Desktop User Menu -->
            <flux:dropdown class="hidden lg:block" position="bottom" align="start">
                <flux:profile
                    :name="auth()->user()->name"
                    :initials="auth()->user()->initials()"
                    icon:trailing="chevrons-up-down"
                />

                <flux:menu class="w-[220px]">
                    <flux:menu.radio.group>
                        <div class="flex items-center gap-3 p-2">
                            <flux:avatar
                                :initials="auth()->user()->initials()"
                                >
                                {{ auth()->user()->initials() }}
                            </flux:avatar>

                            <div class="grid flex-1 text-start text-sm leading-tight">
                                <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    @if(auth()->user()->isAdmin())
                        <flux:menu.radio.group>
                            <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
                        </flux:menu.radio.group>

                        <flux:menu.separator />
                    @endif

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:sidebar>
        @if(!auth()->user()->isStaff())
        @endif

        <!-- Mobile User Menu -->
        <flux:header class="lg:hidden">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            <flux:spacer />

            <flux:dropdown position="top" align="end">
                <flux:profile
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevron-down"
                />

                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                    >
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    @if(auth()->user()->isAdmin())
                        <flux:menu.radio.group>
                            <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
                        </flux:menu.radio.group>

                        <flux:menu.separator />
                    @endif

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:header>

        {{ $slot }}

        @fluxScripts
        
        <style>
            /* Desktop layout: use a two-column grid for sidebar + main */
            @media (min-width: 1024px) {
                body {
                    display: grid;
                    grid-template-columns: 16rem minmax(0, 1fr);
                    min-height: 100vh;
                }

                flux\:sidebar {
                    grid-column: 1;
                }

                flux\:header {
                    grid-column: 1 / -1;
                }

                flux\:main {
                    grid-column: 2;
                    /* Avoid animating width so the main content doesn't stretch when sidebar toggles */
                }

                /* When sidebar is hidden, collapse its column so main stretches full width */
                body.sidebar-hidden {
                    grid-template-columns: 0 minmax(0, 1fr);
                }
            }

            /* Smooth transitions for the foreground dashboard content (opacity only to avoid layout shifts) */
            .relative.z-10 {
                transition: opacity 0.25s ease-in-out;
            }

            /* Padding when the sidebar is hidden (full-width content, no extra narrowing) */
            body.sidebar-hidden .relative.z-10 {
                padding-left: 0;
                padding-right: 0;
            }

            @media (max-width: 1023px) {
                body.sidebar-hidden .relative.z-10 {
                    padding-left: 0;
                    padding-right: 0;
                }
            }

            /* Generic page fade-in / fade-out helper */
            .page-fade {
                opacity: 0;
                animation: pageFadeIn 0.25s ease-out forwards;
            }

            @keyframes pageFadeIn {
                to {
                    opacity: 1;
                }
            }

            body.page-fade-out .page-fade {
                opacity: 0;
                transition: opacity 0.2s ease-in;
            }
        </style>
        
        <script>
            (function() {
                // Wait for DOM to be ready
                function initSidebar() {
                    const sidebarToggle = document.getElementById('sidebarToggle');
                    const floatingToggle = document.getElementById('floatingToggle');
                    const mainSidebar = document.getElementById('mainSidebar');
                    const mainContent = document.querySelector('flux\\:main');
                    
                    // Check if all required elements exist
                    if (!sidebarToggle || !mainSidebar) {
                        console.warn('Sidebar elements not found, retrying in 100ms...');
                        setTimeout(initSidebar, 100);
                        return;
                    }
                    
                    // floatingToggle should always exist now
                    
                    // Get sidebar state from localStorage, default to true (visible)
                    let isSidebarVisible = localStorage.getItem('sidebarVisible') !== 'false';
                    
                    // Debug logging
                    console.log('Sidebar initialized:', {
                        sidebarToggle: !!sidebarToggle,
                        floatingToggle: !!floatingToggle,
                        mainSidebar: !!mainSidebar,
                        mainContent: !!mainContent,
                        initialState: isSidebarVisible
                    });
                    
                    // Apply initial state
                    function applySidebarState(visible) {
                        const body = document.body;
                        
                        if (visible) {
                            // Show sidebar
                            mainSidebar.classList.remove('-translate-x-full');
                            mainSidebar.classList.add('translate-x-0');
                            floatingToggle.classList.add('hidden');
                            body.classList.remove('sidebar-hidden');
                        } else {
                            // Hide sidebar
                            mainSidebar.classList.add('-translate-x-full');
                            mainSidebar.classList.remove('translate-x-0');
                            floatingToggle.classList.remove('hidden');
                            body.classList.add('sidebar-hidden');
                        }
                    }
                    
                    function toggleSidebar(e) {
                        if (e) e.preventDefault();
                        console.log('Toggle called, current state:', isSidebarVisible);
                        
                        isSidebarVisible = !isSidebarVisible;
                        applySidebarState(isSidebarVisible);
                        
                        // Save state to localStorage
                        localStorage.setItem('sidebarVisible', isSidebarVisible.toString());
                        
                        console.log('Toggle completed, new state:', isSidebarVisible);
                    }
                    
                    // Apply initial state on page load
                    applySidebarState(isSidebarVisible);
                    
                    // Add event listeners
                    sidebarToggle.addEventListener('click', toggleSidebar);
                    floatingToggle.addEventListener('click', toggleSidebar);
                    
                    console.log('Sidebar event listeners attached successfully');
                }

                // Initialize when DOM is ready
                if (document.readyState === 'loading') {
                    document.addEventListener('DOMContentLoaded', initSidebar);
                } else {
                    initSidebar();
                }
            })();

            // Simple global fade-out hook when leaving the page
            window.addEventListener('beforeunload', function () {
                document.body.classList.add('page-fade-out');
            });
        </script>
    </body>
</html>
