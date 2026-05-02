<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    // Dashboard nézet
   public function dashboard()
{
    return view('admin.admin', $this->getAdminViewData());
}

private function getAdminViewData(array $extra = []): array
{
    $users = DB::table('users')
        ->where('account_status', 1)
        ->get();

    $assignments = DB::table('weekly_assignments')
        ->join('users as u1', 'weekly_assignments.assigned_user_id_1', '=', 'u1.id')
        ->join('users as u2', 'weekly_assignments.assigned_user_id_2', '=', 'u2.id')
        ->select(
            'weekly_assignments.id',
            'weekly_assignments.assignment_date',
            'weekly_assignments.assigned_level',
            'u1.name as user1_name',
            'u2.name as user2_name'
        )
        ->orderBy('weekly_assignments.assignment_date', 'asc')
        ->get();

    $maleInspectors = $this->getEligibleInspectorsByGender('Férfi');
    $femaleInspectors = $this->getEligibleInspectorsByGender('Nő');

    return array_merge([
        'users' => $users,
        'assignments' => $assignments,
        'maleInspectors' => $maleInspectors,
        'femaleInspectors' => $femaleInspectors,
    ], $extra);
}

    // Felhasználók kereső form megjelenítése
   public function usersForm()
{
    return view('admin.admin', $this->getAdminViewData());
}
    // Felhasználó keresése név és email alapján
    public function searchUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email'
        ]);

        $user = User::where('name', $request->name)
                    ->where('email', $request->email)
                    ->first();

       if (!$user) {
            return redirect()->route('admin.users')->with('hiba', 'Nincs ilyen felhasználó!');
        }


        // role-ok lekérése a user_role táblából
        $roles = DB::table('user_role')->where('userid', $user->id)->pluck('roleid')->toArray();

        // Visszaadjuk ugyanazt a view-t, nincs külön users.blade.php
        return view('admin.admin', $this->getAdminViewData([
            'user' => $user,
            'roles' => $roles,
        ]));
    }

    // Role-ok frissítése
    public function updateRoles(Request $request, User $user)
{
   $newRoles = $request->input('roles', []);

// NE lehessen olyan, hogy egy felhasználónak nincs role-ja
if (empty($newRoles)) {
    return redirect()->route('admin.users')
        ->with('error', 'A felhasználónak legalább egy ranggal rendelkeznie kell!');
}

    // jelenlegi role-ok
    $currentRoles = DB::table('user_role')
        ->where('userid', $user->id)
        ->pluck('roleid')
        ->toArray();

    // hozzáadandó role-ok
    $rolesToAdd = array_diff($newRoles, $currentRoles);

    // törlendő role-ok
    $rolesToRemove = array_diff($currentRoles, $newRoles);

    // új role-ok beszúrása
    foreach ($rolesToAdd as $roleId) {
        DB::table('user_role')->insert([
            'userid' => $user->id,
            'roleid' => $roleId
        ]);
    }

    // role-ok törlése
    if (!empty($rolesToRemove)) {
        DB::table('user_role')
            ->where('userid', $user->id)
            ->whereIn('roleid', $rolesToRemove)
            ->delete();
    }

    $hadLeaderRoleBefore = in_array(2, $currentRoles); // 2 = csoportvezető role id
    $hasLeaderRoleNow = in_array(2, $newRoles);

    if ($hadLeaderRoleBefore && !$hasLeaderRoleNow) {
        // Mindenki, akinek ez a user volt a csoportvezetője, elveszíti a vezetőjét
        DB::table('users')
            ->where('group_leaderid', $user->id)
            ->update(['group_leaderid' => null]);
    }


    return redirect()->route('admin.users')
        ->with('success', 'Role-ok frissítve!');
    }


    // Felhasználó státusz keresése név + email alapján
public function statusSearch(Request $request)
{
    $request->validate([
        'name' => 'required|string',
        'email' => 'required|email'
    ]);

    $statusUser = User::where('name', $request->name)
                      ->where('email', $request->email)
                      ->first();

    if (!$statusUser) {
        return redirect()->route('admin.users')->with('hiba_status', 'Nincs ilyen felhasználó!');
    }

    // Visszaadjuk ugyanazt a view-t, csak a statusUser változóval
   return view('admin.admin', $this->getAdminViewData([
    'statusUser' => $statusUser,
]));
}

