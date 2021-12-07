<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DoubtsController;

Route::get('/login', [LoginController::class, 'loginForm'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate']);

Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
Route::get('register/confirmation/{id}', [RegisterController::class, 'registerConfirmation'])->name('register.confirmation');

// $user = new stdClass();
// $user->name = "Rodrigo Tester";
// $user->email = "rodrigoleandro.adm@gmail.com";

// Mail::send(new EmailConfirm($user));
// // return new \App\Mail\EmailConfirm($user);


Route::get('/password/reset', [ForgotPasswordController::class, 'requestForm'])->name('password.request');
// Route::get('/password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

Route::prefix('')->group(function(){
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');
    
    // // retorna os dados do usuário
    Route::get('user', [UserController::class, 'index']);

    // verifica se o usuário já mandou alguma dúvida
    Route::get('user/doubts', [DoubtsController::class, 'getAll']);
    Route::post('user/doubts/add', [DoubtsController::class, 'add']);
    Route::get('user/doubts/mr', [DoubtsController::class, 'markAsRead']);
});

Route::fallback(function(){
    $user = Auth::user();

    if ($user) {
        return view('index');
    } else {
        return redirect('login');
    }
});