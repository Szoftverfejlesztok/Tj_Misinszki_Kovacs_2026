<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penalty extends Model
{
    // Mely mezők engedélyezettek tömeges feltöltésre
    protected $fillable = ['user_id', 'penalty_date', 'group_leader_id'];

    // Ha nincs created_at / updated_at meződ az adatbázisban
    public $timestamps = false;

    // Kapcsolat a felhasználóhoz
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}