@extends('layouts.application')

@section('form-content')
    @php $maturitaFile = $application->attachments->where('type', 'maturita')->first(); @endphp
    @if ($maturitaFile)
        <form id="delete-file-{{ $maturitaFile->id }}"
            action="{{ route('application.deleteAttachment', ['id' => $application->id, 'attachmentId' => $maturitaFile->id]) }}"
            method="POST" class="hidden">
            @csrf @method('DELETE')
        </form>
    @endif
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
                    @error('previous_school')
                        <p class="text-red-500 text-xs mt-1 ml-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">
                            IZO školy *
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="material-symbols-rounded text-gray-400 text-[20px]">pin</span>
                            </div>
                            <input type="text" name="izo" value="{{ old('izo', $application->details->izo) }}"
                                placeholder="60371731"
                                class="w-full rounded-xl border-gray-300 shadow-sm focus:border-school-primary focus:ring-school-primary bg-white/50 placeholder-gray-400 py-3 pl-10 pr-4 transition-all">
                        </div>
                        @error('izo')
                            <p class="text-red-500 text-xs mt-1 ml-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">
                            Typ školy *
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="material-symbols-rounded text-gray-400 text-[20px]">apartment</span>
                            </div>
                            <select name="school_type"
                                class="w-full appearance-none rounded-xl border-gray-300 shadow-sm focus:border-school-primary focus:ring-school-primary bg-white/50 py-3 pl-10 pr-10 transition-all">
                                <option value="" disabled selected>Vyberte typ</option>
                                <option value="GYM"
                                    {{ old('school_type', $application->details->school_type) == 'GYM' ? 'selected' : '' }}>
                                    Gymnázium</option>
                                <option value="SOŠ"
                                    {{ old('school_type', $application->details->school_type) == 'SOŠ' ? 'selected' : '' }}>
                                    SOŠ (Střední odborná škola)</option>
                                <option value="SOU"
                                    {{ old('school_type', $application->details->school_type) == 'SOU' ? 'selected' : '' }}>
                                    SOU (Střední odborné učiliště)</option>
                                <option value="Jiné"
                                    {{ old('school_type', $application->details->school_type) == 'Jiné' ? 'selected' : '' }}>
                                    Jiné</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                                <span class="material-symbols-rounded text-gray-500">expand_more</span>
                            </div>
                        </div>
                        @error('school_type')
                            <p class="text-red-500 text-xs mt-1 ml-1">{{ $message }}</p>
                        @enderror
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
                        @error('previous_study_field')
                            <p class="text-red-500 text-xs mt-1 ml-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">
                            Kód oboru (KKOV) *
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="material-symbols-rounded text-gray-400 text-[20px]">tag</span>
                            </div>
                            <input type="text" name="previous_study_field_code"
                                value="{{ old('previous_study_field_code', $application->details->previous_study_field_code) }}"
                                placeholder="18-20-M/01"
                                class="w-full rounded-xl border-gray-300 shadow-sm focus:border-school-primary focus:ring-school-primary bg-white/50 placeholder-gray-400 py-3 pl-10 pr-4 transition-all">
                        </div>
                        @error('previous_study_field_code')
                            <p class="text-red-500 text-xs mt-1 ml-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-6">
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
                        @error('graduation_year')
                            <p class="text-red-500 text-xs mt-1 ml-1">{{ $message }}</p>
                        @enderror
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
                                value="{{ old('grade_average', $application->details->grade_average) }}" placeholder="1.50"
                                class="w-full rounded-xl border-gray-300 shadow-sm focus:border-school-primary focus:ring-school-primary bg-white/50 placeholder-gray-400 py-3 pl-10 pr-4 transition-all">
                        </div>
                        @error('grade_average')
                            <p class="text-red-500 text-xs mt-1 ml-1">{{ $message }}</p>
                        @enderror
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
                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" onchange="updateFileName(this)">

                <div
                    class="border-2 border-dashed rounded-2xl p-8 text-center transition-all group-hover:border-school-primary group-hover:bg-red-50/30 flex flex-col items-center justify-center @error('maturita_file') border-red-500 bg-red-50/10 @else border-gray-300 @enderror">
                    <div
                        class="h-12 w-12 bg-gray-100 rounded-full flex items-center justify-center mb-3 group-hover:bg-white text-gray-400 group-hover:text-school-primary transition-colors">
                        <span class="material-symbols-rounded text-[24px]">cloud_upload</span>
                    </div>
                    <p id="upload-text"
                        class="text-sm font-bold text-gray-700 group-hover:text-school-primary transition-colors">
                        Klikněte pro výběr souboru nebo jej přetáhněte sem
                    </p>
                </div>
            </div>

            @if ($maturitaFile)
                <div class="mt-4 flex items-center justify-between p-3 bg-white/60 border border-gray-200 rounded-xl">
                    <div class="flex items-center gap-3">
                        <div class="h-10 w-10 bg-red-50 rounded-lg flex items-center justify-center text-school-primary">
                            <span class="material-symbols-rounded">description</span>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-gray-900 truncate max-w-[200px]">
                                {{ $maturitaFile->filename }}</p>
                            <p class="text-xs text-gray-500">{{ round($maturitaFile->size / 1024) }} KB</p>
                        </div>
                    </div>

                    <button form="delete-file-{{ $maturitaFile->id }}"
                        class="text-gray-400 hover:text-red-500 transition-colors p-2 z-20 relative cursor-pointer">
                        <span class="material-symbols-rounded">delete</span>
                    </button>
                </div>
            @endif
        </div>

        <script>
            function updateFileName(input) {
                const textElement = document.getElementById('upload-text');
                if (input.files && input.files[0]) {
                    textElement.innerText = "Vybráno: " + input.files[0].name;
                    textElement.classList.add('text-school-primary');
                }
            }
        </script>

        <div class="bg-white/80 backdrop-blur-xl rounded-3xl shadow-sm border border-white/60 p-4 ring-1 ring-black/5">
            <div class="flex justify-between items-center">

                <button type="submit" name="go_back" value="1"
                    class="group relative flex items-center justify-center px-6 py-3 rounded-xl overflow-hidden transition-all duration-300 hover:bg-gray-100 cursor-pointer bg-transparent border-none">
                    <span
                        class="relative z-10 text-gray-600 font-bold text-sm flex items-center group-hover:text-gray-900 transition-colors">
                        <span
                            class="material-symbols-rounded mr-2 text-[18px] transition-transform duration-300 group-hover:-translate-x-1">arrow_back</span>
                        Zpět na osobní údaje
                    </span>
                </button>

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
