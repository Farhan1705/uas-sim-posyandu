@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="space-y-5">

    <!-- Statistik Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <a href="{{ route('pregnant-women.index') }}" class="bg-white rounded-xl border border-slate-200 p-4 hover:border-sky-300 transition block">
            <p class="text-xs text-slate-500 mb-1">Ibu Hamil</p>
            <p class="text-2xl font-bold text-slate-800">{{ $totalPregnant ?? 0 }}</p>
        </a>
        <a href="{{ route('children.index') }}" class="bg-white rounded-xl border border-slate-200 p-4 hover:border-sky-300 transition block">
            <p class="text-xs text-slate-500 mb-1">Balita</p>
            <p class="text-2xl font-bold text-slate-800">{{ $totalChildren ?? 0 }}</p>
        </a>
        <div class="bg-white rounded-xl border border-slate-200 p-4">
            <p class="text-xs text-slate-500 mb-1">Total Pengukuran</p>
            <p class="text-2xl font-bold text-slate-800">{{ $totalMeasurements ?? 0 }}</p>
        </div>
        <a href="{{ route('immunizations.index') }}" class="bg-white rounded-xl border border-slate-200 p-4 hover:border-sky-300 transition block">
            <p class="text-xs text-slate-500 mb-1">Imunisasi</p>
            <p class="text-2xl font-bold text-slate-800">{{ $totalImmunizations ?? 0 }}</p>
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
        <!-- Status Gizi Chart -->
        <div class="bg-white rounded-xl border border-slate-200 p-5">
            <h3 class="text-sm font-semibold text-slate-700 mb-4">Status Gizi Balita</h3>

            @php
                $total = ($obesitasCount ?? 0) + ($normalCount ?? 0) + ($waspadaCount ?? 0) + ($kurangCount ?? 0);
                $o = $total > 0 ? round(($obesitasCount / $total) * 100) : 0;
                $n = $total > 0 ? round(($normalCount / $total) * 100) : 0;
                $w = $total > 0 ? round(($waspadaCount / $total) * 100) : 0;
                $k = $total > 0 ? round(($kurangCount / $total) * 100) : 0;

                $oEnd = $o;
                $nEnd = $oEnd + $n;
                $wEnd = $nEnd + $w;
                $kEnd = $wEnd + $k;
            @endphp

            <div class="flex justify-center my-4">
                <div class="relative w-52 h-52">
                    <div class="w-full h-full rounded-full" style="background: conic-gradient(
                        #3b82f6 0% {{ $oEnd }}%,
                        #22c55e {{ $oEnd }}% {{ $nEnd }}%,
                        #facc15 {{ $nEnd }}% {{ $wEnd }}%,
                        #ef4444 {{ $wEnd }}% 100%
                    );"></div>
                    {{-- lubang tengah --}}
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="w-32 h-32 bg-white rounded-full flex flex-col items-center justify-center">
                            <span class="text-2xl font-bold text-slate-800">{{ $total }}</span>
                            <span class="text-xs text-slate-400">balita</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-2 mt-2">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <div class="w-2.5 h-2.5 rounded-full bg-blue-500"></div>
                        <span class="text-xs text-slate-600">Obesitas</span>
                    </div>
                    <span class="text-xs font-semibold text-slate-700">{{ $obesitasCount ?? 0 }} <span class="text-slate-400 font-normal">({{ $o }}%)</span></span>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <div class="w-2.5 h-2.5 rounded-full bg-green-500"></div>
                        <span class="text-xs text-slate-600">Normal</span>
                    </div>
                    <span class="text-xs font-semibold text-slate-700">{{ $normalCount ?? 0 }} <span class="text-slate-400 font-normal">({{ $n }}%)</span></span>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <div class="w-2.5 h-2.5 rounded-full bg-yellow-400"></div>
                        <span class="text-xs text-slate-600">Waspada</span>
                    </div>
                    <span class="text-xs font-semibold text-slate-700">{{ $waspadaCount ?? 0 }} <span class="text-slate-400 font-normal">({{ $w }}%)</span></span>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <div class="w-2.5 h-2.5 rounded-full bg-red-500"></div>
                        <span class="text-xs text-slate-600">Kurang</span>
                    </div>
                    <span class="text-xs font-semibold text-slate-700">{{ $kurangCount ?? 0 }} <span class="text-slate-400 font-normal">({{ $k }}%)</span></span>
                </div>
            </div>
        </div>

        <!-- Tabel Balita Terbaru -->
        <div class="bg-white rounded-xl border border-slate-200 p-5 lg:col-span-2">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-sm font-semibold text-slate-700">Balita Terbaru</h3>
                <a href="{{ route('children.create') }}" class="inline-flex items-center gap-1.5 bg-sky-500 hover:bg-sky-600 text-white px-3 py-1.5 rounded-md text-xs transition">
                    <i class="fas fa-plus"></i> Tambah
                </a>
            </div>
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-slate-100">
                        <th class="text-left py-2 text-xs font-medium text-slate-500">Nama</th>
                        <th class="text-left py-2 text-xs font-medium text-slate-500">Ibu</th>
                        <th class="text-left py-2 text-xs font-medium text-slate-500">Lahir</th>
                        <th class="text-left py-2 text-xs font-medium text-slate-500">Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentChildren ?? [] as $child)
                    <tr class="border-b border-slate-50 hover:bg-slate-50">
                        <td class="py-2 font-medium text-slate-800">{{ $child->name }}</td>
                        <td class="py-2 text-slate-500">{{ $child->mother->name ?? '-' }}</td>
                        <td class="py-2 text-slate-500">{{ \Carbon\Carbon::parse($child->birth_date)->format('d/m/Y') }}</td>
                        <td class="py-2">
                            @if($child->nutrition_status == 'obesitas')
                                <span class="text-xs bg-blue-50 text-blue-700 border border-blue-200 px-2 py-0.5 rounded">Obesitas</span>
                            @elseif($child->nutrition_status == 'normal')
                                <span class="text-xs bg-green-50 text-green-700 border border-green-200 px-2 py-0.5 rounded">Normal</span>
                            @elseif($child->nutrition_status == 'waspada')
                                <span class="text-xs bg-yellow-50 text-yellow-700 border border-yellow-200 px-2 py-0.5 rounded">Waspada</span>
                            @else
                                <span class="text-xs bg-red-50 text-red-700 border border-red-200 px-2 py-0.5 rounded">Kurang</span>
                            @endif
                        </td>
                        <td class="py-2 text-right">
                            <a href="{{ route('children.show', $child->id) }}" class="text-sky-500 hover:text-sky-700 text-xs">Lihat</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-6 text-center text-slate-400 text-sm">Belum ada data balita</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- Warning balita melewati usia posyandu --}}
            @if($overdueChildren->count() > 0)
            <div class="mt-4 pt-4 border-t border-orange-100">
                <div class="flex items-center gap-2 mb-2">
                    <i class="fas fa-exclamation-triangle text-orange-500 text-xs"></i>
                    <span class="text-xs font-semibold text-orange-600">Melewati Usia Posyandu (> 5 Tahun)</span>
                    <span class="ml-auto text-xs bg-orange-100 text-orange-600 px-2 py-0.5 rounded-full">{{ $overdueChildren->count() }}</span>
                </div>
                @foreach($overdueChildren as $child)
                <div class="flex items-center justify-between py-1.5 border-b border-orange-50 last:border-0">
                    <div>
                        <span class="text-sm font-medium text-slate-700">{{ $child->name }}</span>
                        <span class="text-xs text-slate-400 ml-2">{{ (int) \Carbon\Carbon::parse($child->birth_date)->diffInMonths(now()) }} bulan</span>
                    </div>
                    <form action="{{ route('children.destroy', $child->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Hapus data {{ $child->name }}?')"
                            class="text-xs text-red-500 hover:text-red-700 border border-red-200 hover:bg-red-50 px-2 py-0.5 rounded transition">
                            <i class="fas fa-trash mr-1"></i> Hapus
                        </button>
                    </form>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>

</div>
@endsection


