<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Volunteer_answers_question extends Model
{
    use HasFactory;
    protected $fillable = [
        "answers",
        'actions_questions_id',
        "volunteer_id",
        "volunteer_new_id",
        "created_at",
        "updated_at"
    ];
}
