@extends('layouts.app')

@section('title', 'Data Ibu Hamil')
@section('page-title', 'Manajemen Data Ibu Hamil')

@section('content')
<div class="bg-white rounded-xl shadow-md p-5">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-semibold text-gray-800">
            <i class="fas fa-female text-pink-600 mr-2"></i> Daftar Ibu Hamil
        </h3>
        <a href="{{ route('pregnant-women.create') }}" class="bg-teal-600 hover:bg-teal-700 text-white px-4 py-2 rounded-lg text-sm transition flex items-center">
            <i class="fas fa-plus mr-2"></i> Tambah Ibu Hamil
        </a>
    </div>

    <form method="GET" action="{{ route('pregnant-women.index') }}" class="mb-4">
        <div class="relative max-w-sm">
            <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
            <input type="text" name="search" value="{{ $search ?? '' }}"
                placeholder="Cari nama ibu atau suami..."
                class="w-full pl-9 pr-4 py-2 text-sm border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-400">
        </div>
    </form>

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-gray-200">
                    <th class="text-left py-3 px-2 text-sm font-semibold text-gray-600">No</th>
                    <th class="text-left py-3 px-2 text-sm font-semibold text-gray-600">Nama Ibu</th>
                    <th class="text-left py-3 px-2 text-sm font-semibold text-gray-600">Nama Suami</th>
                    <th class="text-left py-3 px-2 text-sm font-semibold text-gray-600">HPL</th>
                    <th class="text-left py-3 px-2 text-sm font-semibold text-gray-600">Usia Kehamilan</th>
                    <th class="text-left py-3 px-2 text-sm font-semibold text-gray-600">Email</th>
                    <th class="text-left py-3 px-2 text-sm font-semibold text-gray-600">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pregnantWomen as $index => $pregnant)
                <tr class="border-b border-gray-100 hover:bg-gray-50">
                    <td class="py-3 px-2 text-sm">{{ $index + 1 }}</td>
                    <td class="py-3 px-2 text-sm font-medium">{{ $pregnant->name }}</td>
                    <td class="py-3 px-2 text-sm">{{ $pregnant->husband_name }}</td>
                    <td class="py-3 px-2 text-sm">{{ $pregnant->due_date ? \Carbon\Carbon::parse($pregnant->due_date)->format('d/m/Y') : '-' }}</td>
                    <td class="py-3 px-2 text-sm">{{ $pregnant->gestational_age ? $pregnant->gestational_age . ' minggu' : '-' }}</td>
                    <td class="py-3 px-2 text-sm">{{ $pregnant->user->email ?? '-' }}</td>
                    <td class="py-3 px-2 text-sm">
                        <a href="{{ route('pregnant-women.show', $pregnant->id) }}" class="text-teal-600 hover:text-teal-700 mr-2">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('pregnant-women.edit', $pregnant->id) }}" class="text-blue-600 hover:text-blue-700 mr-2">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('pregnant-women.destroy', $pregnant->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-700" onclick="return confirm('Yakin ingin menghapus data ini?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="py-6 text-center text-gray-500">Belum ada data ibu hamil</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection