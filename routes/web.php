<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DoubtsController;
use App\Http\Controllers\FollowUpController;
use App\Http\Controllers\ProfessionalController;
use App\Http\Controllers\ProntuaryController;

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
    Route::get('user/get/{id}', [UserController::class, 'getById']);
    Route::get('user/get-all', [UserController::class, 'getAll']);
    Route::get('user/role', [UserController::class, 'getRole']);
    Route::post('user/update/role', [UserController::class, 'updateRole']);
    Route::post('user/delete', [UserController::class, 'deleteUser']);

    Route::get('professional/get/patients', [ProfessionalController::class, 'getPatients']);
    Route::post('professional/doubts/answer', [ProfessionalController::class, 'answerDoubt']);
    Route::get('professional/follow-up/requests', [ProfessionalController::class, 'followUpRequests']);
    Route::get('prontuary/{id}/view/{step}', [ProfessionalController::class, 'getPatientProntuary']);

    // verifica se o usuário já mandou alguma dúvida
    Route::get('user/doubts', [DoubtsController::class, 'getAll']);
    Route::get('user/doubts/unread', [DoubtsController::class, 'getDoubtsUnread']);
    Route::post('user/doubts/add', [DoubtsController::class, 'addDoubt']);
    Route::post('user/answer/add', [DoubtsController::class, 'addAnswer']);
    Route::post('user/doubts/mr', [DoubtsController::class, 'markAsRead']);

    Route::get('user/requested/follow-up', [FollowUpController::class, 'hasFollowUp']);
    Route::post('user/request/follow-up', [FollowUpController::class, 'requestFollowUp']);
    Route::post('user/cancel-request/follow-up', [FollowUpController::class, 'cancelRequestFollowUp']);
    Route::get('user/stats/follow-up', [FollowUpController::class, 'statsFollowUp']);
    Route::get('user/follow-up/get/messages', [FollowUpController::class, 'getMessages']);
    Route::get('professional/follow-up/get/messages', [FollowUpController::class, 'getMessagesProfessional']);
    Route::post('user/follow-up/add', [FollowUpController::class, 'addMessage']);
    Route::post('user/follow-up/accept', [FollowUpController::class, 'acceptRequest']);

    Route::post('user/unique-mail', [UserController::class, 'isUniqueEmail']);
    Route::post('user/update/profile', [UserController::class, 'updateProfile']);
    Route::post('user/update/password', [UserController::class, 'updatePassword']);

    Route::post('prontuary/add', [ProntuaryController::class, 'add']);
    Route::get('prontuary/get/{step}', [ProntuaryController::class, 'get']);
    Route::post('prontuary/finish', [ProntuaryController::class, 'finishProntuary']);
    Route::post('prontuary/edit', [ProntuaryController::class, 'update']);
});

Route::fallback(function(){
    $user = Auth::user();

    if ($user) {
        return view('index');
    } else {
        return redirect('login');
    }
});