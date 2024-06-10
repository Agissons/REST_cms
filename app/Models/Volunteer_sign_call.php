<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Volunteer_sign_call extends Model
{
    use HasFactory;
    protected $fillable = [
        "question",
        "call_id",
        "volunteer_id"
    ];
}
