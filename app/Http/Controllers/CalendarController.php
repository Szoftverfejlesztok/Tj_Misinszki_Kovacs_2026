<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CalendarController extends Controller
{
    public function index(Request $request)
    {
        $year = $request->query('year', now()->year);
        $month = $request->query('month', now()->month);
        $day = $request->query('day');

        $startOfMonth = Carbon::create($year, $month, 1);
        $endOfMonth = $startOfMonth->copy()->endOfMonth();

        $days = [];
        $current = $startOfMonth->copy();

        while ($current <= $endOfMonth) {
            $days[] = (object)[
                'date' => $current->copy(),
                'status' => 0
            ];
            $current->addDay();
        }

        $records = collect();
        $selectedDate = null;
        $assignments = collect();
        $maleAssignments = collect();
        $femaleAssignments = collect();

        if ($day) {
            $selectedDate = Carbon::create($year, $month, $day)->format('Y-m-d');

            $records = DB::table('inspection')
                ->join('users', 'inspection.recordedid', '=', 'users.id')
                ->join('rooms', 'inspection.roomid', '=', 'rooms.roomid')
                ->whereDate('inspection.date', $selectedDate)
                ->select(
                    'users.name as user_name',
                    'rooms.room_number',
                    'inspection.record',
                    DB::raw('DATE(inspection.date) as date')
                )
                ->get();

            $assignments = DB::table('weekly_assignments')
                ->join('users as u1', 'weekly_assignments.assigned_user_id_1', '=', 'u1.id')
                ->join('users as u2', 'weekly_assignments.assigned_user_id_2', '=', 'u2.id')
                ->whereDate('weekly_assignments.assignment_date', $selectedDate)
                ->select(
                    'u1.name as user1_name',
                    'u1.gender as user1_gender',
                    'u2.name as user2_name',
                    'u2.gender as user2_gender',
                    'weekly_assignments.assigned_level'
                )
                ->get();

            $maleAssignments = $assignments->where('assigned_level', '1');
            $femaleAssignments = $assignments->where('assigned_level', '2');
        }

        return view('calendar', compact(
            'year',
            'month',
            'days',
            'records',
            'selectedDate',
            'assignments',
            'maleAssignments',
            'femaleAssignments'
        ));
    }
}