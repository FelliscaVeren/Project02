@extends('layouts.app')

@section('title', 'Buat SPK - Langkah 2 (Waktu Proses & Manpower)')

@section('content')
<div class="w-full px-4 sm:px-6 lg:px-8 min-h-full pb-10" x-data="step2App()" x-init="init()">

    <!-- Progress Indicator -->
<div class="mb-8 max-w-4xl mx-auto">
        <div class="flex items-center">
            <div class="flex items-center text-slate-400 relative">
                <div class="rounded-full h-10 w-10 border-2 border-slate-200 bg-white flex items-center justify-center font-bold text-slate-400">1</div>
                <div class="absolute top-0 -ml-10 text-center mt-12 w-32 text-xs font-medium uppercase text-slate-400">Parameter & Formula</div>
            </div>
            <div class="flex-auto border-t-2 transition duration-500 ease-in-out border-cyan"></div>
            <div class="flex items-center text-cyan relative">
                <div class="rounded-full h-10 w-10 py-3 border-2 border-cyan bg-cyan text-white flex items-center justify-center font-bold">2</div>
                <div class="absolute top-0 -ml-10 text-center mt-12 w-32 text-xs font-bold uppercase text-cyan">Waktu & Manpower</div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden mt-12">
        <div class="p-6 border-b border-slate-100 bg-slate-50/50 flex items-start justify-between gap-4">
            <div>
                <h3 class="text-lg font-bold text-navy">Pengaturan Waktu Proses</h3>
                <p class="text-sm text-slate-500 mt-1">Tanggal mulai & selesai dibawa dari Langkah 1. Isi jam mulai/selesai untuk menghitung total jam dan shift secara otomatis.</p>
            </div>
            <button type="button" @click="datesLocked = !datesLocked" class="flex-shrink-0 px-3 py-2 text-xs font-bold rounded-lg border transition-colors flex items-center gap-1.5" :class="datesLocked ? 'bg-white border-slate-300 text-slate-600 hover:bg-slate-50' : 'bg-amber-50 border-amber-300 text-amber-700'">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                <span x-text="datesLocked ? 'Edit Tanggal' : 'Kunci Tanggal'"></span>
            </button>
        </div>

        <div class="p-6 space-y-8">

            <!-- Baris Start & Finish DateTime + Akumulasi -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
                
                <!-- Start DateTime -->
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Tanggal & Jam Mulai</label>
                    <div class="flex flex-col gap-2">
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wide mb-1">Tanggal</label>
                            <input type="date" x-model="startDate" :disabled="datesLocked" @change="calculate" :class="datesLocked ? 'bg-slate-100 text-slate-500 cursor-not-allowed' : 'bg-slate-50'" class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-sm focus:ring-2 focus:ring-cyan focus:border-cyan outline-none transition-all">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wide mb-1">Jam Mulai</label>
                            <select x-model="startHour" @change="calculate" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-sm focus:ring-2 focus:ring-cyan focus:border-cyan outline-none transition-all">
                                <template x-for="h in hours" :key="h">
                                    <option :value="h" x-text="h"></option>
                                </template>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Finish DateTime -->
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Tanggal & Jam Selesai</label>
                    <div class="flex flex-col gap-2">
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wide mb-1">Tanggal</label>
                            <input type="date" x-model="finishDate" :disabled="datesLocked" :min="startDate" @change="calculate" :class="datesLocked ? 'bg-slate-100 text-slate-500 cursor-not-allowed' : 'bg-slate-50'" class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-sm focus:ring-2 focus:ring-cyan focus:border-cyan outline-none transition-all">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wide mb-1">Jam Selesai</label>
                            <select x-model="finishHour" @change="calculate" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-sm focus:ring-2 focus:ring-cyan focus:border-cyan outline-none transition-all">
                                <template x-for="h in hours" :key="h">
                                    <option :value="h" x-text="h"></option>
                                </template>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Akumulasi Total Jam -->
                <div class="relative overflow-hidden rounded-2xl border-2 h-full" :class="totalHours > 0 ? 'border-cyan bg-cyan/5' : 'border-slate-200 bg-slate-50'">
                    <div class="p-5 h-full flex flex-col justify-center">
                        <p class="text-[10px] font-bold uppercase tracking-wider mb-1" :class="totalHours > 0 ? 'text-cyan' : 'text-slate-400'">Total Durasi Proses</p>
                        <p class="text-3xl font-black" :class="totalHours > 0 ? 'text-navy' : 'text-slate-300'" x-text="totalHours > 0 ? totalHours + ' Jam' : '—'"></p>
                        <p class="text-xs mt-1" :class="totalHours > 0 ? 'text-slate-600' : 'text-slate-400'" x-text="totalHours > 0 ? totalDays + ' Hari · ' + totalShifts + ' Shift (@8 Jam)' : 'Isi Start & Finish Date'"></p>
                        <div x-show="totalHours > 0" class="mt-3 flex gap-2 flex-wrap">
                            <span class="bg-white/80 text-navy border border-cyan/30 px-2 py-0.5 rounded text-[10px] font-bold" x-text="totalDays + ' Hari Produksi'"></span>
                            <span class="bg-white/80 text-navy border border-cyan/30 px-2 py-0.5 rounded text-[10px] font-bold" x-text="totalShifts + ' Shift Dibutuhkan'"></span>
                        </div>
                    </div>
                </div>
            </div>

            <hr class="border-slate-100">

            <!-- Mesin Produksi (dipindah ke atas, sebelum Form Cleaning) -->
            <div>
                <h4 class="text-sm font-bold text-navy mb-4 flex items-center gap-2">
                    <svg class="w-4 h-4 text-cyan" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path></svg>
                    Alokasi Mesin Produksi
                </h4>
                <!-- Baris 1: Mixer + Extruder -->
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 mb-2">Mesin Mixer</label>
                        <select x-model="selectedMixer" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-sm focus:ring-2 focus:ring-cyan outline-none">
                            <option value="">-- Pilih Mixer --</option>
                            <option value="mx-a01">Mixer A-01</option>
                            <option value="mx-b02">Mixer B-02</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 mb-2">Mesin Extruder</label>
                        <select x-model="selectedExtruder" @change="if(!['ext-5', 'ext-6'].includes(selectedExtruder)) selectedFeeders = []" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-sm focus:ring-2 focus:ring-cyan outline-none">
                            <option value="">-- Pilih Extruder --</option>
                            <option value="ext-1">Extruder Line 1</option>
                            <option value="ext-2">Extruder Line 2</option>
                            <option value="ext-3">Extruder Line 3</option>
                            <option value="ext-5">Extruder Line 5 (Mesin 5)</option>
                            <option value="ext-6">Extruder Line 6 (Mesin 6)</option>
                        </select>
                    </div>
                </div>

                <!-- Baris 2: Feeder checklist -->
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <label class="text-xs font-bold text-slate-500">Feeder</label>
                        <span x-show="['ext-5', 'ext-6'].includes(selectedExtruder) && selectedFeeders.length > 0"
                              class="text-[10px] font-bold text-emerald-600 bg-emerald-50 border border-emerald-200 px-2 py-0.5 rounded-full"
                              x-text="selectedFeeders.length + ' Feeder dipilih'"></span>
                        <span x-show="!['ext-5', 'ext-6'].includes(selectedExtruder)"
                              class="text-[10px] text-amber-600 font-medium">*Hanya untuk Extruder 5 &amp; 6</span>
                    </div>
                    <div :class="!['ext-5', 'ext-6'].includes(selectedExtruder) ? 'opacity-40 pointer-events-none' : ''"
                         class="flex flex-col gap-1.5 bg-slate-50 border border-slate-200 rounded-xl p-3 transition-opacity">
                        <template x-for="fd in [{id:'fd-01',label:'Feeder 01'},{id:'fd-02',label:'Feeder 02'},{id:'fd-03',label:'Feeder 03'},{id:'fd-05',label:'Feeder 05'},{id:'fd-06',label:'Feeder 06'}]" :key="fd.id">
                            <label class="flex items-center gap-2.5 cursor-pointer px-3 py-2 rounded-lg border transition-all"
                                   :class="selectedFeeders.includes(fd.id) ? 'bg-cyan/10 border-cyan text-cyan font-bold' : 'bg-white border-slate-200 text-slate-600 hover:border-cyan/50'">
                                <input type="checkbox" :value="fd.id" x-model="selectedFeeders"
                                    class="w-3.5 h-3.5 text-cyan border-slate-300 rounded focus:ring-cyan cursor-pointer">
                                <span class="text-xs font-semibold" x-text="fd.label"></span>
                            </label>
                        </template>
                    </div>
                </div>
            </div>

            <hr class="border-slate-100">

            <!-- Form Cleaning Mesin Terintegrasi di Awal SPK -->
            <div class="p-5 bg-slate-50 rounded-2xl border border-slate-200 space-y-4">
                <div class="flex items-center justify-between">
                    <h4 class="text-sm font-bold text-navy flex items-center gap-2">
                        <svg class="w-4 h-4 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                        🧹 Form Cleaning Mesin
                    </h4>
                    <div class="flex items-center gap-2 bg-white border border-slate-200 rounded-lg p-1 shadow-sm">
                        <label class="flex items-center gap-1.5 cursor-pointer px-2 py-1 rounded transition-colors" :class="cleaningPosition === 'awal' ? 'bg-violet-100 text-violet-700' : 'hover:bg-slate-50 text-slate-500'">
                            <input type="radio" x-model="cleaningPosition" value="awal" class="hidden">
                            <span class="text-xs font-bold">Di Awal (Depan)</span>
                        </label>
                        <label class="flex items-center gap-1.5 cursor-pointer px-2 py-1 rounded transition-colors" :class="cleaningPosition === 'akhir' ? 'bg-violet-100 text-violet-700' : 'hover:bg-slate-50 text-slate-500'">
                            <input type="radio" x-model="cleaningPosition" value="akhir" class="hidden">
                            <span class="text-xs font-bold">Di Akhir (Belakang)</span>
                        </label>
                    </div>
                </div>
                <p class="text-xs text-slate-500">Tentukan jadwal cleaning. Jika di Akhir, pastikan warna/produk selanjutnya aman dari kontaminasi.</p>

                <!-- Info auto-generate: tanggal & shift cleaning mengikuti tanggal/jam SPK, tidak perlu diisi manual -->
                <div class="flex flex-wrap gap-2">
                    <span class="bg-white text-navy border border-slate-300 px-2.5 py-1 rounded-lg text-[11px] font-bold flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 text-cyan" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        Tanggal Cleaning: <span x-text="cleaningDateLabel"></span> 
                    </span>
                    <span class="bg-white text-navy border border-slate-300 px-2.5 py-1 rounded-lg text-[11px] font-bold flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 text-cyan" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Shift: <span x-text="cleaningShiftLabel"></span>
                    </span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 pt-2">
                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-1.5">Mesin yang di-Cleaning</label>
                        <select x-model="cleaningMachine" class="w-full bg-white border border-slate-200 rounded-xl px-3 py-2 text-xs font-bold text-navy focus:ring-2 focus:ring-cyan outline-none">
                            <option value="Extruder Line 1">Extruder Line 1</option>
                            <option value="Extruder Line 2">Extruder Line 2</option>
                            <option value="Extruder Line 3">Extruder Line 3</option>
                            <option value="Extruder Line 5">Extruder Line 5</option>
                            <option value="Extruder Line 6">Extruder Line 6</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-1.5">Jam Mulai Cleaning</label>
                        <select x-model="cleaningStartHour" class="w-full bg-white border border-slate-200 rounded-xl px-3 py-2 text-xs font-semibold text-slate-800 focus:ring-2 focus:ring-cyan outline-none">
                            <template x-for="h in hours" :key="'cstart_'+h">
                                <option :value="h" x-text="h"></option>
                            </template>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-1.5">Durasi Cleaning (Rekomendasi Otomatis)</label>
                        <div class="w-full bg-violet-50 border border-violet-200 rounded-xl px-3 py-2 text-xs font-bold text-violet-800 flex items-center justify-between shadow-sm">
                            <span x-text="cleaningDurationRecommended + ' Jam'"></span>
                        </div>
                    </div>
                </div>

                <!-- Riwayat pemakaian mesin (otomatis) -->
                <div class="pt-2">
                    <label class="block text-xs font-bold text-slate-600 mb-1.5">Riwayat Pemakaian Mesin</label>
                    <div class="w-full bg-amber-50 border border-amber-200 rounded-xl px-3 py-2.5 flex items-center gap-2">
                        <svg class="w-4 h-4 text-amber-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <p class="text-xs font-bold text-amber-800" x-text="cleaningPreviousProduct"></p>
                    </div>
                </div>

                <!-- Produk Berikutnya — hanya muncul saat Cleaning di Akhir -->
                <div x-show="cleaningPosition === 'akhir'" x-transition class="pt-1">
                    <label class="block text-xs font-bold text-slate-600 mb-1.5">Kategori Produk Berikutnya <span class="text-rose-500">*</span></label>
                    <select x-model="nextProductCategory" class="w-full bg-white border border-slate-200 rounded-xl px-3 py-2 text-xs font-semibold text-slate-800 focus:ring-2 focus:ring-cyan outline-none">
                        <option value="">-- Pilih Kategori Produk Berikutnya --</option>
                        <option value="white">White / Putih</option>
                        <option value="clear">Clear / Bening (Transparan)</option>
                        <option value="color">Color / Berwarna</option>
                        <option value="black">Black / Hitam</option>
                        <option value="grey">Grey / Abu-Abu</option>
                    </select>
                    <p class="text-[10px] text-slate-400 mt-1">Digunakan untuk mendeteksi risiko kontaminasi warna antar produksi.</p>
                </div>

                <!-- Smart Notification System -->

                <!-- ⚠️ White sekarang → Color berikutnya: HIGH RISK -->
                <div x-show="cleaningPosition === 'akhir' && cleaningPreviousProduct.includes('White') && ['color','black','grey'].includes(nextProductCategory)" x-transition
                     class="p-4 bg-rose-50 border-2 border-rose-300 rounded-xl flex gap-3">
                    <div class="shrink-0 w-8 h-8 bg-rose-100 rounded-full flex items-center justify-center">
                        <svg class="w-4 h-4 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                    <div>
                        <p class="text-xs font-extrabold text-rose-700 mb-1">⚠️ PERHATIAN: Transisi White → Color Terdeteksi</p>
                        <p class="text-xs text-rose-600">Produk sebelumnya adalah <strong>White</strong> dan produk berikutnya adalah <strong>Color/Gelap</strong>. Cleaning di akhir SPK ini <strong>sangat direkomendasikan</strong> dilakukan dengan standar Purging penuh untuk menghindari kontaminasi warna pada produk berikutnya.</p>
                        <p class="text-[10px] text-rose-500 mt-1.5 font-semibold">Rekomendasi: Tambahkan waktu cleaning minimal 3-4 jam.</p>
                    </div>
                </div>

                <!-- ℹ️ White sekarang → White berikutnya: AMAN -->
                <div x-show="cleaningPosition === 'akhir' && cleaningPreviousProduct.includes('White') && nextProductCategory === 'white'" x-transition
                     class="p-4 bg-emerald-50 border border-emerald-200 rounded-xl flex gap-3">
                    <div class="shrink-0 w-8 h-8 bg-emerald-100 rounded-full flex items-center justify-center">
                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-xs font-extrabold text-emerald-700 mb-1">✓ Aman: Transisi White → White</p>
                        <p class="text-xs text-emerald-600">Produk berikutnya sama-sama <strong>White</strong>. Cleaning standar sudah cukup, tidak ada risiko kontaminasi warna yang signifikan.</p>
                    </div>
                </div>

                <!-- ℹ️ Color sekarang → White berikutnya: MEDIUM RISK -->
                <div x-show="cleaningPosition === 'akhir' && !cleaningPreviousProduct.includes('White') && nextProductCategory === 'white'" x-transition
                     class="p-4 bg-amber-50 border border-amber-300 rounded-xl flex gap-3">
                    <div class="shrink-0 w-8 h-8 bg-amber-100 rounded-full flex items-center justify-center">
                        <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                    <div>
                        <p class="text-xs font-extrabold text-amber-700 mb-1">⚠️ Perhatian: Transisi Color → White</p>
                        <p class="text-xs text-amber-700">Produk berikutnya adalah <strong>White</strong>. Pastikan cleaning dilakukan sangat bersih karena sisa pigmen color dapat mengkontaminasi produk White berikutnya.</p>
                        <p class="text-[10px] text-amber-600 mt-1.5 font-semibold">Rekomendasi: Gunakan material purging khusus sebelum run produk White.</p>
                    </div>
                </div>
            </div>

            <hr class="border-slate-100">

            <!-- Estimasi Manpower per Shift -->
            <div>
                <h4 class="text-sm font-bold text-navy mb-1 flex items-center gap-2">
                    <svg class="w-4 h-4 text-cyan" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    Estimasi Kebutuhan Manpower (Per Shift)
                </h4>
                <p class="text-xs text-slate-500 mb-4">Isi kebutuhan operator per pos kerja, termasuk cleaning mesin. Detail alokasi nama & tim akan diatur di halaman Alokasi Man & Mesin.</p>
                <!-- Manpower Cards -->
                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-start">
                    
                    <!-- Cleaning -->
                    <div class="md:col-span-3 bg-slate-50 rounded-xl p-4 border border-slate-200">
                        <label class="block text-xs font-bold text-slate-500 mb-2">Cleaning</label>
                        <div class="flex items-center gap-2">
                            <input type="number" min="0" x-model.number="mpCleaning" class="w-full bg-white border border-slate-200 rounded-lg px-3 py-1.5 text-sm text-center font-bold text-navy outline-none">
                            <span class="text-xs text-slate-500 whitespace-nowrap">Orang</span>
                        </div>
                    </div>

                    <!-- Mixing / Blending -->
                    <div class="md:col-span-3 bg-slate-50 rounded-xl p-4 border border-slate-200">
                        <label class="block text-xs font-bold text-slate-500 mb-2">Mixing / Blending</label>
                        <div class="flex items-center gap-2">
                            <input type="number" min="0" x-model.number="mpMixing" class="w-full bg-white border border-slate-200 rounded-lg px-3 py-1.5 text-sm text-center font-bold text-navy outline-none">
                            <span class="text-xs text-slate-500 whitespace-nowrap">Orang</span>
                        </div>
                    </div>

                    <!-- Extruder & Bagging Sub-group -->
                    <div class="md:col-span-6 bg-slate-50 rounded-xl p-4 border border-slate-200">
                        <div class="flex flex-wrap items-center justify-between gap-4">
                            <!-- Extruder Main -->
                            <div class="flex-1 min-w-[120px]">
                                <label class="block text-xs font-bold text-slate-500 mb-2">Extruder</label>
                                <div class="flex items-center gap-2">
                                    <input type="number" min="0" x-model.number="mpExtruder" class="w-full bg-white border border-slate-200 rounded-lg px-3 py-1.5 text-sm text-center font-bold text-navy outline-none">
                                    <span class="text-xs text-slate-500 whitespace-nowrap">Orang</span>
                                </div>
                            </div>
                            
                            <!-- Vertical Divider -->
                            <div class="hidden md:block w-px h-12 bg-slate-200"></div>
                            
                            <!-- Bagging Sub-group -->
                            <div class="flex-[2] min-w-[200px]">
                                <label class="block text-[10px] font-bold text-cyan uppercase tracking-widest mb-2">Bagging (Pengemasan)</label>
                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-[10px] text-slate-500 mb-1">Penimbangan</label>
                                        <div class="flex items-center gap-1.5">
                                            <input type="number" min="0" x-model.number="mpPenimbangan" class="w-full bg-white border border-slate-200 rounded-lg px-2 py-1 text-xs text-center font-bold text-navy outline-none">
                                            <span class="text-xs text-slate-500">Org</span>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-[10px] text-slate-500 mb-1">Sealing</label>
                                        <div class="flex items-center gap-1.5">
                                            <input type="number" min="0" x-model.number="mpBagging" class="w-full bg-white border border-slate-200 rounded-lg px-2 py-1 text-xs text-center font-bold text-navy outline-none">
                                            <span class="text-xs text-slate-500">Org</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="p-6 bg-white border-t border-slate-200 flex justify-between items-center">
            <a href="{{ route('ppic.create.step1') }}" class="px-5 py-2.5 text-sm font-bold text-slate-600 bg-white border border-slate-300 rounded-xl hover:bg-slate-50 transition-colors flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali
            </a>
            <div class="flex items-center gap-3">
                <div x-show="totalHours > 0" class="text-sm font-bold text-cyan flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span x-text="totalHours + ' Jam · ' + totalShifts + ' Shift'"></span>
                </div>
                <button type="button" @click="showPreview = true" class="px-6 py-2.5 text-sm font-bold text-white bg-cyan hover:bg-cyan/90 rounded-xl shadow-md shadow-cyan/20 transition-colors flex items-center gap-2">
                    Submit Draft SPK
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Preview Modal sebelum submit — didesain seperti halaman dokumen/buku resmi -->
    <div x-show="showPreview" style="display:none;" x-transition.opacity class="fixed inset-0 z-50 flex items-center justify-center p-4 md:p-6 bg-slate-900/75 backdrop-blur-sm">
        <div @click.outside="showPreview = false" x-show="showPreview" x-transition class="bg-[#fdfcf9] rounded-2xl border border-slate-300 shadow-2xl w-full max-w-7xl max-h-[94vh] flex flex-col font-serif overflow-hidden relative">

            <!-- Header dokumen ala kop surat resmi -->
            <div class="px-10 pt-8 pb-5 border-b-2 border-navy sticky top-0 bg-[#fdfcf9] z-10 flex justify-between items-start">
                <div class="flex-1 text-center pr-6">
                    <p class="text-sm tracking-[0.3em] uppercase text-slate-400 font-sans font-extrabold">Draft Dokumen Internal</p>
                    <h3 class="text-3xl font-black text-navy tracking-wide mt-1">Surat Perintah Kerja (SPK)</h3>
                    <p class="text-sm text-slate-500 mt-1">Periksa kembali seluruh data spesifikasi & alokasi sebelum dikirim ke tahap approval.</p>
                </div>
                <button type="button" @click="showPreview = false" class="text-slate-400 hover:text-slate-700 p-2 rounded-full hover:bg-slate-200/60 transition-colors">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <!-- Body Dokumen (Scrollable) -->
            <div class="px-10 py-8 space-y-8 text-base text-slate-800 leading-relaxed overflow-y-auto flex-1">

                <!-- Grid Baris 1: I. Spesifikasi Dasar & II. Waktu Proses -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- I. Spesifikasi Dasar -->
                    <div class="bg-white/80 p-7 rounded-2xl border border-slate-300 shadow-md">
                        <h4 class="text-sm font-extrabold uppercase tracking-[0.15em] text-navy border-b border-slate-300 pb-3 mb-4 font-sans flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-cyan"></span>
                            I. Spesifikasi Dasar
                        </h4>
                        <dl class="space-y-3 text-sm">
                            <div class="flex justify-between border-b border-slate-100 pb-2"><dt class="text-slate-500 font-medium">Produk:</dt><dd class="font-extrabold text-navy text-right" x-text="productLabel(step1Data.product)"></dd></div>
                            <div class="flex justify-between border-b border-slate-100 pb-2"><dt class="text-slate-500 font-medium">Quantity Batch:</dt><dd class="font-extrabold text-navy text-right" x-text="step1Data.qty ? (step1Data.qty + ' Batch') : '-'"></dd></div>
                            <div class="flex justify-between border-b border-slate-100 pb-2"><dt class="text-slate-500 font-medium">Customer:</dt><dd class="font-extrabold text-navy text-right" x-text="step1Data.customerName || '-'"></dd></div>
                            <div class="flex justify-between border-b border-slate-100 pb-2"><dt class="text-slate-500 font-medium">Target OP:</dt><dd class="font-extrabold text-navy text-right" x-text="step1Data.targetOp || '-'"></dd></div>
                            <div class="flex justify-between border-b border-slate-100 pb-2"><dt class="text-slate-500 font-medium">Tanggal Kirim (tentatif):</dt><dd class="font-extrabold text-navy text-right" x-text="step1Data.tentativeShipDate || '-'"></dd></div>
                            <div class="flex justify-between border-b border-slate-100 pb-2"><dt class="text-slate-500 font-medium">Keterangan:</dt><dd class="font-extrabold text-navy text-right" x-text="step1Data.keterangan || '-'"></dd></div>
                            <div class="flex justify-between"><dt class="text-slate-500 font-medium">Remarks:</dt><dd class="font-extrabold text-navy text-right" x-text="step1Data.remarks || '-'"></dd></div>
                        </dl>
                    </div>

                    <!-- II. Waktu Proses -->
                    <div class="bg-white/80 p-7 rounded-2xl border border-slate-300 shadow-md">
                        <h4 class="text-sm font-extrabold uppercase tracking-[0.15em] text-navy border-b border-slate-300 pb-3 mb-4 font-sans flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-indigo-500"></span>
                            II. Waktu Proses
                        </h4>
                        <dl class="space-y-3 text-sm">
                            <div class="flex justify-between border-b border-slate-100 pb-2"><dt class="text-slate-500 font-medium">Mulai Kerja:</dt><dd class="font-extrabold text-navy text-right" x-text="startDate ? (startDate + ' ' + startHour) : '-'"></dd></div>
                            <div class="flex justify-between border-b border-slate-100 pb-2"><dt class="text-slate-500 font-medium">Estimasi Selesai:</dt><dd class="font-extrabold text-navy text-right" x-text="finishDate ? (finishDate + ' ' + finishHour) : '-'"></dd></div>
                            <div class="flex justify-between pt-1"><dt class="text-slate-500 font-medium">Total Durasi:</dt><dd class="font-black text-cyan text-right text-base" x-text="totalHours > 0 ? (totalHours + ' Jam · ' + totalDays + ' Hari · ' + totalShifts + ' Shift') : '-'"></dd></div>
                        </dl>
                    </div>
                </div>

                <!-- Grid Baris 2: III. Alokasi Mesin & IV. Estimasi Manpower -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- III. Alokasi Mesin & Cleaning -->
                    <div class="bg-white/80 p-7 rounded-2xl border border-slate-300 shadow-md">
                        <h4 class="text-sm font-extrabold uppercase tracking-[0.15em] text-navy border-b border-slate-300 pb-3 mb-4 font-sans flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span>
                            III. Alokasi Mesin & Cleaning
                        </h4>
                        <dl class="space-y-3 text-sm">
                            <div class="flex justify-between border-b border-slate-100 pb-2"><dt class="text-slate-500 font-medium">Mesin Mixer:</dt><dd class="font-extrabold text-navy text-right" x-text="selectedMixer || '-'"></dd></div>
                            <div class="flex justify-between border-b border-slate-100 pb-2"><dt class="text-slate-500 font-medium">Mesin Extruder:</dt><dd class="font-extrabold text-navy text-right" x-text="selectedExtruder || '-'"></dd></div>
                            <div class="flex justify-between border-b border-slate-100 pb-2"><dt class="text-slate-500 font-medium">Feeder Mesin:</dt><dd class="font-extrabold text-navy text-right" x-text="selectedFeeder || '-'"></dd></div>
                            <div class="flex justify-between border-b border-slate-100 pb-2"><dt class="text-slate-500 font-medium">Mesin Cleaning:</dt><dd class="font-extrabold text-navy text-right" x-text="cleaningMachine"></dd></div>
                            <div class="flex justify-between border-b border-slate-100 pb-2"><dt class="text-slate-500 font-medium">Durasi Cleaning:</dt><dd class="font-extrabold text-navy text-right" x-text="cleaningDurationRecommended + ' Jam'"></dd></div>
                            <div class="flex justify-between border-b border-slate-100 pb-2"><dt class="text-slate-500 font-medium">Jadwal Cleaning:</dt><dd class="font-extrabold text-navy text-right" x-text="cleaningDateLabel + ' · ' + cleaningShiftLabel"></dd></div>
                            <div class="pt-1"><dt class="text-slate-500 text-xs mb-0.5 font-medium">Pemakaian Sebelumnya:</dt><dd class="font-extrabold text-amber-700 text-sm" x-text="cleaningPreviousProduct"></dd></div>
                        </dl>
                    </div>

                    <!-- IV. Estimasi Manpower / Shift -->
                    <div class="bg-white/80 p-7 rounded-2xl border border-slate-300 shadow-md">
                        <h4 class="text-sm font-extrabold uppercase tracking-[0.15em] text-navy border-b border-slate-300 pb-3 mb-4 font-sans flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                            IV. Estimasi Manpower / Shift
                        </h4>
                        <dl class="space-y-3 text-sm">
                            <div class="flex justify-between border-b border-slate-100 pb-2"><dt class="text-slate-500 font-medium">Cleaning Team:</dt><dd class="font-extrabold text-navy text-right" x-text="mpCleaning + ' Orang'"></dd></div>
                            <div class="flex justify-between border-b border-slate-100 pb-2"><dt class="text-slate-500 font-medium">Penimbangan:</dt><dd class="font-extrabold text-navy text-right" x-text="mpPenimbangan + ' Orang'"></dd></div>
                            <div class="flex justify-between border-b border-slate-100 pb-2"><dt class="text-slate-500 font-medium">Mixing / Blending:</dt><dd class="font-extrabold text-navy text-right" x-text="mpMixing + ' Orang'"></dd></div>
                            <div class="flex justify-between border-b border-slate-100 pb-2"><dt class="text-slate-500 font-medium">Extruder Operator:</dt><dd class="font-extrabold text-navy text-right" x-text="mpExtruder + ' Orang'"></dd></div>
                            <div class="flex justify-between"><dt class="text-slate-500 font-medium">Bagging Team:</dt><dd class="font-extrabold text-navy text-right" x-text="mpBagging + ' Orang'"></dd></div>
                        </dl>
                    </div>
                </div>

                <!-- V. Rincian Material & Ketersediaan Stok (Full Width Table) -->
                <div>
                    <div class="flex items-center justify-between border-b border-slate-300 pb-2 mb-4 font-sans flex-wrap gap-2">
                        <h4 class="text-xs font-bold uppercase tracking-[0.15em] text-navy flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-purple-500"></span>
                            V. Rincian Material & Ketersediaan Stok
                        </h4>
                        <div class="bg-indigo-50 border border-indigo-200 text-indigo-800 px-3.5 py-1 rounded-full text-xs font-bold flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                            Estimasi Kapasitas Maksimal: <span class="underline text-indigo-600 font-extrabold" x-text="(step1Data.maxPossibleBatch !== undefined ? step1Data.maxPossibleBatch : calculatedMaxPossibleBatch) + ' Batch'"></span>
                        </div>
                    </div>
                    
                    <div class="overflow-x-auto border border-slate-200 rounded-xl bg-white font-sans text-xs shadow-sm">
                        <table class="w-full text-left">
                            <thead class="bg-slate-100 text-slate-700 font-bold uppercase tracking-wider text-[10px] border-b border-slate-200">
                                <tr>
                                    <th class="p-3 pl-4">Material</th>
                                    <th class="p-3 text-right">Kebutuhan / Batch</th>
                                    <th class="p-3 text-right">Target Kebutuhan</th>
                                    <th class="p-3 text-right">Stok Fisik Tersedia</th>
                                    <th class="p-3 text-center pr-4">Status Validasi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-slate-700">
                                <template x-for="item in (step1Data.materials || defaultMaterials)" :key="item.id">
                                    <tr class="hover:bg-slate-50/80 transition-colors">
                                        <td class="p-3 pl-4 font-bold text-navy" x-text="item.name"></td>
                                        <td class="p-3 text-right"><span x-text="item.qtyPerBatch"></span> <span class="text-slate-400">Kg</span></td>
                                        <td class="p-3 text-right font-bold text-slate-800"><span x-text="(item.qtyPerBatch * (step1Data.qty || 50)).toLocaleString()"></span> <span class="text-slate-400">Kg</span></td>
                                        <td class="p-3 text-right font-bold text-navy"><span x-text="(item.stock).toLocaleString()"></span> <span class="text-slate-400">Kg</span></td>
                                        <td class="p-3 text-center pr-4">
                                            <template x-if="item.isEnough">
                                                <span class="inline-flex items-center gap-1 bg-emerald-50 text-emerald-700 border border-emerald-200 px-2.5 py-0.5 rounded text-[10px] font-bold">
                                                    ✓ Cukup (Valid)
                                                </span>
                                            </template>
                                            <template x-if="!item.isEnough">
                                                <span class="inline-flex items-center gap-1 bg-red-50 text-red-700 border border-red-200 px-2.5 py-0.5 rounded text-[10px] font-bold">
                                                    ✕ Kurang
                                                </span>
                                            </template>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Footer Dokumen -->
            <div class="px-10 py-4 border-t border-slate-200 bg-[#fdfcf9] flex justify-end gap-3 sticky bottom-0 font-sans z-10">
                <button type="button" @click="showPreview = false" class="px-5 py-2.5 text-sm font-bold text-slate-600 bg-white border border-slate-300 rounded-xl hover:bg-slate-50 transition-colors shadow-sm">Kembali Edit</button>
                <button type="button" @click="submitSpk()" class="px-6 py-2.5 text-sm font-bold text-white bg-cyan hover:bg-cyan/90 rounded-xl shadow-md shadow-cyan/20 transition-colors flex items-center gap-2">
                    Lanjutkan & Submit SPK
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('step2App', () => ({
            step1Data: {},
            defaultMaterials: [
                { id: 1, name: 'Resin PVC S-65', qtyPerBatch: 25, stock: 1500, isEnough: true },
                { id: 2, name: 'Stabilizer Ca-Zn', qtyPerBatch: 1, stock: 100, isEnough: true },
                { id: 3, name: 'Pigment White', qtyPerBatch: 0.5, stock: 10, isEnough: true }
            ],
            get calculatedMaxPossibleBatch() {
                const qty = this.step1Data.qty || 50;
                const mats = this.step1Data.materials || this.defaultMaterials;
                let maxBatches = mats.map(item => Math.floor(item.stock / item.qtyPerBatch));
                return Math.min(...maxBatches);
            },
            startDate: '',
            startHour: '06:00',
            finishDate: '',
            finishHour: '22:00',
            datesLocked: true,
            totalHours: 0,
            totalDays: 0,
            totalShifts: 0,

            // Alokasi Mesin
            selectedMixer: '',
            selectedExtruder: '',
            selectedFeeders: [],

            // Cleaning
            nextProductCategory: '',
            cleaningPosition: 'awal',
            cleaningMachine: 'Extruder Line 1',
            cleaningStartHour: '06:00',

            get cleaningDurationRecommended() {
                if (this.cleaningMachine.includes('Extruder')) return 3.5;
                if (this.cleaningMachine.includes('Mixer')) return 2.0;
                return 1.5;
            },

            // BARU: dummy riwayat pemakaian terakhir per mesin (nanti diganti data asli dari histori SPK/backend)
            machineLastUsage: {
                'Mixer A-01': 'PVC Compound A (Clear) - Kategori Clear',
                'Mixer B-02': 'PVC Compound B (Color) - Kategori White',
                'Extruder Line 1': 'PVC Compound A (Clear) - Kategori Clear',
                'Extruder Line 2': 'PVC Compound B (Color) - Kategori Black',
                'Extruder Line 5': 'PVC Compound B (Color) - Kategori White',
                'Extruder Line 6': 'PVC Compound B (Color) - Kategori Grey',
                'Feeder 01': 'PVC Compound B (Color) - Kategori White',
            },

            // Manpower
            mpCleaning: 1,
            mpPenimbangan: 1,
            mpMixing: 2,
            mpExtruder: 2,
            mpBagging: 1,

            showPreview: false,

            get hours() {
                let arr = [];
                for(let h = 0; h < 24; h++) {
                    arr.push(h.toString().padStart(2,'0') + ':00');
                }
                return arr;
            },

            // Tanggal cleaning otomatis mengikuti tanggal mulai SPK (tidak perlu input manual)
            get cleaningDateLabel() {
                return this.startDate || '-';
            },

            // Shift cleaning otomatis mengikuti jam mulai cleaning
            get cleaningShiftLabel() {
                let hourNum = parseInt(this.cleaningStartHour);
                if (isNaN(hourNum)) return '-';
                if (hourNum >= 6 && hourNum < 14) return 'Shift 1 (06:00 - 14:00)';
                if (hourNum >= 14 && hourNum < 22) return 'Shift 2 (14:00 - 22:00)';
                return 'Shift 3 (22:00 - 06:00)';
            },

            // BARU: riwayat pemakaian terakhir otomatis mengikuti mesin yang dipilih untuk di-cleaning
            get cleaningPreviousProduct() {
                return this.machineLastUsage[this.cleaningMachine] || 'Belum ada riwayat pemakaian tercatat';
            },

            init() {
                // Prefill dari Langkah 1 (Tanggal Mulai & Kirim Produksi)
                const saved = sessionStorage.getItem('ppic_spk_step1');
                if (saved) {
                    try {
                        this.step1Data = JSON.parse(saved);
                        this.startDate = this.step1Data.startDate || '';
                        this.finishDate = this.step1Data.finishDate || this.step1Data.tentativeShipDate || this.startDate;
                    } catch (e) {
                        this.step1Data = {};
                    }
                }

                const today = new Date().toISOString().split('T')[0];
                if (!this.startDate) this.startDate = today;
                if (!this.finishDate || this.finishDate < this.startDate) this.finishDate = this.startDate;

                this.calculate();

                this.$watch('startDate', () => this.calculate());
                this.$watch('finishDate', () => this.calculate());
                this.$watch('startHour', () => this.calculate());
                this.$watch('finishHour', () => this.calculate());
            },

            productLabel(value) {
                const map = {
                    'prod-a': 'PVC Compound A (Clear)',
                    'prod-b': 'PVC Compound B (Color)'
                };
                return map[value] || (value || '-');
            },

            calculate() {
                if (!this.startDate) {
                    this.startDate = new Date().toISOString().split('T')[0];
                }
                if (!this.finishDate || this.finishDate < this.startDate) {
                    this.finishDate = this.startDate;
                }

                const sHour = (this.startHour || '06:00').substring(0, 5);
                const fHour = (this.finishHour || '22:00').substring(0, 5);

                let startDt = new Date(this.startDate + 'T' + sHour + ':00');
                let finishDt = new Date(this.finishDate + 'T' + fHour + ':00');

                let diffMs = finishDt - startDt;
                if (isNaN(diffMs) || diffMs <= 0) {
                    this.totalHours = 0;
                    this.totalDays = 0;
                    this.totalShifts = 0;
                    return;
                }

                let hours = Math.round(diffMs / (1000 * 60 * 60));
                if (hours < 0) hours = 0;

                this.totalHours = hours;
                this.totalDays = hours > 0 ? Math.ceil(hours / 24) : 0;
                this.totalShifts = hours > 0 ? Math.ceil(hours / 8) : 0;
            },

            submitSpk() {
                sessionStorage.removeItem('ppic_spk_step1');
                window.location.href = "{{ route('approval.index') }}";
            }
        }))
    });
</script>
@endsection