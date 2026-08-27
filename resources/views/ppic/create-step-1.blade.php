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
                    <input type="number" x-model="qty" class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-4 pr-12 py-2.5 text-sm focus:ring-2 focus:ring-cyan focus:border-cyan outline-none transition-all" placeholder="Misal: 50">
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
                        <template x-for="item in formulas[formula]" :key="item.name">
                            <tr class="border-b border-slate-100">
                                <td class="py-2" x-text="item.name"></td>
                                <td class="py-2 text-right font-medium" x-text="item.bom + ' Kg'"></td>
                            </tr>
                        </template>
                    </table>
                </div>
            </div>
        </div>

        <!-- Widget Stok Realtime Komprehensif -->
        <div class="p-6 bg-slate-50 border-t border-slate-200" x-show="formula !== '' && qty > 0">
            <h4 class="text-sm font-bold text-slate-700 mb-4 flex items-center gap-2">
                <svg class="w-4 h-4 text-cyan" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                Pengecekan Stok Bahan Baku Komprehensif (BOM Validation)
            </h4>
            
            <div class="border border-slate-200 rounded-xl overflow-hidden bg-white shadow-sm mb-4">
                <table class="w-full text-left text-sm">
                    <thead class="bg-slate-50 border-b border-slate-200">
                        <tr class="text-xs uppercase text-slate-500 font-bold">
                            <th class="p-3 pl-4">Bahan Baku (Material)</th>
                            <th class="p-3 text-right">Stok Fisik Gudang</th>
                            <th class="p-3 text-right">Kebutuhan SPK</th>
                            <th class="p-3 text-right">Simulasi Akhir</th>
                            <th class="p-3 text-center">Status</th>
                            <th class="p-3 text-right pr-4">Estimasi Sisa Batch</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700">
                        <template x-for="item in stockCheckResults" :key="item.name">
                            <tr>
                                <td class="p-3 pl-4 font-semibold text-navy" x-text="item.name"></td>
                                <td class="p-3 text-right font-medium" x-text="item.available.toLocaleString('id-ID') + ' Kg'"></td>
                                <td class="p-3 text-right font-semibold text-slate-600" x-text="item.needed.toLocaleString('id-ID') + ' Kg'"></td>
                                <td class="p-3 text-right font-black" :class="item.simulatedLeft >= 0 ? 'text-emerald-700' : 'text-red-600'" x-text="item.simulatedLeft.toLocaleString('id-ID') + ' Kg'"></td>
                                <td class="p-3 text-center">
                                    <span class="px-2 py-0.5 rounded text-xs font-bold" :class="item.simulatedLeft >= 0 ? 'bg-emerald-50 text-emerald-700 border border-emerald-100' : 'bg-red-50 text-red-700 border border-red-100'" x-text="item.simulatedLeft >= 0 ? 'CUKUP' : 'KURANG'"></span>
                                </td>
                                <td class="p-3 text-right pr-4 font-semibold text-slate-700">
                                    <span x-text="item.remainingBatches + ' Batch'"></span>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>

            <!-- Warning Card if Stock Inadequate -->
            <div x-show="!isEnough" class="p-4 rounded-xl bg-red-50 text-red-700 flex items-start gap-3 border border-red-200">
                <svg class="w-5 h-5 flex-shrink-0 mt-0.5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                <div class="text-sm">
                    <p class="font-bold">Peringatan: Stok Beberapa Material Kurang!</p>
                    <p class="mt-1 text-red-600">Ada bahan baku yang tidak mencukupi untuk jumlah batch ini. Harap kurangi jumlah batch atau lakukan pengisian stok di gudang terlebih dahulu.</p>
                </div>
            </div>
            
            <div x-show="isEnough" class="p-4 rounded-xl bg-emerald-50 text-emerald-800 flex items-center gap-3 border border-emerald-200">
                <svg class="w-5 h-5 flex-shrink-0 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <p class="text-sm font-bold">Stok semua material mencukupi! Anda dapat melanjutkan ke pengaturan waktu.</p>
            </div>
        </div>

        <div class="p-6 bg-white border-t border-slate-200 flex justify-end gap-3">
            <a href="{{ route('ppic.calendar') }}" class="px-5 py-2.5 text-sm font-bold text-slate-600 bg-white border border-slate-300 rounded-xl hover:bg-slate-50 transition-colors">Batal</a>
            <button @click.prevent="saveStep1()" class="px-6 py-2.5 text-sm font-bold text-white rounded-xl shadow-md transition-colors flex items-center gap-2" :class="isEnough && qty > 0 ? 'bg-cyan hover:bg-cyan/95 shadow-cyan/30' : 'bg-slate-300 cursor-not-allowed text-slate-500'" :disabled="!isEnough || !qty || qty <= 0">
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
            isEnough: true,
            isEditMode: false,
            editSpk: null,
            stockCheckResults: [],

            masterStocks: {
                'Resin PVC S-65': 8500,
                'Stabilizer Ca-Zn': 45,
                'Pigment White TiO2': 100,
                'Pigment Color Blue': 80
            },

            formulas: {
                'form-a1': [
                    { name: 'Resin PVC S-65', bom: 25 },
                    { name: 'Stabilizer Ca-Zn', bom: 1 },
                    { name: 'Pigment White TiO2', bom: 0.5 }
                ],
                'form-a2': [
                    { name: 'Resin PVC S-65', bom: 25 },
                    { name: 'Stabilizer Ca-Zn', bom: 1.2 },
                    { name: 'Pigment Color Blue', bom: 0.8 }
                ]
            },

            init() {
                // Check if edit mode (from URL query parameter)
                const urlParams = new URLSearchParams(window.location.search);
                const spkId = urlParams.get('id');
                if (spkId) {
                    const allSpks = window.getSPKs() || [];
                    const spk = allSpks.find(s => s.id === spkId);
                    if (spk) {
                        this.isEditMode = true;
                        this.editSpk = spk;
                        this.product = spk.productCode || '';
                        this.formula = spk.formulaCode || '';
                        this.qty = spk.qty;
                        this.checkStock();
                    }
                }

                // Watchers to auto-select formula when product changes
                this.$watch('product', value => {
                    if (value === 'prod-a') this.formula = 'form-a1';
                    else if (value === 'prod-b') this.formula = 'form-a2';
                    else this.formula = '';
                    this.checkStock();
                });

                this.$watch('qty', () => {
                    this.checkStock();
                });
                
                this.$watch('formula', () => {
                    this.checkStock();
                });
            },

            checkStock() {
                if (!this.formula || !this.qty || this.qty <= 0) {
                    this.stockCheckResults = [];
                    this.isEnough = true;
                    return;
                }

                const materials = this.formulas[this.formula] || [];
                let enough = true;
                
                this.stockCheckResults = materials.map(m => {
                    const available = this.masterStocks[m.name] || 0;
                    const needed = m.bom * this.qty;
                    const simulatedLeft = available - needed;
                    if (simulatedLeft < 0) {
                        enough = false;
                    }
                    // Remaining batches this material could support
                    const remainingBatches = Math.floor(available / m.bom);
                    
                    return {
                        name: m.name,
                        available: available,
                        needed: needed,
                        simulatedLeft: simulatedLeft,
                        remainingBatches: remainingBatches
                    };
                });
                
                this.isEnough = enough;
            },

            saveStep1() {
                if (!this.isEnough || !this.qty || this.qty <= 0) return;
                // Save temporary draft to sessionStorage so step 2 can read it
                let currentDraft = {
                    productCode: this.product,
                    formulaCode: this.formula,
                    product: this.product === 'prod-a' ? 'PVC Compound A (Clear)' : 'PVC Compound B (Color)',
                    qty: parseInt(this.qty),
                    materials: this.formulas[this.formula].map(m => ({
                        name: m.name,
                        bom: m.bom,
                        picked: 0,
                        added: 0,
                        status: 'Belum Diambil'
                    }))
                };
                
                if (this.isEditMode && this.editSpk) {
                    currentDraft.id = this.editSpk.id;
                    currentDraft.status = 'Draft'; // Reset status from Revised to Draft
                    currentDraft.revisionNote = ''; // Clear note
                    currentDraft.approvals = { gudang: 'Pending', rnd: 'Pending', pe: 'Pending', qc: 'Pending' };
                }

                sessionStorage.setItem('current_spk_draft', JSON.stringify(currentDraft));
                window.location.href = "{{ route('ppic.create.step2') }}";
            }
        }))
    });
</script>
@endsection
