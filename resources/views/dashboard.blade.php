@extends('layouts.app')

@section('title', 'Nástěnka | VOŠ OAUH')

@section('header-right')
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit"
            class="group relative flex items-center justify-center px-4 py-2 rounded-xl overflow-hidden shadow-xl hover:shadow-2xl transition-all duration-300 cursor-pointer">
            <div class="absolute inset-0 topo-bg opacity-50 transition-opacity duration-300"></div>
            <div
                class="absolute inset-0 bg-white/60 backdrop-blur-[2px] group-hover:backdrop-blur-[4px] transition-all duration-300">
            </div>
            <div class="absolute inset-0 rounded-xl border border-white/60 border-b-4 border-b-gray-200/50"></div>

            <span class="relative z-10 text-gray-600 font-bold text-xs flex items-center drop-shadow-sm">
                <span
                    class="material-symbols-rounded mr-2 text-[18px] text-gray-600 group-hover:text-school-primary transition-transform duration-300 group-hover:-translate-x-1">logout</span>
                Odhlásit se
            </span>
        </button>
    </form>
@endsection

@section('content')
    <div class="w-full max-w-5xl mx-auto">
        <div
            class="bg-white/80 backdrop-blur-xl rounded-3xl shadow-sm border border-white/60 overflow-hidden ring-1 ring-black/5 mb-12">
            <div class="px-10 py-6 border-b border-gray-100/80 bg-white/40 flex items-center gap-3">
                <div class="h-8 w-8 rounded-lg bg-red-50 flex items-center justify-center">
                    <span class="material-symbols-rounded text-school-primary">person</span>
                </div>
                <h2 class="font-bold text-gray-800 text-xl">Osobní údaje a nastavení</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2">
                <div class="p-10 border-b md:border-b-0 md:border-r border-gray-200/60 flex flex-col justify-between gap-6">
                    <div>
                        <h2 class="text-xs font-bold text-gray-400 uppercase tracking-wide mb-2">Kontaktní email</h2>
                        <div class="text-xl font-bold text-gray-900 break-all">
                            {{ Auth::user()->email }}
                        </div>
                        <p class="text-sm text-gray-500 mt-2">
                            Emailová adresa, pomocí které se přihlašujete.
                        </p>
                    </div>

                    <div class="pt-4">
                        <button
                            class="group relative flex items-center justify-center px-6 py-3 rounded-xl overflow-hidden shadow-md hover:shadow-lg transition-all duration-300 cursor-pointer w-auto self-start"
                            onclick="openModal('email-modal')">
                            <div class="absolute inset-0 topo-bg opacity-50 transition-opacity duration-300"></div>
                            <div
                                class="absolute inset-0 bg-white/60 backdrop-blur-[2px] group-hover:backdrop-blur-[4px] transition-all duration-300">
                            </div>
                            <div class="absolute inset-0 rounded-xl border border-white/60 border-b-4 border-b-gray-200/50">
                            </div>
                            <span class="relative z-10 text-gray-700 font-bold text-sm flex items-center">
                                <span
                                    class="material-symbols-rounded mr-2 text-[18px] text-gray-500 group-hover:text-school-primary transition-colors">edit</span>
                                Změnit e-mail
                            </span>
                        </button>
                    </div>
                </div>

                <div class="p-10 flex flex-col justify-between gap-6">
                    <div>
                        <h2 class="text-xs font-bold text-gray-400 uppercase tracking-wide mb-2">Heslo k účtu</h2>
                        @if (Auth::user()->password)
                            <div class="flex items-center gap-2 text-green-600 font-bold text-xl">
                                <span class="material-symbols-rounded">check_circle</span>
                                Heslo je nastaveno
                            </div>
                        @else
                            <div class="flex items-center gap-2 text-orange-500 font-bold text-xl">
                                <span class="material-symbols-rounded">warning</span>
                                Heslo není nastaveno
                            </div>
                            <p class="text-sm text-gray-500 mt-2">
                                Bez nastaveného hesla se můžete přihlásit pouze pomocí odkazu v emailu.
                            </p>
                        @endif
                    </div>

                    <div class="pt-4">
                        <button
                            class="group relative flex items-center justify-center px-6 py-3 rounded-xl overflow-hidden shadow-md hover:shadow-lg transition-all duration-300 cursor-pointer w-auto self-start"
                            onclick="openModal('password-modal')">
                            <div class="absolute inset-0 topo-bg opacity-50 transition-opacity duration-300"></div>
                            <div
                                class="absolute inset-0 bg-white/60 backdrop-blur-[2px] group-hover:backdrop-blur-[4px] transition-all duration-300">
                            </div>
                            <div class="absolute inset-0 rounded-xl border border-white/60 border-b-4 border-b-gray-200/50">
                            </div>
                            <span class="relative z-10 text-gray-700 font-bold text-sm flex items-center">
                                <span
                                    class="material-symbols-rounded mr-2 text-[18px] text-gray-500 group-hover:text-school-primary transition-colors">lock_reset</span>
                                {{ Auth::user()->password ? 'Změnit heslo' : 'Vytvořit heslo' }}
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div
            class="bg-white/80 backdrop-blur-xl rounded-3xl shadow-sm border border-white/60 overflow-hidden ring-1 ring-black/5 mb-16">

            <div class="px-10 py-6 border-b border-gray-100/80 bg-white/40 flex items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="h-8 w-8 rounded-lg bg-red-50 flex items-center justify-center">
                        <span class="material-symbols-rounded text-school-primary">description</span>
                    </div>
                    <h2 class="font-bold text-gray-800 text-xl">Moje přihlášky</h2>
                </div>

                @if ($applications->isNotEmpty())
                    <a href="{{ route('programs.index') }}"
                        class="group relative flex items-center justify-center px-5 py-2.5 rounded-xl overflow-hidden shadow-md hover:shadow-lg transition-all duration-300">
                        <div class="absolute inset-0 topo-bg opacity-50 transition-opacity duration-300"></div>
                        <div
                            class="absolute inset-0 bg-white/60 backdrop-blur-[2px] group-hover:backdrop-blur-[4px] transition-all duration-300">
                        </div>
                        <div class="absolute inset-0 rounded-xl border border-white/60 border-b-4 border-b-gray-200/50">
                        </div>

                        <span class="relative z-10 text-gray-900 font-bold text-sm flex items-center">
                            <span
                                class="material-symbols-rounded mr-2 text-[20px] text-gray-600 group-hover:text-school-primary transition-all duration-300 group-hover:rotate-90">add</span>
                            Nová přihláška
                        </span>
                    </a>
                @endif
            </div>

            @if ($applications->isEmpty())
                <div class="p-16 flex flex-col items-center justify-center text-center">
                    <div class="mb-8">
                        <p class="text-gray-500 text-lg mb-2">
                            Zatím jste nepodal(a) žádnou přihlášku ke studiu.
                        </p>
                        <p class="text-gray-400 text-sm">
                            Vyberte si obor z naší nabídky a vyplňte formulář.
                        </p>
                    </div>

                    <a href="{{ route('programs.index') }}"
                        class="group relative flex items-center justify-center px-10 py-5 rounded-xl overflow-hidden shadow-xl hover:shadow-2xl transition-all duration-300 cursor-pointer">
                        <div class="absolute inset-0 topo-bg opacity-50 transition-opacity duration-300"></div>
                        <div
                            class="absolute inset-0 bg-white/60 backdrop-blur-[2px] group-hover:backdrop-blur-[4px] transition-all duration-300">
                        </div>
                        <div class="absolute inset-0 rounded-xl border border-white/60 border-b-4 border-b-gray-200/50">
                        </div>

                        <span class="relative z-10 text-gray-900 font-bold text-xl flex items-center drop-shadow-sm">
                            <span
                                class="material-symbols-rounded mr-3 text-[24px] text-gray-600 group-hover:text-school-primary transition-all duration-300 group-hover:rotate-90">add</span>
                            Podat novou přihlášku
                        </span>
                    </a>
                </div>
            @else
                <div class="p-8 grid grid-cols-1 gap-6">
                    @foreach ($applications as $app)
                        <div
                            class="group relative bg-white/60 backdrop-blur-md rounded-2xl border border-white/60 p-1 flex flex-col sm:flex-row gap-6 transition-all duration-300 hover:shadow-xl hover:bg-white/80 ring-1 ring-black/5 hover:ring-black/10">

                            <div
                                class="relative w-full sm:w-48 h-48 sm:h-auto rounded-xl overflow-hidden flex-shrink-0 shadow-inner">
                                <img src="{{ $app->studyProgram->image_path }}" alt="Obor"
                                    class="absolute inset-0 w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-500">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent sm:hidden"></div>
                                <div class="absolute bottom-3 left-3 sm:hidden">
                                    <span class="text-white font-bold text-sm text-shadow">2025/2026</span>
                                </div>
                            </div>

                            <div class="flex-grow py-4 pr-6 pl-4 sm:pl-0 flex flex-col justify-between">
                                <div>
                                    <div class="flex justify-between items-start mb-2">
                                        <h3
                                            class="text-xl font-bold text-gray-900 group-hover:text-school-primary transition-colors">
                                            {{ $app->studyProgram->name }}
                                        </h3>

                                        @if ($app->status == 'draft')
                                            <span
                                                class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-yellow-50 text-yellow-700 border border-yellow-200 shadow-sm">
                                                <span class="w-1.5 h-1.5 rounded-full bg-yellow-500 animate-pulse"></span>
                                                Rozpracováno
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-green-50 text-green-700 border border-green-200 shadow-sm">
                                                <span class="material-symbols-rounded text-[16px]">check_circle</span>
                                                Odesláno
                                            </span>
                                        @endif
                                    </div>

                                    <div class="text-sm text-gray-500 space-y-2 mb-4">
                                        <p class="flex items-center gap-2">
                                            <span
                                                class="material-symbols-rounded text-[18px] text-gray-400">calendar_month</span>
                                            Akaemický rok {{ date('Y') }}/{{ date('Y') + 1 }}
                                        </p>
                                        <p class="flex items-center gap-2">
                                            <span class="material-symbols-rounded text-[18px] text-gray-400">school</span>
                                            {{ $app->studyProgram->form }} forma
                                        </p>
                                        @if ($app->status == 'submitted')
                                            <p
                                                class="flex items-center gap-2 text-gray-900 font-bold bg-gray-50 px-2 py-1 rounded-lg w-fit mt-2">
                                                <span
                                                    class="material-symbols-rounded text-[18px] text-school-primary">tag</span>
                                                Číslo přihlášky: {{ $app->application_number }}
                                            </p>
                                        @endif
                                    </div>
                                </div>

                                <div class="flex justify-end pt-4 border-t border-gray-200/50">
                                    @if ($app->status == 'draft')
                                        <a href="{{ route('application.step1', $app->id) }}"
                                            class="group/btn relative flex items-center justify-center px-6 py-3 rounded-xl overflow-hidden shadow-md hover:shadow-lg transition-all duration-300 cursor-pointer">
                                            <div
                                                class="absolute inset-0 topo-bg opacity-50 transition-opacity duration-300">
                                            </div>
                                            <div
                                                class="absolute inset-0 bg-white/60 backdrop-blur-[2px] group-hover/btn:backdrop-blur-[4px] transition-all duration-300">
                                            </div>
                                            <div
                                                class="absolute inset-0 rounded-xl border border-white/60 border-b-4 border-b-gray-200/50">
                                            </div>

                                            <span class="relative z-10 text-gray-900 font-bold text-sm flex items-center">
                                                Dokončit přihlášku
                                                <span
                                                    class="material-symbols-rounded ml-2 text-[20px] text-gray-600 group-hover/btn:text-school-primary transition-transform duration-300 group-hover/btn:translate-x-1">arrow_forward</span>
                                            </span>
                                        </a>
                                    @else
                                        <a href="{{ route('application.step4', $app->id) }}"
                                            class="group/btn relative flex items-center justify-center px-6 py-3 rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-all duration-300 border border-transparent hover:border-gray-200">
                                            <div
                                                class="absolute inset-0 bg-white/40 backdrop-blur-sm opacity-0 group-hover/btn:opacity-100 transition-opacity">
                                            </div>

                                            <span
                                                class="relative z-10 text-gray-600 group-hover/btn:text-school-primary font-bold text-sm flex items-center transition-colors">
                                                <span class="material-symbols-rounded mr-2 text-[20px]">visibility</span>
                                                Zobrazit detail
                                            </span>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            <div class="border-t border-gray-200/60 p-10 bg-gray-50/30 text-center">
                <p class="text-sm text-gray-500 font-medium mb-4">
                    Máte problém s účtem nebo přihláškou? Kontaktujte studijní oddělení, rádi vám pomůžeme.
                </p>

                <div class="flex flex-col sm:flex-row justify-center gap-2 sm:gap-6 text-base">
                    <a href="mailto:info@oauh.cz"
                        class="text-school-primary hover:text-school-hover font-semibold transition-colors flex items-center justify-center gap-2">
                        <span class="material-symbols-rounded text-[18px]">mail</span>
                        info@oauh.cz
                    </a>
                    <a href="tel:+420572433012"
                        class="text-school-primary hover:text-school-hover font-semibold transition-colors flex items-center justify-center gap-2">
                        <span class="material-symbols-rounded text-[18px]">call</span>
                        +420 572 433 012
                    </a>
                </div>
            </div>

        </div>
    </div>

    <div id="email-modal" class="fixed inset-0 z-50 hidden">
        <div class="absolute inset-0 bg-gray-900/40 backdrop-blur-sm transition-opacity"
            onclick="closeModal('email-modal')"></div>

        <div class="relative min-h-screen flex items-center justify-center p-4">
            <div
                class="bg-white/90 backdrop-blur-xl rounded-3xl shadow-2xl w-full max-w-md p-8 relative overflow-hidden border border-white/60 ring-1 ring-black/5 animate-scale-in">
                <button type="button" onclick="closeModal('email-modal')"
                    class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition-colors">
                    <span class="material-symbols-rounded text-[24px]">close</span>
                </button>

                <h2 class="text-2xl font-bold text-gray-900 mb-6">Změna e-mailu</h2>

                <form action="{{ route('profile.email') }}" method="POST">
                    @csrf
                    <div class="mb-8">
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">Nový
                            e-mail</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="material-symbols-rounded text-gray-400 text-[20px]">alternate_email</span>
                            </div>
                            <input type="email" name="email" required value="{{ Auth::user()->email }}"
                                class="w-full rounded-xl border-gray-300 shadow-sm focus:border-school-primary focus:ring-school-primary bg-white/50 pl-10 py-3 transition-all placeholder-gray-400">
                        </div>
                        @error('email')
                            <p class="text-red-500 text-xs mt-2 ml-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit"
                        class="group relative w-full flex items-center justify-center px-8 py-4 rounded-xl overflow-hidden shadow-xl hover:shadow-2xl transition-all duration-300 cursor-pointer">
                        <div class="absolute inset-0 topo-bg opacity-50 transition-opacity duration-300"></div>
                        <div
                            class="absolute inset-0 bg-white/60 backdrop-blur-[2px] group-hover:backdrop-blur-[4px] transition-all duration-300">
                        </div>
                        <div class="absolute inset-0 rounded-xl border border-white/60 border-b-4 border-b-gray-200/50">
                        </div>

                        <span class="relative z-10 text-gray-900 font-bold text-lg flex items-center drop-shadow-sm">
                            <span
                                class="material-symbols-rounded mr-3 text-[20px] text-gray-600 group-hover:text-school-primary transition-colors duration-300">save</span>
                            Uložit změny
                        </span>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div id="password-modal" class="fixed inset-0 z-50 hidden">
        <div class="absolute inset-0 bg-gray-900/40 backdrop-blur-sm transition-opacity"
            onclick="closeModal('password-modal')"></div>

        <div class="relative min-h-screen flex items-center justify-center p-4">
            <div
                class="bg-white/90 backdrop-blur-xl rounded-3xl shadow-2xl w-full max-w-md p-8 relative overflow-hidden border border-white/60 ring-1 ring-black/5 animate-scale-in">
                <button type="button" onclick="closeModal('password-modal')"
                    class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition-colors">
                    <span class="material-symbols-rounded text-[24px]">close</span>
                </button>

                <h2 class="text-2xl font-bold text-gray-900 mb-6">
                    {{ Auth::user()->password ? 'Změna hesla' : 'Nastavení hesla' }}
                </h2>

                <form action="{{ route('profile.password') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">Nové
                            heslo</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="material-symbols-rounded text-gray-400 text-[20px]">lock</span>
                            </div>
                            <input type="password" name="password" required minlength="8"
                                placeholder="Minimálně 8 znaků"
                                class="w-full rounded-xl border-gray-300 shadow-sm focus:border-school-primary focus:ring-school-primary bg-white/50 pl-10 py-3 transition-all placeholder-gray-400">
                        </div>
                        @error('password')
                            <p class="text-red-500 text-xs mt-2 ml-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-8">
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">Potvrzení
                            hesla</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="material-symbols-rounded text-gray-400 text-[20px]">lock_reset</span>
                            </div>
                            <input type="password" name="password_confirmation" required minlength="8"
                                placeholder="Zadejte heslo znovu"
                                class="w-full rounded-xl border-gray-300 shadow-sm focus:border-school-primary focus:ring-school-primary bg-white/50 pl-10 py-3 transition-all placeholder-gray-400">
                        </div>
                    </div>

                    <button type="submit"
                        class="group relative w-full flex items-center justify-center px-8 py-4 rounded-xl overflow-hidden shadow-xl hover:shadow-2xl transition-all duration-300 cursor-pointer">
                        <div class="absolute inset-0 topo-bg opacity-50 transition-opacity duration-300"></div>
                        <div
                            class="absolute inset-0 bg-white/60 backdrop-blur-[2px] group-hover:backdrop-blur-[4px] transition-all duration-300">
                        </div>
                        <div class="absolute inset-0 rounded-xl border border-white/60 border-b-4 border-b-gray-200/50">
                        </div>

                        <span class="relative z-10 text-gray-900 font-bold text-lg flex items-center drop-shadow-sm">
                            <span
                                class="material-symbols-rounded mr-3 text-[20px] text-gray-600 group-hover:text-school-primary transition-colors duration-300">save</span>
                            Uložit heslo
                        </span>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openModal(id) {
            document.getElementById(id).classList.remove('hidden');
        }

        function closeModal(id) {
            document.getElementById(id).classList.add('hidden');
        }
        @if ($errors->has('email'))
            openModal('email-modal');
        @endif
        @if ($errors->has('password'))
            openModal('password-modal');
        @endif
    </script>
@endsection
