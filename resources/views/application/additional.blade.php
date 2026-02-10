@extends('layouts.application')

@section('form-content')

@php
    $otherFiles = $application->attachments->where('type', 'other');
@endphp

@foreach($otherFiles as $file)
    <form id="delete-file-{{ $file->id }}"
          action="{{ route('application.deleteAttachment', ['id' => $application->id, 'attachmentId' => $file->id]) }}"
          method="POST" class="hidden">
        @csrf @method('DELETE')
    </form>
@endforeach

<form action="{{ route('application.storeStep3', $application->id) }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="bg-white/80 backdrop-blur-xl rounded-3xl shadow-sm border border-white/60 p-8 ring-1 ring-black/5 mb-6">
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-900">Specifické potřeby</h2>
            <p class="text-sm text-gray-500 mt-1">Uveďte, pokud vyžadujete specifický přístup (např. zdravotní znevýhodnění, poruchy učení).</p>
        </div>

        <div class="relative">
            <textarea name="specific_needs" rows="3" placeholder="Zde popište své požadavky..."
                      class="w-full rounded-xl border-gray-300 shadow-sm focus:border-school-primary focus:ring-school-primary bg-white/50 placeholder-gray-400 py-3 px-4 transition-all">{{ old('specific_needs', $application->details->specific_needs) }}</textarea>
        </div>
    </div>

    <div class="bg-white/80 backdrop-blur-xl rounded-3xl shadow-sm border border-white/60 p-8 ring-1 ring-black/5 mb-6">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">Poznámka k přihlášce</h2>
        <p class="text-sm text-gray-500 mb-4">Prostor pro jakékoliv další informace, které nám chcete sdělit.</p>

        <div class="relative">
            <textarea name="note" rows="3" placeholder="Vaše poznámka..."
                      class="w-full rounded-xl border-gray-300 shadow-sm focus:border-school-primary focus:ring-school-primary bg-white/50 placeholder-gray-400 py-3 px-4 transition-all">{{ old('note', $application->details->note) }}</textarea>
        </div>
    </div>

    <div class="bg-white/80 backdrop-blur-xl rounded-3xl shadow-sm border border-white/60 p-8 ring-1 ring-black/5 mb-8"
         x-data="fileUploader({ maxAttachments: 10 })">

        <h2 class="text-2xl font-bold text-gray-900 mb-2">Další přílohy</h2>
        <p class="text-sm text-gray-500 mb-6">Zde můžete nahrát další dokumenty (např. certifikáty, potvrzení od lékaře).</p>

        <div class="relative group cursor-pointer transition-all duration-300 mb-4"
             x-bind:class="{'bg-red-50/50 border-school-primary ring-2 ring-school-primary/20': isDragging, 'hover:border-school-primary hover:bg-red-50/30': !isDragging}"
             @dragover.prevent="isDragging = true"
             @dragleave.prevent="isDragging = false"
             @drop.prevent="isDragging = false; handleFiles($event.dataTransfer.files)"
             @click="$refs.fileInput.click()">

            <input type="file" name="other_files[]" x-ref="fileInput" class="hidden" multiple
                   accept=".pdf,.jpg,.jpeg,.png" @change="handleFiles($event.target.files)">

            <div class="border-2 border-dashed border-gray-300 rounded-2xl p-8 text-center flex flex-col items-center justify-center transition-colors"
                 x-bind:class="{'border-transparent': isDragging}">

                <div class="h-12 w-12 bg-gray-100 rounded-full flex items-center justify-center mb-3 text-gray-400 transition-colors"
                     x-bind:class="{'bg-white text-school-primary': isDragging}">
                    <span class="material-symbols-rounded text-[24px]">library_add</span>
                </div>

                <p class="text-sm font-bold text-gray-700 transition-colors" x-bind:class="{'text-school-primary': isDragging}">
                    <span x-show="!isDragging">Klikněte pro přidání souborů nebo je přetáhněte sem</span>
                    <span x-show="isDragging">Pusťte soubory zde</span>
                </p>
                <p class="text-xs text-gray-400 mt-1">PDF, JPG, PNG (Max 10 MB)</p>
            </div>
        </div>

        @error('other_files.*')
            <p class="text-red-500 text-xs mt-2 ml-1">{{ $message }}</p>
        @enderror

        <div class="space-y-2">
            <template x-for="file in selectedFiles" :key="file.id">
                <div class="flex items-center justify-between p-3 bg-white border border-gray-200 rounded-xl shadow-sm">
                    <div class="flex items-center gap-3 overflow-hidden">
                        <template x-if="file.previewUrl">
                            <div class="h-10 w-10 rounded-lg overflow-hidden border border-gray-100 flex-shrink-0">
                                <img :src="file.previewUrl" class="w-full h-full object-cover">
                            </div>
                        </template>
                        <template x-if="!file.previewUrl">
                            <div class="h-10 w-10 bg-red-50 rounded-lg flex items-center justify-center text-school-primary flex-shrink-0">
                                <span class="material-symbols-rounded text-[20px]" x-text="getIcon(file.type)"></span>
                            </div>
                        </template>

                        <div class="min-w-0">
                            <p class="text-sm font-bold text-gray-900 truncate" x-text="file.name"></p>
                            <p class="text-xs text-gray-500">Připraveno k nahrání &bull; <span x-text="file.size"></span></p>
                        </div>
                    </div>
                    <button type="button" @click="removeFile(file.id)" class="text-gray-400 hover:text-red-500 transition-colors p-2">
                        <span class="material-symbols-rounded text-[20px]">close</span>
                    </button>
                </div>
            </template>

            @foreach($otherFiles as $file)
                <div class="flex items-center justify-between p-3 bg-white border border-gray-200 rounded-xl shadow-sm">
                    <a href="{{ asset('storage/' . $file->disk_path) }}" target="_blank" class="flex items-center gap-3 overflow-hidden group/file flex-grow">
                        @if(str_starts_with($file->mime_type, 'image/'))
                            <div class="h-10 w-10 rounded-lg overflow-hidden border border-gray-100 flex-shrink-0 bg-gray-100">
                                <img src="{{ asset('storage/' . $file->disk_path) }}" class="w-full h-full object-cover">
                            </div>
                        @else
                            <div class="h-10 w-10 bg-green-50 rounded-lg flex items-center justify-center text-green-600 border border-green-100 flex-shrink-0">
                                <span class="material-symbols-rounded text-[20px]">check_circle</span>
                            </div>
                        @endif

                        <div class="min-w-0">
                            <p class="text-sm font-bold text-gray-900 truncate group-hover/file:text-school-primary transition-colors">
                                {{ $file->filename }}
                            </p>
                            <p class="text-xs text-green-600">
                                Uloženo &bull; {{ round($file->size / 1024) }} KB
                            </p>
                        </div>
                    </a>

                    <button form="delete-file-{{ $file->id }}" class="text-gray-400 hover:text-red-500 transition-colors p-2" title="Odstranit">
                        <span class="material-symbols-rounded text-[20px]">delete</span>
                    </button>
                </div>
            @endforeach

        </div>
    </div>

    <div class="bg-white/80 backdrop-blur-xl rounded-3xl shadow-sm border border-white/60 p-4 ring-1 ring-black/5">
        <div class="flex justify-between items-center">
            <a href="{{ route('application.step2', $application->id) }}" class="group relative flex items-center justify-center px-6 py-3 rounded-xl overflow-hidden transition-all duration-300 hover:bg-gray-100">
                <span class="relative z-10 text-gray-600 font-bold text-sm flex items-center group-hover:text-gray-900 transition-colors">
                    <span class="material-symbols-rounded mr-2 text-[18px] transition-transform duration-300 group-hover:-translate-x-1">arrow_back</span>
                    Zpět na vzdělání
                </span>
            </a>

            <button type="submit" class="group relative flex items-center justify-center px-8 py-4 rounded-xl overflow-hidden shadow-xl hover:shadow-2xl transition-all duration-300 cursor-pointer">
                <div class="absolute inset-0 topo-bg opacity-50 transition-opacity duration-300"></div>
                <div class="absolute inset-0 bg-white/60 backdrop-blur-[2px] group-hover:backdrop-blur-[4px] transition-all duration-300"></div>
                <div class="absolute inset-0 rounded-xl border border-white/60 border-b-4 border-b-gray-200/50"></div>

                <span class="relative z-10 text-gray-900 font-bold text-lg flex items-center drop-shadow-sm">
                    Přejít na souhrn
                    <span class="material-symbols-rounded ml-3 text-[20px] text-gray-600 group-hover:text-school-primary transition-transform duration-300 group-hover:translate-x-1">arrow_forward</span>
                </span>
            </button>
        </div>
    </div>

</form>

@endsection
