@extends('layouts.app')

@section('title', 'Nástěnka | VOŠ OAUH')

@section('header-right')
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="group relative flex items-center justify-center px-4 py-2 rounded-xl overflow-hidden shadow-xl hover:shadow-2xl transition-all duration-300 cursor-pointer">
            <div class="absolute inset-0 topo-bg opacity-50 transition-opacity duration-300"></div>
            <div class="absolute inset-0 bg-white/60 backdrop-blur-[2px] group-hover:backdrop-blur-[4px] transition-all duration-300"></div>
            <div class="absolute inset-0 rounded-xl border border-white/60 border-b-4 border-b-gray-200/50"></div>

            <span class="relative z-10 text-gray-600 font-bold text-xs flex items-center drop-shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-4 w-4 text-gray-600 group-hover:text-school-primary transition-all duration-300 group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                Odhlásit se
            </span>
        </button>
    </form>
@endsection

@section('content')
    <div class="w-full max-w-5xl mx-auto">
        <div class="text-left mb-12">
            <h1 class="text-4xl font-bold text-gray-900">
                Vítejte, <span class="text-school-primary">{{ Auth::user()->name ?? 'Uchazeči' }}</span>
            </h1>
        </div>

        <div
            class="bg-white/80 backdrop-blur-xl rounded-3xl shadow-sm border border-white/60 overflow-hidden ring-1 ring-black/5 mb-12">
            <div class="px-10 py-6 border-b border-gray-100/80 bg-white/40 flex items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-school-primary" viewBox="0 0 20 20"
                    fill="currentColor">
                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                </svg>
                <h2 class="font-bold text-gray-800 text-xl">Nastavení přihlašovacích údajů</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2">
                <div class="p-10 border-b md:border-b-0 md:border-r border-gray-200/60 flex flex-col justify-between gap-6">
                    <div>
                        <h2 class="text-xs font-bold text-gray-400 uppercase tracking-wide mb-2">Kontaktní email</h2>
                        <div class="text-xl font-bold text-gray-900 break-all">
                            {{ Auth::user()->email }}
                        </div>
                        <p class="text-sm text-gray-500 mt-2">
                            Emailová adresa, pomocí které se přihlašujete.
                        </p>
                    </div>

                    <div class="pt-4">
                        <button
                            class="group relative flex items-center justify-center px-6 py-3 rounded-xl overflow-hidden shadow-md hover:shadow-lg transition-all duration-300 cursor-pointer w-auto self-start">
                            <div class="absolute inset-0 topo-bg opacity-50 transition-opacity duration-300"></div>
                            <div
                                class="absolute inset-0 bg-white/60 backdrop-blur-[2px] group-hover:backdrop-blur-[4px] transition-all duration-300">
                            </div>
                            <div class="absolute inset-0 rounded-xl border border-white/60 border-b-4 border-b-gray-200/50">
                            </div>
                            <span class="relative z-10 text-gray-700 font-bold text-sm flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="mr-2 h-4 w-4 text-gray-500 group-hover:text-school-primary transition-colors"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                                Změnit e-mail
                            </span>
                        </button>
                    </div>
                </div>

                <div class="p-10 flex flex-col justify-between gap-6">
                    <div>
                        <h2 class="text-xs font-bold text-gray-400 uppercase tracking-wide mb-2">Heslo k účtu</h2>
                        @if (Auth::user()->password)
                            <div class="flex items-center gap-2 text-green-600 font-bold text-xl">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                                Heslo je nastaveno
                            </div>
                        @else
                            <div class="flex items-center gap-2 text-orange-500 font-bold text-xl">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                        clip-rule="evenodd" />
                                </svg>
                                Heslo není nastaveno
                            </div>
                            <p class="text-sm text-gray-500 mt-2">
                                Bez nastaveného hesla se můžete přihlásit pouze pomocí odkazu v emailu.
                            </p>
                        @endif
                    </div>

                    <div class="pt-4">
                        <button
                            class="group relative flex items-center justify-center px-6 py-3 rounded-xl overflow-hidden shadow-md hover:shadow-lg transition-all duration-300 cursor-pointer w-auto self-start">
                            <div class="absolute inset-0 topo-bg opacity-50 transition-opacity duration-300"></div>
                            <div
                                class="absolute inset-0 bg-white/60 backdrop-blur-[2px] group-hover:backdrop-blur-[4px] transition-all duration-300">
                            </div>
                            <div class="absolute inset-0 rounded-xl border border-white/60 border-b-4 border-b-gray-200/50">
                            </div>
                            <span class="relative z-10 text-gray-700 font-bold text-sm flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="mr-2 h-4 w-4 text-gray-500 group-hover:text-school-primary transition-colors"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                                {{ Auth::user()->password ? 'Změnit heslo' : 'Vytvořit heslo' }}
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div
            class="bg-white/80 backdrop-blur-xl rounded-3xl shadow-sm border border-white/60 overflow-hidden ring-1 ring-black/5 mb-16">
            <div class="px-10 py-6 border-b border-gray-100/80 bg-white/40 flex items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-school-primary" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <h2 class="font-bold text-gray-800 text-xl">Podané přihlášky</h2>
            </div>

            <div class="p-16 flex flex-col items-center justify-center text-center">
                <div class="mb-8">
                    <p class="text-gray-500 text-lg mb-2">
                        Zatím jste nepodal(a) žádnou přihlášku ke studiu.
                    </p>
                </div>

                <a href="{{ route('programs.index') }}"
                    class="group relative flex items-center justify-center px-10 py-5 rounded-xl overflow-hidden shadow-xl hover:shadow-2xl transition-all duration-300 cursor-pointer">
                    <div class="absolute inset-0 topo-bg opacity-50 transition-opacity duration-300"></div>
                    <div
                        class="absolute inset-0 bg-white/60 backdrop-blur-[2px] group-hover:backdrop-blur-[4px] transition-all duration-300">
                    </div>
                    <div class="absolute inset-0 rounded-xl border border-white/60 border-b-4 border-b-gray-200/50"></div>

                    <span class="relative z-10 text-gray-900 font-bold text-xl flex items-center drop-shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="mr-3 h-6 w-6 text-gray-600 group-hover:text-school-primary transition-all duration-300 group-hover:rotate-90"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        </svg>
                        Podat novou přihlášku
                    </span>
                </a>
            </div>

            <div class="border-t border-gray-200/60 p-10 bg-gray-50/30 text-center">
                <p class="text-sm text-gray-500 font-medium mb-4">
                    Máte problém s účtem nebo přihláškou? Kontaktujte studijní oddělení, rádi vám pomůžeme.
                </p>

                <div class="flex flex-col sm:flex-row justify-center gap-2 sm:gap-6 text-base">
                    <a href="mailto:info@oauh.cz"
                        class="text-school-primary hover:text-school-hover font-semibold transition-colors flex items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                        </svg>
                        info@oauh.cz
                    </a>
                    <a href="tel:+420572433012"
                        class="text-school-primary hover:text-school-hover font-semibold transition-colors flex items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                            <path
                                d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                        </svg>
                        +420 572 433 012
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
