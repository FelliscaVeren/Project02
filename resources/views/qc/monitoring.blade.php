@extends('layouts.app')

@section('title', 'QC Inspection & Physical Test Monitoring')

@section('content')
<div class="w-full px-4 sm:px-6 lg:px-8 min-h-full pb-16" x-data="qcMonitoringApp()">

    <!-- Header Page & Selector SPK -->
    <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm mb-6 flex flex-wrap items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="px-2.5 py-1 bg-rose-100 text-rose-800 font-extrabold text-[10px] rounded-full uppercase tracking-wider border border-rose-200">Quality Control (QC)</span>
                <span class="text-xs text-slate-400">· Standard Operasional Prosedur QC-LAB-2026</span>
            </div>
            <h2 class="text-2xl font-black text-navy tracking-tight">Monitoring QC: Dispersi & Physical Mechanical Test</h2>
            <p class="text-xs text-slate-500 mt-1">Pengecekan rutin Dispersi (1 jam sekali) dan pengujian Physical & Mechanical Test (2 jam sekali) sesuai dokumen standar laboratorium.</p>
        </div>

        <div class="flex items-center gap-3">
            <div class="bg-slate-50 border border-slate-200 rounded-xl p-2.5">
                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wide mb-1">Pilih SPK Aktif</label>
                <select x-model="selectedSpkId" @change="changeSpk()" class="bg-white border border-slate-200 rounded-lg px-3 py-1.5 text-xs font-bold text-navy focus:ring-cyan focus:border-cyan outline-none">
                    <option value="SPK-2608-001">SPK-2608-001 · PT Royal Synthetic (PVC Clear)</option>
                    <option value="SPK-2608-002">SPK-2608-002 · PT Chemindo Utama (PVC Color)</option>
                    <option value="SPK-2608-003">SPK-2608-003 · PT Indopack Industri (Rigid PVC)</option>
                </select>
            </div>
            <button @click="openNcModal()" class="px-4 py-3 bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs rounded-xl shadow-md transition flex items-center gap-2 animate-pulse">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                Kirim Alert Ke Foreman
            </button>
        </div>
    </div>

    <!-- Alert Ketidaksesuaian Realtime (Jika Terdeteksi Reject / Hold / Out-of-Spec) -->
    <div x-show="hasNonConformance" x-transition class="bg-rose-50 border-2 border-rose-300 rounded-2xl p-5 mb-6 shadow-sm">
        <div class="flex items-start justify-between gap-4">
            <div class="flex items-start gap-3">
                <div class="w-10 h-10 rounded-xl bg-rose-600 text-white flex items-center justify-center flex-shrink-0 shadow-md">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <h4 class="text-base font-black text-rose-900">🚨 PERINGATAN KETIDAKSESUAIAN PRODUK (OUT OF SPEC DETECTED)</h4>
                        <span class="px-2 py-0.5 bg-rose-200 text-rose-900 text-[10px] font-bold rounded-full uppercase" x-text="ncIncidents.length + ' Temuan NC'"></span>
                    </div>
                    <p class="text-xs text-rose-700 font-medium mt-1" x-text="latestNcDetails"></p>
                    <div class="mt-2 flex items-center gap-2 text-[11px] text-slate-600 bg-white/80 p-2 rounded-lg border border-rose-200">
                        <span class="font-bold text-rose-800">Tindakan Diminta:</span>
                        <span>Segera laporkan temuan ini ke Kepala Produksi / Foreman untuk penghentian sementara atau penanganan khusus.</span>
                    </div>
                </div>
            </div>
            <button @click="openNcModal()" class="px-4 py-2 bg-rose-700 hover:bg-rose-800 text-white font-bold text-xs rounded-xl shadow transition shrink-0 flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                Kirim Laporan ke Foreman
            </button>
        </div>
    </div>

    <!-- Quick Status Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-sm">
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Status Dispersi (1 Jam Sekali)</p>
            <div class="flex items-center justify-between">
                <span class="text-lg font-black text-emerald-600">PASS (Rating 4/5)</span>
                <span class="px-2 py-0.5 bg-emerald-100 text-emerald-800 text-[10px] font-bold rounded">1 Jam Rutin</span>
            </div>
            <p class="text-[10px] text-slate-500 mt-1">Pengecekan terakhir: <b x-text="lastDisperseTime">12:00 WIB</b></p>
        </div>

        <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-sm">
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Physical & Mechanical (2 Jam)</p>
            <div class="flex items-center justify-between">
                <span class="text-lg font-black text-cyan">Monitoring 2 Jam</span>
                <span class="px-2 py-0.5 bg-cyan/20 text-cyan text-[10px] font-bold rounded">Sample #4</span>
            </div>
            <p class="text-[10px] text-slate-500 mt-1">Status Lab: <b class="text-emerald-600">MFI & SG Normal</b></p>
        </div>

        <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-sm">
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Total Insiden NC</p>
            <div class="flex items-center justify-between">
                <span class="text-xl font-black text-rose-600" x-text="ncIncidents.length + ' Insiden'">1 Insiden</span>
                <span class="px-2 py-0.5 bg-rose-100 text-rose-800 text-[10px] font-bold rounded" x-text="ncAlertSent ? 'Alert Sent' : 'Pending Alert'">Alert Sent</span>
            </div>
            <p class="text-[10px] text-slate-500 mt-1">Dikirim ke Foreman: <b x-text="foremanName">Budi S. (Foreman RED)</b></p>
        </div>

        <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-sm">
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Harmonisasi Status QC</p>
            <div class="flex items-center gap-1.5 mt-1">
                <span class="px-2 py-1 bg-emerald-100 text-emerald-800 border border-emerald-200 text-[10px] font-extrabold rounded">PASS (Hijau)</span>
                <span class="px-2 py-1 bg-amber-100 text-amber-800 border border-amber-200 text-[10px] font-extrabold rounded">HOLD (Kuning)</span>
                <span class="px-2 py-1 bg-rose-100 text-rose-800 border border-rose-200 text-[10px] font-extrabold rounded">REJECT (Merah)</span>
            </div>
            <p class="text-[10px] text-slate-400 mt-1">Notes merah wajib jika status REJECT</p>
        </div>
    </div>

    <!-- TAB FITUR QC -->
    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden mb-8">
        
        <!-- Header Switcher Tab -->
        <div class="border-b border-slate-200 bg-slate-50/70 p-2 flex items-center justify-between flex-wrap gap-2">
            <div class="flex items-center gap-2">
                <button @click="activeQcTab = 'disperse'" :class="activeQcTab === 'disperse' ? 'bg-white text-navy shadow-sm font-extrabold border-slate-200' : 'text-slate-500 font-semibold hover:text-slate-800'" class="px-4 py-2.5 text-xs rounded-xl border transition flex items-center gap-2">
                    <svg class="w-4 h-4 text-cyan" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    1. Pengecekan Dispersi (1 Jam Sekali)
                </button>
                <button @click="activeQcTab = 'physical'" :class="activeQcTab === 'physical' ? 'bg-white text-navy shadow-sm font-extrabold border-slate-200' : 'text-slate-500 font-semibold hover:text-slate-800'" class="px-4 py-2.5 text-xs rounded-xl border transition flex items-center gap-2">
                    <svg class="w-4 h-4 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    2. Physical and Mechanical Test (2 Jam Sekali)
                </button>
                <button @click="activeQcTab = 'nc_logs'" :class="activeQcTab === 'nc_logs' ? 'bg-white text-navy shadow-sm font-extrabold border-slate-200' : 'text-slate-500 font-semibold hover:text-slate-800'" class="px-4 py-2.5 text-xs rounded-xl border transition flex items-center gap-2">
                    <svg class="w-4 h-4 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    3. Laporan Ketidaksesuaian ke Foreman
                </button>
            </div>

            <span class="text-xs font-bold text-slate-500 px-3 py-1 bg-slate-100 rounded-lg">Analis QC: <b class="text-navy">Hendra (QC)</b></span>
        </div>

        <!-- ============ TAB 1: PENGECEKAN DISPERSI (1 JAM SEKALI) ============ -->
        <div x-show="activeQcTab === 'disperse'" class="p-6 space-y-6">
            
            <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                <div>
                    <h3 class="text-lg font-bold text-navy flex items-center gap-2">
                        🔍 Log Pengecekan Dispersi (Frequency: Rutin 1 Jam Sekali)
                    </h3>
                    <p class="text-xs text-slate-500 mt-0.5">Memastikan tingkat homogenitas lelehan resin dan pemerataan aditif pigment/stabilizer di extruder.</p>
                </div>
                <span class="px-3 py-1.5 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-xl text-xs font-bold">✓ Pengecekan Rutin Aktif</span>
            </div>

            <!-- Form Tambah Dispersi 1 Jam -->
            <div class="bg-slate-50 border border-slate-200 rounded-2xl p-5 space-y-4">
                <h4 class="text-xs font-bold text-slate-700 uppercase tracking-wider">+ Input Hasil Pengecekan Dispersi Jam Baru</h4>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 mb-1">Jam Pengecekan <span class="text-rose-500">*</span></label>
                        <select x-model="newDisperse.jam" class="w-full bg-white border border-slate-200 rounded-xl p-2.5 text-xs text-navy font-bold outline-none focus:ring-cyan focus:border-cyan">
                            <option value="06:00">06:00 WIB</option>
                            <option value="07:00">07:00 WIB</option>
                            <option value="08:00">08:00 WIB</option>
                            <option value="09:00">09:00 WIB</option>
                            <option value="10:00">10:00 WIB</option>
                            <option value="11:00">11:00 WIB</option>
                            <option value="12:00">12:00 WIB</option>
                            <option value="13:00">13:00 WIB</option>
                            <option value="14:00">14:00 WIB</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 mb-1">Rating Dispersi (1-5)</label>
                        <select x-model="newDisperse.rating" class="w-full bg-white border border-slate-200 rounded-xl p-2.5 text-xs text-navy font-bold outline-none focus:ring-cyan focus:border-cyan">
                            <option value="5">Rating 5 · Sangat Homogen</option>
                            <option value="4">Rating 4 · Baik / Standard</option>
                            <option value="3">Rating 3 · Cukup (Ada Bintik Halus)</option>
                            <option value="2">Rating 2 · Kurang (Aglomerat Merah)</option>
                            <option value="1">Rating 1 · Sangat Buruk (Gumpalan)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 mb-1">Pengecekan Visual</label>
                        <input type="text" x-model="newDisperse.visual" placeholder="Contoh: Bebas aglomerat & bintik" class="w-full bg-white border border-slate-200 rounded-xl p-2.5 text-xs text-navy outline-none focus:ring-cyan focus:border-cyan">
                    </div>

                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 mb-1">Status QC <span class="text-rose-500">*</span></label>
                        <select x-model="newDisperse.status" class="w-full border rounded-xl p-2.5 text-xs font-black outline-none transition"
                                :class="{
                                    'bg-emerald-50 text-emerald-800 border-emerald-300': newDisperse.status === 'PASS',
                                    'bg-amber-50 text-amber-800 border-amber-300': newDisperse.status === 'HOLD',
                                    'bg-rose-50 text-rose-800 border-rose-300': newDisperse.status === 'REJECT'
                                }">
                            <option value="PASS">PASS (Hijau - Lolos)</option>
                            <option value="HOLD">HOLD (Kuning - Penahanan)</option>
                            <option value="REJECT">REJECT (Merah - Ditolak)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 mb-1">Catatan QC <span x-show="newDisperse.status === 'REJECT'" class="text-rose-600 font-bold">(Wajib Merah!)</span></label>
                        <input type="text" x-model="newDisperse.notes" placeholder="Catatan evaluasi atau alasan penolakan..." class="w-full bg-white border rounded-xl p-2.5 text-xs text-navy outline-none focus:ring-cyan focus:border-cyan" :class="newDisperse.status === 'REJECT' ? 'border-rose-400 ring-1 ring-rose-300' : 'border-slate-200'">
                    </div>
                </div>

                <div class="flex justify-end pt-2">
                    <button @click="addDisperseEntry()" class="px-5 py-2.5 bg-navy hover:bg-navy-light text-white text-xs font-bold rounded-xl shadow transition flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Simpan Hasil Dispersi Jam Ini
                    </button>
                </div>
            </div>

            <!-- Tabel Log Dispersi 1 Jam -->
            <div class="overflow-x-auto border border-slate-200 rounded-2xl">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-100 text-slate-700 font-bold uppercase tracking-wider text-[10px] border-b border-slate-200">
                        <tr>
                            <th class="p-3">Jam Pengecekan</th>
                            <th class="p-3">Visual & Aglomerat</th>
                            <th class="p-3">Rating Dispersi</th>
                            <th class="p-3 text-center">Status QC</th>
                            <th class="p-3">Catatan / Notes QC</th>
                            <th class="p-3">Inspector QC</th>
                            <th class="p-3 text-right">Aksi Penanganan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <template x-for="(row, idx) in disperseLogs" :key="idx">
                            <tr :class="{
                                'bg-emerald-50/40': row.status === 'PASS',
                                'bg-amber-50/50': row.status === 'HOLD',
                                'bg-rose-50/60': row.status === 'REJECT'
                            }">
                                <td class="p-3 font-bold text-navy" x-text="row.jam + ' WIB'"></td>
                                <td class="p-3 text-slate-700 font-medium" x-text="row.visual"></td>
                                <td class="p-3 font-bold">
                                    <span class="px-2 py-0.5 rounded text-[11px]" :class="row.rating >= 4 ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800'" x-text="'Rating ' + row.rating + ' / 5'"></span>
                                </td>
                                <td class="p-3 text-center">
                                    <template x-if="row.status === 'PASS'">
                                        <span class="inline-block px-2.5 py-1 bg-emerald-100 text-emerald-800 border border-emerald-300 rounded-lg font-black text-[10px]">
                                            ✓ PASS (HIJAU)
                                        </span>
                                    </template>
                                    <template x-if="row.status === 'HOLD'">
                                        <span class="inline-block px-2.5 py-1 bg-amber-100 text-amber-800 border border-amber-300 rounded-lg font-black text-[10px]">
                                            ⚠️ HOLD (KUNING)
                                        </span>
                                    </template>
                                    <template x-if="row.status === 'REJECT'">
                                        <span class="inline-block px-2.5 py-1 bg-rose-100 text-rose-800 border border-rose-300 rounded-lg font-black text-[10px]">
                                            ✕ REJECT (MERAH)
                                        </span>
                                    </template>
                                </td>
                                <td class="p-3 font-medium">
                                    <template x-if="row.status === 'REJECT'">
                                        <span class="text-rose-700 font-bold bg-rose-100/80 px-2 py-1 rounded border border-rose-200" x-text="row.notes"></span>
                                    </template>
                                    <template x-if="row.status !== 'REJECT'">
                                        <span class="text-slate-600" x-text="row.notes || '-'"></span>
                                    </template>
                                </td>
                                <td class="p-3 font-semibold text-slate-700" x-text="row.inspector"></td>
                                <td class="p-3 text-right">
                                    <template x-if="row.status === 'REJECT' || row.status === 'HOLD'">
                                        <button @click="openNcModal(row)" class="px-2.5 py-1 bg-rose-600 hover:bg-rose-700 text-white font-bold text-[11px] rounded-lg shadow-sm transition inline-flex items-center gap-1">
                                            🚨 Kirim Ke Foreman
                                        </button>
                                    </template>
                                    <template x-if="row.status === 'PASS'">
                                        <span class="text-[10px] font-bold text-emerald-600">Terverifikasi</span>
                                    </template>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
        </div>


        <!-- ============ TAB 2: PHYSICAL AND MECHANICAL TEST (2 JAM SEKALI - SPREADSHEET LAYOUT) ============ -->
        <div x-show="activeQcTab === 'physical'" class="p-6 space-y-6">
            
            <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                <div>
                    <h3 class="text-lg font-bold text-navy flex items-center gap-2">
                        📊 Physical and Mechanical Test Log (Frequency: Rutin 2 Jam Sekali)
                    </h3>
                    <p class="text-xs text-slate-500 mt-0.5">Tampilan data hasil pengujian laboratorium mengikuti format standar fisik & mekanik (Moisture, SG, Melt Flow Index).</p>
                </div>
                <div class="flex items-center gap-2">
                    <span class="px-3 py-1 bg-blue-50 text-blue-700 border border-blue-200 rounded-xl text-xs font-bold">Standard Document Lab</span>
                </div>
            </div>

            <!-- Header Dokumen Ala Spreadsheet -->
            <div class="bg-slate-900 text-white rounded-2xl p-4 shadow-md flex items-center justify-between flex-wrap gap-3 font-sans">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-cyan/20 border border-cyan/40 text-cyan flex items-center justify-center font-bold text-sm">
                        LAB
                    </div>
                    <div>
                        <h4 class="text-base font-black tracking-wide uppercase">Physical and Mechanical Test</h4>
                        <p class="text-xs text-slate-300">Product Name : <b class="text-cyan" x-text="selectedSpk.product">PVC Compound A (Clear)</b> | No. SPK: <b class="text-amber-300" x-text="selectedSpkId">SPK-2608-001</b></p>
                    </div>
                </div>
                <div class="text-right text-xs">
                    <p class="text-slate-400">Pengujian Terakhir: <b class="text-white">12:00 WIB</b></p>
                    <p class="text-emerald-400 font-bold mt-0.5">Standard Specs: Moisture ≤ 0.10% | MFI 15 - 18 g/10min</p>
                </div>
            </div>

            <!-- Form Quick Entry Physical Test 2 Jam -->
            <div class="bg-slate-50 border border-slate-200 rounded-2xl p-5 space-y-4">
                <h4 class="text-xs font-bold text-slate-700 uppercase tracking-wider">+ Form Input Pengujian Fisik & Mekanik (Per 2 Jam)</h4>
                
                <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-8 gap-3">
                    <div>
                        <label class="block text-[10px] font-bold text-slate-600 mb-1">No. Zak</label>
                        <input type="text" x-model="newPhysical.noZak" placeholder="Misal: Zak #05" class="w-full bg-white border border-slate-200 rounded-xl p-2 text-xs font-bold text-navy outline-none focus:ring-cyan">
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold text-slate-600 mb-1">Measurement Time</label>
                        <select x-model="newPhysical.time" class="w-full bg-white border border-slate-200 rounded-xl p-2 text-xs font-bold text-navy outline-none focus:ring-cyan">
                            <option value="06:00">06:00 WIB</option>
                            <option value="08:00">08:00 WIB</option>
                            <option value="10:00">10:00 WIB</option>
                            <option value="12:00">12:00 WIB</option>
                            <option value="14:00">14:00 WIB</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold text-slate-600 mb-1">Lot Number</label>
                        <input type="text" x-model="newPhysical.lotNumber" placeholder="LOT-260816-01" class="w-full bg-white border border-slate-200 rounded-xl p-2 text-xs text-slate-800 outline-none focus:ring-cyan">
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold text-slate-600 mb-1">Moisture (%)</label>
                        <input type="number" step="0.01" x-model.number="newPhysical.moisture" placeholder="0.08" class="w-full bg-white border border-slate-200 rounded-xl p-2 text-xs font-bold text-navy outline-none focus:ring-cyan">
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold text-slate-600 mb-1">Specific Gravity</label>
                        <input type="number" step="0.01" x-model.number="newPhysical.sg" placeholder="1.34" class="w-full bg-white border border-slate-200 rounded-xl p-2 text-xs font-bold text-navy outline-none focus:ring-cyan">
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold text-slate-600 mb-1">MFI 1 (g/10min)</label>
                        <input type="number" step="0.1" x-model.number="newPhysical.mfi1" @input="calcAvgMfi()" placeholder="16.5" class="w-full bg-white border border-slate-200 rounded-xl p-2 text-xs font-bold text-navy outline-none focus:ring-cyan">
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold text-slate-600 mb-1">MFI 2 (g/10min)</label>
                        <input type="number" step="0.1" x-model.number="newPhysical.mfi2" @input="calcAvgMfi()" placeholder="16.8" class="w-full bg-white border border-slate-200 rounded-xl p-2 text-xs font-bold text-navy outline-none focus:ring-cyan">
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold text-slate-600 mb-1">MFI 3 (g/10min)</label>
                        <input type="number" step="0.1" x-model.number="newPhysical.mfi3" @input="calcAvgMfi()" placeholder="16.6" class="w-full bg-white border border-slate-200 rounded-xl p-2 text-xs font-bold text-navy outline-none focus:ring-cyan">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-3 pt-2">
                    <div>
                        <label class="block text-[10px] font-bold text-slate-600 mb-1">Average MFI (Otomatis)</label>
                        <input type="text" :value="newPhysical.avgMfi || '0.0'" disabled class="w-full bg-slate-100 border border-slate-200 rounded-xl p-2 text-xs font-black text-navy cursor-not-allowed">
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold text-slate-600 mb-1">Status QC <span class="text-rose-500">*</span></label>
                        <select x-model="newPhysical.status" class="w-full border rounded-xl p-2 text-xs font-black outline-none transition"
                                :class="{
                                    'bg-emerald-50 text-emerald-800 border-emerald-300': newPhysical.status === 'PASS',
                                    'bg-amber-50 text-amber-800 border-amber-300': newPhysical.status === 'HOLD',
                                    'bg-rose-50 text-rose-800 border-rose-300': newPhysical.status === 'REJECT'
                                }">
                            <option value="PASS">PASS (Hijau - Lolos)</option>
                            <option value="HOLD">HOLD (Kuning - Penahanan)</option>
                            <option value="REJECT">REJECT (Merah - Ditolak)</option>
                        </select>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-[10px] font-bold text-slate-600 mb-1">Note / Catatan Lab <span x-show="newPhysical.status === 'REJECT'" class="text-rose-600 font-bold">(Notes Merah Wajib Diisi!)</span></label>
                        <div class="flex gap-2">
                            <input type="text" x-model="newPhysical.note" placeholder="Catatan pengujian atau alasan penolakan..." class="w-full bg-white border rounded-xl p-2 text-xs text-navy outline-none focus:ring-cyan" :class="newPhysical.status === 'REJECT' ? 'border-rose-400 ring-1 ring-rose-300' : 'border-slate-200'">
                            <button @click="addPhysicalEntry()" class="px-4 py-2 bg-navy hover:bg-navy-light text-white text-xs font-bold rounded-xl shadow transition shrink-0 flex items-center gap-1">
                                + Simpan
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TABEL MODUL PHYSICAL & MECHANICAL TEST (MEMIKIK PERSIS FORMAT EXCEL GAMBAR) -->
            <div class="overflow-x-auto border border-slate-300 rounded-2xl shadow-sm bg-white">
                <table class="w-full text-center text-xs border-collapse font-sans">
                    <thead class="bg-amber-100 text-slate-900 border-b-2 border-slate-400 font-bold text-[10px]">
                        <!-- Multi-Level Header Layer 1 -->
                        <tr class="divide-x divide-slate-300">
                            <th rowspan="2" class="p-2 border-b border-slate-300 bg-amber-200">No</th>
                            <th rowspan="2" class="p-2 border-b border-slate-300 bg-amber-200">No. Zak</th>
                            <th colspan="2" class="p-2 border-b border-slate-300 bg-amber-200">Measurement</th>
                            <th rowspan="2" class="p-2 border-b border-slate-300 bg-amber-200">Lot Number</th>
                            <th colspan="2" class="p-2 border-b border-slate-300 bg-amber-200">Moisture</th>
                            <th colspan="2" class="p-2 border-b border-slate-300 bg-amber-200">Specific Gravity</th>
                            <th colspan="9" class="p-2 border-b border-slate-300 bg-amber-200">Melt Flow Index (MFI)</th>
                            <th rowspan="2" class="p-2 border-b border-slate-300 bg-amber-200 min-w-[120px]">Status QC</th>
                            <th rowspan="2" class="p-2 border-b border-slate-300 bg-amber-200 min-w-[150px]">Note</th>
                            <th rowspan="2" class="p-2 border-b border-slate-300 bg-amber-200">Analysed by</th>
                            <th rowspan="2" class="p-2 border-b border-slate-300 bg-amber-200">Reviewed by</th>
                        </tr>
                        <!-- Multi-Level Header Layer 2 -->
                        <tr class="divide-x divide-slate-300 bg-amber-100">
                            <th class="p-1">Time</th>
                            <th class="p-1">Date</th>
                            <th class="p-1">Mass (g)</th>
                            <th class="p-1">Moisture (%)</th>
                            <th class="p-1">Mass (g)</th>
                            <th class="p-1">SG (g/cm³)</th>
                            <th class="p-1">Temp (°C)</th>
                            <th class="p-1">Cut time (s)</th>
                            <th class="p-1">Cut 1 Mass</th>
                            <th class="p-1">MFI 1</th>
                            <th class="p-1">Cut 2 Mass</th>
                            <th class="p-1">MFI 2</th>
                            <th class="p-1">Cut 3 Mass</th>
                            <th class="p-1">MFI 3</th>
                            <th class="p-1 bg-amber-300 text-slate-900 font-extrabold">Average MFI</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 text-slate-800 text-[11px]">
                        <template x-for="(row, idx) in physicalLogs" :key="idx">
                            <tr class="divide-x divide-slate-200 transition-colors" :class="{
                                'bg-emerald-50/50 hover:bg-emerald-100/50': row.status === 'PASS',
                                'bg-amber-50/60 hover:bg-amber-100/60': row.status === 'HOLD',
                                'bg-rose-50/70 hover:bg-rose-100/70': row.status === 'REJECT'
                            }">
                                <td class="p-2 font-bold text-slate-600" x-text="idx + 1"></td>
                                <td class="p-2 font-bold text-navy" x-text="row.noZak"></td>
                                <td class="p-2 font-semibold" x-text="row.time"></td>
                                <td class="p-2 text-slate-500" x-text="row.date"></td>
                                <td class="p-2 font-mono text-[10px]" x-text="row.lotNumber"></td>
                                <td class="p-2 text-slate-600" x-text="row.moistureMass + ' g'"></td>
                                <td class="p-2 font-bold" :class="row.moistureVal > 0.10 ? 'text-rose-600 font-black' : 'text-slate-800'" x-text="row.moistureVal + ' %'"></td>
                                <td class="p-2 text-slate-600" x-text="row.sgMass + ' g'"></td>
                                <td class="p-2 font-bold text-slate-800" x-text="row.sgVal"></td>
                                <td class="p-2 text-slate-500" x-text="row.temp + ' °C'"></td>
                                <td class="p-2 text-slate-500" x-text="row.cutTime + ' s'"></td>
                                <td class="p-2 text-slate-500" x-text="row.cut1Mass + ' g'"></td>
                                <td class="p-2 font-medium" x-text="row.mfi1"></td>
                                <td class="p-2 text-slate-500" x-text="row.cut2Mass + ' g'"></td>
                                <td class="p-2 font-medium" x-text="row.mfi2"></td>
                                <td class="p-2 text-slate-500" x-text="row.cut3Mass + ' g'"></td>
                                <td class="p-2 font-medium" x-text="row.mfi3"></td>
                                <td class="p-2 font-black text-navy bg-slate-100/80" :class="row.avgMfi > 18.0 ? 'text-rose-600 font-extrabold bg-rose-100' : ''" x-text="row.avgMfi"></td>
                                <td class="p-2 text-center">
                                    <template x-if="row.status === 'PASS'">
                                        <span class="inline-block px-2 py-0.5 bg-emerald-100 text-emerald-800 border border-emerald-300 rounded font-black text-[10px]">
                                            ✓ PASS
                                        </span>
                                    </template>
                                    <template x-if="row.status === 'HOLD'">
                                        <span class="inline-block px-2 py-0.5 bg-amber-100 text-amber-800 border border-amber-300 rounded font-black text-[10px]">
                                            ⚠️ HOLD
                                        </span>
                                    </template>
                                    <template x-if="row.status === 'REJECT'">
                                        <span class="inline-block px-2 py-0.5 bg-rose-100 text-rose-800 border border-rose-300 rounded font-black text-[10px]">
                                            ✕ REJECT
                                        </span>
                                    </template>
                                </td>
                                <td class="p-2 text-left">
                                    <template x-if="row.status === 'REJECT'">
                                        <span class="text-rose-700 font-bold bg-rose-100 px-1.5 py-0.5 rounded text-[10px]" x-text="row.note"></span>
                                    </template>
                                    <template x-if="row.status !== 'REJECT'">
                                        <span class="text-slate-600" x-text="row.note || '-'"></span>
                                    </template>
                                </td>
                                <td class="p-2 text-slate-700 font-semibold" x-text="row.analysedBy"></td>
                                <td class="p-2 text-slate-700 font-semibold" x-text="row.reviewedBy"></td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
        </div>


        <!-- ============ TAB 3: LOG PENANGANAN NC KE FOREMAN ============ -->
        <div x-show="activeQcTab === 'nc_logs'" class="p-6 space-y-6">
            
            <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                <div>
                    <h3 class="text-lg font-bold text-navy flex items-center gap-2">
                        🚨 Log Penanganan Ketidaksesuaian (Alert Sent to Foreman)
                    </h3>
                    <p class="text-xs text-slate-500 mt-0.5">Daftar laporan ketidaksesuaian produk yang dikirim oleh QC ke Kepala Produksi / Foreman untuk tindakan perbaikan.</p>
                </div>
                <button @click="openNcModal()" class="px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs rounded-xl shadow transition flex items-center gap-1.5">
                    + Buat Laporan NC Baru
                </button>
            </div>

            <!-- Tabel Audit Trail Laporan NC -->
            <div class="overflow-x-auto border border-slate-200 rounded-2xl">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-100 text-slate-700 font-bold uppercase tracking-wider text-[10px] border-b border-slate-200">
                        <tr>
                            <th class="p-3">Waktu Kirim</th>
                            <th class="p-3">No. SPK & Produk</th>
                            <th class="p-3">Penerima (Foreman)</th>
                            <th class="p-3">Temuan Ketidaksesuaian</th>
                            <th class="p-3">Instruksi Tindakan Korektif</th>
                            <th class="p-3 text-center">Status Respon Foreman</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <template x-for="(nc, idx) in ncLogs" :key="idx">
                            <tr class="hover:bg-slate-50">
                                <td class="p-3 font-bold text-slate-600" x-text="nc.timestamp"></td>
                                <td class="p-3">
                                    <p class="font-bold text-navy" x-text="nc.spkId"></p>
                                    <p class="text-[10px] text-slate-500" x-text="nc.product"></p>
                                </td>
                                <td class="p-3 font-bold text-amber-800" x-text="nc.foreman"></td>
                                <td class="p-3">
                                    <span class="px-2 py-0.5 bg-rose-100 text-rose-800 rounded font-bold text-[10px] block w-fit mb-1" x-text="nc.issueType"></span>
                                    <p class="text-slate-700 font-medium" x-text="nc.description"></p>
                                </td>
                                <td class="p-3 font-semibold text-slate-700" x-text="nc.actionRequired"></td>
                                <td class="p-3 text-center">
                                    <template x-if="nc.status === 'RECEIVED'">
                                        <span class="px-2.5 py-1 bg-amber-100 text-amber-800 border border-amber-300 rounded-lg font-bold text-[10px]">
                                            ⏳ Diterima Foreman (In Action)
                                        </span>
                                    </template>
                                    <template x-if="nc.status === 'RESOLVED'">
                                        <span class="px-2.5 py-1 bg-emerald-100 text-emerald-800 border border-emerald-300 rounded-lg font-bold text-[10px]">
                                            ✓ Perbaikan Selesai
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

    <!-- MODAL KIRIM ALERT NC KE FOREMAN -->
    <div x-show="showNcModal" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm" x-transition>
        <div class="bg-white rounded-2xl shadow-2xl border border-slate-200 w-full max-w-xl overflow-hidden font-sans" @click.away="showNcModal = false">
            <div class="px-6 py-4 bg-rose-600 text-white flex justify-between items-center">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-amber-300 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    <h3 class="text-base font-bold">Kirim Laporan Ketidaksesuaian ke Foreman Produksi</h3>
                </div>
                <button @click="showNcModal = false" class="text-white/80 hover:text-white">&times;</button>
            </div>

            <div class="p-6 space-y-4 text-xs">
                <div class="bg-rose-50 border border-rose-200 rounded-xl p-3 text-rose-900 font-semibold">
                    Laporan ini akan langsung dikirim ke antarmuka & notifikasi **Foreman Produksi** untuk tindakan korektif darurat di lapangan.
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Target Penerima (Foreman Produksi) <span class="text-rose-500">*</span></label>
                    <input type="text" x-model="ncForm.foreman" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-xs text-navy font-bold outline-none">
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">No. SPK & Produk</label>
                        <input type="text" :value="selectedSpkId + ' (' + selectedSpk.product + ')'" disabled class="w-full bg-slate-100 border border-slate-200 rounded-xl p-2.5 text-xs font-bold text-slate-600 cursor-not-allowed">
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Jenis Ketidaksesuaian <span class="text-rose-500">*</span></label>
                        <select x-model="ncForm.issueType" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-xs text-navy font-bold outline-none">
                            <option value="MFI Out of Spec">MFI Out of Spec (Terlalu Tinggi/Rendah)</option>
                            <option value="Dispersi Bintik / Kontaminasi">Dispersi Bintik / Kontaminasi Pigmen</option>
                            <option value="Moisture Melebihi Limit">Moisture Melebihi Limit (> 0.10%)</option>
                            <option value="Specific Gravity Out of Spec">Specific Gravity Out of Spec</option>
                            <option value="Cacat Fisik Granule">Cacat Fisik Granule / Ukuran Tidak Seragam</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Deskripsi Temuan QC <span class="text-rose-500">*</span></label>
                    <textarea x-model="ncForm.description" rows="2" placeholder="Jelaskan detail temuan sampel (misal: Sample Zak #05 nilai MFI = 21.5 g/10min melebih spesifikasi max 18.0)" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-xs text-slate-800 outline-none focus:ring-rose-500"></textarea>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Instruksi Tindakan Korektif yang Diminta <span class="text-rose-500">*</span></label>
                    <select x-model="ncForm.actionRequired" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-2.5 text-xs text-navy font-bold outline-none">
                        <option value="Hentikan sementara Extruder & bersihkan die zone 4">Hentikan sementara Extruder & bersihkan die zone 4</option>
                        <option value="Hold Zak #05 s/d Zak #10 untuk karantina QC">Hold Zak #05 s/d Zak #10 untuk karantina QC</option>
                        <option value="Lakukan re-mixing ulang pada batch berikutnya">Lakukan re-mixing ulang pada batch berikutnya</option>
                        <option value="Koreksi suhu screw & RPM feeder extruder">Koreksi suhu screw & RPM feeder extruder</option>
                    </select>
                </div>

                <div class="bg-amber-50 border border-amber-200 rounded-xl p-3 flex items-center justify-between">
                    <span class="font-bold text-amber-900">⚡ Kirim dengan Prioritas Tinggi (High Priority Alert)</span>
                    <input type="checkbox" x-model="ncForm.isUrgent" class="w-4 h-4 text-rose-600 rounded">
                </div>
            </div>

            <div class="px-6 py-4 bg-slate-50 border-t border-slate-200 flex justify-end gap-3">
                <button @click="showNcModal = false" class="px-4 py-2 bg-white border border-slate-300 text-slate-600 font-bold text-xs rounded-xl hover:bg-slate-100">Batal</button>
                <button @click="sendNcAlertToForeman()" class="px-5 py-2 bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs rounded-xl shadow flex items-center gap-1.5">
                    🚀 Kirim Alert Ke Foreman Sekarang
                </button>
            </div>
        </div>
    </div>

