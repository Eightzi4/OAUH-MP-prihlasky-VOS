@extends('layouts.application')

@section('form-content')
    <form action="{{ route('application.storeStep1', $application->id) }}" method="POST">
        @csrf

        <div class="bg-white/80 backdrop-blur-xl rounded-3xl shadow-sm border border-white/60 p-8 ring-1 ring-black/5 mb-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Základní údaje</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">
                        Křestní jméno *
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="material-symbols-rounded text-gray-400 text-[20px]">person</span>
                        </div>
                        <input type="text" name="first_name"
                            value="{{ old('first_name', $application->details->first_name ?? Auth::user()->name) }}"
                            class="w-full rounded-xl border-gray-300 shadow-sm focus:border-school-primary focus:ring-school-primary bg-white/50 placeholder-gray-400 py-3 pl-10 pr-4 transition-all">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">
                        Příjmení *
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="material-symbols-rounded text-gray-400 text-[20px]">badge</span>
                        </div>
                        <input type="text" name="last_name"
                            value="{{ old('last_name', $application->details->last_name) }}"
                            class="w-full rounded-xl border-gray-300 shadow-sm focus:border-school-primary focus:ring-school-primary bg-white/50 placeholder-gray-400 py-3 pl-10 pr-4 transition-all">
                    </div>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">
                        E-mail
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="material-symbols-rounded text-gray-400 text-[20px]">alternate_email</span>
                        </div>
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-gray-400">
                            <span class="material-symbols-rounded text-[20px]">help</span>
                        </div>
                        <input type="email" name="email"
                            value="{{ old('email', $application->details->email ?? Auth::user()->email) }}"
                            placeholder="jan.novak@example.com"
                            class="w-full rounded-xl border-gray-300 shadow-sm focus:border-school-primary focus:ring-school-primary bg-gray-50 placeholder-gray-400 py-3 pl-10 pr-10 transition-all cursor-not-allowed"
                            readonly>
                    </div>
                    <p class="text-xs text-gray-400 mt-1 ml-1">Emailová adresa použitá pro korespondenci s Vámi.</p>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">
                        Telefon
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="material-symbols-rounded text-gray-400 text-[20px]">call</span>
                        </div>
                        <input type="text" name="phone" value="{{ old('phone', $application->details->phone) }}"
                            placeholder="+420 777 123 456"
                            class="w-full rounded-xl border-gray-300 shadow-sm focus:border-school-primary focus:ring-school-primary bg-white/50 placeholder-gray-400 py-3 pl-10 pr-4 transition-all">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">
                        Státní občanství
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="material-symbols-rounded text-gray-400 text-[20px]">flag</span>
                        </div>
                        <select name="citizenship"
                            class="w-full appearance-none rounded-xl border-gray-300 shadow-sm focus:border-school-primary focus:ring-school-primary bg-white/50 py-3 pl-10 pr-10 transition-all">
                            <option value="Česká republika" selected>Česká republika</option>
                            <option value="Slovensko">Slovensko</option>
                            <option value="Jiné">Jiné</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                            <span class="material-symbols-rounded text-gray-500">expand_more</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="bg-white/80 backdrop-blur-xl rounded-3xl shadow-sm border border-white/60 p-8 ring-1 ring-black/5">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Adresa místa pobytu</h2>

            <div class="grid grid-cols-1 gap-6">

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">
                        Ulice a číslo popisné
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="material-symbols-rounded text-gray-400 text-[20px]">home</span>
                        </div>
                        <input type="text" name="street" value="{{ old('street', $application->details->street) }}"
                            placeholder="Masarykovo náměstí 123"
                            class="w-full rounded-xl border-gray-300 shadow-sm focus:border-school-primary focus:ring-school-primary bg-white/50 placeholder-gray-400 py-3 pl-10 pr-4 transition-all">
                    </div>
                </div>


                <div class="grid grid-cols-3 gap-6">
                    <div class="col-span-2">
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">
                            Obec / Město
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="material-symbols-rounded text-gray-400 text-[20px]">location_city</span>
                            </div>
                            <input type="text" name="city" value="{{ old('city', $application->details->city) }}"
                                placeholder="Uherské Hradiště"
                                class="w-full rounded-xl border-gray-300 shadow-sm focus:border-school-primary focus:ring-school-primary bg-white/50 placeholder-gray-400 py-3 pl-10 pr-4 transition-all">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">
                            PSČ
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="material-symbols-rounded text-gray-400 text-[20px]">markunread_mailbox</span>
                            </div>
                            <input type="text" name="zip" value="{{ old('zip', $application->details->zip) }}"
                                placeholder="686 01"
                                class="w-full rounded-xl border-gray-300 shadow-sm focus:border-school-primary focus:ring-school-primary bg-white/50 placeholder-gray-400 py-3 pl-10 pr-4 transition-all">
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="bg-white/80 backdrop-blur-xl rounded-3xl shadow-sm border border-white/60 p-4 mt-8 ring-1 ring-black/5">
            <div class="flex justify-between items-center">

                <a href="{{ route('dashboard') }}"
                    class="group relative flex items-center justify-center px-6 py-3 rounded-xl overflow-hidden transition-all duration-300 hover:bg-gray-100">
                    <span
                        class="relative z-10 text-gray-500 font-bold text-sm flex items-center group-hover:text-gray-800 transition-colors">
                        Zrušit
                    </span>
                </a>

                <button type="submit"
                    class="group relative flex items-center justify-center px-8 py-4 rounded-xl overflow-hidden shadow-xl hover:shadow-2xl transition-all duration-300 cursor-pointer">
                    <div class="absolute inset-0 topo-bg opacity-50 transition-opacity duration-300"></div>
                    <div
                        class="absolute inset-0 bg-white/60 backdrop-blur-[2px] group-hover:backdrop-blur-[4px] transition-all duration-300">
                    </div>
                    <div class="absolute inset-0 rounded-xl border border-white/60 border-b-4 border-b-gray-200/50"></div>

                    <span class="relative z-10 text-gray-900 font-bold text-lg flex items-center drop-shadow-sm">
                        Pokračovat
                        <span
                            class="material-symbols-rounded ml-3 text-[20px] text-gray-600 group-hover:text-school-primary transition-transform duration-300 group-hover:translate-x-1">arrow_forward</span>
                    </span>
                </button>
            </div>
        </div>

    </form>
@endsection
