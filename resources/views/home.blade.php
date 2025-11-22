@extends('layouts.app')

@section('title', 'E-přihláška | OAUH')

@section('content')
<div class="w-full max-w-2xl text-center bg-white/80 backdrop-blur-xl p-10 rounded-3xl shadow-2xl border border-white/60 ring-1 ring-black/5">

    <div class="inline-flex items-center px-3 py-1 rounded-full bg-[#f7f7f7] text-xs font-bold mb-8 border border-gray-200 shadow-sm">
        Příjímací řízení 2025/2026
    </div>

    <h1 class="text-4xl sm:text-5xl font-bold tracking-tight text-gray-900 mb-6 drop-shadow-sm">
        Elektronická přihláška<br>ke studiu na VOŠ
    </h1>

    <p class="text-lg text-gray-600 mb-12 max-w-lg mx-auto leading-relaxed font-medium">
        Vítejte v informačním systému pro uchazeče. Zde si můžete vybrat studijní program, vyplnit přihlášku a sledovat její stav.
    </p>

    <div class="flex flex-col sm:flex-row items-center justify-center gap-6 w-full">

        <a href="{{ route('programs.index') }}" class="group relative flex items-center justify-center px-8 py-4 rounded-xl overflow-hidden shadow-xl hover:shadow-2xl transition-all duration-300">
            <div class="absolute inset-0 topo-bg opacity-50 transition-opacity duration-300"></div>
            <div class="absolute inset-0 bg-white/60 backdrop-blur-[2px] group-hover:backdrop-blur-[4px] transition-all duration-300"></div>
            <div class="absolute inset-0 rounded-xl border border-white/60 border-b-4 border-b-gray-200/50"></div>

            <span class="relative z-10 text-gray-900 font-bold text-lg flex items-center drop-shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="mr-3 h-5 w-5 text-gray-600 group-hover:text-school-primary transition-all duration-300 group-hover:rotate-90" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                Podat novou přihlášku
            </span>
        </a>

        <a href="{{ route('login') }}" class="group relative flex items-center justify-center px-8 py-4 rounded-xl overflow-hidden shadow-xl hover:shadow-2xl transition-all duration-300">
            <div class="absolute inset-0 topo-bg opacity-50 transition-opacity duration-300"></div>
            <div class="absolute inset-0 bg-white/60 backdrop-blur-[2px] group-hover:backdrop-blur-[4px] transition-all duration-300"></div>
            <div class="absolute inset-0 rounded-xl border border-white/60 border-b-4 border-b-gray-200/50"></div>

            <span class="relative z-10 text-gray-900 font-bold text-lg flex items-center drop-shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="mr-3 h-5 w-5 text-gray-600 group-hover:text-school-primary transition-colors duration-300" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M4 4h4v4H4V4zm6 0h4v4h-4V4zm6 0h4v4h-4V4zM4 10h4v4H4v-4zm6 0h4v4h-4v-4zm6 0h4v4h-4v-4zM4 16h4v4H4v-4zm6 0h4v4h-4v-4zm6 0h4v4h-4v-4z" />
                </svg>
                Moje přihlášky
            </span>
        </a>
    </div>

    <div class="mt-14 pt-8 border-t border-gray-200/60">
        <p class="text-sm text-gray-500 font-medium">
            Potřebujete poradit? Kontaktujte studijní oddělení VOŠ:
        </p>
        <div class="mt-2 flex flex-col sm:flex-row justify-center gap-2 sm:gap-6 text-base">
            <a href="mailto:info@oauh.cz" class="text-school-primary hover:text-school-hover font-semibold transition-colors flex items-center justify-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" /><path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" /></svg>
                info@oauh.cz
            </a>
            <a href="tel:+420572433012" class="text-school-primary hover:text-school-hover font-semibold transition-colors flex items-center justify-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" /></svg>
                +420 572 433 012
            </a>
        </div>
    </div>
</div>
@endsection
