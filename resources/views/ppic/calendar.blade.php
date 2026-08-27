@extends('layouts.app')

@section('title', 'Jadwal Produksi SPK')

@section('content')
<div class="flex h-full gap-5" x-data="calendarApp()">
    
    <!-- Sidebar Kiri: Tree View SPK -->
    <div class="w-64 bg-white rounded-2xl border border-slate-200 shadow-sm flex flex-col overflow-hidden flex-shrink-0">
        <div class="p-4 border-b border-slate-100 bg-slate-50/80">
            <h3 class="font-bold text-navy flex items-center gap-2 text-sm">
                <svg class="w-4 h-4 text-cyan" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
                Struktur SPK
            </h3>
        </div>

        <!-- Legend -->
        <div class="px-4 py-3 border-b border-slate-100 bg-slate-50/30 space-y-1.5">
            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider mb-2">Legenda</p>
            <div class="flex items-center gap-2"><span class="w-3 h-3 rounded bg-[#112338] inline-block flex-shrink-0"></span><span class="text-[10px] text-slate-600">Running (On Process)</span></div>
            <div class="flex items-center gap-2"><span class="w-3 h-3 rounded border-2 border-dashed border-slate-400 bg-slate-100 inline-block flex-shrink-0"></span><span class="text-[10px] text-slate-600">Draft (Belum Release)</span></div>
            <div class="flex items-center gap-2"><span class="w-3 h-3 rounded bg-violet-500 inline-block flex-shrink-0"></span><span class="text-[10px] text-slate-600">Cleaning Mesin</span></div>
        </div>
        
        <div class="p-3 overflow-y-auto flex-1 space-y-4">
            <!-- Folder Draft -->
            <div x-data="{ open: true }">
                <button @click="open = !open" class="flex items-center gap-2 w-full text-left font-bold text-xs text-slate-700 hover:text-navy transition-colors mb-2">
                    <svg class="w-3.5 h-3.5 transition-transform" :class="open ? 'rotate-90 text-cyan' : 'text-slate-400'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    <svg class="w-4 h-4 text-amber-500" fill="currentColor" viewBox="0 0 20 20"><path d="M2 6a2 2 0 012-2h5l2 2h5a2 2 0 012 2v6a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"></path></svg>
                    Draft (Menunggu Release)
                </button>
                <div x-show="open" class="pl-5 space-y-1.5 border-l-2 border-slate-100 ml-2">
                    <div class="group p-2 hover:bg-slate-50 rounded-lg border border-dashed border-slate-200 hover:border-slate-300 transition-all">
                        <div class="flex justify-between items-start gap-1">
                            <div class="flex-1 min-w-0">
                                <p class="text-[10px] font-bold text-slate-500">DRF-SPK-2608-05</p>
                                <p class="text-[10px] text-slate-400 truncate">PVC Comp C (Black)</p>
                            </div>
                            <button @click="releaseSpk('DRF-SPK-2608-05')" class="opacity-0 group-hover:opacity-100 px-1.5 py-0.5 bg-cyan text-white text-[8px] font-bold rounded shadow-sm hover:bg-cyan/90 transition-all whitespace-nowrap flex-shrink-0">Release</button>
                        </div>
                    </div>
                    <div class="group p-2 hover:bg-slate-50 rounded-lg border border-dashed border-slate-200 hover:border-slate-300 transition-all">
                        <div class="flex justify-between items-start gap-1">
                            <div class="flex-1 min-w-0">
                                <p class="text-[10px] font-bold text-slate-500">DRF-SPK-2608-06</p>
                                <p class="text-[10px] text-slate-400 truncate">PVC Comp D (Red)</p>
                            </div>
                            <button @click="releaseSpk('DRF-SPK-2608-06')" class="opacity-0 group-hover:opacity-100 px-1.5 py-0.5 bg-cyan text-white text-[8px] font-bold rounded shadow-sm hover:bg-cyan/90 transition-all whitespace-nowrap flex-shrink-0">Release</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Folder Running -->
            <div x-data="{ open: true }">
                <button @click="open = !open" class="flex items-center gap-2 w-full text-left font-bold text-xs text-slate-700 hover:text-navy transition-colors mb-2">
                    <svg class="w-3.5 h-3.5 transition-transform" :class="open ? 'rotate-90 text-cyan' : 'text-slate-400'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    <svg class="w-4 h-4 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path d="M2 6a2 2 0 012-2h5l2 2h5a2 2 0 012 2v6a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"></path></svg>
                    Running (Proses Berjalan)
                </button>
                <div x-show="open" class="pl-5 space-y-1.5 border-l-2 border-slate-100 ml-2">
                    <div class="p-2 bg-emerald-50 rounded-lg border border-emerald-200">
                        <p class="text-[10px] font-bold text-emerald-800">SPK-2608-001</p>
                        <p class="text-[10px] text-emerald-600 truncate">PVC Compound A (Clear)</p>
                        <span class="text-[8px] mt-1 text-emerald-700 bg-white/70 px-1 py-0.5 rounded inline-block font-bold">Shift 2 · Team Green</span>
                    </div>
                    <div class="p-2 hover:bg-slate-50 rounded-lg border border-slate-200 transition-all">
                        <p class="text-[10px] font-bold text-navy">SPK-2608-002</p>
                        <p class="text-[10px] text-slate-500 truncate">PVC Compound B (Color)</p>
                        <span class="text-[8px] mt-1 text-slate-600 bg-slate-100 px-1 py-0.5 rounded inline-block">Shift 1 · Team Red</span>
                    </div>
                </div>
            </div>

            <!-- Cleaning Schedule -->
            <div x-data="{ open: true }">
                <button @click="open = !open" class="flex items-center gap-2 w-full text-left font-bold text-xs text-slate-700 hover:text-navy transition-colors mb-2">
                    <svg class="w-3.5 h-3.5 transition-transform" :class="open ? 'rotate-90 text-cyan' : 'text-slate-400'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    <svg class="w-4 h-4 text-violet-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3H5a2 2 0 00-2 2v4m6-6h10a2 2 0 012 2v4M9 3v18m0 0h10a2 2 0 002-2V9M9 21H5a2 2 0 01-2-2V9m0 0h18"></path></svg>
                    Jadwal Cleaning
                </button>
                <div x-show="open" class="pl-5 space-y-1.5 border-l-2 border-slate-100 ml-2">
                    <div class="p-2 bg-violet-50 rounded-lg border border-violet-200">
                        <p class="text-[10px] font-bold text-violet-800">CLN-2608-001</p>
                        <p class="text-[10px] text-violet-600">Mixer A-01 & Feeder 01</p>
                        <p class="text-[9px] text-violet-500 mt-0.5">Oleh: Team Red · Shift 3</p>
                        <p class="text-[9px] text-violet-400 mt-0.5">Setelah: SPK-2608-001</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Area Konten Utama -->
    <div class="flex-1 flex flex-col gap-4 h-full overflow-hidden min-w-0">
        
        <!-- Header Aksi & Filter -->
        <div class="flex justify-between items-center bg-white px-5 py-4 rounded-2xl border border-slate-200 shadow-sm flex-shrink-0 gap-4">
            <div class="flex-1 min-w-0">
                <div class="relative max-w-xs">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <input type="text" x-model="searchQuery" class="w-full bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-cyan focus:border-cyan block pl-10 p-2.5 transition-colors" placeholder="Cari No. SPK, Produk...">
                </div>
            </div>
            
            <div class="flex items-center gap-2 flex-shrink-0">
                <a href="{{ route('ppic.create.step1') }}" class="px-4 py-2 bg-navy hover:bg-navy-light text-white text-sm font-bold rounded-xl shadow-md transition-colors flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Buat SPK
                </a>
                
                <!-- Dual View Mode Toggle -->
                <div class="inline-flex bg-slate-100 p-1 rounded-xl border border-slate-200">
                    <button @click="viewMode = 'calendar'" :class="{'bg-white shadow-sm text-cyan font-bold': viewMode === 'calendar', 'text-slate-500': viewMode !== 'calendar'}" class="px-3 py-1.5 text-xs rounded-lg transition-all flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        Kalender
                    </button>
                    <button @click="viewMode = 'list'" :class="{'bg-white shadow-sm text-cyan font-bold': viewMode === 'list', 'text-slate-500': viewMode !== 'list'}" class="px-3 py-1.5 text-xs rounded-lg transition-all flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
                        Tabel
                    </button>
                </div>
            </div>
        </div>

        <!-- Container Utama View -->
        <div class="flex-1 bg-white p-4 rounded-2xl border border-slate-200 shadow-sm overflow-hidden flex flex-col relative min-h-0">
            
            <!-- Mode Kalender -->
            <div id="calendar" class="flex-1 w-full h-full min-h-0" x-show="viewMode === 'calendar'"></div>
            
            <!-- Mode Tabel / List -->
            <div class="flex-1 w-full h-full overflow-auto" x-show="viewMode === 'list'" style="display: none;">
                <table class="w-full text-left border-collapse text-sm">
                    <thead class="sticky top-0 bg-slate-50 z-10">
                        <tr class="text-xs uppercase tracking-wider text-slate-500 font-bold border-b border-slate-200">
                            <th class="p-3">Info SPK</th>
                            <th class="p-3">Timeline & Mesin</th>
                            <th class="p-3">Tim & Shift</th>
                            <th class="p-3">Status Detail</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700">
                        <!-- Draft SPK row -->
                        <tr class="hover:bg-amber-50/50 transition-colors bg-slate-50/40">
                            <td class="p-3">
                                <span class="inline-block mb-1 px-1.5 py-0.5 rounded bg-slate-200 text-slate-600 text-[9px] font-bold uppercase tracking-wide border border-dashed border-slate-300">Draft</span>
                                <p class="font-bold text-slate-500 text-sm">DRF-SPK-2608-05</p>
                                <p class="text-xs text-slate-400 mt-0.5">PVC Compound C (Black)</p>
                            </td>
                            <td class="p-3">
                                <p class="text-xs text-slate-400 mb-1">Belum ditentukan</p>
                                <p class="text-xs text-slate-400">Mixer: —, Ext: —</p>
                            </td>
                            <td class="p-3">
                                <span class="text-xs text-slate-400 italic">Belum Alokasi Tim</span>
                            </td>
                            <td class="p-3">
                                <span class="px-2 py-1 rounded bg-amber-50 text-amber-700 border border-amber-200 text-xs font-bold">Draft (Menunggu Release)</span>
                                <button class="mt-2 block px-3 py-1 bg-cyan text-white text-xs font-bold rounded-lg hover:bg-cyan/90 transition">Release</button>
                            </td>
                        </tr>
                        <!-- Running SPK row -->
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="p-3">
                                <span class="inline-block mb-1 px-1.5 py-0.5 rounded bg-emerald-100 text-emerald-700 text-[9px] font-bold uppercase tracking-wide">Running</span>
                                <p class="font-bold text-navy text-sm">SPK-2608-001</p>
                                <p class="text-xs text-slate-500 mt-0.5">PVC Compound A (Clear)</p>
                            </td>
                            <td class="p-3">
                                <p class="text-xs text-slate-500">27 Aug 06:00 — 29 Aug 22:00</p>
                                <p class="font-semibold text-cyan text-xs mt-0.5">Mixer A-01 · Ext Line 1</p>
                            </td>
                            <td class="p-3">
                                <div class="flex flex-col gap-1 text-xs">
                                    <span class="px-2 py-0.5 rounded bg-red-50 text-red-700 border border-red-200 font-semibold inline-block">Shift 1 · Team RED</span>
                                    <span class="px-2 py-0.5 rounded bg-emerald-50 text-emerald-700 border border-emerald-200 font-semibold inline-block">Shift 2 · Team GREEN</span>
                                    <span class="px-2 py-0.5 rounded bg-yellow-50 text-yellow-700 border border-yellow-200 font-semibold inline-block">Shift 3 · Team YELLOW</span>
                                </div>
                            </td>
                            <td class="p-3">
                                <span class="px-2 py-1 rounded bg-blue-50 text-blue-700 border border-blue-100 text-xs font-bold block mb-1">On Process</span>
                                <p class="text-xs font-medium text-slate-600">Sub-status: <span class="text-navy font-bold">Sedang Penimbangan (25%)</span></p>
                            </td>
                        </tr>
                        <!-- Cleaning row -->
                        <tr class="hover:bg-violet-50/40 transition-colors bg-violet-50/20">
                            <td class="p-3">
                                <span class="inline-block mb-1 px-1.5 py-0.5 rounded bg-violet-100 text-violet-700 text-[9px] font-bold uppercase tracking-wide">Cleaning</span>
                                <p class="font-bold text-violet-700 text-sm">CLN-2608-001</p>
                                <p class="text-xs text-violet-500 mt-0.5">Cleaning Pasca SPK-2608-001</p>
                            </td>
                            <td class="p-3">
                                <p class="text-xs text-slate-500">29 Aug 22:00 — 30 Aug 02:00</p>
                                <p class="font-semibold text-violet-600 text-xs mt-0.5">Mixer A-01 · Feeder 01</p>
                            </td>
                            <td class="p-3">
                                <span class="px-2 py-0.5 rounded bg-red-50 text-red-700 border border-red-200 text-xs font-semibold inline-block">Shift 3 · Team RED</span>
                                <p class="text-xs text-slate-400 mt-1">Budi, Anggun</p>
                            </td>
                            <td class="p-3">
                                <span class="px-2 py-1 rounded bg-violet-50 text-violet-700 border border-violet-200 text-xs font-bold">Scheduled (Auto)</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Detail Event Kalender -->
    <div x-show="showEventModal" style="display:none;" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm" x-transition>
        <div class="bg-white rounded-2xl shadow-2xl border border-slate-200 w-full max-w-md overflow-hidden" @click.away="showEventModal = false">
            <div class="p-4 text-white flex justify-between items-center" :class="selectedEvent.type === 'cleaning' ? 'bg-violet-600' : (selectedEvent.type === 'draft' ? 'bg-slate-500' : 'bg-navy')">
                <div>
                    <p class="text-xs font-bold opacity-70 uppercase tracking-wide" x-text="selectedEvent.type === 'cleaning' ? '🧹 Cleaning Schedule' : (selectedEvent.type === 'draft' ? '📋 Draft SPK' : '⚙️ Running SPK')"></p>
                    <h4 class="font-bold text-base mt-0.5" x-text="selectedEvent.title"></h4>
                </div>
                <button @click="showEventModal = false" class="text-white/70 hover:text-white transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <div class="p-6 space-y-4 text-sm">
                <div><span class="block text-xs text-slate-500 font-bold mb-1">Produk / Kegiatan</span><p class="font-bold text-navy text-base" x-text="selectedEvent.product"></p></div>
                <div class="grid grid-cols-2 gap-4">
                    <div><span class="block text-xs text-slate-500 font-bold mb-1">Waktu</span><p class="font-semibold text-slate-800 text-xs" x-text="selectedEvent.dateRange"></p></div>
                    <div><span class="block text-xs text-slate-500 font-bold mb-1">Mesin</span><p class="font-semibold text-cyan text-xs" x-text="selectedEvent.machine"></p></div>
                </div>
                <template x-if="selectedEvent.type !== 'draft'">
                    <div class="border-t border-slate-100 pt-3">
                        <span class="block text-xs text-slate-500 font-bold mb-2">Alokasi Shift & Tim</span>
                        <div class="space-y-1">
                            <template x-for="shift in selectedEvent.shifts" :key="shift">
                                <p class="text-xs font-semibold text-slate-700" x-text="shift"></p>
                            </template>
                        </div>
                    </div>
                </template>
                <template x-if="selectedEvent.type === 'draft'">
                    <div class="bg-amber-50 border border-amber-200 rounded-lg p-3 text-xs text-amber-800">
                        <b>Status Draft</b>: SPK ini belum di-release. Alokasi mesin & tim belum dikonfirmasi.
                    </div>
                </template>
                <template x-if="selectedEvent.substatus">
                    <div class="bg-blue-50 border border-blue-100 rounded-lg p-3 flex items-center gap-2">
                        <span class="flex w-2 h-2 rounded-full bg-blue-500 animate-pulse"></span>
                        <p class="text-xs font-bold text-blue-800" x-text="'Sub-status: ' + selectedEvent.substatus"></p>
                    </div>
                </template>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('calendarApp', () => ({
            viewMode: 'calendar',
            searchQuery: '',
            showEventModal: false,
            selectedEvent: { title: '', product: '', dateRange: '', machine: '', shifts: [], substatus: '', type: 'running' },
            
            releaseSpk(draftNo) {
                alert(`SPK ${draftNo} berhasil di-Release ke antrean Running!`);
            }
        }))
    });

    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');

        // Compute dates relative to today
        var today = new Date();
        var fmt = (d) => d.toISOString().split('T')[0];
        var addDays = (d, n) => { var r = new Date(d); r.setDate(r.getDate()+n); return r; };

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            buttonText: {
                today: 'Hari Ini',
                month: 'Bulanan',
                week: 'Mingguan',
                day: 'Harian'
            },
            height: '100%',
            nowIndicator: true,
            slotLabelFormat: { hour: '2-digit', minute: '2-digit', hour12: false },
            eventClick: function(info) {
                let ext = info.event.extendedProps;
                let alpineState = Alpine.$data(document.querySelector('[x-data="calendarApp()"]'));
                alpineState.selectedEvent = {
                    title: info.event.title,
                    product: ext.product || info.event.title,
                    dateRange: info.event.startStr + (info.event.endStr ? ' → ' + info.event.endStr : ''),
                    machine: ext.machine || '—',
                    shifts: ext.shifts || [],
                    substatus: ext.substatus || '',
                    type: ext.type || 'running'
                };
                alpineState.showEventModal = true;
            },
            eventContent: function(arg) {
                let ext = arg.event.extendedProps;
                let isDraft = ext.type === 'draft';
                let isCleaning = ext.type === 'cleaning';
                let teamBadge = ext.team ? `<span style="font-size:8px;font-weight:700;opacity:0.9;">${ext.team}</span>` : '';
                return {
                    html: `<div class="p-1 overflow-hidden cursor-pointer" style="border-radius:4px;">
                        <div style="font-size:9px;font-weight:700;text-transform:uppercase;opacity:${isDraft?'0.7':'0.9'}">${arg.event.title}${isDraft?' [DRAFT]':''}</div>
                        <div style="font-size:11px;font-weight:600;">${ext.product||''}</div>
                        ${teamBadge}
                    </div>`
                };
            },
            events: [
                // Running SPK 1
                {
                    title: 'SPK-2608-001',
                    extendedProps: { 
                        product: 'PVC Compound A (Clear)', 
                        machine: 'Mixer A-01 · Ext Line 1', 
                        type: 'running',
                        team: 'S1:RED | S2:GREEN | S3:YELLOW',
                        shifts: ['Shift 1 — Team RED: Budi, Mia, Ayu', 'Shift 2 — Team GREEN: Bagas, Rudi, Putu', 'Shift 3 — Team YELLOW: Citra, Edi, Fikri'],
                        substatus: 'Sedang Penimbangan Material (25%)'
                    },
                    start: fmt(today) + 'T06:00:00',
                    end: fmt(addDays(today, 2)) + 'T22:00:00',
                    backgroundColor: '#112338',
                    borderColor: '#112338'
                },
                // Running SPK 2
                {
                    title: 'SPK-2608-002',
                    extendedProps: { 
                        product: 'PVC Compound B (Color)', 
                        machine: 'Mixer B-02 · Ext Line 3', 
                        type: 'running',
                        team: 'S1:RED | S2:YELLOW',
                        shifts: ['Shift 1 — Team RED: Anggun, Deva', 'Shift 2 — Team YELLOW: Hana, Irfan'],
                        substatus: 'Dalam Antrean Mesin'
                    },
                    start: fmt(addDays(today, 3)) + 'T08:00:00',
                    end: fmt(addDays(today, 5)) + 'T16:00:00',
                    backgroundColor: '#0ea5e9',
                    borderColor: '#0ea5e9'
                },
                // Draft SPK 1
                {
                    title: 'DRF-2608-05',
                    extendedProps: {
                        product: 'PVC Compound C (Black)',
                        machine: 'Belum Ditentukan',
                        type: 'draft',
                        shifts: []
                    },
                    start: fmt(addDays(today, 6)),
                    end: fmt(addDays(today, 8)),
                    backgroundColor: '#94a3b8',
                    borderColor: '#94a3b8',
                    borderWidth: 2,
                    display: 'block',
                    classNames: ['draft-event']
                },
                // Draft SPK 2
                {
                    title: 'DRF-2608-06',
                    extendedProps: {
                        product: 'PVC Compound D (Red)',
                        machine: 'Belum Ditentukan',
                        type: 'draft',
                        shifts: []
                    },
                    start: fmt(addDays(today, 9)),
                    end: fmt(addDays(today, 10)),
                    backgroundColor: '#94a3b8',
                    borderColor: '#94a3b8',
                    classNames: ['draft-event']
                },
                // Cleaning event (pasca SPK-001)
                {
                    title: '🧹 Cleaning: Mixer A-01',
                    extendedProps: {
                        product: 'Cleaning Mixer A-01 & Feeder 01',
                        machine: 'Mixer A-01 · Feeder 01',
                        type: 'cleaning',
                        team: 'Team RED · Shift 3',
                        shifts: ['Shift 3 — Team RED: Budi, Anggun (4 jam)']
                    },
                    start: fmt(addDays(today, 2)) + 'T22:00:00',
                    end: fmt(addDays(today, 3)) + 'T02:00:00',
                    backgroundColor: '#7c3aed',
                    borderColor: '#7c3aed'
                }
            ]
        });
        calendar.render();
        
        document.querySelector('[x-data="calendarApp()"]').addEventListener('click', () => {
            setTimeout(() => calendar.updateSize(), 50);
        });
    });
