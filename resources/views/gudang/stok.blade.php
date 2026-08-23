@extends('layouts.app')

@section('title', 'Manajemen Stok & Moving Slip')

@section('content')
<div class="h-full flex flex-col gap-6" x-data="{ tab: 'monitoring' }">
    
    <div class="flex justify-between items-end">
        <div>
            <h3 class="text-xl font-bold text-navy">Manajemen Inventaris</h3>
            <p class="text-sm text-slate-500 mt-1">Pemantauan stok bahan baku (Raw Material) dan pencatatan pergerakan mutasi barang.</p>
        </div>
        
        <div class="inline-flex bg-slate-100 p-1 rounded-xl border border-slate-200 shadow-sm">
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
                <p class="text-2xl font-black text-navy">12,450 <span class="text-sm font-medium text-slate-500">Kg</span></p>
            </div>
            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm border-l-4 border-l-indigo-500">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Total Produk Jadi</p>
                <p class="text-2xl font-black text-navy">3,200 <span class="text-sm font-medium text-slate-500">Batch</span></p>
            </div>
            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm border-l-4 border-l-amber-500">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Stok Menipis (< 10%)</p>
                <p class="text-2xl font-black text-amber-600">3 <span class="text-sm font-medium text-slate-500">Item</span></p>
            </div>
            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm border-l-4 border-l-emerald-500">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Status Gudang</p>
                <p class="text-xl font-bold text-emerald-600 mt-1">Aman (Optimal)</p>
            </div>
        </div>

        <!-- Tabel Monitoring -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden flex-1 flex flex-col">
            <div class="p-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                <h4 class="font-bold text-navy">Daftar Item Inventaris</h4>
                <div class="flex gap-2">
                    <input type="text" class="bg-white border border-slate-200 text-slate-900 text-sm rounded-lg focus:ring-cyan focus:border-cyan px-3 py-2" placeholder="Cari Item/Kode...">
                    <select class="bg-white border border-slate-200 text-slate-700 text-sm rounded-lg px-3 py-2 outline-none">
                        <option>Semua Kategori</option>
                        <option>Raw Material</option>
                        <option>Finished Goods</option>
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
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700">
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="p-4 pl-6 font-semibold text-navy">RM-PVC-001</td>
                            <td class="p-4 font-medium">Resin PVC S-65</td>
                            <td class="p-4"><span class="px-2 py-1 rounded bg-slate-100 text-slate-600 text-xs font-bold">Raw Material</span></td>
                            <td class="p-4 text-right font-bold text-slate-900">8,500</td>
                            <td class="p-4 text-right text-slate-500">Kg</td>
                            <td class="p-4 text-center"><span class="px-2 py-1 rounded bg-emerald-50 text-emerald-700 border border-emerald-100 text-xs font-bold">Aman</span></td>
                        </tr>
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="p-4 pl-6 font-semibold text-navy">ADD-012</td>
                            <td class="p-4 font-medium">Stabilizer Ca-Zn</td>
                            <td class="p-4"><span class="px-2 py-1 rounded bg-slate-100 text-slate-600 text-xs font-bold">Additive</span></td>
                            <td class="p-4 text-right font-bold text-amber-600">45</td>
                            <td class="p-4 text-right text-slate-500">Kg</td>
                            <td class="p-4 text-center"><span class="px-2 py-1 rounded bg-amber-50 text-amber-700 border border-amber-100 text-xs font-bold">Menipis</span></td>
                        </tr>
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
            
            <form class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Jenis Pergerakan</label>
                    <select class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-cyan focus:border-cyan outline-none">
                        <option value="in">Barang Masuk (IN) - Restock</option>
                        <option value="out">Barang Keluar (OUT) - Ke Produksi</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">No. Referensi (SPK/PO)</label>
                    <input type="text" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-cyan outline-none" placeholder="Misal: SPK-2608-001">
                </div>
                <div class="md:col-span-2 border-t border-slate-100 pt-6">
                    <label class="block text-sm font-bold text-slate-700 mb-2">Daftar Item Mutasi</label>
                    <div class="bg-slate-50 rounded-xl border border-slate-200 p-4 mb-4">
                        <div class="flex gap-4">
                            <div class="flex-1">
                                <input type="text" placeholder="Kode / Nama Barang" class="w-full bg-white border border-slate-200 rounded-lg px-3 py-2 text-sm outline-none">
                            </div>
                            <div class="w-32">
                                <input type="number" placeholder="Qty" class="w-full bg-white border border-slate-200 rounded-lg px-3 py-2 text-sm outline-none">
                            </div>
                            <button type="button" class="bg-navy text-white px-4 py-2 rounded-lg text-sm font-bold hover:bg-navy-light transition-colors">Tambah</button>
                        </div>
                    </div>
                </div>
                <div class="md:col-span-2 flex justify-end">
                    <button type="button" class="bg-cyan text-white px-6 py-2.5 rounded-xl font-bold shadow-md shadow-cyan/30 hover:bg-cyan/90 transition-colors">Simpan Moving Slip</button>
                </div>
            </form>
        </div>
        
        <!-- Riwayat Moving Slip -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden flex-1">
            <div class="p-5 border-b border-slate-100 bg-slate-50/50">
                <h4 class="font-bold text-navy">Riwayat Pergerakan (Hari Ini)</h4>
            </div>
            <table class="w-full text-left text-sm">
                <tr class="text-xs uppercase text-slate-500 font-bold border-b border-slate-200 bg-slate-50">
                    <th class="p-3 pl-6">Waktu</th>
                    <th class="p-3">Tipe</th>
                    <th class="p-3">No. Referensi</th>
                    <th class="p-3">Item (Qty)</th>
                    <th class="p-3">User</th>
                </tr>
                <tr class="border-b border-slate-100 text-slate-700">
                    <td class="p-3 pl-6">08:15 WIB</td>
                    <td class="p-3"><span class="text-red-600 font-bold bg-red-50 px-2 py-0.5 rounded border border-red-100">OUT</span></td>
                    <td class="p-3 font-semibold">SPK-2508-011</td>
                    <td class="p-3">RM-PVC-001 (500 Kg)</td>
                    <td class="p-3">Gudang 1</td>
                </tr>
            </table>
        </div>
    </div>
</div>
@endsection
