<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - SIM Posyandu</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-slate-100 min-h-screen flex items-center justify-center">

<div class="w-full max-w-sm">
    <div class="text-center mb-6">
        <i class="fas fa-baby-carriage text-3xl text-sky-500 mb-2"></i>
        <h1 class="text-xl font-bold text-slate-800">SIM Posyandu</h1>
        <p class="text-sm text-slate-400">Daftar sebagai Orang Tua</p>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 p-6">
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mb-4">
                <label class="block text-sm font-medium text-slate-700 mb-1">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name') }}"
                       class="w-full px-3 py-2 border {{ $errors->has('name') ? 'border-red-400' : 'border-slate-300' }} rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-sky-400"
                       placeholder="Nama lengkap" required autofocus>
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-slate-700 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}"
                       class="w-full px-3 py-2 border {{ $errors->has('email') ? 'border-red-400' : 'border-slate-300' }} rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-sky-400"
                       placeholder="Masukkan Email" required>
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-slate-700 mb-1">Password</label>
                <input type="password" name="password"
                       class="w-full px-3 py-2 border {{ $errors->has('password') ? 'border-red-400' : 'border-slate-300' }} rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-sky-400"
                       placeholder="Minimal 6 Karakter" required>
                @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-5">
                <label class="block text-sm font-medium text-slate-700 mb-1">Konfirmasi Password</label>
                <input type="password" name="password_confirmation"
                       class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-sky-400"
                       placeholder="Konfirmasi Password" required>
            </div>

            <button type="submit" class="w-full bg-sky-500 hover:bg-sky-600 text-white font-medium py-2 rounded-lg text-sm transition">
                Daftar
            </button>
        </form>

        <p class="text-center text-sm text-slate-500 mt-4">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="text-sky-500 hover:underline">Login</a>
        </p>
    </div>
</div>

</body>
</html>
