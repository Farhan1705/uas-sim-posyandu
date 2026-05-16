@extends('layouts.app')

@section('title', 'Detail Ibu Hamil')
@section('page-title', 'Detail Data Ibu Hamil')

@section('content')
<div class="bg-white rounded-xl shadow-md p-5">
    <div class="flex justify-end mb-4 space-x-2">
        <a href="{{ route('pregnant-women.edit', $pregnantWoman->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm transition">
            <i class="fas fa-edit mr-2"></i> Edit
        </a>
        <a href="{{ route('pregnant-women.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg text-sm transition">
            <i class="fas fa-arrow-left mr-2"></i> Kembali
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Data Ibu Hamil -->
        <div class="border rounded-lg p-4">
            <h3 class="text-md font-semibold text-teal-600 mb-3">
                <i class="fas fa-female mr-2"></i> Data Ibu
            </h3>
            <table class="w-full text-sm">
                <tr class="border-b">
                    <td class="py-2 w-1/3 text-gray-600">Nama Ibu</td>
                    <td class="py-2 font-medium">{{ $pregnantWoman->name }}</td>
                </tr>
                <tr class="border-b">
                    <td class="py-2 text-gray-600">Nama Suami</td>
                    <td class="py-2 font-medium">{{ $pregnantWoman->husband_name }}</td>
                </tr>
                <tr class="border-b">
                    <td class="py-2 text-gray-600">HPL</td>
                    <td class="py-2 font-medium">{{ $pregnantWoman->due_date ? \Carbon\Carbon::parse($pregnantWoman->due_date)->format('d F Y') : '-' }}</td>
                </tr>
                <tr class="border-b">
                    <td class="py-2 text-gray-600">Usia Kehamilan</td>
                    <td class="py-2 font-medium">{{ $pregnantWoman->gestational_age ? $pregnantWoman->gestational_age . ' minggu' : '-' }}</td>
                </tr>
                <tr>
                    <td class="py-2 text-gray-600">Email</td>
                    <td class="py-2 font-medium">{{ $pregnantWoman->user->email ?? '-' }}</td>
                </tr>
            </table>
        </div>

        <!-- Daftar Anak -->
        <div class="border rounded-lg p-4">
            <h3 class="text-md font-semibold text-teal-600 mb-3">
                <i class="fas fa-baby mr-2"></i> Daftar Anak
            </h3>
            @if($pregnantWoman->children->count() > 0)
                <div class="space-y-2">
                    @foreach($pregnantWoman->children as $child)
                    <div class="bg-gray-50 rounded p-3 flex justify-between items-center">
                        <div>
                            <p class="font-medium">{{ $child->name }}</p>
                            <p class="text-xs text-gray-500">Lahir: {{ \Carbon\Carbon::parse($child->birth_date)->format('d/m/Y') }}</p>
                        </div>
                        <a href="{{ route('children.show', $child->id) }}" class="text-teal-600 hover:text-teal-700">
                            <i class="fas fa-eye"></i>
                        </a>
                    </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center py-4">Belum ada data anak</p>
            @endif
        </div>
    </div>
</div>
@endsection