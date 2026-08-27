@extends('layouts.app')

@section('title', 'Manajemen Stok & Moving Slip')

@section('content')
<div class="h-full flex flex-col gap-6" x-data="inventoryDashboard()" x-init="init()">
    
    <div class="flex justify-between items-end">
        <div>
            <h3 class="text-xl font-bold text-navy">Manajemen Inventaris & Stok</h3>
            <p class="text-sm text-slate-500 mt-1">Pemantauan stok bahan baku (Raw Material) khusus untuk pemantauan (monitoring) stok dan pelacakan pergerakan mutasi.</p>
        </div>
        
        <div class="inline-flex bg-slate-100 p-1 rounded-xl border border-slate-200 shadow-sm print:hidden">
            <button @click="tab = 'monitoring'" :class="{'bg-white shadow-sm text-cyan font-bold': tab === 'monitoring', 'text-slate-500 font-medium': tab !== 'monitoring'}" class="px-6 py-2 text-sm rounded-lg transition-all">
                Monitoring Stok Real-time
            </button>
            <button @click="tab = 'moving'" :class="{'bg-white shadow-sm text-cyan font-bold': tab === 'moving', 'text-slate-500 font-medium': tab !== 'moving'}" class="px-6 py-2 text-sm rounded-lg transition-all">
                Moving Slip (Mutasi)
            </button>
        </div>
    </div>

    <!-- Tab Monitoring Stok -->
    <div class="flex-1 flex flex-col gap-6" x-show="tab === 'monitoring'">
        
        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm border-l-4 border-l-cyan">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Total Raw Material</p>
                <p class="text-2xl font-black text-navy">8,725 <span class="text-sm font-medium text-slate-500">Kg</span></p>
            </div>
            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm border-l-4 border-l-indigo-500">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Total Kategori Item</p>
                <p class="text-2xl font-black text-navy">4 <span class="text-sm font-medium text-slate-500">Item</span></p>
            </div>
            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm border-l-4 border-l-amber-500">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Stok Menipis (< 100Kg)</p>
                <p class="text-2xl font-black text-amber-600">1 <span class="text-sm font-medium text-slate-500">Item</span></p>
            </div>
            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm border-l-4 border-l-emerald-500">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Status Gudang</p>
                <p class="text-xl font-bold text-emerald-600 mt-1">Aman (Optimal)</p>
            </div>
        </div>

        <!-- Tabel Monitoring -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden flex-1 flex flex-col">
            <div class="p-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                <h4 class="font-bold text-navy">Daftar Item Inventaris (Monitoring Khusus)</h4>
                <div class="flex gap-2">
                    <input type="text" x-model="searchQuery" class="bg-white border border-slate-200 text-slate-900 text-sm rounded-lg focus:ring-cyan focus:border-cyan px-3 py-2" placeholder="Cari Item/Kode...">
                    <select x-model="categoryFilter" class="bg-white border border-slate-200 text-slate-700 text-sm rounded-lg px-3 py-2 outline-none">
                        <option value="">Semua Kategori</option>
                        <option value="Raw Material">Raw Material</option>
                        <option value="Additive">Additive</option>
                    </select>
                </div>
            </div>
            <div class="overflow-auto flex-1">
                <table class="w-full text-left border-collapse text-sm">
                    <thead class="bg-slate-50 sticky top-0">
                        <tr class="text-xs uppercase tracking-wider text-slate-500 font-bold border-b border-slate-200">
                            <th class="p-4 pl-6">Kode Item</th>
                            <th class="p-4">Deskripsi / Nama Barang</th>
                            <th class="p-4">Kategori</th>
                            <th class="p-4 text-right">Stok Fisik</th>
                            <th class="p-4 text-right">Satuan</th>
                            <th class="p-4 text-center">Status</th>
                            <th class="p-4 text-center">Detail Lot</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700">
                        <template x-for="item in filteredStocks()" :key="item.code">
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="p-4 pl-6 font-semibold text-navy" x-text="item.code"></td>
                                <td class="p-4 font-medium" x-text="item.name"></td>
                                <td class="p-4"><span class="px-2 py-1 rounded bg-slate-100 text-slate-600 text-xs font-bold" x-text="item.category"></span></td>
                                <td class="p-4 text-right font-bold text-slate-900" x-text="item.qty.toLocaleString('id-ID')"></td>
                                <td class="p-4 text-right text-slate-500" x-text="item.unit"></td>
                                <td class="p-4 text-center">
                                    <span class="px-2 py-1 rounded text-xs font-bold" 
                                          :class="item.status === 'Aman' ? 'bg-emerald-50 text-emerald-700 border border-emerald-100' : 'bg-amber-50 text-amber-700 border border-amber-100'"
                                          x-text="item.status"></span>
                                </td>
                                <td class="p-4 text-center">
                                    <button @click="viewLotDetails(item)" class="px-3 py-1.5 bg-slate-100 hover:bg-cyan hover:text-white border border-slate-200 text-navy font-bold text-xs rounded-lg transition-all shadow-sm">
                                        Detail Lot
                                    </button>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Tab Moving Slip -->
    <div class="flex-1 flex flex-col gap-6" x-show="tab === 'moving'" style="display: none;">
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
            <h4 class="text-lg font-bold text-navy mb-2">Pencatatan Moving Slip</h4>
            <p class="text-sm text-slate-500 mb-6">Formulir untuk melacak mutasi barang (Masuk/Keluar) dari gudang secara real-time.</p>
            
            <form class="grid grid-cols-1 md:grid-cols-2 gap-6" @submit.prevent="createManualSlip()">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Jenis Pergerakan</label>
                    <select x-model="formMoveType" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-cyan focus:border-cyan outline-none">
                        <option value="IN">Barang Masuk (IN) - Restock</option>
                        <option value="OUT">Barang Keluar (OUT) - Ke Produksi</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">No. Referensi (SPK/PO)</label>
                    <input type="text" x-model="formRef" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-cyan outline-none" placeholder="Misal: SPK-2608-001" required>
                </div>
                <div class="md:col-span-2 border-t border-slate-100 pt-6">
                    <label class="block text-sm font-bold text-slate-700 mb-2">Daftar Item Mutasi</label>
                    <div class="bg-slate-50 rounded-xl border border-slate-200 p-4 mb-4">
                        <div class="flex gap-4">
                            <div class="flex-1">
                                <select x-model="formItemName" class="w-full bg-white border border-slate-200 rounded-lg px-3 py-2.5 text-sm outline-none">
                                    <option value="">-- Pilih Item --</option>
                                    <option value="Resin PVC S-65">Resin PVC S-65</option>
                                    <option value="Stabilizer Ca-Zn">Stabilizer Ca-Zn</option>
                                    <option value="Pigment White TiO2">Pigment White TiO2</option>
                                    <option value="Pigment Color Blue">Pigment Color Blue</option>
                                </select>
                            </div>
                            <div class="w-32">
                                <input type="number" x-model="formItemQty" placeholder="Qty (Kg)" class="w-full bg-white border border-slate-200 rounded-lg px-3 py-2 text-sm outline-none">
                            </div>
                            <button type="button" @click="addItemToForm()" class="bg-navy text-white px-4 py-2 rounded-lg text-sm font-bold hover:bg-navy-light transition-colors">Tambah</button>
                        </div>
                        
                        <!-- Temporary items on form -->
                        <div class="mt-3 space-y-1" x-show="formItems.length > 0">
                            <template x-for="(fi, idx) in formItems" :key="idx">
                                <div class="bg-white px-3 py-1.5 rounded-lg border border-slate-200 flex justify-between items-center text-xs">
                                    <span class="font-bold text-navy" x-text="fi.name"></span>
                                    <div>
                                        <span class="font-semibold text-slate-600" x-text="fi.qty + ' ' + fi.unit"></span>
                                        <button type="button" @click="removeItemFromForm(idx)" class="text-red-500 font-bold ml-3 hover:underline">Hapus</button>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
                <div class="md:col-span-2 flex justify-end">
                    <button type="submit" class="bg-cyan text-white px-6 py-2.5 rounded-xl font-bold shadow-md shadow-cyan/30 hover:bg-cyan/90 transition-colors">Simpan Moving Slip</button>
                </div>
            </form>
        </div>
        
        <!-- Riwayat Moving Slip -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden flex-1 flex flex-col">
            <div class="p-5 border-b border-slate-100 bg-slate-50/50 flex flex-col md:flex-row md:justify-between md:items-center gap-3">
                <h4 class="font-bold text-navy">Riwayat Pergerakan Barang (Moving Slip)</h4>
                
                <!-- Date Range Filter -->
                <div class="flex items-center gap-2 text-xs">
                    <span class="font-bold text-slate-500">Filter Tanggal:</span>
                    <input type="date" x-model="startDateFilter" class="bg-white border border-slate-200 rounded-lg p-1.5 text-slate-700 focus:ring-cyan focus:border-cyan">
                    <span class="text-slate-400">s/d</span>
                    <input type="date" x-model="endDateFilter" class="bg-white border border-slate-200 rounded-lg p-1.5 text-slate-700 focus:ring-cyan focus:border-cyan">
                    <button type="button" @click="clearDateFilter()" class="text-slate-400 hover:text-red-500 font-semibold underline">Clear</button>
                </div>
            </div>
            
            <div class="overflow-auto flex-1">
                <table class="w-full text-left text-sm border-collapse">
                    <thead class="bg-slate-50 border-b border-slate-200 sticky top-0">
                        <tr class="text-xs uppercase text-slate-500 font-bold">
                            <th class="p-4 pl-6">Waktu Transaksi</th>
                            <th class="p-4">Tipe</th>
                            <th class="p-4">No. Referensi (SPK/PO)</th>
                            <th class="p-4">Detail Mutasi Item (Qty)</th>
                            <th class="p-4 pr-6">Operator</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700">
                        <template x-for="slip in filteredSlips()" :key="slip.id">
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="p-4 pl-6 font-medium" x-text="formatDateTime(slip.date)"></td>
                                <td class="p-4">
                                    <span class="px-2 py-0.5 rounded text-xs font-bold border" 
                                          :class="slip.type === 'IN' ? 'bg-emerald-50 text-emerald-700 border-emerald-100' : 'bg-red-50 text-red-700 border-red-100'"
                                          x-text="slip.type"></span>
                                </td>
                                <td class="p-4 font-semibold text-navy" x-text="slip.ref"></td>
                                <td class="p-4">
                                    <div class="flex flex-col gap-0.5">
                                        <template x-for="mi in slip.items">
                                            <span class="text-xs" x-text="mi.name + ' (' + mi.qty.toLocaleString('id-ID') + ' ' + mi.unit + ')'"></span>
                                        </template>
                                    </div>
                                </td>
                                <td class="p-4 pr-6 text-slate-500" x-text="slip.user"></td>
                            </tr>
                        </template>
                        <template x-if="filteredSlips().length === 0">
                            <tr>
                                <td colspan="5" class="p-10 text-center text-slate-400 font-medium">Tidak ada data riwayat pergerakan pada rentang tanggal ini.</td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- MODAL DETAIL LOT BARANG -->
    <div x-show="showLotModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center p-4" style="display: none;" x-transition>
        <div class="bg-white rounded-3xl border border-slate-200 shadow-2xl max-w-xl w-full overflow-hidden" @click.away="showLotModal = false">
            <div class="p-6 bg-navy text-white flex justify-between items-center">
                <div>
                    <span class="text-xs font-bold text-cyan uppercase tracking-wide">Pelacakan Penerimaan Lot (Lot Tracking)</span>
                    <h3 class="text-xl font-bold" x-text="selectedMaterial?.name"></h3>
                </div>
                <button @click="showLotModal = false" class="text-slate-300 hover:text-white transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <div class="p-6 space-y-4 max-h-[60vh] overflow-y-auto">
                <div class="flex justify-between items-center text-sm font-semibold text-slate-700 bg-slate-50 p-3 rounded-xl border border-slate-100">
                    <span>Total Stok Saat Ini</span>
                    <span class="text-navy font-bold text-base" x-text="(selectedMaterial?.qty || 0).toLocaleString('id-ID') + ' ' + (selectedMaterial?.unit || 'Kg')"></span>
                </div>
                
                <div class="border border-slate-200 rounded-xl overflow-hidden shadow-sm">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-50 border-b border-slate-200">
                            <tr class="text-[10px] uppercase text-slate-500 font-bold">
                                <th class="p-3 pl-4">Nomor Lot</th>
                                <th class="p-3 text-right">Kuantitas Lot</th>
                                <th class="p-3">Tanggal Penerimaan</th>
                                <th class="p-3">Supplier</th>
                                <th class="p-3 text-center pr-4">Status QC</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-700">
                            <template x-for="lot in selectedMaterial?.lots" :key="lot.no">
                                <tr class="hover:bg-slate-50">
                                    <td class="p-3 pl-4 font-bold text-navy" x-text="lot.no"></td>
                                    <td class="p-3 text-right font-semibold text-slate-900" x-text="lot.qty.toLocaleString('id-ID') + ' ' + selectedMaterial.unit"></td>
                                    <td class="p-3" x-text="lot.arrival"></td>
                                    <td class="p-3" x-text="lot.supplier"></td>
                                    <td class="p-3 text-center pr-4">
                                        <span class="px-1.5 py-0.5 rounded text-[9px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-100" x-text="lot.qcStatus"></span>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="p-6 bg-slate-50 border-t border-slate-100 flex justify-end">
                <button @click="showLotModal = false" class="px-6 py-2 text-sm font-bold text-slate-600 bg-white border border-slate-300 rounded-xl hover:bg-slate-50 transition-colors">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('inventoryDashboard', () => ({
            tab: 'monitoring',
            searchQuery: '',
            categoryFilter: '',
            startDateFilter: '',
            endDateFilter: '',
            showLotModal: false,
            selectedMaterial: null,
            slips: [],

            // Data Inventaris Monitored
            stocks: [
                {
                    code: 'RM-PVC-001',
                    name: 'Resin PVC S-65',
                    category: 'Raw Material',
                    qty: 8500,
                    unit: 'Kg',
                    status: 'Aman',
                    lots: [
                        { no: 'Lot 1 (S-65)', qty: 3500, arrival: '12 Aug 2026', supplier: 'IndoResin Corp', qcStatus: 'APPROVED' },
                        { no: 'Lot 2 (S-65)', qty: 3000, arrival: '18 Aug 2026', supplier: 'IndoResin Corp', qcStatus: 'APPROVED' },
                        { no: 'Lot 3 (S-65)', qty: 2000, arrival: '25 Aug 2026', supplier: 'Nippon Chemical', qcStatus: 'APPROVED' }
                    ]
                },
                {
                    code: 'ADD-012',
                    name: 'Stabilizer Ca-Zn',
                    category: 'Additive',
                    qty: 45,
                    unit: 'Kg',
                    status: 'Menipis',
                    lots: [
                        { no: 'Lot 1 (Ca-Zn)', qty: 25, arrival: '05 Aug 2026', supplier: 'Additives Indonesia', qcStatus: 'APPROVED' },
                        { no: 'Lot 2 (Ca-Zn)', qty: 20, arrival: '15 Aug 2026', supplier: 'Additives Indonesia', qcStatus: 'APPROVED' }
                    ]
                },
                {
                    code: 'ADD-018',
                    name: 'Pigment White TiO2',
                    category: 'Additive',
                    qty: 100,
                    unit: 'Kg',
                    status: 'Aman',
                    lots: [
                        { no: 'Lot 1 (TiO2)', qty: 50, arrival: '10 Aug 2026', supplier: 'Global Pigment', qcStatus: 'APPROVED' },
                        { no: 'Lot 2 (TiO2)', qty: 50, arrival: '20 Aug 2026', supplier: 'Global Pigment', qcStatus: 'APPROVED' }
                    ]
                },
                {
                    code: 'ADD-025',
                    name: 'Pigment Color Blue',
                    category: 'Additive',
                    qty: 80,
                    unit: 'Kg',
                    status: 'Aman',
                    lots: [
                        { no: 'Lot 1 (Blue)', qty: 40, arrival: '11 Aug 2026', supplier: 'Global Pigment', qcStatus: 'APPROVED' },
                        { no: 'Lot 2 (Blue)', qty: 40, arrival: '22 Aug 2026', supplier: 'Global Pigment', qcStatus: 'APPROVED' }
                    ]
                }
            ],

            // Form inputs
            formMoveType: 'IN',
            formRef: '',
            formItemName: '',
            formItemQty: '',
            formItems: [],

            init() {
                this.loadSlips();
                window.addEventListener('storage-updated', () => {
                    this.loadSlips();
                });
            },

            loadSlips() {
                this.slips = window.getSlips() || [];
            },

            filteredStocks() {
                const query = this.searchQuery.toLowerCase().trim();
                return this.stocks.filter(s => {
                    if (this.categoryFilter && s.category !== this.categoryFilter) return false;
                    if (query) {
                        return s.code.toLowerCase().includes(query) || s.name.toLowerCase().includes(query);
                    }
                    return true;
                });
            },

            viewLotDetails(material) {
                this.selectedMaterial = material;
                this.showLotModal = true;
            },

            addItemToForm() {
                if (!this.formItemName || !this.formItemQty || this.formItemQty <= 0) {
                    alert('Harap pilih item dan tentukan Qty valid.');
                    return;
                }
                this.formItems.push({
                    name: this.formItemName,
                    qty: parseFloat(this.formItemQty),
                    unit: 'Kg'
                });
                this.formItemName = '';
                this.formItemQty = '';
            },

            removeItemFromForm(idx) {
                this.formItems.splice(idx, 1);
            },

            createManualSlip() {
                if (this.formItems.length === 0) {
                    alert('Daftar item mutasi tidak boleh kosong.');
                    return;
                }
                
                const slips = window.getSlips() || [];
                const newSlip = {
                    id: 'MS-' + Math.floor(Math.random() * 9000 + 1000),
                    type: this.formMoveType,
                    date: new Date().toISOString(),
                    ref: this.formRef,
                    items: this.formItems,
                    user: 'Jane Doe' // User Simulasi
                };
                
                slips.unshift(newSlip);
                window.saveSlips(slips);
                
                // Reset form
                this.formRef = '';
                this.formItems = [];
                this.tab = 'moving'; // Keep on tab moving to see result
                
                alert(`Moving Slip ${newSlip.id} berhasil disimpan!`);
            },

            filteredSlips() {
                return this.slips.filter(s => {
                    const slipDate = s.date.split('T')[0];
                    if (this.startDateFilter && slipDate < this.startDateFilter) return false;
                    if (this.endDateFilter && slipDate > this.endDateFilter) return false;
                    return true;
                });
            },

            clearDateFilter() {
                this.startDateFilter = '';
                this.endDateFilter = '';
            },

            formatDateTime(dateStr) {
                if (!dateStr) return '';
                const date = new Date(dateStr);
                const options = { day: 'numeric', month: 'short', year: 'numeric' };
                const time = String(date.getHours()).padStart(2, '0') + ':' + String(date.getMinutes()).padStart(2, '0');
                return date.toLocaleDateString('id-ID', options) + ' ' + time + ' WIB';
            }
        }));
    });
</script>
@endsection
