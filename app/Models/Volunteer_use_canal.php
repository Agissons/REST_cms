<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Volunteer_use_canal extends Model
{
    use HasFactory;
    protected $fillable = [
        "entry_way",
        "canal_id",
        "volunteer_id"
    ];
}
