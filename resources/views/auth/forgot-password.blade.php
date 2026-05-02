<x-guest-layout>
    <link rel="stylesheet" href="{{ asset('css/forgot-password.css') }}">
    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
        {{ __('Elfelejtetted a jelszavadat? Semmi gond. Add meg az email címedet, és küldünk neked egy jelszó-visszaállító linket, amellyel új jelszót tudsz választani.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Jelszó-visszaállító link küldése') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