</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('qcMonitoringApp', () => ({
            selectedSpkId: 'SPK-2608-001',
            activeQcTab: 'disperse',
            showNcModal: false,

            foremanName: 'Budi S. (Foreman RED)',
            lastDisperseTime: '12:00 WIB',
            ncAlertSent: true,

            spkDb: {
                'SPK-2608-001': { id: 'SPK-2608-001', customer: 'PT Royal Synthetic Compound', product: 'PVC Compound A (Clear)' },
                'SPK-2608-002': { id: 'SPK-2608-002', customer: 'PT Chemindo Utama', product: 'PVC Compound B (Color)' },
                'SPK-2608-003': { id: 'SPK-2608-003', customer: 'PT Indopack Industri', product: 'Rigid PVC Granule Grade A' }
            },

            get selectedSpk() {
                return this.spkDb[this.selectedSpkId] || this.spkDb['SPK-2608-001'];
            },

            changeSpk() {
                // reset state if needed
            },

            // FITUR 1: LOG DISPERSI 1 JAM SEKALI
            disperseLogs: [
                { jam: '06:00', rating: 5, visual: 'Bebas aglomerat & bintik halus', status: 'PASS', notes: 'Dispersi sempurna', inspector: 'Hendra (QC)' },
                { jam: '07:00', rating: 4, visual: 'Homogen, warna jernih', status: 'PASS', notes: 'Sesuai standar', inspector: 'Hendra (QC)' },
                { jam: '08:00', rating: 4, visual: 'Homogen standar', status: 'PASS', notes: 'Sesuai standar', inspector: 'Hendra (QC)' },
                { jam: '09:00', rating: 3, visual: 'Terdeteksi bintik halus pigmen', status: 'HOLD', notes: 'Perlu pengawasan suhu extruder', inspector: 'Hendra (QC)' },
                { jam: '10:00', rating: 2, visual: 'Bintik merah aglomerat menyebar', status: 'REJECT', notes: 'Aglomerat pigmen tidak meleleh sempurna di die zone 4', inspector: 'Hendra (QC)' },
                { jam: '11:00', rating: 4, visual: 'Homogen pasca pembersihan die', status: 'PASS', notes: 'Normal kembali', inspector: 'Hendra (QC)' },
                { jam: '12:00', rating: 5, visual: 'Bebas bintik & sangat jernih', status: 'PASS', notes: 'Sangat homogen', inspector: 'Hendra (QC)' }
            ],

            newDisperse: {
                jam: '13:00',
                rating: 4,
                visual: 'Bebas aglomerat',
                status: 'PASS',
                notes: ''
            },

            addDisperseEntry() {
                if (this.newDisperse.status === 'REJECT' && !this.newDisperse.notes.trim()) {
                    alert('⚠️ Gagal Menyimpan: Catatan penolakan (Notes Merah) WAJIB DIISI jika status QC adalah REJECT!');
                    return;
                }

                this.disperseLogs.unshift({
                    jam: this.newDisperse.jam,
                    rating: parseInt(this.newDisperse.rating),
                    visual: this.newDisperse.visual || 'Bebas aglomerat',
                    status: this.newDisperse.status,
                    notes: this.newDisperse.notes,
                    inspector: 'Hendra (QC)'
                });

                if (this.newDisperse.status === 'REJECT' || this.newDisperse.status === 'HOLD') {
                    this.openNcModal({
                        issueType: 'Dispersi Bintik / Kontaminasi',
                        description: `Dispersi jam ${this.newDisperse.jam} rating ${this.newDisperse.rating}/5. ${this.newDisperse.notes}`
                    });
                }

                alert('✓ Data Pengecekan Dispersi (1 Jam Sekali) BERHASIL disimpan!');
                this.newDisperse = { jam: '14:00', rating: 4, visual: 'Bebas aglomerat', status: 'PASS', notes: '' };
            },

            // FITUR 2: PHYSICAL AND MECHANICAL TEST (2 JAM SEKALI - EXCEL FORMAT)
            physicalLogs: [
                { noZak: 'Zak #01', time: '06:00', date: '2026-09-16', lotNumber: 'LOT-260816-01', moistureMass: '10.02', moistureVal: 0.05, sgMass: '25.00', sgVal: 1.34, temp: 175, cutTime: 10, cut1Mass: '1.65', mfi1: 16.5, cut2Mass: '1.68', mfi2: 16.8, cut3Mass: '1.66', mfi3: 16.6, avgMfi: 16.63, status: 'PASS', note: 'Standard OK', analysedBy: 'Hendra QC', reviewedBy: 'Budi (Foreman)' },
                { noZak: 'Zak #03', time: '08:00', date: '2026-09-16', lotNumber: 'LOT-260816-02', moistureMass: '10.05', moistureVal: 0.07, sgMass: '25.10', sgVal: 1.35, temp: 175, cutTime: 10, cut1Mass: '1.68', mfi1: 16.8, cut2Mass: '1.70', mfi2: 17.0, cut3Mass: '1.69', mfi3: 16.9, avgMfi: 16.90, status: 'PASS', note: 'Standard OK', analysedBy: 'Hendra QC', reviewedBy: 'Budi (Foreman)' },
                { noZak: 'Zak #05', time: '10:00', date: '2026-09-16', lotNumber: 'LOT-260816-03', moistureMass: '10.12', moistureVal: 0.14, sgMass: '25.25', sgVal: 1.38, temp: 175, cutTime: 10, cut1Mass: '2.10', mfi1: 21.0, cut2Mass: '2.15', mfi2: 21.5, cut3Mass: '2.20', mfi3: 22.0, avgMfi: 21.50, status: 'REJECT', note: 'MFI & Moisture melebihi batas toleransi atas (Max 18.0)', analysedBy: 'Hendra QC', reviewedBy: 'Budi (Foreman)' },
                { noZak: 'Zak #07', time: '12:00', date: '2026-09-16', lotNumber: 'LOT-260816-04', moistureMass: '10.04', moistureVal: 0.06, sgMass: '25.05', sgVal: 1.34, temp: 175, cutTime: 10, cut1Mass: '1.67', mfi1: 16.7, cut2Mass: '1.66', mfi2: 16.6, cut3Mass: '1.68', mfi3: 16.8, avgMfi: 16.70, status: 'PASS', note: 'Hasil normal pasca koreksi suhu', analysedBy: 'Hendra QC', reviewedBy: 'Budi (Foreman)' }
            ],

            newPhysical: {
                noZak: 'Zak #09',
                time: '14:00',
                lotNumber: 'LOT-260816-05',
                moisture: 0.07,
                sg: 1.34,
                mfi1: 16.6,
                mfi2: 16.7,
                mfi3: 16.8,
                avgMfi: 16.70,
                status: 'PASS',
                note: ''
            },

            calcAvgMfi() {
                let m1 = parseFloat(this.newPhysical.mfi1) || 0;
                let m2 = parseFloat(this.newPhysical.mfi2) || 0;
                let m3 = parseFloat(this.newPhysical.mfi3) || 0;
                if (m1 && m2 && m3) {
                    this.newPhysical.avgMfi = ((m1 + m2 + m3) / 3).toFixed(2);
                }
            },

            addPhysicalEntry() {
                if (this.newPhysical.status === 'REJECT' && !this.newPhysical.note.trim()) {
                    alert('⚠️ Gagal Menyimpan: Catatan penolakan (Notes Merah) WAJIB DIISI jika status QC adalah REJECT!');
                    return;
                }

                this.calcAvgMfi();

                this.physicalLogs.unshift({
                    noZak: this.newPhysical.noZak || 'Zak #09',
                    time: this.newPhysical.time,
                    date: new Date().toISOString().split('T')[0],
                    lotNumber: this.newPhysical.lotNumber || 'LOT-260816-05',
                    moistureMass: '10.00',
                    moistureVal: this.newPhysical.moisture || 0.07,
                    sgMass: '25.00',
                    sgVal: this.newPhysical.sg || 1.34,
                    temp: 175,
                    cutTime: 10,
                    cut1Mass: (this.newPhysical.mfi1 / 10).toFixed(2),
                    mfi1: this.newPhysical.mfi1 || 16.6,
                    cut2Mass: (this.newPhysical.mfi2 / 10).toFixed(2),
                    mfi2: this.newPhysical.mfi2 || 16.7,
                    cut3Mass: (this.newPhysical.mfi3 / 10).toFixed(2),
                    mfi3: this.newPhysical.mfi3 || 16.8,
                    avgMfi: this.newPhysical.avgMfi || 16.70,
                    status: this.newPhysical.status,
                    note: this.newPhysical.note,
                    analysedBy: 'Hendra QC',
                    reviewedBy: 'Budi (Foreman)'
                });

                if (this.newPhysical.status === 'REJECT' || this.newPhysical.status === 'HOLD') {
                    this.openNcModal({
                        issueType: 'MFI Out of Spec',
                        description: `Sample ${this.newPhysical.noZak} MFI Avg: ${this.newPhysical.avgMfi}. Note: ${this.newPhysical.note}`
                    });
                }

                alert('✓ Data Physical and Mechanical Test (2 Jam Sekali) BERHASIL disimpan!');
                this.newPhysical = { noZak: 'Zak #11', time: '16:00', lotNumber: 'LOT-260816-06', moisture: 0.07, sg: 1.34, mfi1: 16.5, mfi2: 16.7, mfi3: 16.6, avgMfi: 16.60, status: 'PASS', note: '' };
            },

            // FITUR 3: NON-CONFORMANCE LOGS & ALERT TO FOREMAN
            ncLogs: [
                {
                    timestamp: '10:15 WIB',
                    spkId: 'SPK-2608-001',
                    product: 'PVC Compound A (Clear)',
                    foreman: 'Budi S. (Foreman RED)',
                    issueType: 'MFI Out of Spec',
                    description: 'Sample Zak #05 nilai MFI Average 21.50 g/10min melebihi batas atas spec (18.0) & dispersi terdeteksi bintik merah.',
                    actionRequired: 'Hentikan sementara Extruder E-01 & bersihkan die zone 4',
                    status: 'RECEIVED'
                }
            ],

            ncForm: {
                foreman: 'Budi S. (Kepala Shift / Foreman RED)',
                issueType: 'Dispersi Bintik / Kontaminasi',
                description: '',
                actionRequired: 'Hentikan sementara Extruder & bersihkan die zone 4',
                isUrgent: true
            },

            get hasNonConformance() {
                return this.disperseLogs.some(r => r.status === 'REJECT') || this.physicalLogs.some(r => r.status === 'REJECT');
            },

            get latestNcDetails() {
                let rejDis = this.disperseLogs.find(r => r.status === 'REJECT');
                let rejPhy = this.physicalLogs.find(r => r.status === 'REJECT');
                if (rejDis) return `[Dispersi ${rejDis.jam}] Rating ${rejDis.rating}/5 - ${rejDis.notes}`;
                if (rejPhy) return `[Physical Test ${rejPhy.noZak}] MFI Avg: ${rejPhy.avgMfi} - ${rejPhy.note}`;
                return 'Terdeteksi parameter out-of-spec pada sampel QC.';
            },

            openNcModal(presetData = null) {
                if (presetData) {
                    if (presetData.issueType) this.ncForm.issueType = presetData.issueType;
                    if (presetData.description) this.ncForm.description = presetData.description;
                }
                this.showNcModal = true;
            },

            sendNcAlertToForeman() {
                if (!this.ncForm.description.trim()) {
                    alert('Mohon isi deskripsi temuan ketidaksesuaian!');
                    return;
                }

                let timeStr = new Date().toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' }) + ' WIB';
                
                this.ncLogs.unshift({
                    timestamp: timeStr,
                    spkId: this.selectedSpkId,
                    product: this.selectedSpk.product,
                    foreman: this.ncForm.foreman,
                    issueType: this.ncForm.issueType,
                    description: this.ncForm.description,
                    actionRequired: this.ncForm.actionRequired,
                    status: 'RECEIVED'
                });

                this.ncAlertSent = true;
                this.showNcModal = false;

                alert(`🚨 ALERT BERHASIL DIKIRIM KE FOREMAN!\n\nPenerima: ${this.ncForm.foreman}\nJenis NC: ${this.ncForm.issueType}\nTindakan: ${this.ncForm.actionRequired}\n\nForeman menerima notifikasi darurat secara real-time.`);
                
                this.activeQcTab = 'nc_logs';
            }
        }));
    });
</script>
@endsection
