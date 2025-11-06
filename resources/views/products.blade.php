<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-neutral-100 antialiased dark:bg-neutral-900">
        <div class="min-h-screen py-8 px-4 sm:px-6 lg:px-8">
            <div class="max-w-7xl mx-auto">
                <!-- Simple Header -->
                <header class="mb-8">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h1 class="text-3xl font-bold text-neutral-900 dark:text-white mb-2">
                                Product Search Demo
                            </h1>
                            <p class="text-neutral-600 dark:text-neutral-400">
                                Demonstrating Livewire lifecycle hooks, component communication, and best practices.
                            </p>
                        </div>
                        @auth
                            <a href="{{ route('dashboard') }}" class="text-sm text-neutral-600 hover:text-neutral-900 dark:text-neutral-400 dark:hover:text-white">
                                Dashboard →
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="text-sm text-neutral-600 hover:text-neutral-900 dark:text-neutral-400 dark:hover:text-white">
                                Login →
                            </a>
                        @endauth
                    </div>
                </header>

                <!-- Livewire Components -->
                <div class="space-y-6">
                    <livewire:product-search />
                    <livewire:product-list />
                </div>
            </div>
        </div>
        @fluxScripts
    </body>
</html>
