<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\Rule;


class UserController extends Controller
{
    //fonction d'affichage de la View Register
    public function register()
    {
        return view('users.register');
    }



    //fonction d'affichage de la View Login
    public  function login()
    {
        return view('users.login');
    }



    //fonction de creation de l'utilisateur
    public function create(Request $request)
    {
        $formFields = $request->validate([
            // verifie si l'utilisateur existe déjà
            'username'=>['required', Rule::unique('users','username')],
            'email'=>'required|email',
            'password'=>'required|confirmed|min:8'
        ]);



        $formFields['password'] = bcrypt($formFields['password']);

        //insert l'utilisateur dans la base de donnée
        $user = new User;
        $user->username = $formFields['username'];
        $user->password = $formFields['password'];
        $user->email = $formFields['email'];
        $user->created_at = date('Y-m-d H:i:s',strtotime('now'));


        $user->save();
        auth()->login($user);
        $request->session()->regenerate();


        return redirect('/');



    }


    //Fonction de connection
    public function log(Request $request)
    {
        $formFields = $request ->validate([
            'username'=>'required',
            'password'=>'required'
        ]);

        $user = User::firstWhere('username', $request->username);
        //regarde si l'utilisateur existe
        if ($user){
            if(auth()->attempt($formFields)){
                $request->session()->regenerate();
                return redirect('/');
            }

        }
        return back()->withErrors(['username'=>'erreur de dans l\'un des champs'])->onlyInput('username');

    }


    //Fonction de deconnexion
    public function logout(Request $request)
    {
        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
