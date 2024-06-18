<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Volunteer_pledges_donation extends Model
{
    use HasFactory;
    protected $fillable = [
        "donations_amount",
        "interaction_id",
        "realised",
        "volunteer_id"
    ];
}
