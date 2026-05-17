<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SIM POSYANDU - @yield('title', 'Dashboard')</title>

    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

    <style>
        body { background-color: #f1f5f9; }
    </style>

    @stack('styles')
</head>
<body class="min-h-screen">

<div class="min-h-screen flex flex-col">

    <nav class="bg-white border-b border-slate-200 sticky top-0 z-50 px-6 py-3">
        <div class="max-w-screen-xl mx-auto flex items-center justify-between">

            <a href="{{ route('dashboard') }}" class="flex items-center gap-2 font-bold text-lg text-sky-600">
                <i class="fas fa-baby-carriage"></i>
                <span>SIM Posyandu</span>
            </a>

            @auth
            <div class="hidden md:flex items-center gap-1">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-1.5 text-sm px-3 py-1.5 rounded-md transition {{ request()->routeIs('dashboard') ? 'bg-sky-50 text-sky-700 font-semibold' : 'text-slate-500 hover:bg-slate-100 hover:text-slate-900' }}">
                    <i class="fas fa-home"></i> Dashboard
                </a>
                @if(Auth::user()->role == 'bidan')
                    <a href="{{ route('pregnant-women.index') }}" class="flex items-center gap-1.5 text-sm px-3 py-1.5 rounded-md transition {{ request()->routeIs('pregnant-women.*') ? 'bg-sky-50 text-sky-700 font-semibold' : 'text-slate-500 hover:bg-slate-100 hover:text-slate-900' }}">
                        <i class="fas fa-female"></i> Ibu Hamil
                    </a>
                    <a href="{{ route('children.index') }}" class="flex items-center gap-1.5 text-sm px-3 py-1.5 rounded-md transition {{ request()->routeIs('children.*') ? 'bg-sky-50 text-sky-700 font-semibold' : 'text-slate-500 hover:bg-slate-100 hover:text-slate-900' }}">
                        <i class="fas fa-baby"></i> Balita
                    </a>
                    <a href="{{ route('immunizations.index') }}" class="flex items-center gap-1.5 text-sm px-3 py-1.5 rounded-md transition {{ request()->routeIs('immunizations.*') ? 'bg-sky-50 text-sky-700 font-semibold' : 'text-slate-500 hover:bg-slate-100 hover:text-slate-900' }}">
                        <i class="fas fa-syringe"></i> Imunisasi
                    </a>
                @else
                    @php
                        $mother = \App\Models\PregnantWoman::where('user_id', Auth::id())->first();
                        $childrenNav = $mother ? \App\Models\Child::where('mother_id', $mother->id)->get() : collect();
                    @endphp
                    @foreach($childrenNav as $childNav)
                        <a href="{{ route('children.show', $childNav->id) }}" class="flex items-center gap-1.5 text-sm px-3 py-1.5 rounded-md transition {{ request()->is('children/'.$childNav->id.'*') ? 'bg-sky-50 text-sky-700 font-semibold' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                            <i class="fas fa-baby"></i> {{ $childNav->name }}
                        </a>
                    @endforeach
                @endif
            </div>

            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" class="flex items-center gap-2 text-slate-600 hover:text-slate-900 px-3 py-2 rounded-lg hover:bg-slate-100 transition text-sm">
                    <i class="fas fa-user-circle text-sky-500"></i>
                    <span class="hidden sm:inline">{{ Auth::user()->name }}</span>
                    <i class="fas fa-chevron-down text-xs opacity-50"></i>
                </button>
                <div x-show="open" @click.outside="open = false" x-transition
                     class="absolute right-0 mt-1 py-1 bg-white border border-slate-200 rounded-lg shadow-lg min-w-[180px]">
                    <div class="px-4 py-2 border-b border-slate-100 mb-1">
                        <p class="text-slate-800 text-sm font-semibold">{{ Auth::user()->name }}</p>
                        <p class="text-sky-500 text-xs">{{ Auth::user()->role == 'bidan' ? 'Bidan' : 'Orang Tua' }}</p>
                    </div>
                    <a href="{{ route('logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                       class="flex items-center gap-2 px-4 py-2 text-sm text-red-500 hover:bg-slate-50 transition">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
                </div>
            </div>
            @endauth
        </div>
    </nav>

    <div class="max-w-screen-xl mx-auto w-full px-6 pt-6">
        <h1 class="text-xl font-semibold text-slate-800">@yield('page-title', 'Dashboard')</h1>
        <p class="text-slate-400 text-sm mt-0.5">{{ \Carbon\Carbon::now()->locale('id')->translatedFormat('l, d F Y') }}</p>
    </div>

    <div class="max-w-screen-xl mx-auto w-full px-6 pt-4">
        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-4 flex justify-between items-center text-sm">
                <div><i class="fas fa-check-circle mr-2"></i>{{ session('success') }}</div>
                <button onclick="this.parentElement.style.display='none'" class="text-green-400 hover:text-green-600"><i class="fas fa-times"></i></button>
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-4 flex justify-between items-center text-sm">
                <div><i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}</div>
                <button onclick="this.parentElement.style.display='none'" class="text-red-400 hover:text-red-600"><i class="fas fa-times"></i></button>
            </div>
        @endif
    </div>

    <main class="flex-1 max-w-screen-xl mx-auto w-full px-6 py-5">
        @yield('content')
    </main>

    <footer class="text-center text-slate-400 text-xs py-4 border-t border-slate-200 mt-4">
        &copy; {{ date('Y') }} SIM Posyandu
    </footer>
</div>

<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

@stack('scripts')
</body>
</html>
