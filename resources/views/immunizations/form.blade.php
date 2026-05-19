@extends('layouts.app')

@section('title', isset($immunization) ? 'Edit Imunisasi' : 'Tambah Imunisasi')
@section('page-title', isset($immunization) ? 'Edit Data Imunisasi' : 'Tambah Data Imunisasi')

@section('content')
<div class="bg-white rounded-xl border border-slate-200 p-5 max-w-2xl mx-auto">
    <form action="{{ isset($immunization) ? route('immunizations.update', $immunization->id) : route('immunizations.store') }}" 
          method="POST">
        @csrf
        @if(isset($immunization))
            @method('PUT')
        @endif

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-semibold mb-2">Nama Balita <span class="text-red-500">*</span></label>
            <select name="child_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 @error('child_id') border-red-500 @enderror" required>
                <option value="">Pilih Balita</option>
                @foreach($children as $child)
                    <option value="{{ $child->id }}" {{ old('child_id', $immunization->child_id ?? '') == $child->id ? 'selected' : '' }}>
                        {{ $child->name }} ({{ $child->mother->name ?? 'Ibu: -' }})
                    </option>
                @endforeach
            </select>
            @error('child_id')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-semibold mb-2">Nama Vaksin <span class="text-red-500">*</span></label>
                <select name="vaccine_name" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 @error('vaccine_name') border-red-500 @enderror" required>
                    <option value="">Pilih Vaksin</option>
                    <option value="HB-0" {{ old('vaccine_name', $immunization->vaccine_name ?? '') == 'HB-0' ? 'selected' : '' }}>HB-0 (Hepatitis B - 0 bulan)</option>
                    <option value="BCG" {{ old('vaccine_name', $immunization->vaccine_name ?? '') == 'BCG' ? 'selected' : '' }}>BCG (1 bulan)</option>
                    <option value="DPT 1" {{ old('vaccine_name', $immunization->vaccine_name ?? '') == 'DPT 1' ? 'selected' : '' }}>DPT 1 (2 bulan)</option>
                    <option value="Polio 1" {{ old('vaccine_name', $immunization->vaccine_name ?? '') == 'Polio 1' ? 'selected' : '' }}>Polio 1 (2 bulan)</option>
                    <option value="DPT 2" {{ old('vaccine_name', $immunization->vaccine_name ?? '') == 'DPT 2' ? 'selected' : '' }}>DPT 2 (3 bulan)</option>
                    <option value="Polio 2" {{ old('vaccine_name', $immunization->vaccine_name ?? '') == 'Polio 2' ? 'selected' : '' }}>Polio 2 (3 bulan)</option>
                    <option value="DPT 3" {{ old('vaccine_name', $immunization->vaccine_name ?? '') == 'DPT 3' ? 'selected' : '' }}>DPT 3 (4 bulan)</option>
                    <option value="Polio 3" {{ old('vaccine_name', $immunization->vaccine_name ?? '') == 'Polio 3' ? 'selected' : '' }}>Polio 3 (4 bulan)</option>
                    <option value="Campak" {{ old('vaccine_name', $immunization->vaccine_name ?? '') == 'Campak' ? 'selected' : '' }}>Campak (9 bulan)</option>
                </select>
                @error('vaccine_name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-semibold mb-2">Target Usia (bulan) <span class="text-red-500">*</span></label>
                <input type="number" name="age_target" value="{{ old('age_target', $immunization->age_target ?? '') }}" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 @error('age_target') border-red-500 @enderror"
                       placeholder="0, 1, 2, 3, 4, 9, dst" required>
                @error('age_target')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-semibold mb-2">Tanggal Diberikan</label>
            <input type="date" name="date_given" value="{{ old('date_given', isset($immunization) && $immunization->date_given ? $immunization->date_given->format('Y-m-d') : '') }}"
                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
            <p class="text-xs text-gray-500 mt-1">Kosongkan jika belum diberikan. Status akan dihitung otomatis.</p>
            @error('date_given')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end space-x-3 pt-4">
            <a href="{{ route('immunizations.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                Batal
            </a>
            <button type="submit" class="px-4 py-2 bg-teal-600 hover:bg-teal-700 text-white rounded-lg transition">
                <i class="fas fa-save mr-2"></i> Simpan
            </button>
        </div>
    </form>
</div>
@endsection