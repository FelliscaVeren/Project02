@extends('layouts.app')

@section('title', 'Jadwal Produksi SPK')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                        <div class="flex items-center gap-1 mt-1">
                            <span class="text-[8px] text-emerald-700 bg-white/70 px-1 py-0.5 rounded font-bold">Shift 2 · Team Green</span>
                            <span class="text-[8px] text-violet-700 bg-violet-100 px-1 py-0.5 rounded font-bold" title="Termasuk jadwal cleaning paska SPK">Cleaning</span>
                        </div>
                    </div>
                    <div class="p-2 hover:bg-slate-50 rounded-lg border border-slate-200 transition-all">
                        <p class="text-[10px] font-bold text-navy">SPK-2608-002</p>
                        <p class="text-[10px] text-slate-500 truncate">PVC Compound B (Color)</p>
                        <span class="text-[8px] mt-1 text-slate-600 bg-slate-100 px-1 py-0.5 rounded inline-block">Shift 1 · Team Red</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Area Konten Utama -->
    <div class="flex-1 flex flex-col gap-4 h-full overflow-hidden min-w-0">
        
        <!-- Header Aksi & Filter -->
        <div class="flex flex-col bg-white px-5 py-4 rounded-2xl border border-slate-200 shadow-sm flex-shrink-0 gap-4">
            
            <!-- Baris Atas: Tabs Filter & Tombol Aksi -->
            <div class="flex justify-between items-center flex-wrap gap-4">
                
                <!-- UI Tabs untuk Status Filter (menggantikan dropdown) -->
                <div class="flex items-center bg-slate-100 p-1 rounded-xl border border-slate-200" x-show="viewMode === 'list'">
                    <button @click="statusFilter = 'all'" :class="{'bg-white shadow-sm text-cyan font-bold': statusFilter === 'all', 'text-slate-500 hover:text-slate-700': statusFilter !== 'all'}" class="px-3 py-1.5 text-xs rounded-lg transition-all">Semua Status</button>
                    <button @click="statusFilter = 'draft'" :class="{'bg-white shadow-sm text-cyan font-bold': statusFilter === 'draft', 'text-slate-500 hover:text-slate-700': statusFilter !== 'draft'}" class="px-3 py-1.5 text-xs rounded-lg transition-all">Draft</button>
                    <button @click="statusFilter = 'released'" :class="{'bg-white shadow-sm text-cyan font-bold': statusFilter === 'released', 'text-slate-500 hover:text-slate-700': statusFilter !== 'released'}" class="px-3 py-1.5 text-xs rounded-lg transition-all">Released</button>
                    <button @click="statusFilter = 'on_process'" :class="{'bg-white shadow-sm text-cyan font-bold': statusFilter === 'on_process', 'text-slate-500 hover:text-slate-700': statusFilter !== 'on_process'}" class="px-3 py-1.5 text-xs rounded-lg transition-all">On Process</button>
                    <button @click="statusFilter = 'scheduled'" :class="{'bg-white shadow-sm text-cyan font-bold': statusFilter === 'scheduled', 'text-slate-500 hover:text-slate-700': statusFilter !== 'scheduled'}" class="px-3 py-1.5 text-xs rounded-lg transition-all">Schedule</button>
                </div>
                <!-- Spacing jika mode kalender (tabs sembunyi) -->
                <div x-show="viewMode === 'calendar'" class="flex-1"></div>

            <div class="flex items-center gap-2 flex-shrink-0 flex-wrap">


                <!-- Slot Mesin Extruder E01 - E05 Button -->
                <button @click="showSlotModal = true" class="px-3.5 py-2 bg-white border border-slate-300 hover:bg-slate-50 text-slate-700 text-xs font-bold rounded-xl shadow-sm transition-colors flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-cyan" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    Slot Mesin Extruder (E01-E05)
                </button>

                <a href="{{ route('ppic.create.step1') }}" class="px-4 py-2 bg-navy hover:bg-navy-light text-white text-xs font-bold rounded-xl shadow-md transition-colors flex items-center gap-1.5">
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

            <!-- Baris Bawah: Pencarian & Filter Tanggal -->
            <div class="flex items-center gap-3 flex-wrap">
                <!-- Search Input -->
                <div class="relative max-w-sm flex-1">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <input type="text" x-model="searchQuery" class="w-full bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-cyan focus:border-cyan block pl-10 p-2 transition-colors" placeholder="Cari No. SPK, Customer, Produk...">
                </div>
                
                <!-- Date Range Filter -->
                <div class="flex items-center gap-2 bg-slate-50 border border-slate-200 rounded-xl p-1 px-2">
                    <span class="text-xs font-bold text-slate-500 mr-1">Tgl SPK:</span>
                    <input type="date" x-model="dateStart" class="bg-white border border-slate-200 rounded-lg text-xs px-2 py-1 focus:ring-cyan focus:border-cyan outline-none text-slate-700">
                    <span class="text-xs font-bold text-slate-400">-</span>
                    <input type="date" x-model="dateEnd" class="bg-white border border-slate-200 rounded-lg text-xs px-2 py-1 focus:ring-cyan focus:border-cyan outline-none text-slate-700">
                </div>
            </div>
        </div>

        <!-- Container Utama View -->
        <div class="flex-1 bg-white p-4 rounded-2xl border border-slate-200 shadow-sm overflow-hidden flex flex-col relative min-h-0">
            
            <!-- Mode Kalender -->
            <div id="calendar" class="flex-1 w-full h-full min-h-0" x-show="viewMode === 'calendar'"></div>
            
            <!-- Mode Tabel / List (Jadwal Bulanan Detailed) -->
            <div class="flex-1 w-full h-full overflow-auto" x-show="viewMode === 'list'" style="display: none;">
                <table class="w-full text-left border-collapse text-xs">
                    <thead class="sticky top-0 bg-slate-50 z-10">
                        <tr class="uppercase tracking-wider text-slate-500 font-bold border-b border-slate-200 text-[10px]">
                            <th class="p-3">No. SPK & Customer</th>
                            <th class="p-3">Timeline & Pengiriman</th>
                            <th class="p-3">Metrik Kerja (Days/Mins/Delay)</th>
                            <th class="p-3">Proses (TP/MP/MD/ML) & Batch</th>
                            <th class="p-3">Keterangan & Remarks</th>
                            <th class="p-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700">
                        <!-- Draft SPK row -->
                        <tr class="hover:bg-amber-50/50 transition-colors bg-slate-50/40" x-show="statusFilter === 'all' || statusFilter === 'draft'">
                            <td class="p-3">
                                <span class="inline-block mb-1 px-1.5 py-0.5 rounded bg-slate-200 text-slate-600 text-[9px] font-bold uppercase tracking-wide border border-dashed border-slate-300">Draft</span>
                                <p class="font-bold text-slate-500 text-sm">DRF-SPK-2608-05</p>
                                <p class="text-xs text-navy font-semibold">PT Delta Polymer Indonesia</p>
                                <p class="text-[11px] text-slate-400 mt-0.5">PVC Compound C (Black)</p>
                            </td>
                            <td class="p-3">
                                <p class="text-slate-600 font-medium">Tanggal Kirim: <span class="font-bold text-slate-700">09 Sep 2026 (Tentatif)</span></p>
                                <p class="text-[10px] text-slate-400 mt-1">Belum Alokasi Mesin</p>
                            </td>
                            <td class="p-3">
                                <p class="text-slate-600">Working Days: <span class="font-bold">2.0 Days</span></p>
                                <p class="text-slate-600">Working Mins: <span class="font-bold">960 Mins</span></p>
                                <p class="text-emerald-600 font-bold">Delay: 0.0 Hr</p>
                            </td>
                            <td class="p-3">
                                <span class="px-2 py-0.5 rounded bg-amber-50 text-amber-700 border border-amber-200 font-bold text-[10px]">Target OP: 400 Kg / Jam</span>
                                <p class="text-slate-500 mt-1 font-semibold">Batch: 0 / 40 Batch Selesai</p>
                                <p class="text-[10px] text-slate-400 mt-0.5">Proses: TP &rarr; MP &rarr; Extruder</p>
                            </td>
                            <td class="p-3">
                                <p class="text-slate-600">Ket: <span class="text-slate-500">Sample formulasi hitam mate</span></p>
                                <p class="text-slate-600">Remarks: <span class="text-slate-500">Menunggu QC approval</span></p>
                            </td>
                            <td class="p-3 text-right">
                                <button @click="releaseSpk('DRF-SPK-2608-05')" class="px-3 py-1.5 bg-cyan text-white font-bold text-xs rounded-lg shadow-sm hover:bg-cyan/90 transition">Release SPK</button>
                            </td>
                        </tr>
                        <!-- Running SPK row -->
                        <tr class="hover:bg-slate-50 transition-colors" x-show="statusFilter === 'all' || statusFilter === 'on_process' || statusFilter === 'released'">
                            <td class="p-3">
                                <span class="inline-block mb-1 px-1.5 py-0.5 rounded bg-emerald-100 text-emerald-700 text-[9px] font-bold uppercase tracking-wide">Running</span>
                                <p class="font-bold text-navy text-sm">SPK-2608-001</p>
                                <p class="text-xs text-navy font-bold">PT Royal Synthetic Compound</p>
                                <p class="text-[11px] text-slate-500 mt-0.5">PVC Compound A (Clear)</p>
                            </td>
                            <td class="p-3">
                                <p class="text-slate-600 font-medium">Tanggal Kirim: <span class="font-bold text-navy">06 Sep 2026 (Tentatif)</span></p>
                                <p class="text-[10px] text-cyan font-bold mt-1">Mixer A-01 · Ext Line 1 (E-01)</p>
                            </td>
                            <td class="p-3">
                                <p class="text-slate-700">Working Days: <span class="font-bold text-navy">2.5 Days</span></p>
                                <p class="text-slate-700">Working Mins: <span class="font-bold text-navy">1,200 Mins</span></p>
                                <p class="text-emerald-600 font-bold">Delay: 0.0 Hr (On Time)</p>
                            </td>
                            <td class="p-3 min-w-[200px]">
                                <div class="bg-emerald-50 border border-emerald-200 rounded-lg p-2 mb-1">
                                    <p class="font-bold text-emerald-800 text-xs">28 / 50 Batch Selesai (56%)</p>
                                </div>
                                <p class="text-[10px] text-slate-600">Proses Aktif: <b class="text-cyan">TP (Timbang Produk) & MP (Mixing Powder)</b></p>
                            </td>
                            <td class="p-3">
                                <p class="text-slate-700">Ket: <span class="text-slate-600 font-medium">Formula standar high-clarity PVC</span></p>
                                <p class="text-slate-700">Remarks: <span class="text-slate-600 font-medium">Prioritas pengiriman via kontainer 20ft</span></p>
                            </td>
                            <td class="p-3 text-right whitespace-nowrap">
                                <a href="{{ route('spk.detail') }}?id=SPK-2608-001" class="px-3 py-1.5 bg-navy hover:bg-navy-light text-white font-bold text-xs rounded-lg shadow-sm transition inline-block">Detail SPK</a>
                            </td>
                        </tr>

                        <!-- Removed separate Cleaning row -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Live Report & Detail SPK (Full Screen, Step Paging) -->
    <div x-show="showEventModal" style="display:none;" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm" x-transition>
        <div class="bg-slate-50 rounded-2xl shadow-2xl border border-slate-200 w-full max-w-[95vw] h-[95vh] flex flex-col overflow-hidden" @click.away="showEventModal = false">
                      <!-- Header Modal -->
            <div class="px-5 py-3 text-white flex justify-between items-center flex-shrink-0 bg-navy">
                <div class="flex items-center gap-4">
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="px-2 py-0.5 bg-white/20 rounded text-[9px] font-bold uppercase tracking-wider">LIVE REPORT</span>
                            <h4 class="font-bold text-lg" x-text="selectedEvent.title || 'SPK-2608-001'"></h4>
                        </div>
                        <p class="text-xs font-medium opacity-70 mt-0.5">
                            <span x-show="selectedEvent.type !== 'rnd'" x-text="(selectedEvent.product || 'PVC Compound A (Clear)') + ' · ' + (selectedEvent.customer || 'PT Royal Synthetic Compound')"></span>
                            <span x-show="selectedEvent.type === 'rnd'" x-text="'Uji Coba Sample Formula R&D'"></span>
                        </p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <!-- View SPK Fix Button (top right) -->
                    <a x-show="selectedEvent.type !== 'rnd'" :href="'{{ route('spk.detail') }}?id=' + (selectedEvent.title || 'SPK-2608-001')"
                       class="px-4 py-2 bg-white text-navy hover:bg-slate-100 text-xs font-bold rounded-xl shadow-sm transition flex items-center gap-2">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 01-2-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        View SPK Fix
                    </a>
                    <button @click="showEventModal = false" class="text-white/70 hover:text-white transition bg-black/20 p-2 rounded-full hover:bg-black/40">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
            </div>

            <!-- Integrated Cleaning Banner if linked -->
            <template x-if="selectedEvent.parentSpk || selectedEvent.linkedCleaning">
                <div class="bg-violet-600 text-white px-6 py-2.5 flex items-center justify-between text-xs font-bold border-b border-violet-700 flex-shrink-0">
                    <div class="flex items-center gap-2">
                        <span class="px-2 py-0.5 bg-white/20 text-white rounded text-[10px] uppercase tracking-wider font-extrabold">🧹 STACKED TASK</span>
                        <template x-if="selectedEvent.parentSpk">
                            <span>Tugas Cleaning ini terhubung & di-stack secara otomatis dengan SPK Induk: <u class="text-amber-300 font-extrabold" x-text="selectedEvent.parentSpk"></u></span>
                        </template>
                        <template x-if="selectedEvent.linkedCleaning">
                            <span>SPK ini memiliki jadwal cleaning pasca-produksi: <u class="text-amber-300 font-extrabold" x-text="selectedEvent.linkedCleaning"></u></span>
                        </template>
                    </div>
                    <span class="text-[10px] opacity-80 font-normal">Pembersihan mesin & feeder terintegrasi</span>
                </div>
            </template>

            <!-- Step Tabs / Paging Bar (selalu tampil kecuali R&D) -->
            <div x-show="selectedEvent.type !== 'rnd'" class="bg-white border-b border-slate-200 px-4 py-0 flex items-center gap-0 flex-shrink-0 overflow-x-auto">
                <!-- Tab 1: Cleaning -->
                <button @click="activeStep = 'cleaning'"
                    :class="activeStep === 'cleaning' ? 'border-b-2 border-violet-500 text-violet-700 bg-violet-50/50' : 'text-slate-500 hover:text-slate-700 border-b-2 border-transparent'"
                    class="flex items-center gap-2 px-4 py-3.5 text-xs font-bold transition-all whitespace-nowrap flex-shrink-0">
                    <span class="w-5 h-5 rounded-full text-[10px] flex items-center justify-center font-black"
                          :class="activeStep === 'cleaning' ? 'bg-violet-500 text-white' : 'bg-violet-100 text-violet-600'">✓</span>
                    Cleaning
                    <span class="px-1.5 py-0.5 text-[9px] rounded-full font-bold bg-violet-100 text-violet-700">Selesai</span>
                </button>
                <!-- Tab 2: Penimbangan -->
                <button @click="activeStep = 'timbang'; setTimeout(() => initStepChart('timbang'), 80)"
                    :class="activeStep === 'timbang' ? 'border-b-2 border-emerald-500 text-emerald-700 bg-emerald-50/50' : 'text-slate-500 hover:text-slate-700 border-b-2 border-transparent'"
                    class="flex items-center gap-2 px-4 py-3.5 text-xs font-bold transition-all whitespace-nowrap flex-shrink-0">
                    <span class="w-5 h-5 rounded-full text-[10px] flex items-center justify-center font-black"
                          :class="activeStep === 'timbang' ? 'bg-emerald-500 text-white' : 'bg-slate-200 text-slate-600'">✓</span>
                    Penimbangan
                    <span class="px-1.5 py-0.5 text-[9px] rounded-full font-bold bg-emerald-100 text-emerald-700">Selesai</span>
                </button>
                <!-- Tab 3: Mixing -->
                <button @click="activeStep = 'mixing'; setTimeout(() => initStepChart('mixing'), 80)"
                    :class="activeStep === 'mixing' ? 'border-b-2 border-emerald-500 text-emerald-700 bg-emerald-50/50' : 'text-slate-500 hover:text-slate-700 border-b-2 border-transparent'"
                    class="flex items-center gap-2 px-4 py-3.5 text-xs font-bold transition-all whitespace-nowrap flex-shrink-0">
                    <span class="w-5 h-5 rounded-full text-[10px] flex items-center justify-center font-black"
                          :class="activeStep === 'mixing' ? 'bg-emerald-500 text-white' : 'bg-slate-200 text-slate-600'">✓</span>
                    Mixing
                    <span class="px-1.5 py-0.5 text-[9px] rounded-full font-bold bg-emerald-100 text-emerald-700">Selesai</span>
                </button>
                <!-- Tab 4: Extruder -->
                <button @click="activeStep = 'extruder'; setTimeout(() => initStepChart('extruder'), 80)"
                    :class="activeStep === 'extruder' ? 'border-b-2 border-emerald-500 text-emerald-700 bg-emerald-50/50' : 'text-slate-500 hover:text-slate-700 border-b-2 border-transparent'"
                    class="flex items-center gap-2 px-4 py-3.5 text-xs font-bold transition-all whitespace-nowrap flex-shrink-0">
                    <span class="w-5 h-5 rounded-full text-[10px] flex items-center justify-center font-black"
                          :class="activeStep === 'extruder' ? 'bg-emerald-500 text-white' : 'bg-slate-200 text-slate-600'">✓</span>
                    Extruder
                    <span class="px-1.5 py-0.5 text-[9px] rounded-full font-bold bg-emerald-100 text-emerald-700">Selesai</span>
                </button>
                <!-- Tab 5: Bagging -->
                <button @click="activeStep = 'bagging'; setTimeout(() => initStepChart('bagging'), 80)"
                    :class="activeStep === 'bagging' ? 'border-b-2 border-emerald-500 text-emerald-700 bg-emerald-50/50' : 'text-slate-500 hover:text-slate-700 border-b-2 border-transparent'"
                    class="flex items-center gap-2 px-4 py-3.5 text-xs font-bold transition-all whitespace-nowrap flex-shrink-0">
                    <span class="w-5 h-5 rounded-full text-[10px] flex items-center justify-center font-black"
                          :class="activeStep === 'bagging' ? 'bg-emerald-500 text-white' : 'bg-slate-200 text-slate-600'">✓</span>
                    Bagging
                    <span class="px-1.5 py-0.5 text-[9px] rounded-full font-bold bg-emerald-100 text-emerald-700">Selesai</span>
                </button>

                <!-- Overall Progress pill -->
                <div class="ml-auto flex items-center gap-3 pr-1 flex-shrink-0">
                    <span class="text-[10px] text-slate-400 font-bold">Overall</span>
                    <div class="flex items-center gap-2">
                        <div class="w-24 bg-slate-100 rounded-full h-2">
                            <div class="bg-emerald-500 h-2 rounded-full" style="width: 100%"></div>
                        </div>
                        <span class="text-xs font-black text-emerald-600">100%</span>
                    </div>
                    <span class="text-[10px] text-slate-500 font-bold">
                        <span x-text="selectedEvent.completedBatch || '50'"></span>/<span x-text="selectedEvent.totalBatch || '50'"></span> Batch
                    </span>
                </div>
            </div>

            <!-- Step Pages Body (Untuk Semua SPK termasuk Cleaning) -->
            <div x-show="selectedEvent.type !== 'rnd'" class="flex-1 overflow-y-auto p-6 min-h-0">

                <!-- ============ PAGE 1: CLEANING (Monitoring Read-Only — diisi oleh Operator & QC) ============ -->
                <div x-show="activeStep === 'cleaning'" class="space-y-5" x-data="cleaningFormApp()">

                    <!-- Header Info -->
                    <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
                        <div class="flex items-center justify-between flex-wrap gap-4">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-xl bg-emerald-100 flex items-center justify-center text-emerald-600">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Form Cleaning Mesin · C.PRO.001-24</p>
                                    <h3 class="text-base font-black text-navy">Pembersihan Mesin Pra-Produksi</h3>
                                    <p class="text-xs text-slate-500" x-text="'SPK Induk: ' + (selectedEvent.parentSpk || selectedEvent.title || 'SPK-2608-001')"></p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="px-3 py-1.5 bg-emerald-100 text-emerald-700 text-xs font-bold rounded-xl flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    Cleaning Selesai &mdash; Diverifikasi QC
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Info Pelaksanaan (Read-Only) -->
                    <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
                        <h5 class="text-xs font-bold text-slate-500 uppercase tracking-widest mb-4">Informasi Pelaksanaan <span class="text-violet-500 normal-case">(Diisi oleh Operator Cleaning)</span></h5>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                            <div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Nama Operator</p>
                                <p class="text-sm font-bold text-navy bg-slate-50 border border-slate-100 rounded-lg px-3 py-2" x-text="form.namaOperator"></p>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Shift / Group</p>
                                <p class="text-sm font-bold text-navy bg-slate-50 border border-slate-100 rounded-lg px-3 py-2" x-text="form.shift"></p>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Mesin yang di-Cleaning</p>
                                <p class="text-sm font-bold text-navy bg-slate-50 border border-slate-100 rounded-lg px-3 py-2" x-text="form.mesin"></p>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Tanggal</p>
                                <p class="text-sm font-bold text-navy bg-slate-50 border border-slate-100 rounded-lg px-3 py-2" x-text="form.tanggal"></p>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Jam Mulai</p>
                                <p class="text-sm font-bold text-navy bg-slate-50 border border-slate-100 rounded-lg px-3 py-2" x-text="form.jamMulai"></p>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Jam Selesai</p>
                                <p class="text-sm font-bold text-navy bg-slate-50 border border-slate-100 rounded-lg px-3 py-2" x-text="form.jamSelesai"></p>
                            </div>
                        </div>
                    </div>

                    <!-- Material Grid (Read-Only) -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <!-- Material Pendukung -->
                        <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
                            <div class="px-5 py-3 bg-slate-50 border-b border-slate-200">
                                <h5 class="text-xs font-bold text-slate-700 uppercase tracking-wider">Material Pendukung yang Digunakan</h5>
                            </div>
                            <div class="p-4 space-y-1.5">
                                <template x-for="(item, idx) in form.materialPendukung" :key="idx">
                                    <div class="flex items-center justify-between py-1.5 border-b border-slate-50 last:border-0">
                                        <span class="text-xs font-semibold text-slate-600" x-text="item.nama"></span>
                                        <span class="text-xs font-bold text-navy bg-slate-50 px-2.5 py-1 rounded-lg" x-text="item.qty || '—'"></span>
                                    </div>
                                </template>
                            </div>
                        </div>
                        <!-- Material Hasil Cleaning -->
                        <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
                            <div class="px-5 py-3 bg-slate-50 border-b border-slate-200">
                                <h5 class="text-xs font-bold text-slate-700 uppercase tracking-wider">Material Hasil Cleaning</h5>
                            </div>
                            <div class="p-4 space-y-1.5">
                                <template x-for="(item, idx) in form.materialHasil" :key="idx">
                                    <div class="flex items-center justify-between py-1.5 border-b border-slate-50 last:border-0">
                                        <span class="text-xs font-semibold text-slate-600" x-text="item.nama"></span>
                                        <span class="text-xs font-bold text-navy bg-slate-50 px-2.5 py-1 rounded-lg" x-text="item.qty || '—'"></span>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>

                    <!-- Verifikasi QC (Read-Only) -->
                    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
                        <div class="px-5 py-3 bg-emerald-50 border-b border-emerald-200 flex justify-between items-center">
                            <div>
                                <h5 class="text-xs font-bold text-emerald-800 uppercase tracking-wider">Hasil Verifikasi QC</h5>
                                <p class="text-[10px] text-emerald-600 mt-0.5">Semua rangkaian mesin sudah diperiksa dan lolos verifikasi</p>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="w-7 h-7 rounded-full bg-emerald-200 flex items-center justify-center text-emerald-700 text-[10px] font-bold">QC</div>
                                <span class="text-xs font-bold text-emerald-800" x-text="form.namaQC"></span>
                            </div>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-xs text-left">
                                <thead class="bg-slate-100 text-slate-500 font-bold uppercase text-[10px]">
                                    <tr>
                                        <th class="px-4 py-2.5 border-b border-slate-200">Rangkaian Mesin</th>
                                        <th class="px-4 py-2.5 border-b border-slate-200 text-center">Hasil Check 1</th>
                                        <th class="px-4 py-2.5 border-b border-slate-200 text-center">Status</th>
                                        <th class="px-4 py-2.5 border-b border-slate-200 text-center">Hasil Check 2</th>
                                        <th class="px-4 py-2.5 border-b border-slate-200 text-center">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    <template x-for="(row, idx) in form.qcRows" :key="idx">
                                        <tr>
                                            <td class="px-4 py-2.5 font-semibold text-navy" x-text="row.mesin"></td>
                                            <td class="px-4 py-2.5 text-center font-semibold text-slate-700" x-text="row.hasil1 || '—'"></td>
                                            <td class="px-4 py-2.5 text-center">
                                                <span class="px-2 py-0.5 rounded text-[10px] font-bold"
                                                      :class="row.status1 === 'OK' ? 'bg-emerald-100 text-emerald-700' : (row.status1 === 'Cleaning Ulang' ? 'bg-red-100 text-red-700' : 'bg-slate-100 text-slate-400')"
                                                      x-text="row.status1 || '—'"></span>
                                            </td>
                                            <td class="px-4 py-2.5 text-center font-semibold text-slate-700" x-text="row.hasil2 || '—'"></td>
                                            <td class="px-4 py-2.5 text-center">
                                                <span class="px-2 py-0.5 rounded text-[10px] font-bold"
                                                      :class="row.status2 === 'OK' ? 'bg-emerald-100 text-emerald-700' : (row.status2 === 'Cleaning Ulang' ? 'bg-red-100 text-red-700' : 'bg-slate-100 text-slate-400')"
                                                      x-text="row.status2 || '—'"></span>
                                            </td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Approval Strip (Read-Only, sudah tertanda) -->
                    <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
                        <h5 class="text-xs font-bold text-slate-500 uppercase tracking-widest mb-4">Tanda Tangan & Approval</h5>
                        <div class="grid grid-cols-3 gap-5">
                            <div class="text-center border border-emerald-200 bg-emerald-50/50 rounded-xl p-4">
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2">Dibuat Oleh</p>
                                <div class="h-10 flex items-end justify-center">
                                    <p class="text-xs font-bold text-navy border-b-2 border-emerald-400 w-full text-center pb-1" x-text="form.namaOperator"></p>
                                </div>
                                <p class="text-[10px] text-emerald-600 mt-2 font-semibold">Operator ✓</p>
                            </div>
                            <div class="text-center border border-emerald-200 bg-emerald-50/50 rounded-xl p-4">
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2">Diperiksa Oleh</p>
                                <div class="h-10 flex items-end justify-center">
                                    <p class="text-xs font-bold text-navy border-b-2 border-emerald-400 w-full text-center pb-1" x-text="form.namaForeman"></p>
                                </div>
                                <p class="text-[10px] text-emerald-600 mt-2 font-semibold">Foreman ✓</p>
                            </div>
                            <div class="text-center border border-emerald-300 bg-emerald-100 rounded-xl p-4">
                                <p class="text-[10px] font-bold text-emerald-700 uppercase tracking-wider mb-2">Verifikasi Oleh</p>
                                <div class="h-10 flex items-end justify-center">
                                    <p class="text-xs font-bold text-emerald-800 border-b-2 border-emerald-400 w-full text-center pb-1" x-text="form.namaQC"></p>
                                </div>
                                <p class="text-[10px] text-emerald-700 mt-2 font-bold">QC ✓ Lolos</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ============ PAGE: PENIMBANGAN ============ -->
                <div x-show="activeStep === 'timbang'" class="space-y-5">
                    <!-- Stats Row -->
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                        <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-sm">
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Batch Selesai</p>
                            <p class="text-2xl font-black text-emerald-600">50 <span class="text-sm font-bold text-slate-400">/ 50</span></p>
                            <p class="text-[10px] text-emerald-500 font-semibold mt-1">100% Selesai</p>
                        </div>
                        <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-sm">
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Mesin Timbang</p>
                            <p class="text-base font-black text-navy mt-2">Timbangan A-01</p>
                            <p class="text-[10px] text-slate-500 font-semibold mt-1">Kapasitas 500 Kg</p>
                        </div>
                        <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-sm">
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Rata-rata Durasi</p>
                            <p class="text-2xl font-black text-navy">12 <span class="text-sm font-bold text-slate-400">menit</span></p>
                            <p class="text-[10px] text-slate-500 font-semibold mt-1">per Batch</p>
                        </div>
                        <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-sm">
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Ketepatan Waktu</p>
                            <p class="text-2xl font-black text-emerald-600">On Time</p>
                            <p class="text-[10px] text-slate-500 font-semibold mt-1">Total Delay: 0 menit</p>
                        </div>
                        <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-sm">
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Shift Kerja</p>
                            <p class="text-base font-black text-navy mt-2" x-text="selectedEvent.timbangShift || 'Shift 1 · Team RED'"></p>
                            <p class="text-[10px] text-slate-500 font-semibold mt-1" x-text="selectedEvent.timbangOperators || 'Budi, Mia, Ayu'"></p>
                        </div>
                        <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-sm">
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Tanggal Penimbangan</p>
                            <p class="text-base font-black text-navy mt-2" x-text="selectedEvent.timbangDate || '05 Sep 2026'"></p>
                            <p class="text-[10px] text-slate-500 font-semibold mt-1" x-text="'Jam Mulai: ' + (selectedEvent.timbangStartTime || '06:00')"></p>
                        </div>
                    </div>
                    <!-- Chart -->
                    <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
                        <div class="flex justify-between items-start mb-4 flex-wrap gap-3">
                            <div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Grafik Durasi Penimbangan</p>
                                <p class="text-sm font-bold text-navy mt-0.5">Durasi per Batch (Menit) — Proses Timbang</p>
                            </div>
                            <div class="flex items-center gap-2">
                                <select x-model="timbangShiftFilter" @change="initStepChart('timbang')" class="bg-slate-50 border border-slate-200 rounded-lg text-[11px] font-bold px-2 py-1.5 text-slate-600 focus:ring-cyan focus:border-cyan outline-none">
                                    <option value="all">Semua Shift</option>
                                    <option value="Shift 1">Shift 1 · Team RED</option>
                                    <option value="Shift 2">Shift 2 · Team GREEN</option>
                                    <option value="Shift 3">Shift 3 · Team YELLOW</option>
                                </select>
                                <span class="px-2 py-1 bg-emerald-100 text-emerald-700 text-[10px] font-bold rounded-lg whitespace-nowrap">Target ≤ 15 menit</span>
                            </div>
                        </div>
                        <div class="relative h-56">
                            <canvas id="timbangChart"></canvas>
                        </div>
                        <p class="text-[10px] text-slate-400 mt-2">Arahkan kursor ke batang grafik untuk melihat operator, shift, dan jam mulai penimbangan.</p>
                    </div>
                    <!-- Detail Table -->
                    <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm">
                        <div class="px-5 py-3 border-b border-slate-100 flex items-center justify-between">
                            <p class="text-xs font-bold text-slate-700">Rincian Batch Terakhir</p>
                            <span class="text-[10px] text-slate-400">Menampilkan 5 batch terakhir</span>
                        </div>
                        <table class="w-full text-xs">
                            <thead class="bg-slate-50 border-b border-slate-100">
                                <tr class="text-[10px] text-slate-500 font-bold uppercase">
                                    <th class="p-3 text-left">Batch</th>
                                    <th class="p-3 text-left">Operator</th>
                                    <th class="p-3 text-left">Shift</th>
                                    <th class="p-3 text-right">Mulai</th>
                                    <th class="p-3 text-right">Selesai</th>
                                    <th class="p-3 text-right">Durasi</th>
                                    <th class="p-3 text-right">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                <tr><td class="p-3 font-bold text-navy">Batch #50</td><td class="p-3 text-slate-600">Mia</td><td class="p-3 text-slate-500">Shift 1</td><td class="p-3 text-right text-slate-500">08:00</td><td class="p-3 text-right text-slate-500">08:13</td><td class="p-3 text-right font-bold text-navy">13 mnt</td><td class="p-3 text-right"><span class="px-1.5 py-0.5 bg-emerald-100 text-emerald-700 rounded font-bold">On Time</span></td></tr>
                                <tr><td class="p-3 font-bold text-navy">Batch #49</td><td class="p-3 text-slate-600">Ayu</td><td class="p-3 text-slate-500">Shift 1</td><td class="p-3 text-right text-slate-500">07:47</td><td class="p-3 text-right text-slate-500">07:59</td><td class="p-3 text-right font-bold text-navy">12 mnt</td><td class="p-3 text-right"><span class="px-1.5 py-0.5 bg-emerald-100 text-emerald-700 rounded font-bold">On Time</span></td></tr>
                                <tr><td class="p-3 font-bold text-navy">Batch #48</td><td class="p-3 text-slate-600">Mia</td><td class="p-3 text-slate-500">Shift 1</td><td class="p-3 text-right text-slate-500">07:31</td><td class="p-3 text-right text-slate-500">07:45</td><td class="p-3 text-right font-bold text-amber-600">14 mnt</td><td class="p-3 text-right"><span class="px-1.5 py-0.5 bg-amber-100 text-amber-700 rounded font-bold">Lambat</span></td></tr>
                                <tr><td class="p-3 font-bold text-navy">Batch #47</td><td class="p-3 text-slate-600">Fitri</td><td class="p-3 text-slate-500">Shift 2</td><td class="p-3 text-right text-slate-500">07:19</td><td class="p-3 text-right text-slate-500">07:30</td><td class="p-3 text-right font-bold text-navy">11 mnt</td><td class="p-3 text-right"><span class="px-1.5 py-0.5 bg-emerald-100 text-emerald-700 rounded font-bold">On Time</span></td></tr>
                                <tr><td class="p-3 font-bold text-navy">Batch #46</td><td class="p-3 text-slate-600">Hana</td><td class="p-3 text-slate-500">Shift 2</td><td class="p-3 text-right text-slate-500">07:07</td><td class="p-3 text-right text-slate-500">07:18</td><td class="p-3 text-right font-bold text-navy">11 mnt</td><td class="p-3 text-right"><span class="px-1.5 py-0.5 bg-emerald-100 text-emerald-700 rounded font-bold">On Time</span></td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- ============ PAGE: MIXING ============ -->
                <div x-show="activeStep === 'mixing'" class="space-y-5">
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-sm">
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Batch Selesai</p>
                            <p class="text-2xl font-black text-emerald-600">50 <span class="text-sm font-bold text-slate-400">/ 50</span></p>
                            <p class="text-[10px] text-emerald-500 font-semibold mt-1">100% Selesai</p>
                        </div>
                        <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-sm">
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Mesin Mixing</p>
                            <p class="text-base font-black text-navy mt-2">Mixer A-01</p>
                            <p class="text-[10px] text-slate-500 font-semibold mt-1">High-Speed Mixer</p>
                        </div>
                        <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-sm">
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Rata-rata Durasi</p>
                            <p class="text-2xl font-black text-navy">20 <span class="text-sm font-bold text-slate-400">menit</span></p>
                            <p class="text-[10px] text-slate-500 font-semibold mt-1">per Batch (MP+ML)</p>
                        </div>
                        <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-sm">
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Ketepatan Waktu</p>
                            <p class="text-2xl font-black text-emerald-600">On Time</p>
                            <p class="text-[10px] text-slate-500 font-semibold mt-1">Total Delay: 5 menit</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Parameter Suhu Mixing</p>
                            <p class="text-sm font-bold text-navy mb-3">Grafik Suhu Mixer (°C) per Batch</p>
                            <div class="relative h-48">
                                <canvas id="mixingTempChart"></canvas>
                            </div>
                        </div>
                        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Durasi Mixing</p>
                            <p class="text-sm font-bold text-navy mb-3">Durasi Mixing per Batch (Menit)</p>
                            <div class="relative h-48">
                                <canvas id="mixingTimeChart"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
                        <h5 class="text-xs font-bold text-slate-600 mb-3">Ringkasan Parameter Mixing</h5>
                        <div class="grid grid-cols-3 gap-4 text-sm">
                            <div class="bg-slate-50 rounded-xl p-3 text-center"><p class="text-[10px] text-slate-400 font-bold uppercase">Suhu Hot Mixing (Avg)</p><p class="text-lg font-black text-navy mt-1">118 °C</p></div>
                            <div class="bg-slate-50 rounded-xl p-3 text-center"><p class="text-[10px] text-slate-400 font-bold uppercase">Suhu Cold Mixing (Avg)</p><p class="text-lg font-black text-navy mt-1">52 °C</p></div>
                            <div class="bg-slate-50 rounded-xl p-3 text-center"><p class="text-[10px] text-slate-400 font-bold uppercase">RPM Rata-rata</p><p class="text-lg font-black text-navy mt-1">1450 RPM</p></div>
                        </div>
                    </div>
                </div>

                <!-- ============ PAGE: EXTRUDER ============ -->
                <div x-show="activeStep === 'extruder'" class="space-y-5">
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div class="bg-white border border-blue-200 rounded-2xl p-4 shadow-sm ring-1 ring-blue-100">
                            <p class="text-[10px] font-bold text-blue-400 uppercase tracking-widest mb-1">Batch Selesai</p>
                            <p class="text-2xl font-black text-blue-600">28 <span class="text-sm font-bold text-slate-400">/ 50</span></p>
                            <div class="w-full bg-slate-100 rounded-full h-1.5 mt-2">
                                <div class="bg-blue-500 h-1.5 rounded-full" style="width: 56%"></div>
                            </div>
                            <p class="text-[10px] text-blue-500 font-semibold mt-1">56% · Sedang Berjalan</p>
                        </div>
                        <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-sm">
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Mesin Extruder</p>
                            <p class="text-base font-black text-navy mt-2">Extruder E-03</p>
                            <p class="text-[10px] text-slate-500 font-semibold mt-1">Line 1 · Screw Ø 65mm</p>
                        </div>
                        <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-sm">
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Output Aktual</p>
                            <p class="text-2xl font-black text-navy">495 <span class="text-sm font-bold text-slate-400">Kg/Jam</span></p>
                            <p class="text-[10px] text-slate-500 font-semibold mt-1">Target: 500 Kg/Jam</p>
                        </div>
                        <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-sm">
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Ketepatan Waktu</p>
                            <p class="text-2xl font-black text-emerald-600">On Time</p>
                            <p class="text-[10px] text-slate-500 font-semibold mt-1">Delay: 0.0 jam</p>
                        </div>
                    </div>
                    <!-- Filter Grafik -->
                    <div class="flex items-center justify-end gap-2">
                        <span class="text-[10px] font-bold text-slate-400 uppercase">Filter Grafik:</span>
                        <select x-model="extruderShiftFilter" @change="initStepChart('extruder')" class="bg-white border border-slate-200 rounded-lg text-[11px] font-bold px-2 py-1.5 text-slate-600 focus:ring-cyan focus:border-cyan outline-none">
                            <option value="all">Semua Shift</option>
                            <option value="Shift 1">Shift 1 · Team RED</option>
                            <option value="Shift 2">Shift 2 · Team GREEN</option>
                            <option value="Shift 3">Shift 3 · Team YELLOW</option>
                        </select>
                    </div>
                    <!-- Charts -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
                            <div class="flex justify-between items-start mb-3">
                                <div>
                                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Parameter Mesin · Per Jam</p>
                                    <p class="text-sm font-bold text-navy mt-0.5">Grafik Suhu Extruder (°C)</p>
                                </div>
                                <span class="text-[10px] font-bold bg-blue-100 text-blue-700 px-2 py-1 rounded-lg">Live</span>
                            </div>
                            <div class="relative h-48">
                                <canvas id="tempChart"></canvas>
                            </div>
                            <p class="text-[10px] text-slate-400 mt-2">Hover titik grafik untuk melihat operator, shift & jam.</p>
                        </div>
                        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
                            <div class="flex justify-between items-start mb-3">
                                <div>
                                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Output · Per Jam</p>
                                    <p class="text-sm font-bold text-navy mt-0.5">Output Extruder (Kg/Jam)</p>
                                </div>
                            </div>
                            <div class="relative h-48">
                                <canvas id="timeChart"></canvas>
                            </div>
                            <p class="text-[10px] text-slate-400 mt-2">Hover batang grafik untuk melihat operator, shift & jam.</p>
                        </div>
                    </div>
                    <!-- Semua Parameter Extruder (Aktual) -->
                    <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
                        <h5 class="text-xs font-bold text-slate-600 mb-4">Parameter Extruder Aktual (Semua Zone)</h5>
                        <div class="grid grid-cols-3 md:grid-cols-6 gap-3 text-center">
                            <div class="bg-slate-50 rounded-xl p-3"><p class="text-[10px] text-slate-400 font-bold uppercase">Zone 1</p><p class="text-base font-black text-navy mt-1">160°C</p></div>
                            <div class="bg-slate-50 rounded-xl p-3"><p class="text-[10px] text-slate-400 font-bold uppercase">Zone 2</p><p class="text-base font-black text-navy mt-1">170°C</p></div>
                            <div class="bg-slate-50 rounded-xl p-3"><p class="text-[10px] text-slate-400 font-bold uppercase">Zone 3</p><p class="text-base font-black text-navy mt-1">175°C</p></div>
                            <div class="bg-blue-50 rounded-xl p-3 ring-1 ring-blue-200"><p class="text-[10px] text-blue-400 font-bold uppercase">Zone 4 (Die)</p><p class="text-base font-black text-blue-700 mt-1">178°C</p></div>
                            <div class="bg-slate-50 rounded-xl p-3"><p class="text-[10px] text-slate-400 font-bold uppercase">RPM Screw</p><p class="text-base font-black text-navy mt-1">35 RPM</p></div>
                            <div class="bg-slate-50 rounded-xl p-3"><p class="text-[10px] text-slate-400 font-bold uppercase">Ampere</p><p class="text-base font-black text-navy mt-1">42 A</p></div>
                        </div>
                    </div>

                    <!-- Input Parameter per Jam (Live Input + Grafik) -->
                    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden" x-data="extruderHourlyApp()">
                        <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50">
                            <div>
                                <p class="text-xs font-bold text-slate-700">Pencatatan Parameter per Jam</p>
                                <p class="text-[10px] text-slate-400 mt-0.5">Input setiap jam — grafik akan langsung diperbarui secara otomatis</p>
                            </div>
                            <span class="w-2 h-2 bg-blue-500 rounded-full animate-pulse inline-block"></span>
                        </div>

                        <!-- Input Form Row -->
                        <div class="p-5 border-b border-slate-100 bg-blue-50/30">
                            <div class="grid grid-cols-2 md:grid-cols-8 gap-3 items-end">
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Jam</label>
                                    <input type="time" x-model="newEntry.jam" class="w-full bg-white border border-slate-200 rounded-lg px-2 py-1.5 text-xs font-bold focus:ring-1 focus:ring-blue-400 outline-none">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Zone 1 (°C)</label>
                                    <input type="number" x-model.number="newEntry.z1" class="w-full bg-white border border-slate-200 rounded-lg px-2 py-1.5 text-xs font-bold focus:ring-1 focus:ring-blue-400 outline-none" placeholder="160">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Zone 2 (°C)</label>
                                    <input type="number" x-model.number="newEntry.z2" class="w-full bg-white border border-slate-200 rounded-lg px-2 py-1.5 text-xs font-bold focus:ring-1 focus:ring-blue-400 outline-none" placeholder="170">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Zone 3 (°C)</label>
                                    <input type="number" x-model.number="newEntry.z3" class="w-full bg-white border border-slate-200 rounded-lg px-2 py-1.5 text-xs font-bold focus:ring-1 focus:ring-blue-400 outline-none" placeholder="175">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Zone 4 Die (°C)</label>
                                    <input type="number" x-model.number="newEntry.z4" class="w-full bg-white border border-slate-200 rounded-lg px-2 py-1.5 text-xs font-bold focus:ring-1 focus:ring-blue-400 outline-none" placeholder="178">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">RPM</label>
                                    <input type="number" x-model.number="newEntry.rpm" class="w-full bg-white border border-slate-200 rounded-lg px-2 py-1.5 text-xs font-bold focus:ring-1 focus:ring-blue-400 outline-none" placeholder="35">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Ampere</label>
                                    <input type="number" x-model.number="newEntry.amp" class="w-full bg-white border border-slate-200 rounded-lg px-2 py-1.5 text-xs font-bold focus:ring-1 focus:ring-blue-400 outline-none" placeholder="42">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Operator</label>
                                    <div class="flex gap-2">
                                        <input type="text" x-model="newEntry.operator" class="flex-1 bg-white border border-slate-200 rounded-lg px-2 py-1.5 text-xs font-bold focus:ring-1 focus:ring-blue-400 outline-none" placeholder="Nama">
                                        <button @click="addHourlyEntry()" class="px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-lg shadow-sm transition">+</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Grafik Suhu per Jam (Realtime Update) -->
                        <div class="p-5 border-b border-slate-100">
                            <p class="text-xs font-bold text-slate-700 mb-3">Grafik Suhu Extruder per Jam (°C) — Realtime</p>
                            <div class="relative h-44">
                                <canvas id="extruderHourlyChart"></canvas>
                            </div>
                        </div>

                        <!-- Tabel Rincian Per Jam + Rata-rata -->
                        <div class="overflow-x-auto">
                            <table class="w-full text-xs">
                                <thead class="bg-slate-50 border-b border-slate-100">
                                    <tr class="text-[10px] text-slate-500 font-bold uppercase">
                                        <th class="p-3 text-left">Jam</th>
                                        <th class="p-3 text-right">Zone 1</th>
                                        <th class="p-3 text-right">Zone 2</th>
                                        <th class="p-3 text-right">Zone 3</th>
                                        <th class="p-3 text-right">Zone 4 (Die)</th>
                                        <th class="p-3 text-right">RPM</th>
                                        <th class="p-3 text-right">Ampere</th>
                                        <th class="p-3 text-left">Operator</th>
                                        <th class="p-3 text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-50">
                                    <template x-for="(row, idx) in hourlyData" :key="idx">
                                        <tr class="hover:bg-slate-50">
                                            <td class="p-3 font-bold text-navy" x-text="row.jam"></td>
                                            <td class="p-3 text-right text-slate-600" x-text="row.z1 + '°C'"></td>
                                            <td class="p-3 text-right text-slate-600" x-text="row.z2 + '°C'"></td>
                                            <td class="p-3 text-right text-slate-600" x-text="row.z3 + '°C'"></td>
                                            <td class="p-3 text-right font-bold text-blue-700" x-text="row.z4 + '°C'"></td>
                                            <td class="p-3 text-right text-slate-600" x-text="row.rpm + ' RPM'"></td>
                                            <td class="p-3 text-right text-slate-600" x-text="row.amp + ' A'"></td>
                                            <td class="p-3 text-slate-600" x-text="row.operator"></td>
                                            <td class="p-3 text-center">
                                                <button @click="hourlyData.splice(idx,1); updateHourlyChart()" class="text-red-400 hover:text-red-600 text-[10px] font-bold">Hapus</button>
                                            </td>
                                        </tr>
                                    </template>
                                </tbody>
                                <!-- Rata-rata row -->
                                <tfoot class="bg-blue-50 border-t-2 border-blue-200">
                                    <tr class="font-black text-blue-800 text-[10px] uppercase">
                                        <td class="p-3">Rata-rata</td>
                                        <td class="p-3 text-right" x-text="avg('z1') + '°C'"></td>
                                        <td class="p-3 text-right" x-text="avg('z2') + '°C'"></td>
                                        <td class="p-3 text-right" x-text="avg('z3') + '°C'"></td>
                                        <td class="p-3 text-right" x-text="avg('z4') + '°C'"></td>
                                        <td class="p-3 text-right" x-text="avg('rpm') + ' RPM'"></td>
                                        <td class="p-3 text-right" x-text="avg('amp') + ' A'"></td>
                                        <td class="p-3" colspan="2"></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- ============ PAGE 5: BAGGING (Completed) ============ -->
                <div x-show="activeStep === 'bagging'" class="space-y-5">
                    <!-- Stats Row -->
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                        <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-sm">
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Sak Selesai</p>
                            <p class="text-2xl font-black text-emerald-600">600 <span class="text-sm font-bold text-slate-400">/ 600</span></p>
                            <p class="text-[10px] text-emerald-500 font-semibold mt-1">100% Selesai</p>
                        </div>
                        <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-sm">
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Mesin Bagging</p>
                            <p class="text-base font-black text-navy mt-2">Bagging Line 01</p>
                            <p class="text-[10px] text-slate-500 font-semibold mt-1">Semi-Auto · 25 Kg/Sak</p>
                        </div>
                        <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-sm">
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Total Berat</p>
                            <p class="text-2xl font-black text-navy">15.000 <span class="text-sm font-bold text-slate-400">Kg</span></p>
                            <p class="text-[10px] text-slate-500 font-semibold mt-1">600 sak × 25 Kg</p>
                        </div>
                        <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-sm">
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Rata-rata Durasi</p>
                            <p class="text-2xl font-black text-navy">2.1 <span class="text-sm font-bold text-slate-400">mnt/sak</span></p>
                            <p class="text-[10px] text-slate-500 font-semibold mt-1">Target ≤ 2.5 mnt</p>
                        </div>
                        <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-sm">
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Ketepatan Waktu</p>
                            <p class="text-2xl font-black text-emerald-600">On Time</p>
                            <p class="text-[10px] text-slate-500 font-semibold mt-1">Delay: 0 menit</p>
                        </div>
                        <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-sm">
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Transfer ke Gudang</p>
                            <p class="text-2xl font-black text-emerald-600">100%</p>
                            <p class="text-[10px] text-emerald-500 font-semibold mt-1">Semua sudah ditransfer</p>
                        </div>
                    </div>

                    <!-- QC Goods Check -->
                    <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
                        <div class="flex justify-between items-center mb-4">
                            <div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">QC Goods Check</p>
                                <p class="text-sm font-bold text-navy">Hasil Pemeriksaan Kualitas Produk Akhir</p>
                            </div>
                            <span class="px-3 py-1.5 bg-emerald-100 text-emerald-700 text-xs font-bold rounded-xl flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                PASSED
                            </span>
                        </div>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <div class="bg-emerald-50 rounded-xl p-3 text-center border border-emerald-100">
                                <p class="text-[10px] text-emerald-600 font-bold uppercase">Warna</p>
                                <p class="text-sm font-black text-emerald-800 mt-1">Sesuai Std</p>
                            </div>
                            <div class="bg-emerald-50 rounded-xl p-3 text-center border border-emerald-100">
                                <p class="text-[10px] text-emerald-600 font-bold uppercase">Ukuran Granule</p>
                                <p class="text-sm font-black text-emerald-800 mt-1">3.2 mm (OK)</p>
                            </div>
                            <div class="bg-emerald-50 rounded-xl p-3 text-center border border-emerald-100">
                                <p class="text-[10px] text-emerald-600 font-bold uppercase">Moisture</p>
                                <p class="text-sm font-black text-emerald-800 mt-1">0.08% (≤ 0.1%)</p>
                            </div>
                            <div class="bg-emerald-50 rounded-xl p-3 text-center border border-emerald-100">
                                <p class="text-[10px] text-emerald-600 font-bold uppercase">Kontaminasi</p>
                                <p class="text-sm font-black text-emerald-800 mt-1">Tidak Ada</p>
                            </div>
                        </div>
                    </div>

                    <!-- Grafik Bagging -->
                    <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Produktivitas Bagging</p>
                        <p class="text-sm font-bold text-navy mb-3">Sak Selesai per Jam</p>
                        <div class="relative h-48">
                            <canvas id="baggingChart"></canvas>
                        </div>
                    </div>

                    <!-- Tabel Rincian -->
                    <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm">
                        <div class="px-5 py-3 border-b border-slate-100 flex items-center justify-between">
                            <p class="text-xs font-bold text-slate-700">Rincian Output per Shift</p>
                            <span class="text-[10px] text-slate-400">Ringkasan 3 shift terakhir</span>
                        </div>
                        <table class="w-full text-xs">
                            <thead class="bg-slate-50 border-b border-slate-100">
                                <tr class="text-[10px] text-slate-500 font-bold uppercase">
                                    <th class="p-3 text-left">Shift</th>
                                    <th class="p-3 text-left">Operator</th>
                                    <th class="p-3 text-right">Sak Selesai</th>
                                    <th class="p-3 text-right">Berat (Kg)</th>
                                    <th class="p-3 text-right">Avg/Sak</th>
                                    <th class="p-3 text-right">Reject</th>
                                    <th class="p-3 text-right">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                <tr><td class="p-3 font-bold text-navy">Shift 1</td><td class="p-3 text-slate-600">Budi, Mia</td><td class="p-3 text-right font-bold text-navy">210 sak</td><td class="p-3 text-right text-slate-600">5.250 Kg</td><td class="p-3 text-right text-slate-600">2.0 mnt</td><td class="p-3 text-right text-slate-500">0</td><td class="p-3 text-right"><span class="px-1.5 py-0.5 bg-emerald-100 text-emerald-700 rounded font-bold">On Time</span></td></tr>
                                <tr><td class="p-3 font-bold text-navy">Shift 2</td><td class="p-3 text-slate-600">Ayu, Bagas</td><td class="p-3 text-right font-bold text-navy">200 sak</td><td class="p-3 text-right text-slate-600">5.000 Kg</td><td class="p-3 text-right text-slate-600">2.2 mnt</td><td class="p-3 text-right text-slate-500">1</td><td class="p-3 text-right"><span class="px-1.5 py-0.5 bg-emerald-100 text-emerald-700 rounded font-bold">On Time</span></td></tr>
                                <tr><td class="p-3 font-bold text-navy">Shift 3</td><td class="p-3 text-slate-600">Rudi, Citra</td><td class="p-3 text-right font-bold text-navy">190 sak</td><td class="p-3 text-right text-slate-600">4.750 Kg</td><td class="p-3 text-right text-slate-600">2.1 mnt</td><td class="p-3 text-right text-slate-500">0</td><td class="p-3 text-right"><span class="px-1.5 py-0.5 bg-emerald-100 text-emerald-700 rounded font-bold">On Time</span></td></tr>
                            </tbody>
                            <tfoot class="bg-slate-50 border-t border-slate-200">
                                <tr class="font-bold">
                                    <td class="p-3 text-navy" colspan="2">TOTAL</td>
                                    <td class="p-3 text-right font-black text-navy">600 sak</td>
                                    <td class="p-3 text-right font-black text-navy">15.000 Kg</td>
                                    <td class="p-3 text-right text-slate-600">2.1 mnt</td>
                                    <td class="p-3 text-right text-slate-500">1</td>
                                    <td class="p-3 text-right"><span class="px-1.5 py-0.5 bg-emerald-100 text-emerald-700 rounded font-bold">Selesai</span></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <!-- CLEANING DETAIL standalone dihapus — sudah diintegrasikan ke Tab 1 -->
            <div x-show="false" class="hidden">
                <div class="max-w-5xl mx-auto space-y-6">
                    
                    <!-- Header Info Card -->
                    <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm flex justify-between items-center relative overflow-hidden">
                        <div class="absolute right-0 top-0 w-32 h-32 bg-violet-50 rounded-bl-full -z-10"></div>
                        <div class="flex items-center gap-5">
                            <div class="w-16 h-16 rounded-2xl bg-violet-100 flex items-center justify-center text-violet-600 shadow-inner">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                            </div>
                            <div>
                                <h5 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Pembersihan Mesin & Ganti Warna</h5>
                                <h2 class="text-2xl font-black text-navy" x-text="selectedEvent.title"></h2>
                                <p class="text-sm font-semibold text-slate-500 mt-1" x-text="'Target: ' + (selectedEvent.machine || 'Mixer A-01 / Ext Line 1')"></p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Pelaksana</p>
                            <p class="text-sm font-bold text-slate-700 bg-slate-100 px-3 py-1 rounded-lg" x-text="selectedEvent.team || 'Team RED · Shift 3'"></p>
                            <p class="text-xs font-semibold text-slate-500 mt-2" x-text="'Tanggal: ' + (selectedEvent.dateRange || '08 Sep 2026')"></p>
                        </div>
                    </div>

                    <!-- Progress Tracker & Operator -->
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <!-- Progress Bar -->
                        <div class="lg:col-span-2 bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
                            <div class="flex justify-between items-end mb-6">
                                <div>
                                    <h5 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Progress Pembersihan</h5>
                                    <p class="text-sm font-bold text-navy">Tahap 2: Pembersihan Screw & Barrel</p>
                                </div>
                                <span class="text-2xl font-black text-violet-600">60%</span>
                            </div>
                            
                            <!-- Custom Progress Steps -->
                            <div class="relative pt-2 pb-6">
                                <div class="absolute top-4 left-0 w-full h-1 bg-slate-100 rounded-full -z-10"></div>
                                <div class="absolute top-4 left-0 w-[60%] h-1 bg-violet-500 rounded-full -z-10 transition-all duration-1000"></div>
                                
                                <div class="flex justify-between relative">
                                    <div class="flex flex-col items-center gap-2">
                                        <div class="w-6 h-6 rounded-full bg-violet-500 text-white flex items-center justify-center shadow-md">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                        </div>
                                        <p class="text-[10px] font-bold text-slate-700 mt-1">Purging</p>
                                    </div>
                                    <div class="flex flex-col items-center gap-2">
                                        <div class="w-6 h-6 rounded-full bg-violet-500 text-white flex items-center justify-center shadow-md ring-4 ring-violet-100 animate-pulse">
                                            <span class="text-xs font-bold">2</span>
                                        </div>
                                        <p class="text-[10px] font-bold text-violet-700 mt-1">Manual Clean</p>
                                    </div>
                                    <div class="flex flex-col items-center gap-2">
                                        <div class="w-6 h-6 rounded-full bg-slate-200 text-slate-400 flex items-center justify-center border-2 border-white">
                                            <span class="text-xs font-bold">3</span>
                                        </div>
                                        <p class="text-[10px] font-bold text-slate-400 mt-1">Pasang Die</p>
                                    </div>
                                    <div class="flex flex-col items-center gap-2">
                                        <div class="w-6 h-6 rounded-full bg-slate-200 text-slate-400 flex items-center justify-center border-2 border-white">
                                            <span class="text-xs font-bold">4</span>
                                        </div>
                                        <p class="text-[10px] font-bold text-slate-400 mt-1">Pemanasan</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Daftar Operator -->
                        <div class="lg:col-span-1 bg-white border border-slate-200 rounded-2xl p-6 shadow-sm flex flex-col">
                            <h5 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4">Operator Bertugas</h5>
                            <div class="flex-1 space-y-3" x-html="(selectedEvent.shifts && selectedEvent.shifts.length > 0) ? selectedEvent.shifts.map(s => `
                                <div class='flex items-center gap-3 p-2 rounded-xl border border-slate-100 bg-slate-50'>
                                    <div class='w-8 h-8 rounded-full bg-slate-200 flex flex-shrink-0 items-center justify-center text-slate-500 font-bold text-xs'>OP</div>
                                    <p class='text-xs font-semibold text-slate-700'>${s}</p>
                                </div>
                            `).join('') : `
                                <div class='flex items-center gap-3 p-2 rounded-xl border border-slate-100 bg-slate-50'>
                                    <div class='w-8 h-8 rounded-full bg-slate-200 flex flex-shrink-0 items-center justify-center text-slate-500 font-bold text-xs'>B</div>
                                    <p class='text-xs font-semibold text-slate-700'>Budi (Lead)</p>
                                </div>
                                <div class='flex items-center gap-3 p-2 rounded-xl border border-slate-100 bg-slate-50'>
                                    <div class='w-8 h-8 rounded-full bg-slate-200 flex flex-shrink-0 items-center justify-center text-slate-500 font-bold text-xs'>A</div>
                                    <p class='text-xs font-semibold text-slate-700'>Anggun</p>
                                </div>
                            `">
                            </div>
                        </div>
                    </div>

                    <!-- Transisi Produk -->
                    <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
                        <h5 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4">Transisi Produk (Previous &rarr; Running)</h5>
                        <div class="flex items-center justify-between gap-4">
                            <!-- Previous Product -->
                            <div class="flex-1 bg-rose-50 border border-rose-100 rounded-xl p-4 relative">
                                <span class="absolute top-0 right-0 bg-rose-200 text-rose-800 text-[10px] font-bold px-2 py-1 rounded-bl-lg rounded-tr-xl uppercase tracking-wider">Previous</span>
                                <p class="text-xs text-rose-600 font-semibold mb-1">Warna: <span class="font-bold text-rose-800">Merah</span></p>
                                <p class="text-base font-bold text-rose-900 mb-2">ASITHYLEN P WHITE 9440 A</p>
                                <div class="flex justify-between items-center text-xs">
                                    <span class="text-rose-600">Qty Produksi:</span>
                                    <span class="font-bold text-rose-800 bg-rose-200/50 px-2 py-0.5 rounded">15.251,10 Kg</span>
                                </div>
                            </div>
                            
                            <!-- Arrow Indicator -->
                            <div class="flex flex-col items-center px-2">
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Pembersihan</p>
                                <div class="w-10 h-10 rounded-full bg-slate-100 border border-slate-200 flex items-center justify-center text-slate-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                </div>
                                <p class="text-xs font-bold text-violet-600 mt-1">3.50 Jam</p>
                            </div>

                            <!-- Running Product -->
                            <div class="flex-1 bg-emerald-50 border border-emerald-100 rounded-xl p-4 relative">
                                <span class="absolute top-0 right-0 bg-emerald-200 text-emerald-800 text-[10px] font-bold px-2 py-1 rounded-bl-lg rounded-tr-xl uppercase tracking-wider">Running</span>
                                <p class="text-xs text-emerald-600 font-semibold mb-1">Warna: <span class="font-bold text-emerald-800">White</span></p>
                                <p class="text-base font-bold text-emerald-900 mb-2">ASITHYLEN P WHITE 9660</p>
                                <div class="flex justify-between items-center text-xs">
                                    <span class="text-emerald-600">Qty Produksi:</span>
                                    <span class="font-bold text-emerald-800 bg-emerald-200/50 px-2 py-0.5 rounded">13.794,90 Kg</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Material Cleaning Details (Table format mimicking Excel) -->
                    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
                        <div class="p-5 border-b border-slate-200 flex justify-between items-center bg-slate-50">
                            <h5 class="text-xs font-bold text-slate-600 uppercase tracking-widest">Detail Material Cleaning & Biaya</h5>
                            <span class="px-3 py-1 bg-white border border-slate-200 rounded text-xs font-bold text-navy shadow-sm">Waktu Cleaning: <span class="text-violet-600">3.50 Jam</span></span>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-sm whitespace-nowrap">
                                <thead class="bg-slate-100/50 text-slate-500 font-bold text-xs uppercase tracking-wider">
                                    <tr>
                                        <th class="px-5 py-3 border-b border-slate-200">Type Material Cleaning</th>
                                        <th class="px-5 py-3 border-b border-slate-200">Material Cleaning</th>
                                        <th class="px-5 py-3 border-b border-slate-200 text-right">Qty/Proses</th>
                                        <th class="px-5 py-3 border-b border-slate-200 text-right">Total Qty</th>
                                        <th class="px-5 py-3 border-b border-slate-200 text-right">Harga Material</th>
                                        <th class="px-5 py-3 border-b border-slate-200 text-right bg-violet-50 text-violet-700">Biaya Cleaning</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100 text-slate-700">
                                    <tr class="hover:bg-slate-50 transition">
                                        <td class="px-5 py-3 font-semibold text-navy">GRADE B PP</td>
                                        <td class="px-5 py-3">Bekas Cleaningan PP (Grade B)</td>
                                        <td class="px-5 py-3 text-right font-medium">30.00 <span class="text-xs text-slate-400">Kg</span></td>
                                        <td class="px-5 py-3 text-right font-bold text-slate-800">30.00 <span class="text-xs text-slate-400">Kg</span></td>
                                        <td class="px-5 py-3 text-right text-slate-500">Rp 16.946,00</td>
                                        <td class="px-5 py-3 text-right font-bold text-violet-700 bg-violet-50/30">Rp 508.371,00</td>
                                    </tr>
                                </tbody>
                                <tfoot class="bg-slate-50 border-t-2 border-slate-200">
                                    <tr>
                                        <td colspan="3" class="px-5 py-3 text-right font-bold text-slate-500 uppercase text-xs">Total Keseluruhan:</td>
                                        <td class="px-5 py-3 text-right font-black text-navy">30.00 Kg</td>
                                        <td class="px-5 py-3 text-right font-bold text-slate-500">-</td>
                                        <td class="px-5 py-3 text-right font-black text-violet-700 bg-violet-100/50">Rp 508.371,00</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <template x-if="selectedEvent.parentSpk || selectedEvent.linkedCleaning">
                        <div class="bg-violet-50 border border-violet-200 rounded-2xl p-4 flex items-start gap-4 shadow-sm">
                            <span class="text-xl">🔗</span>
                            <div>
                                <p class="text-sm font-bold text-violet-800">Tugas Terhubung (Stacked Task)</p>
                                <p class="text-xs text-violet-600 mt-1">Cleaning ini di-stack secara otomatis sebelum/sesudah SPK <span class="font-bold bg-white px-1.5 py-0.5 rounded shadow-sm border border-violet-100" x-text="selectedEvent.parentSpk || selectedEvent.linkedCleaning"></span></p>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            <!-- ============ PAGE: RND TRIAL DETAIL ============ -->
            <div x-show="selectedEvent.type === 'rnd'" class="flex-1 overflow-y-auto p-6 min-h-0 bg-slate-50">
                <div class="max-w-3xl mx-auto space-y-6">
                    <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
                        <h5 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4">Informasi Trial R&D</h5>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-xs text-slate-500 mb-1">Nomor / Judul Trial</p>
                                <p class="text-sm font-bold text-navy" x-text="selectedEvent.title"></p>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500 mb-1">Sample Produk</p>
                                <p class="text-sm font-bold text-cyan" x-text="selectedEvent.product || 'Formula Eksperimen R&D'"></p>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500 mb-1">Mesin Digunakan</p>
                                <p class="text-sm font-bold text-slate-800" x-text="selectedEvent.machine || 'Extruder E-04'"></p>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500 mb-1">Durasi Trial</p>
                                <p class="text-sm font-bold text-slate-800" x-text="(selectedEvent.time || '13:00 - 15:00') + ' WIB'"></p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
                        <h5 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-3">Catatan / Objektif Trial</h5>
                        <div class="bg-slate-50 rounded-xl p-4 border border-slate-100 relative overflow-hidden">
                            <div class="absolute -left-2 -top-2 text-6xl text-slate-200 font-serif leading-none">"</div>
                            <p class="text-sm text-slate-600 font-medium relative z-10 pl-2">Uji coba komposisi aditif baru untuk meningkatkan flexural strength produk, target peningkatan efisiensi mesin 10% tanpa mengorbankan kejernihan warna. Mohon alokasikan mesin E-04 dengan suhu awal 170°C.</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Footer Modal -->
            <div class="px-5 py-3 bg-white border-t border-slate-200 flex justify-between items-center flex-shrink-0">
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse inline-block"></span>
                    <p class="text-[11px] text-slate-500">Data diperbarui otomatis dari sistem mesin & input operator.</p>
                </div>
                <div class="flex items-center gap-2">
                    <button @click="let so = stepOrder(); activeStep = so[Math.max(0, so.indexOf(activeStep)-1)]; setTimeout(() => initStepChart(activeStep), 80)"
                            x-show="selectedEvent.type !== 'rnd' && activeStep !== stepOrder()[0]"
                            class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl transition flex items-center gap-1">
                        ← Sebelumnya
                    </button>
                    <button @click="let so = stepOrder(); activeStep = so[Math.min(so.length-1, so.indexOf(activeStep)+1)]; setTimeout(() => initStepChart(activeStep), 80)"
                            x-show="selectedEvent.type !== 'rnd' && activeStep !== 'bagging'"
                            class="px-4 py-2 bg-navy hover:bg-navy-light text-white text-xs font-bold rounded-xl transition flex items-center gap-1">
                        Berikutnya →
                    </button>
                    <button @click="showEventModal = false" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl transition">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL LIST SLOT MESIN EXTRUDER E01 - E05 -->
    <div x-show="showSlotModal" style="display:none;" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm" x-transition>
        <div class="bg-white rounded-3xl shadow-2xl border border-slate-200 w-full max-w-2xl overflow-hidden" @click.away="showSlotModal = false">
            <div class="p-5 bg-navy text-white flex justify-between items-center">
                <div>
                    <h4 class="font-bold text-lg flex items-center gap-2">
                        <svg class="w-5 h-5 text-cyan" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        Daftar Slot Mesin Extruder (E01 – E05)
                    </h4>
                    <p class="text-xs text-slate-300 mt-0.5">Daftar alokasi tanggal & No. SPK pada setiap lini mesin Extruder</p>
                </div>
                <button @click="showSlotModal = false" class="text-white/70 hover:text-white transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <div class="p-6 space-y-4 max-h-[75vh] overflow-y-auto text-xs">
                <!-- Toolbar Search & Filter Slot -->
                <div class="flex items-center gap-3 bg-slate-50 p-3 rounded-2xl border border-slate-200">
                    <div class="relative flex-1">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <input type="text" x-model="slotSearchQuery" placeholder="Cari No. SPK, Produk, Tanggal..." class="w-full pl-9 pr-3 py-2 bg-white border border-slate-200 rounded-xl text-xs focus:ring-cyan focus:border-cyan outline-none transition-all">
                    </div>
                    <div class="w-48 flex-shrink-0">
                        <select x-model="slotMachineFilter" class="w-full py-2 px-3 bg-white border border-slate-200 rounded-xl text-xs font-bold text-slate-700 focus:ring-cyan focus:border-cyan outline-none transition-all">
                            <option value="all">Semua Mesin (E01–E05)</option>
                            <option value="Extruder E-01">Extruder E-01</option>
                            <option value="Extruder E-02">Extruder E-02</option>
                            <option value="Extruder E-03">Extruder E-03</option>
                            <option value="Extruder E-04">Extruder E-04</option>
                            <option value="Extruder E-05">Extruder E-05</option>
                        </select>
                    </div>
                </div>

                <!-- Lista Slot Hasil Filter -->
                <div class="space-y-3">
                    <template x-for="(slot, idx) in filteredSlots()" :key="idx">
                        <div class="p-4 bg-slate-50 border border-slate-200 rounded-2xl flex items-center justify-between gap-4 hover:border-cyan/50 transition-all">
                            <div>
                                <span class="px-2 py-0.5 rounded bg-cyan/10 text-cyan font-bold text-[10px] uppercase border border-cyan/20" x-text="slot.machine"></span>
                                <h5 class="font-bold text-navy text-sm mt-1" x-text="slot.spkNo + ' · ' + slot.product"></h5>
                                <p class="text-slate-500 mt-0.5">Tanggal: <b x-text="slot.date"></b> | Jam: <b x-text="slot.time"></b></p>
                            </div>
                            <div class="flex items-center gap-2 flex-shrink-0">
                                <button @click="adjustSlotTime(idx)" class="px-3 py-1.5 bg-white border border-slate-300 hover:bg-slate-100 text-slate-700 font-bold rounded-xl shadow-sm transition">
                                    Ubah Waktu
                                </button>
                                <button @click="deleteSlot(idx)" class="px-3 py-1.5 bg-red-50 hover:bg-red-100 text-red-600 border border-red-200 font-bold rounded-xl transition">
                                    Hapus Slot
                                </button>
                            </div>
                        </div>
                    </template>
                    <template x-if="filteredSlots().length === 0">
                        <div class="text-center py-8 bg-slate-50 rounded-2xl border border-dashed border-slate-200 text-slate-400">
                            <svg class="w-8 h-8 mx-auto mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <p class="font-semibold text-xs text-slate-600">Tidak ada slot mesin extruder yang sesuai</p>
                            <p class="text-[10px] mt-0.5">Coba ubah kata kunci pencarian atau pilihan filter mesin</p>
                        </div>
                    </template>
                </div>
            </div>

            <div class="p-4 bg-slate-50 border-t border-slate-100 flex justify-end">
                <button @click="showSlotModal = false" class="px-5 py-2 bg-navy text-white text-xs font-bold rounded-xl shadow-md hover:bg-navy-light transition">Tutup</button>
            </div>
        </div>
    </div>

        <!-- Mode Tree View SPK -->
        <div class="flex-1 w-full h-full overflow-auto space-y-6" x-show="viewMode === 'tree'" style="display: none;">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                
                <!-- DRAFT SECTION -->
                <div class="bg-slate-50 p-6 rounded-2xl border border-slate-200 flex flex-col">
                    <h4 class="font-bold text-navy text-sm uppercase tracking-wider mb-4 flex items-center gap-2 pb-2 border-b border-slate-200">
                        <svg class="w-5 h-5 text-amber-500" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"></path></svg>
                        Draft / Waiting SPK (<span x-text="draftSpks().length"></span>)
                    </h4>
                    
                    <div class="space-y-4 flex-1">
                        <template x-for="spk in draftSpks()" :key="spk.id">
                            <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm hover:border-amber-400 transition-colors relative">
                                <div class="flex justify-between items-start mb-2">
                                    <div>
                                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wide">Nomor SPK</span>
                                        <p class="font-bold text-navy text-base" x-text="spk.id"></p>
                                    </div>
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold border"
                                          :class="spk.status === 'Revised' ? 'bg-red-50 text-red-700 border-red-200' : 'bg-amber-50 text-amber-700 border-amber-200'"
                                          x-text="spk.status"></span>
                                </div>
                                <div class="grid grid-cols-2 gap-2 text-xs text-slate-600 mb-3">
                                    <div>
                                        <p class="text-slate-400">Produk</p>
                                        <p class="font-semibold text-slate-800" x-text="spk.product"></p>
                                    </div>
                                    <div>
                                        <p class="text-slate-400">Jumlah</p>
                                        <p class="font-semibold text-slate-800" x-text="spk.qty + ' Batch'"></p>
                                    </div>
                                </div>

                                <!-- Approvals list -->
                                <div class="mb-3 p-2 bg-slate-50 rounded-lg text-[10px] flex gap-3 justify-between items-center">
                                    <span class="font-bold text-slate-500">Approvals:</span>
                                    <div class="flex gap-2">
                                        <span class="px-1.5 py-0.5 rounded" :class="spk.approvals.gudang === 'Acc' ? 'bg-emerald-50 text-emerald-700 font-bold' : 'bg-amber-50 text-amber-600'">Gudang</span>
                                        <span class="px-1.5 py-0.5 rounded" :class="spk.approvals.rnd === 'Acc' ? 'bg-emerald-50 text-emerald-700 font-bold' : (spk.approvals.rnd === 'Revised' ? 'bg-red-50 text-red-600 font-bold' : 'bg-amber-50 text-amber-600')">R&D</span>
                                        <span class="px-1.5 py-0.5 rounded" :class="spk.approvals.pe === 'Acc' ? 'bg-emerald-50 text-emerald-700 font-bold' : 'bg-amber-50 text-amber-600'">PE</span>
                                    </div>
                                </div>

                                <!-- Revision Note if Revised -->
                                <template x-if="spk.status === 'Revised'">
                                    <div class="mb-3 p-2.5 bg-red-50 text-red-700 text-xs rounded-lg border border-red-100">
                                        <p class="font-bold mb-0.5">Catatan Revisi:</p>
                                        <p class="text-red-600" x-text="spk.revisionNote"></p>
                                    </div>
                                </template>

                                <div class="flex justify-between items-center pt-2 border-t border-slate-100">
                                    <button @click="openSpkDetail(spk)" class="text-xs font-bold text-cyan hover:underline">Detail Kegiatan</button>
                                    <!-- Released button -->
                                    <button @click="releaseSPK(spk.id)" class="px-3 py-1.5 bg-cyan hover:bg-cyan/90 text-white text-xs font-bold rounded-lg shadow-sm transition-colors flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        Released
                                    </button>
                                </div>
                            </div>
                        </template>
                        <template x-if="draftSpks().length === 0">
                            <p class="text-slate-400 text-center text-xs py-10">Tidak ada draft SPK.</p>
                        </template>
                    </div>
                </div>

                <!-- RUNNING SECTION -->
                <div class="bg-slate-50 p-6 rounded-2xl border border-slate-200 flex flex-col">
                    <h4 class="font-bold text-navy text-sm uppercase tracking-wider mb-4 flex items-center gap-2 pb-2 border-b border-slate-200">
                        <svg class="w-5 h-5 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"></path></svg>
                        Running / Active SPK (<span x-text="runningSpks().length"></span>)
                    </h4>
                    
                    <div class="space-y-4 flex-1">
                        <template x-for="spk in runningSpks()" :key="spk.id">
                            <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm hover:border-emerald-400 transition-colors">
                                <div class="flex justify-between items-start mb-2">
                                    <div>
                                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wide">Nomor SPK</span>
                                        <p class="font-bold text-navy text-base" x-text="spk.id"></p>
                                    </div>
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200" x-text="spk.status"></span>
                                </div>
                                <div class="grid grid-cols-2 gap-2 text-xs text-slate-600 mb-3">
                                    <div>
                                        <p class="text-slate-400">Produk</p>
                                        <p class="font-semibold text-slate-800" x-text="spk.product"></p>
                                    </div>
                                    <div>
                                        <p class="text-slate-400">Jadwal</p>
                                        <p class="font-semibold text-slate-800" x-text="formatDateRange(spk.startDate, spk.endDate)"></p>
                                    </div>
                                </div>

                                <!-- Current specific Stage -->
                                <div class="mb-3 p-3 bg-slate-50 border border-slate-100 rounded-xl">
                                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wide mb-1">Tahap Produksi Saat Ini</p>
                                    <div class="flex items-center gap-2 text-sm font-bold text-emerald-700">
                                        <span class="relative flex h-2 w-2">
                                          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                          <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                                        </span>
                                        <span x-text="spk.subStatus"></span>
                                    </div>
                                </div>

                                <div class="flex justify-between items-center pt-2 border-t border-slate-100">
                                    <button @click="openSpkDetail(spk)" class="text-xs font-bold text-cyan hover:underline">Detail Kegiatan</button>
                                    <a :href="'{{ route('spk.detail') }}?id=' + spk.id" class="text-xs font-bold text-slate-500 hover:text-navy flex items-center gap-1">
                                        Surat Perintah Kerja &rarr;
                                    </a>
                                </div>
                            </div>
                        </template>
                        <template x-if="runningSpks().length === 0">
                            <p class="text-slate-400 text-center text-xs py-10">Tidak ada SPK yang sedang berjalan.</p>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- DETAIL MODAL KEGIATAN -->
    <div x-show="showDetailModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center p-4" style="display: none;" x-transition>
        <div class="bg-white rounded-3xl border border-slate-200 shadow-2xl max-w-lg w-full overflow-hidden" @click.away="showDetailModal = false">
            <div class="p-6 bg-navy text-white flex justify-between items-center">
                <div>
                    <span class="text-xs font-bold text-cyan uppercase tracking-wide">Detail Kegiatan SPK</span>
                    <h3 class="text-xl font-bold" x-text="selectedSpk?.id"></h3>
                </div>
                <button @click="showDetailModal = false" class="text-slate-300 hover:text-white transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <div class="p-6 space-y-6 max-h-[70vh] overflow-y-auto">
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-slate-400 font-medium">Nama Produk</p>
                        <p class="font-bold text-navy" x-text="selectedSpk?.product"></p>
                    </div>
                    <div>
                        <p class="text-slate-400 font-medium">Jumlah Kuantitas</p>
                        <p class="font-bold text-navy" x-text="selectedSpk?.qty + ' Batch'"></p>
                    </div>
                    <div>
                        <p class="text-slate-400 font-medium">Jadwal Produksi</p>
                        <p class="font-bold text-navy" x-text="selectedSpk ? formatDateRange(selectedSpk.startDate, selectedSpk.endDate) : ''"></p>
                    </div>
                    <div>
                        <p class="text-slate-400 font-medium text-cyan">Mesin</p>
                        <p class="font-bold text-navy" x-text="selectedSpk?.machine"></p>
                    </div>
                    <div>
                        <p class="text-slate-400 font-medium">Shift Kerja</p>
                        <p class="font-bold text-navy" x-text="selectedSpk?.shift"></p>
                    </div>
                    <div>
                        <p class="text-slate-400 font-medium font-bold text-slate-700">Status Induk</p>
                        <p class="font-bold uppercase" :class="selectedSpk?.status === 'Running' ? 'text-emerald-600' : 'text-amber-600'" x-text="selectedSpk?.status"></p>
                    </div>
                </div>

                <hr class="border-slate-100">

                <!-- STATUS TERAKHIR & DETAIL TAHAPAN -->
                <div>
                    <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wide mb-3">Status Terakhir & Tahapan Produksi</h4>
                    <div class="space-y-4">
                        
                        <!-- Visual Step Progress -->
                        <div class="relative pl-6 border-l-2 border-slate-200 space-y-5">
                            
                            <!-- Step 1: Draft/Approval -->
                            <div class="relative">
                                <div class="absolute -left-[31px] top-0.5 w-4 h-4 rounded-full border-2 bg-white transition-colors"
                                     :class="(selectedSpk?.status === 'Draft' || selectedSpk?.status === 'Revised') ? 'border-amber-500 bg-amber-500 shadow-sm shadow-amber-300' : 'border-emerald-500 bg-emerald-500'"></div>
                                <div class="text-xs">
                                    <p class="font-bold text-slate-800">Draft & Verifikasi</p>
                                    <p class="text-slate-500" x-text="selectedSpk?.status === 'Revised' ? 'Draf perlu direvisi' : (selectedSpk?.status === 'Draft' ? 'Sedang dalam review persetujuan' : 'Telah diverifikasi dan disetujui')"></p>
                                    <template x-if="selectedSpk?.status === 'Revised'">
                                        <div class="mt-1 p-2 bg-red-50 text-red-700 rounded border border-red-100 font-mono text-[10px]" x-text="selectedSpk.revisionNote"></div>
                                    </template>
                                </div>
                            </div>

                            <!-- Step 2: Penimbangan -->
                            <div class="relative">
                                <div class="absolute -left-[31px] top-0.5 w-4 h-4 rounded-full border-2 bg-white transition-colors"
                                     :class="selectedSpk?.subStatus === 'Dalam Penimbangan' ? 'border-cyan bg-cyan shadow-sm shadow-cyan-300' : (selectedSpk?.status === 'Running' && selectedSpk?.subStatus !== 'Dalam Penimbangan' ? 'border-emerald-500 bg-emerald-500' : 'border-slate-300')"></div>
                                <div class="text-xs">
                                    <p class="font-bold text-slate-800" :class="selectedSpk?.subStatus === 'Dalam Penimbangan' ? 'text-cyan font-extrabold' : ''">Tahap 1: Penimbangan (Weighing)</p>
                                    <p class="text-slate-500">Penimbangan sediaan raw material di ruang penimbangan.</p>
                                </div>
                            </div>

                            <!-- Step 3: Mixing -->
                            <div class="relative">
                                <div class="absolute -left-[31px] top-0.5 w-4 h-4 rounded-full border-2 bg-white transition-colors"
                                     :class="selectedSpk?.subStatus === 'Proses Mixing' ? 'border-cyan bg-cyan shadow-sm shadow-cyan-300' : (selectedSpk?.status === 'Running' && ['Dalam Proses Extruder', 'Dalam Bagging', 'Completed'].includes(selectedSpk?.subStatus) ? 'border-emerald-500 bg-emerald-500' : 'border-slate-300')"></div>
                                <div class="text-xs">
                                    <p class="font-bold text-slate-800" :class="selectedSpk?.subStatus === 'Proses Mixing' ? 'text-cyan font-extrabold' : ''">Tahap 2: Pencampuran (Mixing)</p>
                                    <p class="text-slate-500">Pencampuran Resin PVC, Stabilizer, dan Additive dalam Mixer.</p>
                                </div>
                            </div>

                            <!-- Step 4: Extruder -->
                            <div class="relative">
                                <div class="absolute -left-[31px] top-0.5 w-4 h-4 rounded-full border-2 bg-white transition-colors"
                                     :class="selectedSpk?.subStatus === 'Dalam Proses Extruder' ? 'border-cyan bg-cyan shadow-sm shadow-cyan-300' : (selectedSpk?.status === 'Running' && ['Dalam Bagging', 'Completed'].includes(selectedSpk?.subStatus) ? 'border-emerald-500 bg-emerald-500' : 'border-slate-300')"></div>
                                <div class="text-xs">
                                    <p class="font-bold text-slate-800" :class="selectedSpk?.subStatus === 'Dalam Proses Extruder' ? 'text-cyan font-extrabold' : ''">Tahap 3: Pemrosesan Extruder</p>
                                    <p class="text-slate-500">Peleburan, ekstrusi, dan granulasi menjadi compound padat.</p>
                                </div>
                            </div>

                            <!-- Step 5: Bagging & Packaging -->
                            <div class="relative">
                                <div class="absolute -left-[31px] top-0.5 w-4 h-4 rounded-full border-2 bg-white transition-colors"
                                     :class="selectedSpk?.subStatus === 'Dalam Bagging' ? 'border-cyan bg-cyan shadow-sm shadow-cyan-300' : (selectedSpk?.status === 'Running' && selectedSpk?.subStatus === 'Completed' ? 'border-emerald-500 bg-emerald-500' : 'border-slate-300')"></div>
                                <div class="text-xs">
                                    <p class="font-bold text-slate-800" :class="selectedSpk?.subStatus === 'Dalam Bagging' ? 'text-cyan font-extrabold' : ''">Tahap 4: Bagging & Packaging</p>
                                    <p class="text-slate-500">Pengepakan barang jadi ke sak compound dan pelabelan.</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

            <div class="p-6 bg-slate-50 border-t border-slate-100 flex justify-between items-center">
                <a :href="'{{ route('spk.detail') }}?id=' + selectedSpk?.id" class="px-5 py-2.5 text-sm font-bold text-white bg-navy hover:bg-navy-light rounded-xl shadow-md transition-colors text-center flex-1 mr-3" x-show="selectedSpk?.status === 'Running'">
                    Buka Surat Perintah Kerja (SPK)
                </a>
                <button @click="showDetailModal = false" class="px-5 py-2.5 text-sm font-bold text-slate-600 bg-white border border-slate-300 rounded-xl hover:bg-slate-50 transition-colors flex-1">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {

        // ====== CLEANING FORM APP ======
        Alpine.data('cleaningFormApp', () => ({
            cleaningProgress: 60,
            form: {
                namaOperator: 'Budi Santoso',
                shift: 'Shift 1 - Group A',
                mesin: 'Mixer A-01, Extruder E-03',
                tanggal: '2026-09-08',
                jamMulai: '06:00',
                jamSelesai: '09:30',
                namaQC: 'Hendra (QC)',
                namaForeman: 'Agus Setiawan',
                materialPendukung: [
                    { nama: 'Kain Majun', qty: '3 Lembar' },
                    { nama: 'Thinner', qty: '1 Liter' },
                    { nama: 'Plastik', qty: '2 Pcs' },
                    { nama: 'Kabel Ties', qty: '10 Pcs' },
                    { nama: 'Grade B PP', qty: '25 Kg' },
                    { nama: 'Grade B PE', qty: '15 Kg' },
                    { nama: 'Resin PP', qty: '50 Kg' },
                    { nama: 'Resin PE', qty: '25 Kg' },
                    { nama: 'Stearic Acid', qty: '2 Kg' },
                    { nama: 'Parawax', qty: '1 Kg' },
                    { nama: 'Whimol', qty: '0.5 Liter' },
                ],
                materialHasil: [
                    { nama: 'Titan', qty: '5 Kg' },
                    { nama: 'Resin', qty: '20 Kg' },
                    { nama: 'Grade B', qty: '45 Kg' },
                    { nama: 'Gumpalan', qty: '12 Kg' },
                    { nama: 'Sapuan (debu, granule)', qty: '3 Kg' },
                    { nama: 'Limbah B3 (majun, dll)', qty: '2.5 Kg' },
                ],
                qcRows: [
                    { mesin: 'Mixer', hasil1: 'Tidak ada kerak', status1: 'OK', hasil2: 'Warna bersih', status2: 'OK' },
                    { mesin: 'Gravimetrik - Feeder 1', hasil1: 'Bersih dari sisa material', status1: 'OK', hasil2: 'Sensor aman', status2: 'OK' },
                    { mesin: 'Gravimetrik - Feeder 2', hasil1: 'Bersih', status1: 'OK', hasil2: 'Putaran lancar', status2: 'OK' },
                    { mesin: 'Gravimetrik - Feeder 3', hasil1: 'Kosong & bersih', status1: 'OK', hasil2: '-', status2: 'OK' },
                    { mesin: 'Volumetrik', hasil1: 'Bersih', status1: 'OK', hasil2: '-', status2: 'OK' },
                    { mesin: 'Extruder', hasil1: 'Screw bersih dari sisa PE', status1: 'OK', hasil2: 'Die head bebas kotoran', status2: 'OK' },
                    { mesin: 'Mesin Cutting', hasil1: 'Pisau tajam, bersih', status1: 'OK', hasil2: 'Area potong aman', status2: 'OK' },
                    { mesin: 'Centrifugal Dryer', hasil1: 'Saringan bersih', status1: 'OK', hasil2: 'Kering', status2: 'OK' },
                    { mesin: 'Mesin Vibra 1', hasil1: 'Mesh bersih tidak tersumbat', status1: 'OK', hasil2: 'Getaran stabil', status2: 'OK' },
                    { mesin: 'Mesin Vibra 2', hasil1: 'Bersih', status1: 'OK', hasil2: 'OK', status2: 'OK' },
                    { mesin: 'Silo', hasil1: 'Dinding dalam bersih', status1: 'OK', hasil2: 'Valve lancar', status2: 'OK' },
                ],
            },
            saveCleaning() {
                if (!this.form.namaOperator) {
                    alert('Nama Operator wajib diisi!'); return;
                }
                this.cleaningProgress = 100;
                alert('Form Cleaning berhasil disimpan!');
            }
        }));

        // ====== EXTRUDER HOURLY APP ======
        Alpine.data('extruderHourlyApp', () => ({
            newEntry: { jam: '', z1: null, z2: null, z3: null, z4: null, rpm: null, amp: null, operator: '' },
            hourlyData: [
                { jam: '06:00', z1: 160, z2: 170, z3: 175, z4: 175, rpm: 35, amp: 41, operator: 'Budi' },
                { jam: '07:00', z1: 161, z2: 171, z3: 176, z4: 176, rpm: 35, amp: 42, operator: 'Mia' },
                { jam: '08:00', z1: 160, z2: 172, z3: 178, z4: 178, rpm: 36, amp: 43, operator: 'Ayu' },
                { jam: '09:00', z1: 162, z2: 170, z3: 177, z4: 179, rpm: 35, amp: 42, operator: 'Bagas' },
                { jam: '10:00', z1: 160, z2: 173, z3: 180, z4: 180, rpm: 35, amp: 42, operator: 'Rudi' },
                { jam: '11:00', z1: 161, z2: 172, z3: 179, z4: 178, rpm: 34, amp: 41, operator: 'Putu' },
                { jam: '12:00', z1: 160, z2: 171, z3: 178, z4: 178, rpm: 35, amp: 42, operator: 'Citra' },
            ],
            hourlyChart: null,
            init() {
                this.$nextTick(() => this.buildChart());
            },
            buildChart() {
                const canvas = document.getElementById('extruderHourlyChart');
                if (!canvas) return;
                if (this.hourlyChart) { this.hourlyChart.destroy(); }
                this.hourlyChart = new Chart(canvas, {
                    type: 'line',
                    data: {
                        labels: this.hourlyData.map(r => r.jam),
                        datasets: [
                            { label: 'Zone 1', data: this.hourlyData.map(r => r.z1), borderColor: '#94a3b8', backgroundColor: 'transparent', tension: 0.3, pointRadius: 4 },
                            { label: 'Zone 2', data: this.hourlyData.map(r => r.z2), borderColor: '#60a5fa', backgroundColor: 'transparent', tension: 0.3, pointRadius: 4 },
                            { label: 'Zone 3', data: this.hourlyData.map(r => r.z3), borderColor: '#34d399', backgroundColor: 'transparent', tension: 0.3, pointRadius: 4 },
                            { label: 'Zone 4 (Die)', data: this.hourlyData.map(r => r.z4), borderColor: '#f59e0b', backgroundColor: 'rgba(245,158,11,0.08)', tension: 0.3, pointRadius: 5, borderWidth: 2.5, fill: true },
                        ]
                    },
                    options: {
                        responsive: true, maintainAspectRatio: false,
                        plugins: { legend: { position: 'top', labels: { font: { size: 10 }, boxWidth: 12 } } },
                        scales: {
                            y: { min: 150, max: 200, ticks: { font: { size: 10 } }, grid: { color: '#f1f5f9' } },
                            x: { ticks: { font: { size: 10 } } }
                        }
                    }
                });
            },
            addHourlyEntry() {
                if (!this.newEntry.jam) { alert('Jam wajib diisi!'); return; }
                this.hourlyData.push({ ...this.newEntry });
                this.hourlyData.sort((a, b) => a.jam.localeCompare(b.jam));
                this.newEntry = { jam: '', z1: null, z2: null, z3: null, z4: null, rpm: null, amp: null, operator: '' };
                this.$nextTick(() => this.updateHourlyChart());
            },
            updateHourlyChart() {
                if (!this.hourlyChart) { this.buildChart(); return; }
                this.hourlyChart.data.labels = this.hourlyData.map(r => r.jam);
                this.hourlyChart.data.datasets[0].data = this.hourlyData.map(r => r.z1);
                this.hourlyChart.data.datasets[1].data = this.hourlyData.map(r => r.z2);
                this.hourlyChart.data.datasets[2].data = this.hourlyData.map(r => r.z3);
                this.hourlyChart.data.datasets[3].data = this.hourlyData.map(r => r.z4);
                this.hourlyChart.update();
            },
            avg(field) {
                if (!this.hourlyData.length) return '—';
                const vals = this.hourlyData.map(r => Number(r[field])).filter(v => !isNaN(v));
                if (!vals.length) return '—';
                return (vals.reduce((a, b) => a + b, 0) / vals.length).toFixed(1);
            }
        }));

        Alpine.data('calendarApp', () => ({
            viewMode: 'calendar',
            searchQuery: '',
            statusFilter: 'all',
            dateStart: '',
            dateEnd: '',
            showEventModal: false,
            activeStep: 'cleaning', // Tab 1 = Cleaning
            showRndModal: false,
            showSlotModal: false,
            slotSearchQuery: '',
            slotMachineFilter: 'all',

            stepOrder() {
                return this.selectedEvent.linkedCleaning
                    ? ['cleaning', 'timbang', 'mixing', 'extruder', 'bagging']
                    : ['timbang', 'mixing', 'extruder', 'bagging'];
            },

            filteredSlots() {
                return this.slots.filter(s => {
                    const matchMachine = this.slotMachineFilter === 'all' || s.machine.toLowerCase() === this.slotMachineFilter.toLowerCase();
                    const q = this.slotSearchQuery.toLowerCase().trim();
                    const matchQuery = !q || 
                        s.spkNo.toLowerCase().includes(q) || 
                        s.product.toLowerCase().includes(q) || 
                        s.machine.toLowerCase().includes(q) || 
                        s.date.toLowerCase().includes(q) || 
                        s.time.toLowerCase().includes(q);
                    return matchMachine && matchQuery;
                });
            },
            
            selectedEvent: {
                title: '',
                product: '',
                customer: '',
                deliveryReq: '',
                shipDate: '',
                targetOp: '',
                workingDays: '',
                workingMinutes: '',
                delayHour: '',
                keterangan: '',
                remarks: '',
                completedBatch: 28,
                totalBatch: 50,
                dateRange: '',
                machine: '',
                shifts: [],
                substatus: '',
                type: 'running',
                timbangShift: '',
                timbangOperators: '',
                timbangDate: '',
                timbangStartTime: '',
                cleaningShift: '',
                cleaningDate: '',
                cleaningOperators: [],
                qcName: '',
                qcResult: ''
            },

            // Filter grafik per halaman step
            timbangShiftFilter: 'all',
            extruderShiftFilter: 'all',
            
            // R&D Trial Form
            rndForm: {
                sampleName: '',
                machine: 'Extruder E-01',
                durationHour: 4,
                notes: ''
            },
            rndConflict: true,

            // Slot Mesin Extruder E01 - E05
            slots: [
                { machine: 'Extruder E-01', spkNo: 'SPK-2608-001', product: 'PVC Compound A (Clear)', date: '27 Aug - 29 Aug 2026', time: '06:00 - 22:00' },
                { machine: 'Extruder E-02', spkNo: 'SPK-2608-005', product: 'PVC Compound C (Black)', date: '30 Aug - 31 Aug 2026', time: '08:00 - 16:00' },
                { machine: 'Extruder E-03', spkNo: 'SPK-2608-002', product: 'PVC Compound B (Color)', date: '30 Aug - 01 Sep 2026', time: '08:00 - 16:00' },
                { machine: 'Extruder E-04', spkNo: 'CLN-2608-002', product: 'Cleaning Line E-04',    date: '01 Sep 2026',           time: '08:00 - 12:00' },
                { machine: 'Extruder E-05', spkNo: 'SPK-2608-007', product: 'PVC Compound E (Special)', date: '02 Sep - 04 Sep 2026', time: '08:00 - 18:00' }
            ],
            
            tempChartInstance: null,
            timeChartInstance: null,
            timbangChartInstance: null,
            mixingTempChartInstance: null,
            mixingTimeChartInstance: null,

            init() {
                this.syncSlotsFromSPKs();
                window.addEventListener('storage-updated', () => this.syncSlotsFromSPKs());

                this.$watch('showEventModal', value => {
                    if (value) {
                        // Default buka ke extruder (step yang sedang berjalan)
                        this.activeStep = 'extruder';
                        setTimeout(() => { this.initStepChart('extruder'); }, 150);
                    }
                });
            },

            syncSlotsFromSPKs() {
                const spks = (window.getSPKs && window.getSPKs()) || [];
                const released = spks.filter(s => s.status === 'Released' || s.status === 'Scheduled');
                released.forEach(spk => {
                    if (!this.slots.some(sl => sl.spkNo === spk.id)) {
                        this.slots.unshift({
                            machine: spk.machine || 'Extruder E-01',
                            spkNo: spk.id,
                            product: spk.product || 'PVC Compound A',
                            date: spk.startDate ? spk.startDate + ' - ' + spk.endDate : '09 Sep - 11 Sep 2026',
                            time: '08:00 - 16:00'
                        });
                    }
                });
            },

            initStepChart(step) {
                // Hancurkan semua chart lama
                [
                    'tempChartInstance', 'timeChartInstance',
                    'timbangChartInstance', 'mixingTempChartInstance', 'mixingTimeChartInstance', 'baggingChartInstance'
                ].forEach(k => { if (this[k]) { this[k].destroy(); this[k] = null; } });

                const defaultLineOpts = {
                    responsive: true, maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    elements: { line: { tension: 0.4 }, point: { radius: 3 } }
                };
                const defaultBarOpts = {
                    responsive: true, maintainAspectRatio: false,
                    plugins: { legend: { display: false } }
                };

                if (step === 'timbang') {
                    const timbangData = [
                        { batch: 'B46', mins: 11, operator: 'Hana', shift: 'Shift 2', start: '07:07' },
                        { batch: 'B47', mins: 11, operator: 'Fitri', shift: 'Shift 2', start: '07:19' },
                        { batch: 'B48', mins: 14, operator: 'Mia', shift: 'Shift 1', start: '07:31' },
                        { batch: 'B49', mins: 12, operator: 'Ayu', shift: 'Shift 1', start: '07:47' },
                        { batch: 'B50', mins: 13, operator: 'Mia', shift: 'Shift 1', start: '08:00' }
                    ];
                    const filteredTimbang = this.timbangShiftFilter === 'all'
                        ? timbangData
                        : timbangData.filter(d => d.shift === this.timbangShiftFilter);

                    const ctx = document.getElementById('timbangChart');
                    if (ctx) {
                        this.timbangChartInstance = new Chart(ctx.getContext('2d'), {
                            type: 'bar',
                            data: {
                                labels: filteredTimbang.map(d => d.batch),
                                datasets: [{
                                    label: 'Durasi (mnt)',
                                    data: filteredTimbang.map(d => d.mins),
                                    backgroundColor: (ctx) => ctx.raw > 12 ? '#f59e0b' : '#10b981',
                                    borderRadius: 5
                                }, {
                                    label: 'Target',
                                    data: filteredTimbang.map(() => 12),
                                    type: 'line',
                                    borderColor: '#e11d48',
                                    borderDash: [4,4],
                                    borderWidth: 1.5,
                                    pointRadius: 0,
                                    fill: false
                                }]
                            },
                            options: {
                                ...defaultBarOpts,
                                scales: { y: { min: 0, max: 20 } },
                                plugins: {
                                    legend: { display: false },
                                    tooltip: {
                                        callbacks: {
                                            label: (ctx) => ctx.dataset.label === 'Target' ? 'Target: ' + ctx.raw + ' mnt' : 'Durasi: ' + ctx.raw + ' mnt',
                                            afterLabel: (ctx) => {
                                                if (ctx.dataset.label === 'Target') return '';
                                                const d = filteredTimbang[ctx.dataIndex];
                                                return d ? ['Operator: ' + d.operator, 'Shift: ' + d.shift, 'Jam Mulai: ' + d.start] : '';
                                            }
                                        }
                                    }
                                }
                            }
                        });
                    }
                }

                if (step === 'mixing') {
                    const ctxT = document.getElementById('mixingTempChart');
                    if (ctxT) {
                        this.mixingTempChartInstance = new Chart(ctxT.getContext('2d'), {
                            type: 'line',
                            data: {
                                labels: ['B1','B10','B20','B30','B40','B50'],
                                datasets: [{
                                    label: 'Hot Mix (°C)',
                                    data: [115, 117, 118, 119, 118, 117],
                                    borderColor: '#f97316', backgroundColor: 'rgba(249,115,22,0.08)', fill: true
                                }, {
                                    label: 'Cold Mix (°C)',
                                    data: [50, 51, 53, 52, 52, 51],
                                    borderColor: '#0ea5e9', backgroundColor: 'rgba(14,165,233,0.08)', fill: true
                                }]
                            },
                            options: { ...defaultLineOpts, plugins: { legend: { display: true, position: 'bottom', labels: { boxWidth: 10, font: { size: 10 } } } }, scales: { y: { min: 40, max: 130 } } }
                        });
                    }
                    const ctxMT = document.getElementById('mixingTimeChart');
                    if (ctxMT) {
                        this.mixingTimeChartInstance = new Chart(ctxMT.getContext('2d'), {
                            type: 'bar',
                            data: {
                                labels: ['B46','B47','B48','B49','B50'],
                                datasets: [{ label: 'Durasi (mnt)', data: [19, 20, 21, 20, 19], backgroundColor: '#8b5cf6', borderRadius: 5 }]
                            },
                            options: { ...defaultBarOpts, scales: { y: { min: 0, max: 30 } } }
                        });
                    }
                }

                if (step === 'extruder') {
                    const extruderData = [
                        { hour: '06:00', temp: 175, output: 492, operator: 'Budi', shift: 'Shift 1' },
                        { hour: '07:00', temp: 176, output: 498, operator: 'Mia', shift: 'Shift 1' },
                        { hour: '08:00', temp: 178, output: 505, operator: 'Ayu', shift: 'Shift 1' },
                        { hour: '09:00', temp: 177, output: 497, operator: 'Bagas', shift: 'Shift 2' },
                        { hour: '10:00', temp: 180, output: 503, operator: 'Rudi', shift: 'Shift 2' },
                        { hour: '11:00', temp: 179, output: 499, operator: 'Putu', shift: 'Shift 2' },
                        { hour: '12:00', temp: 178, output: 495, operator: 'Citra', shift: 'Shift 3' }
                    ];
                    const filteredExtruder = this.extruderShiftFilter === 'all'
                        ? extruderData
                        : extruderData.filter(d => d.shift === this.extruderShiftFilter);

                    const tooltipMeta = (d) => d ? ['Operator: ' + d.operator, 'Shift: ' + d.shift, 'Jam: ' + d.hour] : '';

                    const ctxTemp = document.getElementById('tempChart');
                    if (ctxTemp) {
                        this.tempChartInstance = new Chart(ctxTemp.getContext('2d'), {
                            type: 'line',
                            data: {
                                labels: filteredExtruder.map(d => d.hour),
                                datasets: [{
                                    label: 'Suhu Zone 3 (°C)',
                                    data: filteredExtruder.map(d => d.temp),
                                    borderColor: '#0ea5e9', backgroundColor: 'rgba(14,165,233,0.1)', borderWidth: 2, fill: true
                                }]
                            },
                            options: {
                                ...defaultLineOpts,
                                scales: { y: { min: 160, max: 190 } },
                                plugins: {
                                    legend: { display: false },
                                    tooltip: {
                                        callbacks: {
                                            label: (ctx) => 'Suhu: ' + ctx.raw + ' °C',
                                            afterLabel: (ctx) => tooltipMeta(filteredExtruder[ctx.dataIndex])
                                        }
                                    }
                                }
                            }
                        });
                    }
                    const ctxTime = document.getElementById('timeChart');
                    if (ctxTime) {
                        this.timeChartInstance = new Chart(ctxTime.getContext('2d'), {
                            type: 'bar',
                            data: {
                                labels: filteredExtruder.map(d => d.hour),
                                datasets: [{ label: 'Output (Kg/Jam)', data: filteredExtruder.map(d => d.output), backgroundColor: '#10b981', borderRadius: 4 }]
                            },
                            options: {
                                ...defaultBarOpts,
                                scales: { y: { min: 0, max: 600 } },
                                plugins: {
                                    legend: { display: false },
                                    tooltip: {
                                        callbacks: {
                                            label: (ctx) => 'Output: ' + ctx.raw + ' Kg/Jam',
                                            afterLabel: (ctx) => tooltipMeta(filteredExtruder[ctx.dataIndex])
                                        }
                                    }
                                }
                            }
                        });
                    }
                }

                if (step === 'bagging') {
                    const ctxBagging = document.getElementById('baggingChart');
                    if (ctxBagging) {
                        this.baggingChartInstance = new Chart(ctxBagging.getContext('2d'), {
                            type: 'line',
                            data: {
                                labels: ['Shift 1', 'Shift 2', 'Shift 3'],
                                datasets: [{
                                    label: 'Sak Selesai per Shift',
                                    data: [210, 200, 190],
                                    borderColor: '#10b981',
                                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                                    fill: true,
                                    borderWidth: 2,
                                    tension: 0.4
                                }]
                            },
                            options: {
                                ...defaultLineOpts,
                                scales: { y: { min: 0, max: 300 } },
                                plugins: {
                                    legend: { display: false },
                                    tooltip: {
                                        callbacks: {
                                            label: (ctx) => 'Output: ' + ctx.raw + ' Sak',
                                        }
                                    }
                                }
                            }
                        });
                    }
                }
            },

            releaseSpk(draftNo) {
                alert(`SPK ${draftNo} berhasil di-Release ke antrean Running!`);
            },

            deleteSlot(idx) {
                if (confirm('Apakah Anda yakin ingin menghapus slot mesin ini?')) {
                    this.slots.splice(idx, 1);
                    alert('Slot mesin berhasil dihapus.');
                }
            },
            adjustSlotTime(idx) {
                const newTime = prompt('Masukkan penyesuaian jam/waktu baru (contoh: 08:00 - 14:00):', this.slots[idx].time);
                if (newTime) {
                    this.slots[idx].time = newTime;
                    alert('Waktu slot mesin berhasil diperbarui!');
                }
            },
            checkRndConflict() {
                if (this.rndForm.machine === 'Extruder E-01') {
                    this.rndConflict = true;
                } else {
                    this.rndConflict = false;
                }
            },
            submitRndTrial() {
                if (!this.rndForm.sampleName) {
                    alert('Harap masukkan Nama Sample / Formula Trial R&D!');
                    return;
                }
                if (this.rndConflict) {
                    alert('PERHATIAN: Ada konflik jadwal mesin! Harap atur pemendekan SPK atau geser jadwal terlebih dahulu.');
                    return;
                }
                const trialId = 'TRL-RND-' + Math.floor(100 + Math.random() * 900);
                const newTrial = {
                    id: trialId,
                    title: '🧪 Trial R&D: ' + this.rndForm.sampleName,
                    start: new Date().toISOString().split('T')[0] + 'T10:00:00',
                    end: new Date().toISOString().split('T')[0] + 'T' + (10 + parseInt(this.rndForm.durationHour || 4)) + ':00:00',
                    backgroundColor: '#8b5cf6',
                    borderColor: '#7c3aed',
                    extendedProps: {
                        product: this.rndForm.sampleName,
                        customer: 'Internal R&D Department',
                        machine: this.rndForm.machine,
                        keterangan: this.rndForm.notes || 'Pengajuan Trial R&D Uji Coba Sample Formula',
                        type: 'rnd_trial',
                        team: 'Tim R&D',
                        completedBatch: 0,
                        totalBatch: 1,
                        shifts: ['Shift 2 — Tim R&D: Trial Lead'],
                        substatus: 'Pengujian Sample R&D'
                    }
                };
                if (window.calendarInstance) {
                    window.calendarInstance.addEvent(newTrial);
                }
                this.slots.unshift({
                    machine: this.rndForm.machine,
                    spkNo: trialId,
                    product: '🧪 ' + this.rndForm.sampleName,
                    date: new Date().toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' }),
                    time: '10:00 - ' + (10 + parseInt(this.rndForm.durationHour || 4)) + ':00'
                });
                alert(`Request Trial Sample R&D (${this.rndForm.sampleName}) berhasil diajukan ke PPIC & dijadwalkan secara real-time!`);
                this.showRndModal = false;
            },
            shortenExistingSpk() {
                alert('SPK eksisting SPK-2608-001 dipendekkan durasinya! Slot Extruder E-01 sekarang bebas untuk Trial R&D.');
                this.rndConflict = false;
                if (window.calendarInstance) {
                    let ev = window.calendarInstance.getEventById('SPK-2608-001') || window.calendarInstance.getEvents().find(e => e.title === 'SPK-2608-001');
                    if (ev) {
                        ev.setEnd(new Date().toISOString().split('T')[0] + 'T09:30:00');
                    }
                }
            },
            rescheduleRndTrial() {
                this.rndForm.machine = 'Extruder E-02';
                this.rndConflict = false;
                alert('Jadwal Trial R&D berhasil digeser otomatis ke slot kosong di Extruder E-02!');
            }
        }))
    });

    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');

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
                    customer: ext.customer || 'PT Royal Synthetic Compound',
                    deliveryReq: ext.deliveryReq || '05 Sep 2026',
                    shipDate: ext.shipDate || '06 Sep 2026',
                    targetOp: ext.targetOp || '500 Kg / Shift',
                    workingDays: ext.workingDays || '2.5 Days',
                    workingMinutes: ext.workingMinutes || '1,200 Mins',
                    delayHour: ext.delayHour || '0.0 Hr',
                    keterangan: ext.keterangan || 'Formula standar high-clarity PVC',
                    remarks: ext.remarks || 'Prioritas pengiriman via kontainer 20ft',
                    completedBatch: ext.completedBatch || 28,
                    totalBatch: ext.totalBatch || 50,
                    dateRange: info.event.startStr + (info.event.endStr ? ' → ' + info.event.endStr : ''),
                    machine: ext.machine || '—',
                    shifts: ext.shifts || [],
                    substatus: ext.substatus || '',
                    type: ext.type || 'running',
                    parentSpk: ext.parentSpk || '',
                    linkedCleaning: ext.linkedCleaning || '',
                    timbangShift: ext.timbangShift || 'Shift 1 · Team RED',
                    timbangOperators: ext.timbangOperators || 'Budi, Mia, Ayu',
                    timbangDate: ext.timbangDate || info.event.startStr,
                    timbangStartTime: ext.timbangStartTime || '06:00',
                    cleaningShift: ext.cleaningShift || 'Shift 3 · Team RED',
                    cleaningDate: ext.cleaningDate || info.event.startStr,
                    cleaningOperators: ext.cleaningOperators || [],
                    qcName: ext.qcName || 'Sari Wulandari',
                    qcResult: ext.qcResult || 'Lolos / Bebas Kontaminasi Warna'
                };
                alpineState.showEventModal = true;
            },
            eventContent: function(arg) {
                let ext = arg.event.extendedProps;
                let isDraft = ext.type === 'draft';
                let isCleaning = ext.type === 'cleaning';
                let isRnd = ext.type === 'rnd_trial';
                let teamBadge = ext.team ? `<span style="font-size:8px;font-weight:700;opacity:0.9;">${ext.team}</span>` : '';
                
                if (isCleaning) {
                    return {
                        html: `<div class="p-1 overflow-hidden cursor-pointer shadow-sm" style="border-radius:4px; background-color: #7c3aed; color: #ffffff; border-left: 3px solid #f59e0b;">
                            <div style="font-size:8.5px;font-weight:800;text-transform:uppercase;color:#fef08a;">🧹 STACK CLEANING · SPK: ${ext.parentSpk || 'SPK-2608-001'}</div>
                            <div style="font-size:10.5px;font-weight:700;">${arg.event.title}</div>
                            <div style="font-size:8px;opacity:0.9;">${ext.machine||''}</div>
                        </div>`
                    };
                }

                let stackBadge = ext.linkedCleaning ? `<div style="margin-top:2px;font-size:8px;font-weight:800;background:rgba(124,58,237,0.85);padding:1px 5px;border-radius:3px;display:inline-block;color:#fef08a;">🧹 +Cleaning Pasca-SPK</div>` : '';

                return {
                    html: `<div class="p-1 overflow-hidden cursor-pointer" style="border-radius:4px;">
                        <div style="font-size:9px;font-weight:700;text-transform:uppercase;opacity:${isDraft?'0.7':'0.9'}">${arg.event.title}${isDraft?' [DRAFT]':''}${isRnd?' [TRIAL R&D]':''}</div>
                        <div style="font-size:11px;font-weight:600;">${ext.product||''}</div>
                        ${teamBadge}
                        ${stackBadge}
                    </div>`
                };
            },
            events: (function() {
                let defaultEvts = [
                    // Running SPK 1
                    {
                        title: 'SPK-2608-001',
                        extendedProps: { 
                            customer: 'PT Royal Synthetic Compound',
                            product: 'PVC Compound A (Clear)', 
                            machine: 'Mixer A-01 · Ext Line 1 (E-01)', 
                            deliveryReq: '05 Sep 2026',
                            shipDate: '06 Sep 2026 (Tentatif)',
                            targetOp: '500 Kg / Shift',
                            workingDays: '2.5 Days',
                            workingMinutes: '1,200 Mins',
                            delayHour: '0.0 Hr',
                            keterangan: 'Formula standar high-clarity PVC',
                            remarks: 'Prioritas pengiriman via kontainer 20ft',
                            completedBatch: 28,
                            totalBatch: 50,
                            type: 'running',
                            team: 'S1:RED | S2:GREEN | S3:YELLOW',
                            shifts: ['Shift 1 — Team RED: Budi, Mia, Ayu', 'Shift 2 — Team GREEN: Bagas, Rudi, Putu', 'Shift 3 — Team YELLOW: Citra, Edi, Fikri'],
                            substatus: 'Sedang Penimbangan (TP) & Mixing (MP) (56%)',
                            linkedCleaning: '🧹 Cleaning Mixer A-01 & Feeder 01 (Ter-stack Pasca SPK-2608-001)',
                            timbangShift: 'Shift 1 · Team RED',
                            timbangOperators: 'Budi, Mia, Ayu',
                            timbangDate: fmt(today),
                            timbangStartTime: '06:00',
                            cleaningShift: 'Shift 3 · Team RED',
                            cleaningDate: fmt(addDays(today, -1)),
                            cleaningOperators: ['Budi (Lead)', 'Anggun'],
                            qcName: 'Sari Wulandari',
                            qcResult: 'Lolos / Bebas Kontaminasi Warna'
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
                            customer: 'PT Nusantara Plastik',
                            product: 'PVC Compound B (Color)', 
                            machine: 'Mixer B-02 · Ext Line 3 (E-03)', 
                            deliveryReq: '07 Sep 2026',
                            shipDate: '08 Sep 2026 (Tentatif)',
                            targetOp: '450 Kg / Shift',
                            workingDays: '1.5 Days',
                            workingMinutes: '720 Mins',
                            delayHour: '0.0 Hr',
                            keterangan: 'Warna biru kustom pabrik',
                            remarks: 'QC check intensif warna',
                            completedBatch: 0,
                            totalBatch: 30,
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
                    // Cleaning event (pasca SPK-001)
                    {
                        title: '🧹 Cleaning: Mixer A-01',
                        extendedProps: {
                            product: 'Cleaning Mixer A-01 & Feeder 01',
                            machine: 'Mixer A-01 · Feeder 01',
                            type: 'cleaning',
                            team: 'Team RED · Shift 3',
                            parentSpk: 'SPK-2608-001',
                            shifts: ['Shift 3 — Team RED: Budi, Anggun (4 jam)']
                        },
                        start: fmt(addDays(today, 2)) + 'T22:00:00',
                        end: fmt(addDays(today, 3)) + 'T02:00:00',
                        backgroundColor: '#7c3aed',
                        borderColor: '#7c3aed'
                    }
                ];

                // Dynamically fetch any approved/released SPKs from window.getSPKs()
                const savedSPKs = (window.getSPKs && window.getSPKs()) || [];
                savedSPKs.forEach(spk => {
                    if ((spk.status === 'Released' || spk.status === 'Scheduled' || spk.status === 'Running') && !defaultEvts.some(e => e.title === spk.id)) {
                        defaultEvts.push({
                            title: spk.id,
                            extendedProps: {
                                customer: spk.customerName || 'PT Chemindo Utama',
                                product: spk.product || 'PVC Compound A (Clear)',
                                machine: spk.machine || 'Extruder Line 1',
                                deliveryReq: spk.endDate || '2026-09-12',
                                shipDate: spk.endDate || '2026-09-12',
                                targetOp: '500 Kg / Shift',
                                workingDays: '2.0 Days',
                                workingMinutes: '960 Mins',
                                delayHour: '0.0 Hr',
                                keterangan: spk.keterangan || 'SPK Disetujui (ACC)',
                                remarks: spk.remarks || 'Prioritas Produksi',
                                completedBatch: 0,
                                totalBatch: spk.qty || 50,
                                type: 'running',
                                team: 'Shift 1 & 2',
                                shifts: ['Shift 1 — Team RED', 'Shift 2 — Team GREEN'],
                                substatus: spk.subStatus || 'Siap Produksi'
                            },
                            start: (spk.startDate || fmt(today)) + 'T08:00:00',
                            end: (spk.endDate || fmt(addDays(today, 2))) + 'T18:00:00',
                            backgroundColor: '#0ea5e9',
                            borderColor: '#0ea5e9'
                        });
                    }
                });
                return defaultEvts;
            })()
        });
        window.calendarInstance = calendar;
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