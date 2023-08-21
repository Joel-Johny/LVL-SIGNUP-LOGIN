<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth;
use App\Http\Controllers\Dashboard;

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
    return view('welcome');
});
Route::get('/new', function () {
    return view('new');
});

Route::match(['get', 'post'], '/login', [Auth::class,"login"])->middleware('Authenticated');
Route::match(['get', 'post'], '/register', [Auth::class,"register"])->middleware('Authenticated');
// Route::get('/dashboard', [Dashboard::class,'index']);
Route::get('/dashboard', [Auth::class,'dashboard'])->middleware('NotAuthenticated');
Route::get('/logout', [Auth::class,'logout'])->middleware('NotAuthenticated');
