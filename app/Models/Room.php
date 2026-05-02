<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Room extends Model
{
    use HasFactory;

    protected $table = 'rooms';
    protected $primaryKey = 'roomid';
    public $timestamps = false;

    protected $fillable = [
        'floor',
        'room_number',
        'gender',
        'capacity', // érdemes hozzáadni, ha a controller ezt használja
    ];

    // Kapcsolat a felhasználókkal
    public function users()
    {
        return $this->hasMany(User::class, 'roomid', 'roomid');
    }
}