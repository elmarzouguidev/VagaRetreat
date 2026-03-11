<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login — {{ config('app.name', 'VagaRetreat') }} Admin</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased h-full bg-gray-900 flex items-center justify-center">
    <div class="w-full max-w-md px-8">
        <!-- Brand -->
        <div class="text-center mb-12">
            <h1 class="text-3xl font-black tracking-tighter text-white">
                Vaga<span class="text-elmarzouguidev-vaga-red">Admin</span>
            </h1>
            <p class="mt-2 text-sm text-gray-500">Sign in to your admin dashboard</p>
        </div>

        <!-- Login Form -->
        <form method="POST" action="{{ route('admin.login.post') }}" class="space-y-6">
            @csrf

            @if ($errors->any())
                <div class="p-4 bg-red-500/10 border border-red-500/20 rounded-2xl">
                    @foreach ($errors->all() as $error)
                        <p class="text-sm text-red-400 font-medium">{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <div class="space-y-2">
                <label for="email" class="text-[10px] font-black text-gray-500 uppercase tracking-[0.2em]">Email Address</label>
                <input type="email" 
                       name="email" 
                       id="email" 
                       value="{{ old('email') }}"
                       required 
                       autofocus
                       placeholder="admin@vagaretreat.com"
                       class="w-full bg-gray-800 border-2 border-transparent focus:border-elmarzouguidev-vaga-red focus:ring-0 rounded-2xl p-4 text-white font-semibold placeholder-gray-600 transition-all">
            </div>

            <div class="space-y-2">
                <label for="password" class="text-[10px] font-black text-gray-500 uppercase tracking-[0.2em]">Password</label>
                <input type="password" 
                       name="password" 
                       id="password" 
                       required
                       placeholder="••••••••"
                       class="w-full bg-gray-800 border-2 border-transparent focus:border-elmarzouguidev-vaga-red focus:ring-0 rounded-2xl p-4 text-white font-semibold placeholder-gray-600 transition-all">
            </div>

            <div class="flex items-center">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="remember" class="w-4 h-4 rounded border-gray-600 bg-gray-800 text-elmarzouguidev-vaga-red focus:ring-elmarzouguidev-vaga-red">
                    <span class="text-xs font-semibold text-gray-500">Remember me</span>
                </label>
            </div>

            <button type="submit" 
                    class="w-full bg-elmarzouguidev-vaga-red text-white py-4 rounded-2xl text-xs font-black uppercase tracking-[0.3em] hover:bg-red-700 transition-all shadow-xl hover:shadow-red-900/30 flex items-center justify-center group">
                Sign In
                <svg class="w-4 h-4 ml-3 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </button>
        </form>

        <p class="mt-8 text-center text-xs text-gray-600">
            &copy; {{ date('Y') }} VagaRetreat. Admin Access Only.
        </p>
    </div>
</body>
</html>
