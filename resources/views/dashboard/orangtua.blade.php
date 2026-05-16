@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="space-y-5">

    @if($pregnantWoman)
    <div class="bg-white rounded-xl border border-slate-200 p-5">
        <h3 class="text-sm font-semibold text-slate-700 mb-3">Data Kehamilan</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
            <div>
                <p class="text-xs text-slate-400">Nama Ibu</p>
                <p class="text-sm font-medium text-slate-800">{{ $pregnantWoman->name }}</p>
            </div>
            <div>
                <p class="text-xs text-slate-400">Nama Suami</p>
                <p class="text-sm font-medium text-slate-800">{{ $pregnantWoman->husband_name }}</p>
            </div>
            <div>
                <p class="text-xs text-slate-400">HPL</p>
                <p class="text-sm font-medium text-slate-800">{{ $pregnantWoman->due_date ? \Carbon\Carbon::parse($pregnantWoman->due_date)->format('d F Y') : '-' }}</p>
            </div>
            <div>
                <p class="text-xs text-slate-400">Usia Kehamilan</p>
                <p class="text-sm font-medium text-slate-800">{{ $pregnantWoman->gestational_age ? $pregnantWoman->gestational_age . ' minggu' : '-' }}</p>
            </div>
        </div>
    </div>
    @else
    <div class="bg-yellow-50 border border-yellow-200 text-yellow-700 text-sm px-4 py-3 rounded-lg">
        <i class="fas fa-info-circle mr-2"></i> Data ibu hamil belum tersedia. Silakan hubungi bidan untuk pendaftaran.
    </div>
    @endif

    <!-- Data Anak -->
    <div class="bg-white rounded-xl border border-slate-200 p-5">
        <h3 class="text-sm font-semibold text-slate-700 mb-3">Data Anak Saya</h3>

        @if($children->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
            @foreach($children as $child)
            <a href="{{ route('children.show', $child->id) }}" class="flex justify-between items-center p-4 border border-slate-200 rounded-lg hover:border-sky-300 hover:bg-sky-50 transition">
                <div>
                    <p class="font-medium text-slate-800">{{ $child->name }}</p>
                    <p class="text-xs text-slate-400 mt-0.5">
                        {{ (int) \Carbon\Carbon::parse($child->birth_date)->diffInMonths(now()) }} bulan &middot;
                        {{ \Carbon\Carbon::parse($child->birth_date)->format('d F Y') }}
                    </p>
                </div>
                <div class="flex items-center gap-2">
                    @if($child->nutrition_status == 'obesitas')
                        <span class="text-xs bg-blue-50 text-blue-700 border border-blue-200 px-2 py-0.5 rounded">Obesitas</span>
                    @elseif($child->nutrition_status == 'normal')
                        <span class="text-xs bg-green-50 text-green-700 border border-green-200 px-2 py-0.5 rounded">Normal</span>
                    @elseif($child->nutrition_status == 'waspada')
                        <span class="text-xs bg-yellow-50 text-yellow-700 border border-yellow-200 px-2 py-0.5 rounded">Waspada</span>
                    @else
                        <span class="text-xs bg-red-50 text-red-700 border border-red-200 px-2 py-0.5 rounded">Kurang Gizi</span>
                    @endif
                    <i class="fas fa-chevron-right text-slate-300 text-xs"></i>
                </div>
            </a>
            @endforeach
        </div>
        @else
        <p class="text-sm text-slate-400 py-4 text-center">Belum ada data anak. Silakan hubungi bidan.</p>
        @endif
    </div>

</div>
@endsection
