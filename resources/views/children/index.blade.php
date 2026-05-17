@extends('layouts.app')

@section('title', 'Data Balita')
@section('page-title', 'Manajemen Data Balita')

@section('content')
<div class="bg-white rounded-xl shadow-md p-5">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-semibold text-gray-800">
            <i class="fas fa-baby text-blue-600 mr-2"></i> Daftar Balita
        </h3>
        <a href="{{ route('children.create') }}" class="bg-teal-600 hover:bg-teal-700 text-white px-4 py-2 rounded-lg text-sm transition flex items-center">
            <i class="fas fa-plus mr-2"></i> Tambah Balita
        </a>
    </div>

    <form method="GET" action="{{ route('children.index') }}" class="mb-4">
        <div class="relative max-w-sm">
            <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
            <input type="text" name="search" value="{{ $search ?? '' }}"
                placeholder="Cari nama balita atau ibu..."
                class="w-full pl-9 pr-4 py-2 text-sm border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-400">
        </div>
    </form>

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-gray-200">
                    <th class="text-left py-3 px-2 text-sm font-semibold text-gray-600">No</th>
                    <th class="text-left py-3 px-2 text-sm font-semibold text-gray-600">Nama Balita</th>
                    <th class="text-left py-3 px-2 text-sm font-semibold text-gray-600">Ibu</th>
                    <th class="text-left py-3 px-2 text-sm font-semibold text-gray-600">Tanggal Lahir</th>
                    <th class="text-left py-3 px-2 text-sm font-semibold text-gray-600">Usia</th>
                    <th class="text-left py-3 px-2 text-sm font-semibold text-gray-600">Jenis Kelamin</th>
                    <th class="text-left py-3 px-2 text-sm font-semibold text-gray-600">Status Gizi</th>
                    <th class="text-left py-3 px-2 text-sm font-semibold text-gray-600">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($children as $index => $child)
                <tr class="border-b border-gray-100 hover:bg-gray-50">
                    <td class="py-3 px-2 text-sm">{{ $index + 1 }}</td>
                    <td class="py-3 px-2 text-sm font-medium">{{ $child->name }}</td>
                    <td class="py-3 px-2 text-sm">{{ $child->mother->name ?? '-' }}</td>
                    <td class="py-3 px-2 text-sm">{{ \Carbon\Carbon::parse($child->birth_date)->format('d/m/Y') }}</td>
                    <td class="py-3 px-2 text-sm">{{ (int) \Carbon\Carbon::parse($child->birth_date)->diffInMonths(now()) }} bulan</td>
                    <td class="py-3 px-2 text-sm">{{ $child->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                    <td class="py-3 px-2 text-sm">
                        @if($child->nutrition_status == 'obesitas')
                            <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded-full text-xs">Obesitas</span>
                        @elseif($child->nutrition_status == 'normal')
                            <span class="bg-green-100 text-green-700 px-2 py-1 rounded-full text-xs">Normal</span>
                        @elseif($child->nutrition_status == 'waspada')
                            <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded-full text-xs">Waspada</span>
                        @else
                            <span class="bg-red-100 text-red-700 px-2 py-1 rounded-full text-xs">Kurang</span>
                        @endif
                    </td>
                    <td class="py-3 px-2 text-sm">
                        <a href="{{ route('children.show', $child->id) }}" class="text-teal-600 hover:text-teal-700 mr-2">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('children.edit', $child->id) }}" class="text-blue-600 hover:text-blue-700 mr-2">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('children.destroy', $child->id) }}" method="POST" class="inline">
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
                    <td colspan="8" class="py-6 text-center text-gray-500">Belum ada data balita</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection