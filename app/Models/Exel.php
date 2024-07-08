<?php

namespace App\Models;

use Illuminate\Database\Query\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exel extends Model
{
    use HasFactory;

    protected $fillable = [
        "id",
        "first_name",
        "last_name",
        "phone_number",
        "db",
        "primary_zip",
        "wa_enter_way",
        "wa_enter_date",
        "wa_exit_date",
        "wa2_enter_date",
        "wa2_exit_date",
        "wa3_enter_date",
        "wa3_exit_date",
        "appel",
        "info",
        "soutien",
        "donations_amount",
        "status",
        "new_donations_amount",
        "rank",
        "organiser",
        "last_contact",
        "interactor",
        "interaction",
        "next_move",
        "note",
        "email",
        "question",
        "priority_level",
        "conv",
        "rappel",
        "wa",
        "engagement",
        "add_wa",
        "updated_at",
        "created_at",
        "availability"

    ];
}
