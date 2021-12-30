<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

use App\Models\ProntuaryAnthropomedicalData;
use App\Models\ProntuaryBenznidazol;
use App\Models\ProntuaryEpidemicData;
use App\Models\ProntuaryExamsAndProcedure;
use App\Models\ProntuaryIdentificationData;
use App\Models\ProntuaryMedicinesInUse;
use App\Models\ProntuaryPersonalBackground;
use App\Models\ProntuarySocioeconomicData;
use App\Models\Prontuary;

class ProntuaryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function add(Request $request){
        $values      = $request->only('data');
        $currentForm = $request->only('form');
        $completed   = $request->only('steps');
        $progress    = $request->only('progressForm');
        $user        = Auth::user();

        $prontuaryUser = Prontuary::where("id_user", $user->id)->get();
        
        if (!count($prontuaryUser)){ 
            // se não achar prontuário do usuário, cria um
            $this->createProntuary($user->id);
            $this->createProntuaryIdentificationData($user);
            $this->createProntuarySocioeconomicData($user->id);
            $this->createProntuaryEpidemicData($user->id);
            $this->createProntuaryAnthropomedicalData($user->id);
            $this->createProntuaryPersonalBackground($user->id);
            $this->createProntuaryExamsAndProcedures($user->id);
            $this->createProntuaryBenznidazol($user->id);
            $this->createProntuaryMedicinesInUse($user->id);
        } 
        
        return $this->updateProntuary($user->id, $completed['steps']);

