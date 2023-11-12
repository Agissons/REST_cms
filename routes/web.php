<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SetController;
use App\Http\Middleware\Authenticate;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('home');
});
Route::get('/login', [UserController::class, 'login'])->name('login');

Route::get('/register', [UserController::class, 'register']);

Route::post('/users', [UserController::class, 'create']);

route::post('/logout', [UserController::class,'logout'])->middleware(Authenticate::class);

route::post('/log',[UserController::class,'log']);

route::get('/gestion',[SetController::class,'display']);

route::get('/setcreate',[SetController::class,'create'])->middleware(Authenticate::class);

route::get('/set/{id}',[SetController::class,'full'])->middleware(Authenticate::class);



