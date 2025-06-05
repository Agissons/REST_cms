<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Action_got_answer extends Model
{
    use HasFactory;
    protected $fillable = [
        'actions_questions_id',
        "actions_id",
        "created_at",
        "updated_at"
    ];
}
