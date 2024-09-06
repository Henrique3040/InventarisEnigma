<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OverzichtController;
use App\Http\Controllers\ProductenController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ExportController;
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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/overzicht', [OverzichtController::class, 'index'] )->middleware(['auth', 'verified'])->name('overzicht');




Route::resource('producten', ProductenController::class)->middleware(['auth', 'verified']);
Route::put('producten/{product}/updateQuantity', [ProductenController::class, 'updateQuantity'])->name('producten.updateQuantity');
Route::post('categories', [CategoryController::class, 'store'])->name('categories.store');


// routes/web.php
Route::get('/auth/google', [ExportController::class, 'authenticate'])->name('google.authenticate');
Route::get('/google/callback', [ExportController::class, 'callback'])->name('google.callback');
Route::get('/export', [ExportController::class, 'export'])->name('export');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
