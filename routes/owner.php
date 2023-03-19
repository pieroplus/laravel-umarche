<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Owner\ShopController;
use App\Http\Controllers\Owner\ImageController;
use App\Http\Controllers\Owner\ProductController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('owner.welcome');
// });

Route::get('/dashboard', function () {
    return view('/owner/dashboard');
})->middleware(['auth:owners', 'verified'])->name('dashboard');

Route::prefix('shops')->
    middleware('auth:owners')->group(function(){
        Route::get('index', [ShopController::class, 'index'])->name('shops.index');
        Route::get('edit/{shop}', [ShopController::class, 'edit'])->name('shops.edit');
        Route::post('update/{shop}', [ShopController::class, 'update'])->name('shops.update');
    });

Route::middleware('auth:owners')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('images', ImageController::class)
    ->middleware('auth:owners')
    ->except('show');

Route::resource('products', ProductController::class)
    ->middleware('auth:owners')
    ->except('show');

require __DIR__.'/ownerAuth.php';
