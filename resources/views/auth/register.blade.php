<!DOCTYPE html>
<html lang="hu">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Regisztráció</title>

        <link rel="stylesheet" href="{{ asset('css/register.css') }}">
    </head>

    <body>
        <div class="bg-img"></div>

        <div class="content">
            <header class="regist">Regisztráció</header>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="field">
                    <input type="text" name="name" placeholder="Név" value="{{ old('name') }}" required>
                    @error('name')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field">
                    <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
                    @error('email')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field">
                    <input type="password" name="password" placeholder="Jelszó" required>
                    @error('password')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field">
                    <input
                        type="password"
                        name="password_confirmation"
                        placeholder="Jelszó megerősítés"
                        required
                    >
                    @error('password_confirmation')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field">
                    <input
                        type="text"
                        name="room_number"
                        placeholder="Szobaszám"
                        value="{{ old('room_number') }}"
                    >
                    @error('room_number')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field">
                    <select name="gender" required>
                        <option value="Férfi" {{ old('gender') == 'Férfi' ? 'selected' : '' }}>
                            Férfi
                        </option>
                        <option value="Nő" {{ old('gender') == 'Nő' ? 'selected' : '' }}>
                            Nő
                        </option>
                    </select>

                    @error('gender')
                        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field">
                    <input
                        type="text"
                        name="group_leaderid"
                        placeholder="Csoportvezető"
                        value="{{ old('group_leaderid') }}"
                    >
                    @error('group_leaderid')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>

                <input type="submit" value="Regisztráció" class="gomb">

                <div class="login">
                    <p class="regisztraltal">Már regisztráltál?</p>
                    <a href="{{ route('login') }}" class="login-link">Jelentkezz be</a>
                </div>
            </form>
        </div>
    </body>
</html>