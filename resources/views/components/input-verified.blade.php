@props(['name', 'label', 'icon', 'value', 'placeholder' => '', 'niaValue' => null])

@php
    $isVerified = $niaValue && $value == $niaValue;
@endphp

<div>
    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">
        {{ $label }}
    </label>

    <div class="relative">
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <span class="material-symbols-rounded text-gray-400 text-[20px]">{{ $icon }}</span>
        </div>

        <input type="text" name="{{ $name }}" value="{{ $value }}"
               placeholder="{{ $placeholder }}"
               @if($isVerified) readonly @endif
               class="w-full rounded-xl border shadow-sm focus:border-school-primary focus:ring-school-primary py-3 pl-10 pr-4 transition-all
               @if($isVerified)
                   bg-gray-50 border-gray-200 text-gray-500 cursor-not-allowed focus:ring-0
               @else
                   bg-white/50 border-gray-200 text-gray-900 placeholder-gray-400
               @endif
               @error($name) border-red-500 @enderror">

        @if($isVerified)
            <p class="text-blue-600 text-xs mt-1.5 ml-1 font-bold flex items-center gap-1 absolute -bottom-6 left-0">
                <span class="material-symbols-rounded text-[14px]">verified</span> Ověřeno pomocí NIA ID
            </p>
        @endif
    </div>

    @error($name)
        <div class="flex items-center gap-1 mt-1.5 ml-1 text-red-500">
            <span class="material-symbols-rounded text-[16px]">error</span>
            <p class="text-xs">{{ $message }}</p>
        </div>
    @enderror

    <div class="h-4"></div>
</div>
