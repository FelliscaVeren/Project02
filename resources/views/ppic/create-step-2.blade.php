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
                        <label class="block text-xs font-bold text-slate-600 mb-1.5">Jam Selesai Cleaning</label>
                        <select x-model="cleaningEndHour" class="w-full bg-white border border-slate-200 rounded-xl px-3 py-2 text-xs font-semibold text-slate-800 focus:ring-2 focus:ring-cyan outline-none">
                            <template x-for="h in hours" :key="'cend_'+h">
                                <option :value="h" x-text="h"></option>
                            </template>
                        </select>
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

    <!-- Preview Modal sebelum submit -->
    <div x-show="showPreview" style="display:none;" x-transition.opacity class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60">
        <div @click.outside="showPreview = false" x-show="showPreview" x-transition class="bg-white rounded-2xl border border-slate-200 shadow-xl w-full max-w-2xl max-h-[90vh] overflow-y-auto">
            <div class="p-6 border-b border-slate-100 bg-slate-50/50 sticky top-0">
                <h3 class="text-lg font-bold text-navy">Preview Draft SPK</h3>
                <p class="text-sm text-slate-500">Periksa kembali data sebelum melanjutkan ke approval.</p>
            </div>

            <div class="p-6 space-y-5 text-sm">
                <div>
                    <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">Spesifikasi Dasar</h4>
                    <div class="grid grid-cols-2 gap-y-2 gap-x-4">
                        <p class="text-slate-500">Produk</p><p class="font-bold text-navy" x-text="productLabel(step1Data.product)"></p>
                        <p class="text-slate-500">Quantity</p><p class="font-bold text-navy" x-text="(step1Data.qty || '-') + ' Batch'"></p>
                        <p class="text-slate-500">Customer</p><p class="font-bold text-navy" x-text="step1Data.customerName || '-'"></p>
                        <p class="text-slate-500">Target OP</p><p class="font-bold text-navy" x-text="step1Data.targetOp || '-'"></p>
                        <p class="text-slate-500">Tanggal Kirim (tentatif)</p><p class="font-bold text-navy" x-text="step1Data.tentativeShipDate || '-'"></p>
                        <p class="text-slate-500">Keterangan</p><p class="font-bold text-navy" x-text="step1Data.keterangan || '-'"></p>
                        <p class="text-slate-500">Remarks</p><p class="font-bold text-navy" x-text="step1Data.remarks || '-'"></p>
                    </div>
                </div>

                <hr class="border-slate-100">

                <div>
                    <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">Waktu Proses</h4>
                    <div class="grid grid-cols-2 gap-y-2 gap-x-4">
                        <p class="text-slate-500">Mulai</p><p class="font-bold text-navy" x-text="(startDate || '-') + ' ' + startHour"></p>
                        <p class="text-slate-500">Selesai</p><p class="font-bold text-navy" x-text="(finishDate || '-') + ' ' + finishHour"></p>
                        <p class="text-slate-500">Total Durasi</p><p class="font-bold text-navy" x-text="totalHours > 0 ? (totalHours + ' Jam · ' + totalDays + ' Hari · ' + totalShifts + ' Shift') : '-'"></p>
                    </div>
                </div>

                <hr class="border-slate-100">

                <div>
                    <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">Alokasi Mesin & Cleaning</h4>
                    <div class="grid grid-cols-2 gap-y-2 gap-x-4">
                        <p class="text-slate-500">Mixer</p><p class="font-bold text-navy" x-text="selectedMixer || '-'"></p>
                        <p class="text-slate-500">Extruder</p><p class="font-bold text-navy" x-text="selectedExtruder || '-'"></p>
                        <p class="text-slate-500">Feeder</p><p class="font-bold text-navy" x-text="selectedFeeder || '-'"></p>
                        <p class="text-slate-500">Mesin Cleaning</p><p class="font-bold text-navy" x-text="cleaningMachine"></p>
                        <p class="text-slate-500">Jam Cleaning</p><p class="font-bold text-navy" x-text="cleaningStartHour + ' - ' + cleaningEndHour"></p>
                        <p class="text-slate-500">Tanggal / Shift Cleaning</p><p class="font-bold text-navy" x-text="cleaningDateLabel + ' · ' + cleaningShiftLabel"></p>
                    </div>
                </div>

                <hr class="border-slate-100">

                <div>
                    <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">Estimasi Manpower / Shift</h4>
                    <div class="grid grid-cols-2 gap-y-2 gap-x-4">
                        <p class="text-slate-500">Cleaning</p><p class="font-bold text-navy" x-text="mpCleaning + ' Orang'"></p>
                        <p class="text-slate-500">Penimbangan</p><p class="font-bold text-navy" x-text="mpPenimbangan + ' Orang'"></p>
                        <p class="text-slate-500">Mixing / Blending</p><p class="font-bold text-navy" x-text="mpMixing + ' Orang'"></p>
                        <p class="text-slate-500">Extruder</p><p class="font-bold text-navy" x-text="mpExtruder + ' Orang'"></p>
                        <p class="text-slate-500">Bagging</p><p class="font-bold text-navy" x-text="mpBagging + ' Orang'"></p>
                    </div>
                </div>
            </div>

            <div class="p-6 border-t border-slate-100 bg-white flex justify-end gap-3 sticky bottom-0">
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
            cleaningEndHour: '07:00',

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