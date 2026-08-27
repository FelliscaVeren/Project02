@extends('layouts.app')

@section('title', 'Daftar Tunggu Approval')

@section('content')
<div class="h-full flex flex-col gap-6" x-data="approvalInbox()" x-init="init()">
    
    <div class="flex justify-between items-end">
        <div>
            <h3 class="text-lg font-semibold text-slate-800">Kotak Masuk Draft SPK</h3>
            <p class="text-sm text-slate-500">Daftar SPK yang membutuhkan review dan persetujuan departemen Anda.</p>
        </div>
        
        <div class="flex gap-2">
            <span class="inline-flex items-center gap-1.5 py-1.5 px-3 rounded-lg text-xs font-medium bg-amber-100 text-amber-800">
                <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                <span x-text="pendingCount()"></span> Menunggu Review
            </span>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-xs uppercase tracking-wider text-slate-500 font-semibold">
                        <th class="p-4 pl-6">No. Referensi</th>
                        <th class="p-4">Material / Produk</th>
                        <th class="p-4">Tgl Mulai</th>
                        <th class="p-4">Status Review</th>
                        <th class="p-4">Catatan Revisi</th>
                        <th class="p-4 pr-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                    <template x-for="spk in pendingSpks" :key="spk.id">
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="p-4 pl-6 font-bold text-navy" x-text="spk.id"></td>
                            <td class="p-4">
                                <span class="font-semibold" x-text="spk.product"></span>
                                <span class="text-slate-500 text-xs block" x-text="spk.qty + ' Batch'"></span>
                            </td>
                            <td class="p-4" x-text="formatDate(spk.startDate)"></td>
                            <td class="p-4">
                                <div class="flex flex-col gap-1">
                                    <div class="flex items-center gap-1.5">
                                        <span class="px-1.5 py-0.5 rounded text-[10px]" :class="spk.approvals.gudang === 'Acc' ? 'bg-emerald-50 text-emerald-700 font-bold border border-emerald-100' : 'bg-amber-50 text-amber-600 border border-amber-100'">Gudang</span>
                                        <span class="px-1.5 py-0.5 rounded text-[10px]" :class="spk.approvals.rnd === 'Acc' ? 'bg-emerald-50 text-emerald-700 font-bold border border-emerald-100' : (spk.approvals.rnd === 'Revised' ? 'bg-red-50 text-red-700 font-bold border border-red-100' : 'bg-amber-50 text-amber-600 border border-amber-100')">R&D</span>
                                        <span class="px-1.5 py-0.5 rounded text-[10px]" :class="spk.approvals.pe === 'Acc' ? 'bg-emerald-50 text-emerald-700 font-bold border border-emerald-100' : 'bg-amber-50 text-amber-600 border border-amber-100'">PE</span>
                                    </div>
                                    <span class="text-[10px] text-slate-400 font-medium" x-text="'Induk: ' + spk.status"></span>
                                </div>
                            </td>
                            <td class="p-4 max-w-xs">
                                <template x-if="spk.status === 'Revised'">
                                    <div class="p-2 rounded bg-red-50 text-red-700 text-xs border border-red-100 italic" x-text="spk.revisionNote"></div>
                                </template>
                                <template x-if="spk.status !== 'Revised'">
                                    <span class="text-slate-400 text-xs italic">- Tidak ada -</span>
                                </template>
                            </td>
                            <td class="p-4 pr-6 text-right">
                                <a :href="'{{ route('approval.review') }}?id=' + spk.id" class="inline-flex items-center justify-center px-4 py-2 bg-white border border-slate-300 rounded-lg text-xs font-bold text-slate-700 hover:bg-slate-50 transition-colors">Review / Verifikasi</a>
                            </td>
                        </tr>
                    </template>
                    <template x-if="pendingSpks.length === 0">
                        <tr>
                            <td colspan="6" class="p-10 text-center text-slate-400 font-medium">Kotak masuk approval kosong.</td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('approvalInbox', () => ({
            pendingSpks: [],

            init() {
                this.loadSpks();
                window.addEventListener('storage-updated', () => {
                    this.loadSpks();
                });
            },

            loadSpks() {
                const all = window.getSPKs() || [];
                // Show draft or revised
                this.pendingSpks = all.filter(s => s.status === 'Draft' || s.status === 'Revised');
            },

            pendingCount() {
                return this.pendingSpks.filter(s => s.status === 'Draft').length;
            },

            formatDate(dStr) {
                if (!dStr) return '';
                const options = { day: 'numeric', month: 'short', year: 'numeric' };
                return new Date(dStr).toLocaleDateString('id-ID', options);
            }
        }));
    });
</script>
@endsection
