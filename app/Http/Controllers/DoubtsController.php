<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Doubt;
use App\Models\DoubtAnswer;
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
        $id_doubts = [];
        $messages = [];
        $count = 0;

        foreach ($doubts as $key => $value){
            // pega dados das dúvidas e formata
            $messages[$key]['id_doubt'] = $doubts[$key]->_id;
            $messages[$key]['id_user'] = $doubts[$key]->id_user;
            $messages[$key]['type'] = $doubts[$key]->type;
            $messages[$key]['message'] = $doubts[$key]->message;
            $messages[$key]['status'] = $doubts[$key]->status;
            $messages[$key]['created_at'] = $doubts[$key]->created_at; //$this->getFormatedData($doubts[$key]->created_at);
            $messages[$key]['updated_at'] = $doubts[$key]->updated_at; //$this->getFormatedData($doubts[$key]->updated_at);
            
            $id_doubts[$key]['id'] = $doubts[$key]->_id;
            $id_doubts[$key]['message'] = $doubts[$key]->message;
            $count++;
        }

        for ($key = 0; $key < count($id_doubts); $key++){
            // pega resposta da dúvida atual (se existir)
            $answer = DoubtAnswer::where('id_doubt', $id_doubts[$key]['id'])->get();
            
            if (count($answer)){ // se tiver resposta
                $messages[$count]['id_doubt'] = $answer[0]->id_doubt;
                $messages[$count]['type'] = $answer[0]->type;    
                $messages[$count]['answer'] = $answer[0]->answer;
                $messages[$count]['answered_by'] = $answer[0]->answered_by;
                $messages[$count]['read'] = $answer[0]->read;
                $messages[$count]['message'] = $id_doubts[$key]['message'];
                $messages[$count]['created_at'] = $answer[0]->created_at;//$this->getFormatedData($answer[0]->created_at);
                $messages[$count]['updated_at'] = $answer[0]->updated_at;//$this->getFormatedData($answer[0]->updated_at);
                $count++;
            }
        }

        $sort = [];
        foreach ($messages as $key => $value) {
            $sort[$key] = strtotime($messages[$key]['created_at']);
        }

        array_multisort($sort, SORT_ASC, $messages);

        foreach($messages as $key => $value){
            $messages[$key]['created_at'] = $this->getFormatedData($messages[$key]['created_at']);
            $messages[$key]['updated_at'] = $this->getFormatedData($messages[$key]['updated_at']);
        }
        
        return $messages;
    }

    public function addDoubt(Request $request){
        $sent = $request->only(['message']);
       
        if ($sent && $sent['message'] != '') $this->storeDoubt($sent);
    }

    public function addAnswer(Request $request){
        // $sent = $request->only(['message']);

        $sent = [];
        $sent['idDoubt'] = '61ccc55b305c2a0fc2054464';
        $sent['answer'] = 'resposta aqui tal tal';
        $sent['answeredBy'] = '61ccc65f844bdd2118294e15';

        if ($sent['answer'] != '') 
            return $this->storeAnswer($sent);
    }

    public function markAsRead(Request $request){
        $id = $request->only(['id']);
        Doubt::where('_id', $id['id'])->update(['read' => true]);
    }

    protected function storeDoubt(Array $sent){
        $user = Auth::user();

        return Doubt::create([
            'id_user' => $user['id'],
            'type' => 1,
            'message' => $sent['message'],
            'status' => States::WAITING,
        ]);
    }

    protected function storeAnswer(Array $sent){
        // marca dúvida como lida
        Doubt::where('_id', $sent['idDoubt'])->update([ 'status' => States::ANSWERED ,'read' => true ]);

        $answered_by = User::where('_id', $sent['answeredBy'])->get();
        
        return DoubtAnswer::create([
            'id_doubt' => $sent['idDoubt'],
            'type' => 2,
            'answer' => $sent['answer'],
            'answered_by' => $answered_by[0]->name,
            'read' => false,
        ]);
    }

    protected function getFormatedData($date){
        $onlyDate = Carbon::parse($date)->format('d/m/Y');
        $onlyTime = Carbon::parse($date)->format('H:i');
        return $onlyDate." às ".$onlyTime;
    }

    public function getDoubtsUnread(){
        $doubts = Doubt::where('status', 'waiting')->get();
        $data = [];
        
        if (count($doubts)){
            foreach ($doubts as $key => $value){
                $name = User::where('_id', $doubts[$key]->id_user)->get();
                $data[$key]['name'] = $name[0]->name;
                $data[$key]['id_doubt'] = $doubts[$key]->_id;
                $data[$key]['id_user'] = $doubts[$key]->id_user;
                $data[$key]['message'] = $doubts[$key]->message;
                $data[$key]['created_at'] = $this->getFormatedData($doubts[$key]->created_at);
            }
            
            return $data;
        } else return false;
    }

}
