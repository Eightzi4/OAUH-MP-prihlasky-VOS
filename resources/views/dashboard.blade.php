@extends('layouts.app')

@section('title', 'Nástěnka | VOŠ OAUH')

@section('header-right')
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit"
            class="group relative flex items-center justify-center px-4 py-2 rounded-xl overflow-hidden shadow-xl hover:shadow-2xl transition-all duration-300 cursor-pointer">
            <div class="absolute inset-0 topo-bg opacity-50 transition-opacity duration-300"></div>
            <div
                class="absolute inset-0 bg-white/60 backdrop-blur-[2px] group-hover:backdrop-blur-[4px] transition-all duration-300">
            </div>
            <div class="absolute inset-0 rounded-xl border border-white/60 border-b-4 border-b-gray-200/50"></div>

            <span class="relative z-10 text-gray-600 font-bold text-xs flex items-center drop-shadow-sm">
                <span
                    class="material-symbols-rounded mr-2 text-[18px] text-gray-600 group-hover:text-school-primary transition-transform duration-300 group-hover:-translate-x-1">logout</span>
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
                <div class="h-8 w-8 rounded-lg bg-red-50 flex items-center justify-center">
                    <span class="material-symbols-rounded text-school-primary">person</span>
                </div>
                <h2 class="font-bold text-gray-800 text-xl">Osobní údaje a nastavení</h2>
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
                                <span
                                    class="material-symbols-rounded mr-2 text-[18px] text-gray-500 group-hover:text-school-primary transition-colors">edit</span>
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
                                <span class="material-symbols-rounded">check_circle</span>
                                Heslo je nastaveno
                            </div>
                        @else
                            <div class="flex items-center gap-2 text-orange-500 font-bold text-xl">
                                <span class="material-symbols-rounded">warning</span>
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
                                <span
                                    class="material-symbols-rounded mr-2 text-[18px] text-gray-500 group-hover:text-school-primary transition-colors">lock_reset</span>
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
                <div class="h-8 w-8 rounded-lg bg-red-50 flex items-center justify-center">
                    <span class="material-symbols-rounded text-school-primary">description</span>
                </div>
                <h2 class="font-bold text-gray-800 text-xl">Moje přihlášky</h2>
            </div>

            <div class="p-16 flex flex-col items-center justify-center text-center">
                <div class="mb-8">
                    <p class="text-gray-500 text-lg mb-2">
                        Zatím jste nepodal(a) žádnou přihlášku ke studiu.
                    </p>
                </div>

                <a href="{{ route('application.create') }}"
                    class="group relative flex items-center justify-center px-10 py-5 rounded-xl overflow-hidden shadow-xl hover:shadow-2xl transition-all duration-300 cursor-pointer">
                    <div class="absolute inset-0 topo-bg opacity-50 transition-opacity duration-300"></div>
                    <div
                        class="absolute inset-0 bg-white/60 backdrop-blur-[2px] group-hover:backdrop-blur-[4px] transition-all duration-300">
                    </div>
                    <div class="absolute inset-0 rounded-xl border border-white/60 border-b-4 border-b-gray-200/50"></div>

                    <span class="relative z-10 text-gray-900 font-bold text-xl flex items-center drop-shadow-sm">
                        <span
                            class="material-symbols-rounded mr-3 text-[24px] text-gray-600 group-hover:text-school-primary transition-all duration-300 group-hover:rotate-90">add</span>
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
                        <span class="material-symbols-rounded text-[18px]">mail</span>
                        info@oauh.cz
                    </a>
                    <a href="tel:+420572433012"
                        class="text-school-primary hover:text-school-hover font-semibold transition-colors flex items-center justify-center gap-2">
                        <span class="material-symbols-rounded text-[18px]">call</span>
                        +420 572 433 012
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
