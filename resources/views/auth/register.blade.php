<x-guest-layout>
    <div class="mb-8">
        <h2 class="text-3xl font-semibold text-slate-800" style="font-family: 'DM Serif Display', serif;">Créer un compte</h2>
        <p class="text-slate-500 mt-2 text-sm">Rejoignez ColocApp et gérez votre colocation.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        {{-- Name --}}
        <div>
            <label for="name" class="block text-sm font-medium text-slate-700 mb-1.5">Nom complet</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                   class="w-full px-4 py-3 rounded-xl border text-sm text-slate-800 placeholder-slate-400 transition-all duration-150 outline-none
                          {{ $errors->has('name') ? 'border-red-400 bg-red-50 focus:border-red-500 focus:ring-2 focus:ring-red-100' : 'border-slate-200 bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100' }}"
                   placeholder="Jean Dupont">
            @error('name')
                <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Email --}}
        <div>
            <label for="email" class="block text-sm font-medium text-slate-700 mb-1.5">Adresse e-mail</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                   class="w-full px-4 py-3 rounded-xl border text-sm text-slate-800 placeholder-slate-400 transition-all duration-150 outline-none
                          {{ $errors->has('email') ? 'border-red-400 bg-red-50 focus:border-red-500 focus:ring-2 focus:ring-red-100' : 'border-slate-200 bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100' }}"
                   placeholder="vous@exemple.com">
            @error('email')
                <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Password --}}
        <div>
            <label for="password" class="block text-sm font-medium text-slate-700 mb-1.5">Mot de passe</label>
            <input id="password" type="password" name="password" required autocomplete="new-password"
                   class="w-full px-4 py-3 rounded-xl border text-sm text-slate-800 placeholder-slate-400 transition-all duration-150 outline-none
                          {{ $errors->has('password') ? 'border-red-400 bg-red-50 focus:border-red-500 focus:ring-2 focus:ring-red-100' : 'border-slate-200 bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100' }}"
                   placeholder="Minimum 8 caractères">
            @error('password')
                <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Confirm Password --}}
        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-slate-700 mb-1.5">Confirmer le mot de passe</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                   class="w-full px-4 py-3 rounded-xl border text-sm text-slate-800 placeholder-slate-400 transition-all duration-150 outline-none
                          {{ $errors->has('password_confirmation') ? 'border-red-400 bg-red-50 focus:border-red-500 focus:ring-2 focus:ring-red-100' : 'border-slate-200 bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100' }}"
                   placeholder="Répétez votre mot de passe">
            @error('password_confirmation')
                <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Submit --}}
        <div class="pt-1">
            <button type="submit"
                    class="w-full py-3 px-4 bg-emerald-500 hover:bg-emerald-600 text-white font-semibold text-sm rounded-xl transition-all duration-150 shadow-lg shadow-emerald-500/25 hover:shadow-emerald-500/40 active:scale-[0.98]">
                Créer mon compte
            </button>
        </div>
    </form>

    <p class="text-center text-sm text-slate-500 mt-6">
        Déjà inscrit ?
        <a href="{{ route('login') }}" class="text-emerald-600 hover:text-emerald-700 font-semibold transition-colors">
            Se connecter
        </a>
    </p>
</x-guest-layout>