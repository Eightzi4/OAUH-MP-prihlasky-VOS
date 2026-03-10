@extends('layouts.app')

@section('title', 'Správa přihlášek | OAUH')

@section('header-right')
    <div class="flex items-center gap-4">
        <span class="text-sm font-bold text-school-primary hidden sm:block">{{ Auth::user()->role }}</span>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="group relative flex items-center justify-center px-4 py-2 rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-all duration-300 cursor-pointer border border-transparent hover:border-gray-200">
                <div class="absolute inset-0 topo-bg opacity-30 transition-opacity duration-300"></div>
                <div
                    class="absolute inset-0 bg-white/60 backdrop-blur-[2px] group-hover:backdrop-blur-[4px] transition-all duration-300">
                </div>
                <div class="absolute inset-0 rounded-xl border border-white/60 border-b-2 border-b-gray-200/50"></div>
                <span
                    class="relative z-10 text-gray-600 font-bold text-xs flex items-center gap-2 group-hover:text-school-primary transition-colors">
                    Odhlásit se
                    <span class="material-symbols-rounded text-[18px]">logout</span>
                </span>
            </button>
        </form>
    </div>
@endsection

@section('content')
    <div class="w-full max-w-7xl mx-auto">

        <div class="mb-10 text-center sm:text-left">
            <h1 class="text-4xl sm:text-5xl font-bold text-gray-900 mb-3 drop-shadow-sm tracking-tight">Přehled přihlášek
            </h1>
            <p class="text-lg text-gray-700 font-medium">Správa a kontrola podaných elektronických přihlášek ke studiu.</p>
        </div>

        <div class="bg-white/80 backdrop-blur-xl shadow-lg rounded-3xl overflow-hidden border border-white/60 ring-1 ring-black/5"
            x-data="adminTable({
                applications: {{ Js::from($applications) }},
                programs: {{ Js::from($programs) }}
            })" x-init="$watch('searchTerm, selectedStatus, selectedProgram', () => currentPage = 1)">

            <div class="p-6 sm:p-8 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                    <div>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="material-symbols-rounded text-gray-400 text-[20px]">filter_alt</span>
                            </div>
                            <select x-model="selectedStatus"
                                class="block w-full pl-10 pr-10 py-3 border border-gray-200 rounded-xl leading-5 bg-white/50 text-gray-900 focus:outline-none focus:ring-2 focus:ring-school-primary focus:border-school-primary sm:text-sm transition-all shadow-sm appearance-none">
                                <option value="">Všechny stavy</option>
                                <option value="submitted">Odeslané</option>
                                <option value="draft">Rozpracované</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none">
                                <span class="material-symbols-rounded text-gray-500 text-[20px]">expand_more</span>
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="material-symbols-rounded text-gray-400 text-[20px]">school</span>
                            </div>
                            <select x-model="selectedProgram"
                                class="block w-full pl-10 pr-10 py-3 border border-gray-200 rounded-xl leading-5 bg-white/50 text-gray-900 focus:outline-none focus:ring-2 focus:ring-school-primary focus:border-school-primary sm:text-sm transition-all shadow-sm appearance-none">
                                <option value="">Všechny obory</option>
                                <template x-for="program in programs" :key="program.id">
                                    <option :value="program.id" x-text="program.name"></option>
                                </template>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none">
                                <span class="material-symbols-rounded text-gray-500 text-[20px]">expand_more</span>
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="material-symbols-rounded text-gray-400 text-[20px]">search</span>
                            </div>
                            <input type="text" x-model.debounce.300ms="searchTerm"
                                placeholder="Hledat jméno, email, ID..."
                                class="block w-full pl-10 pr-3 py-3 border border-gray-200 rounded-xl leading-5 bg-white/50 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-school-primary focus:border-school-primary sm:text-sm transition-all shadow-sm">
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto border border-gray-200/60 rounded-2xl bg-white shadow-sm">
                    <table class="w-full min-w-full divide-y divide-gray-100">
                        <thead class="bg-gray-50/50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100 transition-colors"
                                    @click="sortBy('id')">
                                    <div class="flex items-center gap-1">ID <span
                                            class="material-symbols-rounded text-[16px]" x-html="sortIcon('id')"></span>
                                    </div>
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100 transition-colors"
                                    @click="sortBy('last_name')">
                                    <div class="flex items-center gap-1">Uchazeč <span
                                            class="material-symbols-rounded text-[16px]"
                                            x-html="sortIcon('last_name')"></span></div>
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100 transition-colors"
                                    @click="sortBy('study_program.name')">
                                    <div class="flex items-center gap-1">Obor <span
                                            class="material-symbols-rounded text-[16px]"
                                            x-html="sortIcon('study_program.name')"></span></div>
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100 transition-colors"
                                    @click="sortBy('status')">
                                    <div class="flex items-center gap-1">Stav <span
                                            class="material-symbols-rounded text-[16px]" x-html="sortIcon('status')"></span>
                                    </div>
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100 transition-colors"
                                    @click="sortBy('created_at')">
                                    <div class="flex items-center gap-1">Založeno <span
                                            class="material-symbols-rounded text-[16px]"
                                            x-html="sortIcon('created_at')"></span></div>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            <template x-if="paginatedData.length === 0">
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-gray-400">
                                        <span class="material-symbols-rounded text-[40px] mb-2 opacity-50">search_off</span>
                                        <p>Nebyly nalezeny žádné přihlášky.</p>
                                    </td>
                                </tr>
                            </template>
                            <template x-for="app in paginatedData" :key="app.id">
                                <tr class="hover:bg-red-50/30 transition-colors cursor-pointer group"
                                    @click="window.location=`{{ url('/admin/application') }}/${app.id}`">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-700"
                                        x-text="app.application_number || `#${app.id}`"></td>
                                    <td class="px-6 py-4 text-sm">
                                        <div class="font-bold text-gray-900 group-hover:text-school-primary transition-colors"
                                            x-text="app.first_name || app.last_name ? `${app.first_name || ''} ${app.last_name || ''}` : 'Nezadáno'">
                                        </div>
                                        <div class="text-xs text-gray-500"
                                            x-text="app.email || (app.user ? app.user.email : '')"></div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600 font-medium"
                                        x-text="app.study_program ? app.study_program.name : ''"></td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <template x-if="app.status === 'submitted'">
                                            <span
                                                class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-green-50 text-green-700 border border-green-200">
                                                <span class="material-symbols-rounded text-[16px]">check_circle</span>
                                                Odesláno
                                            </span>
                                        </template>
                                        <template x-if="app.status === 'draft'">
                                            <span
                                                class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-yellow-50 text-yellow-700 border border-yellow-200">
                                                <span class="w-2 h-2 rounded-full bg-yellow-500"></span> Rozpracováno
                                            </span>
                                        </template>
                                    </td>
                                    <td
                                        class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 flex items-center justify-between">
                                        <span x-text="new Date(app.created_at).toLocaleDateString('cs-CZ')"></span>
                                        <span
                                            class="material-symbols-rounded text-gray-300 opacity-0 group-hover:opacity-100 transition-opacity">chevron_right</span>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>

                <div class="flex flex-col sm:flex-row justify-between items-center text-sm text-gray-500 gap-4 pt-2">
                    <p>Zobrazeno <span class="font-bold text-gray-900" x-text="paginatedData.length"></span> z <span
                            class="font-bold text-gray-900" x-text="filteredData.length"></span> záznamů.</p>
                    <div class="flex items-center gap-2">
                        <button @click="currentPage--" :disabled="currentPage <= 1"
                            class="p-2 border border-gray-200 rounded-xl hover:bg-gray-50 disabled:opacity-50 transition-colors flex items-center justify-center cursor-pointer">
                            <span class="material-symbols-rounded text-[18px]">chevron_left</span>
                        </button>
                        <span class="px-2 font-medium">Strana <span x-text="currentPage"></span> z <span
                                x-text="totalPages || 1"></span></span>
                        <button @click="currentPage++" :disabled="currentPage >= totalPages"
                            class="p-2 border border-gray-200 rounded-xl hover:bg-gray-50 disabled:opacity-50 transition-colors flex items-center justify-center cursor-pointer">
                            <span class="material-symbols-rounded text-[18px]">chevron_right</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('adminTable', (data) => ({
                allData: data.applications,
                programs: data.programs,
                searchTerm: '',
                selectedStatus: '',
                selectedProgram: '',
                sortColumn: 'created_at',
                sortDirection: 'desc',
                currentPage: 1,
                itemsPerPage: 10,

                sortBy(column) {
                    if (this.sortColumn === column) {
                        this.sortDirection = this.sortDirection === 'asc' ? 'desc' : 'asc';
                    } else {
                        this.sortColumn = column;
                        this.sortDirection = 'asc';
                    }
                },
                sortIcon(column) {
                    if (this.sortColumn !== column) return 'unfold_more';
                    return this.sortDirection === 'asc' ? 'keyboard_arrow_up' : 'keyboard_arrow_down';
                },

                get filteredData() {
                    let filtered = [...this.allData];

                    if (this.selectedStatus !== '') {
                        filtered = filtered.filter(a => a.status === this.selectedStatus);
                    }
                    if (this.selectedProgram !== '') {
                        filtered = filtered.filter(a => String(a.study_program_id) === String(this
                            .selectedProgram));
                    }
                    if (this.searchTerm.trim() !== '') {
                        const term = this.searchTerm.toLowerCase();
                        filtered = filtered.filter(a =>
                            (a.first_name && a.first_name.toLowerCase().includes(term)) ||
                            (a.last_name && a.last_name.toLowerCase().includes(term)) ||
                            (a.email && a.email.toLowerCase().includes(term)) ||
                            (a.user && a.user.email && a.user.email.toLowerCase().includes(
                                term)) ||
                            (String(a.id).includes(term)) ||
                            (a.application_number && String(a.application_number).includes(
                                term))
                        );
                    }

                    return filtered.sort((a, b) => {
                        const getProp = (obj, desc) => {
                            const arr = desc.split('.');
                            while (arr.length && (obj = obj[arr.shift()]));
                            return obj;
                        };
                        const aVal = getProp(a, this.sortColumn) || '';
                        const bVal = getProp(b, this.sortColumn) || '';

                        let comparison = 0;
                        if (typeof aVal === 'string' && typeof bVal === 'string') {
                            comparison = aVal.localeCompare(bVal, 'cs');
                        } else {
                            comparison = aVal < bVal ? -1 : (aVal > bVal ? 1 : 0);
                        }
                        return this.sortDirection === 'asc' ? comparison : -comparison;
                    });
                },
                get totalPages() {
                    return Math.ceil(this.filteredData.length / this.itemsPerPage);
                },
                get paginatedData() {
                    const start = (this.currentPage - 1) * this.itemsPerPage;
                    return this.filteredData.slice(start, start + this.itemsPerPage);
                }
            }));
        });
    </script>
@endsection
