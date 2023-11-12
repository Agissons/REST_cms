<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Users_work_set extends Model
{
    use HasFactory;

    protected $fillable = [
        'users_id',
        'sets_id'
    ];
}
