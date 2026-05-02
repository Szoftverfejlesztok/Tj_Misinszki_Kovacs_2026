<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WeeklyAssignmentController extends Controller
{
    public function store(Request $request)
    {
        // Felhasználó ID-k a requestből
        $user1_id = $request->input('user1_id');
        $user2_id = $request->input('user2_id');
        $assigned_level = $request->input('assigned_level');
        $assignment_date = $request->input('assignment_date');

        // Felhasználók lekérése
        $user1 = DB::table('users')->where('id', $user1_id)->first();
        $user2 = DB::table('users')->where('id', $user2_id)->first();

        // Csak 4-es rangú felhasználók lehetnek
        if ($user1->rank != 4 || $user2->rank != 4) {
            return back()->with('error', 'Csak Szobanéző rangú felhasználók kerülhetnek beosztásra!');
        }

        // Gender ellenőrzés
        if (in_array($assigned_level, [0,1])) { // 0-1 = férfi
            if ($user1->gender != 'Férfi' || $user2->gender != 'Férfi') {
                return back()->with('error', 'Csak férfi mehet 0-1 szintre!');
            }
        } elseif ($assigned_level == 2) { // 2 = nő
            if ($user1->gender != 'Nő' || $user2->gender != 'Nő') {
                return back()->with('error', 'Csak nő mehet 2. szintre!');
            }
        }

        // Beosztás mentése
        DB::table('weekly_assignments')->insert([
            'assigned_user_id_1' => $user1_id,
            'assigned_user_id_2' => $user2_id,
            'assigned_level' => $assigned_level,
            'assignment_date' => $assignment_date,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return back()->with('success', 'Beosztás sikeresen mentve!');
    }
}