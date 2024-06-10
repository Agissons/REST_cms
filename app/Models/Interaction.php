<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Interaction extends Model
{
    use HasFactory;
    protected $fillable = [
        "interaction",
        "context_id",
        "interaction_type",
        "interactor_id",
        "volunteer_id"
    ];
}
