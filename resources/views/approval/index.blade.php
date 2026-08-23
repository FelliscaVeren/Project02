@extends('layouts.app')

@section('title', 'Daftar Tunggu Approval')

@section('content')
<div class="h-full flex flex-col gap-6">
    
    <div class="flex justify-between items-end">
        <div>
            <h3 class="text-lg font-semibold text-slate-800">Kotak Masuk Draft SPK</h3>
            <p class="text-sm text-slate-500">Daftar SPK yang membutuhkan review dan persetujuan departemen Anda.</p>
        </div>
        
        <div class="flex gap-2">
            <span class="inline-flex items-center gap-1.5 py-1.5 px-3 rounded-lg text-xs font-medium bg-amber-100 text-amber-800">
                <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                3 Menunggu Review
            </span>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-xs uppercase tracking-wider text-slate-500 font-semibold">
                        <th class="p-4 pl-6">No. Referensi</th>
                        <th class="p-4">Material</th>
                        <th class="p-4">Tgl Mulai</th>
                        <th class="p-4">Status Review</th>
                        <th class="p-4 pr-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="p-4 pl-6 font-medium text-slate-900">DRF-SPK-2308-01</td>
                        <td class="p-4">PVC Compound A (50 Batch)</td>
                        <td class="p-4">12 Aug 2026</td>
                        <td class="p-4">
                            <div class="flex items-center gap-2">
                                <span class="px-2 py-1 bg-amber-100 text-amber-800 text-xs font-medium rounded">Menunggu Gudang</span>
                                <span class="px-2 py-1 bg-slate-100 text-slate-600 text-xs font-medium rounded">RnD</span>
                            </div>
                        </td>
                        <td class="p-4 pr-6 text-right">
                            <a href="{{ route('approval.review') }}" class="inline-flex items-center justify-center px-4 py-2 bg-white border border-slate-300 rounded-lg text-xs font-medium text-slate-700 hover:bg-slate-50 transition-colors">Review</a>
                        </td>
                    </tr>
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="p-4 pl-6 font-medium text-slate-900">DRF-SPK-2308-02</td>
                        <td class="p-4">PVC Compound B (30 Batch)</td>
                        <td class="p-4">15 Aug 2026</td>
                        <td class="p-4">
                            <div class="flex items-center gap-2">
                                <span class="px-2 py-1 bg-emerald-100 text-emerald-800 text-xs font-medium rounded">Gudang (Acc)</span>
                                <span class="px-2 py-1 bg-amber-100 text-amber-800 text-xs font-medium rounded">Menunggu RnD</span>
                            </div>
                        </td>
                        <td class="p-4 pr-6 text-right">
                            <a href="{{ route('approval.review') }}" class="inline-flex items-center justify-center px-4 py-2 bg-white border border-slate-300 rounded-lg text-xs font-medium text-slate-700 hover:bg-slate-50 transition-colors">Review</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
