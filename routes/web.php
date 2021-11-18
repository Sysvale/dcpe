<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController;

Route::get('/login', [LoginController::class, 'loginForm'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate']);

Route::get('/register', [RegisterController::class, 'index'])->name('register');
// Route::post('/register', [RegisterController::class, 'register']);

Route::get('/password/reset', [ForgotPasswordController::class, 'requestForm'])->name('password.request');
// Route::get('/password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

// Route::prefix('/panel')->group(function(){
//     Route::get('/', [HomeController::class, 'index'])->name('home');
//     Route::post('logout', [LoginController::class, 'logout'])->name('logout');
    
//     // retorna os dados do usuário
//     Route::get('user/', [UserController::class, 'index']);
// });

// Route::get('{any}', function () {
//     $user = Auth::user();

//     if ($user) {
//         return view('index', ['user' => $user]);
//     } else {
//         return redirect('login');
//     }
// })->where('any', '(.*)');


// Route::fallback(function(){
//     return redirect('login');
// });