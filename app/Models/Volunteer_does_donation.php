<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Volunteer_does_donation extends Model
{
    use HasFactory;
    protected $fillable = [
        "donations_amount",
        "campaign_id",
        "volunteer_id"
    ];
    
}
