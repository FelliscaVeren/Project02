<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dokumen Material - PT Dunia Kimia Jaya</title>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style type="text/tailwindcss">
        @theme {
            --font-sans: 'Plus Jakarta Sans', sans-serif;
            --color-navy: #112338;
            --color-navy-light: #1c3553;
            --color-cyan: #0ea5e9;
        }
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        @media print {
            .no-print { display: none !important; }
            .page-break { page-break-after: always; }
            body { background: white !important; }
            .print-shadow { box-shadow: none !important; }
        }
    </style>
</head>
<body class="bg-[#f4f7fb] min-h-screen" x-data="docsApp()">

<!-- Toolbar -->
<div class="no-print bg-navy text-white px-6 py-3 flex items-center gap-4 shadow-lg">
    <a href="/ppic/calendar" class="flex items-center gap-2 text-slate-300 hover:text-white text-sm transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Kembali
    </a>
    <div class="h-4 w-px bg-slate-600"></div>
    <h1 class="text-sm font-bold flex-1">Dokumen Alur Material — <span class="text-cyan" x-text="activeDoc === 'moving' ? 'Moving Slip' : (activeDoc === 'transfer' ? 'Transfer Slip' : 'Form Serah Terima')"></span></h1>
    <div class="flex gap-2">
        <button @click="activeDoc = 'moving'" :class="activeDoc === 'moving' ? 'bg-cyan text-white' : 'bg-navy-light text-slate-300 hover:text-white'" class="px-3 py-1.5 rounded-lg text-xs font-bold transition-colors">Moving Slip</button>
        <button @click="activeDoc = 'transfer'" :class="activeDoc === 'transfer' ? 'bg-cyan text-white' : 'bg-navy-light text-slate-300 hover:text-white'" class="px-3 py-1.5 rounded-lg text-xs font-bold transition-colors">Transfer Slip</button>
        <button @click="activeDoc = 'serah_terima'" :class="activeDoc === 'serah_terima' ? 'bg-cyan text-white' : 'bg-navy-light text-slate-300 hover:text-white'" class="px-3 py-1.5 rounded-lg text-xs font-bold transition-colors">Serah Terima</button>
    </div>
    <div class="h-4 w-px bg-slate-600"></div>
    <button onclick="window.print()" class="flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-1.5 rounded-lg text-xs font-bold transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
        Print Dokumen
    </button>
</div>

