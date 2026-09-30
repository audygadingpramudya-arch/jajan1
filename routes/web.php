<?php

use App\Http\Controllers\FoodController;
use App\Http\Controllers\ProfileController;
use App\Models\Food;
use App\Models\Order;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $foods = Food::query()->latest()->get();

    return view('welcome', compact('foods'));
})->name('home');

Route::post('/checkout', [\App\Http\Controllers\CustomerCheckoutController::class, 'store'])
    ->name('customer.checkout');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        $foods = Food::latest()->paginate(10);
        $orders = Order::with('items.food')->latest()->get();

        return view('dashboard', compact('foods', 'orders'));
    })->name('dashboard');

    Route::resource('foods', FoodController::class);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
