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
        "npa",
        "primary_country",
        "organizer",
        "volunteer_scale",
        "fullname",
        "exel_id", 
        "new_id"
    ];
}