        switch($currentForm['form']){
            case 1: $this->updateProntuaryIdentificationData($user->id, $values['data'], $progress['progressForm']); break;
            case 2: $this->updateProntuarySocioeconomicData($user->id, $values['data'], $progress['progressForm']); break;
            case 3: $this->updateProntuaryEpidemicData($user->id, $values['data'], $progress['progressForm']); break;
            case 4: $this->updateProntuaryAnthropomedicalData($user->id, $values['data'], $progress['progressForm']); break;
            case 5: $this->updateProntuaryPersonalBackground($user->id, $values['data'], $progress['progressForm']); break;
            case 6: $this->updateProntuaryExamsAndProcedures($user->id, $values['data'], $progress['progressForm']); break;
            case 7: $this->updateProntuaryBenznidazol($user->id, $values['data'], $progress['progressForm']); break;
            case 8: $this->updateProntuaryMedicinesInUse($user->id, $values['data'], $progress['progressForm']); break;
            default: return 'Erro inesperado. ';
        }
    }

    public function getStates(){
        $states = [];
        $user = Auth::user();

        $states = Prontuary::where("id_user", $user->id)->select("completed_forms")->first()->completed_forms;

        return unserialize($states);
        // $states[] = ProntuaryIdentificationData::where("id_user", $user->id)->select("status")->first()->status;
        // $states[] = ProntuarySocioeconomicData::where("id_user", $user->id)->select("status")->first()->status;
        // $states[] = ProntuaryEpidemicData::where("id_user", $user->id)->select("status")->first()->status;
        // $states[] = ProntuaryAnthropomedicalData::where("id_user", $user->id)->select("status")->first()->status;
        // $states[] = ProntuaryPersonalBackground::where("id_user", $user->id)->select("status")->first()->status;
        // $states[] = ProntuaryExamsAndProcedure::where("id_user", $user->id)->select("status")->first()->status;
        // $states[] = ProntuaryBenznidazol::where("id_user", $user->id)->select("status")->first()->status;
        // $states[] = ProntuaryMedicinesInUse::where("id_user", $user->id)->select("status")->first()->status;

        // $data = [[]];

        // foreach($states as $key => $value){
        //     if ($value == 'completed'){
        //         $data[$key]['id'] = ++$key;
        //         $data[$key]['state'] = $value;
        //     }
        // }

        // return $data;
    }

    public function get($step){
        $user = Auth::user();
        $data = [];

        $prontuary = Prontuary::where("id_user", $user->id)->get();
        $data['completed_forms'] = unserialize($prontuary[0]->completed_forms);

        switch($step){
            case 1: $data[] = ProntuaryIdentificationData::where("id_user", $user->id)->get(); break;
            case 2: $data[] = ProntuarySocioeconomicData::where("id_user", $user->id)->get(); break;
            case 3: $data[] = ProntuaryEpidemicData::where("id_user", $user->id)->get(); break;
            case 4: $data[] = ProntuaryAnthropomedicalData::where("id_user", $user->id)->get(); break;
            case 5: $data[] = ProntuaryPersonalBackground::where("id_user", $user->id)->get(); break;
            case 6: $data[] = ProntuaryExamsAndProcedure::where("id_user", $user->id)->get(); break;
            case 7: $data[] = ProntuaryBenznidazol::where("id_user", $user->id)->get(); break;
            case 8: $data[] = ProntuaryMedicinesInUse::where("id_user", $user->id)->get(); break;
            default: return $data['error'] = "Erro inesperado. ";
        }

        return $data;
    }

    protected function createProntuary($userId){
        return Prontuary::create([
            'id_user' => $userId,
            'completed_forms' => null,
            'status' => 'waiting',
        ]);
    }

    protected function createProntuaryIdentificationData($user){
        return ProntuaryIdentificationData::create([
            'id_user' => $user->id,
            'full_name' => $user->name,
            'birth_date' => '',
            'city_of_birth' => '',
            'city_of_origin' => '',
            'phone' => null,
            'marital_status' => '',
            'breed' => '',
            'sex' => '',
        ]);
    }
    
    protected function createProntuarySocioeconomicData($userId){
        return ProntuarySocioeconomicData::create([
            'id_user' => $userId,
            'education_level' => '',
            'per_capita_income' => '',
            'number_of_inhabitants' => 0,
            'work_status' => '',
            'profission' => '',
        ]);
    }

    protected function createProntuaryEpidemicData($userId){
        return ProntuaryEpidemicData::create([
            'id_user' => $userId,
            'has_serology' => '',
            'dc_in_family' => '',
            'dc_in_family_who' => '',
            'dc_in_family_vf' => 0,
            'know_the_vector' => '',
            'lived_in_a_mud_house' => '',
            'time_in_a_mud_house' => '',
            'dwelling_area' => '',
            'has_breeding' => '',
            'donated_blood' => '',
            'received_blood' => '',
        ]);
    }

    protected function createProntuaryAnthropomedicalData($userId){
        return ProntuaryAnthropomedicalData::create([
            'id_user' => $userId,
            'weight' => 0,
            'height' => 0,
            'imc' => 0,
        ]);
    }

    protected function createProntuaryPersonalBackground($userId){
        return ProntuaryPersonalBackground::create([
            'id_user' => $userId,
            'neoplasm' => '',
            'syphilis_history_dsts' => '',
            'others_dsts_explane' => '',
            'viral_hepatitis' => '',
            'arterial_hypertension' => '',
            'diabetes_mellitus' => '',
            'coronary_disease' => '',
            'dyslipidemia' => '',
            'neuropsychiatric_disorders' => '',
            'neuropsychiatric_disorders_explane' => '',
            'smoking' => '',
            'alcoholism' => '',
            'megaesophagus' => '',
            'megacolon' => '',
            'avc' => '',
            'chronic_lung_disease' => '',
            'cardiac_insufficiency' => '',
        ]);
    }

    protected function createProntuaryExamsAndProcedures($userId){
        return ProntuaryExamsAndProcedure::create([
            'id_user' => $userId,
            'rx_chest' => '',
            'rx_esophagus' => '',
            'electrocardiogram' => '',
            'pacemaker' => '',
            'heart_transplantation' => '',
        ]);
    }

    protected function createProntuaryBenznidazol($userId){
        return ProntuaryBenznidazol::create([
            'id_user' => $userId,
            'benznidazol' => '',
            'year_benznidazol' => '',
            'form_of_presentation' => '',
            'daily_dosage' => '',
            'usage_time_benznidazol' => '',
        ]);
    }

    protected function createProntuaryMedicinesInUse($userId){
        return ProntuaryMedicinesInUse::create([
            'id_user' => $userId,
            'diuretic' => '',
            'blocker' => '',
            'angiotensin_inhibitor' => '',
            'amiodarone' => '',
            'usage_time_amidarone' => '',
            'statins' => '',
            'spironolactone' => '',
            'usage_time_spironolactone' => '',
            'hypoglycemics' => '',
            'benzodiazepines' => '',
            'aas' => '',
            'hydralazine' => '',
            'levothyroxine_sodium' => '',
            'anlodipine' => '',
        ]);
    }

    protected function updateProntuary($userId, $completed){
        return "a :".$completed;
        $completedForms = count($completed) > 0?serialize($completed):null;
        $newStatus = (count($completed) == 8)?'completed':'progress';

        Prontuary::where("id_user", $userId)
        ->update([
            'completed_forms' => $completedForms,
            'status' => $newStatus,
        ]);
    }

    protected function updateProntuaryIdentificationData($userId, Array $data, $progress){
        ProntuaryIdentificationData::where("id_user", $userId)
        ->update([
            'full_name' => $data['name'],
            'birth_date' => $data['birthdate'],
            'sex' => $data['sex'],
            'phone' => $data['phone'],
            'city_of_birth' => $data['cityOfBirth'],
            'city_of_origin' => $data['cityOfOrigin'],
            'marital_status' => $data['maritalStatus'],
            'breed' => $data['breed'],
            'status' => ($progress == 100)?'completed':'inProgress',
        ]);
    }

    protected function updateProntuarySocioeconomicData($userId, Array $data, $progress){
        ProntuarySocioeconomicData::where("id_user", $userId)
        ->update([
            'education_level' => $data['educationLevel'],
            'per_capita_income' => $data['perCapitaIncome'],
            'number_of_inhabitants' => $data['numberOfInhabitants'],
            'work_status' => $data['workSituation'],
            'profission' => $data['profission'],
            'status' => ($progress == 100)?'completed':'inProgress',
        ]);
    }

    protected function updateProntuaryEpidemicData($userId, Array $data, $progress){
        ProntuaryEpidemicData::where("id_user", $userId)
        ->update([
            'has_serology' => $data['serology'],
            'dc_in_family' => $data['caseInTheFamily'],
            'dc_in_family_who' => $data['caseInTheFamilyYes'],
            'dc_in_family_vf' => $data['numberOfCaseInFamily'],
            'know_the_vector' => $data['knowTheVector'],
            'lived_in_a_mud_house' => $data['dwellingArea'],
            'time_in_a_mud_house' => $data['dwellingAreaYears'],
            'dwelling_area' => $data['livedTaipa'],
            'has_breeding_serology' => $data['breedingResidence'],
            'donated_blood' => $data['donatedBlood'],
            'received_blood' => $data['receivedBlood'],
            'status' => ($progress == 100)?'completed':'inProgress',
        ]);
    }

    protected function updateProntuaryAnthropomedicalData($userId, Array $data, $progress){
        ProntuaryAnthropomedicalData::where("id_user", $userId)
        ->update([
            'weight' => $data['weight'],
            'height' => $data['height'],
            'imc' => $data['imc'],
            'status' => ($progress == 100)?'completed':'inProgress',
        ]);
    }

    protected function updateProntuaryPersonalBackground($userId, Array $data, $progress){
        ProntuaryPersonalBackground::where("id_user", $userId)
        ->update([
            'neoplasm' => $data['neoplasm'],
            'syphilis_history_dsts' => $data['syphilis'],
            'others_dsts_explane' => $data['syphilisOthers'],
            'viral_hepatitis' => $data['viralHepatitis'],
            'arterial_hypertension' => $data['arterialHypertension'],
            'diabetes_mellitus' => $data['diabetesMellitus'],
            'coronary_disease' => $data['coronaryArteryDisease'],
            'dyslipidemia' => $data['dyslipidemia'],
            'neuropsychiatric_disorders' => $data['neuropsychiatricDisorders'],
            'neuropsychiatric_disorders_explane' => $data['neuropsychiatricDisordersYes'],
            'smoking' => $data['smoking'],
            'alcoholism' => $data['alcoholism'],
            'megaesophagus' => $data['megaesophagus'],
            'megacolon' => $data['megacolon'],
            'avc' => $data['avc'],
            'chronic_lung_disease' => $data['pulmonaryDisease'],
            'cardiac_insufficiency' => $data['cardiacInsufficiency'],
            'status' => ($progress == 100)?'completed':'inProgress',
        ]);
    }

    protected function updateProntuaryExamsAndProcedures($userId, Array $data, $progress){
        ProntuaryExamsAndProcedure::where("id_user", $userId)
        ->update([
            'rx_chest' => $data['chestXray'],
            'rx_esophagus' => $data['esophagealRadiography'],
            'electrocardiogram' => $data['electrocardiogram'],
            'pacemaker' => $data['pacemaker'],
            'heart_transplantation' => $data['heartTransplantation'],
            'status' => ($progress == 100)?'completed':'inProgress',
        ]);
    }

    protected function updateProntuaryBenznidazol($userId, Array $data, $progress){
        ProntuaryBenznidazol::where("id_user", $userId)
        ->update([
            'benznidazol' => $data['benznidazol'],
            'year_benznidazol' => $data['benznidazolYear'],
            'form_of_presentation' => $data['formOfPresentation'],
            'daily_dosage' => $data['dailyDosage'],
            'usage_time_benznidazol' => $data['usageTime'],
            'status' => ($progress == 100)?'completed':'inProgress',
        ]);
    }

    protected function updateProntuaryMedicinesInUse($userId, Array $data, $progress){
        $pmu = ProntuaryMedicinesInUse::where("id_user", $userId)
        ->update([
            'diuretic' => $data['diuretic'],
            'blocker' => $data['blocker'],
            'angiotensin_inhibitor' => $data['enzymeInhibitor'],
            'amiodarone' => $data['amiodarona'],
            'usage_time_amidarone' => $data['usageTimeAmiodarona'],
            'statins' => $data['estatinas'],
            'spironolactone' => $data['espironolactona'],
            'usage_time_spironolactone' => $data['usageTimeEspironolactona'],
            'hypoglycemics' => $data['hipoglicemiantes'],
            'benzodiazepines' => $data['benzodiazepinicos'],
            'aas' => $data['aas'],
            'hydralazine' => $data['hidralazina'],
            'levothyroxine_sodium' => $data['levotiroxina'],
            'anlodipine' => $data['anlodipino'],
            'status' => ($progress == 100)?'completed':'inProgress',
        ]);
    }
}
