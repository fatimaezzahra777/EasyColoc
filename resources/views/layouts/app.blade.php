<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'ColocApp') }} — @yield('title', 'Accueil')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;1,9..40,400&family=DM+Serif+Display&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'DM Sans', sans-serif; }
        .serif { font-family: 'DM Serif Display', serif; }
    </style>
</head>
<body class="bg-slate-50 antialiased">

    <div class="flex min-h-screen">

  
        <aside class="w-64 bg-slate-900 text-white flex flex-col fixed h-full z-30 shadow-2xl">


            <div class="px-6 py-5 border-b border-slate-800">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                    <div class="w-9 h-9 bg-emerald-500 rounded-xl flex items-center justify-center font-bold text-lg shadow-lg shadow-emerald-500/30">C</div>
                    <span class="serif text-xl text-white">ColocApp</span>
                </a>
            </div>

            {{-- Nav --}}
            <nav class="flex-1 px-3 py-5 overflow-y-auto space-y-0.5">

                @php
                    use Illuminate\Support\Facades\Route as RouteFacade;

                    $safeRoute = function(string $name, array $params = []) {
                        try {
                            return route($name, $params);
                        } catch (\Exception $e) {
                            return '#';
                        }
                    };

                    $navLinks = [
                        [
                            'href'  => $safeRoute('dashboard'),
                            'label' => 'Tableau de bord',
                            'match' => 'dashboard',
                            'icon'  => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6',
                        ],
                        [
                            'href'  => $safeRoute('colocations.index'),
                            'label' => 'Colocations',
                            'match' => 'colocations.*',
                            'icon'  => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4',
                        ],
                        [
                            'href'  => $safeRoute('dépenses.index'),
                            'label' => 'Dépenses',
                            'match' => 'dépenses.*',
                            'icon'  => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
                        ],
                        [
                            'href'  => $safeRoute('categories.index'),
                            'label' => 'Catégories',
                            'match' => 'categories.*',
                            'icon'  => 'M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z',
                        ],
                        [
                            'href'  => $safeRoute('payments.index'),
                            'label' => 'Paiements',
                            'match' => 'payments.*',
                            'icon'  => 'M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z',
                        ],
                        [
                            'href'  => $safeRoute('invitations.index'),
                            'label' => 'Invitations',
                            'match' => 'invitations.*',
                            'icon'  => 'M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z',
                        ],
                    ];
                @endphp

                @foreach($navLinks as $link)
                    <a href="{{ $link['href'] }}"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-150
                              {{ request()->routeIs($link['match']) ? 'bg-emerald-500 text-white shadow-lg shadow-emerald-500/20' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="{{ $link['icon'] }}"/>
                        </svg>
                        {{ $link['label'] }}
                    </a>
                @endforeach

                @if(auth()->user()?->is_admin)
                    <div class="pt-4 mt-4 border-t border-slate-800">
                        <p class="text-xs font-semibold text-slate-600 uppercase tracking-widest px-3 mb-2">Admin</p>
                        <a href="{{ route('admin.dashboard') }}"
                           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all
                                  {{ request()->routeIs('admin.*') ? 'bg-emerald-500 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            Administration
                        </a>
                        <a href="{{ route('admin.users') }}"
                           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all mt-0.5
                                  {{ request()->routeIs('admin.users') ? 'bg-emerald-500 text-white' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                            Utilisateurs
                        </a>
                    </div>
                @endif
            </nav>

            {{-- User --}}
            <div class="px-3 py-4 border-t border-slate-800">
                <div class="flex items-center gap-3 px-3 py-2.5 rounded-xl bg-slate-800">
                    <div class="w-8 h-8 rounded-lg bg-emerald-500 flex items-center justify-center text-white font-semibold text-sm flex-shrink-0">
                        {{ strtoupper(substr(auth()->user()?->name ?? 'U', 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-white truncate">{{ auth()->user()?->name }}</p>
                        <p class="text-xs text-slate-500 truncate">{{ auth()->user()?->email }}</p>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-slate-500 hover:text-white transition-colors p-1 rounded" title="Déconnexion">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <div class="flex-1 ml-64 flex flex-col">

            {{-- Top Bar --}}
            <header class="bg-white border-b border-slate-200 px-8 py-4 flex items-center justify-between sticky top-0 z-20">
                <div>
                    <h1 class="text-lg font-semibold text-slate-800">@yield('page-title', 'Tableau de bord')</h1>
                    @hasSection('page-subtitle')
                        <p class="text-sm text-slate-500">@yield('page-subtitle')</p>
                    @endif
                </div>
                <div class="flex items-center gap-3">
                    @yield('header-actions')
                </div>
            </header>

            {{-- Content --}}
            <main class="flex-1 p-8">

                {{-- Flash messages --}}
                @if(session('success'))
                    <div class="flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl mb-6 text-sm">
                        <svg class="w-5 h-5 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="flex items-center gap-3 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl mb-6 text-sm">
                        <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

</body>
</html>