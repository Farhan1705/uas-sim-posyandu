@extends('layouts.app')

@section('title', 'Riwayat Pengukuran')
@section('page-title', 'Riwayat Pengukuran Balita')

@section('content')
<div class="bg-white rounded-xl shadow-md p-5">
    <div class="flex justify-between items-center mb-5">
        <h3 class="text-lg font-semibold text-gray-800">
            <i class="fas fa-chart-line text-green-600 mr-2"></i> Riwayat Pengukuran
            <span class="text-sm text-gray-500 ml-2">({{ $child->name }})</span>
        </h3>
        <div class="flex space-x-2">
            <a href="{{ route('children.show', $child->id) }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg text-sm transition">
                <i class="fas fa-arrow-left mr-2"></i> Kembali ke Detail
            </a>
            <a href="{{ route('measurements.create', $child->id) }}" class="bg-teal-600 hover:bg-teal-700 text-white px-4 py-2 rounded-lg text-sm transition">
                <i class="fas fa-plus mr-2"></i> Tambah Pengukuran
            </a>
        </div>
    </div>

    @if($measurements->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-200">
                        <th class="text-left py-3 px-2 text-sm font-semibold text-gray-600">No</th>
                        <th class="text-left py-3 px-2 text-sm font-semibold text-gray-600">Tanggal</th>
                        <th class="text-left py-3 px-2 text-sm font-semibold text-gray-600">Berat (kg)</th>
                        <th class="text-left py-3 px-2 text-sm font-semibold text-gray-600">Tinggi (cm)</th>
                        <th class="text-left py-3 px-2 text-sm font-semibold text-gray-600">Lingkar Kepala (cm)</th>
                        <th class="text-left py-3 px-2 text-sm font-semibold text-gray-600">Zona Warna</th>
                        <th class="text-left py-3 px-2 text-sm font-semibold text-gray-600">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($measurements as $index => $measurement)
                    <tr class="border-b border-gray-100 hover:bg-gray-50">
                        <td class="py-3 px-2 text-sm">{{ $index + 1 }}</td>
                        <td class="py-3 px-2 text-sm">{{ \Carbon\Carbon::parse($measurement->measurement_date)->format('d/m/Y') }}</td>
                        <td class="py-3 px-2 text-sm">{{ $measurement->weight }}</td>
                        <td class="py-3 px-2 text-sm">{{ $measurement->height }}</td>
                        <td class="py-3 px-2 text-sm">{{ $measurement->head_circumference }}</td>
                        <td class="py-3 px-2 text-sm">
                            @if($measurement->color_zone == 'biru')
                                <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded-full text-xs">Biru (Obesitas)</span>
                            @elseif($measurement->color_zone == 'hijau')
                                <span class="bg-green-100 text-green-700 px-2 py-1 rounded-full text-xs">Hijau (Normal)</span>
                            @elseif($measurement->color_zone == 'kuning')
                                <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded-full text-xs">Kuning (Waspada)</span>
                            @else
                                <span class="bg-red-100 text-red-700 px-2 py-1 rounded-full text-xs">Merah (Kurang)</span>
                            @endif
                        </td>
                        <td class="py-3 px-2 text-sm">
                            <a href="{{ route('measurements.edit', [$child->id, $measurement->id]) }}" class="text-blue-600 hover:text-blue-700 mr-2">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('measurements.destroy', [$child->id, $measurement->id]) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-700" onclick="return confirm('Yakin ingin menghapus data ini?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="text-center py-8 text-gray-500">
            <i class="fas fa-chart-line text-4xl mb-3 opacity-50"></i>
            <p>Belum ada data pengukuran</p>
            <a href="{{ route('measurements.create', $child->id) }}" class="text-teal-600 hover:underline text-sm mt-2 inline-block">
                <i class="fas fa-plus mr-1"></i> Tambah Pengukuran
            </a>
        </div>
    @endif
</div>
@endsection