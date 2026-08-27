@extends('layouts.app')

@section('title', 'Jadwal Produksi SPK (Dual View Mode)')

@section('content')
<div class="flex flex-col gap-6 h-full" x-data="calendarDashboard()" x-init="init()">
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
            
            <!-- Dual/Triple View Mode Toggle -->
            <div class="inline-flex bg-slate-100 p-1 rounded-lg border border-slate-200">
                <button @click="setViewMode('calendar')" :class="{'bg-white shadow-sm text-cyan font-semibold': viewMode === 'calendar', 'text-slate-500': viewMode !== 'calendar'}" class="px-4 py-1.5 text-xs rounded-md transition-all flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    Kalender
                </button>
                <button @click="setViewMode('list')" :class="{'bg-white shadow-sm text-cyan font-semibold': viewMode === 'list', 'text-slate-500': viewMode !== 'list'}" class="px-4 py-1.5 text-xs rounded-md transition-all flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
                    Tabel / List
                </button>
                <button @click="setViewMode('tree')" :class="{'bg-white shadow-sm text-cyan font-semibold': viewMode === 'tree', 'text-slate-500': viewMode !== 'tree'}" class="px-4 py-1.5 text-xs rounded-md transition-all flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    Tree View SPK
                </button>
            </div>
        </div>
    </div>

    <!-- Alert Success Toast -->
    <div x-show="toastMessage !== ''" x-transition class="fixed bottom-5 right-5 bg-emerald-600 text-white px-6 py-3 rounded-xl shadow-2xl z-50 flex items-center gap-3 border border-emerald-500">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        <div>
            <p class="font-bold text-sm" x-text="toastMessage"></p>
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
                        <th class="p-4">Status & Detail Tahapan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    <template x-for="spk in filteredSpks()" :key="spk.id">
                        <tr class="hover:bg-slate-50 transition-colors cursor-pointer" @click="openSpkDetail(spk)">
                            <td class="p-4 font-bold text-navy" x-text="spk.id"></td>
                            <td class="p-4 font-medium" x-text="spk.product"></td>
                            <td class="p-4" x-text="formatDateRange(spk.startDate, spk.endDate)"></td>
                            <td class="p-4 font-semibold text-cyan" x-text="spk.machine"></td>
                            <td class="p-4">
                                <span class="px-2 py-1 rounded bg-indigo-50 text-indigo-700 border border-indigo-100 text-xs font-bold" x-text="spk.shift"></span>
                            </td>
                            <td class="p-4">
                                <span class="px-2 py-1 rounded text-xs font-bold" 
                                      :class="{
                                          'bg-emerald-50 text-emerald-700 border border-emerald-100': spk.status === 'Running',
                                          'bg-amber-50 text-amber-700 border border-amber-100': spk.status === 'Draft',
                                          'bg-red-50 text-red-700 border border-red-100': spk.status === 'Revised',
                                          'bg-slate-100 text-slate-700 border border-slate-200': spk.status === 'Completed'
                                      }"
                                      x-text="spk.status + ' (' + spk.subStatus + ')'"></span>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
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
        Alpine.data('calendarDashboard', () => ({
            viewMode: 'calendar',
            searchQuery: '',
            spks: [],
            selectedSpk: null,
            showDetailModal: false,
            toastMessage: '',
            calendarObj: null,

            init() {
                this.loadSPKs();
                
                // Dengar perubahan storage
                window.addEventListener('storage-updated', () => {
                    this.loadSPKs();
                    this.refreshCalendarEvents();
                });
                
                // Inisialisasi FullCalendar
                this.$nextTick(() => {
                    this.initCalendar();
                });
            },

            loadSPKs() {
                this.spks = window.getSPKs() || [];
            },

            setViewMode(mode) {
                this.viewMode = mode;
                if (mode === 'calendar' && this.calendarObj) {
                    this.$nextTick(() => {
                        this.calendarObj.updateSize();
                    });
                }
            },

            filteredSpks() {
                const query = this.searchQuery.toLowerCase().trim();
                if (!query) return this.spks;
                return this.spks.filter(s => 
                    s.id.toLowerCase().includes(query) ||
                    s.product.toLowerCase().includes(query) ||
                    s.machine.toLowerCase().includes(query) ||
                    s.status.toLowerCase().includes(query) ||
                    s.subStatus.toLowerCase().includes(query)
                );
            },

            draftSpks() {
                return this.filteredSpks().filter(s => s.status === 'Draft' || s.status === 'Revised');
            },

            runningSpks() {
                return this.filteredSpks().filter(s => s.status === 'Running');
            },

            releaseSPK(id) {
                const allSpks = window.getSPKs();
                const index = allSpks.findIndex(s => s.id === id);
                if (index !== -1) {
                    allSpks[index].status = 'Running';
                    allSpks[index].subStatus = 'Dalam Penimbangan';
                    allSpks[index].approvals = { gudang: 'Acc', rnd: 'Acc', pe: 'Acc', qc: 'Acc' };
                    
                    window.saveSPKs(allSpks);
                    window.addMovingSlip(id); // Generate Moving Slip otomatis
                    
                    this.toastMessage = `SPK ${id} Berhasil Dirilis ke Produksi & Moving Slip Otomatis Dibuat!`;
                    setTimeout(() => { this.toastMessage = ''; }, 4000);
                    
                    this.loadSPKs();
                    this.refreshCalendarEvents();
                }
            },

            openSpkDetail(spk) {
                this.selectedSpk = spk;
                this.showDetailModal = true;
            },

            formatDateRange(start, end) {
                if (!start) return '';
                const options = { day: 'numeric', month: 'short', year: 'numeric' };
                const sDate = new Date(start).toLocaleDateString('id-ID', options);
                if (!end) return sDate;
                const eDate = new Date(end).toLocaleDateString('id-ID', options);
                return `${sDate} - ${eDate}`;
            },

            initCalendar() {
                const calendarEl = document.getElementById('calendar');
                if (!calendarEl) return;

                const self = this;
                this.calendarObj = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,timeGridDay'
                    },
                    themeSystem: 'standard',
                    height: '100%',
                    eventContent: function(arg) {
                        return {
                            html: `
                                <div class="p-1 overflow-hidden cursor-pointer">
                                    <div class="font-bold text-[9px] uppercase text-white/90 truncate">${arg.event.title}</div>
                                    <div class="font-semibold text-xs truncate">${arg.event.extendedProps.product}</div>
                                    <div class="text-[9px] mt-0.5 flex items-center justify-between opacity-90">
                                        <span>${arg.event.extendedProps.machine}</span>
                                        <span class="bg-white/20 px-1 rounded">${arg.event.extendedProps.status}</span>
                                    </div>
                                </div>
                            `
                        };
                    },
                    eventClick: function(info) {
                        const spkId = info.event.id;
                        const spk = self.spks.find(s => s.id === spkId);
                        if (spk) {
                            self.openSpkDetail(spk);
                        }
                    },
                    events: this.getCalendarEvents()
                });
                this.calendarObj.render();
            },

            getCalendarEvents() {
                return this.spks.map(s => ({
                    id: s.id,
                    title: s.id,
                    product: s.product,
                    machine: s.machine,
                    status: s.status,
                    start: s.startDate,
                    end: s.endDate,
                    backgroundColor: s.status === 'Running' ? '#112338' : (s.status === 'Revised' ? '#ef4444' : '#f59e0b'),
                    borderColor: s.status === 'Running' ? '#112338' : (s.status === 'Revised' ? '#ef4444' : '#f59e0b')
                }));
            },

            refreshCalendarEvents() {
                if (this.calendarObj) {
                    this.calendarObj.removeAllEvents();
                    this.calendarObj.addEventSource(this.getCalendarEvents());
                }
            }
        }));
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
