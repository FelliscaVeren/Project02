@extends('layouts.app')

@section('title', 'Buat SPK - Langkah 2 (Waktu, Mesin & Manpower)')

@section('content')
<div class="max-w-5xl mx-auto h-full pb-10" x-data="spkStep2()" x-init="init()">
    
    <!-- Progress Indicator -->
    <div class="mb-8">
        <div class="flex items-center">
            <div class="flex items-center text-slate-400 relative cursor-pointer hover:opacity-80 transition-opacity" @click="goBack()">
                <div class="rounded-full transition duration-500 ease-in-out h-10 w-10 py-3 border-2 border-slate-200 bg-white flex items-center justify-center font-bold">1</div>
                <div class="absolute top-0 -ml-10 text-center mt-12 w-32 text-xs font-bold uppercase text-slate-400">Parameter & Formula</div>
            </div>
            <div class="flex-auto border-t-2 transition duration-500 ease-in-out border-cyan"></div>
            <div class="flex items-center text-cyan relative">
                <div class="rounded-full transition duration-500 ease-in-out h-10 w-10 py-3 border-2 border-cyan bg-cyan text-white flex items-center justify-center font-bold">2</div>
                <div class="absolute top-0 -ml-10 text-center mt-12 w-32 text-xs font-bold uppercase text-cyan">Waktu & Manpower</div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden mt-12">
        <div class="p-6 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
            <div>
                <h3 class="text-lg font-bold text-navy">Manajemen Waktu & Alokasi</h3>
                <p class="text-sm text-slate-500">Tentukan jadwal, alokasi jam kerja, mesin, dan estimasi kebutuhan manpower.</p>
            </div>
            <span class="px-3 py-1.5 bg-cyan/10 text-cyan border border-cyan/20 text-xs font-bold rounded-lg shadow-sm" x-text="draftName + ' (' + draftQty + ' Batch)'"></span>
        </div>
        
        <div class="p-6 space-y-8">
            
            <!-- Pengaturan Waktu & Jam Kerja -->
            <section>
                <h4 class="text-sm font-bold text-navy uppercase tracking-wide border-b border-slate-100 pb-2 mb-4 flex items-center gap-2">
                    <svg class="w-4 h-4 text-cyan" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    1. Pengaturan Tanggal & Alokasi Waktu
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Tanggal Mulai (Start)</label>
                        <input type="date" x-model="startDate" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-cyan outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Tanggal Selesai (Finish)</label>
                        <input type="date" x-model="endDate" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-cyan outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Target Jam Kerja (Pemerataan)</label>
                        <div class="relative">
                            <input type="number" class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-4 pr-16 py-2.5 text-sm focus:ring-2 focus:ring-cyan outline-none transition-all" value="24">
                            <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-slate-400 text-sm font-bold">Jam/Hari</div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Alokasi Mesin -->
            <section>
                <h4 class="text-sm font-bold text-navy uppercase tracking-wide border-b border-slate-100 pb-2 mb-4 flex items-center gap-2">
                    <svg class="w-4 h-4 text-cyan" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    2. Alokasi Mesin
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Mixer</label>
                        <select x-model="mixer" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-cyan outline-none transition-all">
                            <option value="Mixer A-01">Mixer A-01</option>
                            <option value="Mixer B-02">Mixer B-02</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Mesin Extruder</label>
                        <select x-model="extruder" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-cyan outline-none transition-all">
                            <option value="Ext-1">Extruder Line 1</option>
                            <option value="Ext-2">Extruder Line 2</option>
                            <option value="Ext-3">Extruder Line 3</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Feeder</label>
                        <select x-model="feeder" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-cyan outline-none transition-all">
                            <option value="Feeder 01">Feeder 01</option>
                            <option value="Feeder 02">Feeder 02</option>
                        </select>
                    </div>
                </div>
            </section>

            <!-- Kebutuhan Manpower -->
            <section>
                <h4 class="text-sm font-bold text-navy uppercase tracking-wide border-b border-slate-100 pb-2 mb-4 flex items-center gap-2">
                    <svg class="w-4 h-4 text-cyan" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    3. Estimasi Kebutuhan Manpower (Per Shift)
                </h4>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="bg-slate-50 p-3 rounded-xl border border-slate-200">
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Penimbangan</label>
                        <input type="number" value="1" class="w-full bg-white border border-slate-200 rounded-lg px-3 py-1.5 text-sm font-bold focus:ring-2 focus:ring-cyan outline-none text-navy">
                    </div>
                    <div class="bg-slate-50 p-3 rounded-xl border border-slate-200">
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Mixing</label>
                        <input type="number" value="1" class="w-full bg-white border border-slate-200 rounded-lg px-3 py-1.5 text-sm font-bold focus:ring-2 focus:ring-cyan outline-none text-navy">
                    </div>
                    <div class="bg-slate-50 p-3 rounded-xl border border-slate-200">
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Extruder</label>
                        <input type="number" value="2" class="w-full bg-white border border-slate-200 rounded-lg px-3 py-1.5 text-sm font-bold focus:ring-2 focus:ring-cyan outline-none text-navy">
                    </div>
                    <div class="bg-slate-50 p-3 rounded-xl border border-slate-200">
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Bagging</label>
                        <input type="number" value="1" class="w-full bg-white border border-slate-200 rounded-lg px-3 py-1.5 text-sm font-bold focus:ring-2 focus:ring-cyan outline-none text-navy">
                    </div>
                </div>
            </section>
        </div>

        <div class="p-6 bg-white border-t border-slate-200 flex justify-between items-center">
            <button @click="goBack()" class="px-5 py-2.5 text-sm font-bold text-slate-600 bg-white border border-slate-300 rounded-xl hover:bg-slate-50 transition-colors flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali
            </button>
            
            <button @click="publishSPK()" class="px-6 py-2.5 text-sm font-bold text-white bg-navy hover:bg-navy-light rounded-xl shadow-md transition-colors flex items-center gap-2">
                Publish ke Daftar Tunggu
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
            </button>
        </div>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('spkStep2', () => ({
            draftData: null,
            draftName: 'PVC Compound',
            draftQty: 0,
            startDate: '',
            endDate: '',
            mixer: 'Mixer A-01',
            extruder: 'Ext-1',
            feeder: 'Feeder 01',

            init() {
                const sessionDraft = sessionStorage.getItem('current_spk_draft');
                if (sessionDraft) {
                    this.draftData = JSON.parse(sessionDraft);
                    this.draftName = this.draftData.product;
                    this.draftQty = this.draftData.qty;
                } else {
                    alert('Data draf tidak ditemukan, silakan mulai dari langkah 1.');
                    window.location.href = "{{ route('ppic.create.step1') }}";
                }
                
                // Set default dates
                const today = new Date();
                this.startDate = today.toISOString().split('T')[0];
                const end = new Date(today.getTime() + 86400000 * 2);
                this.endDate = end.toISOString().split('T')[0];
            },

            goBack() {
                if (this.draftData && this.draftData.id) {
                    window.location.href = `{{ route('ppic.create.step1') }}?id=${this.draftData.id}`;
                } else {
                    window.location.href = "{{ route('ppic.create.step1') }}";
                }
            },

            publishSPK() {
                if (!this.startDate || !this.endDate) {
                    alert('Harap tentukan tanggal mulai dan tanggal selesai.');
                    return;
                }

                const allSpks = window.getSPKs() || [];
                let spkId = this.draftData.id;

                if (!spkId) {
                    // Generate new ID
                    const yearMonth = '2608';
                    const runNo = String(allSpks.length + 1).padStart(3, '0');
                    spkId = `SPK-${yearMonth}-${runNo}`;
                }

                const newSPK = {
                    id: spkId,
                    product: this.draftData.product,
                    productCode: this.draftData.productCode,
                    formulaCode: this.draftData.formulaCode,
                    qty: this.draftData.qty,
                    startDate: this.startDate,
                    endDate: this.endDate,
                    machine: `${this.mixer}, ${this.extruder}`,
                    shift: 'Shift 1 & 2',
                    status: 'Draft',
                    subStatus: 'Menunggu Approval Gudang',
                    revisionNote: '',
                    approvals: { gudang: 'Pending', rnd: 'Pending', pe: 'Pending', qc: 'Pending' },
                    materials: this.draftData.materials
                };

                const existingIndex = allSpks.findIndex(s => s.id === spkId);
                if (existingIndex !== -1) {
                    allSpks[existingIndex] = newSPK; // Update if editing revised
                } else {
                    allSpks.push(newSPK); // Add new
                }

                window.saveSPKs(allSpks);
                sessionStorage.removeItem('current_spk_draft');
                
                // Redirect to waitlist index
                window.location.href = "{{ route('approval.index') }}";
            }
        }));
    });
</script>
@endsection
