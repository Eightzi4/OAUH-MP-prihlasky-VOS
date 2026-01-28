@extends('layouts.app')

@section('title', 'Přihlášení | E-přihláška OAUH')

@section('header-left')
    <a href="{{ url('/') }}"
        class="group relative flex items-center justify-center px-4 py-2 rounded-xl overflow-hidden shadow-xl hover:shadow-2xl transition-all duration-300">
        <div class="absolute inset-0 topo-bg opacity-50 transition-opacity duration-300"></div>
        <div
            class="absolute inset-0 bg-white/60 backdrop-blur-[2px] group-hover:backdrop-blur-[4px] transition-all duration-300">
        </div>
        <div class="absolute inset-0 rounded-xl border border-white/60 border-b-4 border-b-gray-200/50"></div>

        <span class="relative z-10 text-gray-600 font-bold text-sm flex items-center drop-shadow-sm">
            <span
                class="material-symbols-rounded mr-2 text-[18px] text-gray-600 group-hover:text-school-primary transition-transform duration-300 group-hover:-translate-x-1">arrow_back</span>
            Zpět
        </span>
    </a>
@endsection

@section('content')
    <div
        class="w-full max-w-md text-center bg-white/80 backdrop-blur-xl p-10 rounded-3xl shadow-2xl border border-white/60 ring-1 ring-black/5">

        <div class="mb-8 text-center">
            <h1 class="text-2xl font-bold text-gray-900 mb-2">
                Vstup do systému
            </h1>
            <p class="text-gray-500 text-sm">
                Zadejte svůj e-mail pro přihlášení nebo registraci.
            </p>
        </div>

        <form action="{{ route('auth.email') }}" method="POST" class="space-y-6 text-left">
            @csrf

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">E-mailová adresa</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <span class="material-symbols-rounded text-gray-400 text-[20px]">alternate_email</span>
                    </div>
                    <input type="email" name="email" id="email" required
                        class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl leading-5 bg-white/50 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-school-primary focus:border-school-primary sm:text-sm transition-all shadow-sm"
                        placeholder="jan.novak@example.com">
                </div>
            </div>

            <button type="submit"
                class="group relative w-full flex items-center justify-center px-8 py-4 rounded-xl overflow-hidden shadow-xl hover:shadow-2xl transition-all duration-300 cursor-pointer">
                <div class="absolute inset-0 topo-bg opacity-50 transition-opacity duration-300"></div>
                <div
                    class="absolute inset-0 bg-white/60 backdrop-blur-[2px] group-hover:backdrop-blur-[4px] transition-all duration-300">
                </div>
                <div class="absolute inset-0 rounded-xl border border-white/60 border-b-4 border-b-gray-200/50"></div>

                <span class="relative z-10 text-gray-900 font-bold text-base flex items-center drop-shadow-sm">
                    Pokračovat
                    <span
                        class="material-symbols-rounded ml-3 text-[20px] text-gray-600 group-hover:text-school-primary transition-transform duration-300 group-hover:translate-x-1">arrow_forward</span>
                </span>
            </button>
        </form>

        <div class="mt-8 pt-6 border-t border-gray-200/60 text-xs text-gray-400">
            Pokud u nás ještě nemáte účet, vytvoříme vám ho automaticky.
        </div>
    </div>
@endsection
