<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\HomeController;


Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/book/detail/{id}', [HomeController::class, 'detail'])->name('book.detail');
Route::post('save-book-review', [HomeController::class, 'saveReview'])->name('book.saveReview');

Route::group(['prefix' => 'account'], function () {
    Route::group(['middleware' => 'guest'], function () {
        Route::get('/register', [AccountController::class, 'register'])->name('account.register');
        Route::post('/register', [AccountController::class, 'processRegister'])->name('account.processRegister');
        Route::get('/login', [AccountController::class, 'login'])->name('account.login');
        Route::post('/login', [AccountController::class, 'loginCheck'])->name('account.loginCheck');
    });
    Route::group(['middleware' => 'auth'], function () {
        Route::get('/profile', [AccountController::class, 'profile'])->name('account.profile');
        Route::post('/update-profile', [AccountController::class, 'updateProfile'])->name('account.updateProfile');
        Route::get('/update-password', [AccountController::class, 'changePassword'])->name('account.changePassword');
        Route::post('/update-password', [AccountController::class, 'passwordUpdate'])->name('account.passwordUpdate');
        Route::get('/logout', [AccountController::class, 'logout'])->name('account.logout');
        Route::get('/books', [BookController::class, 'index'])->name('books.index');
        Route::get('/books/add', [BookController::class, 'create'])->name('books.add');
        Route::post('/books/add', [BookController::class, 'store'])->name('books.store');
        Route::get('/books/edit/{id}', [BookController::class, 'edit'])->name('books.edit');
        Route::post('/books/update/{id}', [BookController::class, 'update'])->name('books.update');
        Route::delete('books', [BookController::class, 'destroy'])->name('books.destroy');
        Route::get('review', [ReviewController::class, 'index'])->name('review.index');
        Route::get('/review/edit/{id}', [ReviewController::class, 'edit'])->name('review.edit');
        Route::post('/review/update/{id}', [ReviewController::class, 'update'])->name('review.update');
        Route::delete('review-delete', [ReviewController::class, 'destroy'])->name('review.destroy');
    });
});

// Route::group(['prefix'=>'account'],function(){
//    // Route::group(['middleware'=>'guest'],function(){
//     //});
//         Route::get('/register',[AccountController::class,'register'])->name('account.register');
//         Route::post('/register',[AccountController::class,'processRegister'])->name('account.processRegister');
//         Route::get('/login',[AccountController::class,'login'])->name('account.login');
//         Route::post('/login',[AccountController::class,'loginCheck'])->name('account.loginCheck');
//         Route::group(['middleware'=>'IsUserLogin'],function(){
//         Route::get('/profile',[AccountController::class,'profile'])->name('account.profile');
//         Route::get('/logout',[AccountController::class,'logout'])->name('account.logout');
//     });   
// });