<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LostItemController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('lost_items/index', [LostItemController::class, 'index'])->name('lost_items.index');
Route::get('lost_items/create', [LostItemController::class, 'create'])->name('lost_items.create');
Route::post('lost_items/store', [LostItemController::class, 'store'])->name('lost_items.store');
Route::get('lost_items/{lost_item}/edit', [LostItemController::class, 'edit'])->name('lost_items.edit');
Route::patch('lost_items/{lost_item}', [LostItemController::class, 'update'])->name('lost_items.update');
Route::delete('lost_items/{lost_item}', [LostItemController::class, 'destroy'])->name('lost_items.destroy');

require __DIR__.'/auth.php';
