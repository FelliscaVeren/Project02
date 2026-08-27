@extends('layouts.app')

@section('title', 'Review Draft SPK')

@section('content')
<div class="max-w-6xl mx-auto h-full flex flex-col gap-6" x-data="approvalFlow()">
    
    <!-- Simulasi Ganti Form Berdasarkan Departemen -->
    <div class="bg-cyan/10 border border-cyan/20 rounded-xl p-4 flex items-center justify-between">
        <p class="text-sm text-navy font-bold">Otoritas Approver (Simulasi):</p>
        <select x-model="currentRole" class="bg-white border border-slate-200 rounded-lg px-3 py-1.5 text-sm text-navy font-bold focus:outline-none focus:border-cyan shadow-sm">
            <option value="gudang">Dept. Gudang / Inventory</option>
            <option value="rnd">Dept. R&D (Otoritas Resep)</option>
            <option value="pe">Dept. Process Engineering (PE)</option>
            <option value="qc">Dept. Quality Control (QC)</option>
        </select>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 flex-1">
        <!-- Kolom Kiri: Info Draft & Transparansi Resep (Lebar 4) -->
        <div class="lg:col-span-4 space-y-6">
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5">
                <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wide mb-4 border-b border-slate-100 pb-2">Informasi Draft SPK</h4>
                
                <div class="space-y-4 text-sm">
                    <div>
                        <p class="text-slate-500 mb-1 text-xs">No. Referensi</p>
                        <p class="font-bold text-navy">DRF-SPK-2608-01</p>
                    </div>
                    <div>
                        <p class="text-slate-500 mb-1 text-xs">Produk Akhir</p>
                        <p class="font-bold text-navy">PVC Compound A</p>
                    </div>
                    <div>
                        <p class="text-slate-500 mb-1 text-xs">Waktu & Target Jam</p>
                        <p class="font-bold text-navy">12 - 14 Aug (24 Jam/Hari)</p>
                    </div>
                </div>
            </div>

            <!-- Transparansi Resep -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 border-t-4 border-t-cyan">
                <h4 class="text-xs font-bold text-navy uppercase tracking-wide mb-3 flex items-center gap-2">
                    <svg class="w-4 h-4 text-cyan" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                    Transparansi Formula
                </h4>
                <div class="bg-slate-50 rounded-lg p-3 border border-slate-100 mb-3">
                    <p class="text-xs text-slate-500 mb-1">Nama Formula Asal</p>
                    <p class="text-sm font-bold text-navy">Formula-PVC-A-Rev01</p>
                </div>
                <div class="text-xs text-slate-700">
                    <p class="font-bold mb-2">Komposisi per Batch:</p>
                    <ul class="space-y-1.5">
                        <li class="flex justify-between border-b border-slate-100 pb-1"><span>Resin PVC S-65</span><span class="font-bold">25 Kg</span></li>
                        <li class="flex justify-between border-b border-slate-100 pb-1"><span>Stabilizer Ca-Zn</span><span class="font-bold">1 Kg</span></li>
                        <li class="flex justify-between"><span>Pigment White</span><span class="font-bold">0.5 Kg</span></li>
                    </ul>
                </div>
            </div>
            
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5">
                <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wide mb-4">Progress Approval</h4>
                <div class="space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold" :class="currentRole == 'gudang' ? 'bg-cyan text-white shadow-md' : 'bg-slate-100 text-slate-400'">1</div>
                        <div class="text-sm">
                            <p class="font-bold" :class="currentRole == 'gudang' ? 'text-navy' : 'text-slate-500'">Dept. Gudang</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold" :class="currentRole == 'rnd' ? 'bg-cyan text-white shadow-md' : 'bg-slate-100 text-slate-400'">2</div>
                        <div class="text-sm">
                            <p class="font-bold" :class="currentRole == 'rnd' ? 'text-navy' : 'text-slate-500'">Dept. R&D</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold" :class="currentRole == 'pe' ? 'bg-cyan text-white shadow-md' : 'bg-slate-100 text-slate-400'">3</div>
                        <div class="text-sm">
                            <p class="font-bold" :class="currentRole == 'pe' ? 'text-navy' : 'text-slate-500'">Dept. PE</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold" :class="currentRole == 'qc' ? 'bg-cyan text-white shadow-md' : 'bg-slate-100 text-slate-400'">4</div>
                        <div class="text-sm">
                            <p class="font-bold" :class="currentRole == 'qc' ? 'text-navy' : 'text-slate-500'">Dept. QC</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kolom Tengah: Form Review & Aksi (Lebar 5) -->
        <div class="lg:col-span-5">
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden h-full flex flex-col relative">
                <div class="p-6 border-b border-slate-100 bg-slate-50/50">
                    <h3 class="text-lg font-bold text-navy">Form Keputusan Departemen</h3>
                    <p class="text-sm text-slate-500">Mohon verifikasi secara teliti sebelum memberikan keputusan (Setuju / Revisi / Tolak).</p>
                </div>
                
                <div class="p-6 flex-1 space-y-6 overflow-y-auto">
                    
                    <!-- Form Gudang -->
                    <div x-show="currentRole === 'gudang'">
                        <h4 class="font-bold text-navy mb-4">Verifikasi Gudang / Inventory</h4>
                        <div class="space-y-3">
                            <label class="flex items-start gap-3 p-3 border border-slate-200 rounded-xl hover:bg-slate-50 cursor-pointer transition-colors">
                                <input type="checkbox" class="mt-1 w-4 h-4 text-cyan border-slate-300 rounded focus:ring-cyan">
                                <div>
                                    <span class="block text-sm font-bold text-slate-800">Material Fisik Tersedia</span>
                                    <span class="block text-xs text-slate-500 mt-1">Stok fisik aktual di gudang sudah diperiksa dan sesuai dengan kebutuhan batch draf SPK.</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Form RnD -->
                    <div x-show="currentRole === 'rnd'">
                        <h4 class="font-bold text-navy mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>
                            Otoritas Resep (R&D)
                        </h4>
                        
                        <label class="flex items-start gap-3 p-3 border border-slate-200 rounded-xl hover:bg-slate-50 cursor-pointer transition-colors mb-6">
                            <input type="checkbox" class="mt-1 w-4 h-4 text-cyan border-slate-300 rounded focus:ring-cyan">
                            <div>
                                <span class="block text-sm font-bold text-slate-800">Formula & Resep Valid</span>
                                <span class="block text-xs text-slate-500 mt-1">Draf formula (Standard) sudah dicek dan sesuai dengan standar R&D terbaru.</span>
                            </div>
                        </label>

                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Instruksi / Metode Kerja Tambahan</label>
                            <textarea rows="4" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-cyan outline-none transition-all" placeholder="Misal: Suhu mixing 180C, waktu 15 menit..."></textarea>
                        </div>
                    </div>

                    <!-- Form PE (Process Engineering) -->
                    <div x-show="currentRole === 'pe'" x-data="peForm()">
                        <h4 class="font-bold text-navy mb-1 flex items-center gap-2">
                            <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            Review Mesin (Process Engineering)
                        </h4>
                        <p class="text-xs text-slate-500 mb-4">Centang field yang perlu dikoreksi, isi nilai yang benar, lalu tambahkan catatan.</p>

                        <!-- Field-level Revision Checklist -->
                        <div class="space-y-3 mb-5">
                            <template x-for="field in fields" :key="field.id">
                                <div class="rounded-xl border transition-all" :class="field.flagged ? 'border-amber-300 bg-amber-50/60' : 'border-slate-200 bg-white'">
                                    <!-- Row header: checkbox + label + current value -->
                                    <div class="flex items-center gap-3 p-3">
                                        <input type="checkbox" x-model="field.flagged" class="w-4 h-4 text-amber-500 border-slate-300 rounded focus:ring-amber-400 flex-shrink-0">
                                        <div class="flex-1 min-w-0">
                                            <div class="flex justify-between items-center flex-wrap gap-2">
                                                <div>
                                                    <p class="text-sm font-bold text-slate-800" x-text="field.label"></p>
                                                    <p class="text-xs text-slate-500 mt-0.5">
                                                        Nilai saat ini: 
                                                        <span class="font-bold" :class="field.flagged ? 'text-red-600 line-through' : 'text-navy'" x-text="field.currentValue"></span>
                                                    </p>
                                                </div>
                                                <span x-show="field.flagged" class="text-[9px] font-bold text-amber-700 bg-amber-100 border border-amber-300 px-2 py-0.5 rounded uppercase tracking-wide">Perlu Koreksi</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Expanded correction form (when flagged) -->
                                    <div x-show="field.flagged" x-transition class="px-3 pb-3 pt-0 border-t border-amber-200">
                                        <div class="bg-white rounded-lg p-3 border border-amber-100 mt-2 space-y-3">
                                            <div>
                                                <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wide mb-1">Nilai yang Benar / Seharusnya</label>
                                                <div class="flex gap-2 items-center">
                                                    <!-- Dynamic input type based on field -->
                                                    <template x-if="field.type === 'select'">
                                                        <select x-model="field.correctedValue" class="flex-1 bg-slate-50 border border-slate-200 rounded-lg px-3 py-2 text-sm font-bold text-navy focus:ring-2 focus:ring-amber-400 outline-none">
                                                            <template x-for="opt in field.options" :key="opt">
                                                                <option :value="opt" x-text="opt"></option>
                                                            </template>
                                                        </select>
                                                    </template>
                                                    <template x-if="field.type === 'number'">
                                                        <input type="number" x-model="field.correctedValue" class="w-28 bg-slate-50 border border-slate-200 rounded-lg px-3 py-2 text-sm font-bold text-navy focus:ring-2 focus:ring-amber-400 outline-none">
                                                    </template>
                                                    <template x-if="field.type === 'text'">
                                                        <input type="text" x-model="field.correctedValue" class="flex-1 bg-slate-50 border border-slate-200 rounded-lg px-3 py-2 text-sm font-bold text-navy focus:ring-2 focus:ring-amber-400 outline-none">
                                                    </template>
                                                    <span x-show="field.unit" class="text-xs text-slate-500 font-medium flex-shrink-0" x-text="field.unit"></span>
                                                </div>
                                                <!-- Show diff -->
                                                <p x-show="field.correctedValue" class="text-[10px] mt-1.5 text-slate-500">
                                                    <span class="text-red-500 line-through font-medium" x-text="field.currentValue"></span>
                                                    <svg class="w-3 h-3 inline text-slate-400 mx-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                                    <span class="text-emerald-600 font-bold" x-text="field.correctedValue + (field.unit ? ' ' + field.unit : '')"></span>
                                                </p>
                                            </div>
                                            <div>
                                                <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wide mb-1">Alasan Koreksi <span class="text-red-500">*</span></label>
                                                <input type="text" x-model="field.reason" class="w-full bg-slate-50 border border-slate-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-amber-400 outline-none" :placeholder="'Contoh: ' + field.exampleReason">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <!-- Summary of flagged items -->
                        <div x-show="flaggedCount > 0" x-transition class="bg-amber-50 border border-amber-200 rounded-xl p-4">
                            <p class="text-xs font-bold text-amber-800 flex items-center gap-2 mb-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                <span x-text="flaggedCount + ' item memerlukan koreksi dari PPIC'"></span>
                            </p>
                            <template x-for="field in fields.filter(f => f.flagged && f.correctedValue)" :key="field.id">
                                <p class="text-[11px] text-amber-700 ml-6 mb-1">
                                    • <span class="font-bold" x-text="field.label"></span>: 
                                    <span class="line-through opacity-60" x-text="field.currentValue"></span> → 
                                    <span class="font-bold text-amber-900" x-text="field.correctedValue + (field.unit ? ' ' + field.unit : '')"></span>
                                    <span x-show="field.reason" class="text-amber-600 italic" x-text="' (' + field.reason + ')'"></span>
                                </p>
                            </template>
                        </div>
                    </div>

                    <!-- Form QC -->
                    <div x-show="currentRole === 'qc'">
                        <h4 class="font-bold text-navy mb-4">Verifikasi Quality Control</h4>
                        <label class="flex items-start gap-3 p-3 border border-slate-200 rounded-xl hover:bg-slate-50 cursor-pointer transition-colors">
                            <input type="checkbox" class="mt-1 w-4 h-4 text-cyan border-slate-300 rounded focus:ring-cyan">
                            <div>
                                <span class="block text-sm font-bold text-slate-800">Kapasitas Manpower & Jadwal Valid</span>
                                <span class="block text-xs text-slate-500 mt-1">Estimasi manpower telah sesuai standar pengawasan Quality Control.</span>
                            </div>
                        </label>
                    </div>

                </div>

                <!-- 3 Tombol Aksi -->
                <div class="p-5 bg-slate-50 border-t border-slate-200 flex justify-end gap-3 items-center mt-auto">
                    <button class="px-5 py-2 text-sm font-bold text-red-600 bg-white border border-red-200 rounded-lg hover:bg-red-50 hover:border-red-300 transition-colors">Tolak SPK</button>
                    <button @click="openRevisionModal" class="px-5 py-2 text-sm font-bold text-amber-600 bg-white border border-amber-200 rounded-lg hover:bg-amber-50 hover:border-amber-300 transition-colors">Minta Revisi</button>
                    <a href="{{ route('produksi.alokasi') }}" class="px-8 py-2.5 text-sm font-bold text-white bg-cyan hover:bg-cyan/90 rounded-lg shadow-md shadow-cyan/20 transition-colors">
                        Setujui (ACC)
                    </a>
                </div>

                <!-- Modal Revisi Wajib (Alpine) -->
                <div x-show="showRevisionModal" class="absolute inset-0 bg-white/95 backdrop-blur-sm z-20 flex items-center justify-center p-6" style="display:none;" x-transition>
                    <form @submit.prevent="submitRevision" class="bg-white border border-slate-200 shadow-xl rounded-2xl w-full max-w-md p-6 relative">
                        <div class="flex justify-between items-center mb-2">
                            <h4 class="font-bold text-navy">Form Permintaan Revisi</h4>
                            <button type="button" @click="showRevisionModal = false" class="text-slate-400 hover:text-slate-600"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                        </div>
                        <p class="text-xs text-slate-500 mb-4">Mohon berikan catatan rinci mengapa draf ini dikembalikan. Catatan ini bersifat wajib.</p>
                        
                        <div class="mb-4 relative">
                            <label class="block text-xs font-bold text-slate-700 mb-1">Catatan Revisi <span class="text-red-500">*</span></label>
                            <textarea x-model="revisionNote" required class="w-full border border-slate-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-amber-500 focus:border-amber-500 outline-none transition-all" rows="4" placeholder="Cth: Alokasi mesin Mixer bentrok dengan jadwal pemeliharaan..."></textarea>
                            <div x-show="revisionError" style="display:none;" class="text-red-500 text-xs mt-1 font-bold">Catatan revisi wajib diisi!</div>
                        </div>
                        
                        <div class="flex justify-end gap-2">
                            <button type="button" @click="showRevisionModal = false" class="px-4 py-2 text-sm font-bold text-slate-600">Batal</button>
                            <button type="submit" class="px-4 py-2 text-sm font-bold text-white bg-amber-500 hover:bg-amber-600 rounded-lg transition-colors">Kirim Revisi</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan: Log History Revisi Real-time (Lebar 3) -->
        <div class="lg:col-span-3 bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden h-full flex flex-col">
            <div class="p-5 border-b border-slate-100 bg-slate-50/50">
                <h4 class="text-sm font-bold text-navy flex items-center gap-2">
                    <svg class="w-4 h-4 text-cyan" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Log & Riwayat Dokumen
                </h4>
            </div>
            <div class="flex-1 p-5 overflow-y-auto space-y-6 relative">
                <!-- Garis timeline -->
                <div class="absolute left-7 top-6 bottom-6 w-0.5 bg-slate-100"></div>
                
                <!-- Daftar Log -->
                <template x-for="(log, index) in revisionLogs" :key="index">
                    <div class="relative flex gap-4">
                        <div class="w-5 h-5 rounded-full flex-shrink-0 mt-0.5 border-2 border-white shadow-sm flex items-center justify-center z-10" :class="log.type === 'revision' ? 'bg-amber-500' : (log.type === 'create' ? 'bg-cyan' : 'bg-emerald-500')">
                            <template x-if="log.type === 'revision'"><svg class="w-2 h-2 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg></template>
                            <template x-if="log.type === 'create'"><svg class="w-2 h-2 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg></template>
                        </div>
                        <div class="flex-1 pb-1">
                            <p class="text-xs font-bold text-navy" x-text="log.action"></p>
                            <p class="text-[10px] text-slate-400 mt-0.5 flex justify-between">
                                <span x-text="log.user"></span>
                                <span x-text="log.time"></span>
                            </p>
                            <template x-if="log.note">
                                <div class="mt-2 p-2 bg-amber-50 border border-amber-100 rounded-lg text-[11px] text-amber-800">
                                    <span class="font-bold">Catatan:</span> <span x-text="log.note"></span>
                                </div>
                            </template>
                        </div>
                    </div>
                </template>
                
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('approvalFlow', () => ({
            currentRole: 'gudang',
            showRevisionModal: false,
            revisionNote: '',
            revisionError: false,
            
            revisionLogs: [
                { type: 'revision', action: 'Draft Dikembalikan (Revisi)', user: 'Ir. Budi (PE)', time: '27 Aug, 10:15', note: 'Mohon sesuaikan jadwal, Mixer A-01 sedang maintenance rutin pada tgl 12-13.' },
                { type: 'create', action: 'Draft Dibuat & Diajukan', user: 'Jane Doe (PPIC)', time: '27 Aug, 09:00', note: null }
            ],
            
            openRevisionModal() {
                this.revisionNote = '';
                this.revisionError = false;
                this.showRevisionModal = true;
            },
            
            submitRevision() {
                if (this.revisionNote.trim() === '') {
                    this.revisionError = true;
                    return;
                }
                
                // Tambahkan log baru ke array (Real-time update)
                let userDept = this.currentRole.toUpperCase();
                this.revisionLogs.unshift({
                    type: 'revision',
                    action: 'Draft Dikembalikan (Revisi)',
                    user: `Simulasi (${userDept})`,
                    time: 'Baru saja',
                    note: this.revisionNote
                });
                
                this.showRevisionModal = false;
                alert('Catatan revisi berhasil dikirim! Seluruh modul yang terkait akan terupdate.');
            }
        }))
    });
</script>
@endsection
