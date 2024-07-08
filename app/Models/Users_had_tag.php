<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Users_had_tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'tag_id',
        'user_id'

    ];
}
