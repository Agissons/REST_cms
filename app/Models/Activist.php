<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activist extends Model
{
    use HasFactory;

    protected $fillable = [
        "id",
        "first_name",
        "last_name",
        "full_name",
        "email",
        "email_opt_in",
        "email1",
        "email1_is_bad",
        "unsubscribed_at",
        "phone_number",
        "mobile_opt_in",
        "is_mobile_bad",
        "do_not_call",
        "do_not_contact", "primary_address1",
        "primary_city",
        "primary_state",
        "primary_zip",
        "primary_country_code",
        "primary_country",
        "signup_type",
        "note",
        "is_prospect",
        "is_supporter",
        "support_level",
        "inferred_support_level", "priority_level", "created_at", "updated_at", "recruiter_id",
        "is_donor", "is_fundraiser", "is_ignore_donation_limits", "first_donated_at", "last_donated_at",
        "donations_count", "donations_amount", "donations_raised_count", "donations_raised_amount", "donations_pledged_amount",
        "donations_count_this_cycle", "donations_amount_this_cycle", "donations_raised_count_this_cycle", "donations_raised_amount_this_cycle", "is_volunteer", "availability"

    ];
}
