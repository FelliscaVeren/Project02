@extends('layouts.app')

@section('title', 'Dokumen SPK Final & Audit Trail')

@section('content')
<div class="max-w-4xl mx-auto h-full pb-10 print:max-w-full print:pb-0" x-data="spkDetails()" x-init="init()">
    
    <!-- Action Bar -->
    <div class="flex justify-between items-center mb-6 print:hidden">
        <div>
            <h3 class="text-xl font-bold text-navy" x-text="spkId + ' '"> <span class="text-xs font-black px-2 py-1 rounded ml-2 align-middle" :class="spk?.status === 'Running' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800'" x-text="spk?.status === 'Running' ? 'FIXED / RUNNING' : 'DRAFT'"></span></h3>
            <p class="text-sm text-slate-500 mt-1">Surat Perintah Kerja resmi yang siap dieksekusi oleh Produksi.</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('ppic.calendar') }}" class="px-4 py-2.5 bg-white border border-slate-300 hover:bg-slate-50 text-slate-700 text-sm font-bold rounded-xl transition-colors flex items-center gap-2 shadow-sm">
                &larr; Kembali ke Jadwal
            </a>
            <button @click="showPdfModal = true" class="px-5 py-2.5 bg-navy hover:bg-navy-light text-white text-sm font-bold rounded-xl shadow-md transition-colors flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                Preview PDF SPK
            </button>
        </div>
    </div>

    <!-- Kertas SPK -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-xl overflow-hidden print:shadow-none print:border-none print:rounded-none" id="printable-spk">
        
        <!-- Header Dokumen -->
        <div class="border-b-4 border-navy p-8 flex justify-between items-center bg-slate-50/50 print:p-0 print:pb-6 print:bg-transparent">
            <div>
                <h1 class="text-3xl font-black text-navy uppercase tracking-tight">Surat Perintah Kerja</h1>
                <p class="text-slate-500 mt-1 font-medium">PT Dunia Kimia Jaya</p>
            </div>
            
            <div class="text-right">
                <p class="text-sm text-slate-500 font-bold uppercase tracking-wide mb-1">No. Dokumen</p>
                <p class="text-xl font-bold text-slate-800" x-text="spkId"></p>
                <p class="text-xs text-slate-400 mt-1">Dicetak pada: <span x-text="printTimestamp"></span></p>
            </div>
        </div>
        
        <div class="p-8 space-y-8">
            
            <!-- Info Utama -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <table class="w-full text-sm">
                        <tr><td class="py-1 text-slate-500 w-2/5">Nama Customer</td><td class="py-1 font-bold text-navy" x-text="': ' + (spk?.customer || 'PT Royal Synthetic Compound')"></td></tr>
                        <tr><td class="py-1 text-slate-500">Produk Akhir</td><td class="py-1 font-bold text-navy" x-text="': ' + (spk?.product || '-')"></td></tr>
                        <tr><td class="py-1 text-slate-500">Jumlah Batch</td><td class="py-1 font-bold text-navy"><span x-text="': ' + (spk?.qty || '50') + ' Batch'"></span> <span class="text-xs text-emerald-600 font-bold ml-1">(<span x-text="spk?.completedBatch || '28'"></span> / <span x-text="spk?.qty || '50'"></span> Batch Selesai)</span></td></tr>
                        <tr><td class="py-1 text-slate-500">Tanggal Mulai</td><td class="py-1 font-bold text-navy" x-text="': ' + formatDate(spk?.startDate)"></td></tr>
                        <tr><td class="py-1 text-slate-500">Tanggal Selesai</td><td class="py-1 font-bold text-navy" x-text="': ' + formatDate(spk?.endDate)"></td></tr>
                    </table>
                </div>
                <div>
                    <table class="w-full text-sm">
                        <tr><td class="py-1 text-slate-500 w-2/5">Tanggal Kirim (Tentatif)</td><td class="py-1 font-bold text-navy" x-text="': ' + (spk?.shipDate || '06 Sep 2026')"></td></tr>
                        <tr><td class="py-1 text-slate-500">Target OP (Output/Jam)</td><td class="py-1 font-bold text-navy" x-text="': ' + (spk?.targetOp || '500 Kg / Jam')"></td></tr>
                        <tr><td class="py-1 text-slate-500">Hari Kerja (Working Days)</td><td class="py-1 font-bold text-navy" x-text="': ' + (spk?.workingDays || '2.5 Hari')"></td></tr>
                        <tr><td class="py-1 text-slate-500">Menit Kerja (Working Mins)</td><td class="py-1 font-bold text-navy" x-text="': ' + (spk?.workingMinutes || '1,200 Menit')"></td></tr>
                    </table>
                </div>
                <div>
                    <table class="w-full text-sm">
                        <tr><td class="py-1 text-slate-500 w-2/5">Mesin Alokasi</td><td class="py-1 font-bold text-navy" x-text="': ' + (spk?.machine || '-')"></td></tr>
                        <tr><td class="py-1 text-slate-500">Delay (Keterlambatan)</td><td class="py-1 font-bold text-emerald-600" x-text="': ' + (spk?.delayHour || '0.0 Jam')"></td></tr>
                        <tr><td class="py-1 text-slate-500">Status</td><td class="py-1 font-bold text-emerald-600" x-text="': ' + (spk?.status || '-')"></td></tr>
                        <tr><td class="py-1 text-slate-500">Keterangan</td><td class="py-1 font-semibold text-slate-700" x-text="': ' + (spk?.keterangan || 'Formula standar high-clarity PVC')"></td></tr>
                        <tr><td class="py-1 text-slate-500">Remarks</td><td class="py-1 font-semibold text-slate-700" x-text="': ' + (spk?.remarks || 'Prioritas pengiriman via kontainer 20ft')"></td></tr>
                    </table>
                </div>
            </div>
            
            <hr class="border-slate-100">

            <!-- Detail Formula & Kebutuhan Material -->
            <div>
                <div class="flex items-center justify-between mb-3 flex-wrap gap-2">
                    <h4 class="text-sm font-bold text-navy uppercase tracking-wide flex items-center gap-2">
                        <svg class="w-4 h-4 text-cyan" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                        Formula & Kebutuhan Material (BOM)
                    </h4>
                    <div class="bg-indigo-50 border border-indigo-200 text-indigo-800 px-3 py-1 rounded-full text-xs font-bold flex items-center gap-1.5 shadow-sm">
                        <svg class="w-3.5 h-3.5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                        Estimasi Kapasitas Maksimal: <span class="underline text-indigo-600 font-extrabold">60 Batch</span>
                    </div>
                </div>
                
                <div class="border border-slate-200 rounded-xl overflow-hidden shadow-sm bg-white">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-slate-50 border-b border-slate-200">
                            <tr class="text-[11px] uppercase text-slate-500 font-bold">
                                <th class="p-3">Nama Material</th>
                                <th class="p-3 text-right">Kebutuhan / Batch</th>
                                <th class="p-3 text-right text-navy">Target Kebutuhan</th>
                                <th class="p-3 text-right text-navy">Stok Fisik Tersedia</th>
                                <th class="p-3 text-center">Status Validasi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <tr>
                                <td class="p-3 font-medium text-slate-800">
                                    Resin PVC S-65
                                </td>
                                <td class="p-3 text-right text-slate-600">25 Kg</td>
                                <td class="p-3 text-right font-black text-navy text-[13px]">1,250 Kg</td>
                                <td class="p-3 text-right font-bold text-slate-700">1,500 Kg</td>
                                <td class="p-3 text-center">
                                    <span class="inline-flex items-center gap-1 bg-emerald-50 text-emerald-700 border border-emerald-200 px-2 py-0.5 rounded text-xs font-bold">
                                        ✓ Cukup (Valid)
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td class="p-3 font-medium text-slate-800">
                                    Stabilizer Ca-Zn
                                </td>
                                <td class="p-3 text-right text-slate-600">1 Kg</td>
                                <td class="p-3 text-right font-black text-navy text-[13px]">50 Kg</td>
                                <td class="p-3 text-right font-bold text-slate-700">100 Kg</td>
                                <td class="p-3 text-center">
                                    <span class="inline-flex items-center gap-1 bg-emerald-50 text-emerald-700 border border-emerald-200 px-2 py-0.5 rounded text-xs font-bold">
                                        ✓ Cukup (Valid)
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td class="p-3 font-medium text-slate-800">
                                    Pigment White
                                </td>
                                <td class="p-3 text-right text-slate-600">0.5 Kg</td>
                                <td class="p-3 text-right font-black text-navy text-[13px]">25 Kg</td>
                                <td class="p-3 text-right font-bold text-slate-700">10 Kg</td>
                                <td class="p-3 text-center">
                                    <span class="inline-flex items-center gap-1 bg-emerald-50 text-emerald-700 border border-emerald-200 px-2 py-0.5 rounded text-xs font-bold">
                                        ✓ Cukup (Valid)
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <hr class="border-slate-100">

            <!-- Live Report Final Summary / Parameter Actual -->
            <div>
                <h4 class="text-sm font-bold text-navy uppercase tracking-wide mb-3 flex items-center gap-2">
                    <svg class="w-4 h-4 text-cyan" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    Ringkasan Hasil Produksi & Parameter Aktual
                </h4>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Mesin Parameter Summary -->
                    <div class="border border-slate-200 rounded-xl overflow-hidden shadow-sm bg-white p-4">
                        <h5 class="text-xs font-bold text-slate-500 uppercase tracking-widest mb-3 border-b border-slate-100 pb-2">Rata-Rata Parameter Mesin</h5>
                        <table class="w-full text-sm">
                            <tbody class="divide-y divide-slate-50">
                                <tr>
                                    <td class="py-2 text-slate-600 font-medium">Suhu Extruder (Avg)</td>
                                    <td class="py-2 text-right font-bold text-navy">177 °C</td>
                                </tr>
                                <tr>
                                    <td class="py-2 text-slate-600 font-medium">Durasi Timbang (Avg/Batch)</td>
                                    <td class="py-2 text-right font-bold text-navy">12 Menit</td>
                                </tr>
                                <tr>
                                    <td class="py-2 text-slate-600 font-medium">Output Aktual</td>
                                    <td class="py-2 text-right font-bold text-cyan">495 Kg / Jam</td>
                                </tr>
                                <tr>
                                    <td class="py-2 text-slate-600 font-medium">Total Delay</td>
                                    <td class="py-2 text-right font-bold text-emerald-600">0.0 Jam (On Time)</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Final Yield & Warehouse Transfer -->
                    <div class="border border-slate-200 rounded-xl overflow-hidden shadow-sm bg-white p-4">
                        <h5 class="text-xs font-bold text-slate-500 uppercase tracking-widest mb-3 border-b border-slate-100 pb-2">Status Serah Terima Gudang</h5>
                        
                        <!-- Progress Bar Titip vs Serah Terima -->
                        <div class="space-y-4 mb-4">
                            <!-- Titip Barang -->
                            <div>
                                <div class="flex justify-between text-xs font-bold mb-1">
                                    <span class="text-amber-600">Titip Barang (Numpang)</span>
                                    <span class="text-slate-700" x-text="transferStats.titipQty.toLocaleString() + ' Kg (' + transferStats.titipPct + '%)'"></span>
                                </div>
                                <div class="w-full bg-slate-100 rounded-full h-2">
                                    <div class="bg-amber-400 h-2 rounded-full" :style="'width: ' + transferStats.titipPct + '%'"></div>
                                </div>
                            </div>
                            <!-- Serah Terima Final -->
                            <div>
                                <div class="flex justify-between text-xs font-bold mb-1">
                                    <span class="text-emerald-600">Serah Terima Final (Accepted)</span>
                                    <span class="text-slate-700" x-text="transferStats.finalQty.toLocaleString() + ' Kg (' + transferStats.finalPct + '%)'"></span>
                                </div>
                                <div class="w-full bg-slate-100 rounded-full h-2">
                                    <div class="bg-emerald-500 h-2 rounded-full" :style="'width: ' + transferStats.finalPct + '%'"></div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-emerald-50 text-emerald-800 text-[10px] p-2 rounded-lg font-bold border border-emerald-100 flex items-center justify-between gap-1">
                            <div class="flex items-center gap-1">
                                <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                SPK Selesai - Tidak Ada Selisih Material
                            </div>
                            <button @click="showTransferModal = true" class="px-2 py-1 bg-white border border-emerald-200 text-emerald-700 rounded shadow-sm hover:bg-emerald-100 transition">
                                + Transfer Gudang
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <hr class="border-slate-100">

            <!-- Manpower Allocation by Shift & Team -->
            <div>
                <h4 class="text-sm font-bold text-navy uppercase tracking-wide mb-3 flex items-center gap-2">
                    <svg class="w-4 h-4 text-cyan" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    Alokasi Operator (Berbasis Tim Rotasi Shift)
                </h4>
                <div class="border border-slate-200 rounded-xl overflow-hidden">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-slate-50 border-b border-slate-200">
                            <tr class="text-[11px] uppercase text-slate-500 font-bold">
                                <th class="p-3">Pos Kerja</th>
                                <th class="p-3">Shift 1 (Hari 1) · <span class="text-red-600">Team RED</span></th>
                                <th class="p-3">Shift 2 (Hari 1) · <span class="text-emerald-600">Team GREEN</span></th>
                                <th class="p-3">Shift 3 (Hari 1) · <span class="text-yellow-600">Team YELLOW</span></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-xs">
                            <tr>
                                <td class="p-3 font-bold text-slate-600 bg-slate-50">TP = Timbang Produk</td>
                                <td class="p-3"><span class="font-medium text-navy">Mia, Ayu</span><br><span class="text-[10px] text-red-500 font-bold">Team Red · 06:00-14:00</span></td>
                                <td class="p-3"><span class="font-medium text-navy">Fitri</span><br><span class="text-[10px] text-emerald-600 font-bold">Team Green · 14:00-22:00</span></td>
                                <td class="p-3"><span class="font-medium text-navy">Hana</span><br><span class="text-[10px] text-yellow-600 font-bold">Team Yellow · 22:00-06:00</span></td>
                            </tr>
                            <tr>
                                <td class="p-3 font-bold text-slate-600 bg-slate-50">MP = Mixing Powder</td>
                                <td class="p-3"><span class="font-medium text-navy">Budi, Anggun</span><br><span class="text-[10px] text-red-500 font-bold">Team Red · 06:00-14:00</span></td>
                                <td class="p-3"><span class="font-medium text-navy">Bagas, Rudi</span><br><span class="text-[10px] text-emerald-600 font-bold">Team Green · 14:00-22:00</span></td>
                                <td class="p-3"><span class="font-medium text-navy">Citra, Edi</span><br><span class="text-[10px] text-yellow-600 font-bold">Team Yellow · 22:00-06:00</span></td>
                            </tr>
                            <tr>
                                <td class="p-3 font-bold text-slate-600 bg-slate-50">MD = Mix DBM & ML = Mixing Liquid</td>
                                <td class="p-3"><span class="font-medium text-navy">Budi</span><br><span class="text-[10px] text-red-500 font-bold">Team Red · 06:00-14:00</span></td>
                                <td class="p-3"><span class="font-medium text-navy">Rudi</span><br><span class="text-[10px] text-emerald-600 font-bold">Team Green · 14:00-22:00</span></td>
                                <td class="p-3"><span class="font-medium text-navy">Edi</span><br><span class="text-[10px] text-yellow-600 font-bold">Team Yellow · 22:00-06:00</span></td>
                            </tr>
                            <tr>
                                <td class="p-3 font-bold text-slate-600 bg-slate-50">Extruder</td>
                                <td class="p-3"><span class="font-medium text-navy">Mira</span><br><span class="text-[10px] text-red-500 font-bold">Team Red · 06:00-14:00</span></td>
                                <td class="p-3"><span class="font-medium text-navy">Putu, Putri</span><br><span class="text-[10px] text-emerald-600 font-bold">Team Green · 14:00-22:00</span></td>
                                <td class="p-3"><span class="font-medium text-navy">Fikri, Irfan</span><br><span class="text-[10px] text-yellow-600 font-bold">Team Yellow · 22:00-06:00</span></td>
                            </tr>
                            <tr>
                                <td class="p-3 font-bold text-slate-600 bg-slate-50">Bagging</td>
                                <td class="p-3"><span class="font-medium text-navy">—</span></td>
                                <td class="p-3"><span class="font-medium text-navy">Putu</span><br><span class="text-[10px] text-emerald-600 font-bold">Team Green · 14:00-22:00</span></td>
                                <td class="p-3"><span class="font-medium text-navy">—</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Audit Trail & Digital Stamp -->
            <div class="border-t-2 border-dashed border-slate-200 pt-8 mt-8">
                <h4 class="text-sm font-bold text-navy uppercase tracking-wide mb-4">Otorisasi & Audit Trail (Pengesahan Sistem)</h4>
                
                <div class="grid grid-cols-5 gap-4">
                    <!-- Made By -->
                    <div class="col-span-1 border border-slate-200 rounded-lg p-3 text-center relative overflow-hidden">
                        <div class="absolute -right-4 -bottom-4 opacity-10">
                            <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm4.59-12.42L10 14.17l-2.59-2.58L6 13l4 4 8-8z"/></svg>
                        </div>
                        <p class="text-[10px] font-bold text-slate-500 uppercase">Dibuat Oleh (PPIC)</p>
                        <p class="font-bold text-navy text-sm mt-3">Jane Doe</p>
                        <p class="text-[10px] text-slate-400 mt-1">27 Aug, 08:00</p>
                    </div>

                    <!-- Approved By: Gudang -->
                    <div class="col-span-1 border border-slate-200 rounded-lg p-3 text-center relative overflow-hidden bg-emerald-50/50">
                        <div class="text-emerald-500 flex justify-center mb-1"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div>
                        <p class="text-[10px] font-bold text-emerald-800 uppercase">Gudang</p>
                        <p class="font-bold text-navy text-sm mt-1">Suryanto</p>
                        <p class="text-[10px] text-slate-500 mt-1">27 Aug, 09:15</p>
                    </div>

                    <!-- Approved By: RnD -->
                    <div class="col-span-1 border border-slate-200 rounded-lg p-3 text-center relative overflow-hidden bg-emerald-50/50">
                        <div class="text-emerald-500 flex justify-center mb-1"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div>
                        <p class="text-[10px] font-bold text-emerald-800 uppercase">R&D</p>
                        <p class="font-bold text-navy text-sm mt-1">Dr. Hendra</p>
                        <p class="text-[10px] text-slate-500 mt-1">27 Aug, 10:30</p>
                    </div>

                    <!-- Approved By: PE -->
                    <div class="col-span-1 border border-slate-200 rounded-lg p-3 text-center relative overflow-hidden bg-emerald-50/50">
                        <div class="text-emerald-500 flex justify-center mb-1"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div>
                        <p class="text-[10px] font-bold text-emerald-800 uppercase">Process Eng</p>
                        <p class="font-bold text-navy text-sm mt-1">Ir. Budi</p>
                        <p class="text-[10px] text-slate-500 mt-1">27 Aug, 11:45</p>
                    </div>

                    <!-- Approved By: QC -->
                    <div class="col-span-1 border border-slate-200 rounded-lg p-3 text-center relative overflow-hidden bg-emerald-50/50">
                        <div class="text-emerald-500 flex justify-center mb-1"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div>
                        <p class="text-[10px] font-bold text-emerald-800 uppercase">Quality C.</p>
                        <p class="font-bold text-navy text-sm mt-1">Siska Q.</p>
                        <p class="text-[10px] text-slate-500 mt-1">27 Aug, 13:00</p>
                    </div>
                </div>
                
                <p class="text-[10px] text-slate-400 mt-4 text-center">
                    * Dokumen ini digenerate secara otomatis oleh Sistem SPK. Tanda tangan fisik tidak diperlukan karena setiap approval telah divalidasi melalui sistem otentikasi user (Audit Trail Timestamp).
                </p>
            </div>
            
        </div>
    </div>

    <!-- Modal Preview PDF SPK -->
    <div x-show="showPdfModal" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm print:hidden" x-transition>
        <div class="bg-white rounded-2xl shadow-2xl border border-slate-200 w-full max-w-4xl max-h-[90vh] flex flex-col font-sans overflow-hidden" @click.away="showPdfModal = false">
            <div class="px-6 py-4 bg-navy text-white flex justify-between items-center shrink-0">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    <h3 class="text-base font-bold">Preview PDF: Surat Perintah Kerja (SPK)</h3>
                </div>
                <button @click="showPdfModal = false" class="text-white/80 hover:text-white">&times;</button>
            </div>
            
            <div class="p-6 bg-slate-100 overflow-y-auto flex-1 flex justify-center">
                <div class="w-full max-w-3xl bg-white shadow-lg shadow-slate-300/50 border border-slate-200 p-8 transform scale-90 sm:scale-100 origin-top">
                    <!-- SPK Header PDF Mockup -->
                    <div class="border-b-2 border-navy pb-4 mb-6 flex justify-between items-end">
                        <div>
                            <h2 class="text-2xl font-black text-navy uppercase">Surat Perintah Kerja</h2>
                            <p class="text-sm font-bold text-slate-500">PT Dunia Kimia Jaya</p>
                        </div>
                        <div class="text-right">
                            <p class="text-xs text-slate-400 font-bold">No. SPK: <span class="text-navy" x-text="spkId"></span></p>
                            <p class="text-xs text-slate-400">Tgl Cetak: <span x-text="printTimestamp"></span></p>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4 text-xs mb-6">
                        <div>
                            <p><span class="font-bold text-slate-500 inline-block w-24">Customer</span>: <span class="font-bold text-slate-800" x-text="spk?.customer"></span></p>
                            <p><span class="font-bold text-slate-500 inline-block w-24">Produk</span>: <span class="font-bold text-slate-800" x-text="spk?.product"></span></p>
                            <p><span class="font-bold text-slate-500 inline-block w-24">Qty (Batch)</span>: <span class="font-bold text-slate-800" x-text="spk?.qty"></span></p>
                        </div>
                        <div>
                            <p><span class="font-bold text-slate-500 inline-block w-24">Tgl Mulai</span>: <span class="font-bold text-slate-800" x-text="spk?.startDate"></span></p>
                            <p><span class="font-bold text-slate-500 inline-block w-24">Tgl Selesai</span>: <span class="font-bold text-slate-800" x-text="spk?.endDate"></span></p>
                            <p><span class="font-bold text-slate-500 inline-block w-24">Mesin</span>: <span class="font-bold text-slate-800" x-text="spk?.machine"></span></p>
                        </div>
                    </div>

                    <div class="mb-6">
                        <h4 class="text-sm font-bold text-navy border-b border-slate-200 pb-1 mb-2">BOM & Material Requirement</h4>
                        <table class="w-full text-xs text-left border border-slate-200">
                            <thead class="bg-slate-50 border-b border-slate-200">
                                <tr>
                                    <th class="p-2 border-r border-slate-200">Material</th>
                                    <th class="p-2 border-r border-slate-200 text-center">Req/Batch</th>
                                    <th class="p-2 text-center">Total Req</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-b border-slate-200"><td class="p-2 border-r border-slate-200">Resin PVC S-65</td><td class="p-2 border-r border-slate-200 text-center">25 Kg</td><td class="p-2 text-center font-bold">1,250 Kg</td></tr>
                                <tr class="border-b border-slate-200"><td class="p-2 border-r border-slate-200">Stabilizer Ca-Zn</td><td class="p-2 border-r border-slate-200 text-center">1 Kg</td><td class="p-2 text-center font-bold">50 Kg</td></tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="flex justify-between items-end mt-12 pt-6 border-t border-slate-200 text-center text-xs">
                        <div>
                            <p class="mb-8 font-bold text-slate-500">Dibuat Oleh,</p>
                            <p class="font-bold text-slate-800 underline">PPIC Dept</p>
                        </div>
                        <div>
                            <p class="mb-8 font-bold text-slate-500">Disetujui Oleh,</p>
                            <p class="font-bold text-slate-800 underline">Ka. Produksi</p>
                        </div>
                        <div>
                            <p class="mb-8 font-bold text-slate-500">Diketahui Oleh,</p>
                            <p class="font-bold text-slate-800 underline">Plant Manager</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="px-6 py-4 bg-white border-t border-slate-200 flex justify-end gap-3 shrink-0">
                <button @click="showPdfModal = false" class="px-4 py-2 bg-slate-100 text-slate-600 font-bold text-sm rounded-xl hover:bg-slate-200">Tutup Preview</button>
                <button onclick="window.print()" class="px-5 py-2 bg-navy hover:bg-navy-light text-white font-bold text-sm rounded-xl shadow flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    Download / Print PDF
                </button>
            </div>
        </div>
    </div>

    <!-- Modal Transfer Barang Gudang -->
    <div x-show="showTransferModal" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm print:hidden" x-transition>
        <div class="bg-white rounded-2xl shadow-2xl border border-slate-200 w-full max-w-xl flex flex-col font-sans overflow-hidden" @click.away="showTransferModal = false">
            <div class="px-6 py-4 bg-emerald-600 text-white flex justify-between items-center">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-emerald-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                    <h3 class="text-base font-bold">Proses Transfer Barang Jadi ke Gudang</h3>
                </div>
                <button @click="showTransferModal = false" class="text-white/80 hover:text-white">&times;</button>
            </div>
            
            <div class="p-6 overflow-y-auto max-h-[70vh]">
                <div class="space-y-4">
                    <div class="bg-blue-50 border border-blue-200 rounded-xl p-3 text-xs text-blue-800">
                        Pastikan memilih jenis transfer yang tepat. <br>
                        • <b>Titip Barang:</b> Hanya menumpang fisik di gudang, stok belum dipotong.<br>
                        • <b>Serah Terima Final:</b> Otomatis memotong stok produksi dan menambah stok gudang.
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Jenis Transfer <span class="text-rose-500">*</span></label>
                        <select x-model="transferForm.type" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-sm text-navy font-bold outline-none focus:ring-emerald-500 focus:border-emerald-500">
                            <option value="Titip Barang (Sementara)">Titip Barang (Sementara - Numpang)</option>
                            <option value="Serah Terima Final (Potong Stok)">Serah Terima Final (Kasih Barang & Potong Stok)</option>
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Quantity (Kg) <span class="text-rose-500">*</span></label>
                            <input type="number" x-model="transferForm.qty" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-sm text-navy font-bold outline-none focus:ring-emerald-500 focus:border-emerald-500" placeholder="Contoh: 1000">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Total Pallet</label>
                            <input type="number" x-model="transferForm.pallet" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-sm text-navy font-bold outline-none focus:ring-emerald-500 focus:border-emerald-500" placeholder="Contoh: 1">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Operator Produksi (Yg Menyerahkan) <span class="text-rose-500">*</span></label>
                            <input type="text" x-model="transferForm.opProduksi" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-sm text-navy font-bold outline-none focus:ring-emerald-500 focus:border-emerald-500" placeholder="Nama Operator">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Operator Gudang (Yg Menerima) <span class="text-rose-500">*</span></label>
                            <input type="text" x-model="transferForm.opGudang" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-sm text-navy font-bold outline-none focus:ring-emerald-500 focus:border-emerald-500" placeholder="Nama Operator">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Tanggal <span class="text-rose-500">*</span></label>
                            <input type="date" x-model="transferForm.tanggal" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-sm text-navy font-bold outline-none focus:ring-emerald-500 focus:border-emerald-500">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Jam <span class="text-rose-500">*</span></label>
                            <input type="time" x-model="transferForm.jam" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-sm text-navy font-bold outline-none focus:ring-emerald-500 focus:border-emerald-500">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Keterangan / Notes</label>
                        <input type="text" x-model="transferForm.notes" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-sm text-navy outline-none focus:ring-emerald-500 focus:border-emerald-500" placeholder="Contoh: Titip 1 pallet nunggu QC passed">
                    </div>

                    <div class="mt-6">
                        <h4 class="text-xs font-bold text-slate-500 uppercase mb-2">Riwayat Transfer</h4>
                        <div class="border border-slate-200 rounded-lg overflow-x-auto">
                            <table class="w-full text-left text-xs whitespace-nowrap">
                                <thead class="bg-slate-100 border-b border-slate-200">
                                    <tr>
                                        <th class="p-2">Waktu & Tanggal</th>
                                        <th class="p-2">Jenis Slip</th>
                                        <th class="p-2 text-right">Qty</th>
                                        <th class="p-2">Operator (Prod &rarr; Gudang)</th>
                                        <th class="p-2">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <template x-for="(log, idx) in transferLogs" :key="idx">
                                        <tr class="border-b border-slate-100 hover:bg-slate-50">
                                            <td class="p-2 text-slate-500">
                                                <span class="font-bold text-navy" x-text="log.tanggal"></span><br>
                                                <span class="text-[10px]" x-text="log.jam"></span>
                                            </td>
                                            <td class="p-2 font-bold whitespace-normal min-w-[150px]" :class="log.type.includes('Titip') ? 'text-amber-600' : 'text-emerald-600'" x-text="log.type"></td>
                                            <td class="p-2 text-right font-bold text-navy" x-text="Number(log.qty).toLocaleString() + ' Kg'"></td>
                                            <td class="p-2 text-slate-600">
                                                <span class="text-[10px] text-slate-400">Prod:</span> <span class="font-bold" x-text="log.opProduksi"></span><br>
                                                <span class="text-[10px] text-slate-400">Gdg:</span> <span class="font-bold" x-text="log.opGudang"></span>
                                            </td>
                                            <td class="p-2 text-emerald-600 font-bold">✓ Accepted</td>
                                        </tr>
                                    </template>
                                    <tr x-show="transferLogs.length === 0">
                                        <td colspan="5" class="p-4 text-center text-slate-400 font-medium">Belum ada riwayat transfer.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="px-6 py-4 bg-slate-50 border-t border-slate-200 flex justify-end gap-3">
                <button @click="showTransferModal = false" class="px-4 py-2 bg-white border border-slate-300 text-slate-600 font-bold text-sm rounded-xl hover:bg-slate-100">Batal</button>
                <button @click="submitTransfer()" class="px-5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm rounded-xl shadow flex items-center gap-1.5">
                    Proses Transfer
                </button>
            </div>
        </div>
    </div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('spkDetails', () => ({
            spkId: 'SPK-2608-001',
            spk: null,
            printTimestamp: new Date().toLocaleString('id-ID'),
            showPdfModal: false,
            showTransferModal: false,
            transferForm: {
                type: 'Titip Barang (Sementara)',
                qty: '',
                pallet: '',
                notes: '',
                opProduksi: '',
                opGudang: '',
                tanggal: new Date().toISOString().split('T')[0],
                jam: new Date().toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' })
            },
            transferLogs: [
                { tanggal: '2026-09-16', jam: '10:00 WIB', type: 'Titip Barang (Sementara)', qty: 1000, opProduksi: 'Mira', opGudang: 'Joko' },
                { tanggal: '2026-09-16', jam: '14:00 WIB', type: 'Serah Terima Final (Potong Stok)', qty: 2500, opProduksi: 'Putu', opGudang: 'Joko' },
            ],
            
            get transferStats() {
                // Asumsi Total Qty SPK = 15,000 Kg
                let totalReq = 15000;
                let titip = 0;
                let final = 0;
                this.transferLogs.forEach(log => {
                    if (log.type.includes('Titip')) {
                        titip += Number(log.qty);
                    } else {
                        final += Number(log.qty);
                    }
                });
                
                return {
                    titipQty: titip,
                    finalQty: final,
                    titipPct: ((titip / totalReq) * 100).toFixed(1),
                    finalPct: ((final / totalReq) * 100).toFixed(1)
                };
            },

            submitTransfer() {
                if(!this.transferForm.qty || !this.transferForm.opProduksi || !this.transferForm.opGudang) {
                    alert('Mohon lengkapi data wajib (Qty, Operator Produksi, Operator Gudang)!');
                    return;
                }
                
                this.transferLogs.unshift({
                    tanggal: this.transferForm.tanggal,
                    jam: this.transferForm.jam + ' WIB',
                    type: this.transferForm.type,
                    qty: this.transferForm.qty,
                    opProduksi: this.transferForm.opProduksi,
                    opGudang: this.transferForm.opGudang
                });
                
                let successMsg = this.transferForm.type.includes('Titip') 
                    ? `Berhasil TITIP BARANG sebanyak ${this.transferForm.qty} Kg. Status: Numpang Gudang.` 
                    : `Berhasil SERAH TERIMA FINAL sebanyak ${this.transferForm.qty} Kg. Stok berhasil dipotong! (Accepted)`;
                    
                alert(successMsg);
                this.showTransferModal = false;
                
                this.transferForm = {
                    type: 'Titip Barang (Sementara)',
                    qty: '',
                    pallet: '',
                    notes: '',
                    opProduksi: '',
                    opGudang: '',
                    tanggal: new Date().toISOString().split('T')[0],
                    jam: new Date().toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' })
                };
            },
            init() {
                const urlParams = new URLSearchParams(window.location.search);
                const id = urlParams.get('id') || 'SPK-2608-001';
                this.spkId = id;
                
                const dummyDb = {
                    'SPK-2608-001': {
                        id: 'SPK-2608-001',
                        customer: 'PT Royal Synthetic Compound',
                        product: 'PVC Compound A (Clear)',
                        qty: 50,
                        completedBatch: 28,
                        deliveryReq: '2026-09-05',
                        shipDate: '2026-09-06',
                        targetOp: '500 Kg / Jam',
                        workingDays: '2.5 Days',
                        workingMinutes: '1,200 Mins',
                        delayHour: '0.0 Hr',
                        keterangan: 'Formula standar high-clarity PVC',
                        remarks: 'Prioritas pengiriman via kontainer 20ft',
                        startDate: '2026-08-27',
                        endDate: '2026-08-29',
                        machine: 'Mixer A-01 · Ext Line 1 (E-01)',
                        status: 'Running',
                        subStatus: 'Dalam Penimbangan'
                    },
                    'SPK-2608-002': {
                        id: 'SPK-2608-002',
                        customer: 'PT Chemindo Utama',
                        product: 'PVC Compound B (Color)',
                        qty: 60,
                        completedBatch: 15,
                        deliveryReq: '2026-09-07',
                        shipDate: '2026-09-08',
                        targetOp: '450 Kg / Jam',
                        workingDays: '3.0 Days',
                        workingMinutes: '1,440 Mins',
                        delayHour: '0.0 Hr',
                        keterangan: 'Pesanan aditif pigmen khusus',
                        remarks: 'Uji lab QC sebelum pengiriman',
                        startDate: '2026-08-28',
                        endDate: '2026-08-31',
                        machine: 'Mixer B-02 · Ext Line 2 (E-02)',
                        status: 'Running',
                        subStatus: 'Mixing Powder'
                    },
                    'SPK-2608-003': {
                        id: 'SPK-2608-003',
                        customer: 'PT Indopack Industri',
                        product: 'Rigid PVC Granule Grade A',
                        qty: 30,
                        completedBatch: 30,
                        deliveryReq: '2026-09-02',
                        shipDate: '2026-09-03',
                        targetOp: '500 Kg / Jam',
                        workingDays: '1.5 Days',
                        workingMinutes: '720 Mins',
                        delayHour: '0.0 Hr',
                        keterangan: 'Batch selesai sesuai target OP',
                        remarks: 'Siap dikirim ke gudang ekspedisi',
                        startDate: '2026-08-25',
                        endDate: '2026-08-26',
                        machine: 'Mixer A-02 · Ext Line 3 (E-03)',
                        status: 'Finished',
                        subStatus: 'Transfer Gudang'
                    },
                    'DRF-SPK-2608-05': {
                        id: 'DRF-SPK-2608-05',
                        customer: 'PT Delta Polymer Indonesia',
                        product: 'PVC Compound C (Black)',
                        qty: 40,
                        completedBatch: 0,
                        deliveryReq: '2026-09-08',
                        shipDate: '2026-09-09',
                        targetOp: '400 Kg / Jam',
                        workingDays: '2.0 Days',
                        workingMinutes: '960 Mins',
                        delayHour: '0.0 Hr',
                        keterangan: 'Sample formulasi hitam mate',
                        remarks: 'Menunggu QC approval & rilis PPIC',
                        startDate: '2026-09-01',
                        endDate: '2026-09-03',
                        machine: 'Belum Alokasi Mesin',
                        status: 'Draft',
                        subStatus: 'Drafting'
                    }
                };

                const spks = window.getSPKs ? window.getSPKs() : [];
                const found = spks.find(s => s.id === id);
                if (found) {
                    this.spk = found;
                } else {
                    this.spk = dummyDb[id] || dummyDb['SPK-2608-001'];
                }
            },
            formatDate(d) {
                if (!d) return '-';
                return d;
            }
        }));
    });
</script>
@endsection
