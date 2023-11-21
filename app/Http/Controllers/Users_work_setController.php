<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;

use App\Models\Users_work_set;
use Illuminate\Http\Request;

class Users_work_setController extends Controller
{
    //
    public function usersadd(Request $request)
    {
        $formFields = $request->validate([
            // verifie si l'utilisateur existe déjà
            'name' => 'required',
            'id' => 'required'

        ]);

        $user = User::firstWhere('username', $formFields['name']);
        //regarde si l'utilisateur existe
        if ($user){
            Users_work_set::firstOrCreate(['sets_id'=> $formFields['id'], 'users_id'=>$user->id]);

            return back();

        }
        return back()->withErrors(['name'=>'L\'utilisateur n\'existe pas '])->onlyInput('name');



    }
}
