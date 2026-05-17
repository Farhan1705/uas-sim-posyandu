@extends('layouts.app')

@section('title', isset($child) ? 'Edit Balita' : 'Tambah Balita')
@section('page-title', isset($child) ? 'Edit Data Balita' : 'Tambah Data Balita')

@section('content')
<div class="bg-white rounded-xl shadow-md p-5 max-w-2xl mx-auto">
    <form action="{{ isset($child) ? route('children.update', $child->id) : route('children.store') }}" 
          method="POST">
        @csrf
        @if(isset($child))
            @method('PUT')
        @endif

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-semibold mb-2">Nama Balita <span class="text-red-500">*</span></label>
            <input type="text" name="name" value="{{ old('name', $child->name ?? '') }}" 
                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 @error('name') border-red-500 @enderror"
                   required>
            @error('name')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-semibold mb-2">Nama Ibu <span class="text-red-500">*</span></label>
            <select name="mother_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 @error('mother_id') border-red-500 @enderror" required>
                <option value="">Pilih Ibu</option>
                @foreach($mothers as $mother)
                    <option value="{{ $mother->id }}" {{ old('mother_id', $child->mother_id ?? '') == $mother->id ? 'selected' : '' }}>
                        {{ $mother->name }} (Suami: {{ $mother->husband_name }})
                    </option>
                @endforeach
            </select>
            @error('mother_id')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-semibold mb-2">Tanggal Lahir <span class="text-red-500">*</span></label>
                <input type="date" name="birth_date" value="{{ old('birth_date', $child->birth_date ?? '') }}" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 @error('birth_date') border-red-500 @enderror"
                       required>
                @error('birth_date')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-semibold mb-2">Jenis Kelamin <span class="text-red-500">*</span></label>
                <select name="gender" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 @error('gender') border-red-500 @enderror" required>
                    <option value="">Pilih</option>
                    <option value="L" {{ old('gender', $child->gender ?? '') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ old('gender', $child->gender ?? '') == 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>
                @error('gender')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>


        <div class="flex justify-end space-x-3 pt-4">
            <a href="{{ route('children.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                Batal
            </a>
            <button type="submit" class="px-4 py-2 bg-teal-600 hover:bg-teal-700 text-white rounded-lg transition">
                <i class="fas fa-save mr-2"></i> Simpan
            </button>
        </div>
    </form>
</div>
@endsection