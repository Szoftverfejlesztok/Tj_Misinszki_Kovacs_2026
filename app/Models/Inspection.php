<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inspection extends Model
{
    protected $table = 'inspection';
    public $timestamps = false;

    protected $fillable = [
        'record',
        'recordedid',
        'roomid',
        'recorderid',
        'user_presence',
        'date'
    ];

    // Eager loading a recorderhez (felhasználó, aki írta)
    public function recorder()
    {
        return $this->belongsTo(\App\Models\User::class, 'recorderid');
    }
}
