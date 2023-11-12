<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Handlings_boxe extends Model
{
    use HasFactory;

    protected $fillable = [
        'boxes_id',
        'handlings_id'
    ];
}
