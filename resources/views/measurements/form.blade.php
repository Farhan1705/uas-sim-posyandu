@extends('layouts.app')

@section('title', isset($measurement) ? 'Edit Pengukuran' : 'Tambah Pengukuran')
@section('page-title', isset($measurement) ? 'Edit Data Pengukuran' : 'Tambah Data Pengukuran')

@section('content')
<div class="bg-white rounded-xl shadow-md p-5 max-w-2xl mx-auto">
    <div class="mb-5 pb-3 border-b border-gray-200">
        <p class="text-gray-600">
            <span class="font-semibold">Balita:</span> {{ $child->name }}
            <br>
            <span class="font-semibold">Ibu:</span> {{ $child->mother->name ?? '-' }}
        </p>
    </div>

    <form action="{{ isset($measurement) ? route('measurements.update', [$child->id, $measurement->id]) : route('measurements.store', $child->id) }}" 
          method="POST">
        @csrf
        @if(isset($measurement))
            @method('PUT')
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-semibold mb-2">Tanggal Pengukuran <span class="text-red-500">*</span></label>
                <input type="date" name="measurement_date" value="{{ old('measurement_date', isset($measurement) ? $measurement->measurement_date : '') }}" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 @error('measurement_date') border-red-500 @enderror"
                       required>
                @error('measurement_date')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-semibold mb-2">Usia Saat Pengukuran</label>
                <input type="text" value="{{ (int) \Carbon\Carbon::parse($child->birth_date)->diffInMonths(old('measurement_date', isset($measurement) ? $measurement->measurement_date : date('Y-m-d'))) }} bulan" 
                       class="w-full px-3 py-2 border border-gray-200 rounded-lg bg-gray-100 text-gray-600" readonly>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-semibold mb-2">Berat Badan (kg) <span class="text-red-500">*</span></label>
                <input type="number" step="0.01" name="weight" value="{{ old('weight', $measurement->weight ?? '') }}" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 @error('weight') border-red-500 @enderror"
                       required>
                @error('weight')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-semibold mb-2">Tinggi Badan (cm) <span class="text-red-500">*</span></label>
                <input type="number" step="0.01" name="height" value="{{ old('height', $measurement->height ?? '') }}" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 @error('height') border-red-500 @enderror"
                       required>
                @error('height')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-semibold mb-2">Lingkar Kepala (cm) <span class="text-red-500">*</span></label>
                <input type="number" step="0.01" name="head_circumference" value="{{ old('head_circumference', $measurement->head_circumference ?? '') }}" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 @error('head_circumference') border-red-500 @enderror"
                       required>
                @error('head_circumference')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="mb-5">
            <label class="block text-gray-700 text-sm font-semibold mb-2">Zona Warna KMS</label>
            <div class="w-full px-3 py-2 border border-gray-200 rounded-lg bg-gray-100 text-gray-600 text-sm">
                Dihitung otomatis berdasarkan berat badan dan usia
            </div>
        </div>

        <div class="flex justify-end space-x-3 pt-4">
            <a href="{{ route('measurements.index', $child->id) }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                Batal
            </a>
            <button type="submit" class="px-4 py-2 bg-teal-600 hover:bg-teal-700 text-white rounded-lg transition">
                <i class="fas fa-save mr-2"></i> Simpan
            </button>
        </div>
    </form>
</div>

<script>
// Auto update usia saat tanggal berubah
document.querySelector('input[name="measurement_date"]').addEventListener('change', function() {
    const birthDate = '{{ $child->birth_date }}';
    const measurementDate = this.value;
    if (measurementDate) {
        fetch(`/api/calculate-age?birth=${birthDate}&measurement=${measurementDate}`)
            .then(response => response.json())
            .then(data => {
                // Optional: update display
            });
    }
});
</script>
@endsection