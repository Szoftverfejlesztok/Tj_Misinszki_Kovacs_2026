<!DOCTYPE html>
<html lang="hu">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bejelentkezés</title>
  <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>
  <p class="dok">DÖK</p>

  <form class="bejelentkezes" method="POST" action="{{ route('login') }}">
      @csrf

      @if (session('error'))
          <div class="error-text mb-3">{{ session('error') }}</div>
      @endif

    <div class="mezo">
        <input type="text" class="input" name="email" placeholder="Email" autocomplete="username" required autofocus value="{{ old('email') }}">
        @error('email')
            <div class="error-text">{{ $message }}</div> 
        @enderror
    </div>

    <div class="mezo">
        <input type="password" class="input" name="password" placeholder="Jelszó" autocomplete="current-password" required>
    </div>

    <div class="elfelejtett">
        <a href="{{ route('password.request') }}">Elfelejtetted a jelszavadat?</a>
    </div>

      <button class="gomb" type="submit">Bejelentkezés</button>
  </form>
</body>
</html>