<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'ColocApp') }} — Gérez votre colocation simplement</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;1,9..40,400&family=DM+Serif+Display&display=swap" rel="stylesheet">
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    <style>
        body { font-family: 'DM Sans', sans-serif; }
        .serif { font-family: 'DM Serif Display', serif; }
    </style>
</head>
<body class="bg-slate-950 text-white antialiased overflow-x-hidden">

    {{-- ========== NAVBAR ========== --}}
    <header class="fixed top-0 left-0 right-0 z-50 border-b border-white/5 bg-slate-950/80 backdrop-blur-xl">
        <div class="max-w-6xl mx-auto px-6 h-16 flex items-center justify-between">
            <a href="/" class="flex items-center gap-3">
                <div class="w-8 h-8 bg-emerald-500 rounded-lg flex items-center justify-center font-bold text-sm shadow-lg shadow-emerald-500/30">C</div>
                <span class="serif text-lg text-white">ColocApp</span>
            </a>

            <nav class="hidden md:flex items-center gap-8 text-sm text-slate-400">
                <a href="#features" class="hover:text-white transition-colors">Fonctionnalités</a>
                <a href="#how" class="hover:text-white transition-colors">Comment ça marche</a>
                <a href="#faq" class="hover:text-white transition-colors">FAQ</a>
            </nav>

            <div class="flex items-center gap-3">
                @auth
                    <a href="{{ url('/dashboard') }}"
                       class="px-4 py-2 bg-emerald-500 hover:bg-emerald-400 text-white text-sm font-semibold rounded-xl transition-all shadow-lg shadow-emerald-500/25">
                        Tableau de bord
                    </a>
                @else
                    @if (Route::has('login'))
                        <a href="{{ route('login') }}"
                           class="px-4 py-2 text-slate-400 hover:text-white text-sm font-medium transition-colors">
                            Connexion
                        </a>
                    @endif
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                           class="px-4 py-2 bg-emerald-500 hover:bg-emerald-400 text-white text-sm font-semibold rounded-xl transition-all shadow-lg shadow-emerald-500/25">
                            Commencer gratuitement
                        </a>
                    @endif
                @endauth
            </div>
        </div>
    </header>

    {{-- ========== HERO ========== --}}
    <section class="min-h-screen flex items-center justify-center relative pt-16 px-6">

        {{-- Background glow --}}
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute top-1/4 left-1/2 -translate-x-1/2 w-[800px] h-[500px] bg-emerald-500/10 rounded-full blur-3xl"></div>
            <div class="absolute top-1/3 left-1/4 w-64 h-64 bg-emerald-400/5 rounded-full blur-2xl"></div>
            <div class="absolute top-1/3 right-1/4 w-80 h-80 bg-teal-400/5 rounded-full blur-2xl"></div>
        </div>

        {{-- Grid pattern --}}
        <div class="absolute inset-0 opacity-[0.03]" style="background-image: linear-gradient(#fff 1px, transparent 1px), linear-gradient(90deg, #fff 1px, transparent 1px); background-size: 60px 60px;"></div>

        <div class="max-w-4xl mx-auto text-center relative z-10">

            {{-- Badge --}}
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-xs font-semibold uppercase tracking-widest mb-8">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                Gestion de colocation simplifiée
            </div>

            <h1 class="serif text-5xl md:text-7xl text-white leading-tight mb-6">
                Finis les disputes<br>
                <span class="text-emerald-400">d'argent</span> entre colocs.
            </h1>

            <p class="text-slate-400 text-lg md:text-xl max-w-2xl mx-auto leading-relaxed mb-10">
                ColocApp centralise vos dépenses partagées, calcule automatiquement qui doit quoi à qui,
                et simplifie les remboursements entre colocataires.
            </p>

            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                @auth
                    <a href="{{ url('/dashboard') }}"
                       class="inline-flex items-center gap-2 px-7 py-3.5 bg-emerald-500 hover:bg-emerald-400 text-white font-semibold rounded-2xl transition-all shadow-2xl shadow-emerald-500/30 text-base">
                        Accéder au tableau de bord
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                @else
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                           class="inline-flex items-center gap-2 px-7 py-3.5 bg-emerald-500 hover:bg-emerald-400 text-white font-semibold rounded-2xl transition-all shadow-2xl shadow-emerald-500/30 text-base">
                            Créer un compte gratuit
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    @endif
                    @if (Route::has('login'))
                        <a href="{{ route('login') }}"
                           class="inline-flex items-center gap-2 px-7 py-3.5 bg-white/5 hover:bg-white/10 border border-white/10 text-white font-medium rounded-2xl transition-all text-base">
                            Se connecter
                        </a>
                    @endif
                @endauth
            </div>

            {{-- Social proof --}}
            <div class="flex items-center justify-center gap-2 mt-10 text-slate-500 text-sm">
                <div class="flex -space-x-2">
                    @foreach(['E', 'M', 'T', 'A', 'L'] as $letter)
                        <div class="w-7 h-7 rounded-full bg-gradient-to-br from-emerald-400 to-teal-600 border-2 border-slate-950 flex items-center justify-center text-white text-xs font-bold">
                            {{ $letter }}
                        </div>
                    @endforeach
                </div>
                <span>Rejoignez <strong class="text-slate-300">+500 colocations</strong> qui nous font confiance</span>
            </div>
        </div>
    </section>

    {{-- ========== STATS ========== --}}
    <section class="py-16 border-y border-white/5 bg-white/[0.02]">
        <div class="max-w-5xl mx-auto px-6">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                @foreach([
                    ['value' => '500+', 'label' => 'Colocations actives'],
                    ['value' => '12k+', 'label' => 'Dépenses enregistrées'],
                    ['value' => '98%', 'label' => 'Satisfaction utilisateurs'],
                    ['value' => '0€',  'label' => 'Pour toujours gratuit'],
                ] as $stat)
                    <div>
                        <p class="serif text-4xl text-emerald-400 mb-1">{{ $stat['value'] }}</p>
                        <p class="text-slate-500 text-sm">{{ $stat['label'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ========== FEATURES ========== --}}
    <section id="features" class="py-24 px-6">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16">
                <p class="text-emerald-400 text-xs font-semibold uppercase tracking-widest mb-3">Fonctionnalités</p>
                <h2 class="serif text-4xl md:text-5xl text-white mb-4">Tout ce qu'il vous faut</h2>
                <p class="text-slate-400 max-w-xl mx-auto">Une suite d'outils pensée pour rendre la vie en colocation plus sereine.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                @php
                    $features = [
                        [
                            'icon'  => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
                            'title' => 'Dépenses partagées',
                            'desc'  => 'Enregistrez chaque dépense en quelques secondes et répartissez-la équitablement entre les colocataires.',
                            'color' => 'emerald',
                        ],
                        [
                            'icon'  => 'M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z',
                            'title' => 'Soldes en temps réel',
                            'desc'  => 'Visualisez instantanément qui doit de l\'argent à qui. Fini les calculs manuels interminables.',
                            'color' => 'teal',
                        ],
                        [
                            'icon'  => 'M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z',
                            'title' => 'Remboursements simplifiés',
                            'desc'  => 'Enregistrez les paiements entre membres et confirmez les remboursements d\'un clic.',
                            'color' => 'cyan',
                        ],
                        [
                            'icon'  => 'M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z',
                            'title' => 'Invitations par e-mail',
                            'desc'  => 'Invitez vos colocataires en un clic. Ils reçoivent un lien pour rejoindre votre colocation.',
                            'color' => 'emerald',
                        ],
                        [
                            'icon'  => 'M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z',
                            'title' => 'Catégories personnalisées',
                            'desc'  => 'Organisez vos dépenses par catégories (courses, loyer, énergie…) et analysez vos habitudes.',
                            'color' => 'teal',
                        ],
                        [
                            'icon'  => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4',
                            'title' => 'Multi-colocations',
                            'desc'  => 'Gérez plusieurs logements depuis un seul compte. Idéal pour les propriétaires ou les étudiants.',
                            'color' => 'cyan',
                        ],
                    ];
                @endphp

                @foreach($features as $feature)
                    @php
                        $colors = [
                            'emerald' => ['bg' => 'bg-emerald-500/10', 'border' => 'border-emerald-500/10', 'icon' => 'text-emerald-400', 'hover' => 'hover:border-emerald-500/30'],
                            'teal'    => ['bg' => 'bg-teal-500/10',    'border' => 'border-teal-500/10',    'icon' => 'text-teal-400',    'hover' => 'hover:border-teal-500/30'],
                            'cyan'    => ['bg' => 'bg-cyan-500/10',    'border' => 'border-cyan-500/10',    'icon' => 'text-cyan-400',    'hover' => 'hover:border-cyan-500/30'],
                        ][$feature['color']];
                    @endphp
                    <div class="p-6 rounded-2xl bg-white/[0.03] border {{ $colors['border'] }} {{ $colors['hover'] }} transition-all duration-200 group">
                        <div class="w-11 h-11 rounded-xl {{ $colors['bg'] }} flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5 {{ $colors['icon'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="{{ $feature['icon'] }}"/>
                            </svg>
                        </div>
                        <h3 class="font-semibold text-white mb-2">{{ $feature['title'] }}</h3>
                        <p class="text-slate-400 text-sm leading-relaxed">{{ $feature['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ========== HOW IT WORKS ========== --}}
    <section id="how" class="py-24 px-6 bg-white/[0.02] border-y border-white/5">
        <div class="max-w-5xl mx-auto">
            <div class="text-center mb-16">
                <p class="text-emerald-400 text-xs font-semibold uppercase tracking-widest mb-3">Simple comme bonjour</p>
                <h2 class="serif text-4xl md:text-5xl text-white mb-4">Comment ça marche ?</h2>
                <p class="text-slate-400 max-w-xl mx-auto">Démarrez en moins de 2 minutes.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 relative">
                {{-- Connecting line --}}
                <div class="hidden md:block absolute top-8 left-1/3 right-1/3 h-px bg-gradient-to-r from-emerald-500/0 via-emerald-500/40 to-emerald-500/0"></div>

                @foreach([
                    ['step' => '01', 'title' => 'Créez votre colocation', 'desc' => 'Inscrivez-vous et créez votre première colocation en quelques secondes. Donnez-lui un nom et une adresse.'],
                    ['step' => '02', 'title' => 'Invitez vos colocs', 'desc' => 'Envoyez une invitation par e-mail à chaque colocataire. Ils rejoignent votre espace en un clic.'],
                    ['step' => '03', 'title' => 'Gérez les dépenses', 'desc' => 'Ajoutez chaque dépense, choisissez comment la répartir, et laissez ColocApp calculer les soldes automatiquement.'],
                ] as $step)
                    <div class="relative text-center">
                        <div class="w-16 h-16 rounded-2xl bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center mx-auto mb-5">
                            <span class="serif text-2xl text-emerald-400">{{ $step['step'] }}</span>
                        </div>
                        <h3 class="font-semibold text-white text-lg mb-3">{{ $step['title'] }}</h3>
                        <p class="text-slate-400 text-sm leading-relaxed">{{ $step['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ========== FAQ ========== --}}
    <section id="faq" class="py-24 px-6">
        <div class="max-w-2xl mx-auto">
            <div class="text-center mb-16">
                <p class="text-emerald-400 text-xs font-semibold uppercase tracking-widest mb-3">Questions fréquentes</p>
                <h2 class="serif text-4xl text-white">Vous avez des questions ?</h2>
            </div>

            <div class="space-y-3">
                @foreach([
                    ['q' => 'ColocApp est-il gratuit ?',          'a' => 'Oui, ColocApp est entièrement gratuit. Créez autant de colocations que vous voulez, invitez autant de membres que nécessaire, sans aucune limite.'],
                    ['q' => 'Combien de colocataires puis-je inviter ?', 'a' => 'Il n\'y a aucune limite au nombre de membres par colocation. Que vous soyez 2 ou 10 colocataires, ColocApp s\'adapte.'],
                    ['q' => 'Puis-je gérer plusieurs colocations ?', 'a' => 'Absolument. Depuis un seul compte, vous pouvez gérer plusieurs logements. Utile si vous êtes propriétaire ou si vous changez de colocation.'],
                    ['q' => 'Comment sont calculés les remboursements ?', 'a' => 'ColocApp calcule automatiquement les soldes de chaque membre. Il vous indique qui doit de l\'argent à qui, et le montant exact.'],
                    ['q' => 'Mes données sont-elles sécurisées ?',  'a' => 'Vos données sont stockées de façon sécurisée. Nous ne partageons jamais vos informations avec des tiers.'],
                ] as $faq)
                    <details class="group bg-white/[0.03] border border-white/5 rounded-2xl overflow-hidden">
                        <summary class="flex items-center justify-between px-6 py-4 cursor-pointer text-white font-medium select-none hover:bg-white/[0.03] transition-colors">
                            {{ $faq['q'] }}
                            <svg class="w-5 h-5 text-slate-400 group-open:rotate-45 transition-transform flex-shrink-0 ml-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                        </summary>
                        <div class="px-6 pb-5 text-slate-400 text-sm leading-relaxed border-t border-white/5 pt-4">
                            {{ $faq['a'] }}
                        </div>
                    </details>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ========== CTA ========== --}}
    <section class="py-24 px-6">
        <div class="max-w-3xl mx-auto text-center">
            <div class="relative rounded-3xl bg-gradient-to-br from-emerald-500/20 via-emerald-500/10 to-transparent border border-emerald-500/20 px-8 py-16 overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-br from-emerald-500/5 to-transparent pointer-events-none"></div>
                <div class="absolute -top-16 -right-16 w-48 h-48 bg-emerald-500/20 rounded-full blur-3xl pointer-events-none"></div>

                <div class="relative z-10">
                    <h2 class="serif text-4xl md:text-5xl text-white mb-4">
                        Prêt à simplifier<br>votre colocation ?
                    </h2>
                    <p class="text-slate-400 mb-8 text-lg">
                        Rejoignez des centaines de colocataires qui vivent enfin en paix.
                    </p>
                    @auth
                        <a href="{{ url('/dashboard') }}"
                           class="inline-flex items-center gap-2 px-8 py-4 bg-emerald-500 hover:bg-emerald-400 text-white font-semibold rounded-2xl transition-all shadow-2xl shadow-emerald-500/30 text-base">
                            Accéder à mon tableau de bord
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    @else
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                               class="inline-flex items-center gap-2 px-8 py-4 bg-emerald-500 hover:bg-emerald-400 text-white font-semibold rounded-2xl transition-all shadow-2xl shadow-emerald-500/30 text-base">
                                Démarrer gratuitement
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </a>
                        @endif
                    @endauth
                    <p class="text-slate-500 text-sm mt-4">Gratuit · Sans carte bancaire · En 2 minutes</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ========== FOOTER ========== --}}
    <footer class="border-t border-white/5 py-10 px-6">
        <div class="max-w-6xl mx-auto flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="w-7 h-7 bg-emerald-500 rounded-lg flex items-center justify-center text-white font-bold text-xs">C</div>
                <span class="serif text-white">ColocApp</span>
            </div>
            <p class="text-slate-600 text-sm">© {{ date('Y') }} ColocApp. Fait avec ❤️ pour les colocataires.</p>
            <div class="flex items-center gap-6 text-sm text-slate-500">
                <a href="#" class="hover:text-slate-300 transition-colors">Confidentialité</a>
                <a href="#" class="hover:text-slate-300 transition-colors">Conditions</a>
                <a href="#" class="hover:text-slate-300 transition-colors">Contact</a>
            </div>
        </div>
    </footer>

</body>
</html>