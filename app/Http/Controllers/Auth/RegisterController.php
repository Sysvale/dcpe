<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

use App\Mail\EmailConfirm;
use App\Constants\UserRoles;

use App\Models\User;

class RegisterController extends Controller
{
    public function __construct()
    {
       $this->middleware('guest');
    }

    public function index(){
        return view('auth.register');
    }

    public function register(Request $request){
        $data = $request->only([
            'name',
            'email',
            'password',
            'password_confirmation',
        ]);
 
        $validator = $this->validator($data);
     
        if ($validator->fails()){
            return redirect()->route('register')
             ->withErrors($validator)
             ->withInput();
        }
 
        $user = $this->create($data);
        $this->sendMailConfirmation($user);

        // Auth::login($user);
 
        return redirect()->route('home');
 
    }
 
    protected function validator(array $data)
    {
         return Validator::make($data, [
             'email' => ['required', 'string', 'max:255', 'unique:users'],
             'name' => ['required', 'string', 'max:255'],
             'password' => ['required', 'string', 'min:4', 'confirmed']
         ]);
    }
 
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'email_verified_at' => null,
            'password' => Hash::make($data['password']),
            'roles' => UserRoles::PATIENT,
            'cover' => asset(Storage::url('images/default-user.png')),
        ]);
    }

    public function sendMailConfirmation($user){
        return Mail::send(new EmailConfirm($user));
    }
}
