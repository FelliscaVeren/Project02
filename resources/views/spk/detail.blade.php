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
                <p class="text-slate-500 mt-1 font-medium">PT. Manufacturing Cemerlang</p>
            </div>
            
            <div class="text-right">
                <p class="text-sm text-slate-500 font-bold uppercase tracking-wide mb-1">No. Dokumen</p>
                <p class="text-xl font-bold text-slate-800" x-text="spkId"></p>
                <p class="text-xs text-slate-400 mt-1">Dicetak pada: <span x-text="printTimestamp"></span></p>
            </div>
        </div>
        
        <div class="p-8 space-y-8">
            
            <!-- Info Utama -->
            <div class="grid grid-cols-2 gap-8">
                <div>
                    <table class="w-full text-sm">
                        <tr><td class="py-1 text-slate-500 w-1/3">Produk Akhir</td><td class="py-1 font-bold text-navy" x-text="': ' + (spk?.product || '-')"></td></tr>
                        <tr><td class="py-1 text-slate-500">Jumlah Batch</td><td class="py-1 font-bold text-navy" x-text="': ' + (spk?.qty || '-') + ' Batch'"></td></tr>
                        <tr><td class="py-1 text-slate-500">Tanggal Mulai</td><td class="py-1 font-bold text-navy" x-text="': ' + formatDate(spk?.startDate)"></td></tr>
                        <tr><td class="py-1 text-slate-500">Tanggal Selesai</td><td class="py-1 font-bold text-navy" x-text="': ' + formatDate(spk?.endDate)"></td></tr>
                    </table>
                </div>
                <div>
                    <table class="w-full text-sm">
                        <tr><td class="py-1 text-slate-500 w-1/3">Mesin Alokasi</td><td class="py-1 font-bold text-navy" x-text="': ' + (spk?.machine || '-')"></td></tr>
                        <tr><td class="py-1 text-slate-500">Target Waktu</td><td class="py-1 font-bold text-navy">: 24 Jam / Hari</td></tr>
                        <tr><td class="py-1 text-slate-500">Status</td><td class="py-1 font-bold text-emerald-600" x-text="': ' + (spk?.status || '-')"></td></tr>
                        <tr><td class="py-1 text-slate-500">Lokasi / Tahap</td><td class="py-1 font-bold text-cyan" x-text="': ' + (spk?.subStatus || '-')"></td></tr>
                    </table>
                </div>
            </div>
            
            <hr class="border-slate-100">

            <!-- Alur Visual Penanganan Material -->
            <div>
                <h4 class="text-sm font-bold text-navy uppercase tracking-wide mb-4 flex items-center gap-2">
                    <svg class="w-4 h-4 text-cyan" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path></svg>
                    Alur Proses Penanganan Material
                </h4>
                
                <div class="grid grid-cols-5 gap-2 text-center text-[10px]">
                    <div class="p-2 border rounded-xl" :class="['Dalam Penimbangan', 'Proses Mixing', 'Dalam Proses Extruder', 'Dalam Bagging', 'Completed'].includes(spk?.subStatus) ? 'bg-emerald-50 border-emerald-200 text-emerald-800 font-bold' : 'bg-slate-50 border-slate-200 text-slate-400'">
                        <p class="font-bold">1. Warehouse Release</p>
                        <p class="text-[9px] mt-0.5">Bahan Baku Dikeluarkan</p>
                    </div>
                    <div class="p-2 border rounded-xl" :class="['Proses Mixing', 'Dalam Proses Extruder', 'Dalam Bagging', 'Completed'].includes(spk?.subStatus) ? 'bg-emerald-50 border-emerald-200 text-emerald-800 font-bold' : (spk?.subStatus === 'Dalam Penimbangan' ? 'bg-cyan/10 border-cyan text-cyan font-bold animate-pulse' : 'bg-slate-50 border-slate-200 text-slate-400')">
                        <p class="font-bold">2. Penimbangan (Weighing)</p>
                        <p class="text-[9px] mt-0.5">Verifikasi Qty & Timbangan</p>
                    </div>
                    <div class="p-2 border rounded-xl" :class="['Dalam Proses Extruder', 'Dalam Bagging', 'Completed'].includes(spk?.subStatus) ? 'bg-emerald-50 border-emerald-200 text-emerald-800 font-bold' : (spk?.subStatus === 'Proses Mixing' ? 'bg-cyan/10 border-cyan text-cyan font-bold animate-pulse' : 'bg-slate-50 border-slate-200 text-slate-400')">
                        <p class="font-bold">3. Pencampuran (Mixing)</p>
                        <p class="text-[9px] mt-0.5">Input Material ke Mixer</p>
                    </div>
                    <div class="p-2 border rounded-xl" :class="['Dalam Bagging', 'Completed'].includes(spk?.subStatus) ? 'bg-emerald-50 border-emerald-200 text-emerald-800 font-bold' : (spk?.subStatus === 'Dalam Proses Extruder' ? 'bg-cyan/10 border-cyan text-cyan font-bold animate-pulse' : 'bg-slate-50 border-slate-200 text-slate-400')">
                        <p class="font-bold">4. Extrusion Process</p>
                        <p class="text-[9px] mt-0.5">Peleburan & Granulasi</p>
                    </div>
                    <div class="p-2 border rounded-xl" :class="spk?.subStatus === 'Completed' ? 'bg-emerald-50 border-emerald-200 text-emerald-800 font-bold' : (spk?.subStatus === 'Dalam Bagging' ? 'bg-cyan/10 border-cyan text-cyan font-bold animate-pulse' : 'bg-slate-50 border-slate-200 text-slate-400')">
                        <p class="font-bold">5. Bagging & QC Goods</p>
                        <p class="text-[9px] mt-0.5">Pengepakan Sak & Label</p>
                    </div>
                </div>
            </div>
            
            <hr class="border-slate-100">

            <!-- Detail Tabel Rincian Material -->
            <div>
                <div class="flex justify-between items-center mb-3">
                    <h4 class="text-sm font-bold text-navy uppercase tracking-wide flex items-center gap-2">
                        <svg class="w-4 h-4 text-cyan" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                        Tabel Rincian & Kesesuaian Material (BOM vs Aktual)
                    </h4>
                    <span class="px-2 py-1 rounded bg-emerald-50 text-emerald-700 border border-emerald-100 text-xs font-bold flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        QC Status: Valid & Sesuai R&D
                    </span>
                </div>
                <div class="border border-slate-200 rounded-xl overflow-hidden shadow-sm bg-white">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-slate-50 border-b border-slate-200">
                            <tr class="text-xs uppercase text-slate-500 font-bold">
                                <th class="p-3 pl-4">Nama Material</th>
                                <th class="p-3 text-right">Kebutuhan / Batch</th>
                                <th class="p-3 text-right">Total Kebutuhan SPK</th>
                                <th class="p-3 text-right">Ambil Dari Gudang</th>
                                <th class="p-3 text-right">Ditambahkan Ke Mixer</th>
                                <th class="p-3 text-center pr-4">Kesesuaian</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-700">
                            <template x-for="m in spk?.materials" :key="m.name">
                                <tr>
                                    <td class="p-3 pl-4 font-semibold text-navy" x-text="m.name"></td>
                                    <td class="p-3 text-right font-medium" x-text="m.bom + ' Kg'"></td>
                                    <td class="p-3 text-right font-semibold text-slate-600" x-text="(m.bom * spk.qty).toLocaleString('id-ID') + ' Kg'"></td>
                                    <td class="p-3 text-right font-bold text-indigo-600" x-text="(m.picked || (m.bom * spk.qty)).toLocaleString('id-ID') + ' Kg'"></td>
                                    <td class="p-3 text-right font-bold text-cyan" x-text="(m.added || (m.bom * spk.qty)).toLocaleString('id-ID') + ' Kg'"></td>
                                    <td class="p-3 text-center pr-4">
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold" 
                                              :class="spk.status === 'Running' ? 'bg-emerald-50 text-emerald-700 border border-emerald-100' : 'bg-amber-50 text-amber-700 border border-amber-100'"
                                              x-text="spk.status === 'Running' ? '100% Sesuai' : 'Siap Sesuai'"></span>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <hr class="border-slate-100">

            <!-- Manpower Allocation -->
            <div>
                <h4 class="text-sm font-bold text-navy uppercase tracking-wide mb-3 flex items-center gap-2">
                    <svg class="w-4 h-4 text-cyan" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    Alokasi Operator (Shift 1)
                </h4>
                <div class="grid grid-cols-4 gap-4 text-sm text-center">
                    <div class="border border-slate-200 p-2 rounded-lg bg-slate-50">
                        <p class="text-[10px] uppercase font-bold text-slate-400 mb-1">Penimbangan</p>
                        <p class="font-bold text-navy">Op. Andi</p>
                    </div>
                    <div class="border border-slate-200 p-2 rounded-lg bg-slate-50">
                        <p class="text-[10px] uppercase font-bold text-slate-400 mb-1">Mixing</p>
                        <p class="font-bold text-navy">Op. Dedi</p>
                    </div>
                    <div class="border border-slate-200 p-2 rounded-lg bg-slate-50">
                        <p class="text-[10px] uppercase font-bold text-slate-400 mb-1">Extruder</p>
                        <p class="font-bold text-navy">Op. Fajar, Hadi</p>
                    </div>
                    <div class="border border-slate-200 p-2 rounded-lg bg-slate-50">
                        <p class="text-[10px] uppercase font-bold text-slate-400 mb-1">Bagging</p>
                        <p class="font-bold text-navy">Op. Indah</p>
                    </div>
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
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('spkDetails', () => ({
            spkId: 'SPK-2608-001',
            spk: null,
            printTimestamp: '',

            init() {
                const urlParams = new URLSearchParams(window.location.search);
                const queryId = urlParams.get('id');
                if (queryId) {
                    this.spkId = queryId;
                }
                
                const allSpks = window.getSPKs() || [];
                this.spk = allSpks.find(s => s.id === this.spkId);
                
                // If not found, use default seeded PVC compound A details
                if (!this.spk && this.spkId === 'SPK-2608-001') {
                    this.spk = allSpks[0];
                }
                
                const now = new Date();
                this.printTimestamp = now.toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' }) + ' ' + 
                                      String(now.getHours()).padStart(2, '0') + ':' + 
                                      String(now.getMinutes()).padStart(2, '0') + ':' + 
                                      String(now.getSeconds()).padStart(2, '0');
            },

            formatDate(dStr) {
                if (!dStr) return '-';
                const options = { day: 'numeric', month: 'long', year: 'numeric' };
                return new Date(dStr).toLocaleDateString('id-ID', options);
            }
        }));
    });
</script>
@endsection