// Fiók státusz frissítése
public function updateStatus(Request $request, User $user)
{
    $request->validate([
        'account_status' => 'required|in:0,1'
    ]);

    $user->account_status = $request->account_status;
    $user->save();

    return redirect()->route('admin.users')->with('success_status', 'Fiók státusz frissítve!');
}


// USER keresése csoportvezető kezeléshez
public function groupLeaderSearch(Request $request)
{
    $request->validate([
        'name' => 'required|string',
        'email' => 'required|email'
    ]);

    $leaderUser = User::where('name', $request->name)
        ->where('email', $request->email)
        ->first();

    if (!$leaderUser) {
        return redirect()->route('admin.users')
            ->with('hiba_leader', 'Nincs ilyen felhasználó!');
    }

    // user role lekérdezése
    $roles = DB::table('user_role')
        ->where('userid', $leaderUser->id)
        ->pluck('roleid')
        ->toArray();

    // ha csoportvezető akkor nem kaphat csoportvezetőt
    if (in_array(2, $roles)) {
        return redirect()->route('admin.users')
            ->with('hiba_leader', 'Csoportvezetőnek nem adható csoportvezető.');
    }

    // ellenőrizni hogy diák vagy szobanéző
    if (!in_array(4, $roles) && !in_array(5, $roles)) {
        return redirect()->route('admin.users')
            ->with('hiba_leader', 'A felhasználó nem diák vagy szobanéző.');
    }

    $currentLeader = null;

    if ($leaderUser->group_leaderid) {
        $currentLeader = User::find($leaderUser->group_leaderid);
    }

    return view('admin.admin', $this->getAdminViewData([
    'leaderUser' => $leaderUser,
    'currentLeader' => $currentLeader,
]));
}

public function assignLeader(Request $request, User $user)
{
    $request->validate([
        'leader_name' => 'required|string',
        'leader_email' => 'required|email'
    ]);

    // leader keresése
    $leader = User::where('name', $request->leader_name)
        ->where('email', $request->leader_email)
        ->first();

    if (!$leader) {
        return redirect()->route('admin.users')
            ->with('hiba_leader', 'A megadott csoportvezető nem található.');
    }

    // role ellenőrzés (csoportvezető)
    $leaderRoles = DB::table('user_role')
        ->where('userid', $leader->id)
        ->pluck('roleid')
        ->toArray();

    if (!in_array(2, $leaderRoles)) {
        return redirect()->route('admin.users')
            ->with('hiba_leader', 'Nem adható hozzá, mert a felhasználó nem csoportvezető.');
    }

    // aktív-e a leader
    if ($leader->account_status == 0) {
        return redirect()->route('admin.users')
            ->with('hiba_leader', 'A csoportvezető fiókja inaktív.');
    }

    // saját magát nem adhatja meg
    if ($leader->id == $user->id) {
        return redirect()->route('admin.users')
            ->with('hiba_leader', 'A felhasználó nem lehet saját csoportvezetője.');
    }

    // ha már van leader
    if ($user->group_leaderid) {

        // ha nincs bepipálva a csere
        if (!$request->has('replace_leader')) {
            return redirect()->route('admin.users')
                ->with('hiba_leader', 'A felhasználónak már van csoportvezetője.');
        }

        // ha ugyanaz a leader
        if ($user->group_leaderid == $leader->id) {
            return redirect()->route('admin.users')
                ->with('hiba_leader', 'Ez már a jelenlegi csoportvezető.');
        }
    }

    // leader beállítása
    $user->group_leaderid = $leader->id;
    $user->save();

    return redirect()->route('admin.users')
        ->with('success_leader', 'Csoportvezető sikeresen beállítva.');
}

