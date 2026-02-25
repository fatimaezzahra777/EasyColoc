<x-guest-layout>
    <div class="mb-8">
        <h2 class="text-3xl font-semibold text-slate-800" style="font-family: 'DM Serif Display', serif;">Bon retour !</h2>
        <p class="text-slate-500 mt-2 text-sm">Connectez-vous à votre espace colocation.</p>
    </div>

    {{-- Session Status --}}
    @if(session('status'))
        <div class="mb-4 px-4 py-3 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl text-sm">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        {{-- Email --}}
        <div>
            <label for="email" class="block text-sm font-medium text-slate-700 mb-1.5">Adresse e-mail</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                   class="w-full px-4 py-3 rounded-xl border text-sm text-slate-800 placeholder-slate-400 transition-all duration-150 outline-none
                          {{ $errors->has('email') ? 'border-red-400 bg-red-50 focus:border-red-500 focus:ring-2 focus:ring-red-100' : 'border-slate-200 bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100' }}"
                   placeholder="vous@exemple.com">
            @error('email')
                <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Password --}}
        <div>
            <div class="flex items-center justify-between mb-1.5">
                <label for="password" class="block text-sm font-medium text-slate-700">Mot de passe</label>
                @if(Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-xs text-emerald-600 hover:text-emerald-700 font-medium transition-colors">
                        Mot de passe oublié ?
                    </a>
                @endif
            </div>
            <input id="password" type="password" name="password" required autocomplete="current-password"
                   class="w-full px-4 py-3 rounded-xl border text-sm text-slate-800 placeholder-slate-400 transition-all duration-150 outline-none
                          {{ $errors->has('password') ? 'border-red-400 bg-red-50 focus:border-red-500 focus:ring-2 focus:ring-red-100' : 'border-slate-200 bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100' }}"
                   placeholder="••••••••">
            @error('password')
                <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Remember me --}}
        <div class="flex items-center gap-2.5">
            <input id="remember_me" type="checkbox" name="remember"
                   class="w-4 h-4 rounded border-slate-300 text-emerald-500 focus:ring-emerald-400 focus:ring-offset-0 cursor-pointer">
            <label for="remember_me" class="text-sm text-slate-600 cursor-pointer select-none">Se souvenir de moi</label>
        </div>

        {{-- Submit --}}
        <button type="submit"
                class="w-full py-3 px-4 bg-emerald-500 hover:bg-emerald-600 text-white font-semibold text-sm rounded-xl transition-all duration-150 shadow-lg shadow-emerald-500/25 hover:shadow-emerald-500/40 active:scale-[0.98]">
            Se connecter
        </button>
    </form>

    <p class="text-center text-sm text-slate-500 mt-6">
        Pas encore de compte ?
        <a href="{{ route('register') }}" class="text-emerald-600 hover:text-emerald-700 font-semibold transition-colors">
            S'inscrire
        </a>
    </p>
</x-guest-layout>