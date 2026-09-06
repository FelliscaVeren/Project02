@extends('layouts.app')

@section('title', 'Alokasi Manpower & Mesin (Berbasis Tim Shift)')

@section('content')
<div class="max-w-6xl mx-auto h-full pb-10" x-data="alokasiApp()">

    <!-- Header Info SPK -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 mb-6">
        <div class="flex justify-between items-start flex-wrap gap-4">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">SPK Yang Sedang Dikerjakan</p>
                <h3 class="text-xl font-bold text-navy">SPK-2608-001 · PVC Compound A (Clear)</h3>
                <div class="flex gap-4 mt-2 text-sm text-slate-600">
                    <span class="flex items-center gap-1.5"><svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>27 Aug 06:00 — 29 Aug 22:00</span>
                    <span class="flex items-center gap-1.5"><svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg><span x-text="totalShifts + ' Shift Dibutuhkan'"></span></span>
                    <span class="flex items-center gap-1.5"><svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>40 Jam Total</span>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <!-- Rotasi Tim Minggu Ini -->
                <div class="bg-slate-50 border border-slate-200 rounded-xl p-3 text-xs">
                    <p class="font-bold text-slate-500 uppercase tracking-wider mb-2 text-[10px]">Jadwal Rotasi Minggu Ini</p>
                    <div class="space-y-1">
                        <div class="flex items-center gap-2"><span class="w-3 h-3 rounded-full bg-red-500 flex-shrink-0"></span><span class="font-bold text-slate-700">Shift 1 (06:00-14:00) — Team RED</span></div>
                        <div class="flex items-center gap-2"><span class="w-3 h-3 rounded-full bg-emerald-500 flex-shrink-0"></span><span class="font-bold text-slate-700">Shift 2 (14:00-22:00) — Team GREEN</span></div>
                        <div class="flex items-center gap-2"><span class="w-3 h-3 rounded-full bg-yellow-500 flex-shrink-0"></span><span class="font-bold text-slate-700">Shift 3 (22:00-06:00) — Team YELLOW</span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Allocation Grid by Shift -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden mb-6">
        <div class="p-5 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
            <div>
                <h4 class="font-bold text-navy">Alokasi Operator Per Shift</h4>
                <p class="text-xs text-slate-500 mt-1">Pilih operator yang bertugas di tiap shift. Daftar anggota ditampilkan sesuai jadwal tim rotasi.</p>
            </div>
            <div class="flex gap-2 text-xs">
                <span class="px-2 py-1 bg-red-50 text-red-700 border border-red-200 rounded font-bold">Team RED</span>
                <span class="px-2 py-1 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded font-bold">Team GREEN</span>
                <span class="px-2 py-1 bg-yellow-50 text-yellow-700 border border-yellow-200 rounded font-bold">Team YELLOW</span>
            </div>
        </div>

        <div class="overflow-x-auto">
            <div class="flex gap-0 divide-x divide-slate-100 min-w-max">
                <template x-for="(shift, si) in shifts" :key="si">
                    <div class="p-5 w-72 flex-shrink-0">
                        <!-- Shift Header -->
                        <div class="rounded-xl p-3 mb-4 text-white" :class="shift.teamColor">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="text-xs font-bold opacity-80" x-text="'Shift ' + (si+1)"></span>
                                <span class="text-[9px] font-bold px-1.5 py-0.5 rounded bg-white/20 uppercase" x-text="shift.team + ' TEAM'"></span>
                            </div>
                            <p class="text-sm font-bold" x-text="shift.label"></p>
                            <p class="text-xs opacity-80 mt-0.5" x-text="shift.time"></p>
                            <p class="text-[10px] opacity-70 mt-1.5" x-text="'Tgl: ' + shift.date"></p>
                        </div>

                        <!-- Station Rows in this Shift -->
                        <template x-for="station in stations" :key="station.id">
                            <div class="mb-4">
                                <p class="text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2 flex items-center gap-1">
                                    <span x-text="station.label"></span>
                                    <span class="bg-slate-100 text-slate-500 px-1.5 py-0.5 rounded text-[8px]" x-text="'Butuh: ' + station.need + ' org'"></span>
                                </p>
                                <div class="space-y-1.5">
                                    <template x-for="member in shift.members" :key="shift.team + '_' + member.name">
                                        <label class="flex items-center gap-2.5 p-2 rounded-lg border border-transparent hover:border-slate-200 hover:bg-slate-50 cursor-pointer transition-all">
                                            <input type="checkbox" class="w-4 h-4 rounded border-slate-300 focus:ring-2" :class="shift.checkboxColor" :id="'s' + si + '_' + station.id + '_' + member.name">
                                            <div>
                                                <span class="text-sm font-semibold text-slate-800 block" x-text="member.name"></span>
                                                <span class="text-[10px] text-slate-400" x-text="member.role"></span>
                                            </div>
                                        </label>
                                    </template>
                                </div>
                            </div>
                        </template>
                    </div>
                </template>
            </div>
        </div>
    </div>

    <!-- Summary Preview -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 mb-6">
        <h4 class="text-sm font-bold text-navy mb-4 flex items-center gap-2">
            <svg class="w-4 h-4 text-cyan" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
            Preview Keterangan Alokasi di Dokumen SPK
        </h4>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
            <template x-for="(shift, si) in shifts" :key="'prev_'+si">
                <div class="rounded-xl p-4 border" :class="shift.previewBg">
                    <p class="font-bold text-xs mb-2" :class="shift.previewText" x-text="'Shift ' + (si+1) + ' · Team ' + shift.team.toUpperCase()"></p>
                    <p class="text-slate-600 text-xs" x-text="shift.time"></p>
                    <div class="mt-3 space-y-1.5">
                        <template x-for="station in stations" :key="'pvs_'+si+'_'+station.id">
                            <p class="text-xs text-slate-700">
                                <span class="font-bold text-navy" x-text="station.label + ':'"></span>
                                <span class="text-slate-500"> [Pilih di atas]</span>
                            </p>
                        </template>
                    </div>
                </div>
            </template>
        </div>
    </div>

    <!-- Aksi -->
    <div class="flex justify-end gap-3">
        <a href="{{ route('ppic.create.step2') }}" class="px-5 py-2.5 text-sm font-bold text-slate-600 bg-white border border-slate-300 rounded-xl hover:bg-slate-50 transition-colors">Kembali</a>
        <a href="{{ route('spk.detail') }}" class="px-6 py-2.5 text-sm font-bold text-white bg-navy hover:bg-navy-light rounded-xl shadow-md transition-colors flex items-center gap-2">
            Simpan Alokasi & Lihat SPK Final
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
        </a>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('alokasiApp', () => ({
            totalShifts: 5,

            // Jadwal rotasi tim berdasarkan minggu ini (bisa berubah setiap minggu)
            // Minggu ini: Shift1=RED, Shift2=GREEN, Shift3=YELLOW
            teamRoster: {
                RED:    [
                    { name: 'Budi', role: 'Lead Operator' },
                    { name: 'Anggun', role: 'Operator' },
                    { name: 'Mia', role: 'Operator' },
                    { name: 'Mira', role: 'Operator' },
                    { name: 'Ayu', role: 'Helper' }
                ],
                GREEN:  [
                    { name: 'Bagas', role: 'Lead Operator' },
                    { name: 'Rudi', role: 'Operator' },
                    { name: 'Putu', role: 'Operator' },
                    { name: 'Putri', role: 'Operator' },
                    { name: 'Fitri', role: 'Helper' }
                ],
                YELLOW: [
                    { name: 'Citra', role: 'Lead Operator' },
                    { name: 'Edi', role: 'Operator' },
                    { name: 'Fikri', role: 'Operator' },
                    { name: 'Hana', role: 'Operator' },
                    { name: 'Irfan', role: 'Helper' }
                ]
            },

            // Sequence shift rotation per hari:
            // Hari 1: S1=RED, S2=GREEN, S3=YELLOW
            // Hari 2: S1=GREEN, S2=YELLOW, S3=RED
            // dst...

            get shifts() {
                // Simulate 5 shifts needed (40 jam / 8 jam per shift)
                const rotation = [
                    { team: 'RED',    teamColor: 'bg-red-600',     checkboxColor: 'text-red-600 focus:ring-red-500',     previewBg: 'bg-red-50 border-red-200',     previewText: 'text-red-800',    label: 'Shift 1 (Hari 1)', time: '06:00 – 14:00', date: '27 Aug 2026' },
                    { team: 'GREEN',  teamColor: 'bg-emerald-600', checkboxColor: 'text-emerald-600 focus:ring-emerald-500', previewBg: 'bg-emerald-50 border-emerald-200', previewText: 'text-emerald-800', label: 'Shift 2 (Hari 1)', time: '14:00 – 22:00', date: '27 Aug 2026' },
                    { team: 'YELLOW', teamColor: 'bg-yellow-500',  checkboxColor: 'text-yellow-600 focus:ring-yellow-500', previewBg: 'bg-yellow-50 border-yellow-200', previewText: 'text-yellow-800', label: 'Shift 3 (Hari 1)', time: '22:00 – 06:00', date: '27-28 Aug' },
                    { team: 'RED',    teamColor: 'bg-red-600',     checkboxColor: 'text-red-600 focus:ring-red-500',     previewBg: 'bg-red-50 border-red-200',     previewText: 'text-red-800',    label: 'Shift 1 (Hari 2)', time: '06:00 – 14:00', date: '28 Aug 2026' },
                    { team: 'GREEN',  teamColor: 'bg-emerald-600', checkboxColor: 'text-emerald-600 focus:ring-emerald-500', previewBg: 'bg-emerald-50 border-emerald-200', previewText: 'text-emerald-800', label: 'Shift 2 (Hari 2)', time: '14:00 – 22:00', date: '28 Aug 2026' }
                ];
                return rotation.slice(0, this.totalShifts).map(s => ({
                    ...s,
                    members: this.teamRoster[s.team]
                }));
            },

            stations: [
                { id: 'timbang', label: 'Penimbangan', need: 1 },
                { id: 'mixing',  label: 'Mixing',       need: 2 },
                { id: 'extruder',label: 'Extruder',     need: 2 },
                { id: 'bagging', label: 'Bagging',      need: 1 }
            ]
        }))
    });
</script>
@endsection
