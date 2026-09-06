<!DOCTYPE html>
<html lang="id" class="bg-[#f4f7fb] text-slate-800">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem SPK - @yield('title', 'Dashboard')</title>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
    <script>
        // Inisialisasi Database SPK di localStorage jika belum ada
        if (!localStorage.getItem('spk_system_db')) {
            const initialSPKs = [
                {
                    id: 'SPK-2608-001',
                    product: 'PVC Compound A (Clear)',
                    productCode: 'prod-a',
                    formulaCode: 'form-a1',
                    qty: 50,
                    startDate: new Date().toISOString().split('T')[0],
                    endDate: new Date(Date.now() + 86400000 * 2).toISOString().split('T')[0],
                    machine: 'Mixer A-01, Ext-1',
                    shift: 'Shift 1 & 2',
                    status: 'Running',
                    subStatus: 'Dalam Penimbangan',
                    revisionNote: '',
                    approvals: { gudang: 'Acc', rnd: 'Acc', pe: 'Acc', qc: 'Acc' },
                    materials: [
                        { name: 'Resin PVC S-65', bom: 25, picked: 1250, added: 1250, status: 'Sesuai' },
                        { name: 'Stabilizer Ca-Zn', bom: 1, picked: 50, added: 50, status: 'Sesuai' },
                        { name: 'Pigment White TiO2', bom: 0.5, picked: 25, added: 25, status: 'Sesuai' }
                    ]
                },
                {
                    id: 'SPK-2608-002',
                    product: 'PVC Compound B (Color)',
                    productCode: 'prod-b',
                    formulaCode: 'form-a2',
                    qty: 30,
                    startDate: new Date(Date.now() + 86400000 * 3).toISOString().split('T')[0],
                    endDate: new Date(Date.now() + 86400000 * 5).toISOString().split('T')[0],
                    machine: 'Mixer B-02, Ext-3',
                    shift: 'Shift 3',
                    status: 'Draft',
                    subStatus: 'Menunggu Approval PE',
                    revisionNote: '',
                    approvals: { gudang: 'Acc', rnd: 'Acc', pe: 'Pending', qc: 'Pending' },
                    materials: [
                        { name: 'Resin PVC S-65', bom: 25, picked: 750, added: 0, status: 'Belum Diambil' },
                        { name: 'Stabilizer Ca-Zn', bom: 1, picked: 30, added: 0, status: 'Belum Diambil' },
                        { name: 'Pigment Color Blue', bom: 0.8, picked: 24, added: 0, status: 'Belum Diambil' }
                    ]
                },
                {
                    id: 'SPK-2608-003',
                    product: 'PVC Compound A (Clear)',
                    productCode: 'prod-a',
                    formulaCode: 'form-a1',
                    qty: 40,
                    startDate: new Date(Date.now() + 86400000 * 6).toISOString().split('T')[0],
                    endDate: new Date(Date.now() + 86400000 * 8).toISOString().split('T')[0],
                    machine: 'Mixer A-01, Ext-1',
                    shift: 'Shift 1',
                    status: 'Draft',
                    subStatus: 'Menunggu Approval Gudang',
                    revisionNote: '',
                    approvals: { gudang: 'Pending', rnd: 'Pending', pe: 'Pending', qc: 'Pending' },
                    materials: [
                        { name: 'Resin PVC S-65', bom: 25, picked: 0, added: 0, status: 'Belum Diambil' },
                        { name: 'Stabilizer Ca-Zn', bom: 1, picked: 0, added: 0, status: 'Belum Diambil' },
                        { name: 'Pigment White TiO2', bom: 0.5, picked: 0, added: 0, status: 'Belum Diambil' }
                    ]
                },
                {
                    id: 'SPK-2608-004',
                    product: 'PVC Compound B (Color)',
                    productCode: 'prod-b',
                    formulaCode: 'form-a2',
                    qty: 15,
                    startDate: new Date(Date.now() + 86400000 * 9).toISOString().split('T')[0],
                    endDate: new Date(Date.now() + 86400000 * 10).toISOString().split('T')[0],
                    machine: 'Mixer B-02, Ext-3',
                    shift: 'Shift 2',
                    status: 'Revised',
                    subStatus: 'Perlu Revisi PPIC',
                    revisionNote: 'Kandungan Stabilizer Ca-Zn perlu disesuaikan dengan suhu mixer baru karena ada risiko pemanasan berlebih pada Ext-3.',
                    approvals: { gudang: 'Acc', rnd: 'Revised', pe: 'Pending', qc: 'Pending' },
                    materials: [
                        { name: 'Resin PVC S-65', bom: 25, picked: 0, added: 0, status: 'Belum Diambil' },
                        { name: 'Stabilizer Ca-Zn', bom: 1, picked: 0, added: 0, status: 'Belum Diambil' },
                        { name: 'Pigment Color Blue', bom: 0.8, picked: 0, added: 0, status: 'Belum Diambil' }
                    ]
                }
            ];
            localStorage.setItem('spk_system_db', JSON.stringify(initialSPKs));
        }

        // Inisialisasi Moving Slip jika belum ada
        if (!localStorage.getItem('moving_slips_db')) {
            const initialSlips = [
                {
                    id: 'MS-2608-001',
                    type: 'OUT',
                    date: '2026-08-27T08:15:00',
                    ref: 'SPK-2608-001',
                    items: [
                        { name: 'Resin PVC S-65', qty: 1250, unit: 'Kg' },
                        { name: 'Stabilizer Ca-Zn', qty: 50, unit: 'Kg' },
                        { name: 'Pigment White TiO2', qty: 25, unit: 'Kg' }
                    ],
                    user: 'Jane Doe'
                }
            ];
            localStorage.setItem('moving_slips_db', JSON.stringify(initialSlips));
        }

        // Helper functions
        window.getSPKs = function() {
            return JSON.parse(localStorage.getItem('spk_system_db'));
        };
        window.saveSPKs = function(spks) {
            localStorage.setItem('spk_system_db', JSON.stringify(spks));
            // Trigger storage event for same-window updates
            window.dispatchEvent(new Event('storage-updated'));
        };
        window.getSlips = function() {
            return JSON.parse(localStorage.getItem('moving_slips_db'));
        };
        window.saveSlips = function(slips) {
            localStorage.setItem('moving_slips_db', JSON.stringify(slips));
            window.dispatchEvent(new Event('storage-updated'));
        };
        window.addMovingSlip = function(refSpk) {
            const spks = window.getSPKs();
            const spk = spks.find(s => s.id === refSpk);
            if (!spk) return;
            
            const slips = window.getSlips();
            const newSlip = {
                id: 'MS-' + Math.floor(Math.random() * 9000 + 1000),
                type: 'OUT',
                date: new Date().toISOString(),
                ref: spk.id,
                items: spk.materials.map(m => ({
                    name: m.name,
                    qty: m.bom * spk.qty,
                    unit: 'Kg'
                })),
                user: 'System (Auto)'
            };
            slips.unshift(newSlip);
            window.saveSlips(slips);
        };
    </script>
    <style type="text/tailwindcss">
        @theme {
            --font-sans: 'Plus Jakarta Sans', sans-serif;
            --color-navy: #112338;
            --color-navy-light: #1c3553;
            --color-cyan: #0ea5e9;
        }
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="antialiased flex h-screen overflow-hidden bg-[#f4f7fb] print:bg-white print:h-auto print:overflow-visible">
    
    <!-- Sidebar -->
    <aside class="w-64 bg-navy text-white border-r border-navy flex flex-col shadow-xl flex-shrink-0 print:hidden">
        <div class="h-16 flex items-center px-6 border-b border-navy-light bg-navy-light/30">
            <h1 class="text-xl font-bold flex items-center gap-2">
                <span class="text-cyan">Sistem</span>SPK
            </h1>
        </div>
        <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
            <p class="px-2 text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Perencanaan (PPIC)</p>
            <a href="{{ route('ppic.calendar') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-slate-300 hover:bg-navy-light hover:text-white transition-colors {{ request()->routeIs('ppic.calendar') ? 'bg-cyan/20 text-cyan font-medium' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                Kalender SPK
            </a>
            <a href="{{ route('ppic.create.step1') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-slate-300 hover:bg-navy-light hover:text-white transition-colors {{ request()->routeIs('ppic.create.*') ? 'bg-cyan/20 text-cyan font-medium' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Buat SPK Baru
            </a>

            <p class="px-2 text-xs font-semibold text-slate-400 uppercase tracking-wider mt-8 mb-2">Inventaris & Stok</p>
            <a href="{{ route('gudang.stok') }}" class="flex items-center justify-between px-3 py-2 rounded-lg text-slate-300 hover:bg-navy-light hover:text-white transition-colors {{ request()->routeIs('gudang.stok') ? 'bg-cyan/20 text-cyan font-medium' : '' }}">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    Manajemen Stok
                </div>
            </a>

            <p class="px-2 text-xs font-semibold text-slate-400 uppercase tracking-wider mt-8 mb-2">Review & Approval</p>
            <a href="{{ route('approval.index') }}" class="flex items-center justify-between px-3 py-2 rounded-lg text-slate-300 hover:bg-navy-light hover:text-white transition-colors {{ request()->routeIs('approval.*') ? 'bg-cyan/20 text-cyan font-medium' : '' }}">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                    Daftar Tunggu
                </div>
                <span class="bg-amber-500/20 text-amber-300 text-xs font-bold px-2 py-0.5 rounded-full border border-amber-500/50">3</span>
            </a>

            <p class="px-2 text-xs font-semibold text-slate-400 uppercase tracking-wider mt-8 mb-2">Departemen Produksi</p>
            <a href="{{ route('produksi.alokasi') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-slate-300 hover:bg-navy-light hover:text-white transition-colors {{ request()->routeIs('produksi.alokasi') ? 'bg-cyan/20 text-cyan font-medium' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                Alokasi Man & Mesin
            </a>
            
            <p class="px-2 text-xs font-semibold text-slate-400 uppercase tracking-wider mt-8 mb-2">Umum & Audit</p>
            <a href="{{ route('spk.detail') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-slate-300 hover:bg-navy-light hover:text-white transition-colors {{ request()->routeIs('spk.*') ? 'bg-cyan/20 text-cyan font-medium' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                SPK Fix & Audit Trail
            </a>
            <a href="{{ route('dokumen.material') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-slate-300 hover:bg-navy-light hover:text-white transition-colors {{ request()->routeIs('dokumen.*') ? 'bg-cyan/20 text-cyan font-medium' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                Dokumen Material
            </a>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col overflow-hidden print:overflow-visible">
        <!-- Topbar -->
        <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-8 flex-shrink-0 shadow-sm z-10 print:hidden">
            <h2 class="text-lg font-bold text-navy">@yield('title')</h2>
            
            <div class="flex items-center gap-4">
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" class="flex items-center gap-2 text-sm font-medium text-slate-600 hover:text-navy bg-slate-100 px-3 py-1.5 rounded-lg transition-colors border border-slate-200">
                        <span class="w-2 h-2 rounded-full bg-cyan"></span>
                        Simulasi Role
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white border border-slate-100 rounded-xl shadow-lg py-1 z-50">
                        <a href="#" class="block px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">PPIC</a>
                        <a href="#" class="block px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">Gudang / Inventory</a>
                        <a href="#" class="block px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">R&D</a>
                        <a href="#" class="block px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">Process Engineering (PE)</a>
                        <a href="#" class="block px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">Quality Control (QC)</a>
                        <a href="#" class="block px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">Kepala Produksi</a>
                    </div>
                </div>
                
                <div class="w-9 h-9 rounded-full bg-navy flex items-center justify-center text-white font-bold text-sm shadow-md">
                    JD
                </div>
            </div>
        </header>

        <!-- Content Area -->
        <div class="flex-1 overflow-y-auto p-8 relative print:overflow-visible print:p-0">
            @yield('content')
        </div>
    </main>
</body>
</html>
