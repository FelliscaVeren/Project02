@extends('layouts.app')

@section('title', 'Jadwal Produksi SPK (Dual View Mode)')

@section('content')
<div class="flex flex-col gap-6 h-full" x-data="{ viewMode: 'calendar', searchQuery: '' }">
    <!-- Header Aksi & Filter -->
    <div class="flex justify-between items-center bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
        <div class="flex-1 max-w-md">
            <h3 class="text-lg font-bold text-navy mb-3">Monitoring Jadwal</h3>
            <!-- Fitur Pencarian (Search) -->
            <div class="relative">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text" x-model="searchQuery" class="w-full bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-cyan focus:border-cyan block pl-10 p-2.5 transition-colors" placeholder="Cari No. SPK, Produk, atau Mesin...">
            </div>
        </div>
        
        <div class="flex flex-col items-end gap-3">
            <div class="flex gap-2">
                <button class="px-4 py-2 bg-white border border-slate-300 hover:bg-slate-50 text-slate-700 text-sm font-medium rounded-xl transition-colors flex items-center gap-2 shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                    Tarik SAP
                </button>
                <a href="{{ route('ppic.create.step1') }}" class="px-4 py-2 bg-navy hover:bg-navy-light text-white text-sm font-medium rounded-xl shadow-md transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Buat Jadwal
                </a>
            </div>
            
            <!-- Dual View Mode Toggle -->
            <div class="inline-flex bg-slate-100 p-1 rounded-lg border border-slate-200">
                <button @click="viewMode = 'calendar'" :class="{'bg-white shadow-sm text-cyan font-semibold': viewMode === 'calendar', 'text-slate-500': viewMode !== 'calendar'}" class="px-4 py-1.5 text-xs rounded-md transition-all flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    Kalender
                </button>
                <button @click="viewMode = 'list'" :class="{'bg-white shadow-sm text-cyan font-semibold': viewMode === 'list', 'text-slate-500': viewMode !== 'list'}" class="px-4 py-1.5 text-xs rounded-md transition-all flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
                    Tabel / List
                </button>
            </div>
        </div>
    </div>

    <!-- Container Utama -->
    <div class="flex-1 bg-white p-5 rounded-2xl border border-slate-200 shadow-sm overflow-hidden flex flex-col relative">
        
        <!-- Mode Kalender -->
        <div id="calendar" class="flex-1 w-full h-full" x-show="viewMode === 'calendar'"></div>
        
        <!-- Mode Tabel / List -->
        <div class="flex-1 w-full h-full overflow-auto" x-show="viewMode === 'list'" style="display: none;">
            <table class="w-full text-left border-collapse text-sm">
                <thead class="sticky top-0 bg-slate-50 shadow-sm">
                    <tr class="text-xs uppercase tracking-wider text-slate-500 font-bold border-b border-slate-200">
                        <th class="p-4">No. SPK</th>
                        <th class="p-4">Nama Produk Akhir</th>
                        <th class="p-4">Tanggal Pelaksanaan</th>
                        <th class="p-4">Nama Mesin</th>
                        <th class="p-4">Shift Kerja</th>
                        <th class="p-4">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="p-4 font-bold text-navy">SPK-2608-001</td>
                        <td class="p-4 font-medium">PVC Compound A (Clear)</td>
                        <td class="p-4">12 Aug 2026 - 14 Aug 2026</td>
                        <td class="p-4 font-semibold text-cyan">Mixer A-01, Ext-1</td>
                        <td class="p-4"><span class="px-2 py-1 rounded bg-indigo-50 text-indigo-700 border border-indigo-100 text-xs font-bold">Shift 1 & 2</span></td>
                        <td class="p-4"><span class="px-2 py-1 rounded bg-emerald-50 text-emerald-700 border border-emerald-100 text-xs font-bold">On Progress</span></td>
                    </tr>
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="p-4 font-bold text-navy">SPK-2608-002</td>
                        <td class="p-4 font-medium">PVC Compound B (Color)</td>
                        <td class="p-4">15 Aug 2026 - 16 Aug 2026</td>
                        <td class="p-4 font-semibold text-cyan">Mixer B-02, Ext-3</td>
                        <td class="p-4"><span class="px-2 py-1 rounded bg-amber-50 text-amber-700 border border-amber-100 text-xs font-bold">Shift 3</span></td>
                        <td class="p-4"><span class="px-2 py-1 rounded bg-amber-50 text-amber-700 border border-amber-100 text-xs font-bold">Pending (Approved)</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            themeSystem: 'standard',
            height: '100%',
            eventContent: function(arg) {
                // Kustomisasi tampilan Event (Detail Operasional)
                return {
                    html: `
                        <div class="p-1 overflow-hidden">
                            <div class="font-bold text-[10px] uppercase text-white/90 truncate">${arg.event.title}</div>
                            <div class="font-semibold text-xs truncate">${arg.event.extendedProps.product}</div>
                            <div class="text-[10px] mt-0.5 flex items-center justify-between opacity-90">
                                <span>${arg.event.extendedProps.machine}</span>
                                <span class="bg-white/20 px-1 rounded">${arg.event.extendedProps.shift}</span>
                            </div>
                        </div>
                    `
                };
            },
            events: [
                {
                    title: 'SPK-2608-001',
                    extendedProps: { product: 'PVC Compound A', machine: 'Mixer A-01, Ext-1', shift: 'Shift 1,2' },
                    start: new Date().toISOString().split('T')[0],
                    end: new Date(Date.now() + 86400000 * 3).toISOString().split('T')[0],
                    backgroundColor: '#112338',
                    borderColor: '#112338'
                },
                {
                    title: 'SPK-2608-002',
                    extendedProps: { product: 'PVC Compound B', machine: 'Mixer B-02, Ext-3', shift: 'Shift 3' },
                    start: new Date(Date.now() + 86400000 * 4).toISOString().split('T')[0],
                    end: new Date(Date.now() + 86400000 * 6).toISOString().split('T')[0],
                    backgroundColor: '#0ea5e9',
                    borderColor: '#0ea5e9'
                }
            ]
        });
        calendar.render();
        
        // Resize kalender saat switch tab (Bug fix Alpine x-show)
        window.addEventListener('resize', () => calendar.updateSize());
    });
</script>

<style>
    /* Styling FullCalendar to match new theme */
    .fc .fc-toolbar-title { font-size: 1.25rem; font-weight: 700; color: #112338; }
    .fc .fc-button-primary { background-color: #f4f7fb; border-color: #e2e8f0; color: #475569; text-transform: capitalize; border-radius: 0.5rem; font-weight: 600;}
    .fc .fc-button-primary:hover { background-color: #e2e8f0; color: #112338; }
    .fc .fc-button-primary:not(:disabled).fc-button-active, .fc .fc-button-primary:not(:disabled):active { background-color: #0ea5e9; color: white; border-color: #0ea5e9;}
    .fc .fc-daygrid-day-number { color: #112338; font-weight: 600; font-size: 0.875rem;}
    .fc-theme-standard th { background-color: #f4f7fb; border-color: #e2e8f0; padding: 0.75rem 0; color: #64748b; font-weight: 700; font-size: 0.75rem; text-transform: uppercase;}
    .fc-theme-standard td, .fc-theme-standard th { border-color: #f1f5f9; }
    .fc-h-event { border-radius: 0.375rem; border: none; box-shadow: 0 1px 2px rgba(0,0,0,0.05); }
</style>
@endsection
