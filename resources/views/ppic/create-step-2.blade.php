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
                <div class="grid grid-cols-3 gap-4">
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
                        <select x-model="selectedExtruder" @change="if(!['ext-5', 'ext-6'].includes(selectedExtruder)) selectedFeeder = ''" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-sm focus:ring-2 focus:ring-cyan outline-none">
                            <option value="">-- Pilih Extruder --</option>
                            <option value="ext-1">Extruder Line 1</option>
                            <option value="ext-2">Extruder Line 2</option>
                            <option value="ext-3">Extruder Line 3</option>
                            <option value="ext-4">Extruder Line 4</option>
                            <option value="ext-5">Extruder Line 5 (Mesin 5)</option>
                            <option value="ext-6">Extruder Line 6 (Mesin 6)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 mb-2">Feeder</label>
                        <select x-model="selectedFeeder" :disabled="!['ext-5', 'ext-6'].includes(selectedExtruder)" :class="!['ext-5', 'ext-6'].includes(selectedExtruder) ? 'opacity-50 cursor-not-allowed bg-slate-100' : 'bg-slate-50'" class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-sm focus:ring-2 focus:ring-cyan outline-none">
                            <option value="">-- Pilih Feeder --</option>
                            <option value="fd-01">Feeder 01</option>
                            <option value="fd-02">Feeder 02</option>
                        </select>
                        <p x-show="!['ext-5', 'ext-6'].includes(selectedExtruder)" class="text-[10px] text-amber-600 mt-1">*Feeder hanya berlaku untuk Mesin 5 dan 6</p>
                        <p x-show="['ext-5', 'ext-6'].includes(selectedExtruder)" class="text-[10px] text-emerald-600 font-bold mt-1">✓ Feeder aktif untuk <span x-text="selectedExtruder === 'ext-5' ? 'Mesin 5' : 'Mesin 6'"></span></p>
                    </div>
                </div>
            </div>

            <hr class="border-slate-100">

            <!-- Form Cleaning Mesin Terintegrasi di Awal SPK -->
            <div class="p-5 bg-slate-50 rounded-2xl border border-slate-200 space-y-4">
                <div class="flex items-center justify-between">
                    <h4 class="text-sm font-bold text-navy flex items-center gap-2">
                        <svg class="w-4 h-4 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                        🧹 Form Cleaning Mesin (Awal Produksi SPK)
                    </h4>
                </div>
                <p class="text-xs text-slate-500">Aturan Pabrik: Mesin harus di-cleaning di <strong>AWAL / DEPAN</strong> sebelum proses produksi SPK dijalankan.</p>

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
                            <option value="Mixer A-01">Mixer A-01</option>
                            <option value="Mixer B-02">Mixer B-02</option>
                            <option value="Extruder Line 1">Extruder Line 1</option>
                            <option value="Extruder Line 2">Extruder Line 2</option>
                            <option value="Extruder Line 5">Extruder Line 5</option>
                            <option value="Extruder Line 6">Extruder Line 6</option>
                            <option value="Feeder 01">Feeder 01</option>
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

                <!-- BARU: Riwayat pemakaian mesin sebelum cleaning (otomatis, bukan input manual) -->
                <div class="pt-2">
                    <label class="block text-xs font-bold text-slate-600 mb-1.5">Riwayat Pemakaian Terakhir (Sebelum Cleaning)</label>
                    <div class="w-full bg-amber-50 border border-amber-200 rounded-xl px-3 py-2.5 flex items-center gap-2">
                        <svg class="w-4 h-4 text-amber-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <p class="text-xs font-bold text-amber-800" x-text="cleaningPreviousProduct"></p>
                    </div>
                    <p class="text-[10px] text-slate-400 mt-1">Otomatis terisi dari riwayat SPK terakhir pada mesin ini, dipakai sebagai acuan risiko kontaminasi sebelum cleaning.</p>
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
                <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                    <div class="bg-slate-50 rounded-xl p-4 border border-slate-200">
                        <label class="block text-xs font-bold text-slate-500 mb-2">Cleaning</label>
                        <div class="flex items-center gap-2">
                            <input type="number" min="0" x-model.number="mpCleaning" class="w-full bg-white border border-slate-200 rounded-lg px-3 py-1.5 text-sm text-center font-bold text-navy outline-none">
                            <span class="text-xs text-slate-500 whitespace-nowrap">Orang</span>
                        </div>
                    </div>
                    <div class="bg-slate-50 rounded-xl p-4 border border-slate-200">
                        <label class="block text-xs font-bold text-slate-500 mb-2">Penimbangan</label>
                        <div class="flex items-center gap-2">
                            <input type="number" min="0" x-model.number="mpPenimbangan" class="w-full bg-white border border-slate-200 rounded-lg px-3 py-1.5 text-sm text-center font-bold text-navy outline-none">
                            <span class="text-xs text-slate-500 whitespace-nowrap">Orang</span>
                        </div>
                    </div>
                    <div class="bg-slate-50 rounded-xl p-4 border border-slate-200">
                        <label class="block text-xs font-bold text-slate-500 mb-2">Mixing / Blending</label>
                        <div class="flex items-center gap-2">
                            <input type="number" min="0" x-model.number="mpMixing" class="w-full bg-white border border-slate-200 rounded-lg px-3 py-1.5 text-sm text-center font-bold text-navy outline-none">
                            <span class="text-xs text-slate-500 whitespace-nowrap">Orang</span>
                        </div>
                    </div>
                    <div class="bg-slate-50 rounded-xl p-4 border border-slate-200">
                        <label class="block text-xs font-bold text-slate-500 mb-2">Extruder</label>
                        <div class="flex items-center gap-2">
                            <input type="number" min="0" x-model.number="mpExtruder" class="w-full bg-white border border-slate-200 rounded-lg px-3 py-1.5 text-sm text-center font-bold text-navy outline-none">
                            <span class="text-xs text-slate-500 whitespace-nowrap">Orang</span>
                        </div>
                    </div>
                    <div class="bg-slate-50 rounded-xl p-4 border border-slate-200">
                        <label class="block text-xs font-bold text-slate-500 mb-2">Bagging</label>
                        <div class="flex items-center gap-2">
                            <input type="number" min="0" x-model.number="mpBagging" class="w-full bg-white border border-slate-200 rounded-lg px-3 py-1.5 text-sm text-center font-bold text-navy outline-none">
                            <span class="text-xs text-slate-500 whitespace-nowrap">Orang</span>
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

    <!-- Preview Modal sebelum submit — didesain seperti halaman dokumen/buku -->
    <div x-show="showPreview" style="display:none;" x-transition.opacity class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/70">
        <div @click.outside="showPreview = false" x-show="showPreview" x-transition class="bg-[#fdfcf9] rounded-lg border border-slate-300 shadow-2xl w-full max-w-2xl max-h-[92vh] overflow-y-auto font-serif">

            <!-- Header dokumen ala kop surat -->
            <div class="px-10 pt-8 pb-6 border-b-2 border-navy sticky top-0 bg-[#fdfcf9]">
                <p class="text-center text-xs tracking-[0.3em] uppercase text-slate-400 font-sans font-bold">Draft Dokumen Internal</p>
                <h3 class="text-center text-2xl font-bold text-navy tracking-wide mt-1">Surat Perintah Kerja (SPK)</h3>
                <p class="text-center text-sm text-slate-500 mt-1">Periksa kembali seluruh data di bawah ini sebelum melanjutkan ke tahap approval.</p>
            </div>

            <div class="px-10 py-8 space-y-9 text-base text-slate-800 leading-relaxed">

                <!-- I. Spesifikasi Dasar -->
                <div>
                    <h4 class="text-sm font-bold uppercase tracking-[0.15em] text-navy border-b border-slate-300 pb-2 mb-4 font-sans">I. Spesifikasi Dasar</h4>
                    <dl class="space-y-3">
                        <div class="flex flex-wrap items-baseline gap-x-2"><dt class="text-slate-500 shrink-0">Produk:</dt><dd class="font-bold text-navy" x-text="productLabel(step1Data.product)"></dd></div>
                        <div class="flex flex-wrap items-baseline gap-x-2"><dt class="text-slate-500 shrink-0">Quantity:</dt><dd class="font-bold text-navy" x-text="step1Data.qty ? (step1Data.qty + ' Batch') : '-'"></dd></div>
                        <div class="flex flex-wrap items-baseline gap-x-2"><dt class="text-slate-500 shrink-0">Customer:</dt><dd class="font-bold text-navy" x-text="step1Data.customerName || '-'"></dd></div>
                        <div class="flex flex-wrap items-baseline gap-x-2"><dt class="text-slate-500 shrink-0">Target OP:</dt><dd class="font-bold text-navy" x-text="step1Data.targetOp || '-'"></dd></div>
                        <div class="flex flex-wrap items-baseline gap-x-2"><dt class="text-slate-500 shrink-0">Tanggal Kirim (tentatif):</dt><dd class="font-bold text-navy" x-text="step1Data.tentativeShipDate || '-'"></dd></div>
                        <div class="flex flex-wrap items-baseline gap-x-2"><dt class="text-slate-500 shrink-0">Keterangan:</dt><dd class="font-bold text-navy" x-text="step1Data.keterangan || '-'"></dd></div>
                        <div class="flex flex-wrap items-baseline gap-x-2"><dt class="text-slate-500 shrink-0">Remarks:</dt><dd class="font-bold text-navy" x-text="step1Data.remarks || '-'"></dd></div>
                    </dl>
                </div>

                <!-- II. Waktu Proses -->
                <div>
                    <h4 class="text-sm font-bold uppercase tracking-[0.15em] text-navy border-b border-slate-300 pb-2 mb-4 font-sans">II. Waktu Proses</h4>
                    <dl class="space-y-3">
                        <div class="flex flex-wrap items-baseline gap-x-2"><dt class="text-slate-500 shrink-0">Mulai:</dt><dd class="font-bold text-navy" x-text="startDate ? (startDate + ' ' + startHour) : '-'"></dd></div>
                        <div class="flex flex-wrap items-baseline gap-x-2"><dt class="text-slate-500 shrink-0">Selesai:</dt><dd class="font-bold text-navy" x-text="finishDate ? (finishDate + ' ' + finishHour) : '-'"></dd></div>
                        <div class="flex flex-wrap items-baseline gap-x-2"><dt class="text-slate-500 shrink-0">Total Durasi:</dt><dd class="font-bold text-navy" x-text="totalHours > 0 ? (totalHours + ' Jam · ' + totalDays + ' Hari · ' + totalShifts + ' Shift') : '-'"></dd></div>
                    </dl>
                </div>

                <!-- III. Alokasi Mesin & Cleaning -->
                <div>
                    <h4 class="text-sm font-bold uppercase tracking-[0.15em] text-navy border-b border-slate-300 pb-2 mb-4 font-sans">III. Alokasi Mesin & Cleaning</h4>
                    <dl class="space-y-3">
                        <div class="flex flex-wrap items-baseline gap-x-2"><dt class="text-slate-500 shrink-0">Mixer:</dt><dd class="font-bold text-navy" x-text="selectedMixer || '-'"></dd></div>
                        <div class="flex flex-wrap items-baseline gap-x-2"><dt class="text-slate-500 shrink-0">Extruder:</dt><dd class="font-bold text-navy" x-text="selectedExtruder || '-'"></dd></div>
                        <div class="flex flex-wrap items-baseline gap-x-2"><dt class="text-slate-500 shrink-0">Feeder:</dt><dd class="font-bold text-navy" x-text="selectedFeeder || '-'"></dd></div>
                        <div class="flex flex-wrap items-baseline gap-x-2"><dt class="text-slate-500 shrink-0">Mesin Cleaning:</dt><dd class="font-bold text-navy" x-text="cleaningMachine"></dd></div>
                        <div class="flex flex-wrap items-baseline gap-x-2"><dt class="text-slate-500 shrink-0">Durasi Cleaning:</dt><dd class="font-bold text-navy" x-text="cleaningDurationRecommended + ' Jam '"></dd></div>
                        <div class="flex flex-wrap items-baseline gap-x-2"><dt class="text-slate-500 shrink-0">Tanggal / Shift Cleaning:</dt><dd class="font-bold text-navy" x-text="cleaningDateLabel + ' · ' + cleaningShiftLabel"></dd></div>
                        <div class="pt-2 mt-1 border-t border-dashed border-slate-200">
                            <div class="flex flex-wrap items-baseline gap-x-2 pt-2"><dt class="text-slate-500 shrink-0">Riwayat Pemakaian Sebelumnya:</dt><dd class="font-bold text-amber-700" x-text="cleaningPreviousProduct"></dd></div>
                        </div>
                    </dl>
                </div>

                <!-- IV. Estimasi Manpower -->
                <div>
                    <h4 class="text-sm font-bold uppercase tracking-[0.15em] text-navy border-b border-slate-300 pb-2 mb-4 font-sans">IV. Estimasi Manpower / Shift</h4>
                    <dl class="space-y-3">
                        <div class="flex flex-wrap items-baseline gap-x-2"><dt class="text-slate-500 shrink-0">Cleaning:</dt><dd class="font-bold text-navy" x-text="mpCleaning + ' Orang'"></dd></div>
                        <div class="flex flex-wrap items-baseline gap-x-2"><dt class="text-slate-500 shrink-0">Penimbangan:</dt><dd class="font-bold text-navy" x-text="mpPenimbangan + ' Orang'"></dd></div>
                        <div class="flex flex-wrap items-baseline gap-x-2"><dt class="text-slate-500 shrink-0">Mixing / Blending:</dt><dd class="font-bold text-navy" x-text="mpMixing + ' Orang'"></dd></div>
                        <div class="flex flex-wrap items-baseline gap-x-2"><dt class="text-slate-500 shrink-0">Extruder:</dt><dd class="font-bold text-navy" x-text="mpExtruder + ' Orang'"></dd></div>
                        <div class="flex flex-wrap items-baseline gap-x-2"><dt class="text-slate-500 shrink-0">Bagging:</dt><dd class="font-bold text-navy" x-text="mpBagging + ' Orang'"></dd></div>
                    </dl>
                </div>

                <!-- V. Rincian Material & Ketersediaan Stok (Diambil dari Tahap 1 & 2) -->
                <div>
                    <div class="flex items-center justify-between border-b border-slate-300 pb-2 mb-4 font-sans">
                        <h4 class="text-sm font-bold uppercase tracking-[0.15em] text-navy">V. Rincian Material & Ketersediaan Stok</h4>
                        <div class="bg-indigo-50 border border-indigo-200 text-indigo-800 px-3 py-1 rounded-full text-[11px] font-bold flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                            Estimasi Kapasitas Maksimal: <span class="underline text-indigo-600 font-extrabold" x-text="(step1Data.maxPossibleBatch !== undefined ? step1Data.maxPossibleBatch : calculatedMaxPossibleBatch) + ' Batch'"></span>
                        </div>
                    </div>
                    
                    <div class="overflow-x-auto border border-slate-200 rounded-xl bg-white font-sans text-xs shadow-sm">
                        <table class="w-full text-left">
                            <thead class="bg-slate-100 text-slate-700 font-bold uppercase tracking-wider text-[10px] border-b border-slate-200">
                                <tr>
                                    <th class="p-2.5">Material</th>
                                    <th class="p-2.5 text-right">Kebutuhan / Batch</th>
                                    <th class="p-2.5 text-right">Target Kebutuhan</th>
                                    <th class="p-2.5 text-right">Stok Fisik Tersedia</th>
                                    <th class="p-2.5 text-center">Status Validasi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-slate-700">
                                <template x-for="item in (step1Data.materials || defaultMaterials)" :key="item.id">
                                    <tr class="hover:bg-slate-50/80">
                                        <td class="p-2.5 font-bold text-navy" x-text="item.name"></td>
                                        <td class="p-2.5 text-right"><span x-text="item.qtyPerBatch"></span> <span class="text-slate-400">Kg</span></td>
                                        <td class="p-2.5 text-right font-bold text-slate-800"><span x-text="(item.qtyPerBatch * (step1Data.qty || 50)).toLocaleString()"></span> <span class="text-slate-400">Kg</span></td>
                                        <td class="p-2.5 text-right font-bold text-navy"><span x-text="(item.stock).toLocaleString()"></span> <span class="text-slate-400">Kg</span></td>
                                        <td class="p-2.5 text-center">
                                            <template x-if="item.isEnough">
                                                <span class="inline-flex items-center gap-1 bg-emerald-50 text-emerald-700 border border-emerald-200 px-2 py-0.5 rounded text-[10px] font-bold">
                                                    ✓ Cukup (Valid)
                                                </span>
                                            </template>
                                            <template x-if="!item.isEnough">
                                                <span class="inline-flex items-center gap-1 bg-red-50 text-red-700 border border-red-200 px-2 py-0.5 rounded text-[10px] font-bold">
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

            <div class="px-10 py-5 border-t border-slate-200 bg-[#fdfcf9] flex justify-end gap-3 sticky bottom-0 font-sans">
                <button type="button" @click="showPreview = false" class="px-5 py-2.5 text-sm font-bold text-slate-600 bg-white border border-slate-300 rounded-xl hover:bg-slate-50 transition-colors">Kembali Edit</button>
                <button type="button" @click="submitSpk()" class="px-6 py-2.5 text-sm font-bold text-white bg-cyan hover:bg-cyan/90 rounded-xl shadow-md shadow-cyan/20 transition-colors flex items-center gap-2">
                    Lanjutkan & Submit
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
            selectedFeeder: '',

            // Cleaning
            cleaningMachine: 'Mixer A-01',
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
                // Prefill dari Langkah 1 (Tanggal Mulai & Selesai Produksi)
                const saved = sessionStorage.getItem('ppic_spk_step1');
                if (saved) {
                    try {
                        this.step1Data = JSON.parse(saved);
                        this.startDate = this.step1Data.startDate || '';
                        this.finishDate = this.step1Data.finishDate || '';
                    } catch (e) {
                        this.step1Data = {};
                    }
                }
                this.calculate();
                this.$watch('startDate', () => this.calculate());
                this.$watch('finishDate', () => this.calculate());
            },

            productLabel(value) {
                const map = {
                    'prod-a': 'PVC Compound A (Clear)',
                    'prod-b': 'PVC Compound B (Color)'
                };
                return map[value] || (value || '-');
            },

            calculate() {
                if (this.startDate && this.finishDate && this.finishDate < this.startDate) {
                    this.finishDate = this.startDate;
                }
                if (!this.startDate || !this.finishDate) { this.totalHours = 0; return; }

                let startDt = new Date(this.startDate + 'T' + this.startHour + ':00');
                let finishDt = new Date(this.finishDate + 'T' + this.finishHour + ':00');
                
                let diffMs = finishDt - startDt;
                if (diffMs <= 0) { this.totalHours = 0; return; }

                this.totalHours = Math.round(diffMs / (1000 * 60 * 60));
                this.totalDays = Math.ceil(this.totalHours / 24);
                this.totalShifts = Math.ceil(this.totalHours / 8);
            },

            submitSpk() {
                sessionStorage.removeItem('ppic_spk_step1');
                window.location.href = "{{ route('approval.index') }}";
            }
        }))
    });
</script>
@endsection