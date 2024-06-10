<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Volunteer_act_campaign extends Model
{
    use HasFactory;
    protected $fillable = [
        "soutien",
        "info",
        "campaign_id",
        "volunteer_id"
    ];
}
