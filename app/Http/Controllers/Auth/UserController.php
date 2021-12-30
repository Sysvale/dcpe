<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Http\Controllers\Controller;
use App\Models\Doubt;
use App\Models\FollowUp;
use App\Models\User;

class UserController extends Controller
{
    private $userCover;

    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        $user = Auth::user();
        $user->name = ucwords($user->name);
        
        $this->userCover = $user->cover;
        $user->cover = asset(Storage::url($user->cover));
        return $user;
    }

    public function isUniqueEmail(Request $request){
        $email = $request->only(['isUnique']);
        $exists = User::where('email', $email['isUnique'])->get();
        
        return count($exists)?false:true;
    }

    public function updateProfile(Request $request){
        $file = $request->file('file');
        $data = $request->only(['data']);
        $user = $this->index();
        
        if ($file){
            $cover = $request->file('file')->store('public/covers');
            Storage::delete($this->userCover);
            User::where('_id', $user->id)->update(['cover' => $cover]);
        } 

        if (count($data) > 0){
            for ($key = 0; $key < count($data); $key++){
                $type = $data['data'][$key]['type'];
                $value = $data['data'][$key][$type];
                
                User::where('_id', $user->_id)->update([$type => $value]);
            }
        }
    }

    public function updatePassword(Request $request){
        $user = Auth::user();
        $data = $request->only(['actualPassword', 'newPassword']);

        // verificar se a senha bate com a do usuário
        if (Hash::check($data['actualPassword'], $user->password)){
            User::where('_id', $user->_id)->update(['password' => Hash::make($data['newPassword'])]);
            return true;
        } else return false;
    }

    public function getRole(){
        $user = Auth::user();
        return $user->roles;
    }

    public function getById($id){
        $user = User::where('_id', $id)->get();
        return ucwords($user[0]->name);
    }

    public function updateRole(Request $request){
        $user = Auth::user();
        $id_user = $request->only('idUser');
        $value = $request->only('value');

        if ($user->roles == 'sudo'){
            User::where('_id', $id_user['idUser'])
                ->update([
                    'roles' => $value['value'],
                ]);
        }
    }

    public function getAll(){
        $user = Auth::user();
        $all_users = [];
        $data = [];

        if ($user->roles == 'sudo'){
            $all_users = User::all()->except(Auth::id());

            foreach($all_users as $key => $value){
                $data[$key]['id'] = $all_users[$key]->_id;
                $data[$key]['name'] = $all_users[$key]->name;
                $data[$key]['email'] = $all_users[$key]->email;
                $data[$key]['email_verified_at'] = $this->getFormatedData($all_users[$key]->email_verified_at);
                $data[$key]['roles'] = $all_users[$key]->roles;
            }
        }
        
        return $data;
    }
    
    protected function getFormatedData($date){
        $onlyDate = Carbon::parse($date)->format('d/m/Y');
        $onlyTime = Carbon::parse($date)->format('H:i');
        return $onlyDate." às ".$onlyTime;
    }

    protected function deleteUser(Request $request){
        $user = Auth::user();
        $id_user = $request->only('idUser');

        if ($user->roles == 'sudo'){
            User::where('_id', $id_user['idUser'])
                ->delete();   
            Doubt::where('id_user', $id_user['idUser'])
            ->delete();  
            FollowUp::where('id_user', $id_user['idUser'])
            ->delete(); 
        }
    }
}