<div class="max-w-4xl mx-auto py-8 px-4">

    <!-- ========== MOVING SLIP ========== -->
    <div x-show="activeDoc === 'moving'" x-transition x-data="movingSlipApp()">
        <div class="bg-white rounded-2xl shadow-lg print-shadow border border-slate-200 overflow-hidden">
            <!-- Header -->
            <div class="border-b-4 border-navy p-6 bg-slate-50/50">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">PT Dunia Kimia Jaya</p>
                        <h1 class="text-2xl font-black text-navy uppercase tracking-tight">Moving Slip</h1>
                        <p class="text-sm text-slate-500 mt-0.5">Formulir Penambahan Material ke Produksi</p>
                    </div>
                    <div class="text-right">
                        <div class="inline-block bg-amber-100 border border-amber-300 rounded-xl px-4 py-2 text-right">
                            <p class="text-[10px] font-bold text-amber-600 uppercase tracking-wide">No. Dokumen</p>
                            <p class="text-lg font-black text-navy">MS-2608-001</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-6 space-y-6">
                <!-- Info Referensi -->
                <div class="grid grid-cols-2 gap-6">
                    <div class="space-y-3">
                        <div class="flex gap-3 items-start border-b border-slate-100 pb-2">
                            <span class="text-xs font-bold text-slate-400 w-32 flex-shrink-0 pt-0.5">No. SPK</span>
                            <span class="text-sm font-bold text-navy flex-1">SPK-2608-001</span>
                        </div>
                        <div class="flex gap-3 items-start border-b border-slate-100 pb-2">
                            <span class="text-xs font-bold text-slate-400 w-32 flex-shrink-0 pt-0.5">Produk</span>
                            <span class="text-sm font-bold text-navy flex-1">PVC Compound A (Clear)</span>
                        </div>
                        <div class="flex gap-3 items-start border-b border-slate-100 pb-2">
                            <span class="text-xs font-bold text-slate-400 w-32 flex-shrink-0 pt-0.5">Tanggal</span>
                            <span class="text-sm font-bold text-navy flex-1">27 Agustus 2026</span>
                        </div>
                    </div>
                    <div class="space-y-3">
                        <div class="flex gap-3 items-start border-b border-slate-100 pb-2">
                            <span class="text-xs font-bold text-slate-400 w-32 flex-shrink-0 pt-0.5">Dari (Gudang)</span>
                            <span class="text-sm font-bold text-navy flex-1">Gudang Bahan Baku — Rak B2</span>
                        </div>
                        <div class="flex gap-3 items-start border-b border-slate-100 pb-2">
                            <span class="text-xs font-bold text-slate-400 w-32 flex-shrink-0 pt-0.5">Ke (Produksi)</span>
                            <span class="text-sm font-bold text-navy flex-1">Lantai Produksi — Mixer A-01</span>
                        </div>
                        <div class="flex gap-3 items-start border-b border-slate-100 pb-2">
                            <span class="text-xs font-bold text-slate-400 w-32 flex-shrink-0 pt-0.5">Alasan</span>
                            <span class="text-sm text-navy flex-1">Kekurangan material saat proses mixing berlangsung</span>
                        </div>
                    </div>
                </div>

                <!-- Tabel Material -->
                <div>
                    <div class="flex justify-between items-center mb-3 no-print">
                        <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wide">Detail Material yang Diminta</h3>
                        <button @click="addRow()" class="flex items-center gap-1 text-[10px] font-bold text-amber-700 bg-amber-50 border border-amber-200 px-2 py-1 rounded-lg hover:bg-amber-100 transition-colors">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Tambah Baris
                        </button>
                    </div>
                    <div class="border border-slate-200 rounded-xl overflow-hidden">
                        <table class="w-full text-left text-sm">
                            <thead class="bg-slate-50 border-b border-slate-200">
                                <tr class="text-xs uppercase text-slate-500 font-bold">
                                    <th class="px-3 py-3">No.</th>
                                    <th class="px-3 py-3">Nama Material</th>
                                    <th class="px-3 py-3">Kode Item</th>
                                    <th class="px-3 py-3 text-right">Jml Diminta (Kg)</th>
                                    <th class="px-3 py-3">Keterangan</th>
                                    <th class="px-3 py-3 no-print"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                <template x-for="(row, i) in rows" :key="i">
                                    <tr class="hover:bg-slate-50">
                                        <td class="px-3 py-2.5 text-slate-400 text-sm" x-text="i + 1"></td>
                                        <td class="px-3 py-2.5">
                                            <input x-model="row.nama" type="text" placeholder="Nama material..." class="w-full bg-transparent border-b border-dashed border-slate-300 focus:border-amber-400 outline-none text-sm font-semibold text-navy py-0.5">
                                        </td>
                                        <td class="px-3 py-2.5">
                                            <input x-model="row.kode" type="text" placeholder="Kode..." class="w-24 bg-transparent border-b border-dashed border-slate-300 focus:border-amber-400 outline-none text-xs font-mono text-slate-600 py-0.5">
                                        </td>
                                        <td class="px-3 py-2.5 text-right">
                                            <input x-model="row.qty" type="number" step="0.1" min="0" placeholder="0.0" class="w-20 bg-transparent border-b border-dashed border-slate-300 focus:border-amber-400 outline-none text-sm font-bold text-navy text-right py-0.5">
                                        </td>
                                        <td class="px-3 py-2.5">
                                            <input x-model="row.ket" type="text" placeholder="Keterangan..." class="w-full bg-transparent border-b border-dashed border-slate-300 focus:border-amber-400 outline-none text-xs text-slate-500 py-0.5">
                                        </td>
                                        <td class="px-3 py-2.5 no-print">
                                            <button @click="rows.splice(i,1)" class="text-red-400 hover:text-red-600">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                            </button>
                                        </td>
                                    </tr>
                                </template>
                                <tr class="bg-slate-50/60">
                                    <td colspan="3" class="px-3 py-3 text-right text-xs font-bold text-slate-500 uppercase">Total</td>
                                    <td class="px-3 py-3 text-right font-black text-navy" x-text="totalQty.toFixed(1) + ' Kg'"></td>
                                    <td colspan="2"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Tanda Tangan -->
                <div class="grid grid-cols-3 gap-6 pt-4">
                    <div class="text-center">
                        <div class="h-16 border-b border-slate-300 mb-2"></div>
                        <p class="text-xs font-bold text-slate-600">Diajukan oleh</p>
                        <p class="text-[10px] text-slate-400">Operator / Produksi</p>
                    </div>
                    <div class="text-center">
                        <div class="h-16 border-b border-slate-300 mb-2"></div>
                        <p class="text-xs font-bold text-slate-600">Disetujui oleh</p>
                        <p class="text-[10px] text-slate-400">Process Engineering (PE)</p>
                    </div>
                    <div class="text-center">
                        <div class="h-16 border-b border-slate-300 mb-2"></div>
                        <p class="text-xs font-bold text-slate-600">Diserahkan oleh</p>
                        <p class="text-[10px] text-slate-400">Petugas Gudang</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ========== TRANSFER SLIP ========== -->
    <div x-show="activeDoc === 'transfer'" x-transition style="display:none;" x-data="transferSlipApp()">
        <div class="bg-white rounded-2xl shadow-lg print-shadow border border-slate-200 overflow-hidden">
            <!-- Header -->
            <div class="border-b-4 border-cyan p-6 bg-slate-50/50">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">PT Dunia Kimia Jaya</p>
                        <h1 class="text-2xl font-black text-navy uppercase tracking-tight">Transfer Slip</h1>
                        <p class="text-sm text-slate-500 mt-0.5">Bukti Perpindahan Material dari Gudang ke Produksi</p>
                    </div>
                    <div class="text-right">
                        <div class="inline-block bg-cyan/10 border border-cyan/30 rounded-xl px-4 py-2 text-right">
                            <p class="text-[10px] font-bold text-cyan uppercase tracking-wide">No. Dokumen</p>
                            <p class="text-lg font-black text-navy">TS-2608-001</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-6 space-y-6">
                <!-- Info Transfer -->
                <div class="grid grid-cols-2 gap-6">
                    <div class="space-y-3">
                        <div class="flex gap-3 items-start border-b border-slate-100 pb-2">
                            <span class="text-xs font-bold text-slate-400 w-32 flex-shrink-0 pt-0.5">No. SPK</span>
                            <span class="text-sm font-bold text-navy flex-1">SPK-2608-001</span>
                        </div>
                        <div class="flex gap-3 items-start border-b border-slate-100 pb-2">
                            <span class="text-xs font-bold text-slate-400 w-32 flex-shrink-0 pt-0.5">Tanggal Transfer</span>
                            <span class="text-sm font-bold text-navy flex-1">27 Agustus 2026, 05:30</span>
                        </div>
                        <div class="flex gap-3 items-start border-b border-slate-100 pb-2">
                            <span class="text-xs font-bold text-slate-400 w-32 flex-shrink-0 pt-0.5">Jenis Permintaan</span>
                            <span class="text-sm font-bold text-cyan flex-1">Reguler (Sesuai BOM SPK)</span>
                        </div>
                    </div>
                    <div class="space-y-3">
                        <div class="flex gap-3 items-start border-b border-slate-100 pb-2">
                            <span class="text-xs font-bold text-slate-400 w-32 flex-shrink-0 pt-0.5">Asal Gudang</span>
                            <span class="text-sm font-bold text-navy flex-1">Gudang Bahan Baku Utama (GBB-01)</span>
                        </div>
                        <div class="flex gap-3 items-start border-b border-slate-100 pb-2">
                            <span class="text-xs font-bold text-slate-400 w-32 flex-shrink-0 pt-0.5">Tujuan Produksi</span>
                            <span class="text-sm font-bold text-navy flex-1">Area Produksi — Mixer A-01</span>
                        </div>
                        <div class="flex gap-3 items-start border-b border-slate-100 pb-2">
                            <span class="text-xs font-bold text-slate-400 w-32 flex-shrink-0 pt-0.5">No. PO / Ref</span>
                            <span class="text-sm font-bold text-navy flex-1">PO-2608-0071</span>
                        </div>
                    </div>
                </div>

                <!-- Tabel Material -->
                <div>
                    <div class="flex justify-between items-center mb-3 no-print">
                        <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wide">Rincian Material yang Ditransfer</h3>
                        <button @click="addRow()" class="flex items-center gap-1 text-[10px] font-bold text-cyan bg-cyan/10 border border-cyan/30 px-2 py-1 rounded-lg hover:bg-cyan/20 transition-colors">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Tambah Baris
                        </button>
                    </div>
                    <div class="border border-slate-200 rounded-xl overflow-hidden">
                        <table class="w-full text-left text-sm">
                            <thead class="bg-slate-50 border-b border-slate-200">
                                <tr class="text-xs uppercase text-slate-500 font-bold">
                                    <th class="px-3 py-3">No.</th>
                                    <th class="px-3 py-3">Nama Material</th>
                                    <th class="px-3 py-3">Kode Item</th>
                                    <th class="px-3 py-3">Satuan</th>
                                    <th class="px-3 py-3 text-right">Jml Sesuai BOM</th>
                                    <th class="px-3 py-3 text-right">Jml Aktual Transfer</th>
                                    <th class="px-3 py-3">Selisih</th>
                                    <th class="px-3 py-3 no-print"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                <template x-for="(row, i) in rows" :key="i">
                                    <tr class="hover:bg-slate-50">
                                        <td class="px-3 py-2.5 text-slate-400 text-sm" x-text="i + 1"></td>
                                        <td class="px-3 py-2.5">
                                            <input x-model="row.nama" type="text" placeholder="Nama material..." class="w-full bg-transparent border-b border-dashed border-slate-300 focus:border-cyan outline-none text-sm font-semibold text-navy py-0.5">
                                        </td>
                                        <td class="px-3 py-2.5">
                                            <input x-model="row.kode" type="text" placeholder="Kode..." class="w-20 bg-transparent border-b border-dashed border-slate-300 focus:border-cyan outline-none text-xs font-mono text-slate-600 py-0.5">
                                        </td>
                                        <td class="px-3 py-2.5">
                                            <select x-model="row.satuan" class="bg-transparent border-b border-dashed border-slate-300 text-xs text-slate-600 outline-none py-0.5">
                                                <option>Kg</option><option>Liter</option><option>Pcs</option>
                                            </select>
                                        </td>
                                        <td class="px-3 py-2.5 text-right">
                                            <input x-model="row.bom" type="number" step="0.1" min="0" placeholder="0.0" class="w-20 bg-transparent border-b border-dashed border-slate-300 focus:border-cyan outline-none text-sm font-bold text-navy text-right py-0.5">
                                        </td>
                                        <td class="px-3 py-2.5 text-right">
                                            <input x-model="row.aktual" type="number" step="0.1" min="0" placeholder="0.0" class="w-20 bg-transparent border-b border-dashed border-slate-300 focus:border-cyan outline-none text-sm font-bold text-right py-0.5" :class="selisih(row) < 0 ? 'text-amber-600' : 'text-emerald-700'">
                                        </td>
                                        <td class="px-3 py-2.5">
                                            <span x-show="row.bom && row.aktual" class="text-xs font-bold px-2 py-0.5 rounded" :class="selisih(row) === 0 ? 'bg-emerald-50 text-emerald-700' : 'bg-amber-50 text-amber-700'" x-text="selisih(row) === 0 ? 'OK' : selisih(row).toFixed(1)"></span>
                                        </td>
                                        <td class="px-3 py-2.5 no-print">
                                            <button @click="rows.splice(i,1)" class="text-red-400 hover:text-red-600">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                            </button>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                    <p class="text-xs text-slate-400 mt-2 italic">*Selisih akan otomatis terhitung. Warna kuning = ada selisih, harus dilaporkan ke gudang.</p>
                </div>


                <!-- Status Stok Gudang -->
                <div class="bg-slate-50 border border-slate-200 rounded-xl p-4">
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wide mb-3">Konfirmasi Update Stok Gudang</p>
                    <div class="flex items-center gap-3">
                        <div class="w-5 h-5 border-2 border-slate-400 rounded"></div>
                        <p class="text-sm text-slate-700">Stok gudang telah dikurangi sesuai jumlah transfer aktual di atas.</p>
                    </div>
                </div>

                <!-- Tanda Tangan -->
                <div class="grid grid-cols-3 gap-6 pt-4">
                    <div class="text-center">
                        <div class="h-16 border-b border-slate-300 mb-2"></div>
                        <p class="text-xs font-bold text-slate-600">Dibuat / Diminta oleh</p>
                        <p class="text-[10px] text-slate-400">PPIC</p>
                    </div>
                    <div class="text-center">
                        <div class="h-16 border-b border-slate-300 mb-2"></div>
                        <p class="text-xs font-bold text-slate-600">Disiapkan & Diserahkan</p>
                        <p class="text-[10px] text-slate-400">Petugas Gudang</p>
                    </div>
                    <div class="text-center">
                        <div class="h-16 border-b border-slate-300 mb-2"></div>
                        <p class="text-xs font-bold text-slate-600">Diterima oleh</p>
                        <p class="text-[10px] text-slate-400">Operator / Produksi</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ========== FORM SERAH TERIMA ========== -->
    <div x-show="activeDoc === 'serah_terima'" x-transition style="display:none;">
        <div class="bg-white rounded-2xl shadow-lg print-shadow border border-slate-200 overflow-hidden">
            <!-- Header -->
            <div class="border-b-4 border-emerald-600 p-6 bg-slate-50/50">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">PT Dunia Kimia Jaya</p>
                        <h1 class="text-2xl font-black text-navy uppercase tracking-tight">Berita Acara Serah Terima</h1>
                        <p class="text-sm text-slate-500 mt-0.5">Serah Terima Material dari Gudang ke Bagian Produksi</p>
                    </div>
                    <div class="text-right">
                        <div class="inline-block bg-emerald-50 border border-emerald-200 rounded-xl px-4 py-2 text-right">
                            <p class="text-[10px] font-bold text-emerald-600 uppercase tracking-wide">No. Dokumen</p>
                            <p class="text-lg font-black text-navy">BAST-2608-001</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-6 space-y-6">
                <!-- Paragraf Serah Terima -->
                <div class="bg-emerald-50 border border-emerald-200 rounded-xl p-4">
                    <p class="text-sm text-slate-700 leading-relaxed">
                        Pada hari <strong>Kamis, 27 Agustus 2026</strong>, pihak <strong>Gudang Bahan Baku</strong> telah menyerahkan material kepada pihak <strong>Bagian Produksi</strong> untuk keperluan pelaksanaan Surat Perintah Kerja (SPK) Nomor <strong>SPK-2608-001</strong>, dengan rincian sebagaimana tercantum di bawah ini.
                    </p>
                </div>

                <!-- Info Pihak -->
                <div class="grid grid-cols-2 gap-6">
                    <div class="border border-slate-200 rounded-xl p-4">
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wide mb-3">Pihak Penyerah (Gudang)</p>
                        <div class="space-y-2 text-sm">
                            <div class="flex gap-2"><span class="text-slate-400 w-20 text-xs">Nama</span><span class="font-bold text-navy">Ahmad Fauzi</span></div>
                            <div class="flex gap-2"><span class="text-slate-400 w-20 text-xs">Jabatan</span><span class="font-bold text-navy">Kepala Gudang</span></div>
                            <div class="flex gap-2"><span class="text-slate-400 w-20 text-xs">Departemen</span><span class="font-bold text-navy">Gudang & Logistik</span></div>
                        </div>
                    </div>
                    <div class="border border-slate-200 rounded-xl p-4">
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wide mb-3">Pihak Penerima (Produksi)</p>
                        <div class="space-y-2 text-sm">
                            <div class="flex gap-2"><span class="text-slate-400 w-20 text-xs">Nama</span><span class="font-bold text-navy">Budi Santoso</span></div>
                            <div class="flex gap-2"><span class="text-slate-400 w-20 text-xs">Jabatan</span><span class="font-bold text-navy">Lead Operator</span></div>
                            <div class="flex gap-2"><span class="text-slate-400 w-20 text-xs">Departemen</span><span class="font-bold text-navy">Produksi — Shift 1 (Red Team)</span></div>
                        </div>
                    </div>
                </div>

                <!-- Tabel Material -->
                <div>
                    <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wide mb-3">Daftar Material yang Diserahterimakan</h3>
                    <div class="border border-slate-200 rounded-xl overflow-hidden">
                        <table class="w-full text-left text-sm">
                            <thead class="bg-slate-50 border-b border-slate-200">
                                <tr class="text-xs uppercase text-slate-500 font-bold">
                                    <th class="px-4 py-3">No.</th>
                                    <th class="px-4 py-3">Nama Material</th>
                                    <th class="px-4 py-3">Batch / Lot No.</th>
                                    <th class="px-4 py-3 text-right">Jumlah (Kg)</th>
                                    <th class="px-4 py-3">Kondisi</th>
                                    <th class="px-4 py-3">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                <tr>
                                    <td class="px-4 py-3 text-slate-500">1</td>
                                    <td class="px-4 py-3 font-semibold text-navy">Resin PVC S-65</td>
                                    <td class="px-4 py-3 font-mono text-xs text-slate-600">LOT-260801</td>
                                    <td class="px-4 py-3 text-right font-bold text-navy">500.0</td>
                                    <td class="px-4 py-3"><span class="text-xs font-bold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded">Baik</span></td>
                                    <td class="px-4 py-3 text-xs text-slate-500">—</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-3 text-slate-500">2</td>
                                    <td class="px-4 py-3 font-semibold text-navy">Stabilizer Ca-Zn</td>
                                    <td class="px-4 py-3 font-mono text-xs text-slate-600">LOT-260805</td>
                                    <td class="px-4 py-3 text-right font-bold text-navy">20.0</td>
                                    <td class="px-4 py-3"><span class="text-xs font-bold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded">Baik</span></td>
                                    <td class="px-4 py-3 text-xs text-slate-500">—</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-3 text-slate-500">3</td>
                                    <td class="px-4 py-3 font-semibold text-navy">Pigment White</td>
                                    <td class="px-4 py-3 font-mono text-xs text-slate-600">LOT-260803</td>
                                    <td class="px-4 py-3 text-right font-bold text-navy">9.5</td>
                                    <td class="px-4 py-3"><span class="text-xs font-bold text-amber-600 bg-amber-50 px-2 py-0.5 rounded">Kurang 0.5Kg</span></td>
                                    <td class="px-4 py-3 text-xs text-slate-500">Sisanya akan dikirim menyusul</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Pernyataan -->
                <div class="border border-slate-200 rounded-xl p-4 space-y-3">
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wide">Pernyataan & Konfirmasi</p>
                    <div class="flex items-start gap-3">
                        <div class="w-4 h-4 mt-0.5 border-2 border-slate-400 rounded flex-shrink-0"></div>
                        <p class="text-xs text-slate-600">Material yang tercantum telah diterima dalam kondisi baik, jumlah telah dihitung dan diverifikasi oleh kedua pihak.</p>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-4 h-4 mt-0.5 border-2 border-slate-400 rounded flex-shrink-0"></div>
                        <p class="text-xs text-slate-600">Stok gudang akan disesuaikan secara otomatis berdasarkan dokumen serah terima ini setelah ditandatangani kedua pihak.</p>
                    </div>
                </div>

                <!-- Tanda Tangan -->
                <div class="grid grid-cols-2 gap-8 pt-4">
                    <div class="text-center">
                        <p class="text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Pihak Penyerah</p>
                        <div class="h-20 border border-dashed border-slate-300 rounded-lg mb-3 flex items-end justify-center pb-2">
                            <span class="text-[10px] text-slate-300">(Tanda Tangan & Cap)</span>
                        </div>
                        <p class="text-xs font-bold text-slate-600">Ahmad Fauzi</p>
                        <p class="text-[10px] text-slate-400">Kepala Gudang — 27 Agustus 2026</p>
                    </div>
                    <div class="text-center">
                        <p class="text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Pihak Penerima</p>
                        <div class="h-20 border border-dashed border-slate-300 rounded-lg mb-3 flex items-end justify-center pb-2">
                            <span class="text-[10px] text-slate-300">(Tanda Tangan)</span>
                        </div>
                        <p class="text-xs font-bold text-slate-600">Budi Santoso</p>
                        <p class="text-[10px] text-slate-400">Lead Operator Produksi — 27 Agustus 2026</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('docsApp', () => ({
            activeDoc: 'moving'
        }));

        Alpine.data('movingSlipApp', () => ({
            rows: [
                { nama: 'Resin PVC S-65', kode: 'RM-001', qty: 50, ket: 'Tumpah saat proses' },
                { nama: 'Stabilizer Ca-Zn', kode: 'RM-003', qty: 2, ket: '' }
            ],
            addRow() {
                this.rows.push({ nama: '', kode: '', qty: '', ket: '' });
            },
            get totalQty() {
                return this.rows.reduce((sum, r) => sum + (parseFloat(r.qty) || 0), 0);
            }
        }));

        Alpine.data('transferSlipApp', () => ({
            rows: [
                { nama: 'Resin PVC S-65', kode: 'RM-001', satuan: 'Kg', bom: 500, aktual: 500 },
                { nama: 'Stabilizer Ca-Zn', kode: 'RM-003', satuan: 'Kg', bom: 20, aktual: 20 },
                { nama: 'Pigment White', kode: 'RM-007', satuan: 'Kg', bom: 10, aktual: 9.5 }
            ],
            addRow() {
                this.rows.push({ nama: '', kode: '', satuan: 'Kg', bom: '', aktual: '' });
            },
            selisih(row) {
                const b = parseFloat(row.aktual) || 0;
                const a = parseFloat(row.bom) || 0;
                return parseFloat((b - a).toFixed(2));
            }
        }));
    });
</script>

</body>
</html>
