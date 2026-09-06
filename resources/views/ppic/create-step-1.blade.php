@extends('layouts.app')

@section('title', 'Buat SPK - Langkah 1 (Parameter, Draft Formula & Stok)')

@section('content')
<div class="max-w-5xl mx-auto h-full pb-10" x-data="spkForm()" x-init="init()">
    
    <!-- Revision Alert Card -->
    <template x-if="isEditMode && editSpk">
        <div class="mb-6 p-5 bg-amber-50 border-l-4 border-l-amber-500 rounded-xl shadow-sm text-sm text-amber-800">
            <div class="flex items-start gap-3">
                <svg class="w-6 h-6 text-amber-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                <div>
                    <h4 class="font-bold text-base text-navy">Modifikasi SPK Terrevisi: <span x-text="editSpk.id"></span></h4>
                    <p class="mt-1 font-medium">Draft ini dikembalikan oleh departemen R&D / Penguji karena memerlukan perbaikan.</p>
                    <div class="mt-3 p-3 bg-white/80 rounded-lg border border-amber-200">
                        <p class="font-bold text-xs text-navy uppercase tracking-wider mb-1">Catatan Revisi Otorisator:</p>
                        <p class="italic text-slate-700" x-text="editSpk.revisionNote"></p>
                    </div>
                </div>
            </div>
        </div>
    </template>
    
    <!-- Progress Indicator -->
    <div class="mb-8">
        <div class="flex items-center">
            <div class="flex items-center text-cyan relative">
                <div class="rounded-full transition duration-500 ease-in-out h-10 w-10 py-3 border-2 border-cyan bg-cyan text-white flex items-center justify-center font-bold">1</div>
                <div class="absolute top-0 -ml-10 text-center mt-12 w-32 text-xs font-bold uppercase text-cyan">Parameter & Formula</div>
            </div>
            <div class="flex-auto border-t-2 transition duration-500 ease-in-out border-slate-200"></div>
            <div class="flex items-center text-slate-400 relative">
                <div class="rounded-full transition duration-500 ease-in-out h-10 w-10 py-3 border-2 border-slate-200 bg-white flex items-center justify-center font-bold">2</div>
                <div class="absolute top-0 -ml-10 text-center mt-12 w-32 text-xs font-medium uppercase text-slate-400">Waktu & Manpower</div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden mt-12">
        <div class="p-6 border-b border-slate-100 bg-slate-50/50">
            <h3 class="text-lg font-bold text-navy">Spesifikasi Dasar SPK</h3>
            <p class="text-sm text-slate-500">Tentukan produk, kuantitas, dan draft formula untuk mengecek ketersediaan bahan baku (Stok).</p>
        </div>
        
        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Pilih Produk Akhir</label>
                <select x-model="product" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-cyan focus:border-cyan outline-none transition-all">
                    <option value="">-- Pilih Produk --</option>
                    <option value="prod-a">PVC Compound A (Clear)</option>
                    <option value="prod-b">PVC Compound B (Color)</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Quantity (Total Batch)</label>
                <div class="relative">
                    <input type="number" x-model.number="qty" @input="calculateStock" class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-4 pr-12 py-2.5 text-sm focus:ring-2 focus:ring-cyan focus:border-cyan outline-none transition-all" placeholder="Misal: 50">
                    <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-slate-400 text-sm font-medium">Batch</div>
                </div>
            </div>
            
            <!-- Draft Formula & Rincian Transparan -->
            <div class="md:col-span-2 border-t border-slate-100 pt-6" x-show="product !== ''">
                <label class="block text-sm font-bold text-slate-700 mb-2">Draft Formula / Resep (Integrasi Tahap 1)</label>
                <select x-model="formula" @change="calculateStock" class="w-full md:w-1/2 bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-cyan focus:border-cyan outline-none transition-all">
                    <option value="">-- Tarik Formula dari Master Data --</option>
                    <option value="form-a1">Formula-PVC-A-Rev01 (Standard)</option>
                </select>
            </div>
        </div>

        <!-- Widget Stok Realtime Semua Material -->
        <div class="p-6 bg-slate-50 border-t border-slate-200" x-show="formula !== '' && qty > 0" style="display:none;" x-transition>
            
            <div class="flex justify-between items-end mb-4">
                <h4 class="text-sm font-bold text-slate-700 flex items-center gap-2">
                    <svg class="w-4 h-4 text-cyan" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path></svg>
                    Simulasi Ketersediaan Stok Material
                </h4>
                
                <!-- Kalkulator Batch -->
                <div class="bg-indigo-50 border border-indigo-200 text-indigo-800 px-4 py-2 rounded-xl flex items-center gap-3 shadow-sm">
                    <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                    <div>
                        <p class="text-[10px] font-bold uppercase tracking-wider opacity-70">Estimasi Kapasitas Maksimal</p>
                        <p class="text-sm font-bold">Bisa produksi <span class="text-indigo-600 underline" x-text="maxPossibleBatch"></span> Batch lagi</p>
                    </div>
                </div>
            </div>
            
            <!-- Tabel Simulasi Semua Material -->
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden mb-4">
                <table class="w-full text-left text-sm">
                    <thead class="bg-slate-50 border-b border-slate-200">
                        <tr class="text-xs uppercase text-slate-500 font-bold">
                            <th class="p-3 pl-4">Material</th>
                            <th class="p-3 text-right">Kebutuhan (Per Batch)</th>
                            <th class="p-3 text-right">Target Kebutuhan</th>
                            <th class="p-3 text-right">Stok Fisik Tersedia</th>
                            <th class="p-3 text-center w-32">Status Validasi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700">
                        <template x-for="item in materials" :key="item.id">
                            <tr :class="item.isEnough ? '' : 'bg-red-50/50'">
                                <td class="p-3 pl-4 font-bold text-navy" x-text="item.name"></td>
                                <td class="p-3 text-right"><span x-text="item.qtyPerBatch"></span> <span class="text-xs text-slate-400">Kg</span></td>
                                <td class="p-3 text-right font-bold text-slate-800"><span x-text="item.qtyPerBatch * qty"></span> <span class="text-xs text-slate-400">Kg</span></td>
                                <td class="p-3 text-right font-bold text-navy"><span x-text="item.stock"></span> <span class="text-xs text-slate-400">Kg</span></td>
                                <td class="p-3 text-center">
                                    <template x-if="item.isEnough">
                                        <span class="bg-emerald-50 text-emerald-700 border border-emerald-200 px-2 py-1 rounded text-xs font-bold flex items-center justify-center gap-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Cukup
                                        </span>
                                    </template>
                                    <template x-if="!item.isEnough">
                                        <span class="bg-red-50 text-red-700 border border-red-200 px-2 py-1 rounded text-xs font-bold flex items-center justify-center gap-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg> Kurang
                                        </span>
                                    </template>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>

            <!-- Banner Validasi Global -->
            <div x-show="!isAllEnough" style="display:none;" x-transition class="p-4 rounded-xl bg-red-50 text-red-700 flex items-start gap-3 border border-red-200">
                <svg class="w-5 h-5 flex-shrink-0 mt-0.5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                <div class="text-sm">
                    <p class="font-bold">Peringatan: Stok Material Tidak Mencukupi!</p>
                    <p class="mt-1 text-red-600">Ada satu atau lebih bahan baku yang stok fisiknya kurang dari target kebutuhan batch Anda. Anda tidak dapat melanjutkan pembuatan SPK ini.</p>
                </div>
            </div>
            
            <div x-show="isAllEnough" style="display:none;" x-transition class="p-4 rounded-xl bg-emerald-50 text-emerald-800 flex items-center gap-3 border border-emerald-200">
                <svg class="w-5 h-5 flex-shrink-0 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <p class="text-sm font-bold">Validasi Sukses: Semua material mencukupi untuk jumlah batch ini. Silakan lanjutkan ke pengaturan waktu.</p>
            </div>
        </div>

        <div class="p-6 bg-white border-t border-slate-200 flex justify-end gap-3">
            <a href="{{ route('ppic.calendar') }}" class="px-5 py-2.5 text-sm font-bold text-slate-600 bg-white border border-slate-300 rounded-xl hover:bg-slate-50 transition-colors">Batal</a>
            <a href="{{ route('ppic.create.step2') }}" class="px-6 py-2.5 text-sm font-bold text-white rounded-xl shadow-md transition-colors flex items-center gap-2" :class="isAllEnough && qty > 0 ? 'bg-cyan hover:bg-cyan/90 shadow-cyan/30' : 'bg-slate-300 cursor-not-allowed text-slate-500'" :style="isAllEnough && qty > 0 ? '' : 'pointer-events: none;'">
                Lanjut: Waktu & Manpower
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </button>
        </div>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('spkForm', () => ({
            product: '',
            formula: '',
            qty: null,
            isAllEnough: true,
            maxPossibleBatch: 0,
            
            materials: [
                { id: 1, name: 'Resin PVC S-65', qtyPerBatch: 25, stock: 1500, isEnough: true },
                { id: 2, name: 'Stabilizer Ca-Zn', qtyPerBatch: 1, stock: 100, isEnough: true },
                { id: 3, name: 'Pigment White', qtyPerBatch: 0.5, stock: 10, isEnough: true }
            ],
            
            calculateStock() {
                if (!this.qty || this.formula === '') {
                    this.isAllEnough = true;
                    return;
                }
                
                let allEnough = true;
                let maxBatches = [];
                
                this.materials.forEach(item => {
                    let needed = item.qtyPerBatch * this.qty;
                    item.isEnough = item.stock >= needed;
                    if(!item.isEnough) allEnough = false;
                    
                    // Hitung maksimal batch per material
                    maxBatches.push(Math.floor(item.stock / item.qtyPerBatch));
                });
                
                this.isAllEnough = allEnough;
                
                // Kalkulator Max Batch adalah nilai terkecil (bottleneck) dari maxBatches
                this.maxPossibleBatch = Math.min(...maxBatches);
            }
        }))
    });
</script>
@endsection
