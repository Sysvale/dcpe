<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Doubt;
use App\Constants\States;
use App\Models\User;

use Carbon\Carbon;

class DoubtsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getAll(){
        $user = Auth::user();

        // pegar todas duvidas do usuário logado
        $doubts = Doubt::where('id_user', $user->id)->get();
        $doubtsFormated = [];

        foreach ($doubts as $key => $value){
            $doubtsFormated[$key]['_id'] = $doubts[$key]->_id;
            $doubtsFormated[$key]['id_user'] = $doubts[$key]->id_user;
            $doubtsFormated[$key]['message'] = $doubts[$key]->message;
            $doubtsFormated[$key]['status'] = $doubts[$key]->status;
            $doubtsFormated[$key]['answered'] = $doubts[$key]->answered;
            $doubtsFormated[$key]['read'] = $doubts[$key]->read;
            if ($doubts[$key]->answered_by != null){
                $professional = User::where('_id', $doubts[$key]->answered_by)->get();
                
                $doubtsFormated[$key]['answered_by'] = $professional[0]['name'];
            }
            $doubtsFormated[$key]['created_at'] = $this->getFormatedData($doubts[$key]->created_at);
            $doubtsFormated[$key]['updated_at'] = $this->getFormatedData($doubts[$key]->updated_at);    
        }
        
        return $doubtsFormated;

    }

    public function add(Request $request){
        $sent = $request->only(['message']);

        if ($sent && $sent['message'] != '') $this->store($sent);
    }

    public function markAsRead(Request $request){
        $id = $request->only(['id']);
        echo $id['id'];
        $message = Doubt::where('_id', $id)->get();

        if ($message){
            echo $message;
            $message->read = true;
        }
    }

    protected function store(array $sent)
    {
        $user = Auth::user();

        return Doubt::create([
            'id_user' => $user['id'],
            'message' => $sent['message'],
            'status' => States::WAITING,
            'answered' => null,
            'read' => false,
            'answered_by' => null,
        ]);
    }

    protected function getFormatedData($date){
        $onlyDate = Carbon::parse($date)->format('d/m/Y');
        $onlyTime = Carbon::parse($date)->format('H:i');
        return $onlyDate." às ".$onlyTime;
    }

}
