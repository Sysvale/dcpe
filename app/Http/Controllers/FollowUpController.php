<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\FollowUp;
use App\Models\FollowUpChat;
use App\Models\Professional;

use Carbon\Carbon;

class FollowUpController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function hasFollowUp(){
        $user = Auth::user();

        // verifica se já requisitou acompanhamento
        $followUp = FollowUp::where('id_user', $user->id)->get();

        if (count($followUp)){
            if ($followUp[0]['requested']) return true;
            else return false;
        } else return false;
    }

    public function requestFollowUp(){
        $user = Auth::user();

        FollowUp::create([
            'id_user' => $user->id,
            'requested' => true,
            'accepted_by' => null,
        ]);
    }

    public function cancelRequestFollowUp(){
        $user = Auth::user();
        FollowUp::where('id_user', $user->_id)->delete();
    }

    public function acceptRequest(Request $request){
        $professional = Auth::user();
        $user = $request->only('user');

        // atualiza a requisição
        FollowUp::where('id_user', $user['user'])
            ->update([
                'accepted_by' => $professional->_id
            ]);
        
        Professional::create([
            'id_user' => $professional->_id,
            'id_patient' => $user['user'],
        ]);
    }

    public function statsFollowUp(){
        $user = Auth::user();

        if ($user->roles == 'patient'){
            $stats = FollowUp::where('id_user', $user->id)->get();
            if ($stats[0]->accepted_by != null){
                $accepted_by = User::where('_id', $stats[0]->accepted_by)->get();
                return ['name' => ucwords($accepted_by[0]->name), 'id_chat' => $stats[0]->_id];
            } else return false;
        }

        if ($user->roles == 'professional'){
            $id_chat = FollowUp::where('accepted_by', $user->id)->get();
            return $id_chat[0]->_id;
        }

    }

    public function getMessages(){
        $user = Auth::user();
        $chat = FollowUp::where('id_user', $user->id)->get();
        $professional = $chat[0]->accepted_by;
        $messages = [];

        // pega as mensagens do usuário do chat
        $messages_sent = FollowUpChat::where('id_chat', $chat[0]->_id)
        ->where('id_user', $user->id)->get();
        $messages_received = FollowUpChat::where('id_chat', $chat[0]->_id)
        ->where('id_user', $professional)->get();
        
        $count = 0;
        
        foreach($messages_sent as $key => $value){
            $messages[$key]['id'] = $messages_sent[$key]->_id;
            $messages[$key]['id_chat'] = $messages_sent[$key]->id_chat;
            $messages[$key]['id_user'] = $messages_sent[$key]->id_user;
            $messages[$key]['message'] = $messages_sent[$key]->message;
            $messages[$key]['created_at'] = $messages_sent[$key]->created_at;
            $messages[$key]['updated_at'] = $messages_sent[$key]->updated_at;
            $messages[$key]['type'] = 1;
            $count++;
        }
        
        for ($key = 0; $key < count($messages_received); $key++){
            $messages[$count]['id'] = $messages_received[$key]->_id;
            $messages[$count]['id_chat'] = $messages_received[$key]->id_chat;
            $messages[$count]['id_user'] = $messages_received[$key]->id_user;
            $messages[$count]['message'] = $messages_received[$key]->message;
            $messages[$count]['created_at'] = $messages_received[$key]->created_at;
            $messages[$count]['updated_at'] = $messages_received[$key]->updated_at;
            $messages[$count]['type'] = 2;
            $count++;
        }
        
        $sort = [];

        foreach ($messages as $key => $value) {
            $sort[$key] = strtotime($messages[$key]['created_at']);
        }

        array_multisort($sort, SORT_ASC, $messages);

        foreach($messages as $key => $value){
            $user_name = User::where('_id', $messages[$key]['id_user'])->get();
            $messages[$key]['id_user'] = ucwords($user_name[0]->name);
            $messages[$key]['created_at'] = $this->getFormatedData($messages[$key]['created_at']);
            $messages[$key]['updated_at'] = $this->getFormatedData($messages[$key]['updated_at']);
        }

        return $messages;
    }

    public function getMessagesProfessional(){
        $professional = Auth::user();
        $chat = FollowUp::where('accepted_by', $professional->_id)->get();
        $user = $chat[0]->id_user;
        $messages = [];

        // pega as mensagens do usuário do chat
        $messages_sent = FollowUpChat::where('id_chat', $chat[0]->_id)
        ->where('id_user', $professional->_id)->get();
        $messages_received = FollowUpChat::where('id_chat', $chat[0]->_id)
        ->where('id_user', $user)->get();
        
        $count = 0;
        
        foreach($messages_sent as $key => $value){
            $messages[$key]['id'] = $messages_sent[$key]->_id;
            $messages[$key]['id_chat'] = $messages_sent[$key]->id_chat;
            $messages[$key]['id_user'] = $messages_sent[$key]->id_user;
            $messages[$key]['message'] = $messages_sent[$key]->message;
            $messages[$key]['created_at'] = $messages_sent[$key]->created_at;
            $messages[$key]['updated_at'] = $messages_sent[$key]->updated_at;
            $messages[$key]['type'] = 1;
            $count++;
        }
        
        for ($key = 0; $key < count($messages_received); $key++){
            $messages[$count]['id'] = $messages_received[$key]->_id;
            $messages[$count]['id_chat'] = $messages_received[$key]->id_chat;
            $messages[$count]['id_user'] = $messages_received[$key]->id_user;
            $messages[$count]['message'] = $messages_received[$key]->message;
            $messages[$count]['created_at'] = $messages_received[$key]->created_at;
            $messages[$count]['updated_at'] = $messages_received[$key]->updated_at;
            $messages[$count]['type'] = 2;
            $count++;
        }
        
        $sort = [];

        foreach ($messages as $key => $value) {
            $sort[$key] = strtotime($messages[$key]['created_at']);
        }

        array_multisort($sort, SORT_ASC, $messages);

        foreach($messages as $key => $value){
            $user_name = User::where('_id', $messages[$key]['id_user'])->get();
            $messages[$key]['id_user'] = ucwords($user_name[0]->name);
            $messages[$key]['created_at'] = $this->getFormatedData($messages[$key]['created_at']);
            $messages[$key]['updated_at'] = $this->getFormatedData($messages[$key]['updated_at']);
        }

        return $messages;
    }

    protected function getFormatedData($date){
        $onlyDate = Carbon::parse($date)->format('d/m/Y');
        $onlyTime = Carbon::parse($date)->format('H:i');
        return $onlyDate." às ".$onlyTime;
    }

    public function addMessage(Request $request){
        $sent = $request->only(['message']);
        $chat = $request->only(['idChat']);

        if ($sent['message'] != '') $this->storeMessage($sent['message'], $chat['idChat']);
    }

    protected function storeMessage($sent, $id_chat){
        $user = Auth::user();

        return FollowUpChat::create([
            'id_user' => $user->_id,
            'id_chat' => $id_chat,
            'message' => $sent,
        ]);
    }

}
