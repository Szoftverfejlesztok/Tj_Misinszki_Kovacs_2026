<x-app-layout>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Noto+Serif:wght@400;600;700&display=swap"
        rel="stylesheet">

    <div class="page-wrap">
        <div class="main-content">
            <p class="felhasznalo">Lekérdezés-Beírások</p>

            <form method="POST" action="{{ route('dashboard.search') }}" class="main-content">
                @csrf
                <input type="text" name="nev" id="nev" placeholder="Diák neve" class="box">
                <br>
                <button type="submit">Lekérdezés</button>
            </form>

            @if(session('hiba'))
                <p style="color:red; margin-top:20px;">{{ session('hiba') }}</p>
            @endif

            @if(session('siker'))
                <p style="color:green; margin-top:20px;">{{ session('siker') }}</p>
            @endif

            @if ($errors->any())
                <div style="color:red; margin-top:20px;">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <div class="beiras-container">
                @if (!empty($talalat_nev))
                    <h2 class="beiras-cim">Keresett név: {{ $talalat_nev }}</h2>

                    @if($inspections->isEmpty())
                        <p class="beiras-cim">Nincs beírás</p>
                    @else
                        @foreach($inspections as $insp)
                            <div class="beiras-blokk">
                                <p><strong>Beíró diák:</strong> {{ $insp->recorder->name }}</p>
                                <p><strong>Indok:</strong> {{ $insp->record }}</p>
                                <p><strong>Dátum:</strong> {{ $insp->date }}</p>
                            </div>
                        @endforeach
                    @endif

                    @php
                        $roles = DB::table('user_role')->where('userid', auth()->id())->pluck('roleid')->toArray();
                    @endphp

                    @if(array_intersect($roles, [1, 2, 3, 4]))
                        <h3 class="uj-beiras-cim">Új beírás rögzítése</h3>

                        <form method="POST" action="{{ route('inspection.store') }}" class="uj-beiras-form">
                            @csrf
                            <input type="hidden" name="recordedid" value="{{ $user->id }}">
                            <input type="hidden" name="roomid" value="{{ $user->roomid }}">
                            <textarea name="record" required placeholder="Beírás szövege"></textarea>
                            <button type="submit">Beírás mentése</button>
                        </form>
                    @endif
                @endif
            </div>
        </div>
    </div>

    <script>
        const toggleButton = document.querySelector('.menu-toggle');
        const menu = document.querySelector('.main-menu');

        if (toggleButton && menu) {
            toggleButton.addEventListener('click', () => {
                menu.classList.toggle('show');
            });
        }
    </script>
</x-app-layout>