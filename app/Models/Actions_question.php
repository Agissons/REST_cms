<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Actions_question extends Model
{
    use HasFactory;
    protected $fillable = [
        "name",
        'label',
        "id_action",
        "remarque",
        "created_at",
        "updated_at"
    ];
}
