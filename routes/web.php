<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\PackageBankController;
use App\Http\Controllers\PackageBookingController;
use App\Http\Controllers\PackageWeddingController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get("/",[FrontController::class,'index'])->name('front.index');
Route::get("/category/{category:slug}",[FrontController::class,'category'])->name('front.category');
Route::get("/details/{packageWedding:slug}",[FrontController::class,'details'])->name('front.details');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware('can:checkout package')->group(function(){
        
        Route::get('/book/{packageWedding:slug}', [FrontController::class,'book'])
        ->name('front.book');

        Route::post('/book/save/{packageWedding:slug}', [FrontController::class,'book_store'])
        ->name('front.book.store');

        Route::get('/book/choose-bank/{packageBooking}', [FrontController::class,'choose_bank'])
        ->name('front.choose_bank');

        Route::patch('/book/choose-bank/{packageBooking}/save', [FrontController::class,'choose_bank_store'])
        ->name('front.choose_bank_store');

        Route::get('/book/payment/{packageBooking}', [FrontController::class,'book_payment'])
        ->name('front.book_payment');

        Route::patch('/book/payment/{packageBooking}/save', [FrontController::class,'book_payment_store'])
        ->name('front.book_payment_store');

        Route::get('/book-finish', [FrontController::class,'book_finish'])
        ->name('front.book_finish');

    });

    Route::prefix('dashboard')->name('dashboard.')->group(function(){
        Route::get('/my-bookings', [DashboardController::class,'my_bookings'])
        ->name('bookings');
        Route::get('/my-bookings/details/{packageBooking}', [DashboardController::class,'booking_details'])
        ->name('booking.details');
    });

    Route::prefix('admin')->name('admin.')->group(function(){
        Route::middleware('can:manage categories')->group(function(){
            Route::resource('categories', CategoryController::class);

        });
        Route::middleware('can:manage packages')->group(function(){
            Route::resource('package_weddings', PackageWeddingController::class);

        });
        Route::middleware('can:manage package banks')->group(function(){
            Route::resource('package_banks', PackageBankController::class);

        });
        Route::middleware('can:manage transaction')->group(function(){
            Route::resource('package_bookings', PackageBookingController::class);

        });
    });
});

require __DIR__.'/auth.php';
