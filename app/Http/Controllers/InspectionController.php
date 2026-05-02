<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Inspection;
use App\Models\User;

class InspectionController extends Controller
{
   public function store(Request $request)
{
    $user = Auth::user();

    $roles = DB::table('user_role')
        ->where('userid', $user->id)
        ->pluck('roleid')
        ->toArray();

    if (!array_intersect($roles, [1, 2, 4])) {
        return redirect()->back()->with('hiba', 'Nincs jogosultságod beírást rögzíteni!');
    }

    $request->validate([
        'record' => 'required|string',
        'recordedid' => 'required|integer|exists:users,id',
    ]);

    $recordedUserRoles = DB::table('user_role')
        ->where('userid', $request->recordedid)
        ->pluck('roleid')
        ->toArray();

    if (array_intersect($recordedUserRoles, [1, 2, 3])) {
        return redirect()->back()->with('hiba', 'Ennek a felhasználónak nem lehet beírást rögzíteni!');
    }

    $recordedUser = User::find($request->recordedid);

    if (!$recordedUser || is_null($recordedUser->roomid)) {
        return redirect()->back()->with('hiba', 'Ennek a felhasználónak nincs szobája, ezért nem lehet beírást rögzíteni!');
    }

    Inspection::create([
        'record' => $request->record,
        'recordedid' => $request->recordedid,
        'roomid' => $recordedUser->roomid,
        'recorderid' => $user->id,
        'user_presence' => '1',
        'date' => now(),
    ]);

    return redirect()->back()->with('siker', 'Beírás mentve!');
    }
}
