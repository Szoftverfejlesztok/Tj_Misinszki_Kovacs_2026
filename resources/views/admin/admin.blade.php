<x-app-layout>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">

    <div class="admin-content">
        <!-- Felhasználói szerepek -->
        <div x-data="{ open: {{ isset($user) || session('hiba') || session('error') || session('success') ? 'true' : 'false' }} }">
            <button @click="open = !open" class="btn btn-blue">
                Felhasználói szerepek
            </button>

            <div x-show="open" x-transition class="panel">
                <form action="{{ route('admin.users.search') }}" method="POST">
                    @csrf
                    <input type="text" name="name" placeholder="Felhasználó neve" required>
                    <input type="email" name="email" placeholder="Email" required>
                    <button type="submit">Keresés</button>
                </form>

                @if(session('hiba'))
                    <p class="text-error">{{ session('hiba') }}</p>
                @endif

                @if(session('error'))
                    <p class="text-error">{{ session('error') }}</p>
                @endif

                @if(session('success'))
                    <p class="text-success">{{ session('success') }}</p>
                @endif

                @isset($user)
                    <div>
                        <h3>{{ $user->name }} ({{ $user->email }})</h3>

                        <form action="{{ route('admin.users.updateRoles', $user) }}" method="POST">
                            @csrf

                            @foreach(DB::table('roles')->get() as $role)
                                <label>
                                    <input
                                        type="checkbox"
                                        name="roles[]"
                                        value="{{ $role->roleid }}"
                                        {{ in_array($role->roleid, $roles ?? []) ? 'checked' : '' }}
                                    >
                                    {{ $role->name }}
                                </label>
                            @endforeach

                            <button type="submit">Role-ok frissítése</button>
                        </form>
                    </div>
                @endisset
            </div>
        </div>

        <!-- Fiók státusz -->
        <div x-data="{ openStatus: {{ isset($statusUser) || session('hiba_status') || session('success_status') ? 'true' : 'false' }} }">
            <button @click="openStatus = !openStatus" class="btn btn-green">
                Fiók státusz kezelése
            </button>

            <div x-show="openStatus" x-transition class="panel">
                <form action="{{ route('admin.users.statusSearch') }}" method="POST">
                    @csrf
                    <input type="text" name="name" placeholder="Felhasználó neve" required>
                    <input type="email" name="email" placeholder="Email" required>
                    <button type="submit">Keresés</button>
                </form>

                @if(session('hiba_status'))
                    <p class="text-error">{{ session('hiba_status') }}</p>
                @endif

                @if(session('success_status'))
                    <p class="text-success">{{ session('success_status') }}</p>
                @endif

                @isset($statusUser)
                    <div>
                        <h3>{{ $statusUser->name }} ({{ $statusUser->email }})</h3>
                        <p>Jelenlegi státusz: {{ $statusUser->account_status == 1 ? 'Aktív' : 'Inaktív' }}</p>

                        <form action="{{ route('admin.users.updateStatus', $statusUser) }}" method="POST">
                            @csrf
                            @method('patch')

                            <select name="account_status">
                                <option value="1" {{ $statusUser->account_status == 1 ? 'selected' : '' }}>
                                    Aktív
                                </option>
                                <option value="0" {{ $statusUser->account_status == 0 ? 'selected' : '' }}>
                                    Inaktív
                                </option>
                            </select>

                            <button type="submit">Mentés</button>
                        </form>
                    </div>
                @endisset
            </div>
        </div>

        <!-- Csoportvezető -->
        <div x-data="{ openLeader: {{ isset($leaderUser) || session('hiba_leader') || session('success_leader') ? 'true' : 'false' }} }">
            <button @click="openLeader = !openLeader" class="btn btn-purple">
                Csoportvezető kezelése
            </button>

            <div x-show="openLeader" x-transition class="panel">
                <form action="{{ route('admin.users.groupLeaderSearch') }}" method="POST">
                    @csrf
                    <input type="text" name="name" placeholder="Felhasználó neve" required>
                    <input type="email" name="email" placeholder="Email" required>
                    <button type="submit">Keresés</button>
                </form>

                @if(session('hiba_leader'))
                    <p class="text-error">{{ session('hiba_leader') }}</p>
                @endif

                @if(session('success_leader'))
                    <p class="text-success">{{ session('success_leader') }}</p>
                @endif

                @isset($leaderUser)
                    <div>
                        <h3>{{ $leaderUser->name }} ({{ $leaderUser->email }})</h3>

                        @if($currentLeader)
                            <p>
                                Jelenlegi csoportvezető:
                                {{ $currentLeader->name }} ({{ $currentLeader->email }})
                            </p>
                        @else
                            <p>Nincs csoportvezetője.</p>
                        @endif

                        <form action="{{ route('admin.users.assignLeader', $leaderUser) }}" method="POST">
                            @csrf

                            <input type="text" name="leader_name" placeholder="Csoportvezető neve" required>
                            <input type="email" name="leader_email" placeholder="Csoportvezető email" required>

                            @if($currentLeader)
                                <label>
                                    <input type="checkbox" name="replace_leader" value="1">
                                    Csoportvezető lecserélése
                                </label>
                            @endif

                            <button type="submit">Mentés</button>
                        </form>
                    </div>
                @endisset
            </div>
        </div>

        <div x-data="{ 
    openRoomCheck: {{ ($errors->any() || session('hiba_assignments') || session('success_assignments')) ? 'true' : 'false' }}, 
    selectedDay: '{{ old('selected_day', '') }}' 
}">
    <button type="button" @click="openRoomCheck = !openRoomCheck">
        Szobaellenőrzés kezelése
    </button>

    <div x-show="openRoomCheck" x-transition>     

        @if(session('hiba_assignments'))
            <p>{{ session('hiba_assignments') }}</p>
        @endif

        @if(session('success_assignments'))
            <p>{{ session('success_assignments') }}</p>
        @endif

        @if($maleInspectors->count() < 2)
            <p>Nincs legalább 2 választható férfi szobanéző.</p>
        @endif

        @if($femaleInspectors->count() < 2)
            <p>Nincs legalább 2 választható női szobanéző.</p>
        @endif

        <form action="{{ route('admin.assignments.save') }}" method="POST">
            @csrf

            <div>
                <h3>Nap kiválasztása</h3>

                <label>
                    <input type="radio" name="selected_day" value="vasarnap" x-model="selectedDay" {{ old('selected_day') === 'vasarnap' ? 'checked' : '' }}>
                    Vasárnap
                </label>

                <label>
                    <input type="radio" name="selected_day" value="hetfo" x-model="selectedDay" {{ old('selected_day') === 'hetfo' ? 'checked' : '' }}>
                    Hétfő
                </label>

                <label>
                    <input type="radio" name="selected_day" value="kedd" x-model="selectedDay" {{ old('selected_day') === 'kedd' ? 'checked' : '' }}>
                    Kedd
                </label>

                <label>
                    <input type="radio" name="selected_day" value="szerda" x-model="selectedDay" {{ old('selected_day') === 'szerda' ? 'checked' : '' }}>
                    Szerda
                </label>

                <label>
                    <input type="radio" name="selected_day" value="csutortok" x-model="selectedDay" {{ old('selected_day') === 'csutortok' ? 'checked' : '' }}>
                    Csütörtök
                </label>

                <label>
                    <input type="radio" name="selected_day" value="pentek" x-model="selectedDay" {{ old('selected_day') === 'pentek' ? 'checked' : '' }}>
                    Péntek
                </label>

                <label>
                    <input type="radio" name="selected_day" value="szombat" x-model="selectedDay" {{ old('selected_day') === 'szombat' ? 'checked' : '' }}>
                    Szombat
                </label>

                @error('selected_day')
                    <p>{{ $message }}</p>
                @enderror
            </div>

            <div>
                <h3>Férfi felhasználók</h3>

                <div>
                    <label for="male_user_1">Első férfi</label>
                    <select id="male_user_1" name="male_user_1" required>
                        <option value="">Válassz férfi felhasználót</option>
                        @foreach($maleInspectors as $user)
                            <option value="{{ $user->id }}" {{ old('male_user_1') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('male_user_1')
                        <p>{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="male_user_2">Második férfi</label>
                    <select id="male_user_2" name="male_user_2" required>
                        <option value="">Válassz férfi felhasználót</option>
                        @foreach($maleInspectors as $user)
                            <option value="{{ $user->id }}" {{ old('male_user_2') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('male_user_2')
                        <p>{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <h3>Női felhasználók</h3>

                <div>
                    <label for="female_user_1">Első nő</label>
                    <select id="female_user_1" name="female_user_1" required>
                        <option value="">Válassz női felhasználót</option>
                        @foreach($femaleInspectors as $user)
                            <option value="{{ $user->id }}" {{ old('female_user_1') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('female_user_1')
                        <p>{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="female_user_2">Második nő</label>
                    <select id="female_user_2" name="female_user_2" required>
                        <option value="">Válassz női felhasználót</option>
                        @foreach($femaleInspectors as $user)
                            <option value="{{ $user->id }}" {{ old('female_user_2') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('female_user_2')
                        <p>{{ $message }}</p>
                    @enderror
                </div>
            </div>

           <div>
                <button 
                    type="submit"
                    {{ ($maleInspectors->count() < 2 || $femaleInspectors->count() < 2) ? 'disabled' : '' }}>
                        Mentés
                </button>
            </div>
        </form>
    </div>
</div>

    </div>
</x-app-layout>