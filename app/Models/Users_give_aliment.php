<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Users_give_aliment extends Model
{
    use HasFactory;

    protected $fillable = [
        'weight',
        'users_id',
        'aliments_id'
    ];
}
