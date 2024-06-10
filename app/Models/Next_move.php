<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Next_move extends Model
{
    use HasFactory;
    protected $fillable = [
        "description",
        "organisez_id",
        "volunteer_id",
        "next_move_type"
    ];
}
