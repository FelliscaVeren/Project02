@extends('layouts.app')

@section('title', 'QC Inspection & Physical Test Monitoring')

@section('content')
<div class="w-full px-4 sm:px-6 lg:px-8 min-h-full pb-16" x-data="qcMonitoringApp()">

    <!-- Header Page & Selector SPK -->
    <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm mb-6 flex flex-wrap items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="px-2.5 py-1 bg-indigo-100 text-indigo-800 font-extrabold text-[10px] rounded-full uppercase tracking-wider border border-indigo-200">Quality Control (QC)</span>
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
            <div class="flex flex-col gap-2 shrink-0">
                <button @click="openNcModal()" class="px-4 py-2 bg-rose-700 hover:bg-rose-800 text-white font-bold text-xs rounded-xl shadow transition flex items-center justify-center gap-1.5 w-full">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                    Kirim Laporan ke Foreman
                </button>
                <button @click="openPenangananModal()" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs rounded-xl shadow transition flex items-center justify-center gap-1.5 w-full">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                    Penanganan Produk
                </button>
            </div>
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
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2">Label Status QC</p>
            <div class="space-y-1.5">
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 flex-shrink-0"></span>
                    <span class="px-2.5 py-1 bg-emerald-100 text-emerald-800 border border-emerald-200 text-[10px] font-extrabold rounded-full">PASS</span>
                    <span class="text-[10px] text-slate-500">Produk lolos standar</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-amber-500 flex-shrink-0"></span>
                    <span class="px-2.5 py-1 bg-amber-100 text-amber-800 border border-amber-200 text-[10px] font-extrabold rounded-full">HOLD</span>
                    <span class="text-[10px] text-slate-500">Perlu evaluasi lanjut</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-slate-500 flex-shrink-0"></span>
                    <span class="px-2.5 py-1 bg-slate-100 text-slate-700 border border-slate-300 text-[10px] font-extrabold rounded-full">REJECT</span>
                    <span class="text-[10px] text-slate-500">Tidak sesuai spesifikasi</span>
                </div>
            </div>
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
                    <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                    3. Riwayat Laporan ke Foreman
                </button>
                <button @click="activeQcTab = 'qc_form'" :class="activeQcTab === 'qc_form' ? 'bg-white text-navy shadow-sm font-extrabold border-slate-200' : 'text-slate-500 font-semibold hover:text-slate-800'" class="px-4 py-2.5 text-xs rounded-xl border transition flex items-center gap-2">
                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    4. Form Monitoring Kualitas
                </button>
                <button @click="activeQcTab = 'goods_check'" :class="activeQcTab === 'goods_check' ? 'bg-white text-navy shadow-sm font-extrabold border-slate-200' : 'text-slate-500 font-semibold hover:text-slate-800'" class="px-4 py-2.5 text-xs rounded-xl border transition flex items-center gap-2">
                    <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    5. QC Goods Check (KPI Bagging)
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

            <!-- Form Input Dispersi Baru -->
            <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm relative overflow-hidden mb-6">
                <div class="absolute top-0 left-0 w-1 h-full bg-navy"></div>
                <h4 class="text-xs font-bold text-slate-500 uppercase tracking-widest mb-4 flex items-center gap-2">
                    <span class="w-1.5 h-1.5 rounded-full bg-navy"></span>
                    INPUT HASIL PENGECEKAN DISPERSI JAM BARU
                </h4>
                
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                    <div>
                        <label class="block text-[10px] font-bold text-slate-500 mb-1">Jam Pengecekan <span class="text-rose-500">*</span></label>
                        <select class="w-full bg-white border border-slate-200 rounded-lg px-3 py-2 text-xs font-bold text-navy focus:ring-2 focus:ring-cyan outline-none">
                            <option>13:00 WIB</option>
                            <option>14:00 WIB</option>
                            <option>15:00 WIB</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-500 mb-1">Pengecekan Visual</label>
                        <input type="text" value="Bebas aglomerat" class="w-full bg-white border border-slate-200 rounded-lg px-3 py-2 text-xs text-navy focus:ring-2 focus:ring-cyan outline-none">
                    </div>
                    <div x-data="{ statusQc: 'PASS' }">
                        <label class="block text-[10px] font-bold text-slate-500 mb-1">Status QC <span class="text-rose-500">*</span></label>
                        <select x-model="statusQc"
                            :class="{
                                'bg-emerald-50 border-emerald-400 text-emerald-700 focus:ring-emerald-500': statusQc === 'PASS',
                                'bg-amber-50 border-amber-400 text-amber-700 focus:ring-amber-500': statusQc === 'HOLD',
                                'bg-rose-50 border-rose-400 text-rose-700 focus:ring-rose-500': statusQc === 'REJECT'
                            }"
                            class="w-full border rounded-lg px-3 py-2 text-xs font-bold focus:ring-2 outline-none transition-all">
                            <option value="PASS">PASS</option>
                            <option value="HOLD">HOLD</option>
                            <option value="REJECT">REJECT</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-500 mb-1">Catatan QC</label>
                        <select class="w-full bg-white border border-slate-200 rounded-lg px-3 py-2 text-xs font-bold text-navy focus:ring-2 focus:ring-cyan outline-none">
                            <option value="Ok">✓ Ok</option>
                            <option value="NG">✗ NG</option>
                        </select>
                    </div>
                </div>
                
                <div class="mt-4 flex justify-end">
                    <button class="px-5 py-2.5 bg-navy hover:bg-navy-light text-white text-xs font-bold rounded-xl shadow-md transition flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Simpan Hasil Dispersi Jam Ini
                    </button>
                </div>
            </div>

            <!-- Visual Check Extruder (Saat Running & Hasil Akhir) -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <!-- Panel: Visual Check Saat Running -->
                <div x-data="{ vc: { melt: 'Ok', bintik: 'Ok', homo: 'Ok', tekanan: 'Ok', permukaan: 'Ok' } }"
                     :class="Object.values(vc).some(v => v === 'NG') ? 'bg-gradient-to-br from-rose-50 to-white border-rose-200' : 'bg-gradient-to-br from-cyan/5 to-white border-cyan/30'"
                     class="border rounded-2xl p-5 shadow-sm transition-all duration-300">
                    <div class="flex items-center gap-2 mb-4 pb-3"
                         :class="Object.values(vc).some(v => v === 'NG') ? 'border-b border-rose-200' : 'border-b border-cyan/20'">
                        <span class="w-7 h-7 rounded-lg flex items-center justify-center font-black text-xs transition-all"
                              :class="Object.values(vc).some(v => v === 'NG') ? 'bg-rose-100 text-rose-600' : 'bg-cyan/20 text-cyan'">▶</span>
                        <div>
                            <h4 class="font-bold text-sm text-navy">Visual Check — Saat Running</h4>
                            <p class="text-[10px] text-slate-400 mt-0.5">Pengecekan visual selama proses ekstrusi berlangsung</p>
                        </div>
                    </div>
                    <div class="space-y-2.5">
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-slate-600 font-medium">Warna Lelehan (Melt Color)</span>
                            <div class="flex gap-1.5">
                                <button @click="vc.melt = 'Ok'" :class="vc.melt === 'Ok' ? 'bg-emerald-500 text-white shadow border-emerald-500' : 'bg-slate-100 text-slate-500 hover:bg-emerald-100'" class="px-3 py-1 rounded-lg text-[10px] font-bold transition-all border border-transparent">✓</button>
                                <button @click="vc.melt = 'NG'" :class="vc.melt === 'NG' ? 'bg-rose-500 text-white shadow' : 'bg-slate-100 text-slate-500 hover:bg-rose-100'" class="px-3 py-1 rounded-lg text-[10px] font-bold transition-all">✗</button>
                            </div>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-slate-600 font-medium">Bintik / Kontaminan</span>
                            <div class="flex gap-1.5">
                                <button @click="vc.bintik = 'Ok'" :class="vc.bintik === 'Ok' ? 'bg-emerald-500 text-white shadow border-emerald-500' : 'bg-slate-100 text-slate-500 hover:bg-emerald-100'" class="px-3 py-1 rounded-lg text-[10px] font-bold transition-all border border-transparent">✓</button>
                                <button @click="vc.bintik = 'NG'" :class="vc.bintik === 'NG' ? 'bg-rose-500 text-white shadow' : 'bg-slate-100 text-slate-500 hover:bg-rose-100'" class="px-3 py-1 rounded-lg text-[10px] font-bold transition-all">✗</button>
                            </div>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-slate-600 font-medium">Homogenitas Dispersi</span>
                            <div class="flex gap-1.5">
                                <button @click="vc.homo = 'Ok'" :class="vc.homo === 'Ok' ? 'bg-emerald-500 text-white shadow border-emerald-500' : 'bg-slate-100 text-slate-500 hover:bg-emerald-100'" class="px-3 py-1 rounded-lg text-[10px] font-bold transition-all border border-transparent">✓</button>
                                <button @click="vc.homo = 'NG'" :class="vc.homo === 'NG' ? 'bg-rose-500 text-white shadow' : 'bg-slate-100 text-slate-500 hover:bg-rose-100'" class="px-3 py-1 rounded-lg text-[10px] font-bold transition-all">✗</button>
                            </div>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-slate-600 font-medium">Tekanan Die / Output Stabil</span>
                            <div class="flex gap-1.5">
                                <button @click="vc.tekanan = 'Ok'" :class="vc.tekanan === 'Ok' ? 'bg-emerald-500 text-white shadow border-emerald-500' : 'bg-slate-100 text-slate-500 hover:bg-emerald-100'" class="px-3 py-1 rounded-lg text-[10px] font-bold transition-all border border-transparent">✓</button>
                                <button @click="vc.tekanan = 'NG'" :class="vc.tekanan === 'NG' ? 'bg-rose-500 text-white shadow' : 'bg-slate-100 text-slate-500 hover:bg-rose-100'" class="px-3 py-1 rounded-lg text-[10px] font-bold transition-all">✗</button>
                            </div>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-slate-600 font-medium">Permukaan Granula (Smooth)</span>
                            <div class="flex gap-1.5">
                                <button @click="vc.permukaan = 'Ok'" :class="vc.permukaan === 'Ok' ? 'bg-emerald-500 text-white shadow border-emerald-500' : 'bg-slate-100 text-slate-500 hover:bg-emerald-100'" class="px-3 py-1 rounded-lg text-[10px] font-bold transition-all border border-transparent">✓</button>
                                <button @click="vc.permukaan = 'NG'" :class="vc.permukaan === 'NG' ? 'bg-rose-500 text-white shadow' : 'bg-slate-100 text-slate-500 hover:bg-rose-100'" class="px-3 py-1 rounded-lg text-[10px] font-bold transition-all">✗</button>
                            </div>
                        </div>
                    </div>
                    <!-- Summary Badge Otomatis -->
                    <div class="mt-3 pt-3 flex justify-between items-center"
                         :class="Object.values(vc).some(v => v === 'NG') ? 'border-t border-rose-100' : 'border-t border-cyan/10'">
                        <span class="text-[10px] text-slate-400">Dicatat oleh: <b class="text-slate-600">Hendra (QC)</b></span>
                        <template x-if="!Object.values(vc).some(v => v === 'NG')">
                            <span class="px-2.5 py-1 bg-emerald-100 text-emerald-700 text-[10px] font-extrabold rounded-full flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                Running OK
                            </span>
                        </template>
                        <template x-if="Object.values(vc).some(v => v === 'NG')">
                            <span class="px-2.5 py-1 bg-rose-100 text-rose-700 text-[10px] font-extrabold rounded-full flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/></svg>
                                Running NG
                            </span>
                        </template>
                    </div>
                </div>

                <!-- Panel: Hasil Akhir (Released) -->
                <div x-data="{ ha: { warna: 'Ok', ukuran: 'Ok', aglomerat: 'Ok', serbuk: 'Ok', kontaminasi: 'Ok' } }"
                     :class="Object.values(ha).some(v => v === 'NG') ? 'bg-gradient-to-br from-rose-50 to-white border-rose-200' : 'bg-gradient-to-br from-emerald-50 to-white border-emerald-200'"
                     class="border rounded-2xl p-5 shadow-sm transition-all duration-300">
                    <div class="flex items-center gap-2 mb-4 pb-3"
                         :class="Object.values(ha).some(v => v === 'NG') ? 'border-b border-rose-100' : 'border-b border-emerald-100'">
                        <span class="w-7 h-7 rounded-lg flex items-center justify-center font-black text-xs transition-all"
                              :class="Object.values(ha).some(v => v === 'NG') ? 'bg-rose-100 text-rose-600' : 'bg-emerald-100 text-emerald-700'"
                              x-text="Object.values(ha).some(v => v === 'NG') ? '✗' : '✓'">✓</span>
                        <div>
                            <h4 class="font-bold text-sm text-navy">Hasil Akhir — Released</h4>
                            <p class="text-[10px] text-slate-400 mt-0.5">Pengecekan produk yang siap dilepas / di-release</p>
                        </div>
                    </div>
                    <div class="space-y-2.5">
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-slate-600 font-medium">Warna Granula Seragam</span>
                            <div class="flex gap-1.5">
                                <button @click="ha.warna = 'Ok'" :class="ha.warna === 'Ok' ? 'bg-emerald-500 text-white shadow border-emerald-500' : 'bg-slate-100 text-slate-500 hover:bg-emerald-100'" class="px-3 py-1 rounded-lg text-[10px] font-bold transition-all border border-transparent">✓</button>
                                <button @click="ha.warna = 'NG'" :class="ha.warna === 'NG' ? 'bg-rose-500 text-white shadow' : 'bg-slate-100 text-slate-500 hover:bg-rose-100'" class="px-3 py-1 rounded-lg text-[10px] font-bold transition-all">✗</button>
                            </div>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-slate-600 font-medium">Ukuran Granula Seragam</span>
                            <div class="flex gap-1.5">
                                <button @click="ha.ukuran = 'Ok'" :class="ha.ukuran === 'Ok' ? 'bg-emerald-500 text-white shadow border-emerald-500' : 'bg-slate-100 text-slate-500 hover:bg-emerald-100'" class="px-3 py-1 rounded-lg text-[10px] font-bold transition-all border border-transparent">✓</button>
                                <button @click="ha.ukuran = 'NG'" :class="ha.ukuran === 'NG' ? 'bg-rose-500 text-white shadow' : 'bg-slate-100 text-slate-500 hover:bg-rose-100'" class="px-3 py-1 rounded-lg text-[10px] font-bold transition-all">✗</button>
                            </div>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-slate-600 font-medium">Bebas Aglomerat / Bintik</span>
                            <div class="flex gap-1.5">
                                <button @click="ha.aglomerat = 'Ok'" :class="ha.aglomerat === 'Ok' ? 'bg-emerald-500 text-white shadow border-emerald-500' : 'bg-slate-100 text-slate-500 hover:bg-emerald-100'" class="px-3 py-1 rounded-lg text-[10px] font-bold transition-all border border-transparent">✓</button>
                                <button @click="ha.aglomerat = 'NG'" :class="ha.aglomerat === 'NG' ? 'bg-rose-500 text-white shadow' : 'bg-slate-100 text-slate-500 hover:bg-rose-100'" class="px-3 py-1 rounded-lg text-[10px] font-bold transition-all">✗</button>
                            </div>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-slate-600 font-medium">Kandungan Serbuk Minimal</span>
                            <div class="flex gap-1.5">
                                <button @click="ha.serbuk = 'Ok'" :class="ha.serbuk === 'Ok' ? 'bg-emerald-500 text-white shadow border-emerald-500' : 'bg-slate-100 text-slate-500 hover:bg-emerald-100'" class="px-3 py-1 rounded-lg text-[10px] font-bold transition-all border border-transparent">✓</button>
                                <button @click="ha.serbuk = 'NG'" :class="ha.serbuk === 'NG' ? 'bg-rose-500 text-white shadow' : 'bg-slate-100 text-slate-500 hover:bg-rose-100'" class="px-3 py-1 rounded-lg text-[10px] font-bold transition-all">✗</button>
                            </div>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-slate-600 font-medium">Tidak Ada Kontaminasi Asing</span>
                            <div class="flex gap-1.5">
                                <button @click="ha.kontaminasi = 'Ok'" :class="ha.kontaminasi === 'Ok' ? 'bg-emerald-500 text-white shadow border-emerald-500' : 'bg-slate-100 text-slate-500 hover:bg-emerald-100'" class="px-3 py-1 rounded-lg text-[10px] font-bold transition-all border border-transparent">✓</button>
                                <button @click="ha.kontaminasi = 'NG'" :class="ha.kontaminasi === 'NG' ? 'bg-rose-500 text-white shadow' : 'bg-slate-100 text-slate-500 hover:bg-rose-100'" class="px-3 py-1 rounded-lg text-[10px] font-bold transition-all">✗</button>
                            </div>
                        </div>
                    </div>
                    <!-- Summary Badge Otomatis -->
                    <div class="mt-3 pt-3 flex justify-between items-center"
                         :class="Object.values(ha).some(v => v === 'NG') ? 'border-t border-rose-100' : 'border-t border-emerald-100'">
                        <span class="text-[10px] text-slate-400">Status Release:</span>
                        <template x-if="!Object.values(ha).some(v => v === 'NG')">
                            <span class="px-2.5 py-1 bg-emerald-500 text-white text-[10px] font-extrabold rounded-full flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                RELEASED
                            </span>
                        </template>
                        <template x-if="Object.values(ha).some(v => v === 'NG')">
                            <span class="px-2.5 py-1 bg-rose-600 text-white text-[10px] font-extrabold rounded-full flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/></svg>
                                NOT RELEASED
                            </span>
                        </template>
                    </div>
                </div>
            </div>

            <!-- Filter Log Dispersi (PPIC View) -->
            <div class="bg-slate-50 border border-slate-200 rounded-2xl p-4 flex items-center justify-between gap-4">
                <div class="flex-1">
                    <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1">Cari / Filter Log Dispersi</label>
                    <div class="relative">
                        <input type="text" x-model="searchDisperse" placeholder="Cari berdasarkan catatan, inspektur, atau jam..." class="w-full bg-white border border-slate-200 rounded-xl py-2 pl-9 pr-4 text-xs text-navy outline-none focus:ring-cyan focus:border-cyan">
                        <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                </div>
                <div class="w-48 shrink-0">
                    <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1">Filter Status QC</label>
                    <select x-model="filterDisperseStatus" class="w-full bg-white border border-slate-200 rounded-xl p-2 text-xs text-navy font-bold outline-none focus:ring-cyan focus:border-cyan">
                        <option value="">Semua Status</option>
                        <option value="PASS">Hanya PASS (Hijau)</option>
                        <option value="HOLD">Hanya HOLD (Kuning)</option>
                        <option value="REJECT">Hanya REJECT (Merah)</option>
                    </select>
                </div>
            </div>

            <!-- Tabel Log Dispersi 1 Jam -->
            <div class="overflow-x-auto border border-slate-200 rounded-2xl">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-100 text-slate-700 font-bold uppercase tracking-wider text-[10px] border-b border-slate-200">
                        <tr>
                            <th class="p-3">Tanggal</th>
                            <th class="p-3">Jam Pengecekan</th>
                            <th class="p-3">Visual</th>
                            <th class="p-3 text-center">Status QC</th>
                            <th class="p-3">Catatan QC</th>
                            <th class="p-3">Inspector QC</th>
                            <th class="p-3 text-right">Aksi Penanganan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <template x-for="(row, idx) in filteredDisperseLogs" :key="idx">
                            <tr :class="{
                                'bg-emerald-50/40': row.status === 'PASS',
                                'bg-amber-50/50': row.status === 'HOLD',
                                'bg-rose-50/60': row.status === 'REJECT'
                            }">
                                <td class="p-3 font-semibold text-slate-500" x-text="row.tanggal"></td>
                                <td class="p-3 font-bold text-navy" x-text="row.jam + ' WIB'"></td>
                                <td class="p-3 text-slate-700 font-medium" x-text="row.visual"></td>
                                <td class="p-3 text-center">
                                    <template x-if="row.status === 'PASS'">
                                        <span class="inline-block px-2.5 py-1 bg-emerald-100 text-emerald-800 border border-emerald-300 rounded-full font-black text-[10px]">✓ PASS</span>
                                    </template>
                                    <template x-if="row.status === 'HOLD'">
                                        <span class="inline-block px-2.5 py-1 bg-amber-100 text-amber-800 border border-amber-300 rounded-full font-black text-[10px]">⚠ HOLD</span>
                                    </template>
                                    <template x-if="row.status === 'REJECT'">
                                        <span class="inline-block px-2.5 py-1 bg-slate-100 text-slate-700 border border-slate-300 rounded-full font-black text-[10px]">✕ REJECT</span>
                                    </template>
                                </td>
                                <td class="p-3 font-medium">
                                    <template x-if="row.status === 'REJECT'">
                                        <span class="text-slate-700 font-bold bg-slate-100 px-2 py-1 rounded border border-slate-200" x-text="row.notes"></span>
                                    </template>
                                    <template x-if="row.status !== 'REJECT'">
                                        <span class="text-slate-600" x-text="row.notes || '-'"></span>
                                    </template>
                                </td>
                                <td class="p-3 font-semibold text-slate-700" x-text="row.inspector"></td>
                                <td class="p-3 text-right">
                                    <template x-if="row.status === 'REJECT' || row.status === 'HOLD'">
                                        <button @click="openNcModal(row)" class="px-2.5 py-1 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-[11px] rounded-lg shadow-sm transition inline-flex items-center gap-1">
                                            📋 Laporkan
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

            <!-- Filter Physical Test (PPIC View) -->
            <div class="bg-slate-50 border border-slate-200 rounded-2xl p-4 flex items-center justify-between gap-4">
                <div class="flex-1">
                    <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1">Cari / Filter Log Physical Test</label>
                    <div class="relative">
                        <input type="text" x-model="searchPhysical" placeholder="Cari berdasarkan No. Zak, Lot, atau catatan..." class="w-full bg-white border border-slate-200 rounded-xl py-2 pl-9 pr-4 text-xs text-navy outline-none focus:ring-cyan focus:border-cyan">
                        <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                </div>
                <div class="w-48 shrink-0">
                    <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1">Filter Status QC</label>
                    <select x-model="filterPhysicalStatus" class="w-full bg-white border border-slate-200 rounded-xl p-2 text-xs text-navy font-bold outline-none focus:ring-cyan focus:border-cyan">
                        <option value="">Semua Status</option>
                        <option value="PASS">Hanya PASS (Hijau)</option>
                        <option value="HOLD">Hanya HOLD (Kuning)</option>
                        <option value="REJECT">Hanya REJECT (Merah)</option>
                    </select>
                </div>
            </div>

            <!-- Form Input Baris Baru Physical Test -->
            <div class="mb-4" x-data="physicalInputApp()">
                <div class="flex items-center justify-between mb-3">
                    <h4 class="text-xs font-bold text-slate-500 uppercase tracking-widest flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-navy"></span>
                        INPUT DATA PHYSICAL & MECHANICAL TEST
                    </h4>
                    <button @click="addRow()" class="px-4 py-2 bg-navy hover:bg-navy-light text-white text-xs font-bold rounded-xl shadow-md transition flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Tambah Baris
                    </button>
                </div>

                <!-- TABEL PHYSICAL & MECHANICAL TEST -->
                <div class="overflow-x-auto border border-slate-300 rounded-2xl shadow-sm bg-white">
                    <table class="w-full text-center text-xs border-collapse font-sans">
                        <thead class="bg-amber-100 text-slate-900 border-b-2 border-slate-400 font-bold text-[10px]">
                            <tr class="divide-x divide-slate-300">
                                <th rowspan="2" class="p-2 border-b border-slate-300 bg-amber-200">No</th>
                                <th rowspan="2" class="p-2 border-b border-slate-300 bg-amber-200 min-w-[70px]">No. Zak</th>
                                <th colspan="2" class="p-2 border-b border-slate-300 bg-amber-200">Measurement</th>
                                <th rowspan="2" class="p-2 border-b border-slate-300 bg-amber-200 min-w-[90px]">Lot Number</th>
                                <th colspan="2" class="p-2 border-b border-slate-300 bg-amber-200">Moisture</th>
                                <th colspan="2" class="p-2 border-b border-slate-300 bg-amber-200">Specific Gravity</th>
                                <th colspan="9" class="p-2 border-b border-slate-300 bg-amber-200">Melt Flow Index (MFI)</th>
                                <th rowspan="2" class="p-2 border-b border-slate-300 bg-amber-200 min-w-[110px]">Status QC</th>
                                <th rowspan="2" class="p-2 border-b border-slate-300 bg-amber-200 min-w-[130px]">Note</th>
                                <th rowspan="2" class="p-2 border-b border-slate-300 bg-amber-200 min-w-[80px]">Analysed by</th>
                                <th rowspan="2" class="p-2 border-b border-slate-300 bg-amber-200 min-w-[80px]">Reviewed by</th>
                                <th rowspan="2" class="p-2 border-b border-slate-300 bg-amber-200">Aksi</th>
                            </tr>
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
                                <th class="p-1 bg-amber-300 text-slate-900 font-extrabold">Avg MFI</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 text-slate-800 text-[11px]">

                            <!-- Baris Input Baru (Editable) -->
                            <template x-for="(row, idx) in inputRows" :key="row.id">
                                <tr class="divide-x divide-slate-200 bg-blue-50/60 border-b-2 border-blue-200">
                                    <td class="p-1.5 font-bold text-slate-500 text-center" x-text="savedRows.length + idx + 1"></td>
                                    <td class="p-1"><input type="text" x-model="row.noZak" placeholder="Zak-01" class="w-16 text-center bg-white border border-slate-300 rounded px-1.5 py-1 text-[11px] font-bold text-navy outline-none focus:border-blue-400 focus:ring-1 focus:ring-blue-300"></td>
                                    <td class="p-1"><input type="time" x-model="row.time" class="w-20 text-center bg-white border border-slate-300 rounded px-1 py-1 text-[11px] outline-none focus:border-blue-400 focus:ring-1 focus:ring-blue-300"></td>
                                    <td class="p-1"><input type="date" x-model="row.date" class="w-24 text-center bg-white border border-slate-300 rounded px-1 py-1 text-[11px] outline-none focus:border-blue-400 focus:ring-1 focus:ring-blue-300"></td>
                                    <td class="p-1"><input type="text" x-model="row.lotNumber" placeholder="LOT-001" class="w-20 text-center bg-white border border-slate-300 rounded px-1.5 py-1 text-[11px] font-mono outline-none focus:border-blue-400 focus:ring-1 focus:ring-blue-300"></td>
                                    <!-- Moisture -->
                                    <td class="p-1"><input type="text" inputmode="numeric" :value="row.moistureMass" @keydown="filterKey($event)" @input="row.moistureMass = autoDecimal($event.target, 2)" placeholder="0.00" class="w-14 text-center bg-white border border-slate-300 rounded px-1 py-1 text-[11px] font-mono outline-none focus:border-blue-400 focus:ring-1 focus:ring-blue-300"></td>
                                    <td class="p-1">
                                        <input type="number" x-model="row.moistureVal" step="0.001" placeholder="0.000"
                                            :class="parseFloat(row.moistureVal) > 0.10 ? 'border-rose-400 bg-rose-50 text-rose-700 font-black' : 'border-slate-300 bg-white'"
                                            class="w-16 text-center border rounded px-1 py-1 text-[11px] outline-none focus:ring-1 focus:ring-blue-300">
                                    </td>
                                    <!-- SG -->
                                    <td class="p-1"><input type="text" inputmode="numeric" :value="row.sgMass" @keydown="filterKey($event)" @input="row.sgMass = autoDecimal($event.target, 2)" placeholder="0.00" class="w-14 text-center bg-white border border-slate-300 rounded px-1 py-1 text-[11px] font-mono outline-none focus:border-blue-400 focus:ring-1 focus:ring-blue-300"></td>
                                    <td class="p-1"><input type="text" inputmode="numeric" :value="row.sgVal" @keydown="filterKey($event)" @input="row.sgVal = autoDecimal($event.target, 3)" placeholder="0.000" class="w-16 text-center bg-white border border-slate-300 rounded px-1 py-1 text-[11px] font-mono outline-none focus:border-blue-400 focus:ring-1 focus:ring-blue-300"></td>
                                    <!-- MFI -->
                                    <td class="p-1"><input type="number" x-model="row.temp" placeholder="190" class="w-12 text-center bg-white border border-slate-300 rounded px-1 py-1 text-[11px] outline-none focus:border-blue-400 focus:ring-1 focus:ring-blue-300"></td>
                                    <td class="p-1"><input type="number" x-model="row.cutTime" placeholder="10" class="w-12 text-center bg-white border border-slate-300 rounded px-1 py-1 text-[11px] outline-none focus:border-blue-400 focus:ring-1 focus:ring-blue-300"></td>
                                    <td class="p-1"><input type="text" inputmode="numeric" :value="row.cut1Mass" @keydown="filterKey($event)" @input="row.cut1Mass = autoDecimal($event.target, 4)" placeholder="0.0000" class="w-16 text-center bg-white border border-slate-300 rounded px-1 py-1 text-[11px] font-mono outline-none focus:border-blue-400 focus:ring-1 focus:ring-blue-300"></td>
                                    <td class="p-1 font-bold text-slate-700" x-text="calcMfi(row.cut1Mass, row.cutTime) || '-'"></td>
                                    <td class="p-1"><input type="text" inputmode="numeric" :value="row.cut2Mass" @keydown="filterKey($event)" @input="row.cut2Mass = autoDecimal($event.target, 4)" placeholder="0.0000" class="w-16 text-center bg-white border border-slate-300 rounded px-1 py-1 text-[11px] font-mono outline-none focus:border-blue-400 focus:ring-1 focus:ring-blue-300"></td>
                                    <td class="p-1 font-bold text-slate-700" x-text="calcMfi(row.cut2Mass, row.cutTime) || '-'"></td>
                                    <td class="p-1"><input type="text" inputmode="numeric" :value="row.cut3Mass" @keydown="filterKey($event)" @input="row.cut3Mass = autoDecimal($event.target, 4)" placeholder="0.0000" class="w-16 text-center bg-white border border-slate-300 rounded px-1 py-1 text-[11px] font-mono outline-none focus:border-blue-400 focus:ring-1 focus:ring-blue-300"></td>
                                    <td class="p-1 font-bold text-slate-700" x-text="calcMfi(row.cut3Mass, row.cutTime) || '-'"></td>
                                    <!-- Avg MFI auto-calculated -->
                                    <td class="p-1.5 font-black"
                                        :class="calcAvgMfi(row) > 18.0 ? 'text-rose-600 bg-rose-100' : calcAvgMfi(row) > 0 ? 'text-navy bg-amber-50' : 'text-slate-400 bg-slate-50'"
                                        x-text="calcAvgMfi(row) > 0 ? calcAvgMfi(row) : '—'"></td>
                                    <!-- Status QC -->
                                    <td class="p-1">
                                        <select x-model="row.status"
                                            :class="{
                                                'bg-emerald-50 border-emerald-400 text-emerald-700': row.status === 'PASS',
                                                'bg-amber-50 border-amber-400 text-amber-700': row.status === 'HOLD',
                                                'bg-rose-50 border-rose-400 text-rose-700': row.status === 'REJECT'
                                            }"
                                            class="w-20 border rounded px-1 py-1 text-[10px] font-bold outline-none transition-all">
                                            <option value="PASS">PASS</option>
                                            <option value="HOLD">HOLD</option>
                                            <option value="REJECT">REJECT</option>
                                        </select>
                                    </td>
                                    <td class="p-1"><input type="text" x-model="row.note" placeholder="Catatan..." class="w-28 bg-white border border-slate-300 rounded px-1.5 py-1 text-[11px] outline-none focus:border-blue-400 focus:ring-1 focus:ring-blue-300"></td>
                                    <td class="p-1"><input type="text" x-model="row.analysedBy" placeholder="Nama" class="w-16 text-center bg-white border border-slate-300 rounded px-1 py-1 text-[11px] outline-none focus:border-blue-400 focus:ring-1 focus:ring-blue-300"></td>
                                    <td class="p-1"><input type="text" x-model="row.reviewedBy" placeholder="Nama" class="w-16 text-center bg-white border border-slate-300 rounded px-1 py-1 text-[11px] outline-none focus:border-blue-400 focus:ring-1 focus:ring-blue-300"></td>
                                    <td class="p-1 text-center">
                                        <div class="flex flex-col gap-1 items-center">
                                            <button @click="saveRow(idx)" class="px-2 py-1 bg-emerald-600 hover:bg-emerald-700 text-white text-[10px] font-bold rounded-lg shadow-sm transition">
                                                Simpan
                                            </button>
                                            <button @click="removeInputRow(idx)" class="px-2 py-1 bg-slate-200 hover:bg-rose-100 text-slate-600 hover:text-rose-600 text-[10px] font-bold rounded-lg transition">
                                                Hapus
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </template>

                            <!-- Baris Log yang Sudah Tersimpan -->
                            <template x-for="(row, idx) in filteredPhysicalLogs" :key="idx">
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
                                            <span class="inline-block px-2 py-0.5 bg-emerald-100 text-emerald-800 border border-emerald-300 rounded font-black text-[10px]">✓ PASS</span>
                                        </template>
                                        <template x-if="row.status === 'HOLD'">
                                            <span class="inline-block px-2 py-0.5 bg-amber-100 text-amber-800 border border-amber-300 rounded font-black text-[10px]">⚠️ HOLD</span>
                                        </template>
                                        <template x-if="row.status === 'REJECT'">
                                            <span class="inline-block px-2 py-0.5 bg-rose-100 text-rose-800 border border-rose-300 rounded font-black text-[10px]">✕ REJECT</span>
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
                                    <td class="p-2 text-center">
                                        <span class="text-[10px] text-emerald-600 font-bold">✓ Saved</span>
                                    </td>
                                </tr>
                            </template>

                            <!-- Empty state jika tidak ada data -->
                            <template x-if="filteredPhysicalLogs.length === 0 && inputRows.length === 0">
                                <tr>
                                    <td colspan="22" class="py-10 text-center text-xs text-slate-400">
                                        <div class="flex flex-col items-center gap-2">
                                            <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                            <span>Belum ada data. Klik <b>+ Tambah Baris</b> untuk mulai input.</span>
                                        </div>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
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
                    + Buat Laporan Ketidaksesuaian Baru
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
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-amber-50 text-amber-800 border border-amber-300 rounded-full font-bold text-xs shadow-sm">
                                            <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                                            ⏳ Diterima Foreman (In Action)
                                        </span>
                                    </template>
                                    <template x-if="nc.status === 'RESOLVED'">
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-50 text-emerald-800 border border-emerald-300 rounded-full font-bold text-xs shadow-sm">
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

        <!-- ============ TAB 4: FORM DIGITAL MONITORING KUALITAS (PAPERLESS) ============ -->
        <div x-show="activeQcTab === 'qc_form'" x-data="qcFormApp()" class="p-6 space-y-5">

            <!-- Header -->
            <div class="flex items-start justify-between border-b border-slate-100 pb-4">
                <div>
                    <h3 class="text-lg font-bold text-navy flex items-center gap-2">
                        📋 Form Digital Monitoring Kualitas Produk
                    </h3>
                    <p class="text-xs text-slate-500 mt-0.5">Isi form per pengecekan secara digital. Data tersimpan otomatis — tidak perlu kertas.</p>
                </div>
                <span class="px-3 py-1.5 bg-emerald-50 text-emerald-700 border border-emerald-200 text-[10px] font-bold rounded-xl">✓ Mode Paperless Aktif</span>
            </div>

            <!-- Step 1: Konteks Pengecekan -->
            <div class="bg-gradient-to-br from-slate-50 to-white border border-slate-200 rounded-2xl p-5 shadow-sm">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">● Langkah 1 — Konteks Pengecekan</p>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wide mb-1.5">Produk</label>
                        <input type="text" x-model="form.produk" placeholder="Nama produk..." class="w-full bg-white border border-slate-200 rounded-xl px-3 py-2 text-xs font-medium text-slate-800 outline-none focus:ring-2 focus:ring-emerald-400 focus:border-emerald-400 transition">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wide mb-1.5">Mesin</label>
                        <input type="text" x-model="form.mesin" placeholder="E-01, E-02..." class="w-full bg-white border border-slate-200 rounded-xl px-3 py-2 text-xs font-medium text-slate-800 outline-none focus:ring-2 focus:ring-emerald-400 focus:border-emerald-400 transition">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wide mb-1.5">Tanggal Real-Time</label>
                        <input type="date" x-model="form.tanggal" readonly class="w-full bg-slate-100 cursor-not-allowed border border-slate-200 rounded-xl px-3 py-2 text-xs font-bold text-emerald-800 outline-none transition" title="Tanggal otomatis hari ini (tidak dapat diubah)">
                        <p class="text-[9px] text-slate-400 mt-1">Otomatis hari ini</p>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wide mb-1.5">Jam & Analis QC</label>
                        <div class="flex items-center gap-2">
                            <span class="px-2.5 py-2 bg-emerald-100 text-emerald-900 border border-emerald-200 rounded-xl font-bold text-xs flex-shrink-0" x-text="form.jam"></span>
                            <input type="text" x-model="form.analis" placeholder="Nama QC..." class="w-full bg-white border border-slate-200 rounded-xl px-3 py-2 text-xs font-medium text-slate-800 outline-none focus:ring-2 focus:ring-emerald-400 focus:border-emerald-400 transition">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step 2: Pilih Shift & Jam -->
            <div class="bg-gradient-to-br from-navy/5 to-white border border-navy/10 rounded-2xl p-5 shadow-sm">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">● Langkah 2 — Pilih Shift & Jam Pengecekan</p>
                <div class="grid grid-cols-2 gap-5">
                    <!-- Shift Selector -->
                    <div>
                        <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wide mb-2.5">Shift</label>
                        <div class="flex gap-2">
                            <template x-for="s in [1,2,3]" :key="s">
                                <button @click="form.shift = s" :class="form.shift === s ? 'bg-navy text-white border-navy shadow-lg scale-105' : 'bg-white text-slate-600 border-slate-200 hover:border-navy/40'" class="flex-1 py-3 rounded-xl border-2 font-black text-sm transition-all duration-150">
                                    <span x-text="'Shift ' + s"></span>
                                </button>
                            </template>
                        </div>
                    </div>
                    <!-- Jam Selector -->
                    <div>
                        <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wide mb-2.5">Jam Ke (Interval per 2 Jam)</label>
                        <div class="flex gap-2">
                            <template x-for="j in [1,3,5,7]" :key="j">
                                <button @click="form.jamKe = j" :class="form.jamKe === j ? 'bg-cyan text-white border-cyan shadow-lg scale-105' : 'bg-white text-slate-600 border-slate-200 hover:border-cyan/40'" class="flex-1 py-3 rounded-xl border-2 font-black text-sm transition-all duration-150">
                                    <span x-text="'Jam ' + j"></span>
                                </button>
                            </template>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step 3: Parameter Input -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">

                <!-- A. Visual -->
                <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
                    <div class="flex items-center gap-2 mb-4 pb-3 border-b border-slate-100">
                        <span class="w-7 h-7 rounded-lg bg-blue-100 text-blue-700 flex items-center justify-center font-black text-xs">A</span>
                        <h4 class="font-bold text-sm text-slate-800">Visual Check</h4>
                    </div>
                    <div class="space-y-3">
                        <!-- Row helper: label + toggle -->
                        <template x-for="(item, key) in form.visual" :key="key">
                            <div class="flex items-center justify-between">
                                <span class="text-xs text-slate-600 font-medium" x-text="visualLabels[key]"></span>
                                <div class="flex gap-1.5">
                                    <button @click="form.visual[key] = 'OK'" :class="form.visual[key] === 'OK' ? 'bg-emerald-500 text-white shadow' : 'bg-slate-100 text-slate-500 hover:bg-emerald-100'" class="px-3 py-1 rounded-lg text-[10px] font-bold transition-all">✓</button>
                                    <button @click="form.visual[key] = 'NG'" :class="form.visual[key] === 'NG' ? 'bg-rose-500 text-white shadow' : 'bg-slate-100 text-slate-500 hover:bg-rose-100'" class="px-3 py-1 rounded-lg text-[10px] font-bold transition-all">✗</button>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- B. Test -->
                <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
                    <div class="flex items-center gap-2 mb-4 pb-3 border-b border-slate-100">
                        <span class="w-7 h-7 rounded-lg bg-violet-100 text-violet-700 flex items-center justify-center font-black text-xs">B</span>
                        <h4 class="font-bold text-sm text-slate-800">Test Produk</h4>
                    </div>
                    <div class="space-y-3">
                        <!-- Toggle tests -->
                        <template x-for="(item, key) in form.testToggle" :key="key">
                            <div class="flex items-center justify-between">
                                <span class="text-xs text-slate-600 font-medium" x-text="testToggleLabels[key]"></span>
                                <div class="flex gap-1.5">
                                    <button @click="form.testToggle[key] = 'OK'" :class="form.testToggle[key] === 'OK' ? 'bg-emerald-500 text-white shadow' : 'bg-slate-100 text-slate-500 hover:bg-emerald-100'" class="px-3 py-1 rounded-lg text-[10px] font-bold transition-all">✓</button>
                                    <button @click="form.testToggle[key] = 'NG'" :class="form.testToggle[key] === 'NG' ? 'bg-rose-500 text-white shadow' : 'bg-slate-100 text-slate-500 hover:bg-rose-100'" class="px-3 py-1 rounded-lg text-[10px] font-bold transition-all">✗</button>
                                </div>
                            </div>
                        </template>
                        <!-- Numeric inputs -->
                        <div>
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wide">Spectrophotometer (Delta E)</label>
                            <div class="flex items-center gap-2 mt-1">
                                <input type="number" step="0.01" x-model="form.deltaE" placeholder="0.00" class="flex-1 bg-slate-50 border border-slate-200 rounded-lg px-2.5 py-1.5 text-xs font-bold text-slate-800 outline-none focus:ring-2 focus:ring-violet-400 focus:border-violet-400 transition">
                                <span :class="parseFloat(form.deltaE) < 1 ? 'bg-emerald-100 text-emerald-700' : (form.deltaE === '' ? 'bg-slate-100 text-slate-400' : 'bg-rose-100 text-rose-700')" class="px-2.5 py-1 rounded-lg text-[10px] font-bold min-w-[40px] text-center transition-all">
                                    <span x-text="form.deltaE === '' ? '-' : (parseFloat(form.deltaE) < 1 ? 'PASS' : 'FAIL')"></span>
                                </span>
                            </div>
                            <p class="text-[9px] text-slate-400 mt-0.5">Std: Delta E &lt; 1 = PASS</p>
                        </div>
                        <div>
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wide">Moisture (%)</label>
                            <div class="flex items-center gap-2 mt-1">
                                <input type="number" step="0.01" x-model="form.moisture" placeholder="0.00" class="flex-1 bg-slate-50 border border-slate-200 rounded-lg px-2.5 py-1.5 text-xs font-bold text-slate-800 outline-none focus:ring-2 focus:ring-violet-400 focus:border-violet-400 transition">
                                <span :class="parseFloat(form.moisture) < 0.1 ? 'bg-emerald-100 text-emerald-700' : (form.moisture === '' ? 'bg-slate-100 text-slate-400' : 'bg-rose-100 text-rose-700')" class="px-2.5 py-1 rounded-lg text-[10px] font-bold min-w-[40px] text-center transition-all">
                                    <span x-text="form.moisture === '' ? '-' : (parseFloat(form.moisture) < 0.1 ? 'PASS' : 'FAIL')"></span>
                                </span>
                            </div>
                            <p class="text-[9px] text-slate-400 mt-0.5">Std: &lt; 0.1%</p>
                        </div>
                    </div>
                </div>

                <!-- C. Lain-lain + Kesimpulan -->
                <div class="space-y-4">
                    <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
                        <div class="flex items-center gap-2 mb-4 pb-3 border-b border-slate-100">
                            <span class="w-7 h-7 rounded-lg bg-amber-100 text-amber-700 flex items-center justify-center font-black text-xs">C</span>
                            <h4 class="font-bold text-sm text-slate-800">Lain-lain</h4>
                        </div>
                        <div class="space-y-3">
                            <div>
                                <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wide">Durasi Dryer (Jam)</label>
                                <input type="number" step="0.5" min="0" x-model="form.dryerJam" placeholder="0" class="mt-1 w-full bg-slate-50 border border-slate-200 rounded-lg px-2.5 py-1.5 text-xs font-bold text-slate-800 outline-none focus:ring-2 focus:ring-amber-400 focus:border-amber-400 transition">
                            </div>
                            <div>
                                <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wide">Inner Bags (Pcs)</label>
                                <input type="number" min="0" x-model="form.innerBags" placeholder="0" class="mt-1 w-full bg-slate-50 border border-slate-200 rounded-lg px-2.5 py-1.5 text-xs font-bold text-slate-800 outline-none focus:ring-2 focus:ring-amber-400 focus:border-amber-400 transition">
                            </div>
                        </div>
                    </div>

                    <!-- Kesimpulan -->
                    <div class="bg-white border-2 rounded-2xl p-5 shadow-sm transition-all" :class="overallStatus === 'OK' ? 'border-emerald-300 bg-emerald-50/30' : (overallStatus === 'NG' ? 'border-rose-300 bg-rose-50/30' : 'border-slate-200')">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="w-7 h-7 rounded-lg flex items-center justify-center font-black text-xs" :class="overallStatus === 'OK' ? 'bg-emerald-500 text-white' : (overallStatus === 'NG' ? 'bg-rose-500 text-white' : 'bg-slate-200 text-slate-500')">✓</span>
                            <h4 class="font-bold text-sm text-slate-800">Kesimpulan</h4>
                        </div>
                        <div class="flex gap-2 mb-3">
                            <button @click="form.kesimpulan = 'OK'" :class="form.kesimpulan === 'OK' ? 'bg-emerald-500 text-white shadow-md scale-105' : 'bg-white border border-slate-200 text-slate-600 hover:border-emerald-400'" class="flex-1 py-2.5 rounded-xl font-black text-sm transition-all">✅ OK</button>
                            <button @click="form.kesimpulan = 'NG'" :class="form.kesimpulan === 'NG' ? 'bg-rose-500 text-white shadow-md scale-105' : 'bg-white border border-slate-200 text-slate-600 hover:border-rose-400'" class="flex-1 py-2.5 rounded-xl font-black text-sm transition-all">❌ NG</button>
                        </div>
                        <p x-show="overallStatus === 'NG'" class="text-[10px] text-rose-600 font-bold bg-rose-100 rounded-lg px-2 py-1">⚠️ Ada parameter NG — pertimbangkan laporan ke Foreman.</p>
                        <p x-show="overallStatus === 'OK'" class="text-[10px] text-emerald-700 font-bold bg-emerald-100 rounded-lg px-2 py-1">✓ Semua parameter dalam batas standar.</p>
                    </div>
                </div>
            </div>

            <!-- Catatan -->
            <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Catatan / Observasi Tambahan</label>
                <textarea x-model="form.catatan" rows="2" placeholder="Tulis catatan observasi di sini (opsional)..." class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-xs text-slate-800 outline-none focus:ring-2 focus:ring-navy/30 focus:border-navy/30 transition resize-none"></textarea>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end">
                <button @click="submitForm()" class="px-6 py-3 bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 text-white font-black text-sm rounded-xl shadow-lg hover:shadow-xl transition-all duration-150 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                    Simpan Data Pengecekan
                </button>
            </div>

            <!-- Sukses Notif -->
            <div x-show="showSuccess" x-transition class="flex items-center gap-3 bg-emerald-50 border border-emerald-300 rounded-2xl px-5 py-3.5 shadow">
                <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <p class="text-xs font-bold text-emerald-800">Data pengecekan berhasil disimpan! Catatan tercatat di log di bawah.</p>
            </div>

            <!-- Log Riwayat Pengecekan Hari Ini -->
            <div x-show="logs.length > 0" class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm">
                <div class="bg-slate-50 border-b border-slate-100 px-5 py-3 flex items-center justify-between">
                    <h4 class="text-xs font-bold text-slate-700">📊 Log Pengecekan Hari Ini</h4>
                    <span class="text-[10px] font-bold text-slate-400" x-text="logs.length + ' entri'"></span>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-xs">
                        <thead class="bg-slate-100/70">
                            <tr class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">
                                <th class="text-left px-4 py-2.5">Waktu</th>
                                <th class="text-left px-4 py-2.5">Shift / Jam</th>
                                <th class="text-left px-4 py-2.5">Produk</th>
                                <th class="text-left px-4 py-2.5">Mesin</th>
                                <th class="text-center px-4 py-2.5">Visual</th>
                                <th class="text-center px-4 py-2.5">Test</th>
                                <th class="text-center px-4 py-2.5">Delta E</th>
                                <th class="text-center px-4 py-2.5">Moisture</th>
                                <th class="text-center px-4 py-2.5">Status</th>
                                <th class="text-left px-4 py-2.5">Analis</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <template x-for="(log, i) in logs" :key="i">
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="px-4 py-2.5 font-medium text-slate-500" x-text="log.timestamp"></td>
                                    <td class="px-4 py-2.5 font-bold text-navy" x-text="'Shift ' + log.shift + ' / Jam ' + log.jamKe"></td>
                                    <td class="px-4 py-2.5 text-slate-600" x-text="log.produk || '-'"></td>
                                    <td class="px-4 py-2.5 text-slate-600" x-text="log.mesin || '-'"></td>
                                    <td class="px-4 py-2.5 text-center">
                                        <span :class="log.visualAll === 'OK' ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800'" class="px-2 py-0.5 rounded-md font-bold" x-text="log.visualAll === 'OK' ? '✓' : '✗'"></span>
                                    </td>
                                    <td class="px-4 py-2.5 text-center">
                                        <span :class="log.testAll === 'OK' ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800'" class="px-2 py-0.5 rounded-md font-bold" x-text="log.testAll === 'OK' ? '✓' : '✗'"></span>
                                    </td>
                                    <td class="px-4 py-2.5 text-center font-bold text-slate-700" x-text="log.deltaE !== '' ? log.deltaE : '-'"></td>
                                    <td class="px-4 py-2.5 text-center font-bold text-slate-700" x-text="log.moisture !== '' ? log.moisture + '%' : '-'"></td>
                                    <td class="px-4 py-2.5 text-center">
                                        <span :class="log.kesimpulan === 'OK' ? 'bg-emerald-500 text-white' : 'bg-rose-500 text-white'" class="px-2.5 py-1 rounded-lg font-black text-[10px]" x-text="log.kesimpulan === 'OK' ? '✓ OK' : (log.kesimpulan === 'NG' ? '✗ NG' : (log.kesimpulan || '-'))"></span>
                                    </td>
                                    <td class="px-4 py-2.5 text-slate-600" x-text="log.analis || '-'"></td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- ============ TAB 5: QC GOODS CHECK (KPI BAGGING & KEMASAN AKHIR) ============ -->
        <div x-show="activeQcTab === 'goods_check'" x-data="qcGoodsCheckApp()" class="p-6 space-y-6">
            
            <!-- Header -->
            <div class="flex items-start justify-between border-b border-slate-100 pb-4">
                <div>
                    <h3 class="text-lg font-bold text-navy flex items-center gap-2">
                        📦 5. QC Goods Check & KPI Bagging (Pengujian Kemasan Akhir)
                    </h3>
                    <p class="text-xs text-slate-500 mt-0.5">Pengujian kualitas fisik akhir produk pada tahap bagging: seal jahitan, toleransi berat, label barcode & palletizing.</p>
                </div>
                <span class="px-3 py-1.5 bg-orange-50 text-orange-700 border border-orange-200 text-xs font-bold rounded-xl flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-orange-500 animate-pulse"></span>
                    Stage 5: Final Released Check
                </span>
            </div>

            <!-- KPI Ringkasan Widget Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="bg-gradient-to-br from-amber-500/10 to-orange-500/5 border border-amber-200/80 rounded-2xl p-4 shadow-sm">
                    <p class="text-[10px] font-bold text-amber-800 uppercase tracking-wider mb-1">Pass Rate KPI Bagging</p>
                    <div class="flex items-baseline justify-between">
                        <span class="text-2xl font-black text-amber-900">98.5%</span>
                        <span class="text-[10px] font-bold text-emerald-600 bg-emerald-100 px-2 py-0.5 rounded-full">✓ On Target (&gt;98%)</span>
                    </div>
                    <p class="text-[10px] text-amber-700 mt-1">Total 120 Zak Teruji Hari Ini</p>
                </div>

                <div class="bg-gradient-to-br from-blue-50 to-indigo-50 border border-blue-200/80 rounded-2xl p-4 shadow-sm">
                    <p class="text-[10px] font-bold text-blue-800 uppercase tracking-wider mb-1">Akurasi Berat Netto</p>
                    <div class="flex items-baseline justify-between">
                        <span class="text-2xl font-black text-blue-900">25.02 <span class="text-xs font-normal">kg</span></span>
                        <span class="text-[10px] font-bold text-blue-700 bg-blue-100 px-2 py-0.5 rounded-full">Toleransi ±0.05 kg</span>
                    </div>
                    <p class="text-[10px] text-blue-700 mt-1">Standar Kemasan 25.00 kg/Zak</p>
                </div>

                <div class="bg-gradient-to-br from-emerald-50 to-teal-50 border border-emerald-200/80 rounded-2xl p-4 shadow-sm">
                    <p class="text-[10px] font-bold text-emerald-800 uppercase tracking-wider mb-1">Kualitas Seal & Labeling</p>
                    <div class="flex items-baseline justify-between">
                        <span class="text-2xl font-black text-emerald-900">100% OK</span>
                        <span class="text-[10px] font-bold text-emerald-700 bg-emerald-100 px-2 py-0.5 rounded-full">0 Defect Seal</span>
                    </div>
                    <p class="text-[10px] text-emerald-700 mt-1">Bebas Bocor & Label Sesuai</p>
                </div>

                <div class="bg-gradient-to-br from-purple-50 to-indigo-50 border border-purple-200/80 rounded-2xl p-4 shadow-sm">
                    <p class="text-[10px] font-bold text-purple-800 uppercase tracking-wider mb-1">Status Pallet & Wrapping</p>
                    <div class="flex items-baseline justify-between">
                        <span class="text-2xl font-black text-purple-900">Rapi & Safe</span>
                        <span class="text-[10px] font-bold text-purple-700 bg-purple-100 px-2 py-0.5 rounded-full">Stretch Film OK</span>
                    </div>
                    <p class="text-[10px] text-purple-700 mt-1">Siap Transfer ke Gudang FG</p>
                </div>
            </div>

            <!-- Form Input Check KPI Bagging & Kemasan Akhir -->
            <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm space-y-4">
                <h4 class="text-xs font-bold text-slate-500 uppercase tracking-widest flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-orange-500"></span>
                    INPUT HASIL PENGUJIAN QC GOODS CHECK (BAGGING & KEMASAN AKHIR)
                </h4>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Lot Number / Batch</label>
                        <input type="text" x-model="goodsForm.lotNo" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs font-bold text-navy outline-none focus:border-orange-400">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Hasil Timbang Sample (Kg)</label>
                        <input type="number" step="0.01" x-model="goodsForm.weight" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs font-bold text-navy outline-none focus:border-orange-400" placeholder="25.00">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Kualitas Seal Jahitan</label>
                        <select x-model="goodsForm.sealCheck" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs font-bold text-slate-700 outline-none focus:border-orange-400">
                            <option value="PASS">PASS (Kuat & Rapi)</option>
                            <option value="FAIL">FAIL (Bocor / Rapuh)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Kesesuaian Label Barcode</label>
                        <select x-model="goodsForm.labelCheck" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs font-bold text-slate-700 outline-none focus:border-orange-400">
                            <option value="SESUAI">SESUAI (Terbaca Barcode)</option>
                            <option value="TIDAK_SESUAI">TIDAK SESUAI (Cacat Print)</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 pt-2">
                    <div>
                        <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Kondisi Pallet & Stretch Film</label>
                        <select x-model="goodsForm.palletCheck" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs font-bold text-slate-700 outline-none focus:border-orange-400">
                            <option value="OK">OK (Wrapping Rapi & Kokoh)</option>
                            <option value="REWORK">RE-WORK (Perlu Re-wrap)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Keputusan Akhir Goods Check</label>
                        <select x-model="goodsForm.status" class="w-full border rounded-xl px-3 py-2 text-xs font-black outline-none" :class="goodsForm.status === 'RELEASED' ? 'bg-emerald-50 border-emerald-400 text-emerald-700' : (goodsForm.status === 'HOLD' ? 'bg-amber-50 border-amber-400 text-amber-700' : 'bg-rose-50 border-rose-400 text-rose-700')">
                            <option value="RELEASED">RELEASED (Lolos ke Gudang FG)</option>
                            <option value="HOLD">HOLD (Evaluasi Kemasan)</option>
                            <option value="REJECT">REJECT (Cacat Kemasan)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Catatan QC Kemasan</label>
                        <input type="text" x-model="goodsForm.notes" placeholder="Catatan opsional..." class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs text-slate-700 outline-none focus:border-orange-400">
                    </div>
                </div>

                <div class="flex justify-end pt-2">
                    <button @click="submitGoodsCheck()" class="px-5 py-2.5 bg-orange-600 hover:bg-orange-700 text-white font-bold text-xs rounded-xl shadow transition flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Simpan Hasil QC Goods Check
                    </button>
                </div>
            </div>

            <!-- Tabel Riwayat QC Goods Check Bagging -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-5 py-4 bg-slate-50 border-b border-slate-200 flex justify-between items-center">
                    <h4 class="text-xs font-bold text-slate-700 uppercase tracking-wider">Riwayat QC Goods Check & Bagging (Hari Ini)</h4>
                    <span class="text-[10px] font-bold text-slate-500" x-text="goodsLogs.length + ' Entri Data'"></span>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-100 border-b border-slate-200 text-slate-600 uppercase font-bold text-[10px]">
                            <tr>
                                <th class="p-3">Waktu</th>
                                <th class="p-3">Lot / Batch No</th>
                                <th class="p-3 text-right">Berat Netto</th>
                                <th class="p-3 text-center">Jahitan Seal</th>
                                <th class="p-3 text-center">Label Barcode</th>
                                <th class="p-3 text-center">Palletizing</th>
                                <th class="p-3 text-center">Status Released</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <template x-for="(g, idx) in goodsLogs" :key="idx">
                                <tr class="hover:bg-slate-50">
                                    <td class="p-3 font-bold text-slate-600" x-text="g.timestamp"></td>
                                    <td class="p-3 font-extrabold text-navy" x-text="g.lotNo"></td>
                                    <td class="p-3 text-right font-bold text-slate-800" x-text="g.weight + ' kg'"></td>
                                    <td class="p-3 text-center">
                                        <span :class="g.sealCheck === 'PASS' ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800'" class="px-2 py-0.5 rounded font-bold text-[10px]" x-text="g.sealCheck"></span>
                                    </td>
                                    <td class="p-3 text-center">
                                        <span :class="g.labelCheck === 'SESUAI' ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800'" class="px-2 py-0.5 rounded font-bold text-[10px]" x-text="g.labelCheck"></span>
                                    </td>
                                    <td class="p-3 text-center font-bold text-slate-700" x-text="g.palletCheck"></td>
                                    <td class="p-3 text-center">
                                        <span :class="g.status === 'RELEASED' ? 'bg-emerald-500 text-white' : (g.status === 'HOLD' ? 'bg-amber-500 text-white' : 'bg-rose-500 text-white')" class="px-2.5 py-1 rounded-lg font-black text-[10px]" x-text="g.status"></span>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
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

    <!-- MODAL PENANGANAN PRODUK / REKOMENDASI -->
    <div x-show="showPenangananModal" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm overflow-y-auto" x-transition>
        <div class="bg-white rounded-2xl shadow-2xl border border-slate-200 w-full max-w-2xl my-auto overflow-hidden font-sans" @click.away="showPenangananModal = false">
            <!-- Header Modal -->
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-indigo-50/70">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-indigo-100 text-indigo-700 flex items-center justify-center font-bold">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <h3 class="text-sm font-black text-slate-800">Form Penanganan Rekomendasi</h3>
                            <span class="px-2 py-0.5 bg-indigo-600 text-white rounded font-mono font-extrabold text-[10px]" x-text="penangananForm.nomorForm"></span>
                        </div>
                        <p class="text-[10px] text-slate-500 mt-0.5">Tujuan Pemeriksaan: <b class="text-indigo-700 font-bold" x-text="penangananForm.tujuanPemeriksaan">Foreman Produksi</b> — Laporan deviasi & rekomendasi perbaikan</p>
                    </div>
                </div>
                <button @click="showPenangananModal = false" class="text-slate-400 hover:text-slate-600 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <!-- Body Form Modal -->
            <div class="p-6 space-y-4 max-h-[75vh] overflow-y-auto">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[10px] font-bold text-indigo-700 uppercase mb-1.5">Nomor Form Otomatis</label>
                        <input type="text" x-model="penangananForm.nomorForm" readonly class="w-full bg-indigo-50/70 border border-indigo-200 rounded-xl px-3 py-2 text-xs font-mono font-black text-indigo-900 outline-none">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-indigo-700 uppercase mb-1.5">Tujuan Pemeriksaan</label>
                        <input type="text" x-model="penangananForm.tujuanPemeriksaan" readonly class="w-full bg-indigo-50/70 border border-indigo-200 rounded-xl px-3 py-2 text-xs font-bold text-indigo-900 outline-none">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1.5">Tanggal</label>
                        <input type="date" x-model="penangananForm.tanggal" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs font-bold text-slate-700 outline-none focus:border-indigo-400">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1.5">Nama Produk</label>
                        <input type="text" x-model="penangananForm.produk" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs font-bold text-slate-700 outline-none focus:border-indigo-400">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1.5">Batch / Lot No</label>
                        <input type="text" x-model="penangananForm.batchNo" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs font-bold text-slate-700 outline-none focus:border-indigo-400" placeholder="Contoh: L-2608-01">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1.5">Jumlah</label>
                        <div class="flex items-center gap-2">
                            <input type="number" x-model="penangananForm.jumlah" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs font-bold text-slate-700 outline-none focus:border-indigo-400" placeholder="0">
                            <select x-model="penangananForm.satuan" class="w-20 bg-slate-50 border border-slate-200 rounded-xl px-2 py-2 text-xs font-bold text-slate-700 outline-none focus:border-indigo-400">
                                <option value="Kg">Kg</option>
                                <option value="Pcs">Pcs</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1.5">Penyimpangan</label>
                    <textarea x-model="penangananForm.penyimpangan" rows="2" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-xs text-slate-700 outline-none focus:border-indigo-400 resize-none" placeholder="Deskripsikan penyimpangan yang terjadi..."></textarea>
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1.5">Penanganan</label>
                    <textarea x-model="penangananForm.penanganan" rows="2" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-xs text-slate-700 outline-none focus:border-indigo-400 resize-none" placeholder="Langkah penanganan yang telah dilakukan..."></textarea>
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1.5">Keterangan Tambahan</label>
                    <textarea x-model="penangananForm.keterangan" rows="2" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-xs text-slate-700 outline-none focus:border-indigo-400 resize-none" placeholder="(Opsional)"></textarea>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1.5">Dibuat Oleh</label>
                        <input type="text" x-model="penangananForm.dibuatOleh" class="w-full bg-slate-100 border border-slate-200 rounded-xl px-3 py-2 text-xs font-bold text-slate-500 outline-none" readonly>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1.5">Disetujui Oleh</label>
                        <select x-model="penangananForm.disetujuiOleh" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs font-bold text-slate-700 outline-none focus:border-indigo-400">
                            <option value="">Pilih Supervisor...</option>
                            <option value="Agus (SPV QC)">Agus (SPV QC)</option>
                            <option value="Budi (Foreman Produksi)">Budi (Foreman Produksi)</option>
                            <option value="Bambang (Manager Produksi)">Bambang (Manager Produksi)</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Footer Tombol Batal & Simpan Form Penanganan (Didalam Container Form) -->
            <div class="px-6 py-4 bg-slate-50 border-t border-slate-200 flex justify-end gap-3">
                <button type="button" @click="showPenangananModal = false" class="px-4 py-2 bg-white border border-slate-300 text-slate-700 font-bold text-xs rounded-xl hover:bg-slate-100 transition shadow-sm">Batal</button>
                <button type="button" @click="submitPenanganan()" class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs rounded-xl shadow flex items-center gap-1.5 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Simpan Form Penanganan
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
            searchDisperse: '',
            filterDisperseStatus: '',
            searchPhysical: '',
            filterPhysicalStatus: '',
            showNcModal: false,
            showPenangananModal: false,

            foremanName: 'Budi S. (Foreman RED)',
            lastDisperseTime: '12:00 WIB',
            ncAlertSent: true,

            spkDb: {
                'SPK-2608-001': { id: 'SPK-2608-001', customer: 'PT Royal Synthetic Compound', product: 'PVC Compound A (Clear)' },
                'SPK-2608-002': { id: 'SPK-2608-002', customer: 'PT Chemindo Utama', product: 'PVC Compound B (Color)' },
                'SPK-2608-003': { id: 'SPK-2608-003', customer: 'PT Indopack Industri', product: 'Rigid PVC Granule Grade A' }
            },

            penangananForm: {
                nomorForm: 'FORM-QC-REC-2026-001',
                tujuanPemeriksaan: 'Foreman Produksi',
                tanggal: new Date().toISOString().slice(0, 10),
                produk: 'PVC Compound A (Clear)',
                batchNo: '',
                jumlah: '',
                satuan: 'Kg',
                penyimpangan: '',
                penanganan: '',
                keterangan: '',
                dibuatOleh: 'Hendra (QC)',
                disetujuiOleh: 'Budi (Foreman Produksi)'
            },

            get selectedSpk() {
                return this.spkDb[this.selectedSpkId] || this.spkDb['SPK-2608-001'];
            },

            changeSpk() {
                // reset state if needed
                this.penangananForm.produk = this.selectedSpk.product;
            },

            openPenangananModal() {
                this.penangananForm.produk = this.selectedSpk.product;
                this.showPenangananModal = true;
            },

            submitPenanganan() {
                if(!this.penangananForm.batchNo || !this.penangananForm.penyimpangan) {
                    alert('Lengkapi Batch No dan Deskripsi Penyimpangan terlebih dahulu!');
                    return;
                }
                alert('Form Penanganan Produk berhasil disimpan secara digital!');
                this.showPenangananModal = false;
                // Di sini biasanya di-push ke array/database riwayat penanganan
            },

            disperseLogs: [
                { tanggal: '2026-09-16', jam: '06:00', rating: 5, visual: 'Bebas aglomerat & bintik halus', status: 'PASS', notes: 'Dispersi sempurna', inspector: 'Hendra (QC)' },
                { tanggal: '2026-09-16', jam: '07:00', rating: 4, visual: 'Homogen, warna jernih', status: 'PASS', notes: 'Sesuai standar', inspector: 'Hendra (QC)' },
                { tanggal: '2026-09-16', jam: '08:00', rating: 4, visual: 'Homogen standar', status: 'PASS', notes: 'Sesuai standar', inspector: 'Hendra (QC)' },
                { tanggal: '2026-09-16', jam: '09:00', rating: 3, visual: 'Terdeteksi bintik halus pigmen', status: 'HOLD', notes: 'Perlu pengawasan suhu extruder', inspector: 'Hendra (QC)' },
                { tanggal: '2026-09-16', jam: '10:00', rating: 2, visual: 'Bintik merah aglomerat menyebar', status: 'REJECT', notes: 'Aglomerat pigmen tidak meleleh sempurna di die zone 4', inspector: 'Hendra (QC)' },
                { tanggal: '2026-09-16', jam: '11:00', rating: 4, visual: 'Homogen pasca pembersihan die', status: 'PASS', notes: 'Normal kembali', inspector: 'Hendra (QC)' },
                { tanggal: '2026-09-16', jam: '12:00', rating: 5, visual: 'Bebas bintik & sangat jernih', status: 'PASS', notes: 'Sangat homogen', inspector: 'Hendra (QC)' }
            ],

            get filteredDisperseLogs() {
                return this.disperseLogs.filter(row => {
                    let matchSearch = (row.notes.toLowerCase().includes(this.searchDisperse.toLowerCase()) || 
                                       row.inspector.toLowerCase().includes(this.searchDisperse.toLowerCase()) ||
                                       row.visual.toLowerCase().includes(this.searchDisperse.toLowerCase()) ||
                                       row.jam.includes(this.searchDisperse));
                    let matchStatus = this.filterDisperseStatus === '' || row.status === this.filterDisperseStatus;
                    return matchSearch && matchStatus;
                });
            },

            // FITUR 2: PHYSICAL AND MECHANICAL TEST (2 JAM SEKALI - EXCEL FORMAT)
            physicalLogs: [
                { noZak: 'Zak #01', time: '06:00', date: '2026-09-16', lotNumber: 'LOT-260816-01', moistureMass: '10.02', moistureVal: 0.05, sgMass: '25.00', sgVal: 1.34, temp: 175, cutTime: 10, cut1Mass: '1.65', mfi1: 16.5, cut2Mass: '1.68', mfi2: 16.8, cut3Mass: '1.66', mfi3: 16.6, avgMfi: 16.63, status: 'PASS', note: 'Standard OK', analysedBy: 'Hendra QC', reviewedBy: 'Budi (Foreman)' },
                { noZak: 'Zak #03', time: '08:00', date: '2026-09-16', lotNumber: 'LOT-260816-02', moistureMass: '10.05', moistureVal: 0.07, sgMass: '25.10', sgVal: 1.35, temp: 175, cutTime: 10, cut1Mass: '1.68', mfi1: 16.8, cut2Mass: '1.70', mfi2: 17.0, cut3Mass: '1.69', mfi3: 16.9, avgMfi: 16.90, status: 'PASS', note: 'Standard OK', analysedBy: 'Hendra QC', reviewedBy: 'Budi (Foreman)' },
                { noZak: 'Zak #05', time: '10:00', date: '2026-09-16', lotNumber: 'LOT-260816-03', moistureMass: '10.12', moistureVal: 0.14, sgMass: '25.25', sgVal: 1.38, temp: 175, cutTime: 10, cut1Mass: '2.10', mfi1: 21.0, cut2Mass: '2.15', mfi2: 21.5, cut3Mass: '2.20', mfi3: 22.0, avgMfi: 21.50, status: 'REJECT', note: 'MFI & Moisture melebihi batas toleransi atas (Max 18.0)', analysedBy: 'Hendra QC', reviewedBy: 'Budi (Foreman)' },
                { noZak: 'Zak #07', time: '12:00', date: '2026-09-16', lotNumber: 'LOT-260816-04', moistureMass: '10.04', moistureVal: 0.06, sgMass: '25.05', sgVal: 1.34, temp: 175, cutTime: 10, cut1Mass: '1.67', mfi1: 16.7, cut2Mass: '1.66', mfi2: 16.6, cut3Mass: '1.68', mfi3: 16.8, avgMfi: 16.70, status: 'PASS', note: 'Hasil normal pasca koreksi suhu', analysedBy: 'Hendra QC', reviewedBy: 'Budi (Foreman)' }
            ],

            get filteredPhysicalLogs() {
                return this.physicalLogs.filter(row => {
                    let matchSearch = (row.noZak.toLowerCase().includes(this.searchPhysical.toLowerCase()) || 
                                       row.lotNumber.toLowerCase().includes(this.searchPhysical.toLowerCase()) ||
                                       (row.note && row.note.toLowerCase().includes(this.searchPhysical.toLowerCase())));
                    let matchStatus = this.filterPhysicalStatus === '' || row.status === this.filterPhysicalStatus;
                    return matchSearch && matchStatus;
                });
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

        // ====== QC DIGITAL FORM APP ======
        Alpine.data('qcFormApp', () => ({
            showSuccess: false,
            logs: [],

            form: {
                produk: 'PVC Compound A (Clear)',
                mesin: 'E-01',
                tanggal: new Date().toISOString().slice(0, 10),
                jam: new Date().toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' }) + ' WIB',
                analis: 'Hendra (QC)',
                shift: 1,
                jamKe: 1,
                visual: {
                    ukuranGranula: '',
                    warnaGranula: '',
                    kandunganAir: '',
                    serbuk: '',
                },
                testToggle: {
                    press: '',
                    injection: '',
                    blownFilm: '',
                    migrasi: '',
                },
                deltaE: '',
                moisture: '',
                dryerJam: '',
                innerBags: '',
                catatan: '',
                kesimpulan: '',
            },

            visualLabels: {
                ukuranGranula: 'Ukuran Granula',
                warnaGranula: 'Warna Granula',
                kandunganAir: 'Kandungan Air',
                serbuk: 'Serbuk',
            },

            testToggleLabels: {
                press: 'Press',
                injection: 'Injection',
                blownFilm: 'Blown Film',
                migrasi: 'Migrasi',
            },

            get overallStatus() {
                const visualNG = Object.values(this.form.visual).some(v => v === 'NG');
                const testNG = Object.values(this.form.testToggle).some(v => v === 'NG');
                const deltaNG = this.form.deltaE !== '' && parseFloat(this.form.deltaE) >= 1;
                const moistureNG = this.form.moisture !== '' && parseFloat(this.form.moisture) >= 0.1;
                if (this.form.kesimpulan) return this.form.kesimpulan;
                if (visualNG || testNG || deltaNG || moistureNG) return 'NG';
                const allFilled = Object.values(this.form.visual).every(v => v !== '') &&
                                  Object.values(this.form.testToggle).every(v => v !== '');
                if (allFilled) return 'OK';
                return '';
            },

            submitForm() {
                const timeStr = new Date().toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' }) + ' WIB';

                const visualAll = Object.values(this.form.visual).some(v => v === 'NG') ? 'NG' : 'OK';
                const testAll = (Object.values(this.form.testToggle).some(v => v === 'NG') ||
                                 (this.form.deltaE !== '' && parseFloat(this.form.deltaE) >= 1) ||
                                 (this.form.moisture !== '' && parseFloat(this.form.moisture) >= 0.1)) ? 'NG' : 'OK';

                this.logs.unshift({
                    timestamp: timeStr,
                    shift: this.form.shift,
                    jamKe: this.form.jamKe,
                    produk: this.form.produk,
                    mesin: this.form.mesin,
                    analis: this.form.analis,
                    visualAll,
                    testAll,
                    deltaE: this.form.deltaE,
                    moisture: this.form.moisture,
                    kesimpulan: this.overallStatus || this.form.kesimpulan || 'OK',
                    catatan: this.form.catatan,
                });

                // Reset form params only (keep context)
                this.form.visual = { ukuranGranula: '', warnaGranula: '', kandunganAir: '', serbuk: '' };
                this.form.testToggle = { press: '', injection: '', blownFilm: '', migrasi: '' };
                this.form.deltaE = '';
                this.form.moisture = '';
                this.form.dryerJam = '';
                this.form.innerBags = '';
                this.form.catatan = '';
                this.form.kesimpulan = '';

                this.showSuccess = true;
                setTimeout(() => { this.showSuccess = false; }, 4000);
            }
        }));

        // ===== PHYSICAL INPUT APP =====
        Alpine.data('physicalInputApp', () => ({
            inputRows: [],
            savedRows: [],
            _idCounter: 0,

            get filteredPhysicalLogs() {
                // Gabungkan savedRows dengan data global physicalLogs jika ada
                const all = [...(window._physicalLogsData || []), ...this.savedRows];
                return all;
            },

            addRow() {
                this.inputRows.push({
                    id: ++this._idCounter,
                    noZak: '',
                    time: '',
                    date: new Date().toISOString().slice(0, 10),
                    lotNumber: '',
                    moistureMass: '',
                    moistureVal: '',
                    sgMass: '',
                    sgVal: '',
                    temp: '',
                    cutTime: '',
                    cut1Mass: '',
                    cut2Mass: '',
                    cut3Mass: '',
                    status: 'PASS',
                    note: '',
                    analysedBy: '',
                    reviewedBy: '',
                });
            },

            // ── Auto Decimal ──────────────────────────────────────────────
            // Contoh (decimals=4): ketik "0009" → "0.0009"
            //                     ketik "521"  → "0.0521"
            // Mempertahankan posisi kursor relatif agar nyaman dipakai.
            autoDecimal(el, decimals) {
                // Ambil hanya digit dari value sekarang
                let raw = el.value.replace(/[^0-9]/g, '');

                if (!raw) {
                    el.value = '';
                    return '';
                }

                // Pad kiri sampai minimal (decimals+1) digit
                while (raw.length <= decimals) raw = '0' + raw;

                // Hapus leading zeros di bagian integer (jaga minimal 1 digit)
                const intPart = raw.slice(0, -decimals).replace(/^0+/, '') || '0';
                const decPart = raw.slice(-decimals);
                const formatted = intPart + '.' + decPart;

                // Update input value & kembalikan string untuk x-bind
                el.value = formatted;
                return formatted;
            },

            // Hanya izinkan digit + tombol navigasi/edit
            filterKey(event) {
                const allowed = [
                    '0','1','2','3','4','5','6','7','8','9',
                    'Backspace','Delete','Tab','ArrowLeft','ArrowRight',
                    'Home','End'
                ];
                if (!allowed.includes(event.key)) event.preventDefault();
            },

            // Hitung MFI dari Cut Mass & Cut Time (g/10min)
            // Formula: MFI = (CutMass (g) / CutTime (s)) * 600
            calcMfi(cutMass, cutTime) {
                const m = parseFloat(cutMass);
                const t = parseFloat(cutTime);
                if (!m || !t || t === 0) return null;
                return parseFloat(((m / t) * 600).toFixed(2));
            },

            calcAvgMfi(row) {
                const mfi1 = this.calcMfi(row.cut1Mass, row.cutTime);
                const mfi2 = this.calcMfi(row.cut2Mass, row.cutTime);
                const mfi3 = this.calcMfi(row.cut3Mass, row.cutTime);
                const vals = [mfi1, mfi2, mfi3].filter(v => v !== null);
                if (vals.length === 0) return 0;
                return parseFloat((vals.reduce((a, b) => a + b, 0) / vals.length).toFixed(2));
            },

            saveRow(idx) {
                const row = this.inputRows[idx];
                const avgMfi = this.calcAvgMfi(row);
                const mfi1 = this.calcMfi(row.cut1Mass, row.cutTime);
                const mfi2 = this.calcMfi(row.cut2Mass, row.cutTime);
                const mfi3 = this.calcMfi(row.cut3Mass, row.cutTime);

                this.savedRows.push({
                    noZak: row.noZak || '-',
                    time: row.time || '-',
                    date: row.date || '-',
                    lotNumber: row.lotNumber || '-',
                    moistureMass: row.moistureMass || '0.00',
                    moistureVal: parseFloat(row.moistureVal) || 0,
                    sgMass: row.sgMass || '0.00',
                    sgVal: row.sgVal || '0.000',
                    temp: row.temp || '190',
                    cutTime: row.cutTime || '10',
                    cut1Mass: row.cut1Mass || '0.0000',
                    mfi1: mfi1 || '-',
                    cut2Mass: row.cut2Mass || '0.0000',
                    mfi2: mfi2 || '-',
                    cut3Mass: row.cut3Mass || '0.0000',
                    mfi3: mfi3 || '-',
                    avgMfi: avgMfi || '-',
                    status: row.status || 'PASS',
                    note: row.note || '',
                    analysedBy: row.analysedBy || '-',
                    reviewedBy: row.reviewedBy || '-',
                });

                this.inputRows.splice(idx, 1);
            },

            removeInputRow(idx) {
                this.inputRows.splice(idx, 1);
            },
        }));

        // ===== QC GOODS CHECK APP =====
        Alpine.data('qcGoodsCheckApp', () => ({
            goodsForm: {
                lotNo: 'L-2608-01',
                weight: '25.02',
                sealCheck: 'PASS',
                labelCheck: 'SESUAI',
                palletCheck: 'OK',
                status: 'RELEASED',
                notes: 'Kemasan rapi, seal jahitan kuat & label barcode sesuai.'
            },
            goodsLogs: [
                { timestamp: '11:45 WIB', lotNo: 'L-2608-01', weight: '25.02', sealCheck: 'PASS', labelCheck: 'SESUAI', palletCheck: 'OK', status: 'RELEASED' },
                { timestamp: '09:30 WIB', lotNo: 'L-2608-01', weight: '24.98', sealCheck: 'PASS', labelCheck: 'SESUAI', palletCheck: 'OK', status: 'RELEASED' },
                { timestamp: '07:15 WIB', lotNo: 'L-2607-88', weight: '25.10', sealCheck: 'PASS', labelCheck: 'SESUAI', palletCheck: 'OK', status: 'RELEASED' }
            ],
            submitGoodsCheck() {
                if(!this.goodsForm.lotNo || !this.goodsForm.weight) {
                    alert('Lengkapi Lot Number dan Hasil Timbang Berat terlebih dahulu!');
                    return;
                }
                const nowTime = new Date().toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' }) + ' WIB';
                this.goodsLogs.unshift({
                    timestamp: nowTime,
                    lotNo: this.goodsForm.lotNo,
                    weight: this.goodsForm.weight,
                    sealCheck: this.goodsForm.sealCheck,
                    labelCheck: this.goodsForm.labelCheck,
                    palletCheck: this.goodsForm.palletCheck,
                    status: this.goodsForm.status
                });
                alert('Pengujian QC Goods Check berhasil disimpan! Status Released diperbarui.');
            }
        }));
    });
</script>
@endsection
