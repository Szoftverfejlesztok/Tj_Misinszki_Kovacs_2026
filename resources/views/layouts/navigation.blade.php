<link rel="stylesheet" href="{{ asset('css/menu.css') }}">

<nav x-data="{ open: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center nav-row">
            <div class="flex items-center nav-left">
                <div class="logo">
                    <img src="{{ asset('images/DOK-logo.png') }}" alt="Logo">
                </div>

                <div class="header-content">
                    <button class="menu-toggle" aria-label="Menu megnyitasa">&#9776;</button>
                </div>

                <div class="main-menu hidden min-[1025px]:block">
                    <ul class="main-menu-list">
                        @php
                            $roles = DB::table('user_role')
                                ->where('userid', auth()->id())
                                ->pluck('roleid')
                                ->toArray();
                        @endphp

                        @if(in_array(1, $roles))
                            <li>
                                <a href="{{ route('admin.dashboard') }}">Adminisztráció</a>
                            </li>
                        @endif

                        <li>
                            <a href="{{ route('dashboard') }}">Lekérdezés / Beírások</a>
                        </li>

                        <li>
                            <a href="{{ route('calendar') }}">Naptár</a>
                        </li>

                        @if(array_intersect($roles, [1,2,3]))
                            <li>
                                <a href="{{ route('cards') }}">Büntetések</a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>

            <div class="flex items-center nav-right">
                <div class="hidden min-[1025px]:flex min-[1025px]:items-center min-[1025px]:ms-6">
                    <x-dropdown class="custom-dropdown">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-800 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                <div>{{ Auth::user()->name }}</div>

                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profil') }}
                            </x-dropdown-link>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link
                                    :href="route('logout')"
                                    onclick="event.preventDefault();
                                             this.closest('form').submit();">
                                    {{ __('Kijelentkezés') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>

                <div class="-me-2 flex items-center min-[1025px]:hidden">
                    <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>


    <div :class="{'block': open, 'hidden': ! open}" class="hidden min-[1025px]:hidden">
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600 px-4">
            <div class="font-medium text-base text-gray-800 dark:text-gray-200">
                {{ Auth::user()->name }}
            </div>

            <div class="font-medium text-sm text-gray-500">
                {{ Auth::user()->email }}
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    Profil
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link
                        :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        Kijelentkezés
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>

        <div class="border-t border-gray-200 dark:border-gray-600 my-2"></div>

        <ul class="flex flex-col gap-2 px-4 pt-2">
            @php
                $roles = DB::table('user_role')
                    ->where('userid', auth()->id())
                    ->pluck('roleid')
                    ->toArray();
            @endphp

            @if(in_array(1, $roles))
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded hover:bg-gray-100">
                        Adminisztráció
                    </a>
                </li>
            @endif

            <div class="border-t border-gray-200 dark:border-gray-600 my-2"></div>

            <li>
                <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded hover:bg-gray-100">
                    Lekérdezés / Beírások
                </a>
            </li>

            <div class="border-t border-gray-200 dark:border-gray-600 my-2"></div>

            <li>
                <a href="{{ route('calendar') }}" class="block px-3 py-2 rounded hover:bg-gray-100">
                    Naptár
                </a>
            </li>

            <div class="border-t border-gray-200 dark:border-gray-600 my-2"></div>

            @if(array_intersect($roles, [1,2,3]))
                <li>
                    <a href="{{ route('cards') }}" class="block px-3 py-2 rounded hover:bg-gray-100">
                        Büntetések
                    </a>
                </li>
            @endif

            <div class="border-t border-gray-200 dark:border-gray-600 my-2"></div>
        </ul>
    </div>
</nav>