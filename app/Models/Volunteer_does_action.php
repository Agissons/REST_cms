<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Volunteer_does_action extends Model
{
    use HasFactory;
    protected $fillable = [
        'actions_id',
        "volunteer_id",
        "volunteer_new_id",
        "created_at",
        "updated_at"
    ];
}
