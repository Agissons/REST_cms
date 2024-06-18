<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExelController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VolunteerController;
use App\Http\Controllers\SetController;
use App\Http\Middleware\Authenticate;
use App\Http\Controllers\InteractionController;

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
Route::get('/combine', [ExelController::class, 'combine'])->name('combine');
Route::get('/extract', [ExelController::class, 'extract'])->name('extract');
Route::get('/display', [VolunteerController::class, 'display'])->name('display');

Route::get('/login', [UserController::class, 'login'])->name('login');
Route::get('/create', [VolunteerController::class, 'create'])->name('create');
route::get('/volunteer/{id}',[VolunteerController::class,'full'])->middleware(Authenticate::class);

Route::get('/register', [UserController::class, 'register']);

Route::post('/users', [UserController::class, 'create']);

route::post('/logout', [UserController::class,'logout'])->middleware(Authenticate::class);

route::post('/log',[UserController::class,'log']);

route::get('/gestion',[SetController::class,'display']);

route::post('/setcreate',[SetController::class,'create'])->middleware(Authenticate::class);

route::get('/set/{id}',[SetController::class,'full'])->middleware(Authenticate::class);

route::post('/guanoadd',[SetController::class,'guanoadd'])->middleware(Authenticate::class);

route::post('/newinteractions',[InteractionController::class,'create'])->middleware(Authenticate::class);

