<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Volunteer extends Model
{
    use HasFactory;

    protected $fillable = [
        "first_name",
        "last_name",
        "primary_address1",
        "primary_city",
        "primary_state",
        "primary_zip",
        "primary_country_code",
        "primary_country",
        "organizer_id",
        "volunteer_scale"
    ];
}
