`@extends('layouts.app')

@section('title', isset($pregnantWoman) ? 'Edit Ibu Hamil' : 'Tambah Ibu Hamil')
@section('page-title', isset($pregnantWoman) ? 'Edit Data Ibu Hamil' : 'Tambah Data Ibu Hamil')

@section('content')
<div class="bg-white rounded-xl border border-slate-200 p-6 max-w-2xl mx-auto">
    <form action="{{ isset($pregnantWoman) ? route('pregnant-women.update', $pregnantWoman->id) : route('pregnant-women.store') }}"
          method="POST">
        @csrf
        @if(isset($pregnantWoman))
            @method('PUT')
        @endif

        @if(!isset($pregnantWoman))
        {{-- Pilih ibu yang sudah registrasi --}}
        <div class="mb-5">
            <label class="block text-gray-700 text-sm font-semibold mb-2">Pilih Ibu </label>
            @if($unlinkedUsers->isEmpty())
                <div class="p-3 bg-yellow-50 border border-yellow-300 rounded-lg text-sm text-yellow-700">
                    <i class="fas fa-info-circle mr-1"></i>
                    Belum ada ibu yang sudah registrasi dan belum terdaftar.
                </div>
            @else
                <select name="existing_user_id" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 @error('existing_user_id') border-red-500 @enderror">
                    <option value="">-- Pilih Ibu --</option>
                    @foreach($unlinkedUsers as $u)
                        <option value="{{ $u->id }}" {{ old('existing_user_id') == $u->id ? 'selected' : '' }}>
                            {{ $u->name }} ({{ $u->email }})
                        </option>
                    @endforeach
                </select>
                @error('existing_user_id')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            @endif
        </div>
        @else
        {{-- Edit mode: tampilkan nama ibu (readonly) --}}
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-semibold mb-2">Nama Ibu</label>
            <input type="text" value="{{ $pregnantWoman->name }}" disabled
                   class="w-full px-3 py-2 border border-gray-200 rounded-lg bg-gray-50 text-gray-500">
        </div>
        @endif

        {{-- Nama Suami --}}
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-semibold mb-2">Nama Suami</label>
            <input type="text" name="husband_name" value="{{ old('husband_name', $pregnantWoman->husband_name ?? '') }}"
                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 @error('husband_name') border-red-500 @enderror"
                   required>
            @error('husband_name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-semibold mb-2">HPL</label>
                <input type="date" name="due_date" value="{{ old('due_date', $pregnantWoman->due_date ?? '') }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 @error('due_date') border-red-500 @enderror">
                @error('due_date')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-semibold mb-2">Usia Kehamilan (Minggu) </label>
                <input type="number" name="gestational_age" value="{{ old('gestational_age', $pregnantWoman->gestational_age ?? '') }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 @error('gestational_age') border-red-500 @enderror"
                       min="0" max="42">
                @error('gestational_age')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
        </div>

        <div class="flex justify-end space-x-3 pt-4">
            <a href="{{ route('pregnant-women.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                Batal
            </a>
            <button type="submit" class="px-4 py-2 bg-teal-600 hover:bg-teal-700 text-white rounded-lg transition">
                <i class="fas fa-save mr-2"></i> Simpan
            </button>
        </div>
    </form>
</div>
@endsection
