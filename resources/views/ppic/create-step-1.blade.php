@extends('layouts.app')

@section('title', 'Buat SPK - Langkah 1 (Parameter, Draft Formula & Stok)')

@section('content')
<div class="max-w-5xl mx-auto h-full pb-10" x-data="spkForm()">
    
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
                    <input type="number" x-model="qty" @input="checkStock" class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-4 pr-12 py-2.5 text-sm focus:ring-2 focus:ring-cyan focus:border-cyan outline-none transition-all" placeholder="Misal: 50">
                    <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-slate-400 text-sm font-medium">Batch</div>
                </div>
            </div>
            
            <!-- Draft Formula (Dipindah ke Tahap 1) -->
            <div class="md:col-span-2 border-t border-slate-100 pt-6" x-show="product !== ''">
                <label class="block text-sm font-bold text-slate-700 mb-2">Draft Formula / Resep (Integrasi Tahap 1)</label>
                <div class="flex gap-4">
                    <select x-model="formula" class="flex-1 bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-cyan focus:border-cyan outline-none transition-all">
                        <option value="">-- Tarik Formula dari Master Data --</option>
                        <option value="form-a1">Formula-PVC-A-Rev01 (Standard)</option>
                        <option value="form-a2">Formula-PVC-A-Rev02 (High Impact)</option>
                    </select>
                </div>
                
                <!-- Rincian Material Transparan -->
                <div class="mt-4 p-4 rounded-xl border border-slate-200 bg-slate-50" x-show="formula !== ''">
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-3">Rincian Material (BOM) per 1 Batch</p>
                    <table class="w-full text-left text-sm text-slate-700">
                        <tr class="border-b border-slate-200"><th class="pb-2">Material</th><th class="pb-2 text-right">Kebutuhan/Batch</th></tr>
                        <tr class="border-b border-slate-100"><td class="py-2">Resin PVC S-65</td><td class="py-2 text-right font-medium">25 Kg</td></tr>
                        <tr class="border-b border-slate-100"><td class="py-2">Stabilizer Ca-Zn</td><td class="py-2 text-right font-medium">1 Kg</td></tr>
                        <tr><td class="py-2">Pigment White TiO2</td><td class="py-2 text-right font-medium">0.5 Kg</td></tr>
                    </table>
                </div>
            </div>
        </div>

        <!-- Widget Stok Realtime -->
        <div class="p-6 bg-slate-50 border-t border-slate-200" x-show="formula !== '' && qty > 0">
            <h4 class="text-sm font-bold text-slate-700 mb-4 flex items-center gap-2">
                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path></svg>
                Pengecekan Stok Bahan Baku (Kritis)
            </h4>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm">
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Stok PVC Terendah</p>
                    <p class="text-2xl font-black text-navy" x-text="totalStock + ' Kg'"></p>
                </div>
                <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm">
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Total Kebutuhan (Semua Batch)</p>
                    <p class="text-2xl font-black text-amber-600" x-text="(qty * 25) + ' Kg'"></p>
                </div>
                <div class="p-4 rounded-xl shadow-sm border transition-colors" :class="isEnough ? 'bg-emerald-50 border-emerald-200' : 'bg-red-50 border-red-200'">
                    <p class="text-[10px] font-bold uppercase tracking-wider mb-1" :class="isEnough ? 'text-emerald-700' : 'text-red-700'">Sisa Stok Simulasi</p>
                    <p class="text-2xl font-black" :class="isEnough ? 'text-emerald-800' : 'text-red-800'" x-text="(totalStock - (qty * 25)) + ' Kg'"></p>
                </div>
            </div>

            <div x-show="!isEnough" class="mt-4 p-4 rounded-xl bg-red-50 text-red-700 flex items-start gap-3 border border-red-200">
                <svg class="w-5 h-5 flex-shrink-0 mt-0.5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                <div class="text-sm">
                    <p class="font-bold">Peringatan Stok Kurang!</p>
                    <p class="mt-1 text-red-600">Bahan baku (Resin PVC S-65) tidak mencukupi untuk jumlah batch ini.</p>
                </div>
            </div>
            
            <div x-show="isEnough" class="mt-4 p-4 rounded-xl bg-emerald-50 text-emerald-800 flex items-center gap-3 border border-emerald-200">
                <svg class="w-5 h-5 flex-shrink-0 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <p class="text-sm font-bold">Stok semua material mencukupi! Anda dapat melanjutkan ke pengaturan waktu.</p>
            </div>
        </div>

        <div class="p-6 bg-white border-t border-slate-200 flex justify-end gap-3">
            <a href="{{ route('ppic.calendar') }}" class="px-5 py-2.5 text-sm font-bold text-slate-600 bg-white border border-slate-300 rounded-xl hover:bg-slate-50 transition-colors">Batal</a>
            <a href="{{ route('ppic.create.step2') }}" class="px-6 py-2.5 text-sm font-bold text-white rounded-xl shadow-md transition-colors flex items-center gap-2" :class="isEnough && qty > 0 ? 'bg-cyan hover:bg-cyan/90 shadow-cyan/30' : 'bg-slate-300 cursor-not-allowed text-slate-500'" :style="isEnough && qty > 0 ? '' : 'pointer-events: none;'">
                Lanjut: Waktu & Manpower
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </a>
        </div>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('spkForm', () => ({
            product: '',
            formula: '',
            qty: null,
            totalStock: 1500, // Simulasi kg PVC
            isEnough: true,
            
            checkStock() {
                if (this.qty === null || this.qty === '') {
                    this.isEnough = true;
                    return;
                }
                let needed = this.qty * 25; // Asumsi 25kg PVC per batch
                this.isEnough = (this.totalStock - needed) >= 0;
            }
        }))
    })
</script>
@endsection
