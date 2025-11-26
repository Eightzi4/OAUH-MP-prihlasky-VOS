@extends('layouts.app')

@section('title', 'Zkontrolujte email | VOŠ OAUH')

@section('header-left')
    <a href="{{ route('login') }}" class="group relative flex items-center justify-center px-4 py-2 rounded-xl overflow-hidden shadow-xl hover:shadow-2xl transition-all duration-300">
        <div class="absolute inset-0 topo-bg opacity-50 transition-opacity duration-300"></div>
        <div class="absolute inset-0 bg-white/60 backdrop-blur-[2px] group-hover:backdrop-blur-[4px] transition-all duration-300"></div>
        <div class="absolute inset-0 rounded-xl border border-white/60 border-b-4 border-b-gray-200/50"></div>

        <span class="relative z-10 text-gray-600 font-bold text-sm flex items-center drop-shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-4 w-4 text-gray-600 group-hover:text-school-primary transition-transform duration-300 group-hover:-translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Zpět
        </span>
    </a>
@endsection

@section('content')
<div class="w-full max-w-lg text-center bg-white/80 backdrop-blur-xl p-10 rounded-3xl shadow-2xl border border-white/60 ring-1 ring-black/5">

    <h1 class="text-3xl font-bold text-gray-900 mb-6">
        Zkontrolujte svou schránku
    </h1>

    <div class="mb-10">
        <p class="text-gray-600 text-base mb-2">
            Přihlašovací odkaz jsme odeslali na adresu:
        </p>
        <div class="text-2xl font-bold text-school-primary break-all">
            {{ $email }}
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-10 text-left">
        <div class="flex items-start gap-3">
            <div class="mt-0.5 p-1.5 bg-gray-100 rounded-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <span class="block text-sm font-bold text-gray-900">Platnost odkazu</span>
                <span class="text-xs text-gray-500">Odkaz vyprší za 30 minut.</span>
            </div>
        </div>
        <div class="flex items-start gap-3">
            <div class="mt-0.5 p-1.5 bg-gray-100 rounded-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
            <div>
                <span class="block text-sm font-bold text-gray-900">Nenašli jste email?</span>
                <span class="text-xs text-gray-500">Zkontrolujte složku SPAM.</span>
            </div>
        </div>
    </div>

    <p class="text-xs text-gray-400">
        Udělali jste chybu v emailu? <a href="{{ route('login') }}" class="text-school-primary hover:text-school-hover font-bold hover:underline transition-colors">Zkuste to znovu</a>.
    </p>
</div>
@endsection
