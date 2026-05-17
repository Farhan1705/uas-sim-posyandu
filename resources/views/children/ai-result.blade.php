@extends('layouts.app')

@section('title', 'AI Rekomendasi Gizi - ' . $child->name)
@section('page-title', 'AI Rekomendasi Gizi Balita')

@section('content')
<div class="space-y-5">
    <div class="flex justify-between items-center">
        <div class="flex space-x-2">
            <a href="{{ route('children.show', $child->id) }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg text-sm transition">
                <i class="fas fa-arrow-left mr-2"></i> Kembali ke Detail
            </a>
            <a href="{{ route('children.ai-recommendation', $child->id) }}" class="bg-teal-600 hover:bg-teal-700 text-white px-4 py-2 rounded-lg text-sm transition">
                <i class="fas fa-sync-alt mr-2"></i> Generate Ulang
            </a>
        </div>
        <div class="text-sm text-gray-500">
            <i class="fas fa-robot mr-1"></i> Didukung oleh Google Gemini AI
        </div>
    </div>

    <div class="bg-gradient-to-r from-purple-500 to-purple-700 rounded-xl shadow-lg p-5 text-white">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-xl font-bold">{{ $child->name }}</h2>
                <p class="text-purple-100 text-sm">Anak dari {{ $child->mother->name ?? '-' }}</p>
                <div class="mt-2 flex flex-wrap gap-2">
                    <span class="text-xs bg-purple-600 px-2 py-1 rounded-full">
                        <i class="fas fa-calendar-alt mr-1"></i> Usia: {{ $umurBulan }} bulan
                    </span>
                    <span class="text-xs bg-purple-600 px-2 py-1 rounded-full">
                        <i class="fas fa-{{ $child->gender == 'L' ? 'mars' : 'venus' }} mr-1"></i> {{ $child->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}
                    </span>
                    @php
                        $latestMeasurement = $child->measurements()->latest('measurement_date')->first();
                    @endphp
                    @if($latestMeasurement)
                    <span class="text-xs bg-purple-600 px-2 py-1 rounded-full">
                        <i class="fas fa-weight-scale mr-1"></i> Berat: {{ $latestMeasurement->weight }} kg
                    </span>
                    <span class="text-xs bg-purple-600 px-2 py-1 rounded-full">
                        <i class="fas fa-ruler-vertical mr-1"></i> Tinggi: {{ $latestMeasurement->height }} cm
                    </span>
                    @endif
                </div>
            </div>
            <div class="text-right">
                @if($child->nutrition_status == 'obesitas')
                    <span class="bg-blue-500 px-3 py-1 rounded-full text-sm text-white"><i class="fas fa-circle mr-1"></i> Obesitas</span>
                @elseif($child->nutrition_status == 'normal')
                    <span class="bg-green-500 px-3 py-1 rounded-full text-sm text-white"><i class="fas fa-check-circle mr-1"></i> Gizi Normal</span>
                @elseif($child->nutrition_status == 'waspada')
                    <span class="bg-yellow-500 px-3 py-1 rounded-full text-sm text-white"><i class="fas fa-exclamation-circle mr-1"></i> Waspada</span>
                @else
                    <span class="bg-red-500 px-3 py-1 rounded-full text-sm text-white"><i class="fas fa-times-circle mr-1"></i> Kurang Gizi</span>
                @endif
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-md p-6">
        <div class="flex items-center mb-4">
            <div class="bg-purple-100 rounded-full p-2 mr-3">
                <i class="fas fa-robot text-purple-600 text-xl"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-800">Rekomendasi AI</h3>
        </div>
        
        <div class="prose max-w-none">
            <div class="bg-gray-50 rounded-lg p-5 text-sm text-slate-700 leading-relaxed">
                {!! $responseText !!}
            </div>
        </div>
        
        <div class="mt-5 pt-4 border-t border-gray-200">
            <div class="text-xs text-gray-500">
                <i class="fas fa-info-circle mr-1"></i> 
                Rekomendasi ini dihasilkan oleh AI (Google Gemini) berdasarkan data pengukuran terbaru.
                Konsultasikan lebih lanjut dengan bidan untuk penanganan lebih tepat.
            </div>
        </div>
    </div>

    <div class="bg-blue-50 rounded-xl p-5 border border-blue-200">
        <h4 class="font-semibold text-blue-800 mb-2 flex items-center">
            <i class="fas fa-lightbulb text-yellow-500 mr-2"></i> Tips untuk Orang Tua
        </h4>
        <ul class="text-sm text-blue-700 space-y-1 ml-5 list-disc">
            <li>Pantau berat badan anak setiap bulan di posyandu</li>
            <li>Pastikan imunisasi lengkap sesuai jadwal</li>
            <li>Berikan ASI eksklusif selama 6 bulan pertama</li>
            <li>Setelah 6 bulan, berikan MPASI yang bergizi seimbang</li>
            <li>Jika ada keluhan, segera konsultasikan ke bidan atau dokter</li>
        </ul>
    </div>
</div>

@endsection