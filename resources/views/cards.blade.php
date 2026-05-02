<!-- resources/views/cards.blade.php -->
<x-app-layout>
    <link rel="stylesheet" href="{{ asset('css/cards.css') }}">

    <div class="cards-container">
        @foreach($penalties as $penalty)
            <div class="card">
                <h3>{{ $penalty->user->name }}</h3>
                <p>Dátum: {{ \Carbon\Carbon::parse($penalty->penalty_date)->format('Y-m-d') }}</p>

                <form method="POST" action="{{ url('/penalty/done/' . $penalty->id) }}">
                    @csrf
                    <button type="submit" class="done-button">
                        Teljesítve
                    </button>
                </form>
            </div>
        @endforeach
    </div>
</x-app-layout>