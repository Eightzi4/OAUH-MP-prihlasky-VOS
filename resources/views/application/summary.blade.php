@extends('layouts.application')

@section('form-content')
    <form action="{{ route('application.submit', $application->id) }}" method="POST">
        @csrf

        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Souhrn přihlášky</h1>
            <p class="text-gray-500">
                Prosím, pečlivě zkontrolujte všechny zadané údaje. Po odeslání již nebude možné přihlášku editovat.
            </p>
        </div>

        <div
            class="bg-white/80 backdrop-blur-xl rounded-3xl shadow-sm border border-white/60 p-8 ring-1 ring-black/5 mb-6 relative group">
            <div class="flex justify-between items-start mb-6 border-b border-gray-100 pb-4">
                <h2 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                    <span class="material-symbols-rounded text-school-primary">person</span>
                    Osobní a kontaktní údaje
                </h2>
                <a href="{{ route('application.step1', $application->id) }}"
                    class="text-xs font-bold text-gray-400 uppercase hover:text-school-primary transition-colors flex items-center gap-1">
                    <span class="material-symbols-rounded text-[16px]">edit</span> Upravit
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-y-6 gap-x-12">
                <div>
                    <span class="block text-xs font-bold text-gray-400 uppercase tracking-wide mb-1">Jméno a příjmení</span>
                    <span class="text-base font-semibold text-gray-900">{{ $application->details->first_name }}
                        {{ $application->details->last_name }}</span>
                </div>
                <div>
                    <span class="block text-xs font-bold text-gray-400 uppercase tracking-wide mb-1">Rodné číslo</span>
                    <span class="text-base font-semibold text-gray-900">{{ $application->details->birth_number }}</span>
                </div>
                <div>
                    <span class="block text-xs font-bold text-gray-400 uppercase tracking-wide mb-1">Datum a místo
                        narození</span>
                    <span class="text-base font-semibold text-gray-900">
                        {{ \Carbon\Carbon::parse($application->details->birth_date)->format('d. m. Y') }},
                        {{ $application->details->birth_city }}
                    </span>
                </div>
                <div>
                    <span class="block text-xs font-bold text-gray-400 uppercase tracking-wide mb-1">Státní občanství</span>
                    <span class="text-base font-semibold text-gray-900">{{ $application->details->citizenship }}</span>
                </div>
                <div>
                    <span class="block text-xs font-bold text-gray-400 uppercase tracking-wide mb-1">Email a Telefon</span>
                    <span class="text-base font-semibold text-gray-900 block">{{ $application->details->email }}</span>
                    <span class="text-base font-semibold text-gray-900 block">{{ $application->details->phone }}</span>
                </div>
                <div>
                    <span class="block text-xs font-bold text-gray-400 uppercase tracking-wide mb-1">Adresa trvalého
                        bydliště</span>
                    <span class="text-base font-semibold text-gray-900">
                        {{ $application->details->street }}<br>
                        {{ $application->details->zip }} {{ $application->details->city }}
                    </span>
                </div>
            </div>
        </div>

        <div
            class="bg-white/80 backdrop-blur-xl rounded-3xl shadow-sm border border-white/60 p-8 ring-1 ring-black/5 mb-6 relative">
            <div class="flex justify-between items-start mb-6 border-b border-gray-100 pb-4">
                <h2 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                    <span class="material-symbols-rounded text-school-primary">school</span>
                    Předchozí vzdělání
                </h2>
                <a href="{{ route('application.step2', $application->id) }}"
                    class="text-xs font-bold text-gray-400 uppercase hover:text-school-primary transition-colors flex items-center gap-1">
                    <span class="material-symbols-rounded text-[16px]">edit</span> Upravit
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-y-6 gap-x-12">
                <div class="md:col-span-2">
                    <span class="block text-xs font-bold text-gray-400 uppercase tracking-wide mb-1">Střední škola</span>
                    <span class="text-base font-semibold text-gray-900">{{ $application->details->previous_school }}</span>
                    <div class="text-sm text-gray-500 mt-1 flex gap-4">
                        <span>IZO: {{ $application->details->izo }}</span>
                        <span>Typ: {{ $application->details->school_type }}</span>
                    </div>
                </div>
                <div>
                    <span class="block text-xs font-bold text-gray-400 uppercase tracking-wide mb-1">Obor studia</span>
                    <span
                        class="text-base font-semibold text-gray-900">{{ $application->details->previous_study_field }}</span>
                    <span class="text-sm text-gray-500 block">Kód:
                        {{ $application->details->previous_study_field_code }}</span>
                </div>
                <div>
                    <span class="block text-xs font-bold text-gray-400 uppercase tracking-wide mb-1">Maturita</span>
                    <span class="text-base font-semibold text-gray-900">Rok:
                        {{ $application->details->graduation_year }}</span>
                    <span class="text-base font-semibold text-gray-900 block">Průměr:
                        {{ $application->details->grade_average }}</span>
                </div>
                <div class="md:col-span-2">
                    <span class="block text-xs font-bold text-gray-400 uppercase tracking-wide mb-2">Nahrané
                        vysvědčení</span>
                    @if ($application->details->maturita_file_path)
                        <div
                            class="flex items-center gap-2 text-green-700 bg-green-50 px-4 py-2 rounded-lg border border-green-100 inline-flex">
                            <span class="material-symbols-rounded">description</span>
                            <span class="font-bold text-sm">Maturitní vysvědčení nahráno</span>
                        </div>
                    @else
                        <div
                            class="flex items-center gap-2 text-orange-700 bg-orange-50 px-4 py-2 rounded-lg border border-orange-100 inline-flex">
                            <span class="material-symbols-rounded">warning</span>
                            <span class="font-bold text-sm">Nenahráno (nutno doložit později)</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div
            class="bg-white/80 backdrop-blur-xl rounded-3xl shadow-sm border border-white/60 p-8 ring-1 ring-black/5 mb-8 relative">
            <div class="flex justify-between items-start mb-6 border-b border-gray-100 pb-4">
                <h2 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                    <span class="material-symbols-rounded text-school-primary">feed</span>
                    Doplňující informace
                </h2>
                <a href="{{ route('application.step3', $application->id) }}"
                    class="text-xs font-bold text-gray-400 uppercase hover:text-school-primary transition-colors flex items-center gap-1">
                    <span class="material-symbols-rounded text-[16px]">edit</span> Upravit
                </a>
            </div>

            <div class="space-y-6">
                <div>
                    <span class="block text-xs font-bold text-gray-400 uppercase tracking-wide mb-1">Specifické
                        potřeby</span>
                    <p class="text-sm text-gray-700 leading-relaxed">
                        {{ $application->details->specific_needs ?? 'Neuvedeno' }}</p>
                </div>
                <div>
                    <span class="block text-xs font-bold text-gray-400 uppercase tracking-wide mb-1">Poznámka</span>
                    <p class="text-sm text-gray-700 leading-relaxed">{{ $application->details->note ?? 'Bez poznámky' }}
                    </p>
                </div>
                @if ($application->details->other_file_path)
                    <div>
                        <span class="block text-xs font-bold text-gray-400 uppercase tracking-wide mb-2">Další
                            přílohy</span>
                        <div
                            class="flex items-center gap-2 text-gray-700 bg-gray-50 px-4 py-2 rounded-lg border border-gray-200 inline-flex">
                            <span class="material-symbols-rounded">attach_file</span>
                            <span class="font-bold text-sm">Příloha nahrána</span>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <div class="bg-school-primary/5 rounded-3xl p-8 border border-school-primary/10 mb-8">
            <label class="flex items-start gap-4 cursor-pointer group">
                <div class="relative flex items-center">
                    <input type="checkbox" name="consent" required
                        class="peer h-6 w-6 cursor-pointer appearance-none rounded-md border-2 border-gray-300 bg-white transition-all checked:border-school-primary checked:bg-school-primary hover:border-school-primary">
                    <span
                        class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 text-white opacity-0 peer-checked:opacity-100">
                        <span class="material-symbols-rounded text-[18px] font-bold">check</span>
                    </span>
                </div>
                <div class="text-sm text-gray-700 leading-relaxed pt-0.5">
                    <span class="font-bold text-gray-900">Potvrzuji správnost a pravdivost údajů</span>
                    <br>
                    Prohlašuji, že všechny uvedené údaje v této přihlášce jsou pravdivé a úplné. Jsem si vědom(a) právních
                    následků uvedení nepravdivých údajů. Souhlasím se zpracováním osobních údajů pro účely přijímacího
                    řízení v souladu s GDPR.
                </div>
            </label>
            @error('consent')
                <p class="text-red-500 text-xs mt-2 ml-10">Musíte potvrdit souhlas se zpracováním údajů.</p>
            @enderror
        </div>

        <div class="bg-white/80 backdrop-blur-xl rounded-3xl shadow-sm border border-white/60 p-4 ring-1 ring-black/5">
            <div class="flex justify-between items-center">

                <a href="{{ route('application.step3', $application->id) }}"
                    class="group relative flex items-center justify-center px-6 py-3 rounded-xl overflow-hidden transition-all duration-300 hover:bg-gray-100">
                    <span
                        class="relative z-10 text-gray-600 font-bold text-sm flex items-center group-hover:text-gray-900 transition-colors">
                        <span
                            class="material-symbols-rounded mr-2 text-[18px] transition-transform duration-300 group-hover:-translate-x-1">arrow_back</span>
                        Zpět
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
                        Odeslat přihlášku
                        <span
                            class="material-symbols-rounded ml-3 text-[20px] text-school-primary transition-transform duration-300 group-hover:translate-x-1">send</span>
                    </span>
                </button>
            </div>
        </div>

    </form>
@endsection
