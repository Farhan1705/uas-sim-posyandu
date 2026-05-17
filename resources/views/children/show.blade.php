@extends('layouts.app')

@section('title', 'Detail Balita')
@section('page-title', 'Detail Data Balita')

@section('content')
<div class="space-y-5">
    <div class="flex justify-between items-center">
        <div class="flex space-x-2">
            @can('bidan')
                <a href="{{ route('children.edit', $child->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm transition">
                    <i class="fas fa-edit mr-2"></i> Edit
                </a>
                <button onclick="openMeasurementModal()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm transition">
                    <i class="fas fa-weight-scale mr-2"></i> Tambah Pengukuran
                </button>
            @else
                <a href="{{ route('children.ai-recommendation', $child->id) }}" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg text-sm transition">
                    <i class="fas fa-robot mr-2"></i> AI Rekomendasi Gizi
                </a>
            @endcan
            <a href="{{ route('children.growth-chart', $child->id) }}" class="bg-teal-600 hover:bg-teal-700 text-white px-4 py-2 rounded-lg text-sm transition">
                <i class="fas fa-chart-line mr-2"></i> Lihat Grafik KMS
            </a>
            <a href="{{ Auth::user()->role == 'bidan' ? route('children.index') : route('dashboard') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg text-sm transition">
                <i class="fas fa-arrow-left mr-2"></i> Kembali
            </a>
        </div>
        
        @if($child->nutrition_status == 'obesitas')
            <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm">Status Gizi: Obesitas</span>
        @elseif($child->nutrition_status == 'normal')
            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">Status Gizi: Normal</span>
        @elseif($child->nutrition_status == 'waspada')
            <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-sm">Status Gizi: Waspada</span>
        @else
            <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm">Status Gizi: Kurang</span>
        @endif
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5">
        <h3 class="text-sm font-semibold text-slate-700 mb-4">
            <i class="fas fa-info-circle text-sky-500 mr-2"></i> Informasi Balita
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
            <div class="bg-slate-50 border border-slate-200 rounded-lg p-3 shadow-sm hover:shadow-md hover:border-sky-300 transition">
                <p class="text-xs text-slate-400 mb-0.5">Nama Lengkap</p>
                <p class="font-semibold text-slate-800">{{ $child->name }}</p>
            </div>
            <div class="bg-slate-50 border border-slate-200 rounded-lg p-3 shadow-sm hover:shadow-md hover:border-sky-300 transition">
                <p class="text-xs text-slate-400 mb-0.5">Nama Ibu</p>
                <p class="font-semibold text-slate-800">{{ $child->mother->name ?? '-' }}</p>
            </div>
            <div class="bg-slate-50 border border-slate-200 rounded-lg p-3 shadow-sm hover:shadow-md hover:border-sky-300 transition">
                <p class="text-xs text-slate-400 mb-0.5">Tanggal Lahir</p>
                <p class="font-semibold text-slate-800">{{ \Carbon\Carbon::parse($child->birth_date)->format('d F Y') }}</p>
            </div>
            <div class="bg-slate-50 border border-slate-200 rounded-lg p-3 shadow-sm hover:shadow-md hover:border-sky-300 transition">
                <p class="text-xs text-slate-400 mb-0.5">Usia</p>
                <p class="font-semibold text-slate-800">{{ $umurBulan }} bulan</p>
            </div>
            <div class="bg-slate-50 border border-slate-200 rounded-lg p-3 shadow-sm hover:shadow-md hover:border-sky-300 transition">
                <p class="text-xs text-slate-400 mb-0.5">Jenis Kelamin</p>
                <p class="font-semibold text-slate-800">{{ $child->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-md p-5">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">
            <i class="fas fa-chart-simple text-teal-600 mr-2"></i> Riwayat Pengukuran
        </h3>
        
        @if($child->measurements->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-gray-200">
                            <th class="text-left py-2 px-2 text-sm font-semibold text-gray-600">Tanggal</th>
                            <th class="text-left py-2 px-2 text-sm font-semibold text-gray-600">Berat (kg)</th>
                            <th class="text-left py-2 px-2 text-sm font-semibold text-gray-600">Tinggi (cm)</th>
                            <th class="text-left py-2 px-2 text-sm font-semibold text-gray-600">Lingkar Kepala (cm)</th>
                            <th class="text-left py-2 px-2 text-sm font-semibold text-gray-600">Zona</th>
                             @can('bidan') <th class="text-left py-2 px-2 text-sm font-semibold text-gray-600">Aksi</th> @endcan
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($child->measurements as $measurement)
                        <tr class="border-b border-gray-100">
                            <td class="py-2 px-2 text-sm">{{ \Carbon\Carbon::parse($measurement->measurement_date)->format('d/m/Y') }}</td>
                            <td class="py-2 px-2 text-sm">{{ $measurement->weight }}</td>
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
                            @can('bidan')
                            <td class="py-2 px-2 text-sm">
                                <a href="{{ route('measurements.edit', [$child->id, $measurement->id]) }}" class="text-blue-600 hover:text-blue-700 mr-2">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('measurements.destroy', [$child->id, $measurement->id]) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-700" onclick="return confirm('Yakin ingin menghapus?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                            @endcan
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-500 text-center py-4">Belum ada data pengukuran</p>
        @endif
    </div>

    <div class="bg-white rounded-xl shadow-md p-5">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">
            <i class="fas fa-syringe text-teal-600 mr-2"></i> Riwayat Imunisasi
        </h3>
        
        @if($child->immunizations->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-gray-200">
                            <th class="text-left py-2 px-2 text-sm font-semibold text-gray-600">Nama Vaksin</th>
                            <th class="text-left py-2 px-2 text-sm font-semibold text-gray-600">Target Usia</th>
                            <th class="text-left py-2 px-2 text-sm font-semibold text-gray-600">Tanggal Diberikan</th>
                            <th class="text-left py-2 px-2 text-sm font-semibold text-gray-600">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($child->immunizations as $immunization)
                        <tr class="border-b border-gray-100">
                            <td class="py-2 px-2 text-sm">{{ $immunization->vaccine_name }}</td>
                            <td class="py-2 px-2 text-sm">{{ $immunization->age_target }} bulan</td>
                            <td class="py-2 px-2 text-sm">{{ $immunization->date_given ? \Carbon\Carbon::parse($immunization->date_given)->format('d/m/Y') : '-' }}</td>
                            <td class="py-2 px-2 text-sm">
                                @if($immunization->status == 'done')
                                    <span class="bg-green-100 text-green-700 px-2 py-0.5 rounded-full text-xs">Selesai</span>
                                @elseif($immunization->status == 'pending')
                                    <span class="bg-yellow-100 text-yellow-700 px-2 py-0.5 rounded-full text-xs">Pending</span>
                                @else
                                    <span class="bg-red-100 text-red-700 px-2 py-0.5 rounded-full text-xs"> Terlewat</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-500 text-center py-4">Belum ada data imunisasi</p>
        @endif
        
        @can('bidan')
        <div class="mt-4 text-right">
            <a href="{{ route('immunizations.create') }}?child_id={{ $child->id }}" class="text-teal-600 hover:text-teal-700 text-sm">
                <i class="fas fa-plus mr-1"></i> Tambah Imunisasi
            </a>
        </div>
        @endcan
    </div>
</div>

@can('bidan')
<div id="measurementModal" class="fixed inset-0 bg-slate-100 hidden flex items-center justify-center z-50">
    <div class="bg-white rounded-xl shadow-xl p-6 w-full max-w-md">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold">Tambah Pengukuran</h3>
            <button onclick="closeMeasurementModal()" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <form action="{{ route('measurements.store', $child->id) }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="block text-sm font-semibold mb-1">Tanggal Pengukuran</label>
                <input type="date" name="measurement_date" class="w-full px-3 py-2 border rounded-lg" required>
            </div>
            <div class="mb-3">
                <label class="block text-sm font-semibold mb-1">Berat Badan (kg)</label>
                <input type="number" step="0.01" name="weight" class="w-full px-3 py-2 border rounded-lg" required>
            </div>
            <div class="mb-3">
                <label class="block text-sm font-semibold mb-1">Tinggi Badan (cm)</label>
                <input type="number" step="0.01" name="height" class="w-full px-3 py-2 border rounded-lg" required>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-semibold mb-1">Lingkar Kepala (cm)</label>
                <input type="number" step="0.01" name="head_circumference" class="w-full px-3 py-2 border rounded-lg" required>
            </div>
            <div class="flex justify-end space-x-2">
                <button type="button" onclick="closeMeasurementModal()" class="px-4 py-2 border rounded-lg">Batal</button>
                <button type="submit" class="px-4 py-2 bg-teal-600 text-white rounded-lg">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
function openMeasurementModal() {
    document.getElementById('measurementModal').classList.remove('hidden');
}
function closeMeasurementModal() {
    document.getElementById('measurementModal').classList.add('hidden');
}
</script>
@endcan
@endsection