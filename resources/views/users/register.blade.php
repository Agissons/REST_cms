<?php
/**
 * @file register.blade.php
 * @brief file description
 * @author Created by Pablo-Fernando.ZUBIE
 * @version 04.05.2023
 */
$title = "Register";
?>
@extends('layout')

@section('content')
    <div class="container mt-3 col-lg-6 col-md-8 col-sm-12">
        <form method="POST" action="/users">
            @csrf <!-- juste de la securité  https://laravel.com/docs/5.8/csrf -->
            <div class="mb-3 mt-3">
                <label for="username">Nom d'utilisateur:</label>
                <input type="text" class="form-control" name="username" placeholder="Nom d'utilisateur"
                       value="{{old('username')}}">
                @error('username')
                <p>{{$message}}</p>
                @enderror
            </div>
            <div class="mb-3">
                <label for="email">Email:</label>
                <input type="email" class="form-control" name="email" placeholder="email"
                       value="{{old('email')}}">
                @error('email')
                <p>{{$message}}</p>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password">Mot de passe:</label>
                <input type="password" class="form-control" name="password" placeholder="Mot de passe">
                @error('password')
                <p>{{$message}}</p>
                @enderror
            </div>
            <div class="mb-3">
                <label for="password_confirmation">Comfirmer le mot de passe:</label>
                <input type="password" class="form-control" name="password_confirmation" placeholder="confirmation de mdp">
                @error('password_confirmation')
                <p>{{$message}}</p>
                @enderror
            </div >
            <div class="mb-3 row">

                <button type="submit" name="sign" class="btn btn-primary col-5" style="background-color: #a7c957;color:#bc4749;border:#386641">Register</button>
                <div class="col-2"></div>

                <button type="reset" class="btn btn-primary col-5" style="background-color: #a7c957;color:#bc4749;border:#386641">Annuler </button>
            </div>



        </form>


    </div>
@endsection
