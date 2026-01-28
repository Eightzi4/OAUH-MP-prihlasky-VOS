@extends('layouts.application')

@section('form-content')
    <form action="{{ route('application.storeStep2', $application->id) }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="bg-white/80 backdrop-blur-xl rounded-3xl shadow-sm border border-white/60 p-8 ring-1 ring-black/5 mb-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-2">Předchozí vzdělání</h2>
            <p class="text-sm text-gray-500 mb-8">Vyplňte údaje o střední škole a nahrajte maturitní vysvědčení.</p>

            <div class="grid grid-cols-1 gap-6">

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">
                        Název střední školy *
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="material-symbols-rounded text-gray-400 text-[20px]">school</span>
                        </div>
                        <input type="text" name="previous_school"
                            value="{{ old('previous_school', $application->details->previous_school) }}"
                            placeholder="Např. Obchodní akademie Uherské Hradiště"
                            class="w-full rounded-xl border-gray-300 shadow-sm focus:border-school-primary focus:ring-school-primary bg-white/50 placeholder-gray-400 py-3 pl-10 pr-4 transition-all">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">
                            Obor studia *
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="material-symbols-rounded text-gray-400 text-[20px]">menu_book</span>
                            </div>
                            <input type="text" name="previous_study_field"
                                value="{{ old('previous_study_field', $application->details->previous_study_field) }}"
                                placeholder="Např. Ekonomické lyceum"
                                class="w-full rounded-xl border-gray-300 shadow-sm focus:border-school-primary focus:ring-school-primary bg-white/50 placeholder-gray-400 py-3 pl-10 pr-4 transition-all">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">
                                Rok maturity *
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="material-symbols-rounded text-gray-400 text-[20px]">calendar_month</span>
                                </div>
                                <input type="text" name="graduation_year"
                                    value="{{ old('graduation_year', $application->details->graduation_year) }}"
                                    placeholder="2025"
                                    class="w-full rounded-xl border-gray-300 shadow-sm focus:border-school-primary focus:ring-school-primary bg-white/50 placeholder-gray-400 py-3 pl-10 pr-4 transition-all">
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">
                                Průměr známek *
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="material-symbols-rounded text-gray-400 text-[20px]">functions</span>
                                </div>
                                <input type="text" name="grade_average"
                                    value="{{ old('grade_average', $application->details->grade_average) }}"
                                    placeholder="1.50"
                                    class="w-full rounded-xl border-gray-300 shadow-sm focus:border-school-primary focus:ring-school-primary bg-white/50 placeholder-gray-400 py-3 pl-10 pr-4 transition-all">
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="bg-white/80 backdrop-blur-xl rounded-3xl shadow-sm border border-white/60 p-8 ring-1 ring-black/5 mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-2">Maturitní vysvědčení</h2>
            <p class="text-sm text-gray-500 mb-6">Nahrajte sken maturitního vysvědčení (PDF, JPG, PNG). Pokud ještě nemáte
                odmaturováno, můžete nahrát později.</p>

            <div class="relative group cursor-pointer">
                <input type="file" name="maturita_file" id="maturita_file"
                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">

                <div
                    class="border-2 border-dashed border-gray-300 rounded-2xl p-8 text-center transition-all group-hover:border-school-primary group-hover:bg-red-50/30 flex flex-col items-center justify-center">
                    <div
                        class="h-12 w-12 bg-gray-100 rounded-full flex items-center justify-center mb-3 group-hover:bg-white text-gray-400 group-hover:text-school-primary transition-colors">
                        <span class="material-symbols-rounded text-[24px]">cloud_upload</span>
                    </div>
                    <p class="text-sm font-bold text-gray-700 group-hover:text-school-primary transition-colors">
                        Klikněte pro výběr souboru nebo jej přetáhněte sem
                    </p>
                    <p class="text-xs text-gray-400 mt-1">
                        Maximální velikost 10 MB.
                    </p>
                    @if ($application->details->maturita_file_path)
                        <div
                            class="mt-4 flex items-center gap-2 text-sm text-green-600 font-bold bg-green-50 px-3 py-1 rounded-lg">
                            <span class="material-symbols-rounded text-[18px]">check</span>
                            Soubor již byl nahrán
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="bg-white/80 backdrop-blur-xl rounded-3xl shadow-sm border border-white/60 p-4 ring-1 ring-black/5">
            <div class="flex justify-between items-center">

                <a href="{{ route('application.step1', $application->id) }}"
                    class="group relative flex items-center justify-center px-6 py-3 rounded-xl overflow-hidden transition-all duration-300 hover:bg-gray-100">
                    <span
                        class="relative z-10 text-gray-600 font-bold text-sm flex items-center group-hover:text-gray-900 transition-colors">
                        <span
                            class="material-symbols-rounded mr-2 text-[18px] transition-transform duration-300 group-hover:-translate-x-1">arrow_back</span>
                        Zpět na osobní údaje
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
