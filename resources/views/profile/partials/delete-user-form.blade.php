<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Fiók inaktiválása') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('A fiókja inaktiválását követően nem tud majd belépni.
                        A fiók csak a szolgáltató által aktiválható újra.
                        Kérjük, a fiók inaktiválása előtt mentse le minden fontos adatát vagy információját.') }}
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >{{ __('Fiók inaktiválása') }}</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Biztosan inaktiválni szeretné a fiókját?') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('A fiókja inaktiválását követően nem tud majd belépni. Kérjük, adja meg jelszavát a fiók inaktiválásának megerősítéséhez.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Jelszó') }}" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-3/4"
                    placeholder="{{ __('Jelszó') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Mégse') }}
                </x-secondary-button>

                <x-danger-button class="ms-3">
                    {{ __('Fiók inaktiválása') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
