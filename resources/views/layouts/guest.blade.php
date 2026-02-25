<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'ColocApp') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600;700&family=DM+Serif+Display&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>body { font-family: 'DM Sans', sans-serif; }</style>
</head>
<body class="antialiased bg-slate-50">

    <div class="min-h-screen flex">
        {{-- Left Panel --}}
        <div class="hidden lg:flex lg:w-1/2 bg-slate-900 relative overflow-hidden flex-col justify-between p-12">
            {{-- Background pattern --}}
            <div class="absolute inset-0 opacity-10">
                <div class="absolute top-20 left-20 w-64 h-64 bg-emerald-400 rounded-full blur-3xl"></div>
                <div class="absolute bottom-20 right-20 w-80 h-80 bg-emerald-600 rounded-full blur-3xl"></div>
            </div>

            <div class="relative z-10">
                <a href="/" class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-emerald-500 rounded-xl flex items-center justify-center text-white font-bold text-xl shadow-lg shadow-emerald-500/30">C</div>
                    <span class="text-2xl text-white" style="font-family: 'DM Serif Display', serif;">ColocApp</span>
                </a>
            </div>

            <div class="relative z-10 space-y-6">
                <p class="text-4xl text-white leading-tight" style="font-family: 'DM Serif Display', serif;">
                    Gérez votre colocation<br>sans stress.
                </p>
                <p class="text-slate-400 text-lg leading-relaxed max-w-sm">
                    Partagez les dépenses, suivez les paiements et invitez vos colocataires en quelques clics.
                </p>

                {{-- Feature pills --}}
                <div class="flex flex-wrap gap-2 pt-2">
                    @foreach(['Dépenses partagées', 'Paiements simplifiés', 'Invitations faciles', 'Historique complet'] as $feat)
                        <span class="px-3 py-1.5 bg-slate-800 text-emerald-400 text-sm rounded-full border border-slate-700">
                            {{ $feat }}
                        </span>
                    @endforeach
                </div>
            </div>

            <div class="relative z-10">
                <p class="text-slate-600 text-sm">© {{ date('Y') }} ColocApp. Tous droits réservés.</p>
            </div>
        </div>

        {{-- Right Panel --}}
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8">
            <div class="w-full max-w-md">
                {{-- Mobile logo --}}
                <div class="lg:hidden mb-8 flex items-center gap-3">
                    <div class="w-9 h-9 bg-emerald-500 rounded-xl flex items-center justify-center text-white font-bold text-lg">C</div>
                    <span class="text-xl text-slate-800" style="font-family: 'DM Serif Display', serif;">ColocApp</span>
                </div>

                {{ $slot }}
            </div>
        </div>
    </div>

</body>
</html>