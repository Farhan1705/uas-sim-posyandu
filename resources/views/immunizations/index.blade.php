@extends('layouts.app')

@section('title', 'Data Imunisasi')
@section('page-title', 'Manajemen Data Imunisasi')

@section('content')
<div class="bg-white rounded-xl shadow-md p-5">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-semibold text-gray-800">
            <i class="fas fa-syringe text-purple-600 mr-2"></i> Daftar Imunisasi
        </h3>
        <a href="{{ route('immunizations.create') }}" class="bg-teal-600 hover:bg-teal-700 text-white px-4 py-2 rounded-lg text-sm transition flex items-center">
            <i class="fas fa-plus mr-2"></i> Tambah Imunisasi
        </a>
    </div>

    <form method="GET" action="{{ route('immunizations.index') }}" class="mb-4">
        <div class="relative max-w-sm">
            <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
            <input type="text" name="search" value="{{ $search ?? '' }}"
                placeholder="Cari nama balita atau vaksin..."
                class="w-full pl-9 pr-4 py-2 text-sm border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-400">
        </div>
    </form>

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-gray-200">
                    <th class="text-left py-3 px-2 text-sm font-semibold text-gray-600">No</th>
                    <th class="text-left py-3 px-2 text-sm font-semibold text-gray-600">Nama Balita</th>
                    <th class="text-left py-3 px-2 text-sm font-semibold text-gray-600">Nama Vaksin</th>
                    <th class="text-left py-3 px-2 text-sm font-semibold text-gray-600">Target Usia</th>
                    <th class="text-left py-3 px-2 text-sm font-semibold text-gray-600">Tanggal Diberikan</th>
                    <th class="text-left py-3 px-2 text-sm font-semibold text-gray-600">Status</th>
                    <th class="text-left py-3 px-2 text-sm font-semibold text-gray-600">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($immunizations as $index => $immunization)
                <tr class="border-b border-gray-100 hover:bg-gray-50">
                    <td class="py-3 px-2 text-sm">{{ $index + 1 }}</td>
                    <td class="py-3 px-2 text-sm font-medium">{{ $immunization->child->name ?? '-' }}</td>
                    <td class="py-3 px-2 text-sm">{{ $immunization->vaccine_name }}</td>
                    <td class="py-3 px-2 text-sm">{{ $immunization->age_target }} bulan</td>
                    <td class="py-3 px-2 text-sm">{{ $immunization->date_given ? \Carbon\Carbon::parse($immunization->date_given)->format('d/m/Y') : '-' }}</td>
                    <td class="py-3 px-2 text-sm">
                        @if($immunization->status == 'done')
                            <span class="bg-green-100 text-green-700 px-2 py-1 rounded-full text-xs">Selesai</span>
                        @elseif($immunization->status == 'pending')
                            <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded-full text-xs">Pending</span>
                        @else
                            <span class="bg-red-100 text-red-700 px-2 py-1 rounded-full text-xs">Terlewat</span>
                        @endif
                    </td>
                    <td class="py-3 px-2 text-sm">
                        <a href="{{ route('immunizations.edit', $immunization->id) }}" class="text-blue-600 hover:text-blue-700 mr-2">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('immunizations.destroy', $immunization->id) }}" method="POST" class="inline">
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
                    <td colspan="7" class="py-6 text-center text-gray-500">Belum ada data imunisasi</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection