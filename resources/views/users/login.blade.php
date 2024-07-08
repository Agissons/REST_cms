<?php
/**
 * @file login.blade.php
 * @brief file description
 * @author Created by Pablo-Fernando.ZUBIE
 * @version 04.05.2023
 */
$title = 'Login';
?>
@extends('layout')

@section('content')
    <div class="container mt-3 col-lg-6 col-md-8 col-sm-12">
        <form method="POST" action="/log">
            @csrf <!-- juste de la securité  https://laravel.com/docs/5.8/csrf -->
            <div class="mb-3 mt-3">
                <label for="username">Acronyme:</label>
                <input type="text" class="form-control" name="username" placeholder="Acronyme">
                @error('username')
                    <p>{{ $message }}</p>
                @enderror
            </div>


            <div class="mb-3">
                <label for="password">Mot de passe:</label>
                <input type="password" class="form-control" name="password" placeholder="Mot de passe">
                @error('password')
                    <p>{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-3 row">

                <button type="submit" name="log" class="btn btn-primary col-5"
                    style="background-color: #a7c957;color:#bc4749;border:#386641">Login</button>
                <div class="col-2"></div>
                <button type="reset" class="btn btn-primary col-5"
                    style="background-color: #a7c957;color:#bc4749;border:#386641">Annuler </button>
            </div>


        </form>


    </div>
@endsection