</script>

<style>
    .fc .fc-toolbar-title { font-size: 1rem; font-weight: 700; color: #112338; }
    .fc .fc-button-primary { background-color: #f4f7fb; border-color: #e2e8f0; color: #475569; text-transform: capitalize; border-radius: 0.5rem; font-weight: 600; padding: 0.2rem 0.7rem; font-size: 0.8rem; box-shadow: none; }
    .fc .fc-button-primary:hover { background-color: #e2e8f0; color: #112338; border-color: #cbd5e1; }
    .fc .fc-button-primary:not(:disabled).fc-button-active, .fc .fc-button-primary:not(:disabled):active { background-color: #112338; color: white; border-color: #112338; }
    .fc .fc-daygrid-day-number { color: #112338; font-weight: 600; font-size: 0.75rem; }
    .fc-theme-standard th { background-color: #f4f7fb; border-color: #e2e8f0; padding: 0.4rem 0; color: #64748b; font-weight: 700; font-size: 0.68rem; text-transform: uppercase; }
    .fc-theme-standard td, .fc-theme-standard th { border-color: #f1f5f9; }
    .fc-h-event { border-radius: 4px; border: none; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
    .fc-h-event:hover { opacity: 0.9; }
    .draft-event .fc-event-main { opacity: 0.75; background-image: repeating-linear-gradient(-45deg, transparent, transparent 3px, rgba(255,255,255,0.15) 3px, rgba(255,255,255,0.15) 6px); }
    .fc .fc-timegrid-slot { height: 2rem; }
    .fc .fc-col-header-cell { padding: 0.5rem 0; }
    .fc-day-today { background-color: rgba(14, 165, 233, 0.04) !important; }
    .fc .fc-now-indicator-line { border-color: #ef4444 !important; border-top-width: 2px; }
    .fc .fc-now-indicator-arrow { border-top-color: #ef4444 !important; border-bottom-color: #ef4444 !important; }
</style>
@endsection
