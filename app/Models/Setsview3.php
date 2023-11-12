<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Facades\DB;

class Setsview3 extends Model
{
    use HasFactory;

    protected $table = "setsview3";

    public static function select($id)
    {
        $sets=DB::table('setsview3')->select('setsview3.id', 'setsview3.name', 'setsview3.weight', 'setsview3.boxes', 'setsview3.users', 'setsview3.production')
            ->join('users_work_sets', function (JoinClause $join) use ($id) {
                $join->on('setsview3.id', '=', 'users_work_sets.sets_id')
                    ->where('users_work_sets.users_id', '=', $id);
            })->get();
        return $sets;
    }


}
