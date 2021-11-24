<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

use App\Models\User;

class LoginController extends Controller
{
    public function __construct(){
        $this->middleware('guest')->except('logout');
    }

    public function authenticate(Request $request){
        $data = $request->only([
            'email',
            'password',
        ]);

        $remember = $request->input('remember', false);

        $validator = $this->validator($data);

        if ($validator->fails()){
            return redirect()->route('login')
                ->withErrors($validator)
                ->withInput();
        }

        $confirmed = User::where('email', $data['email'])->get();

        if ($confirmed[0]['email_verified_at'] == null){
            $validator->errors()->add('not-validated', 'Email não confirmado, confirme seu email para ativar a conta. Um email foi enviado à '.$confirmed[0]['email']);
            
            return redirect()->route('login')
                ->withErrors($validator)
                ->withInput();
        }

        // fazer login
        if (Auth::attempt($data, $remember)){
            return redirect()->route('home');
        } else {
            $validator->errors()->add('password', 'E-mail e/ou senha inválidos.');
            
            return redirect()->route('login')
                ->withErrors($validator)
                ->withInput();
        }
    }

    public function loginForm(){
        return view('auth.login');
    }

    public function logout(){
        Auth::logout();

        return redirect()->route('login');
    }

    protected function validator(array $data){
        return Validator::make($data, [
            'email' => ['required', 'string', 'email', 'max:100'],
            'password' => ['required', 'string', 'min:4'],
        ]);
    }
}
