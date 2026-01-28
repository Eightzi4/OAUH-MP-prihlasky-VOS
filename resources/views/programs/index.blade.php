@extends('layouts.app')

@section('title', 'Studijní programy | VOŠ OAUH')

@section('header-left')
    <a href="{{ url('/') }}"
        class="group relative flex items-center justify-center px-4 py-2 rounded-xl overflow-hidden shadow-xl hover:shadow-2xl transition-all duration-300">
        <div class="absolute inset-0 topo-bg opacity-50 transition-opacity duration-300"></div>
        <div
            class="absolute inset-0 bg-white/60 backdrop-blur-[2px] group-hover:backdrop-blur-[4px] transition-all duration-300">
        </div>
        <div class="absolute inset-0 rounded-xl border border-white/60 border-b-4 border-b-gray-200/50"></div>

        <span class="relative z-10 text-gray-600 font-bold text-sm flex items-center drop-shadow-sm">
    <span class="material-symbols-rounded mr-2 text-[18px] text-gray-600 group-hover:text-school-primary transition-transform duration-300 group-hover:-translate-x-1">arrow_back</span>
    Zpět
</span>
    </a>
@endsection

@section('content')
    <div class="w-full max-w-6xl mx-auto">

        <div class="text-center mb-16">
            <div
                class="inline-flex items-center px-3 py-1 rounded-full bg-white/80 backdrop-blur-md text-xs font-bold mb-6 border border-gray-200 shadow-sm">
                Akademický rok 2025/2026
            </div>
            <h1 class="text-4xl sm:text-5xl font-bold text-gray-900 mb-6 drop-shadow-sm">
                Nabídka studijních oborů
            </h1>
        </div>

        <div
            class="group relative bg-white/80 backdrop-blur-xl rounded-3xl shadow-2xl overflow-hidden border border-white/60 ring-1 ring-black/5 flex flex-col lg:flex-row min-h-[500px] transition-all duration-500 hover:shadow-red-900/5">
            <div class="relative w-full lg:w-2/5 overflow-hidden min-h-[300px] lg:min-h-full">
                <img src="https://www.oauh.cz/content/subjects/6.jpg" alt="Ekonomicko-právní činnost"
                    class="absolute inset-0 w-full h-full object-cover grayscale transition-all duration-700 group-hover:grayscale-0 group-hover:scale-105">

                <div
                    class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent lg:bg-gradient-to-r lg:from-transparent lg:to-black/10">
                </div>

                <div class="absolute top-6 left-6 flex flex-wrap gap-2">
                    <span
                        class="px-4 py-1.5 bg-white/95 backdrop-blur-md text-sm font-bold text-school-primary rounded-lg shadow-md border border-white/20">
                        Prezenční forma
                    </span>
                    <span
                        class="px-4 py-1.5 bg-gray-900/90 backdrop-blur-md text-sm font-bold text-white rounded-lg shadow-md border border-white/10">
                        3 roky
                    </span>
                </div>
            </div>

            <div class="w-full lg:w-3/5 p-8 sm:p-10 flex flex-col justify-between relative">
                <div class="absolute top-0 right-0 p-10 opacity-5 pointer-events-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-64 w-64 text-school-primary" fill="currentColor"
                        viewBox="0 0 24 24">
                        <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5" />
                    </svg>
                </div>

                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <span class="text-sm font-bold tracking-wider text-gray-400 uppercase">Kód oboru: 63-41-N/04</span>
                    </div>

                    <h2
                        class="text-3xl sm:text-4xl font-bold text-gray-900 mb-6 group-hover:text-school-primary transition-colors">
                        Ekonomicko-právní činnost
                    </h2>

                    <p class="text-gray-600 text-lg leading-relaxed mb-10 max-w-2xl">
                        Komplexní vzdělávací program zaměřený na propojení ekonomických znalostí s právním povědomím.
                        Absolventi získají kvalifikaci pro práci ve státní správě, v právních kancelářích nebo v managementu
                        firem.
                        Součástí studia je i odborná praxe.
                    </p>

                    <div
                        class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-6 mb-10 border-t border-b border-gray-200/60 py-8">
                        <div class="flex flex-col">
                            <span class="text-xs font-bold text-gray-400 uppercase tracking-wide mb-1">Udělovaný
                                titul</span>
                            <span class="text-lg font-bold text-gray-900 flex items-center gap-2">
                                <span class="material-symbols-rounded text-school-primary">school</span>
                                DiS. (Diplomovaný specialista)
                            </span>
                        </div>

                        <div class="flex flex-col">
                            <span class="text-xs font-bold text-gray-400 uppercase tracking-wide mb-1">Školné</span>
                            <span class="text-lg font-bold text-gray-900 flex items-center gap-2">
                                <span class="material-symbols-rounded text-school-primary">payments</span>
                                2 500 Kč / rok
                            </span>
                        </div>

                        <div class="flex flex-col">
                            <span class="text-xs font-bold text-gray-400 uppercase tracking-wide mb-1">Místo výuky</span>
                            <span class="text-lg font-bold text-gray-900 flex items-center gap-2">
                                <span class="material-symbols-rounded text-school-primary">location_on</span>
                                Uherské Hradiště
                            </span>
                        </div>

                        <div class="flex flex-col">
                            <span class="text-xs font-bold text-gray-400 uppercase tracking-wide mb-1">Jazyk výuky</span>
                            <span class="text-lg font-bold text-gray-900 flex items-center gap-2">
                                <span class="material-symbols-rounded text-school-primary">translate</span>
                                Čeština
                            </span>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row items-center gap-4 mt-auto">
                    <a href="{{ route('login') }}"
                        class="group/btn relative w-full sm:w-auto flex-grow flex items-center justify-center px-8 py-4 rounded-xl overflow-hidden shadow-xl hover:shadow-2xl transition-all duration-300 cursor-pointer">
                        <div class="absolute inset-0 topo-bg opacity-50 transition-opacity duration-300"></div>
                        <div
                            class="absolute inset-0 bg-white/60 backdrop-blur-[2px] group-hover/btn:backdrop-blur-[4px] transition-all duration-300">
                        </div>
                        <div class="absolute inset-0 rounded-xl border border-white/60 border-b-4 border-b-gray-200/50">
                        </div>

                        <span class="relative z-10 text-gray-900 font-bold text-lg flex items-center drop-shadow-sm">
                            Podat přihlášku na tento obor
                            <span
                                class="material-symbols-rounded ml-3 text-[20px] text-gray-600 group-hover/btn:text-school-primary transition-transform duration-300 group-hover/btn:translate-x-1">arrow_forward</span>
                        </span>
                    </a>

                    <a href="https://www.oauh.cz/vyssi-odborna-skola.htm" target="_blank"
                        class="w-full sm:w-auto flex items-center justify-center px-6 py-4 rounded-xl text-gray-500 font-semibold hover:text-school-primary hover:bg-white/50 transition-all">
                        Více informací
                        <span class="material-symbols-rounded ml-2 text-[20px]">open_in_new</span>
                    </a>
                </div>

            </div>
        </div>
    </div>
@endsection
