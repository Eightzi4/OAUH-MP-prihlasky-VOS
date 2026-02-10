@extends('layouts.application')

@section('form-content')
    <form action="{{ route('application.storeStep1', $application->id) }}" method="POST">
        @csrf

        <div class="relative bg-white/80 backdrop-blur-xl rounded-3xl shadow-lg border-2 border-school-primary/20 p-8 mb-10 overflow-hidden group hover:border-school-primary/40 transition-all duration-500">
            <div class="absolute -right-4 -bottom-12 opacity-[0.04] rotate-[15deg] pointer-events-none transition-transform duration-700 ease-out group-hover:rotate-[5deg] group-hover:scale-105">
                <span class="material-symbols-rounded text-[250px] text-school-primary leading-none">verified_user</span>
            </div>
            <div class="relative z-10 flex flex-col xl:flex-row items-center justify-between gap-8">
                <div class="max-w-xl text-center xl:text-left">
                    <h3 class="text-3xl font-bold text-gray-900 mb-3 tracking-tight flex items-center justify-center xl:justify-start gap-3">
                        <span class="material-symbols-rounded text-school-primary text-[32px]">fingerprint</span>
                        Identita občana
                    </h3>
                    <p class="text-gray-600 font-medium leading-relaxed text-lg">
                        Urychlete vyplňování načtením ověřených údajů přímo ze státních registrů (BankID, eObčanka).
                    </p>
                </div>
                <div class="flex flex-col gap-4 w-full xl:w-auto">
                    <a href="{{ route('nia.real.login', $application->id) }}" class="group/btn relative flex items-center justify-center px-8 py-4 rounded-xl overflow-hidden shadow-xl hover:shadow-2xl transition-all duration-300 cursor-pointer w-full sm:w-[280px]">
                        <div class="absolute inset-0 topo-bg opacity-50 transition-opacity duration-300"></div>
                        <div class="absolute inset-0 bg-white/60 backdrop-blur-[2px] group-hover/btn:backdrop-blur-[4px] transition-all duration-300"></div>
                        <div class="absolute inset-0 rounded-xl border border-white/60 border-b-4 border-b-gray-200/50"></div>
                        <span class="relative z-10 text-gray-900 font-bold text-lg flex items-center drop-shadow-sm whitespace-nowrap">
                            Načíst přes NIA
                            <span class="material-symbols-rounded ml-3 text-[24px] text-gray-600 group-hover/btn:text-school-primary transition-transform duration-300 group-hover/btn:translate-x-1">login</span>
                        </span>
                    </a>
                    <a href="{{ route('nia.mock.login', $application->id) }}" class="group/btn relative flex items-center justify-center px-8 py-4 rounded-xl overflow-hidden shadow-xl hover:shadow-2xl transition-all duration-300 cursor-pointer w-full sm:w-[280px]">
                        <div class="absolute inset-0 topo-bg opacity-30 transition-opacity duration-300"></div>
                        <div class="absolute inset-0 bg-white/40 backdrop-blur-[2px] group-hover/btn:backdrop-blur-[4px] transition-all duration-300"></div>
                        <div class="absolute inset-0 rounded-xl border border-white/60 border-b-4 border-b-gray-200/50"></div>
                        <span class="relative z-10 text-gray-700 font-bold text-lg flex items-center drop-shadow-sm whitespace-nowrap">
                            Vyzkoušet Demo
                            <span class="material-symbols-rounded ml-3 text-[24px] text-emerald-600 group-hover/btn:scale-110 transition-transform duration-300">science</span>
                        </span>
                    </a>
                </div>
            </div>
        </div>

        <div class="bg-white/80 backdrop-blur-xl rounded-3xl shadow-sm border border-white/60 p-8 ring-1 ring-black/5 mb-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Identifikační údaje</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @include('components.input-verified', [
                    'name' => 'first_name',
                    'label' => 'Křestní jméno',
                    'icon' => 'person',
                    'placeholder' => 'Jan',
                    'value' => old('first_name', $application->details->first_name),
                    'niaValue' => $application->details->nia_data['first_name'] ?? null,
                ])

                @include('components.input-verified', [
                    'name' => 'last_name',
                    'label' => 'Příjmení',
                    'icon' => 'badge',
                    'placeholder' => 'Novák',
                    'value' => old('last_name', $application->details->last_name),
                    'niaValue' => $application->details->nia_data['last_name'] ?? null,
                ])

                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">Pohlaví</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="material-symbols-rounded text-gray-400 text-[20px]">wc</span>
                        </div>
                        @php
                            $genderVerified = isset($application->details->nia_data['gender']) &&
                                              old('gender', $application->details->gender) == $application->details->nia_data['gender'];
                        @endphp
                        <select name="gender"
                            class="w-full appearance-none rounded-xl border border-gray-200 shadow-sm focus:border-school-primary focus:ring-school-primary py-3 pl-10 pr-10 transition-all
                            @if($genderVerified) bg-gray-50 text-gray-500 pointer-events-none @else bg-white/50 text-gray-900 @endif
                            @error('gender') border-red-500 @enderror">
                            <option value="" disabled selected>Vyberte pohlaví</option>
                            <option value="Muž" {{ old('gender', $application->details->gender) == 'Muž' ? 'selected' : '' }}>Muž</option>
                            <option value="Žena" {{ old('gender', $application->details->gender) == 'Žena' ? 'selected' : '' }}>Žena</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                            <span class="material-symbols-rounded text-gray-500">expand_more</span>
                        </div>
                        @if($genderVerified)
                            <p class="text-blue-600 text-xs mt-1.5 ml-1 font-bold flex items-center gap-1 absolute -bottom-6 left-0">
                                <span class="material-symbols-rounded text-[14px]">verified</span> Ověřeno pomocí NIA ID
                            </p>
                        @endif
                    </div>
                    @error('gender')
                        <div class="flex items-center gap-1 mt-1.5 ml-1 text-red-500"><span class="material-symbols-rounded text-[16px]">error</span><p class="text-xs">{{ $message }}</p></div>
                    @enderror
                    <div class="h-4"></div>
                </div>
            </div>
        </div>

        <div class="bg-white/80 backdrop-blur-xl rounded-3xl shadow-sm border border-white/60 p-8 ring-1 ring-black/5 mb-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Narození a občanství</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">Datum narození</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="material-symbols-rounded text-gray-400 text-[20px]">calendar_today</span>
                        </div>
                        @php
                            $dobValue = old('birth_date', $application->details->birth_date ? $application->details->birth_date->format('Y-m-d') : '');
                            $dobVerified = isset($application->details->nia_data['birth_date']) && $dobValue == $application->details->nia_data['birth_date'];
                        @endphp
                        <input type="date" name="birth_date" value="{{ $dobValue }}"
                            @if($dobVerified) readonly @endif
                            class="w-full rounded-xl border border-gray-200 shadow-sm focus:border-school-primary focus:ring-school-primary py-3 pl-10 pr-4 transition-all
                            @if($dobVerified) bg-gray-50 text-gray-500 cursor-not-allowed @else bg-white/50 text-gray-900 @endif
                            @error('birth_date') border-red-500 @enderror">

                        @if($dobVerified)
                            <p class="text-blue-600 text-xs mt-1.5 ml-1 font-bold flex items-center gap-1 absolute -bottom-6 left-0">
                                <span class="material-symbols-rounded text-[14px]">verified</span> Ověřeno pomocí NIA ID
                            </p>
                        @endif
                    </div>
                    @error('birth_date')
                        <div class="flex items-center gap-1 mt-1.5 ml-1 text-red-500"><span class="material-symbols-rounded text-[16px]">error</span><p class="text-xs">{{ $message }}</p></div>
                    @enderror
                    <div class="h-4"></div>
                </div>

                @include('components.input-verified', [
                    'name' => 'birth_number',
                    'label' => 'Rodné číslo',
                    'icon' => 'fingerprint',
                    'placeholder' => '000101/1234',
                    'value' => old('birth_number', $application->details->birth_number),
                    'niaValue' => $application->details->nia_data['birth_number'] ?? null,
                ])

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">Státní občanství</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="material-symbols-rounded text-gray-400 text-[20px]">flag</span>
                        </div>
                        @php
                            $citizenVerified = isset($application->details->nia_data['citizenship']) &&
                                              old('citizenship', $application->details->citizenship) == $application->details->nia_data['citizenship'];
                        @endphp
                        <select name="citizenship"
                            class="w-full appearance-none rounded-xl border border-gray-200 shadow-sm focus:border-school-primary focus:ring-school-primary py-3 pl-10 pr-10 transition-all
                            @if($citizenVerified) bg-gray-50 text-gray-500 pointer-events-none @else bg-white/50 text-gray-900 @endif
                            @error('citizenship') border-red-500 @enderror">
                            <option value="Česká republika" {{ old('citizenship', $application->details->citizenship) == 'Česká republika' ? 'selected' : '' }}>Česká republika</option>
                            <option value="Slovensko" {{ old('citizenship', $application->details->citizenship) == 'Slovensko' ? 'selected' : '' }}>Slovensko</option>
                            <option value="Jiné">Jiné</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                            <span class="material-symbols-rounded text-gray-500">expand_more</span>
                        </div>
                        @if($citizenVerified)
                            <p class="text-blue-600 text-xs mt-1.5 ml-1 font-bold flex items-center gap-1 absolute -bottom-6 left-0">
                                <span class="material-symbols-rounded text-[14px]">verified</span> Ověřeno pomocí NIA ID
                            </p>
                        @endif
                    </div>
                    @error('citizenship')
                        <div class="flex items-center gap-1 mt-1.5 ml-1 text-red-500"><span class="material-symbols-rounded text-[16px]">error</span><p class="text-xs">{{ $message }}</p></div>
                    @enderror
                    <div class="h-4"></div>
                </div>

                @include('components.input-verified', [
                    'name' => 'birth_city',
                    'label' => 'Místo narození',
                    'icon' => 'location_on',
                    'placeholder' => 'Uherské Hradiště',
                    'value' => old('birth_city', $application->details->birth_city),
                    'niaValue' => $application->details->nia_data['birth_city'] ?? null,
                ])
            </div>
        </div>

        <div class="bg-white/80 backdrop-blur-xl rounded-3xl shadow-sm border border-white/60 p-8 ring-1 ring-black/5 mb-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Adresa trvalého bydliště</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">Stát</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="material-symbols-rounded text-gray-400 text-[20px]">public</span>
                        </div>
                        @php
                            $countryVerified = isset($application->details->nia_data['country']) &&
                                              old('country', $application->details->country) == $application->details->nia_data['country'];
                        @endphp
                        <select name="country"
                            class="w-full appearance-none rounded-xl border border-gray-200 shadow-sm focus:border-school-primary focus:ring-school-primary py-3 pl-10 pr-10 transition-all
                            @if($countryVerified) bg-gray-50 text-gray-500 pointer-events-none @else bg-white/50 text-gray-900 @endif
                            @error('country') border-red-500 @enderror">
                            <option value="Česká republika" {{ old('country', $application->details->country) == 'Česká republika' ? 'selected' : '' }}>Česká republika</option>
                            <option value="Slovensko" {{ old('country', $application->details->country) == 'Slovensko' ? 'selected' : '' }}>Slovensko</option>
                            <option value="Jiné">Jiné</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                            <span class="material-symbols-rounded text-gray-500">expand_more</span>
                        </div>
                        @if($countryVerified)
                            <p class="text-blue-600 text-xs mt-1.5 ml-1 font-bold flex items-center gap-1 absolute -bottom-6 left-0">
                                <span class="material-symbols-rounded text-[14px]">verified</span> Ověřeno pomocí NIA ID
                            </p>
                        @endif
                    </div>
                    @error('country')
                        <div class="flex items-center gap-1 mt-1.5 ml-1 text-red-500"><span class="material-symbols-rounded text-[16px]">error</span><p class="text-xs">{{ $message }}</p></div>
                    @enderror
                    <div class="h-4"></div>
                </div>

                @include('components.input-verified', [
                    'name' => 'city',
                    'label' => 'Obec / Město',
                    'icon' => 'location_city',
                    'placeholder' => 'Uherské Hradiště',
                    'value' => old('city', $application->details->city),
                    'niaValue' => $application->details->nia_data['city'] ?? null,
                ])

                @include('components.input-verified', [
                    'name' => 'street',
                    'label' => 'Ulice a číslo popisné',
                    'icon' => 'home',
                    'placeholder' => 'Masarykovo náměstí 123',
                    'value' => old('street', $application->details->street),
                    'niaValue' => $application->details->nia_data['street'] ?? null,
                ])

                <div>
                    @include('components.input-verified', [
                        'name' => 'zip',
                        'label' => 'PSČ',
                        'icon' => 'markunread_mailbox',
                        'placeholder' => '686 01',
                        'value' => old('zip', $application->details->zip),
                        'niaValue' => $application->details->nia_data['zip'] ?? null,
                    ])
                </div>
            </div>
        </div>

        <div class="bg-white/80 backdrop-blur-xl rounded-3xl shadow-sm border border-white/60 p-8 ring-1 ring-black/5">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Kontaktní údaje</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">E-mail</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="material-symbols-rounded text-gray-400 text-[20px]">alternate_email</span>
                        </div>
                        <input type="email" name="email"
                            value="{{ old('email', $application->details->email ?? Auth::user()->email) }}"
                            placeholder="jan.novak@example.com"
                            class="w-full rounded-xl border border-gray-200 shadow-sm focus:border-school-primary focus:ring-school-primary bg-white/50 text-gray-900 placeholder-gray-400 py-3 pl-10 pr-4 transition-all @error('email') border-red-500 @enderror">
                    </div>
                    @error('email')
                        <div class="flex items-center gap-1 mt-1.5 ml-1 text-red-500"><span class="material-symbols-rounded text-[16px]">error</span><p class="text-xs">{{ $message }}</p></div>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">Telefon</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="material-symbols-rounded text-gray-400 text-[20px]">call</span>
                        </div>
                        <input type="text" name="phone" value="{{ old('phone', $application->details->phone) }}"
                            placeholder="+420 777 123 456"
                            class="w-full rounded-xl border border-gray-200 shadow-sm focus:border-school-primary focus:ring-school-primary bg-white/50 text-gray-900 placeholder-gray-400 py-3 pl-10 pr-4 transition-all @error('phone') border-red-500 @enderror">
                    </div>
                    @error('phone')
                        <div class="flex items-center gap-1 mt-1.5 ml-1 text-red-500"><span class="material-symbols-rounded text-[16px]">error</span><p class="text-xs">{{ $message }}</p></div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="bg-white/80 backdrop-blur-xl rounded-3xl shadow-sm border border-white/60 p-4 mt-8 ring-1 ring-black/5">
            <div class="flex justify-between items-center">
                <a href="{{ route('dashboard') }}" class="group relative flex items-center justify-center px-6 py-3 rounded-xl overflow-hidden transition-all duration-300 hover:bg-gray-100">
                    <span class="relative z-10 text-gray-500 font-bold text-sm flex items-center group-hover:text-gray-800 transition-colors">
                        Zrušit
                    </span>
                </a>

                <button type="submit" class="group relative flex items-center justify-center px-8 py-4 rounded-xl overflow-hidden shadow-xl hover:shadow-2xl transition-all duration-300 cursor-pointer">
                    <div class="absolute inset-0 topo-bg opacity-50 transition-opacity duration-300"></div>
                    <div class="absolute inset-0 bg-white/60 backdrop-blur-[2px] group-hover:backdrop-blur-[4px] transition-all duration-300"></div>
                    <div class="absolute inset-0 rounded-xl border border-white/60 border-b-4 border-b-gray-200/50"></div>
                    <span class="relative z-10 text-gray-900 font-bold text-lg flex items-center drop-shadow-sm">
                        Pokračovat
                        <span class="material-symbols-rounded ml-3 text-[20px] text-gray-600 group-hover:text-school-primary transition-transform duration-300 group-hover:translate-x-1">arrow_forward</span>
                    </span>
                </button>
            </div>
        </div>

    </form>
@endsection
