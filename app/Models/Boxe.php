<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Boxe extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'weight',
        'active',
        'sets_id',
        'users_id',
        'types_id'
    ];
}