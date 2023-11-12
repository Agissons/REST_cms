<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Users_does_handling extends Model
{
    use HasFactory;

    protected $fillable = [
        'users_id',
        'handlings_id'
    ];
}
