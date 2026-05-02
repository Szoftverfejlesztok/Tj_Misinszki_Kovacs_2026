<x-app-layout>
    <link rel="stylesheet" href="{{ asset('css/calendar.css') }}">

    @php
        $current = \Carbon\Carbon::create($year, $month, 1);
        $prevMonth = $current->copy()->subMonth();
        $nextMonth = $current->copy()->addMonth();
    @endphp

    <div class="month-navigation">
        <a href="{{ route('calendar', ['year' => $prevMonth->year, 'month' => $prevMonth->month]) }}">
            &laquo; Előző
        </a>

        <span style="margin:0 20px; font-weight:bold;">
            {{ $current->format('F Y') }}
        </span>

        <a href="{{ route('calendar', ['year' => $nextMonth->year, 'month' => $nextMonth->month]) }}">
            Következő &raquo;
        </a>
    </div>

    <table class="calendar">
        <thead>
            <tr>
                <th>Mon</th>
                <th>Tue</th>
                <th>Wed</th>
                <th>Thu</th>
                <th>Fri</th>
                <th>Sat</th>
                <th>Sun</th>
            </tr>
        </thead>

        <tbody>
            @php
                $firstDayOfWeek = $current->dayOfWeekIso;
                $dayCounter = 1;
                $today = now();
            @endphp

            <tr>
                @for($i = 1; $i < $firstDayOfWeek; $i++)
                    <td></td>
                    @php $dayCounter++; @endphp
                @endfor

                @foreach($days as $day)
                    @php
                        $isToday = $day->date->isSameDay($today);
                        $cssClass = "calendar-day" . ($isToday ? " today" : "");
                        $bgColor = "";

                        if ($day->status == 1) $bgColor = "cbx-yellow";
                        if ($day->status == 2) $bgColor = "cbx-green";
                    @endphp

                    <td
                        class="{{ $cssClass }} {{ $bgColor }}"
                        data-date="{{ $day->date->format('Y-m-d') }}"
                    >
                        {{ $day->date->day }}
                    </td>

                    @if($dayCounter % 7 == 0)
                        </tr>
                        <tr>
                    @endif

                    @php $dayCounter++; @endphp
                @endforeach
            </tr>
        </tbody>
    </table>

    @if(isset($selectedDate))
        <div class="calendar-bottom-section">
            @if($assignments->count() > 0)
                @php
                    $maleAssignments = $assignments->whereIn('assigned_level', ['1']);
                    $femaleAssignments = $assignments->where('assigned_level', '2');
                @endphp

                <div class="assignment-container">
                    <h2 class="section-title">Szobaellenőrzők ezen a napon:</h2>

                    <h3>Férfi szobaellenőrzők:</h3>
                    @forelse($maleAssignments as $a)
                        <div class="assignment-card">
                            <div>{{ $a->user1_name }}</div>
                            <div>{{ $a->user2_name }}</div>
                        </div>
                    @empty
                        <p class="no-assignment">Nincs férfi beosztás.</p>
                    @endforelse

                    <h3>Női szobaellenőrzők:</h3>
                    @forelse($femaleAssignments as $a)
                        <div class="assignment-card">
                            <div>{{ $a->user1_name }}</div>
                            @if(!empty($a->user2_name))
                                <div>{{ $a->user2_name }}</div>
                            @endif
                        </div>
                    @empty
                        <p class="no-assignment">Nincs női beosztás.</p>
                    @endforelse
                </div>
            @else
                <p class="no-assignment">Nincs beosztás erre a napra.</p>
            @endif

            <div class="inspection-container">
                <h2 class="inspection-title">Beírások ezen a napon: {{ $selectedDate }}</h2>

                @if($records->count() == 0)
                    <p class="no-record">Nincs beírás ezen a napon.</p>
                @else
                    <div class="inspection-grid">
                        @foreach($records as $record)
                            <div class="inspection-card">
                                <div class="card-header">
                                    <span class="student-name">{{ $record->user_name }}</span>
                                    <span class="room-number">Szoba {{ $record->room_number }}</span>
                                </div>

                                <div class="card-body">
                                    {{ $record->record }}
                                </div>

                                <div class="card-footer">
                                    {{ $record->date }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    @endif

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const navType = performance.getEntriesByType("navigation")[0]?.type;
            const perf = performance.navigation?.type;
            const isReload = navType === "reload" || perf === performance.navigation.TYPE_RELOAD;

            if (isReload) {
                const today = new Date();
                const currentYear = today.getFullYear();
                const currentMonth = today.getMonth() + 1;

                const urlParams = new URLSearchParams(window.location.search);
                const year = parseInt(urlParams.get("year"));
                const month = parseInt(urlParams.get("month"));

                if (year !== currentYear || month !== currentMonth) {
                    window.location.href = `{{ route('calendar') }}?year=${currentYear}&month=${currentMonth}`;
                    return;
                }
            }

            const days = document.querySelectorAll(".calendar-day");

            days.forEach(function(day) {
                day.addEventListener("click", function() {
                    const date = this.dataset.date;
                    if (!date) return;

                    const parts = date.split("-");
                    const year = parts[0];
                    const month = parts[1];
                    const dayNum = parts[2];

                    window.location.href = `{{ route('calendar') }}?year=${year}&month=${month}&day=${dayNum}`;
                });
            });
        });
    </script>
</x-app-layout>