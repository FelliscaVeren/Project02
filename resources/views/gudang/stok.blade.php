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
            <button @click="tab = 'moving'" :class="{'bg-white shadow-sm text-cyan font-bold': tab === 'moving', 'text-slate-500 font-medium': tab !== 'moving'}" class="px-6 py-2 text-sm rounded-lg transition-all flex items-center gap-2">
                Moving Slip (Mutasi)
                <span class="bg-amber-500 text-white text-[9px] px-1.5 py-0.5 rounded font-bold">Auto</span>
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

        <!-- Tabel Monitoring & Lot -->
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
            <div class="overflow-auto flex-1 p-0">
                <table class="w-full text-left text-sm" x-data="{ expanded: null }">
                    <thead class="bg-slate-50 sticky top-0 z-10 shadow-sm">
                        <tr class="text-xs uppercase tracking-wider text-slate-500 font-bold border-b border-slate-200">
                            <th class="p-4 pl-6">Kode Item</th>
                            <th class="p-4">Deskripsi / Nama Barang</th>
                            <th class="p-4">Kategori</th>
                            <th class="p-4 text-right">Total Stok Fisik</th>
                            <th class="p-4 text-center">Status</th>
                            <th class="p-4 text-center">Aksi (Lot Tracker)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700">
                        
                        <!-- Row 1 -->
                        <tr class="hover:bg-slate-50 transition-colors cursor-pointer" @click="expanded = expanded === 1 ? null : 1">
                            <td class="p-4 pl-6 font-semibold text-navy">RM-PVC-001</td>
                            <td class="p-4 font-medium">Resin PVC S-65</td>
                            <td class="p-4"><span class="px-2 py-1 rounded bg-slate-100 text-slate-600 text-[10px] font-bold">Raw Material</span></td>
                            <td class="p-4 text-right font-bold text-slate-900">8,500 <span class="text-xs font-normal text-slate-500">Kg</span></td>
                            <td class="p-4 text-center"><span class="px-2 py-1 rounded bg-emerald-50 text-emerald-700 border border-emerald-100 text-[10px] font-bold">Aman</span></td>
                            <td class="p-4 text-center">
                                <button class="px-3 py-1 bg-white border border-slate-300 text-slate-600 hover:bg-slate-50 rounded-lg text-xs font-bold transition-all inline-flex items-center gap-1 shadow-sm">
                                    <span x-text="expanded === 1 ? 'Tutup Detail' : 'Detail Lot'"></span>
                                    <svg class="w-3 h-3 transition-transform" :class="expanded === 1 ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </button>
                            </td>
                        </tr>
                        <!-- Expandable Lot Details for Row 1 -->
                        <tr x-show="expanded === 1" x-transition class="bg-slate-50/50">
                            <td colspan="6" class="p-0">
                                <div class="px-8 py-4 border-l-4 border-cyan">
                                    <p class="text-xs font-bold text-navy mb-2 uppercase tracking-wide">Riwayat Kedatangan Barang (Tracking per Lot)</p>
                                    <table class="w-full text-xs text-left">
                                        <tr class="text-slate-500 border-b border-slate-200">
                                            <th class="py-2 w-32">Nomor Lot</th>
                                            <th class="py-2">Tanggal Masuk (IN)</th>
                                            <th class="py-2">Supplier</th>
                                            <th class="py-2 text-right">Kuantitas</th>
                                            <th class="py-2 pl-4">Catatan QC</th>
                                        </tr>
                                        <tr class="border-b border-slate-100">
                                            <td class="py-2 font-bold text-slate-700">LOT-001-A</td>
                                            <td class="py-2">01 Aug 2026</td>
                                            <td class="py-2">PT. Chemindo</td>
                                            <td class="py-2 text-right font-medium">3,500 Kg</td>
                                            <td class="py-2 pl-4 text-emerald-600 font-medium">Lolos Uji</td>
                                        </tr>
                                        <tr>
                                            <td class="py-2 font-bold text-slate-700">LOT-001-B</td>
                                            <td class="py-2">10 Aug 2026</td>
                                            <td class="py-2">PT. Chemindo</td>
                                            <td class="py-2 text-right font-medium">5,000 Kg</td>
                                            <td class="py-2 pl-4 text-emerald-600 font-medium">Lolos Uji</td>
                                        </tr>
                                    </table>
                                </div>
                            </td>
                        </tr>

                        <!-- Row 2 -->
                        <tr class="hover:bg-slate-50 transition-colors cursor-pointer" @click="expanded = expanded === 2 ? null : 2">
                            <td class="p-4 pl-6 font-semibold text-navy">ADD-012</td>
                            <td class="p-4 font-medium">Stabilizer Ca-Zn</td>
                            <td class="p-4"><span class="px-2 py-1 rounded bg-slate-100 text-slate-600 text-[10px] font-bold">Additive</span></td>
                            <td class="p-4 text-right font-bold text-amber-600">45 <span class="text-xs font-normal text-slate-500">Kg</span></td>
                            <td class="p-4 text-center"><span class="px-2 py-1 rounded bg-amber-50 text-amber-700 border border-amber-100 text-[10px] font-bold">Menipis</span></td>
                            <td class="p-4 text-center">
                                <button class="px-3 py-1 bg-white border border-slate-300 text-slate-600 hover:bg-slate-50 rounded-lg text-xs font-bold transition-all inline-flex items-center gap-1 shadow-sm">
                                    <span x-text="expanded === 2 ? 'Tutup Detail' : 'Detail Lot'"></span>
                                    <svg class="w-3 h-3 transition-transform" :class="expanded === 2 ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </button>
                            </td>
                        </tr>
                        <!-- Expandable Lot Details for Row 2 -->
                        <tr x-show="expanded === 2" x-transition class="bg-slate-50/50">
                            <td colspan="6" class="p-0">
                                <div class="px-8 py-4 border-l-4 border-amber-400">
                                    <p class="text-xs font-bold text-navy mb-2 uppercase tracking-wide">Riwayat Kedatangan Barang (Tracking per Lot)</p>
                                    <table class="w-full text-xs text-left">
                                        <tr class="text-slate-500 border-b border-slate-200">
                                            <th class="py-2 w-32">Nomor Lot</th>
                                            <th class="py-2">Tanggal Masuk (IN)</th>
                                            <th class="py-2">Supplier</th>
                                            <th class="py-2 text-right">Kuantitas</th>
                                            <th class="py-2 pl-4">Catatan QC</th>
                                        </tr>
                                        <tr>
                                            <td class="py-2 font-bold text-slate-700">LOT-STB-11</td>
                                            <td class="py-2">20 Jul 2026</td>
                                            <td class="py-2">CV. Maju Jaya</td>
                                            <td class="py-2 text-right font-medium text-amber-600">45 Kg (Sisa)</td>
                                            <td class="py-2 pl-4 text-emerald-600 font-medium">Lolos Uji</td>
                                        </tr>
                                    </table>
                                </div>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Tab Moving Slip -->
    <div class="flex-1 flex flex-col gap-6" x-show="tab === 'moving'" style="display: none;">
        
        <!-- Notifikasi Auto Generate -->
        <div class="bg-cyan/10 border border-cyan/20 p-4 rounded-xl flex items-center gap-3">
            <div class="p-2 bg-cyan text-white rounded-lg"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg></div>
            <div>
                <p class="font-bold text-navy text-sm">Integrasi Sistem (Auto-Generate)</p>
                <p class="text-xs text-slate-600 mt-0.5">Sistem akan secara otomatis me-generate Moving Slip (OUT) ketika status dokumen SPK diubah menjadi 'Released' atau material ditarik ke produksi.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 h-full flex-1">
            
            <!-- Manual Form -->
            <div class="lg:col-span-1 bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex flex-col">
                <h4 class="text-base font-bold text-navy mb-1">Manual Moving Slip</h4>
                <p class="text-xs text-slate-500 mb-6">Pencatatan mutasi manual untuk retur atau stok tambahan.</p>
                
                <form class="space-y-4 flex-1">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Jenis Pergerakan</label>
                        <select class="w-full bg-slate-50 border border-slate-200 rounded-lg px-3 py-2 text-sm focus:ring-cyan outline-none">
                            <option value="in">Barang Masuk (IN) - Restock / Retur</option>
                            <option value="out">Barang Keluar (OUT) - Scrap</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">No. Referensi / PO</label>
                        <input type="text" class="w-full bg-slate-50 border border-slate-200 rounded-lg px-3 py-2 text-sm focus:ring-cyan outline-none" placeholder="Misal: PO-1234">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Barang & Kuantitas</label>
                        <div class="flex gap-2">
                            <input type="text" placeholder="Kode Barang" class="flex-1 bg-white border border-slate-200 rounded-lg px-3 py-2 text-sm">
                            <input type="number" placeholder="Qty" class="w-20 bg-white border border-slate-200 rounded-lg px-3 py-2 text-sm">
                        </div>
                    </div>
                </form>
                <div class="pt-4 border-t border-slate-100 mt-auto">
                    <button type="button" class="w-full bg-navy text-white px-4 py-2.5 rounded-lg text-sm font-bold shadow-md hover:bg-navy-light transition-colors">Catat Mutasi Manual</button>
                </div>
            </div>
            
            <!-- Riwayat & Filter Tanggal -->
            <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden flex flex-col relative">
                <div class="p-5 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center z-10">
                    <h4 class="font-bold text-navy">Riwayat Pergerakan (Moving Slip History)</h4>
                    
                    <!-- Date Range Filter -->
                    <div class="flex items-center gap-2">
                        <div class="bg-white border border-slate-200 rounded-lg flex items-center shadow-sm overflow-hidden text-sm">
                            <span class="pl-3 pr-2 text-slate-400"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg></span>
                            <input type="date" class="py-1.5 px-2 outline-none text-slate-700 text-xs">
                            <span class="text-slate-300">-</span>
                            <input type="date" class="py-1.5 px-2 outline-none text-slate-700 text-xs">
                        </div>
                        <button class="px-3 py-1.5 bg-cyan text-white text-xs font-bold rounded-lg shadow-sm hover:bg-cyan/90">Filter</button>
                    </div>
                </div>
                
                <div class="overflow-y-auto flex-1">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-slate-50 sticky top-0 shadow-sm">
                            <tr class="text-[10px] uppercase text-slate-500 font-bold border-b border-slate-200">
                                <th class="p-3 pl-6">Tgl & Waktu</th>
                                <th class="p-3">Tipe</th>
                                <th class="p-3">No. Referensi (System Note)</th>
                                <th class="p-3">Item Ditarik</th>
                                <th class="p-3 text-right">Kuantitas</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-700">
                            <!-- Data Auto Generate -->
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="p-3 pl-6 text-xs font-medium text-slate-500">27 Aug, 14:30</td>
                                <td class="p-3"><span class="text-red-600 font-bold bg-red-50 px-2 py-0.5 rounded text-[10px] border border-red-100">OUT (Auto)</span></td>
                                <td class="p-3 font-semibold text-navy">SPK-2608-001 <span class="block text-[9px] text-slate-400 font-normal">Generated when SPK Released</span></td>
                                <td class="p-3 text-xs">RM-PVC-001 (Resin PVC)</td>
                                <td class="p-3 text-right font-bold text-slate-900">-1,250 Kg</td>
                            </tr>
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="p-3 pl-6 text-xs font-medium text-slate-500">27 Aug, 14:30</td>
                                <td class="p-3"><span class="text-red-600 font-bold bg-red-50 px-2 py-0.5 rounded text-[10px] border border-red-100">OUT (Auto)</span></td>
                                <td class="p-3 font-semibold text-navy">SPK-2608-001 <span class="block text-[9px] text-slate-400 font-normal">Generated when SPK Released</span></td>
                                <td class="p-3 text-xs">ADD-012 (Stabilizer)</td>
                                <td class="p-3 text-right font-bold text-slate-900">-50 Kg</td>
                            </tr>
                            
                            <!-- Manual Data -->
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="p-3 pl-6 text-xs font-medium text-slate-500">20 Jul, 09:15</td>
                                <td class="p-3"><span class="text-emerald-600 font-bold bg-emerald-50 px-2 py-0.5 rounded text-[10px] border border-emerald-100">IN (Manual)</span></td>
                                <td class="p-3 font-semibold text-navy">PO-MJU-992 <span class="block text-[9px] text-slate-400 font-normal">Penerimaan Supplier</span></td>
                                <td class="p-3 text-xs">ADD-012 (Stabilizer)</td>
                                <td class="p-3 text-right font-bold text-emerald-600">+45 Kg</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
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
