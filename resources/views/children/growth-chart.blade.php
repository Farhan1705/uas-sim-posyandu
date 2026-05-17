@extends('layouts.app')

@section('title', 'Grafik KMS - ' . $child->name)
@section('page-title', 'Grafik Kartu Menuju Sehat (KMS)')

@section('content')
<div class="space-y-5">
    <div class="flex justify-between items-center">
        <div class="flex space-x-2">
            <a href="{{ route('children.show', $child->id) }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg text-sm transition">
                <i class="fas fa-arrow-left mr-2"></i> Kembali ke Detail
            </a>
            @can('bidan')
            <a href="{{ route('measurements.create', $child->id) }}" class="bg-teal-600 hover:bg-teal-700 text-white px-4 py-2 rounded-lg text-sm transition">
                <i class="fas fa-plus mr-2"></i> Tambah Pengukuran
            </a>
            @endcan
        </div>
        <div class="text-sm text-gray-500">
            <i class="fas fa-calendar-alt mr-1"></i> Usia: {{ $umurBulan }} bulan
        </div>
    </div>

    <div class="bg-gradient-to-r from-teal-500 to-teal-700 rounded-xl shadow-lg p-5 text-white">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-xl font-bold">{{ $child->name }}</h2>
                <p class="text-teal-100 text-sm">Anak dari {{ $child->mother->name ?? '-' }}</p>
                <div class="mt-2 flex space-x-3">
                    <span class="text-xs bg-teal-600 px-2 py-1 rounded-full">
                        <i class="fas fa-calendar-alt mr-1"></i> Lahir: {{ \Carbon\Carbon::parse($child->birth_date)->format('d/m/Y') }}
                    </span>
                    <span class="text-xs bg-teal-600 px-2 py-1 rounded-full">
                        <i class="fas fa-{{ $child->gender == 'L' ? 'mars' : 'venus' }} mr-1"></i> {{ $child->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}
                    </span>
                </div>
            </div>
            <div class="text-right">
                @if($child->nutrition_status == 'obesitas')
                    <span class="bg-blue-500 px-3 py-1 rounded-full text-sm">Obesitas</span>
                @elseif($child->nutrition_status == 'normal')
                    <span class="bg-green-500 px-3 py-1 rounded-full text-sm">Gizi Normal</span>
                @elseif($child->nutrition_status == 'waspada')
                    <span class="bg-yellow-500 px-3 py-1 rounded-full text-sm">Waspada</span>
                @else
                    <span class="bg-red-500 px-3 py-1 rounded-full text-sm">Kurang Gizi</span>
                @endif
            </div>
        </div>
    </div>

    @if(isset($error))
        <div class="bg-yellow-50 border-l-4 border-yellow-500 rounded-lg p-4">
            <div class="flex items-center">
                <i class="fas fa-exclamation-triangle text-yellow-500 mr-3"></i>
                <p class="text-yellow-700">{{ $error }}</p>
            </div>
        </div>
        
    @elseif(count($weights) > 0)
        <div class="bg-white rounded-xl shadow-md p-5">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">
                <i class="fas fa-chart-line text-teal-600 mr-2"></i> Grafik Perkembangan Berat Badan
            </h3>
            <div class="relative">
                <canvas id="kmsChart" class="w-full h-96"></canvas>
            </div>

            <div class="mt-5 pt-4 border-t border-gray-200">
                <h4 class="text-sm font-semibold text-gray-700 mb-2">Keterangan Zona Warna:</h4>
                <div class="flex flex-wrap gap-4">
                    <div class="flex items-center">
                        <div class="w-5 h-5 bg-blue-500 rounded mr-2"></div>
                        <span class="text-sm">Zona Biru: Obesitas (Berat Berlebih)</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-5 h-5 bg-green-500 rounded mr-2"></div>
                        <span class="text-sm">Zona Hijau: Normal (Gizi Baik)</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-5 h-5 bg-yellow-500 rounded mr-2"></div>
                        <span class="text-sm">Zona Kuning: Waspada (Risiko Kurang Gizi)</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-5 h-5 bg-red-500 rounded mr-2"></div>
                        <span class="text-sm">Zona Merah: Kurang Gizi</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-md p-5">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">
                <i class="fas fa-table text-teal-600 mr-2"></i> Data Pengukuran
            </h3>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-gray-200">
                            <th class="text-left py-2 px-2 text-sm font-semibold text-gray-600">Tanggal</th>
                            <th class="text-left py-2 px-2 text-sm font-semibold text-gray-600">Usia (bln)</th>
                            <th class="text-left py-2 px-2 text-sm font-semibold text-gray-600">Berat (kg)</th>
                            <th class="text-left py-2 px-2 text-sm font-semibold text-gray-600">Tinggi (cm)</th>
                            <th class="text-left py-2 px-2 text-sm font-semibold text-gray-600">Lingkar Kepala (cm)</th>
                            <th class="text-left py-2 px-2 text-sm font-semibold text-gray-600">Zona</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($child->measurements->sortBy('measurement_date') as $measurement)
                        @php
                            $usiaSaatUkur = (int) \Carbon\Carbon::parse($child->birth_date)->diffInMonths($measurement->measurement_date);
                        @endphp
                        <tr class="border-b border-gray-100">
                            <td class="py-2 px-2 text-sm">{{ \Carbon\Carbon::parse($measurement->measurement_date)->format('d/m/Y') }}</td>
                            <td class="py-2 px-2 text-sm">{{ $usiaSaatUkur }} bln</td>
                            <td class="py-2 px-2 text-sm font-medium">{{ $measurement->weight }}</td>
                            <td class="py-2 px-2 text-sm">{{ $measurement->height }}</td>
                            <td class="py-2 px-2 text-sm">{{ $measurement->head_circumference }}</td>
                            <td class="py-2 px-2 text-sm">
                                @if($measurement->color_zone == 'biru')
                                    <span class="bg-blue-100 text-blue-700 px-2 py-0.5 rounded-full text-xs">Biru (Obesitas)</span>
                                @elseif($measurement->color_zone == 'hijau')
                                    <span class="bg-green-100 text-green-700 px-2 py-0.5 rounded-full text-xs">Hijau</span>
                                @elseif($measurement->color_zone == 'kuning')
                                    <span class="bg-yellow-100 text-yellow-700 px-2 py-0.5 rounded-full text-xs">Kuning</span>
                                @else
                                    <span class="bg-red-100 text-red-700 px-2 py-0.5 rounded-full text-xs">Merah</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="bg-yellow-50 border-l-4 border-yellow-500 rounded-lg p-4">
            <div class="flex items-center">
                <i class="fas fa-chart-line text-yellow-500 mr-3"></i>
                <p class="text-yellow-700">Belum ada data pengukuran untuk menampilkan grafik.</p>
            </div>
            @can('bidan')
            <div class="mt-3">
                <a href="{{ route('measurements.create', $child->id) }}" class="bg-teal-600 hover:bg-teal-700 text-white px-4 py-2 rounded-lg text-sm transition inline-block">
                    <i class="fas fa-plus mr-2"></i> Tambah Pengukuran
                </a>
            </div>
            @endcan
        </div>
    @endif
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('kmsChart');
    
    if (!ctx) return;
    
    const labels = @json($labels);
    const weights = @json($weights);
    const zones = @json($zones);
    
    const pointColors = zones.map(zone => {
        if (zone === 'biru') return '#3b82f6';
        if (zone === 'hijau') return '#10b981';
        if (zone === 'kuning') return '#f59e0b';
        return '#ef4444';
    });
    
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Berat Badan (kg)',
                data: weights,
                borderColor: '#1abc9c',
                backgroundColor: 'rgba(26, 188, 156, 0.1)',
                borderWidth: 2,
                pointRadius: 6,
                pointHoverRadius: 8,
                pointBackgroundColor: pointColors,
                pointBorderColor: '#ffffff',
                pointBorderWidth: 2,
                tension: 0.3,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            let value = context.raw;
                            let zone = zones[context.dataIndex];
                            let status = '';
                            if (zone === 'biru') status = 'Obesitas';
                            else if (zone === 'hijau') status = 'Normal';
                            else if (zone === 'kuning') status = 'Waspada';
                            else status = 'Kurang Gizi';
                            return `${label}: ${value} kg (${status})`;
                        }
                    }
                },
                legend: {
                    position: 'top',
                    labels: {
                        usePointStyle: true,
                        boxWidth: 10
                    }
                }
            },
            scales: {
                y: {
                    title: {
                        display: true,
                        text: 'Berat Badan (kg)',
                        font: {
                            weight: 'bold'
                        }
                    },
                    beginAtZero: false,
                    min: 0,
                    max: Math.max(...weights, 15) + 2,
                    grid: {
                        color: '#e5e7eb'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Tanggal Pengukuran',
                        font: {
                            weight: 'bold'
                        }
                    },
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
});
</script>
@endpush
@endsection