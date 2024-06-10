<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Volunteer_use_group extends Model
{
    use HasFactory;
    protected $fillable = [
        "left",
        "groups_id",
        "volunteer_id"
    ];
}
