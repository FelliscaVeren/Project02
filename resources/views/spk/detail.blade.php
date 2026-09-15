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
            <button class="px-5 py-2.5 bg-navy hover:bg-navy-light text-white text-sm font-bold rounded-xl shadow-md transition-colors flex items-center gap-2" onclick="window.print()">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                Print SPK / Export PDF
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
                        <tr><td class="py-1 text-slate-500">Target OP (Output/Hour)</td><td class="py-1 font-bold text-navy" x-text="': ' + (spk?.targetOp || '500 Kg / Jam')"></td></tr>
                        <tr><td class="py-1 text-slate-500">Working Days</td><td class="py-1 font-bold text-navy" x-text="': ' + (spk?.workingDays || '2.5 Days')"></td></tr>
                        <tr><td class="py-1 text-slate-500">Working Minutes</td><td class="py-1 font-bold text-navy" x-text="': ' + (spk?.workingMinutes || '1,200 Mins')"></td></tr>
                    </table>
                </div>
                <div>
                    <table class="w-full text-sm">
                        <tr><td class="py-1 text-slate-500 w-2/5">Mesin Alokasi</td><td class="py-1 font-bold text-navy" x-text="': ' + (spk?.machine || '-')"></td></tr>
                        <tr><td class="py-1 text-slate-500">Delay (Hour)</td><td class="py-1 font-bold text-emerald-600" x-text="': ' + (spk?.delayHour || '0.0 Hr')"></td></tr>
                        <tr><td class="py-1 text-slate-500">Status</td><td class="py-1 font-bold text-emerald-600" x-text="': ' + (spk?.status || '-')"></td></tr>
                        <tr><td class="py-1 text-slate-500">Keterangan</td><td class="py-1 font-semibold text-slate-700" x-text="': ' + (spk?.keterangan || 'Formula standar high-clarity PVC')"></td></tr>
                        <tr><td class="py-1 text-slate-500">Remarks</td><td class="py-1 font-semibold text-slate-700" x-text="': ' + (spk?.remarks || 'Prioritas pengiriman via kontainer 20ft')"></td></tr>
                    </table>
                </div>
            </div>
            
            <hr class="border-slate-100">

            <!-- Detail Formula & Kebutuhan Material -->
            <div>
                <h4 class="text-sm font-bold text-navy uppercase tracking-wide mb-3 flex items-center gap-2">
                    <svg class="w-4 h-4 text-cyan" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                    Formula & Kebutuhan Material (BOM)
                </h4>
                
                <div class="border border-slate-200 rounded-xl overflow-hidden shadow-sm bg-white">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-slate-50 border-b border-slate-200">
                            <tr class="text-[11px] uppercase text-slate-500 font-bold">
                                <th class="p-3">Nama Material</th>
                                <th class="p-3 text-center">Jumlah Batch</th>
                                <th class="p-3 text-right">Berat / Batch</th>
                                <th class="p-3 text-right text-navy">Total Qty (Target)</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <tr>
                                <td class="p-3 font-medium text-slate-800">
                                    Resin PVC S-65
                                </td>
                                <td class="p-3 text-center text-slate-500 font-bold" x-text="spk?.qty || '50'">50</td>
                                <td class="p-3 text-right text-slate-600">25 Kg</td>
                                <td class="p-3 text-right font-black text-navy text-[13px]">1,250 Kg</td>
                            </tr>
                            <tr>
                                <td class="p-3 font-medium text-slate-800">
                                    Stabilizer Ca-Zn
                                </td>
                                <td class="p-3 text-center text-slate-500 font-bold" x-text="spk?.qty || '50'">50</td>
                                <td class="p-3 text-right text-slate-600">1 Kg</td>
                                <td class="p-3 text-right font-black text-navy text-[13px]">50 Kg</td>
                            </tr>
                            <tr>
                                <td class="p-3 font-medium text-slate-800">
                                    Pigment White
                                </td>
                                <td class="p-3 text-center text-slate-500 font-bold" x-text="spk?.qty || '50'">50</td>
                                <td class="p-3 text-right text-slate-600">0.5 Kg</td>
                                <td class="p-3 text-right font-black text-navy text-[13px]">25 Kg</td>
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
                        <div class="flex items-center gap-4 mb-4">
                            <div class="relative w-16 h-16 flex-shrink-0">
                                <svg class="w-full h-full transform -rotate-90" viewBox="0 0 36 36">
                                    <path class="text-slate-100" stroke-width="3" stroke="currentColor" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                                    <path class="text-emerald-500" stroke-dasharray="100, 100" stroke-width="3" stroke-linecap="round" stroke="currentColor" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                                </svg>
                                <div class="absolute inset-0 flex items-center justify-center text-[10px] font-bold text-navy">100%</div>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-slate-700">15,000 Kg / 15,000 Kg</p>
                                <p class="text-[11px] text-slate-500 mt-0.5">Telah diserahterimakan ke Gudang Barang Jadi.</p>
                            </div>
                        </div>
                        <div class="bg-emerald-50 text-emerald-800 text-[10px] p-2 rounded-lg font-bold border border-emerald-100 flex items-center gap-1">
                            <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            SPK Selesai - Tidak Ada Selisih Material
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

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('spkDetails', () => ({
            spkId: 'SPK-2608-001',
            spk: null,
            printTimestamp: new Date().toLocaleString('id-ID'),
            init() {
                const urlParams = new URLSearchParams(window.location.search);
                const id = urlParams.get('id') || 'SPK-2608-001';
                this.spkId = id;
                const spks = window.getSPKs ? window.getSPKs() : [];
                const found = spks.find(s => s.id === id);
                if (found) {
                    this.spk = found;
                } else {
                    this.spk = {
                        id: id,
                        customer: 'PT Royal Synthetic Compound',
                        product: 'PVC Compound A (Clear)',
                        qty: 50,
                        completedBatch: 28,
                        deliveryReq: '2026-09-05',
                        shipDate: '2026-09-06',
                        targetOp: '500 Kg / Shift',
                        workingDays: '2.5 Days',
                        workingMinutes: '1,200 Mins',
                        delayHour: '0.0 Hr',
                        keterangan: 'Formula standar high-clarity PVC',
                        remarks: 'Prioritas pengiriman via kontainer 20ft',
                        startDate: '2026-08-27',
                        endDate: '2026-08-29',
                        machine: 'Mixer A-01, Ext-1',
                        status: 'Running',
                        subStatus: 'Dalam Penimbangan'
                    };
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
