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

        <div class="bg-white/80 backdrop-blur-xl rounded-3xl shadow-sm border border-white/60 p-8 ring-1 ring-black/5 mb-8"
            x-data="fileUploader({ maxAttachments: 1 })">

            <h2 class="text-2xl font-bold text-gray-900 mb-2">Maturitní vysvědčení</h2>
            <p class="text-sm text-gray-500 mb-6">Nahrajte sken maturitního vysvědčení (PDF, JPG, PNG).</p>

            <div class="relative group cursor-pointer transition-all duration-300"
                x-show="selectedFiles.length === 0 @if ($maturitaFile) && false @endif"
                x-bind:class="{ 'bg-red-50/50 border-school-primary ring-2 ring-school-primary/20': isDragging, 'hover:border-school-primary hover:bg-red-50/30':
                        !isDragging }"
                @dragover.prevent="isDragging = true" @dragleave.prevent="isDragging = false"
                @drop.prevent="isDragging = false; handleFiles($event.dataTransfer.files)" @click="$refs.fileInput.click()">

                <input type="file" name="maturita_file" x-ref="fileInput" class="hidden" accept=".pdf,.jpg,.jpeg,.png"
                    @change="handleFiles($event.target.files)">

                <div class="border-2 border-dashed border-gray-300 rounded-2xl p-8 text-center flex flex-col items-center justify-center transition-colors"
                    x-bind:class="{ 'border-transparent': isDragging }">

                    <div class="h-12 w-12 bg-gray-100 rounded-full flex items-center justify-center mb-3 text-gray-400 transition-colors"
                        x-bind:class="{ 'bg-white text-school-primary': isDragging }">
                        <span class="material-symbols-rounded text-[24px]">cloud_upload</span>
                    </div>

                    <p class="text-sm font-bold text-gray-700 transition-colors"
                        x-bind:class="{ 'text-school-primary': isDragging }">
                        <span x-show="!isDragging">Klikněte pro výběr souboru nebo jej přetáhněte sem</span>
                        <span x-show="isDragging">Pusťte soubor zde</span>
                    </p>
                    <p class="text-xs text-gray-400 mt-1">Maximální velikost 10 MB.</p>
                </div>
            </div>

            @error('maturita_file')
                <p class="text-red-500 text-xs mt-2 ml-1">{{ $message }}</p>
            @enderror

            <div class="mt-4 space-y-2" x-show="selectedFiles.length > 0">
                <template x-for="file in selectedFiles" :key="file.id">
                    <div
                        class="flex items-center justify-between p-3 bg-white border border-gray-200 rounded-xl shadow-sm">
                        <div class="flex items-center gap-3 overflow-hidden">
                            <template x-if="file.previewUrl">
                                <div class="h-12 w-12 rounded-lg overflow-hidden border border-gray-100 flex-shrink-0">
                                    <img :src="file.previewUrl" class="w-full h-full object-cover">
                                </div>
                            </template>
                            <template x-if="!file.previewUrl">
                                <div
                                    class="h-12 w-12 bg-red-50 rounded-lg flex items-center justify-center text-school-primary flex-shrink-0">
                                    <span class="material-symbols-rounded" x-text="getIcon(file.type)"></span>
                                </div>
                            </template>

                            <div class="min-w-0">
                                <p class="text-sm font-bold text-gray-900 truncate" x-text="file.name"></p>
                                <p class="text-xs text-gray-500">Nový soubor &bull; <span x-text="file.size"></span></p>
                            </div>
                        </div>

                        <button type="button" @click="removeFile(file.id)"
                            class="text-gray-400 hover:text-red-500 transition-colors p-2">
                            <span class="material-symbols-rounded">close</span>
                        </button>
                    </div>
                </template>
            </div>

            @if ($maturitaFile)
                <div x-show="selectedFiles.length === 0" class="mt-0">
                    <div
                        class="p-3 bg-white border border-gray-200 rounded-xl flex items-center justify-between shadow-sm">
                        <a href="{{ asset('storage/' . $maturitaFile->disk_path) }}" target="_blank"
                            class="flex items-center gap-3 overflow-hidden group/file flex-grow">
                            <div
                                class="h-12 w-12 bg-green-50 rounded-lg flex items-center justify-center text-green-600 border border-green-100 flex-shrink-0">
                                <span class="material-symbols-rounded">check_circle</span>
                            </div>
                            <div class="min-w-0">
                                <p
                                    class="text-sm font-bold text-gray-900 truncate group-hover/file:text-green-700 transition-colors">
                                    {{ $maturitaFile->filename }}
                                </p>
                                <p class="text-xs text-green-600">
                                    Soubor nahrán &bull; Klikněte pro zobrazení
                                </p>
                            </div>
                        </a>

                        <button form="delete-file-{{ $maturitaFile->id }}"
                            class="text-gray-400 hover:text-red-500 transition-colors p-2" title="Odstranit soubor">
                            <span class="material-symbols-rounded">delete</span>
                        </button>
                    </div>
                </div>
            @endif

        </div>

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
