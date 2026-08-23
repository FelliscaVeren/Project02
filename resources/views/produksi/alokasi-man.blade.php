@extends('layouts.app')

@section('title', 'Alokasi Tenaga Kerja (Manpower) & Mesin')

@section('content')
<div class="max-w-6xl mx-auto h-full flex flex-col gap-6" x-data="manpowerAllocation()">
    
    <div class="flex justify-between items-end">
        <div>
            <h3 class="text-xl font-bold text-navy">Alokasi Operator (Assign Manpower)</h3>
            <p class="text-sm text-slate-500 mt-1">Sinkronisasi jadwal, pantau occupancy mesin, dan tentukan operator berdasarkan rotasi shift.</p>
        </div>
        <button @click="randomizeRotation" class="px-4 py-2 bg-white border border-slate-300 hover:bg-slate-50 text-slate-700 text-sm font-bold rounded-xl transition-colors flex items-center gap-2 shadow-sm">
            <svg class="w-4 h-4 text-cyan" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
            Generate Rotasi Acak (Minggu Ini)
        </button>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 flex-1">
        
        <!-- Kolom Kiri: Machine Occupancy & Draft Info -->
        <div class="xl:col-span-1 space-y-6 flex flex-col h-full">
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 border-l-4 border-l-emerald-500">
                <div class="flex justify-between items-start mb-4">
                    <h4 class="text-xs font-bold text-navy uppercase tracking-wide">SPK Siap Eksekusi</h4>
                    <span class="bg-emerald-100 text-emerald-800 text-[10px] font-black px-2 py-1 rounded">ALL APPROVED</span>
                </div>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between border-b border-slate-50 pb-2">
                        <span class="text-slate-500">No. Referensi</span>
                        <span class="font-bold text-navy">DRF-SPK-2608-01</span>
                    </div>
                    <div class="flex justify-between border-b border-slate-50 pb-2">
                        <span class="text-slate-500">Jadwal</span>
                        <span class="font-bold text-navy">12 - 14 Aug</span>
                    </div>
                    <div class="flex justify-between border-b border-slate-50 pb-2">
                        <span class="text-slate-500">Kebutuhan Manpower</span>
                        <span class="font-bold text-amber-600">Total 5 Org/Shift</span>
                    </div>
                </div>
            </div>

            <!-- Machine Occupancy -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 flex-1">
                <h4 class="text-xs font-bold text-navy uppercase tracking-wide mb-4">Machine Occupancy (Status Sinkronisasi)</h4>
                
                <div class="space-y-4">
                    <div class="bg-slate-50 p-3 rounded-xl border border-slate-100">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-sm font-bold text-slate-800">Mixer A-01</span>
                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                        </div>
                        <div class="flex h-2 bg-slate-200 rounded-full overflow-hidden">
                            <div class="w-1/3 bg-emerald-400" title="Shift 1"></div>
                            <div class="w-1/3 bg-emerald-500" title="Shift 2"></div>
                            <div class="w-1/3 bg-slate-200" title="Shift 3 (Kosong)"></div>
                        </div>
                        <p class="text-[10px] text-slate-400 mt-1 font-medium">Tersedia untuk Shift 3</p>
                    </div>
                    
                    <div class="bg-slate-50 p-3 rounded-xl border border-slate-100">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-sm font-bold text-slate-800">Extruder Line 1</span>
                            <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                        </div>
                        <div class="flex h-2 bg-slate-200 rounded-full overflow-hidden">
                            <div class="w-1/3 bg-amber-400" title="Shift 1"></div>
                            <div class="w-1/3 bg-amber-500" title="Shift 2"></div>
                            <div class="w-1/3 bg-amber-600" title="Shift 3"></div>
                        </div>
                        <p class="text-[10px] text-amber-600 mt-1 font-bold">Occupancy Penuh (3 Shift)</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Alokasi & Multi-Select -->
        <div class="xl:col-span-2 bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden flex flex-col">
            <div class="p-5 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
                <div>
                    <h3 class="text-lg font-bold text-navy">Penugasan Operator per Stasiun</h3>
                    <p class="text-xs text-slate-500">Gunakan Ctrl/Cmd+Click untuk memilih lebih dari 1 operator (Multi-Select).</p>
                </div>
                
                <div x-show="showHistory" class="bg-indigo-50 border border-indigo-100 text-indigo-700 px-3 py-1.5 rounded-lg text-xs font-bold" style="display:none;" x-transition>
                    ✅ Shift telah dirotasi acak berdasarkan minggu lalu
                </div>
            </div>
            
            <div class="p-6 flex-1 space-y-6 overflow-y-auto">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    
                    <!-- Bagian Penimbangan -->
                    <div class="bg-slate-50 p-4 rounded-xl border border-slate-200">
                        <div class="flex justify-between items-center mb-3">
                            <h4 class="text-sm font-bold text-slate-700 uppercase tracking-wide flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-indigo-500"></span> Penimbangan (Need 1)
                            </h4>
                        </div>
                        <!-- Multi-select simulasi -->
                        <select multiple class="w-full bg-white border border-slate-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-cyan outline-none h-24" x-ref="selTimbang">
                            <option value="andi">Op. Andi</option>
                            <option value="budi">Op. Budi</option>
                            <option value="citra">Op. Citra</option>
                        </select>
                    </div>
                    
                    <!-- Bagian Mixing -->
                    <div class="bg-slate-50 p-4 rounded-xl border border-slate-200">
                        <div class="flex justify-between items-center mb-3">
                            <h4 class="text-sm font-bold text-slate-700 uppercase tracking-wide flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-blue-500"></span> Mixing (Need 1)
                            </h4>
                        </div>
                        <select multiple class="w-full bg-white border border-slate-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-cyan outline-none h-24" x-ref="selMixing">
                            <option value="dedi">Op. Dedi</option>
                            <option value="eko">Op. Eko</option>
                        </select>
                    </div>
                    
                    <!-- Bagian Extruder -->
                    <div class="bg-slate-50 p-4 rounded-xl border border-slate-200">
                        <div class="flex justify-between items-center mb-3">
                            <h4 class="text-sm font-bold text-slate-700 uppercase tracking-wide flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-emerald-500"></span> Extruder (Need 2)
                            </h4>
                        </div>
                        <select multiple class="w-full bg-white border border-slate-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-cyan outline-none h-24" x-ref="selExtruder">
                            <option value="fajar">Op. Fajar</option>
                            <option value="gilang">Op. Gilang</option>
                            <option value="hadi">Op. Hadi</option>
                            <option value="ivan">Op. Ivan</option>
                        </select>
                        <p class="text-[10px] text-slate-500 mt-1">*Pilih 2 orang menggunakan Ctrl/Cmd+Click</p>
                    </div>
                    
                    <!-- Bagian Bagging -->
                    <div class="bg-slate-50 p-4 rounded-xl border border-slate-200">
                        <div class="flex justify-between items-center mb-3">
                            <h4 class="text-sm font-bold text-slate-700 uppercase tracking-wide flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-amber-500"></span> Bagging (Need 1)
                            </h4>
                        </div>
                        <select multiple class="w-full bg-white border border-slate-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-cyan outline-none h-24" x-ref="selBagging">
                            <option value="indah">Op. Indah</option>
                            <option value="joko">Op. Joko</option>
                        </select>
                    </div>
                </div>

                <!-- Histori Rotasi (Tampil saat randomize dipencet) -->
                <div x-show="showHistory" style="display:none;" x-transition class="mt-4 border border-slate-200 rounded-xl overflow-hidden">
                    <div class="bg-slate-50 px-4 py-2 border-b border-slate-200">
                        <p class="text-xs font-bold text-navy">Data Histori Shift Minggu Lalu</p>
                    </div>
                    <div class="p-4 bg-white text-xs text-slate-600">
                        <p>Minggu lalu <b>Op. Andi</b> berada di Shift Malam (3). Rotasi sistem mengacak agar minggu ini ia mendapat Shift Pagi (1).</p>
                    </div>
                </div>
            </div>

            <div class="p-5 bg-slate-50 border-t border-slate-200 flex justify-end">
                <a href="{{ route('spk.detail') }}" class="px-6 py-2.5 text-sm font-bold text-white bg-navy hover:bg-navy-light rounded-xl shadow-md transition-colors flex items-center gap-2">
                    Submit & Generate SPK Fix
                    <svg class="w-4 h-4 text-cyan" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('manpowerAllocation', () => ({
            showHistory: false,
            randomizeRotation() {
                // Simulasi rotasi acak
                this.showHistory = true;
                
                // Pilih opsi acak di dom
                this.$refs.selTimbang.selectedIndex = Math.floor(Math.random() * 3);
                this.$refs.selMixing.selectedIndex = Math.floor(Math.random() * 2);
                
                // Multi select simulasi
                let extOpts = this.$refs.selExtruder.options;
                for(let i=0; i<extOpts.length; i++) extOpts[i].selected = false;
                extOpts[0].selected = true;
                extOpts[2].selected = true;
                
                this.$refs.selBagging.selectedIndex = Math.floor(Math.random() * 2);
            }
        }))
    });
</script>
@endsection
