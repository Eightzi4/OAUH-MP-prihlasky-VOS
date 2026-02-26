@extends('layouts.application')

@section('form-content')

    <form id="main-form" action="{{ route('application.submit', $application->id) }}" method="POST">
        @csrf

        @php
            function editBtn(string $route): string
            {
                return '';
            }
        @endphp

        <div
            class="bg-white/80 backdrop-blur-xl rounded-3xl shadow-sm border border-white/60 p-6 sm:p-8 ring-1 ring-black/5 mb-6">
            <div class="flex justify-between items-center mb-6 pb-4 border-b border-gray-100">
                <h2 class="text-xl font-bold text-gray-900">Osobní a kontaktní údaje</h2>
                <a href="{{ route('application.step1', $application->id) }}"
                    class="group relative flex items-center justify-center px-4 py-2 rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-all duration-300 border border-transparent hover:border-gray-200">
                    <div class="absolute inset-0 topo-bg opacity-30"></div>
                    <div
                        class="absolute inset-0 bg-white/60 backdrop-blur-[2px] group-hover:bg-white/70 transition-all duration-300">
                    </div>
                    <div class="absolute inset-0 rounded-xl border border-white/60 border-b-2 border-b-gray-200/50"></div>
                    <span class="relative z-10 text-xs font-bold text-gray-600 flex items-center gap-2">
                        <span
                            class="material-symbols-rounded text-[16px] text-gray-500 group-hover:text-school-primary transition-colors">edit</span>
                        Upravit
                    </span>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-12 gap-y-5">
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wide mb-1">Jméno a příjmení</p>
                    <p class="text-sm font-semibold text-gray-900">{{ $application->first_name }}
                        {{ $application->last_name }}</p>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wide mb-1">Pohlaví</p>
                    <p class="text-sm font-semibold text-gray-900">{{ $application->gender }}</p>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wide mb-1">Rodné číslo</p>
                    <p class="text-sm font-semibold text-gray-900 font-mono">{{ $application->birth_number }}</p>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wide mb-1">Datum a místo narození</p>
                    <p class="text-sm font-semibold text-gray-900">
                        {{ \Carbon\Carbon::parse($application->birth_date)->format('d. m. Y') }},
                        {{ $application->birth_city }}
                    </p>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wide mb-1">Státní občanství</p>
                    <p class="text-sm font-semibold text-gray-900">{{ $application->citizenship }}</p>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wide mb-1">Adresa trvalého bydliště</p>
                    <p class="text-sm font-semibold text-gray-900 leading-relaxed">
                        {{ $application->street }}<br>
                        {{ $application->zip }} {{ $application->city }}<br>
                        {{ $application->country }}
                    </p>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wide mb-1">E-mail</p>
                    <p class="text-sm font-semibold text-gray-900">{{ $application->email }}</p>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wide mb-1">Telefon</p>
                    <p class="text-sm font-semibold text-gray-900">{{ $application->phone }}</p>
                </div>
            </div>
        </div>

        <div
            class="bg-white/80 backdrop-blur-xl rounded-3xl shadow-sm border border-white/60 p-6 sm:p-8 ring-1 ring-black/5 mb-6">
            <div class="flex justify-between items-center mb-6 pb-4 border-b border-gray-100">
                <h2 class="text-xl font-bold text-gray-900">Předchozí vzdělání</h2>
                <a href="{{ route('application.step2', $application->id) }}"
                    class="group relative flex items-center justify-center px-4 py-2 rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-all duration-300 border border-transparent hover:border-gray-200">
                    <div class="absolute inset-0 topo-bg opacity-30"></div>
                    <div
                        class="absolute inset-0 bg-white/60 backdrop-blur-[2px] group-hover:bg-white/70 transition-all duration-300">
                    </div>
                    <div class="absolute inset-0 rounded-xl border border-white/60 border-b-2 border-b-gray-200/50"></div>
                    <span class="relative z-10 text-xs font-bold text-gray-600 flex items-center gap-2">
                        <span
                            class="material-symbols-rounded text-[16px] text-gray-500 group-hover:text-school-primary transition-colors">edit</span>
                        Upravit
                    </span>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-12 gap-y-5">
                <div class="sm:col-span-2">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wide mb-1">Název střední školy</p>
                    <p class="text-sm font-semibold text-gray-900">{{ $application->previous_school }}</p>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wide mb-1">IZO školy</p>
                    <p class="text-sm font-semibold text-gray-900 font-mono">{{ $application->izo }}</p>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wide mb-1">Typ školy</p>
                    <p class="text-sm font-semibold text-gray-900">{{ $application->school_type }}</p>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wide mb-1">Obor studia</p>
                    <p class="text-sm font-semibold text-gray-900">{{ $application->previous_study_field }}</p>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wide mb-1">Kód oboru (KKOV)</p>
                    <p class="text-sm font-semibold text-gray-900 font-mono">{{ $application->previous_study_field_code }}
                    </p>
                </div>
                @if ($application->graduation_year || $application->grade_average)
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wide mb-1">Rok maturity</p>
                        <p class="text-sm font-semibold text-gray-900">{{ $application->graduation_year ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wide mb-1">Průměr známek</p>
                        <p class="text-sm font-semibold text-gray-900">{{ $application->grade_average ?? '—' }}</p>
                    </div>
                @endif

                @php $maturitaFile = $application->attachments->where('type', 'maturita')->first(); @endphp
                @if ($maturitaFile)
                    <div class="sm:col-span-2">
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wide mb-2">Maturitní vysvědčení</p>
                        <a href="{{ asset('storage/' . $maturitaFile->disk_path) }}" target="_blank"
                            class="inline-flex items-center gap-3 p-3 bg-white border border-gray-200 rounded-xl hover:shadow-md transition-all group/file">
                            @if (str_starts_with($maturitaFile->mime_type, 'image/'))
                                <div
                                    class="h-10 w-10 rounded-lg overflow-hidden border border-gray-100 bg-gray-100 flex-shrink-0">
                                    <img src="{{ asset('storage/' . $maturitaFile->disk_path) }}"
                                        class="w-full h-full object-cover">
                                </div>
                            @else
                                <div
                                    class="h-10 w-10 bg-green-50 rounded-lg flex items-center justify-center text-green-600 border border-green-100 flex-shrink-0">
                                    <span class="material-symbols-rounded">description</span>
                                </div>
                            @endif
                            <div class="min-w-0">
                                <p
                                    class="text-sm font-bold text-gray-900 truncate group-hover/file:text-school-primary transition-colors">
                                    {{ $maturitaFile->filename }}
                                </p>
                                <p class="text-xs text-gray-500">{{ round($maturitaFile->size / 1024) }} KB &bull; Klikněte
                                    pro zobrazení</p>
                            </div>
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <div
            class="bg-white/80 backdrop-blur-xl rounded-3xl shadow-sm border border-white/60 p-6 sm:p-8 ring-1 ring-black/5 mb-8">
            <div class="flex justify-between items-center mb-6 pb-4 border-b border-gray-100">
                <h2 class="text-xl font-bold text-gray-900">Doplňující informace</h2>
                <a href="{{ route('application.step3', $application->id) }}"
                    class="group relative flex items-center justify-center px-4 py-2 rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-all duration-300 border border-transparent hover:border-gray-200">
                    <div class="absolute inset-0 topo-bg opacity-30"></div>
                    <div
                        class="absolute inset-0 bg-white/60 backdrop-blur-[2px] group-hover:bg-white/70 transition-all duration-300">
                    </div>
                    <div class="absolute inset-0 rounded-xl border border-white/60 border-b-2 border-b-gray-200/50"></div>
                    <span class="relative z-10 text-xs font-bold text-gray-600 flex items-center gap-2">
                        <span
                            class="material-symbols-rounded text-[16px] text-gray-500 group-hover:text-school-primary transition-colors">edit</span>
                        Upravit
                    </span>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-12 gap-y-5">
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wide mb-1">Specifické potřeby</p>
                    <p class="text-sm text-gray-900 leading-relaxed">{{ $application->specific_needs ?: 'Neuvedeno' }}</p>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wide mb-1">Poznámka</p>
                    <p class="text-sm text-gray-900 leading-relaxed">{{ $application->note ?: 'Bez poznámky' }}</p>
                </div>

                @php $otherFiles = $application->attachments->where('type', 'other'); @endphp
                @if ($otherFiles->isNotEmpty())
                    <div class="sm:col-span-2">
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wide mb-2">Další přílohy</p>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            @foreach ($otherFiles as $file)
                                <a href="{{ asset('storage/' . $file->disk_path) }}" target="_blank"
                                    class="flex items-center gap-3 p-3 bg-white border border-gray-200 rounded-xl hover:shadow-md transition-all group/file">
                                    @if (str_starts_with($file->mime_type, 'image/'))
                                        <div
                                            class="h-10 w-10 rounded-lg overflow-hidden border border-gray-100 bg-gray-100 flex-shrink-0">
                                            <img src="{{ asset('storage/' . $file->disk_path) }}"
                                                class="w-full h-full object-cover">
                                        </div>
                                    @else
                                        <div
                                            class="h-10 w-10 bg-blue-50 rounded-lg flex items-center justify-center text-blue-600 border border-blue-100 flex-shrink-0">
                                            <span class="material-symbols-rounded">attach_file</span>
                                        </div>
                                    @endif
                                    <div class="min-w-0">
                                        <p
                                            class="text-sm font-bold text-gray-900 truncate group-hover/file:text-school-primary transition-colors">
                                            {{ $file->filename }}
                                        </p>
                                        <p class="text-xs text-gray-500">{{ round($file->size / 1024) }} KB</p>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-gray-200 shadow-sm mb-8 ring-1 ring-black/5">
            <label class="flex items-start gap-4 cursor-pointer group">
                <div class="relative flex items-center pt-1 flex-shrink-0">
                    <input type="checkbox" name="consent" required
                        class="peer h-6 w-6 cursor-pointer appearance-none rounded-md border-2 border-gray-300 bg-white transition-all checked:border-school-primary checked:bg-school-primary hover:border-school-primary">
                    <span
                        class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 mt-0.5 text-white opacity-0 peer-checked:opacity-100 pointer-events-none">
                        <span class="material-symbols-rounded text-[18px] font-bold">check</span>
                    </span>
                </div>
                <div class="text-sm text-gray-700 leading-relaxed">
                    <span class="font-bold text-gray-900 block mb-1">Potvrzuji správnost a pravdivost údajů</span>
                    Prohlašuji, že všechny uvedené údaje v této přihlášce jsou pravdivé a úplné. Jsem si vědom(a) právních
                    následků uvedení nepravdivých údajů. Souhlasím se zpracováním osobních údajů pro účely přijímacího
                    řízení v souladu s GDPR.
                </div>
            </label>
            @error('consent')
                <div class="flex items-center gap-1 mt-2 ml-10 text-school-warning">
                    <span class="material-symbols-rounded text-[16px]">error</span>
                    <p class="text-xs font-medium">Musíte potvrdit souhlas se zpracováním údajů.</p>
                </div>
            @enderror
        </div>

        <div class="bg-white/80 backdrop-blur-xl rounded-3xl shadow-sm border border-white/60 p-4 ring-1 ring-black/5">
            <div class="flex justify-between items-center gap-4">
                <button type="button" onclick="goToStep('{{ route('application.step3', $application->id) }}')"
                    class="group flex items-center justify-center px-4 py-2.5 sm:px-6 sm:py-3 rounded-xl transition-all duration-300 hover:bg-gray-100 cursor-pointer bg-transparent border-none">
                    <span
                        class="text-gray-600 font-bold text-sm flex items-center group-hover:text-gray-900 transition-colors whitespace-nowrap">
                        <span
                            class="material-symbols-rounded mr-1 sm:mr-2 text-[18px] transition-transform duration-300 group-hover:-translate-x-1">arrow_back</span>
                        <span class="hidden sm:inline">Zpět na přílohy</span>
                        <span class="sm:hidden">Zpět</span>
                    </span>
                </button>

                <button type="submit"
                    class="group relative flex items-center justify-center px-6 py-3 sm:px-8 sm:py-4 rounded-xl overflow-hidden shadow-xl hover:shadow-2xl transition-all duration-300 cursor-pointer">
                    <div class="absolute inset-0 topo-bg opacity-50 transition-opacity duration-300"></div>
                    <div
                        class="absolute inset-0 bg-white/60 backdrop-blur-[2px] group-hover:backdrop-blur-[4px] transition-all duration-300">
                    </div>
                    <div class="absolute inset-0 rounded-xl border border-white/60 border-b-4 border-b-gray-200/50"></div>
                    <span
                        class="relative z-10 text-gray-900 font-bold text-base sm:text-lg flex items-center drop-shadow-sm whitespace-nowrap">
                        Odeslat přihlášku
                        <span
                            class="material-symbols-rounded ml-2 sm:ml-3 text-[20px] text-school-primary transition-transform duration-300 group-hover:translate-x-1">send</span>
                    </span>
                </button>
            </div>
        </div>

    </form>

@endsection
