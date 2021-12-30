<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

use App\Models\Professional;
use App\Models\User;
use App\Models\Doubt;
use App\Models\DoubtAnswer;
use App\Models\FollowUp;

use App\Models\ProntuaryAnthropomedicalData;
use App\Models\ProntuaryBenznidazol;
use App\Models\ProntuaryEpidemicData;
use App\Models\ProntuaryExamsAndProcedure;
use App\Models\ProntuaryIdentificationData;
use App\Models\ProntuaryMedicinesInUse;
use App\Models\ProntuaryPersonalBackground;
use App\Models\ProntuarySocioeconomicData;
use App\Models\Prontuary;

class ProfessionalController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getPatients(){
        $professional = Auth::user();
        $data = [];

        $patients = Professional::where('id_user', $professional->id)->get();

        if (count($patients)){
            foreach($patients as $key => $value){
                $name = User::where('_id', $patients[$key]->id_patient)->get();
    
                $data[$key]['name'] = ucwords($name[0]->name);
                $data[$key]['id_patient'] = $patients[$key]->id_patient;
            }
        } else return false;
        
        return $data;
    }

    public function answerDoubt(Request $request){
        $professional = Auth::user();
        $answer = $request->only('message');
        $id_doubt = $request->only('idDoubt');

        // cria resposta
        DoubtAnswer::create([
            'id_doubt' => $id_doubt['idDoubt'],
            'type' => 2,
            'answer' => $answer['message'],
            'answered_by' => $professional->_id,
        ]);

        // atualiza o status da dúvida para respondido
        Doubt::where('_id', $id_doubt['idDoubt'])
        ->update([
            'status' => 'answered',
        ]);
    }

    public function followUpRequests(){
        $requests = FollowUp::where('requested', true)
        ->where('accepted_by', null)->get();

        if (count($requests)){
            $data = [];
    
            foreach($requests as $key => $value){
                $name = User::where('_id', $requests[$key]->id_user)->get();
                $data[$key]['id_user'] = $requests[$key]->id_user;
                $data[$key]['name'] = ucwords($name[0]->name);
                $data[$key]['date'] = $this->getFormatedData($requests[$key]->created_at);
            }

            return $data;
        } else return false;

    }

    protected function getFormatedData($date){
        $onlyDate = Carbon::parse($date)->format('d/m/Y');
        return $onlyDate;
    }

    public function getPatientProntuary($id, $step){
        $data = [];

        switch($step){
            case 0: $data[] = Prontuary::where("id_user", $id)->get(); break;
            case 1: $data[] = ProntuaryIdentificationData::where("id_user", $id)->get(); break;
            case 2: $data[] = ProntuarySocioeconomicData::where("id_user", $id)->get(); break;
            case 3: $data[] = ProntuaryEpidemicData::where("id_user", $id)->get(); break;
            case 4: $data[] = ProntuaryAnthropomedicalData::where("id_user", $id)->get(); break;
            case 5: $data[] = ProntuaryPersonalBackground::where("id_user", $id)->get(); break;
            case 6: $data[] = ProntuaryExamsAndProcedure::where("id_user", $id)->get(); break;
            case 7: $data[] = ProntuaryBenznidazol::where("id_user", $id)->get(); break;
            case 8: $data[] = ProntuaryMedicinesInUse::where("id_user", $id)->get(); break;
            default: return $data['error'] = "Erro inesperado. ";
        }

        return $data;
    }
}
