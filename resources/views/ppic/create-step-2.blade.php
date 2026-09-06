@extends('layouts.app')

@section('title', 'Buat SPK - Langkah 2 (Waktu Proses & Manpower)')

@section('content')
<div class="max-w-5xl mx-auto h-full pb-10" x-data="step2App()">

    <!-- Progress Indicator -->
    <div class="mb-8">
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
        <div class="p-6 border-b border-slate-100 bg-slate-50/50">
            <h3 class="text-lg font-bold text-navy">Pengaturan Waktu Proses</h3>
            <p class="text-sm text-slate-500 mt-1">Masukkan tanggal dan jam mulai serta selesai proses produksi. Sistem akan menghitung total jam dan shift yang dibutuhkan secara otomatis.</p>
        </div>

        <div class="p-6 space-y-8">

            <!-- Baris Start & Finish DateTime + Akumulasi -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
                
                <!-- Start DateTime -->
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Tanggal & Jam Mulai</label>
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wide mb-1">Tanggal</label>
                            <input type="date" x-model="startDate" @change="calculate" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-sm focus:ring-2 focus:ring-cyan focus:border-cyan outline-none transition-all">
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
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wide mb-1">Tanggal</label>
                            <input type="date" x-model="finishDate" @change="calculate" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-sm focus:ring-2 focus:ring-cyan focus:border-cyan outline-none transition-all">
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

            <!-- Mesin -->
            <div>
                <h4 class="text-sm font-bold text-navy mb-4 flex items-center gap-2">
                    <svg class="w-4 h-4 text-cyan" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path></svg>
                    Alokasi Mesin
                </h4>
                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 mb-2">Mesin Mixer</label>
                        <select class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-sm focus:ring-2 focus:ring-cyan outline-none">
                            <option value="">-- Pilih Mixer --</option>
                            <option value="mx-a01">Mixer A-01</option>
                            <option value="mx-b02">Mixer B-02</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 mb-2">Mesin Extruder</label>
                        <select x-model="selectedExtruder" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-sm focus:ring-2 focus:ring-cyan outline-none">
                            <option value="">-- Pilih Extruder --</option>
                            <option value="ext-1">Extruder Line 1</option>
                            <option value="ext-2">Extruder Line 2</option>
                            <option value="ext-3">Extruder Line 3</option>
                            <option value="ext-4-5">Extruder Line 4-5</option>
                            <option value="ext-5-6">Extruder Line 5-6</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 mb-2">Feeder</label>
                        <select x-model="selectedFeeder" :disabled="!['ext-4-5', 'ext-5-6'].includes(selectedExtruder)" :class="!['ext-4-5', 'ext-5-6'].includes(selectedExtruder) ? 'opacity-50 cursor-not-allowed bg-slate-100' : 'bg-slate-50'" class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-sm focus:ring-2 focus:ring-cyan outline-none">
                            <option value="">-- Pilih Feeder --</option>
                            <option value="fd-01">Feeder 01</option>
                            <option value="fd-02">Feeder 02</option>
                        </select>
                        <p x-show="!['ext-4-5', 'ext-5-6'].includes(selectedExtruder)" class="text-[10px] text-amber-600 mt-1 mt-1">*Feeder hanya untuk mesin 4-5 / 5-6</p>
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
                <p class="text-xs text-slate-500 mb-4">Isi kebutuhan operator per pos kerja. Detail alokasi nama & tim akan diatur di halaman Alokasi Man & Mesin.</p>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="bg-slate-50 rounded-xl p-4 border border-slate-200">
                        <label class="block text-xs font-bold text-slate-500 mb-2">Penimbangan</label>
                        <div class="flex items-center gap-2">
                            <input type="number" min="0" value="1" class="w-full bg-white border border-slate-200 rounded-lg px-3 py-1.5 text-sm text-center font-bold text-navy outline-none">
                            <span class="text-xs text-slate-500 whitespace-nowrap">Orang</span>
                        </div>
                    </div>
                    <div class="bg-slate-50 rounded-xl p-4 border border-slate-200">
                        <label class="block text-xs font-bold text-slate-500 mb-2">Mixing / Blending</label>
                        <div class="flex items-center gap-2">
                            <input type="number" min="0" value="2" class="w-full bg-white border border-slate-200 rounded-lg px-3 py-1.5 text-sm text-center font-bold text-navy outline-none">
                            <span class="text-xs text-slate-500 whitespace-nowrap">Orang</span>
                        </div>
                    </div>
                    <div class="bg-slate-50 rounded-xl p-4 border border-slate-200">
                        <label class="block text-xs font-bold text-slate-500 mb-2">Extruder</label>
                        <div class="flex items-center gap-2">
                            <input type="number" min="0" value="2" class="w-full bg-white border border-slate-200 rounded-lg px-3 py-1.5 text-sm text-center font-bold text-navy outline-none">
                            <span class="text-xs text-slate-500 whitespace-nowrap">Orang</span>
                        </div>
                    </div>
                    <div class="bg-slate-50 rounded-xl p-4 border border-slate-200">
                        <label class="block text-xs font-bold text-slate-500 mb-2">Bagging</label>
                        <div class="flex items-center gap-2">
                            <input type="number" min="0" value="1" class="w-full bg-white border border-slate-200 rounded-lg px-3 py-1.5 text-sm text-center font-bold text-navy outline-none">
                            <span class="text-xs text-slate-500 whitespace-nowrap">Orang</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="p-6 bg-white border-t border-slate-200 flex justify-between items-center">
            <button @click="goBack()" class="px-5 py-2.5 text-sm font-bold text-slate-600 bg-white border border-slate-300 rounded-xl hover:bg-slate-50 transition-colors flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali
            </a>
            <div class="flex items-center gap-3">
                <div x-show="totalHours > 0" class="text-sm font-bold text-cyan flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span x-text="totalHours + ' Jam · ' + totalShifts + ' Shift'"></span>
                </div>
                <a href="{{ route('approval.index') }}" class="px-6 py-2.5 text-sm font-bold text-white bg-cyan hover:bg-cyan/90 rounded-xl shadow-md shadow-cyan/20 transition-colors flex items-center gap-2">
                    Submit Draft SPK
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('step2App', () => ({
            startDate: '',
            startHour: '06:00',
            finishDate: '',
            finishHour: '22:00',
            totalHours: 0,
            totalDays: 0,
            totalShifts: 0,
            selectedExtruder: '',
            selectedFeeder: '',

            get hours() {
                let arr = [];
                for(let h = 0; h < 24; h++) {
                    arr.push(h.toString().padStart(2,'0') + ':00');
                }
                return arr;
            },

            calculate() {
                if (!this.startDate || !this.finishDate) { this.totalHours = 0; return; }

                let startDt = new Date(this.startDate + 'T' + this.startHour + ':00');
                let finishDt = new Date(this.finishDate + 'T' + this.finishHour + ':00');
                
                let diffMs = finishDt - startDt;
                if (diffMs <= 0) { this.totalHours = 0; return; }

                this.totalHours = Math.round(diffMs / (1000 * 60 * 60));
                this.totalDays = Math.ceil(this.totalHours / 24);
                this.totalShifts = Math.ceil(this.totalHours / 8);
            }
        }))
    });
</script>
@endsection
