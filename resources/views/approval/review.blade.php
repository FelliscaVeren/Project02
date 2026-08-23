@extends('layouts.app')

@section('title', 'Review Draft SPK')

@section('content')
<div class="max-w-5xl mx-auto h-full flex flex-col gap-6" x-data="{ currentRole: 'gudang', showRevisionModal: false }">
    
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

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Info Draft & Transparansi Resep -->
        <div class="lg:col-span-1 space-y-6">
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

        <!-- Form Review -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden h-full flex flex-col relative">
                <div class="p-6 border-b border-slate-100 bg-slate-50/50">
                    <h3 class="text-lg font-bold text-navy">Form Keputusan Departemen</h3>
                    <p class="text-sm text-slate-500">Mohon verifikasi secara teliti sebelum memberikan keputusan (Setuju / Revisi / Tolak).</p>
                </div>
                
                <div class="p-6 flex-1 space-y-6">
                    
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

                    <!-- Form PE -->
                    <div x-show="currentRole === 'pe'">
                        <h4 class="font-bold text-navy mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            Otoritas Mesin (Process Engineering)
                        </h4>
                        
                        <div class="mb-4 bg-slate-50 p-4 rounded-xl border border-slate-200 grid grid-cols-3 gap-4">
                            <div><p class="text-[10px] font-bold text-slate-400 mb-1 uppercase">Mixer</p><p class="text-sm font-bold text-navy">Mixer A-01</p></div>
                            <div><p class="text-[10px] font-bold text-slate-400 mb-1 uppercase">Extruder</p><p class="text-sm font-bold text-navy">Ext Line 1</p></div>
                            <div><p class="text-[10px] font-bold text-slate-400 mb-1 uppercase">Feeder</p><p class="text-sm font-bold text-navy">Feeder 01</p></div>
                        </div>

                        <label class="flex items-start gap-3 p-3 border border-slate-200 rounded-xl hover:bg-slate-50 cursor-pointer transition-colors">
                            <input type="checkbox" class="mt-1 w-4 h-4 text-cyan border-slate-300 rounded focus:ring-cyan">
                            <div>
                                <span class="block text-sm font-bold text-slate-800">Kesiapan Mesin Valid</span>
                                <span class="block text-xs text-slate-500 mt-1">Tidak ada bentrok jadwal pemeliharaan mesin pada tanggal pelaksanaan SPK ini.</span>
                            </div>
                        </label>
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
                <div class="p-5 bg-slate-50 border-t border-slate-200 flex justify-end gap-3 items-center">
                    <button class="px-5 py-2 text-sm font-bold text-red-600 bg-white border border-red-200 rounded-lg hover:bg-red-50 hover:border-red-300 transition-colors">Tolak SPK</button>
                    <button @click="showRevisionModal = true" class="px-5 py-2 text-sm font-bold text-amber-600 bg-white border border-amber-200 rounded-lg hover:bg-amber-50 hover:border-amber-300 transition-colors">Minta Revisi</button>
                    <a href="{{ route('approval.index') }}" class="px-8 py-2.5 text-sm font-bold text-white bg-cyan hover:bg-cyan/90 rounded-lg shadow-md shadow-cyan/20 transition-colors">
                        Setujui (ACC)
                    </a>
                </div>

                <!-- Modal Revisi (Alpine) -->
                <div x-show="showRevisionModal" class="absolute inset-0 bg-white/90 backdrop-blur-sm z-10 flex items-center justify-center p-6" style="display:none;">
                    <div class="bg-white border border-slate-200 shadow-xl rounded-2xl w-full max-w-md p-6">
                        <h4 class="font-bold text-navy mb-2">Catatan Revisi</h4>
                        <p class="text-xs text-slate-500 mb-4">Berikan catatan mengapa draf ini dikembalikan ke PPIC untuk direvisi.</p>
                        <textarea class="w-full border border-slate-200 rounded-xl p-3 text-sm focus:ring-2 focus:ring-amber-500 outline-none mb-4" rows="4" placeholder="Tulis catatan revisi..."></textarea>
                        <div class="flex justify-end gap-2">
                            <button @click="showRevisionModal = false" class="px-4 py-2 text-sm font-bold text-slate-600">Batal</button>
                            <button class="px-4 py-2 text-sm font-bold text-white bg-amber-500 rounded-lg">Kirim Revisi</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
