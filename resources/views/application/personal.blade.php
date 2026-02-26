@extends('layouts.application')

@section('form-content')
    @php
        $serverErrors = array_keys($errors->toArray());
        $serverMessages = collect($errors->toArray())->map(fn($msgs) => $msgs[0])->toArray();
    @endphp

    <div x-data="stepValidator({
        step: 1,
        serverErrorFields: @json($serverErrors),
        serverMessages: @json($serverMessages),
        fields: [
            { name: 'first_name', message: 'Křestní jméno je povinné.' },
            { name: 'last_name', message: 'Příjmení je povinné.' },
            { name: 'gender', message: 'Pohlaví je povinné.' },
            { name: 'birth_number', message: 'Rodné číslo je povinné.' },
            { name: 'birth_date', message: 'Datum narození je povinné.' },
            { name: 'birth_city', message: 'Místo narození je povinné.' },
            { name: 'citizenship', message: 'Státní občanství je povinné.' },
            { name: 'email', message: 'E-mail je povinný.' },
            { name: 'phone', message: 'Telefon je povinný.' },
            { name: 'street', message: 'Ulice a číslo popisné jsou povinné.' },
            { name: 'city', message: 'Město je povinné.' },
            { name: 'zip', message: 'PSČ je povinné.' },
            { name: 'country', message: 'Stát je povinný.' },
        ]
    })">
        <form id="main-form" action="{{ route('application.storeStep1', $application->id) }}" method="POST">
            @csrf

            <div
                class="relative bg-white/80 backdrop-blur-xl rounded-3xl shadow-lg border-2 border-school-primary/20 p-6 sm:p-8 mb-8 overflow-hidden group hover:border-school-primary/40 transition-all duration-500">
                <div
                    class="absolute -right-4 -bottom-12 opacity-[0.04] rotate-[15deg] pointer-events-none transition-transform duration-700 ease-out group-hover:rotate-[5deg] group-hover:scale-105">
                    <span
                        class="material-symbols-rounded text-[200px] sm:text-[250px] text-school-primary leading-none">verified_user</span>
                </div>
                <div class="relative z-10 flex flex-col xl:flex-row items-center justify-between gap-6">
                    <div class="max-w-xl text-center xl:text-left">
                        <h3
                            class="text-2xl sm:text-3xl font-bold text-gray-900 mb-2 tracking-tight flex items-center justify-center xl:justify-start gap-3">
                            <span
                                class="material-symbols-rounded text-school-primary text-[28px] sm:text-[32px]">fingerprint</span>
                            Identita občana
                        </h3>
                        <p class="text-gray-600 font-medium leading-relaxed text-base sm:text-lg">
                            Urychlete vyplňování načtením ověřených údajů přímo ze státních registrů.
                        </p>
                    </div>
                    <div class="flex flex-col sm:flex-row xl:flex-col gap-3 w-full xl:w-auto">
                        <a href="{{ route('nia.real.login', $application->id) }}"
                            class="group/btn relative flex items-center justify-center px-6 py-3 sm:px-8 sm:py-4 rounded-xl overflow-hidden shadow-xl hover:shadow-2xl transition-all duration-300 cursor-pointer w-full sm:w-auto xl:w-[280px]">
                            <div class="absolute inset-0 topo-bg opacity-50"></div>
                            <div
                                class="absolute inset-0 bg-white/60 backdrop-blur-[2px] group-hover/btn:backdrop-blur-[4px] transition-all duration-300">
                            </div>
                            <div class="absolute inset-0 rounded-xl border border-white/60 border-b-4 border-b-gray-200/50">
                            </div>
                            <span
                                class="relative z-10 text-gray-900 font-bold text-base sm:text-lg flex items-center drop-shadow-sm whitespace-nowrap">
                                Načíst přes NIA
                                <span
                                    class="material-symbols-rounded ml-2 text-[22px] text-gray-600 group-hover/btn:text-school-primary transition-transform duration-300 group-hover/btn:translate-x-1">login</span>
                            </span>
                        </a>
                        <a href="https://www.youtube.com/watch?v=ztrRu-olFy8" target="_blank"
                            class="group/btn relative flex items-center justify-center px-6 py-3 sm:px-8 sm:py-4 rounded-xl overflow-hidden shadow-xl hover:shadow-2xl transition-all duration-300 cursor-pointer w-full sm:w-auto xl:w-[280px]">
                            <div class="absolute inset-0 topo-bg opacity-30"></div>
                            <div
                                class="absolute inset-0 bg-white/40 backdrop-blur-[2px] group-hover/btn:backdrop-blur-[4px] transition-all duration-300">
                            </div>
                            <div class="absolute inset-0 rounded-xl border border-white/60 border-b-4 border-b-gray-200/50">
                            </div>
                            <span
                                class="relative z-10 text-gray-700 font-bold text-base sm:text-lg flex items-center drop-shadow-sm whitespace-nowrap">
                                Video návod
                                <span
                                    class="material-symbols-rounded ml-2 text-[22px] text-red-600 group-hover/btn:scale-110 transition-transform duration-300">play_circle</span>
                            </span>
                        </a>
                    </div>
                </div>
            </div>

            <div
                class="bg-white/80 backdrop-blur-xl rounded-3xl shadow-sm border border-white/60 p-6 sm:p-8 ring-1 ring-black/5 mb-6">
                <h2 class="text-xl sm:text-2xl font-bold text-gray-900 mb-6">Identifikační údaje</h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    @include('components.input-verified', [
                        'name' => 'first_name',
                        'label' => 'Křestní jméno',
                        'icon' => 'person',
                        'placeholder' => 'Jan',
                        'value' => old('first_name', $application->first_name),
                        'verified' => in_array('first_name', $application->verified_fields ?? []),
                    ])

                    @include('components.input-verified', [
                        'name' => 'last_name',
                        'label' => 'Příjmení',
                        'icon' => 'badge',
                        'placeholder' => 'Novák',
                        'value' => old('last_name', $application->last_name),
                        'verified' => in_array('last_name', $application->verified_fields ?? []),
                    ])

                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">Pohlaví</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="material-symbols-rounded text-gray-400 text-[20px]">wc</span>
                            </div>
                            @php $genderVerified = in_array('gender', $application->verified_fields ?? []); @endphp
                            <select name="gender"
                                :class="{
                                    'border-school-warning ring-1 ring-school-warning/30': fieldHasError('gender'),
                                    'border-gray-200': !fieldHasError('gender')
                                }"
                                class="block w-full appearance-none rounded-xl border shadow-sm leading-5 sm:text-sm text-gray-900 py-3 pl-10 pr-10 transition-all focus:outline-none focus:ring-2 focus:ring-school-primary focus:border-school-primary
                            @if ($genderVerified) bg-gray-50 text-gray-500 pointer-events-none @else bg-white/50 @endif">
                                <option value="" disabled {{ old('gender', $application->gender) ? '' : 'selected' }}>
                                    Vyberte pohlaví</option>
                                <option value="Muž"
                                    {{ old('gender', $application->gender) === 'Muž' ? 'selected' : '' }}>Muž</option>
                                <option value="Žena"
                                    {{ old('gender', $application->gender) === 'Žena' ? 'selected' : '' }}>Žena</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                                <span class="material-symbols-rounded text-gray-500">expand_more</span>
                            </div>
                        </div>
                        @error('gender')
                            <template x-if="showServerError('gender')">
                                <div data-field-error class="flex items-center gap-1 mt-1.5 ml-1 text-school-warning">
                                    <span class="material-symbols-rounded text-[16px]">error</span>
                                    <p class="text-xs font-medium">{{ $message }}</p>
                                </div>
                            </template>
                        @enderror
                        @if (!$genderVerified)
                            <template x-if="hasError('gender')">
                                <div data-field-error class="flex items-center gap-1 mt-1.5 ml-1 text-school-warning">
                                    <span class="material-symbols-rounded text-[16px]">error</span>
                                    <p class="text-xs font-medium" x-text="errors['gender']"></p>
                                </div>
                            </template>
                        @endif
                        <div class="h-4"></div>
                    </div>
                </div>
            </div>

            <div
                class="bg-white/80 backdrop-blur-xl rounded-3xl shadow-sm border border-white/60 p-6 sm:p-8 ring-1 ring-black/5 mb-6">
                <h2 class="text-xl sm:text-2xl font-bold text-gray-900 mb-6">Narození a občanství</h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">Datum
                            narození</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="material-symbols-rounded text-gray-400 text-[20px]">calendar_today</span>
                            </div>
                            @php
                                $dobValue = old(
                                    'birth_date',
                                    $application->birth_date ? $application->birth_date->format('Y-m-d') : '',
                                );
                                $dobVerified = in_array('birth_date', $application->verified_fields ?? []);
                            @endphp
                            <input type="date" name="birth_date" value="{{ $dobValue }}"
                                @if ($dobVerified) readonly @endif
                                :class="{
                                    'border-school-warning ring-1 ring-school-warning/30': fieldHasError('birth_date'),
                                    'border-gray-200': !fieldHasError('birth_date')
                                }"
                                class="block w-full rounded-xl border shadow-sm focus:border-school-primary focus:ring-school-primary py-3 pl-10 pr-4 transition-all focus:outline-none
                            @if ($dobVerified) bg-gray-50 text-gray-500 cursor-not-allowed focus:border-gray-200 @else bg-white/50 text-gray-900 focus:ring-2 @endif">

                            @if ($dobVerified)
                                <p
                                    class="text-blue-600 text-xs mt-1.5 ml-1 font-bold flex items-center gap-1 absolute -bottom-6 left-0">
                                    <span class="material-symbols-rounded text-[14px]">verified</span> Ověřeno pomocí NIA ID
                                </p>
                            @endif
                        </div>
                        @error('birth_date')
                            <template x-if="showServerError('birth_date')">
                                <div data-field-error class="flex items-center gap-1 mt-1.5 ml-1 text-school-warning">
                                    <span class="material-symbols-rounded text-[16px]">error</span>
                                    <p class="text-xs font-medium">{{ $message }}</p>
                                </div>
                            </template>
                        @enderror
                        @if (!$dobVerified)
                            <template x-if="hasError('birth_date')">
                                <div data-field-error class="flex items-center gap-1 mt-1.5 ml-1 text-school-warning">
                                    <span class="material-symbols-rounded text-[16px]">error</span>
                                    <p class="text-xs font-medium" x-text="errors['birth_date']"></p>
                                </div>
                            </template>
                        @endif
                        <div class="h-4"></div>
                    </div>

                    @include('components.input-verified', [
                        'name' => 'birth_number',
                        'label' => 'Rodné číslo',
                        'icon' => 'fingerprint',
                        'placeholder' => '000101/1234',
                        'value' => old('birth_number', $application->birth_number),
                        'verified' => in_array('birth_number', $application->verified_fields ?? []),
                    ])

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">Státní
                            občanství</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="material-symbols-rounded text-gray-400 text-[20px]">flag</span>
                            </div>
                            @php $citizenVerified = in_array('citizenship', $application->verified_fields ?? []); @endphp
                            <select name="citizenship"
                                :class="{
                                    'border-school-warning ring-1 ring-school-warning/30': fieldHasError('citizenship'),
                                    'border-gray-200': !fieldHasError('citizenship')
                                }"
                                class="block w-full appearance-none rounded-xl border shadow-sm leading-5 sm:text-sm text-gray-900 py-3 pl-10 pr-10 transition-all focus:outline-none focus:ring-2 focus:ring-school-primary focus:border-school-primary
                            @if ($citizenVerified) bg-gray-50 text-gray-500 pointer-events-none @else bg-white/50 @endif">
                                <option value="Česká republika"
                                    {{ old('citizenship', $application->citizenship) === 'Česká republika' ? 'selected' : '' }}>
                                    Česká republika</option>
                                <option value="Slovensko"
                                    {{ old('citizenship', $application->citizenship) === 'Slovensko' ? 'selected' : '' }}>
                                    Slovensko</option>
                                <option value="Jiné"
                                    {{ old('citizenship', $application->citizenship) === 'Jiné' ? 'selected' : '' }}>
                                    Jiné</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                                <span class="material-symbols-rounded text-gray-500">expand_more</span>
                            </div>
                        </div>
                        @error('citizenship')
                            <template x-if="showServerError('citizenship')">
                                <div data-field-error class="flex items-center gap-1 mt-1.5 ml-1 text-school-warning">
                                    <span class="material-symbols-rounded text-[16px]">error</span>
                                    <p class="text-xs font-medium">{{ $message }}</p>
                                </div>
                            </template>
                        @enderror
                        @if (!$citizenVerified)
                            <template x-if="hasError('citizenship')">
                                <div data-field-error class="flex items-center gap-1 mt-1.5 ml-1 text-school-warning">
                                    <span class="material-symbols-rounded text-[16px]">error</span>
                                    <p class="text-xs font-medium" x-text="errors['citizenship']"></p>
                                </div>
                            </template>
                        @endif
                        <div class="h-4"></div>
                    </div>

                    @include('components.input-verified', [
                        'name' => 'birth_city',
                        'label' => 'Místo narození',
                        'icon' => 'location_on',
                        'placeholder' => 'Uherské Hradiště',
                        'value' => old('birth_city', $application->birth_city),
                        'verified' => in_array('birth_city', $application->verified_fields ?? []),
                    ])
                </div>
            </div>

            <div
                class="bg-white/80 backdrop-blur-xl rounded-3xl shadow-sm border border-white/60 p-6 sm:p-8 ring-1 ring-black/5 mb-6">
                <h2 class="text-xl sm:text-2xl font-bold text-gray-900 mb-6">Adresa trvalého bydliště</h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">Stát</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="material-symbols-rounded text-gray-400 text-[20px]">public</span>
                            </div>
                            @php $countryVerified = in_array('country', $application->verified_fields ?? []); @endphp
                            <select name="country"
                                :class="{
                                    'border-school-warning ring-1 ring-school-warning/30': fieldHasError('country'),
                                    'border-gray-200': !fieldHasError('country')
                                }"
                                class="block w-full appearance-none rounded-xl border shadow-sm leading-5 sm:text-sm text-gray-900 py-3 pl-10 pr-10 transition-all focus:outline-none focus:ring-2 focus:ring-school-primary focus:border-school-primary
                            @if ($countryVerified) bg-gray-50 text-gray-500 pointer-events-none focus:border-gray-200 focus:ring-0 @else bg-white/50 @endif">
                                <option value="Česká republika"
                                    {{ old('country', $application->country) === 'Česká republika' ? 'selected' : '' }}>
                                    Česká republika</option>
                                <option value="Slovensko"
                                    {{ old('country', $application->country) === 'Slovensko' ? 'selected' : '' }}>
                                    Slovensko</option>
                                <option value="Jiné"
                                    {{ old('country', $application->country) === 'Jiné' ? 'selected' : '' }}>
                                    Jiné</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                                <span class="material-symbols-rounded text-gray-500">expand_more</span>
                            </div>

                            @if ($countryVerified)
                                <p
                                    class="text-blue-600 text-xs mt-1.5 ml-1 font-bold flex items-center gap-1 absolute -bottom-6 left-0">
                                    <span class="material-symbols-rounded text-[14px]">verified</span> Ověřeno pomocí NIA
                                    ID
                                </p>
                            @endif
                        </div>
                        @error('country')
                            <template x-if="showServerError('country')">
                                <div data-field-error class="flex items-center gap-1 mt-1.5 ml-1 text-school-warning">
                                    <span class="material-symbols-rounded text-[16px]">error</span>
                                    <p class="text-xs font-medium">{{ $message }}</p>
                                </div>
                            </template>
                        @enderror
                        @if (!$countryVerified)
                            <template x-if="hasError('country')">
                                <div data-field-error class="flex items-center gap-1 mt-1.5 ml-1 text-school-warning">
                                    <span class="material-symbols-rounded text-[16px]">error</span>
                                    <p class="text-xs font-medium" x-text="errors['country']"></p>
                                </div>
                            </template>
                        @endif
                        <div class="h-4"></div>
                    </div>

                    @include('components.input-verified', [
                        'name' => 'city',
                        'label' => 'Obec / Město',
                        'icon' => 'location_city',
                        'placeholder' => 'Uherské Hradiště',
                        'value' => old('city', $application->city),
                        'verified' => in_array('city', $application->verified_fields ?? []),
                    ])

                    @include('components.input-verified', [
                        'name' => 'street',
                        'label' => 'Ulice a číslo popisné',
                        'icon' => 'home',
                        'placeholder' => 'Masarykovo náměstí 123',
                        'value' => old('street', $application->street),
                        'verified' => in_array('street', $application->verified_fields ?? []),
                    ])

                    @include('components.input-verified', [
                        'name' => 'zip',
                        'label' => 'PSČ',
                        'icon' => 'markunread_mailbox',
                        'placeholder' => '686 01',
                        'value' => old('zip', $application->zip),
                        'verified' => in_array('zip', $application->verified_fields ?? []),
                    ])
                </div>
            </div>

            <div
                class="bg-white/80 backdrop-blur-xl rounded-3xl shadow-sm border border-white/60 p-6 sm:p-8 ring-1 ring-black/5">
                <h2 class="text-xl sm:text-2xl font-bold text-gray-900 mb-6">Kontaktní údaje</h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">E-mail</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="material-symbols-rounded text-gray-400 text-[20px]">alternate_email</span>
                            </div>
                            <input type="email" name="email"
                                value="{{ old('email', $application->email ?? Auth::user()->email) }}"
                                placeholder="jan.novak@example.com"
                                :class="{
                                    'border-school-warning ring-1 ring-school-warning/30': fieldHasError('email'),
                                    'border-gray-200': !fieldHasError('email')
                                }"
                                class="block w-full pl-10 pr-3 py-3 border rounded-xl leading-5 bg-white/50 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-school-primary focus:border-school-primary sm:text-sm transition-all shadow-sm">
                        </div>
                        @error('email')
                            <template x-if="showServerError('email')">
                                <div data-field-error class="flex items-center gap-1 mt-1.5 ml-1 text-school-warning">
                                    <span class="material-symbols-rounded text-[16px]">error</span>
                                    <p class="text-xs font-medium">{{ $message }}</p>
                                </div>
                            </template>
                        @enderror
                        <template x-if="hasError('email')">
                            <div data-field-error class="flex items-center gap-1 mt-1.5 ml-1 text-school-warning">
                                <span class="material-symbols-rounded text-[16px]">error</span>
                                <p class="text-xs font-medium" x-text="errors['email']"></p>
                            </div>
                        </template>
                        <div class="h-2"></div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">Telefon</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="material-symbols-rounded text-gray-400 text-[20px]">call</span>
                            </div>
                            <input type="text" name="phone" value="{{ old('phone', $application->phone) }}"
                                placeholder="+420 777 123 456"
                                :class="{
                                    'border-school-warning ring-1 ring-school-warning/30': fieldHasError('phone'),
                                    'border-gray-200': !fieldHasError('phone')
                                }"
                                class="block w-full pl-10 pr-3 py-3 border rounded-xl leading-5 bg-white/50 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-school-primary focus:border-school-primary sm:text-sm transition-all shadow-sm">
                        </div>
                        @error('phone')
                            <template x-if="showServerError('phone')">
                                <div data-field-error class="flex items-center gap-1 mt-1.5 ml-1 text-school-warning">
                                    <span class="material-symbols-rounded text-[16px]">error</span>
                                    <p class="text-xs font-medium">{{ $message }}</p>
                                </div>
                            </template>
                        @enderror
                        <template x-if="hasError('phone')">
                            <div data-field-error class="flex items-center gap-1 mt-1.5 ml-1 text-school-warning">
                                <span class="material-symbols-rounded text-[16px]">error</span>
                                <p class="text-xs font-medium" x-text="errors['phone']"></p>
                            </div>
                        </template>
                        <div class="h-2"></div>
                    </div>
                </div>
            </div>

            <div
                class="bg-white/80 backdrop-blur-xl rounded-3xl shadow-sm border border-white/60 p-4 mt-6 ring-1 ring-black/5">
                <div class="flex justify-between items-center gap-4">
                    <a href="{{ route('dashboard') }}"
                        class="group flex items-center justify-center px-4 py-2.5 sm:px-6 sm:py-3 rounded-xl transition-all duration-300 hover:bg-gray-100">
                        <span
                            class="text-gray-500 font-bold text-sm group-hover:text-gray-800 transition-colors whitespace-nowrap">
                            Zrušit
                        </span>
                    </a>

                    <button type="button" @click="trySubmit()"
                        class="group relative flex items-center justify-center px-6 py-3 sm:px-8 sm:py-4 rounded-xl overflow-hidden shadow-xl hover:shadow-2xl transition-all duration-300 cursor-pointer">
                        <div class="absolute inset-0 topo-bg opacity-50"></div>
                        <div
                            class="absolute inset-0 bg-white/60 backdrop-blur-[2px] group-hover:backdrop-blur-[4px] transition-all duration-300">
                        </div>
                        <div class="absolute inset-0 rounded-xl border border-white/60 border-b-4 border-b-gray-200/50">
                        </div>
                        <span
                            class="relative z-10 text-gray-900 font-bold text-base sm:text-lg flex items-center drop-shadow-sm whitespace-nowrap">
                            Pokračovat
                            <span
                                class="material-symbols-rounded ml-2 text-[20px] text-gray-600 group-hover:text-school-primary transition-transform duration-300 group-hover:translate-x-1">arrow_forward</span>
                        </span>
                    </button>
                </div>
            </div>

        </form>
    </div>
@endsection