public function saveWeeklyAssignments(Request $request)
{
    if (!$this->isAdmin()) {
        return back()->with('hiba_assignments', 'A művelethez adminisztrátori jogosultság szükséges.');
    }

    $maleInspectors = $this->getEligibleInspectorsByGender('Férfi');
    $femaleInspectors = $this->getEligibleInspectorsByGender('Nő');

    if ($maleInspectors->count() < 2) {
        return back()
            ->withInput()
            ->with('hiba_assignments', 'Nincs legalább 2 választható férfi szobanéző.');
    }

    if ($femaleInspectors->count() < 2) {
        return back()
            ->withInput()
            ->with('hiba_assignments', 'Nincs legalább 2 választható női szobanéző.');
    }

    $validated = $request->validate([
        'selected_day'  => 'required|in:vasarnap,hetfo,kedd,szerda,csutortok,pentek,szombat',
        'male_user_1'   => 'required|integer|exists:users,id',
        'male_user_2'   => 'required|integer|exists:users,id|different:male_user_1',
        'female_user_1' => 'required|integer|exists:users,id',
        'female_user_2' => 'required|integer|exists:users,id|different:female_user_1',
    ], [
        'selected_day.required' => 'Kötelező napot választani.',
        'selected_day.in' => 'Érvénytelen nap lett kiválasztva.',
        'male_user_1.required' => 'Az első férfi kiválasztása kötelező.',
        'male_user_2.required' => 'A második férfi kiválasztása kötelező.',
        'male_user_2.different' => 'A két férfi felhasználó nem lehet ugyanaz.',
        'female_user_1.required' => 'Az első nő kiválasztása kötelező.',
        'female_user_2.required' => 'A második nő kiválasztása kötelező.',
        'female_user_2.different' => 'A két női felhasználó nem lehet ugyanaz.',
    ]);

    $userIds = [
        (int) $validated['male_user_1'],
        (int) $validated['male_user_2'],
        (int) $validated['female_user_1'],
        (int) $validated['female_user_2'],
    ];

    if (count($userIds) !== count(array_unique($userIds))) {
        return back()
            ->withInput()
            ->with('hiba_assignments', 'Ugyanaz a felhasználó nem választható ki többször.');
    }

    $male1 = $this->getEligibleInspector((int) $validated['male_user_1'], 'Férfi');
    $male2 = $this->getEligibleInspector((int) $validated['male_user_2'], 'Férfi');
    $female1 = $this->getEligibleInspector((int) $validated['female_user_1'], 'Nő');
    $female2 = $this->getEligibleInspector((int) $validated['female_user_2'], 'Nő');

    if (!$male1 || !$male2) {
        return back()
            ->withInput()
            ->with('hiba_assignments', 'A férfi mezőkben lévő felhasználó időközben érvénytelenné vált vagy nem jogosult.');
    }

    if (!$female1 || !$female2) {
        return back()
            ->withInput()
            ->with('hiba_assignments', 'A női mezőkben lévő felhasználó időközben érvénytelenné vált vagy nem jogosult.');
    }

    $assignmentDate = $this->resolveNearestDateFromDay($validated['selected_day']);

    try {
        DB::beginTransaction();

        $assignments = DB::table('weekly_assignments')
            ->where('assignment_date', $assignmentDate)
            ->lockForUpdate()
            ->get();

        if ($assignments->contains(fn ($row) => !in_array((string) $row->assigned_level, ['1', '2'], true))) {
            DB::rollBack();

            return back()
                ->withInput()
                ->with('hiba_assignments', 'Hibás beosztás található ehhez a naphoz tartozó adatok között.');
        }

        if ($assignments->contains(fn ($row) => (int) $row->assigned_user_id_1 === (int) $row->assigned_user_id_2)) {
            DB::rollBack();

            return back()
                ->withInput()
                ->with('hiba_assignments', 'Hibás beosztás található: ugyanaz a felhasználó kétszer szerepel egy rekordban.');
        }

        $maleAssignments = $assignments->where('assigned_level', '1')->values();
        $femaleAssignments = $assignments->where('assigned_level', '2')->values();

        if ($maleAssignments->count() > 1 || $femaleAssignments->count() > 1) {
            DB::rollBack();

            return back()
                ->withInput()
                ->with('hiba_assignments', 'Duplikált beosztás található ugyanarra a napra.');
        }

        if ($maleAssignments->isNotEmpty()) {
            DB::table('weekly_assignments')
                ->where('id', $maleAssignments->first()->id)
                ->update([
                    'assigned_user_id_1' => $male1->id,
                    'assigned_user_id_2' => $male2->id,
                ]);
        } else {
            DB::table('weekly_assignments')->insert([
                'assigned_user_id_1' => $male1->id,
                'assigned_user_id_2' => $male2->id,
                'assignment_date' => $assignmentDate,
                'assigned_level' => '1',
            ]);
        }

        if ($femaleAssignments->isNotEmpty()) {
            DB::table('weekly_assignments')
                ->where('id', $femaleAssignments->first()->id)
                ->update([
                    'assigned_user_id_1' => $female1->id,
                    'assigned_user_id_2' => $female2->id,
                ]);
        } else {
            DB::table('weekly_assignments')->insert([
                'assigned_user_id_1' => $female1->id,
                'assigned_user_id_2' => $female2->id,
                'assignment_date' => $assignmentDate,
                'assigned_level' => '2',
            ]);
        }

        DB::commit();

        return back()->with(
            'success_assignments',
            'A beosztás sikeresen elmentve ehhez a naphoz: ' . $assignmentDate
        );
    } catch (\Throwable $e) {
        DB::rollBack();

        Log::error('Heti beosztás mentési hiba', [
            'message' => $e->getMessage(),
            'selected_day' => $validated['selected_day'] ?? null,
            'assignment_date' => $assignmentDate ?? null,
            'user_ids' => $userIds ?? [],
        ]);

        return back()
            ->withInput()
            ->with('hiba_assignments', 'A mentés közben hiba történt.');
    }
}
private function isAdmin(): bool
{
    $user = Auth::user();

    if (!$user) {
        return false;
    }

    return DB::table('user_role')
        ->where('userid', $user->id)
        ->where('roleid', 1)
        ->exists();
}

