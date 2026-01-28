<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>E-přihláška | VOŠ OAUH</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .topo-bg {
            background-image: url("{{ asset('storage/topography_background.svg') }}");
            background-attachment: fixed;
            background-size: cover;
            background-position: center;
        }

        .material-symbols-rounded {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            line-height: 1;
            display: inline-flex;
            align-items: center;
            vertical-align: middle;
        }
    </style>
</head>

<body class="topo-bg bg-white text-school-dark antialiased flex flex-col min-h-screen relative">

    <div class="fixed inset-0 z-0 bg-white/5 backdrop-blur-[1px] pointer-events-none"></div>

    <header class="bg-[#f7f7f7]/90 backdrop-blur-md border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative h-16 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="{{ route('dashboard') }}"
                    class="flex items-center gap-2 text-gray-500 hover:text-school-primary transition-colors text-sm font-bold">
                    <span class="material-symbols-rounded">arrow_back</span>
                    Uložit a odejít
                </a>
                <div class="h-6 w-px bg-gray-300"></div>
                <span class="font-bold text-gray-900">Nová přihláška</span>
            </div>

            <div class="text-xs text-gray-400 font-mono">
                ID: {{ $application->id ?? 'DRAFT' }}
            </div>
        </div>
    </header>

    <main class="flex-grow w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 relative z-10">

        <div
            class="bg-white/80 backdrop-blur-xl rounded-2xl shadow-sm border border-white/60 p-4 mb-10 ring-1 ring-black/5">
            <div class="flex flex-wrap items-center justify-center gap-2 sm:gap-6 text-sm font-medium">

                <div
                    class="flex items-center gap-3 px-4 py-2 rounded-xl transition-colors {{ Request::routeIs('application.step1') ? 'bg-red-50 text-school-primary' : 'text-gray-400' }}">
                    <span
                        class="h-8 w-8 rounded-full flex items-center justify-center border-2 {{ Request::routeIs('application.step1') ? 'border-school-primary bg-white' : 'border-gray-200' }} text-sm font-bold">1</span>
                    <span>Osobní údaje</span>
                </div>

                <div class="hidden sm:block w-12 h-px bg-gray-200"></div>

                <div
                    class="flex items-center gap-3 px-4 py-2 rounded-xl transition-colors {{ Request::routeIs('application.step2') ? 'bg-red-50 text-school-primary' : 'text-gray-400' }}">
                    <span
                        class="h-8 w-8 rounded-full flex items-center justify-center border-2 {{ Request::routeIs('application.step2') ? 'border-school-primary bg-white' : 'border-gray-200' }} text-sm font-bold">2</span>
                    <span>Předchozí vzdělání</span>
                </div>

                <div class="hidden sm:block w-12 h-px bg-gray-200"></div>

                <div
                    class="flex items-center gap-3 px-4 py-2 rounded-xl transition-colors {{ Request::routeIs('application.step3') ? 'bg-red-50 text-school-primary' : 'text-gray-400' }}">
                    <span
                        class="h-8 w-8 rounded-full flex items-center justify-center border-2 {{ Request::routeIs('application.step3') ? 'border-school-primary bg-white' : 'border-gray-200' }} text-sm font-bold">3</span>
                    <span>Doplňující údaje</span>
                </div>

                <div class="hidden sm:block w-12 h-px bg-gray-200"></div>

                <div class="flex items-center gap-3 px-4 py-2 rounded-xl text-gray-400">
                    <span
                        class="h-8 w-8 rounded-full flex items-center justify-center border-2 border-gray-200 text-sm font-bold">4</span>
                    <span>Souhrn</span>
                </div>

            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">

            <div class="lg:col-span-2 space-y-6">
                @yield('form-content')
            </div>

            <div
                class="bg-white/80 backdrop-blur-xl rounded-2xl shadow-sm border border-white/60 p-6 sticky top-24 ring-1 ring-black/5">

                <div class="flex items-center gap-3 mb-6 border-b border-gray-100 pb-4">
                    <img src="https://www.oauh.cz/content/filters/l2.png" alt="Logo" class="h-8 w-auto">
                    <span class="text-sm font-bold text-gray-900 leading-tight">Obchodní akademie<br>Uherské
                        Hradiště</span>
                </div>

                <h3 class="text-lg font-bold text-school-primary mb-1">
                    Ekonomicko-právní činnost
                </h3>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wide mb-6">
                    Vybraný studijní program
                </p>

                <div class="space-y-4 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-500">Akademický rok</span>
                        <span class="font-semibold text-gray-900">2025/2026</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Jazyk výuky</span>
                        <span class="font-semibold text-gray-900">Čeština</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Forma studia</span>
                        <span class="font-semibold text-gray-900">Prezenční</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Školné</span>
                        <span class="font-semibold text-gray-900">2 500 Kč</span>
                    </div>
                </div>

                <div class="mt-8 pt-6 border-t border-gray-100">
                    <h4 class="font-bold text-gray-800 text-sm mb-2">Nevíte si s něčím rady?</h4>
                    <a href="mailto:info@oauh.cz"
                        class="text-school-primary text-sm hover:underline block">info@oauh.cz</a>
                    <a href="tel:+420572433012" class="text-school-primary text-sm hover:underline block">+420 572 433
                        012</a>
                </div>
            </div>

        </div>
    </main>
</body>

</html>
