@extends('layouts.app')

@section('title', 'Detail přihlášky | OAUH Admin')

@section('header-left')
    <a href="{{ route('admin.dashboard') }}"
        class="group relative flex items-center justify-center px-4 py-2 rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-all duration-300 border border-transparent hover:border-gray-200">
        <div class="absolute inset-0 topo-bg opacity-30 transition-opacity duration-300"></div>
        <div
            class="absolute inset-0 bg-white/60 backdrop-blur-[2px] group-hover:backdrop-blur-[4px] transition-all duration-300">
        </div>
        <div class="absolute inset-0 rounded-xl border border-white/60 border-b-2 border-b-gray-200/50"></div>
        <span
            class="relative z-10 text-gray-600 font-bold text-sm flex items-center gap-2 group-hover:text-school-primary transition-colors">
            <span class="material-symbols-rounded text-[18px]">arrow_back</span>
            Zpět na přehled
        </span>
    </a>
@endsection

@section('content')
    <div class="w-full max-w-5xl mx-auto py-8">

        <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-8 gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">
                    Přihláška: {{ $application->first_name }} {{ $application->last_name }}
                </h1>
                <p class="text-gray-500 font-mono">
                    ID: {{ $application->application_number ?? $application->id }} | Založeno:
                    {{ $application->created_at->format('d. m. Y H:i') }}
                </p>
            </div>
            <div>
                @if ($application->status === 'submitted')
                    <span
                        class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full text-sm font-bold bg-green-50 text-green-700 border border-green-200 shadow-sm">
                        <span class="material-symbols-rounded text-[18px]">check_circle</span> Odesláno
                    </span>
                @else
                    <span
                        class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full text-sm font-bold bg-yellow-50 text-yellow-700 border border-yellow-200 shadow-sm">
                        <span class="w-2 h-2 rounded-full bg-yellow-500"></span> Rozpracováno
                    </span>
                @endif
            </div>
        </div>

        <div
            class="bg-white/80 backdrop-blur-xl rounded-3xl shadow-sm border border-white/60 p-6 sm:p-8 ring-1 ring-black/5 mb-6">
            <h2 class="text-xl font-bold text-gray-900 mb-6 pb-4 border-b border-gray-100 flex items-center gap-2">
                <span class="material-symbols-rounded text-school-primary">person</span>
                Osobní a kontaktní údaje
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-12 gap-y-5">
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wide mb-1">Jméno a příjmení</p>
                    <p class="text-sm font-semibold text-gray-900">{{ $application->first_name }}
                        {{ $application->last_name }}</p>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wide mb-1">Pohlaví</p>
                    <p class="text-sm font-semibold text-gray-900">{{ $application->gender ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wide mb-1">Rodné číslo</p>
                    <p class="text-sm font-semibold text-gray-900 font-mono">{{ $application->birth_number ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wide mb-1">Datum a místo narození</p>
                    <p class="text-sm font-semibold text-gray-900">
                        {{ $application->birth_date ? \Carbon\Carbon::parse($application->birth_date)->format('d. m. Y') : '—' }},
                        {{ $application->birth_city ?? '—' }}
                    </p>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wide mb-1">Státní občanství</p>
                    <p class="text-sm font-semibold text-gray-900">{{ $application->citizenship ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wide mb-1">Adresa trvalého bydliště</p>
                    <p class="text-sm font-semibold text-gray-900 leading-relaxed">
                        {{ $application->street ?? '—' }}<br>
                        {{ $application->zip }} {{ $application->city }}<br>
                        {{ $application->country }}
                    </p>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wide mb-1">E-mail</p>
                    <p class="text-sm font-semibold text-gray-900">{{ $application->email ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wide mb-1">Telefon</p>
                    <p class="text-sm font-semibold text-gray-900">{{ $application->phone ?? '—' }}</p>
                </div>
            </div>
        </div>

        <div
            class="bg-white/80 backdrop-blur-xl rounded-3xl shadow-sm border border-white/60 p-6 sm:p-8 ring-1 ring-black/5 mb-6">
            <h2 class="text-xl font-bold text-gray-900 mb-6 pb-4 border-b border-gray-100 flex items-center gap-2">
                <span class="material-symbols-rounded text-school-primary">school</span>
                Předchozí vzdělání
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-12 gap-y-5">
                <div class="sm:col-span-2">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wide mb-1">Název střední školy</p>
                    <p class="text-sm font-semibold text-gray-900">{{ $application->previous_school ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wide mb-1">IZO školy</p>
                    <p class="text-sm font-semibold text-gray-900 font-mono">{{ $application->izo ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wide mb-1">Typ školy</p>
                    <p class="text-sm font-semibold text-gray-900">{{ $application->school_type ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wide mb-1">Obor studia</p>
                    <p class="text-sm font-semibold text-gray-900">{{ $application->previous_study_field ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wide mb-1">Kód oboru (KKOV)</p>
                    <p class="text-sm font-semibold text-gray-900 font-mono">
                        {{ $application->previous_study_field_code ?? '—' }}</p>
                </div>

                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wide mb-1">Rok maturity</p>
                    <p class="text-sm font-semibold text-gray-900">{{ $application->graduation_year ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wide mb-1">Průměr známek</p>
                    <p class="text-sm font-semibold text-gray-900">{{ $application->grade_average ?? '—' }}</p>
                </div>

                @php $maturitaFile = $application->attachments->where('type', 'maturita')->first(); @endphp
                <div class="sm:col-span-2 mt-2">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wide mb-2">Maturitní vysvědčení</p>
                    @if ($maturitaFile)
                        <a href="{{ asset('storage/' . $maturitaFile->disk_path) }}" target="_blank"
                            class="inline-flex items-center gap-3 p-3 bg-white border border-gray-200 rounded-xl hover:shadow-md transition-all group/file w-full sm:w-auto">
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
                            <div class="min-w-0 pr-4">
                                <p
                                    class="text-sm font-bold text-gray-900 truncate group-hover/file:text-school-primary transition-colors">
                                    {{ $maturitaFile->filename }}
                                </p>
                                <p class="text-xs text-gray-500">{{ round($maturitaFile->size / 1024) }} KB &bull; Zobrazit
                                </p>
                            </div>
                        </a>
                    @else
                        <div
                            class="flex items-center gap-2 text-orange-700 bg-orange-50 px-4 py-2 rounded-lg border border-orange-100 inline-flex">
                            <span class="material-symbols-rounded text-[18px]">warning</span>
                            <span class="font-bold text-sm">Zatím nenahráno</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div
            class="bg-white/80 backdrop-blur-xl rounded-3xl shadow-sm border border-white/60 p-6 sm:p-8 ring-1 ring-black/5 mb-8">
            <h2 class="text-xl font-bold text-gray-900 mb-6 pb-4 border-b border-gray-100 flex items-center gap-2">
                <span class="material-symbols-rounded text-school-primary">feed</span>
                Doplňující informace
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-12 gap-y-5">
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wide mb-1">Specifické potřeby</p>
                    <p class="text-sm text-gray-900 leading-relaxed">{{ $application->specific_needs ?: '—' }}</p>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wide mb-1">Poznámka</p>
                    <p class="text-sm text-gray-900 leading-relaxed">{{ $application->note ?: '—' }}</p>
                </div>

                @php $otherFiles = $application->attachments->where('type', 'other'); @endphp
                @if ($otherFiles->isNotEmpty())
                    <div class="sm:col-span-2 mt-2">
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
                                    <div class="min-w-0 pr-4">
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
    </div>
@endsection