private function getEligibleInspectorsByGender(string $gender)
{
    return DB::table('users')
        ->where('users.gender', $gender)
        ->where('users.account_status', 1)
        ->whereExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('user_role')
                ->whereColumn('user_role.userid', 'users.id')
                ->where('user_role.roleid', 4);
        })
        ->whereNotExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('user_role')
                ->whereColumn('user_role.userid', 'users.id')
                ->whereNotIn('user_role.roleid', [4, 5]);
        })
        ->select('users.id', 'users.name')
        ->orderBy('users.name')
        ->get();
}

private function getEligibleInspector(int $userId, string $gender)
{
    return DB::table('users')
        ->where('users.id', $userId)
        ->where('users.gender', $gender)
        ->where('users.account_status', 1)
        ->whereExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('user_role')
                ->whereColumn('user_role.userid', 'users.id')
                ->where('user_role.roleid', 4);
        })
        ->whereNotExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('user_role')
                ->whereColumn('user_role.userid', 'users.id')
                ->whereNotIn('user_role.roleid', [4, 5]);
        })
        ->select('users.id', 'users.name')
        ->first();
}
private function resolveNearestDateFromDay(string $selectedDay): string
{
    $today = Carbon::today();

    $dayMap = [
        'vasarnap' => Carbon::SUNDAY,
        'hetfo' => Carbon::MONDAY,
        'kedd' => Carbon::TUESDAY,
        'szerda' => Carbon::WEDNESDAY,
        'csutortok' => Carbon::THURSDAY,
        'pentek' => Carbon::FRIDAY,
        'szombat' => Carbon::SATURDAY,
    ];

    $targetDay = $dayMap[$selectedDay];
    $currentDay = $today->dayOfWeek;
    $daysUntilTarget = ($targetDay - $currentDay + 7) % 7;

    if ($daysUntilTarget === 0) {
        $daysUntilTarget = 7;
    }

    return $today->copy()->addDays($daysUntilTarget)->toDateString();
}
}
