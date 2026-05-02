<x-guest-layout>
    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email -->
        <div>
            <x-input-label for="email" :value="'Email cím'" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

      <!-- Password -->
<div class="mt-4">
    <x-input-label for="password" :value="'Jelszó'" />
    <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />

    @php
        $passwordErrors = [];
        if ($errors->has('password')) {
            foreach ($errors->get('password') as $error) {
                if (str_contains($error, 'at least 8 characters')) {
                    $passwordErrors[] = 'A jelszónak legalább 8 karakter hosszúnak kell lennie.';
                } elseif (str_contains($error, 'confirmation')) {
                    $passwordErrors[] = 'A két jelszó nem egyezik.';
                } else {
                    $passwordErrors[] = $error; 
                }
            }
        }
    @endphp

    <x-input-error :messages="$passwordErrors" class="mt-2" />
</div>

<!-- Confirm Password -->
<div class="mt-4">
    <x-input-label for="password_confirmation" :value="'Jelszó megerősítése'" />
    <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />

    @php
        $confirmErrors = [];
        if ($errors->has('password_confirmation')) {
            foreach ($errors->get('password_confirmation') as $error) {
                $confirmErrors[] = 'A két jelszó nem egyezik.';
            }
        }
    @endphp

    <x-input-error :messages="$confirmErrors" class="mt-2" />
</div>

       <div class="flex items-center justify-end mt-4">
            <x-primary-button>Jelszó visszaállítása</x-primary-button>
        </div>
    </form>
</x-guest-layout>
