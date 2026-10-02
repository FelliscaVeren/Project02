@extends('layouts.app')

@section('title', 'Approval SPK Baru')

@section('content')
<div class="max-w-6xl mx-auto h-full flex flex-col gap-6" x-data="approvalFlow()">
    
    <!-- Simulasi Ganti Form Berdasarkan Departemen -->
    <div class="bg-cyan/10 border border-cyan/20 rounded-xl p-4 flex items-center justify-between flex-wrap gap-3">
        <div class="flex items-center gap-2">
            <p class="text-sm text-navy font-bold">Otoritas Approver (Berurutan Mandatory):</p>
            <span class="bg-cyan text-white text-[10px] font-bold px-2 py-0.5 rounded uppercase">Sequential Flow</span>
        </div>
        <select x-model="currentRole" class="bg-white border border-slate-200 rounded-lg px-3 py-1.5 text-sm text-navy font-bold focus:outline-none focus:border-cyan shadow-sm">
            <option value="gudang">1. Dept. Gudang / Inventory</option>
            <option value="pe">2. Dept. Process Engineering (PE)</option>
            <option value="rnd">3. Dept. R&D (Otoritas Resep)</option>
            <option value="qc">4. Dept. Quality Control (QC)</option>
        </select>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 flex-1">
        <!-- Kolom Kiri: Info SPK Baru & Transparansi Resep (Lebar 4) -->
        <div class="lg:col-span-4 space-y-6">
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5">
                <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wide mb-4 border-b border-slate-100 pb-2">Informasi SPK Baru</h4>
                
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
                <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wide mb-4">Progress Approval Berurutan</h4>
                <div class="space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold" :class="currentRole == 'gudang' ? 'bg-cyan text-white shadow-md' : 'bg-emerald-100 text-emerald-700'">1</div>
                        <div class="text-sm flex-1 flex justify-between items-center">
                            <p class="font-bold" :class="currentRole == 'gudang' ? 'text-navy' : 'text-slate-700'">Dept. Gudang</p>
                            <span class="text-[9px] font-bold px-1.5 py-0.5 rounded" :class="approvalStatus.gudang ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700'" x-text="approvalStatus.gudang ? '✓ ACC' : 'Pending'"></span>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold" :class="currentRole == 'pe' ? 'bg-cyan text-white shadow-md' : 'bg-slate-100 text-slate-400'">2</div>
                        <div class="text-sm flex-1 flex justify-between items-center">
                            <p class="font-bold" :class="currentRole == 'pe' ? 'text-navy' : 'text-slate-500'">Dept. PE</p>
                            <span class="text-[9px] font-bold px-1.5 py-0.5 rounded" :class="approvalStatus.pe ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-500'" x-text="approvalStatus.pe ? '✓ ACC' : 'Menunggu Gudang'"></span>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold" :class="currentRole == 'rnd' ? 'bg-cyan text-white shadow-md' : 'bg-slate-100 text-slate-400'">3</div>
                        <div class="text-sm flex-1 flex justify-between items-center">
                            <p class="font-bold" :class="currentRole == 'rnd' ? 'text-navy' : 'text-slate-500'">Dept. R&D</p>
                            <span class="text-[9px] font-bold px-1.5 py-0.5 rounded" :class="approvalStatus.rnd ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-500'" x-text="approvalStatus.rnd ? '✓ ACC' : 'Menunggu PE'"></span>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold" :class="currentRole == 'qc' ? 'bg-cyan text-white shadow-md' : 'bg-slate-100 text-slate-400'">4</div>
                        <div class="text-sm flex-1 flex justify-between items-center">
                            <p class="font-bold" :class="currentRole == 'qc' ? 'text-navy' : 'text-slate-500'">Dept. QC</p>
                            <span class="text-[9px] font-bold px-1.5 py-0.5 rounded" :class="approvalStatus.qc ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-500'" x-text="approvalStatus.qc ? '✓ ACC' : 'Menunggu R&D'"></span>
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
                    
                    <!-- Form Gudang (Step 1) -->
                    <div x-show="currentRole === 'gudang'" class="space-y-4">
                        <div class="flex justify-between items-center border-b border-slate-100 pb-3">
                            <h4 class="font-bold text-navy flex items-center gap-2">
                                <svg class="w-5 h-5 text-cyan" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                1. Verifikasi Stok & Material (Gudang)
                            </h4>
                            <span class="text-[10px] bg-cyan/10 text-cyan font-bold px-2 py-0.5 rounded">Langkah 1 dari 4</span>
                        </div>
                        
                        <div class="space-y-3">
                            <label class="flex items-start gap-3 p-3.5 border border-slate-200 rounded-xl hover:bg-slate-50 cursor-pointer transition-colors bg-white shadow-sm">
                                <input type="checkbox" checked class="mt-1 w-4 h-4 text-cyan border-slate-300 rounded focus:ring-cyan">
                                <div>
                                    <span class="block text-sm font-bold text-slate-800">Verifikasi Stok Fisik Gudang</span>
                                    <span class="block text-xs text-slate-500 mt-0.5">Lot number diterbitkan langsung dari Gudang saat material ditarik.</span>
                                </div>
                            </label>

                            <!-- Pilihan Ketersediaan Stok & Opsi Material Alternatif / BOM -->
                            <div class="p-4 border border-cyan/30 rounded-xl bg-cyan/5 space-y-3">
                                <label class="block text-xs font-bold text-navy uppercase tracking-wide">Status Ketersediaan Material di Gudang</label>
                                <div class="grid grid-cols-2 gap-2">
                                    <button type="button" @click="gudangStockMode = 'cukup'" :class="gudangStockMode === 'cukup' ? 'bg-cyan text-white shadow-sm' : 'bg-white border border-slate-200 text-slate-600'" class="p-2.5 rounded-lg text-xs font-bold transition-all text-left">
                                        ✓ Stok Lengkap (Cukup)
                                    </button>
                                    <button type="button" @click="gudangStockMode = 'alternatif'" :class="gudangStockMode === 'alternatif' ? 'bg-amber-500 text-white shadow-sm' : 'bg-white border border-slate-200 text-slate-600'" class="p-2.5 rounded-lg text-xs font-bold transition-all text-left">
                                        ⚠️ Material Kosong / Pilih Alternatif
                                    </button>
                                </div>

                                <!-- Panel Material Alternatif / BOM -->
                                <div x-show="gudangStockMode === 'alternatif'" x-transition class="pt-2 space-y-3 border-t border-cyan/20">
                                    <div class="p-3 bg-amber-50 border border-amber-200 rounded-lg">
                                        <p class="text-xs font-bold text-amber-800 mb-1">Pilih Material Alternatif dari Stok Gudang yang Tersedia:</p>
                                        <select x-model="altMaterialSelected" class="w-full bg-white border border-amber-300 rounded-lg px-3 py-2 text-xs font-bold text-navy outline-none focus:ring-2 focus:ring-amber-400">
                                            <option value="RM-PVC-002 (Resin S-60)">RM-PVC-002: Resin PVC S-60 (Stok: 2,500 Kg)</option>
                                            <option value="ADD-013 (Stabilizer Ca-Zn Rev2)">ADD-013: Stabilizer Ca-Zn Grade B (Stok: 120 Kg)</option>
                                            <option value="ADD-019 (TiO2 High Grade)">ADD-019: Pigment TiO2 Brand B (Stok: 45 Kg)</option>
                                        </select>
                                        <p class="text-[10px] text-amber-700 mt-1.5 italic">* Pilihan material alternatif akan otomatis menyesuaikan daftar racikan BOM untuk diajukan ke PE & RND.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form PE / Process Engineering (Step 2) -->
                    <div x-show="currentRole === 'pe'" x-data="peForm()" class="space-y-5">
                        <div class="flex justify-between items-center border-b border-slate-100 pb-3">
                            <h4 class="font-bold text-navy flex items-center gap-2">
                                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path></svg>
                                2. Alokasi Mesin & Feeder (Process Engineering)
                            </h4>
                            <span class="text-[10px] bg-indigo-100 text-indigo-700 font-bold px-2 py-0.5 rounded">Langkah 2 dari 4</span>
                        </div>

                        <!-- Pengkondisian Jenis Produk (Rutin / Tidak Rutin / Trial) -->
                        <div class="p-3.5 bg-slate-50 border border-slate-200 rounded-xl space-y-2">
                            <label class="block text-xs font-bold text-slate-700">Kategori & Sifat Produk SPK ini:</label>
                            <div class="grid grid-cols-3 gap-2">
                                <label class="flex items-center gap-2 p-2 bg-white border border-slate-200 rounded-lg text-xs font-bold cursor-pointer hover:border-cyan">
                                    <input type="radio" name="prodType" value="rutin" x-model="productType" class="text-cyan focus:ring-cyan">
                                    <span>Produk Rutin</span>
                                </label>
                                <label class="flex items-center gap-2 p-2 bg-white border border-slate-200 rounded-lg text-xs font-bold cursor-pointer hover:border-amber-400">
                                    <input type="radio" name="prodType" value="tidak_rutin" x-model="productType" class="text-amber-500 focus:ring-amber-400">
                                    <span>Tidak Rutin</span>
                                </label>
                                <label class="flex items-center gap-2 p-2 bg-white border border-slate-200 rounded-lg text-xs font-bold cursor-pointer hover:border-purple-400">
                                    <input type="radio" name="prodType" value="trial" x-model="productType" class="text-purple-600 focus:ring-purple-400">
                                    <span>Trial Run</span>
                                </label>
                            </div>
                            <p class="text-[10px] text-slate-500" x-text="productType === 'rutin' ? 'ℹ️ Produk Rutin: Cukup diverifikasi parameter standar oleh PE.' : '⚠️ Produk Tidak Rutin / Trial: Membutuhkan verifikasi & instruksi khusus dari R&D di tahap berikutnya.'"></p>
                        </div>

                        <!-- Pengaturan Mesin Digunakan Buat Produk Apa & Material per Feeder -->
                        <div class="p-4 border border-indigo-200 bg-indigo-50/40 rounded-xl space-y-3">
                            <h5 class="text-xs font-bold text-indigo-900 uppercase tracking-wide flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                Configuration Mesin & Material per Feeder
                            </h5>

                            <div>
                                <label class="block text-[11px] font-bold text-slate-700 mb-1">Mesin Digunakan Untuk Produk:</label>
                                <input type="text" x-model="peMachineProduct" class="w-full bg-white border border-slate-200 rounded-lg px-3 py-2 text-xs font-bold text-navy outline-none focus:ring-2 focus:ring-indigo-400" placeholder="Misal: PVC Pipe Grade A / Compound White">
                            </div>

                            <!-- Feeder Allocation List -->
                            <div class="space-y-2.5 pt-2">
                                <div class="flex justify-between items-center">
                                    <label class="text-[11px] font-bold text-slate-700 uppercase tracking-wider">Penentuan Material per Feeder:</label>
                                    <button type="button" @click="addFeeder()" class="text-[10px] font-bold text-indigo-600 bg-white border border-indigo-200 hover:bg-indigo-50 px-2 py-1 rounded transition-colors">+ Tambah Feeder</button>
                                </div>

                                <template x-for="(f, idx) in feeders" :key="idx">
                                    <div class="p-3 bg-white border border-slate-200 rounded-lg shadow-sm space-y-2">
                                        <div class="flex justify-between items-center border-b border-slate-100 pb-1">
                                            <span class="text-xs font-bold text-navy" x-text="f.name"></span>
                                            <button type="button" @click="removeFeeder(idx)" class="text-red-400 hover:text-red-600 text-[10px] font-bold" x-show="feeders.length > 1">Hapus</button>
                                        </div>
                                        <div class="grid grid-cols-2 gap-2">
                                            <div>
                                                <label class="block text-[10px] text-slate-500 font-bold mb-0.5">Material Utama 1</label>
                                                <input type="text" x-model="f.materialA" class="w-full bg-slate-50 border border-slate-200 rounded px-2.5 py-1.5 text-xs font-medium text-slate-800 outline-none focus:border-indigo-400">
                                            </div>
                                            <div>
                                                <label class="block text-[10px] text-slate-500 font-bold mb-0.5">Material Tambahan 2</label>
                                                <input type="text" x-model="f.materialB" class="w-full bg-slate-50 border border-slate-200 rounded px-2.5 py-1.5 text-xs font-medium text-slate-800 outline-none focus:border-indigo-400">
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <!-- Review Checklist Mesin (Jumlah di Mesin Dihapus) -->
                        <div>
                            <p class="text-xs font-bold text-slate-700 mb-2">Checklist Koreksi Tipe Mesin & Feeder:</p>
                            <div class="space-y-3">
                                <template x-for="field in fields" :key="field.id">
                                    <div class="rounded-xl border transition-all" :class="field.flagged ? 'border-amber-300 bg-amber-50/60' : 'border-slate-200 bg-white'">
                                        <div class="flex items-center gap-3 p-3">
                                            <input type="checkbox" x-model="field.flagged" class="w-4 h-4 text-amber-500 border-slate-300 rounded focus:ring-amber-400 flex-shrink-0">
                                            <div class="flex-1 min-w-0">
                                                <div class="flex justify-between items-center flex-wrap gap-2">
                                                    <div>
                                                        <p class="text-sm font-bold text-slate-800" x-text="field.label"></p>
                                                        <p class="text-xs text-slate-500 mt-0.5">
                                                            Mesin Terpilih: 
                                                            <span class="font-bold" :class="field.flagged ? 'text-red-600 line-through' : 'text-navy'" x-text="field.currentValue"></span>
                                                        </p>
                                                    </div>
                                                    <span x-show="field.flagged" class="text-[9px] font-bold text-amber-700 bg-amber-100 border border-amber-300 px-2 py-0.5 rounded uppercase tracking-wide">Perlu Koreksi</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div x-show="field.flagged" x-transition class="px-3 pb-3 pt-0 border-t border-amber-200">
                                            <div class="bg-white rounded-lg p-3 border border-amber-100 mt-2 space-y-3">
                                                <div>
                                                    <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wide mb-1">Tipe Mesin yang Seharusnya</label>
                                                    <input type="text" x-model="field.correctedValue" class="w-full bg-slate-50 border border-slate-200 rounded-lg px-3 py-2 text-sm font-bold text-navy focus:ring-2 focus:ring-amber-400 outline-none">
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
                        </div>

                     </div>

                    <!-- Form R&D (Step 3) -->
                    <div x-show="currentRole === 'rnd'" class="space-y-4">
                        <div class="flex justify-between items-center border-b border-slate-100 pb-3">
                            <h4 class="font-bold text-navy flex items-center gap-2">
                                <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>
                                3. Otoritas Resep & Instruksi Trial (R&D)
                            </h4>
                            <span class="text-[10px] bg-amber-100 text-amber-800 font-bold px-2 py-0.5 rounded">Langkah 3 dari 4</span>
                        </div>

                        <!-- Status Kondisional dari PE -->
                        <div class="p-3.5 rounded-xl border" :class="productType === 'rutin' ? 'bg-emerald-50 border-emerald-200' : (productType === 'trial' ? 'bg-purple-50 border-purple-200' : 'bg-amber-50 border-amber-200')">
                            <div class="flex items-center gap-2">
                                <span class="font-bold text-xs" :class="productType === 'rutin' ? 'text-emerald-800' : (productType === 'trial' ? 'text-purple-800' : 'text-amber-800')">
                                    Status Sifat Produk: <span class="uppercase underline" x-text="productType"></span>
                                </span>
                            </div>
                            <p class="text-xs mt-1" :class="productType === 'rutin' ? 'text-emerald-700' : (productType === 'trial' ? 'text-purple-700' : 'text-amber-700')">
                                <template x-if="productType === 'rutin'">
                                    <span>✓ Produk Rutin: Menggunakan formula master R&D standar tanpa memerlukan trial tambahan.</span>
                                </template>
                                <template x-if="productType === 'tidak_rutin'">
                                    <span>⚠️ Produk Tidak Rutin: R&D menyusun instruksi penyesuaian parameter khusus sebelum diproduksi.</span>
                                </template>
                                <template x-if="productType === 'trial'">
                                    <span>🧪 Produk Trial: Wajib menyertakan instruksi uji coba trial run dari R&D untuk dipantau oleh QC.</span>
                                </template>
                            </p>
                        </div>
                        
                        <label class="flex items-start gap-3 p-3.5 border border-slate-200 rounded-xl hover:bg-slate-50 cursor-pointer transition-colors bg-white">
                            <input type="checkbox" checked class="mt-1 w-4 h-4 text-cyan border-slate-300 rounded focus:ring-cyan">
                            <div>
                                <span class="block text-sm font-bold text-slate-800">Formula & Resep Valid Disetujui</span>
                                <span class="block text-xs text-slate-500 mt-0.5">Komposisi racikan dan alokasi material per feeder dari PE sudah teruji standar R&D.</span>
                            </div>
                        </label>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">Instruksi Khusus / Parameter Trial R&D:</label>
                            <textarea rows="3" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-xs focus:ring-2 focus:ring-amber-400 outline-none transition-all mb-3" placeholder="Ketik instruksi khusus (Misal: Suhu zone 1-4 175C, RPM Feeder 1 45 rpm, RPM Feeder 2 12 rpm...)"></textarea>
                        </div>
                    </div>

                    <!-- Form QC / Quality Control (Step 4) -->
                    <div x-show="currentRole === 'qc'" class="space-y-4">
                        <div class="flex justify-between items-center border-b border-slate-100 pb-3">
                            <h4 class="font-bold text-navy flex items-center gap-2">
                                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                4. Final Approval & Metode Pengujian QC
                            </h4>
                            <span class="text-[10px] bg-emerald-100 text-emerald-800 font-bold px-2 py-0.5 rounded">Langkah 4 dari 4 (Final)</span>
                        </div>

                        <!-- Form Metode Pengujian QC & Tambahan Instruksi (Manpower Dihilangkan) -->
                        <div class="p-4 border border-emerald-200 bg-emerald-50/40 rounded-xl space-y-4">
                            <div>
                                <label class="block text-xs font-bold text-emerald-900 mb-1.5">
                                    Metode Pengujian / QC Inspection Method <span class="text-red-500">*</span>
                                </label>
                                <select x-model="qcMethod" class="w-full bg-white border border-emerald-300 rounded-lg px-3 py-2 text-xs font-bold text-navy focus:ring-2 focus:ring-emerald-400 outline-none">
                                    <option value="Physical & Mechanical Test (MFI, Tensile, Density)">Physical & Mechanical Test (MFI, Tensile, Density)</option>
                                    <option value="Pengujian Dispersi & Visual Standard (1 Jam Sekali)">Pengujian Dispersi & Visual Standard (1 Jam Sekali)</option>
                                    <option value="QC Goods Check & KPI Bagging Final">QC Goods Check & KPI Bagging Final</option>
                                    <option value="Full Lab Sampling & Complete Verification">Full Lab Sampling & Complete Verification</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-emerald-900 mb-1.5">
                                    Tambahan Instruksi Khusus QC
                                </label>
                                <textarea rows="2" x-model="qcInstructions" class="w-full bg-white border border-emerald-300 rounded-lg px-3 py-2 text-xs text-slate-800 focus:ring-2 focus:ring-emerald-400 outline-none" placeholder="Ketik tambahan instruksi khusus QC (misal: Cek kecerahan warna per 30 menit, toleransi SG 1.34 +/- 0.02)..."></textarea>
                            </div>

                            <div class="grid grid-cols-2 gap-3 pt-3 border-t border-emerald-200/60 items-end">
                                <div class="flex flex-col">
                                    <label class="block text-xs font-bold text-emerald-900 mb-1.5 min-h-[24px] flex items-end">
                                        Tanggal Eksekusi SPK & Formula
                                    </label>
                                    <input type="date" x-model="qcStartDate" class="w-full h-10 bg-white border border-emerald-300 rounded-lg px-3 text-xs font-bold text-navy focus:ring-2 focus:ring-emerald-400 outline-none">
                                </div>
                                <div class="flex flex-col">
                                    <label class="block text-xs font-bold text-emerald-900 mb-1.5 min-h-[24px] flex items-end">
                                        Jam Start Run Mesin
                                    </label>
                                    <input type="time" x-model="qcStartTime" class="w-full h-10 bg-white border border-emerald-300 rounded-lg px-3 text-xs font-bold text-navy focus:ring-2 focus:ring-emerald-400 outline-none">
                                </div>
                            </div>
                        </div>

                        <label class="flex items-start gap-3 p-3.5 border border-slate-200 rounded-xl hover:bg-slate-50 cursor-pointer transition-colors bg-white">
                            <input type="checkbox" x-model="qcFormulaConfirmed" class="mt-1 w-4 h-4 text-emerald-600 border-slate-300 rounded focus:ring-emerald-500">
                            <div>
                                <span class="block text-sm font-bold text-slate-800">Verifikasi QC, Metode & Jadwal Lengkap</span>
                                <span class="block text-xs text-slate-500 mt-0.5">Formula, metode pengujian QC, instruksi khusus, dan jadwal run telah divalidasi penuh.</span>
                            </div>
                        </label>
                    </div>

                </div>

                <!-- 3 Tombol Aksi -->
                <div class="p-5 bg-slate-50 border-t border-slate-200 flex justify-between items-center mt-auto">
                    <button type="button" class="px-4 py-2 text-xs font-bold text-red-600 bg-white border border-red-200 rounded-lg hover:bg-red-50 hover:border-red-300 transition-colors">Tolak SPK</button>
                    <div class="flex gap-2">
                        <button type="button" @click="openRevisionModal" class="px-4 py-2 text-xs font-bold text-amber-600 bg-white border border-amber-200 rounded-lg hover:bg-amber-50 hover:border-amber-300 transition-colors">Minta Revisi</button>
                        <button type="button" @click="approveCurrentStep()" class="px-6 py-2.5 text-xs font-bold text-white bg-cyan hover:bg-cyan/90 rounded-lg shadow-md shadow-cyan/20 transition-colors flex items-center gap-1.5">
                            <span>Setujui (ACC <span class="uppercase font-black" x-text="currentRole"></span>)</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </button>
                    </div>
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
            
            // Status approval per departemen (Berurutan / Sequential mandatory: Gudang -> PE -> RND -> QC)
            approvalStatus: {
                gudang: false,
                pe: false,
                rnd: false,
                qc: false
            },

            // Pengkondisian Jenis Produk (Ditentukan oleh PE / PPIC): 'rutin' | 'tidak_rutin' | 'trial'
            productType: 'rutin',

            // State Gudang - Material Alternatif / BOM
            gudangStockMode: 'cukup', // 'cukup' | 'alternatif'
            altMaterialSelected: 'RM-PVC-002 (Resin S-60)',

            // State Feeder & Material per Feeder (Ditentukan oleh PE)
            peMachineProduct: 'PVC Compound A High Impact',
            feeders: [
                { name: 'Feeder 1', materialA: 'Resin PVC S-65', materialB: 'Pigment White TiO2' },
                { name: 'Feeder 2', materialA: 'Stabilizer Ca-Zn', materialB: 'Lubricant Wax' }
            ],

            // State QC - Metode & Tambahan Instruksi (Manpower Dihilangkan)
            qcMethod: 'Physical & Mechanical Test (MFI, Tensile, Density)',
            qcInstructions: 'Cek kecerahan warna per 30 menit, toleransi SG 1.34 +/- 0.02.',
            qcStartDate: '2026-08-28',
            qcStartTime: '08:00',
            qcFormulaConfirmed: true,

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
            },

            addFeeder() {
                const nextNum = this.feeders.length + 1;
                this.feeders.push({
                    name: `Feeder ${nextNum}`,
                    materialA: 'Material Baru',
                    materialB: '-'
                });
            },

            removeFeeder(idx) {
                if (this.feeders.length > 1) {
                    this.feeders.splice(idx, 1);
                }
            },

            approveCurrentStep() {
                this.approvalStatus[this.currentRole] = true;
                const roleDeptName = { gudang: 'Gudang', pe: 'PE', rnd: 'R&D', qc: 'QC' }[this.currentRole];
                
                this.revisionLogs.unshift({
                    type: 'acc',
                    action: `SPK Disetujui (${roleDeptName})`,
                    user: `Simulasi (${roleDeptName})`,
                    time: 'Baru saja',
                    note: this.currentRole === 'qc' ? `Metode QC: ${this.qcMethod}, Jadwal Run: ${this.qcStartDate} ${this.qcStartTime}` : 'Disetujui tanpa catatan'
                });

                // Auto advance to next role in sequence Gudang -> PE -> RND -> QC
                if (this.currentRole === 'gudang') this.currentRole = 'pe';
                else if (this.currentRole === 'pe') this.currentRole = 'rnd';
                else if (this.currentRole === 'rnd') this.currentRole = 'qc';
                else if (this.currentRole === 'qc') {
                    alert('🎉 Seluruh persetujuan (Gudang -> PE -> RND -> QC) telah LENGKAP! SPK Siap dijalankan ke Produksi.');
                    window.location.href = "{{ route('produksi.alokasi') }}";
                }
            }
        }));

        Alpine.data('peForm', () => ({
            fields: [
                {
                    id: 'mixer',
                    label: 'Mesin Mixer',
                    currentValue: 'Mixer A-01',
                    correctedValue: 'Mixer B-02',
                    type: 'text',
                    unit: '',
                    reason: '',
                    exampleReason: 'Mixer A-01 kapasitas kurang, harusnya pakai Mixer B-02',
                    flagged: true
                },
                {
                    id: 'extruder',
                    label: 'Mesin Extruder',
                    currentValue: 'Ext Line 1',
                    correctedValue: '',
                    type: 'select',
                    options: ['Ext Line 1', 'Ext Line 2', 'Ext Line 3'],
                    unit: '',
                    reason: '',
                    exampleReason: 'Kapasitas Ext Line 1 tidak cukup untuk batch ini',
                    flagged: false
                },
                {
                    id: 'feeder',
                    label: 'Feeder',
                    currentValue: 'Feeder 01',
                    correctedValue: '',
                    type: 'select',
                    options: ['Feeder 01', 'Feeder 02', 'Feeder 03'],
                    unit: '',
                    reason: '',
                    exampleReason: 'Feeder 01 dialokasikan ke SPK lain di waktu bersamaan',
                    flagged: false
                }
            ],

            get flaggedCount() {
                return this.fields.filter(f => f.flagged).length;
            },

            // === Notes / Catatan Internal ===
            showNoteInput: false,
            newNote: { poin: '', detail: '' },
            notes: [
                { poin: 'Kapasitas Mixer', detail: 'Mixer A-01 tidak cukup untuk batch ini, perlu ditinjau ulang', by: 'Ir. Budi (PE)', time: '27 Ags, 09:45' }
            ],

            saveNote() {
                if (!this.newNote.poin.trim() || !this.newNote.detail.trim()) return;
                this.notes.push({
                    poin: this.newNote.poin,
                    detail: this.newNote.detail,
                    by: 'PE (Simulasi)',
                    time: new Date().toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' }) + ', ' + new Date().toLocaleDateString('id-ID', { day: '2-digit', month: 'short' })
                });
                this.newNote = { poin: '', detail: '' };
                this.showNoteInput = false;
            }
        }));
    });
</script>
@endsection
