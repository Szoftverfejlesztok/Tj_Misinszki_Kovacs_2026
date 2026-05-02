<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Inspection;
use Illuminate\Support\Facades\Auth;
use App\Models\Penalty;
use App\Http\Controllers\CalendarController; 
use App\Http\Controllers\InspectionController;



Route::get('/', function () {
    return view('welcome');
});


Route::get('/dashboard', function () {
    return view('dashboard', [
        'talalat_nev' => null,
        'user' => null,
        'inspections' => collect(),
        'hiba' => null,
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');



Route::post('/dashboard', function (Request $request) {
    $nev = $request->input('nev');
    $user = User::where('name', $nev)->first();
   $inspections = collect();

if ($user) {

    $inspectionCount = Inspection::where('recordedid', $user->id)->count();
    $penaltyBlocks = Penalty::where('user_id', $user->id)->count();
    $currentPoints = max(0, $inspectionCount - ($penaltyBlocks * 4));

    $inspections = Inspection::with('recorder')
        ->where('recordedid', $user->id)
        ->orderBy('date', 'desc')
        ->take($currentPoints)
        ->get();
}

    return view('dashboard', [
        'talalat_nev' => $user?->name,
        'hiba' => $user ? null : 'Nincs ilyen nevű felhasználó!',
        'inspections' => $inspections,
        'user' => $user, 
    ]);
})->middleware(['auth', 'verified'])->name('dashboard.search');



Route::post('/inspection/store', [InspectionController::class, 'store'])
    ->middleware(['auth', 'verified'])
    ->name('inspection.store');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



Route::get('/cards', function () {
    $roles = DB::table('user_role')
        ->where('userid', Auth::id())
        ->pluck('roleid')
        ->toArray();

    if (!array_intersect($roles, [1,2,3])) {
        abort(403);
    }

    $users = User::all();
    foreach ($users as $user) {
        $inspections = Inspection::where('recordedid', $user->id)
                                 ->orderBy('date')
                                 ->get();

        $totalCount = $inspections->count();
        $blocks = intdiv($totalCount, 4); 

        $existingBlocks = Penalty::where('user_id', $user->id)
                                 ->count();

        for ($i = 1; $i <= $blocks; $i++) {
            $date = $inspections->slice(($i-1)*4, 4)->last()->date;

            if ($i <= $existingBlocks) {
                $penaltyId = Penalty::where('user_id', $user->id)
                                     ->orderBy('penalty_date')
                                     ->skip($i-1)
                                     ->take(1)
                                     ->value('id');

                Penalty::where('id', $penaltyId)
                       ->update(['penalty_date' => $date]);

            } else {
                Penalty::create([
                    'user_id' => $user->id,
                    'penalty_date' => $date,
                    'group_leader_id' => $user->group_leaderid ?? 1,
                ]);
            }
        }
    }

    $penalties = Penalty::with('user')
    ->where('status', 0)
    ->orderBy('penalty_date', 'desc')
    ->get();

    return view('cards', compact('penalties'));
})->middleware(['auth', 'verified'])->name('cards');



Route::post('/penalty/done/{id}', function ($id) {
    $penalty = Penalty::findOrFail($id);
    $user = Auth::user(); 
    $roles = DB::table('user_role')->where('userid', $user->id)->pluck('roleid')->toArray();

    if (!array_intersect($roles, [1,3])) { 
        return redirect()->back()->with('hiba', 'Nincs jogosultságod teljesíteni a kártyát!');
    }

    $penalty->status = 1;
    $penalty->save();

    return redirect()->back()->with('success', 'Kártya teljesítve!');
})->middleware(['auth','verified']);





Route::get('/calendar', [CalendarController::class, 'index'])
    ->middleware(['auth','verified'])
    ->name('calendar');




Route::prefix('admin')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/', function () {
        $isAdmin = DB::table('user_role')
            ->where('userid', Auth::id())
            ->where('roleid', 1)
            ->exists();
        if (!$isAdmin) {
            abort(403);
        }

        return app(AdminController::class)->dashboard();

    })->name('admin.dashboard');

    Route::get('/users', [AdminController::class, 'usersForm'])->name('admin.users');
    Route::post('/users/search', [AdminController::class, 'searchUser'])->name('admin.users.search');
    Route::post('/users/{user}/roles', [AdminController::class, 'updateRoles'])->name('admin.users.updateRoles');
    Route::post('/users/status-search', [AdminController::class, 'statusSearch'])->name('admin.users.statusSearch');
    Route::patch('/users/{user}/status', [AdminController::class, 'updateStatus'])->name('admin.users.updateStatus');
    Route::post('/users/groupLeaderSearch', [AdminController::class, 'groupLeaderSearch'])->name('admin.users.groupLeaderSearch');
    Route::post('/users/assignLeader/{user}', [AdminController::class, 'assignLeader']) ->name('admin.users.assignLeader');
    Route::post('/weekly-assignments/save', [AdminController::class, 'saveWeeklyAssignments'])->name('admin.assignments.save');
});


require __DIR__.'/auth.php';
