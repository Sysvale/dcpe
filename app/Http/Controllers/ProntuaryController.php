<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $form = $request->only('form');
        $user = Auth::user();

        $userProntuary = Prontuary::where("id_user", $user->id)->get();
        
        // pega o prontuário do usuário, se ele tiver um atualiza, se não cria um
        if (!count($userProntuary)){ // cria
            $this->createProntuary($user->id);
            $this->createProntuaryIdentificationData($user);
            $this->createProntuarySocioeconomicData($user->id);
            $this->createProntuaryEpidemicData($user->id);
            $this->createProntuaryAnthropomedicalData($user->id);
            $this->createProntuaryPersonalBackground($user->id);
            $this->createProntuaryExamsAndProcedures($user->id);
            $this->createProntuaryBenznidazol($user->id);
            $this->createProntuaryMedicinesInUse($user->id);
        } else {
            // atualiza o existente
            switch($form['form']['id']){
                case 1: $this->updateProntuaryIdentificationData($user->id, $form['form']); break;
                case 2: $this->updateProntuarySocioeconomicData($user->id, $form['form']); break;
                case 3: $this->updateProntuaryEpidemicData($user->id, $form['form']); break;
                case 4: $this->updateProntuaryAnthropomedicalData($user->id, $form['form']); break;
                case 5: $this->updateProntuaryPersonalBackground($user->id, $form['form']); break;
                case 6: $this->updateProntuaryExamsAndProcedures($user->id, $form['form']); break;
                case 7: $this->updateProntuaryBenznidazol($user->id, $form['form']); break;
                case 8: $this->updateProntuaryMedicinesInUse($user->id, $form['form']); break;
                default: return 'Erro inesperado. ';
            }
        }
        
    }

    public function get($step){
        $user = Auth::user();
        $data = [];

        switch($step){
            case 0: $data[] = Prontuary::where("id_user", $user->id)->get(); break;
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

    public function finishProntuary(){
        $user = Auth::user();
        $this->updateProntuary($user->id, 'completed');
    }

    protected function createProntuary($userId){
        return Prontuary::create([
            'id_user' => $userId,
            'status' => 'waiting', // função finish do step8
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
            'has_dc' => '',
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

    protected function updateProntuary($userId, $status){

        Prontuary::where("id_user", $userId)
        ->update([
            'status' => $status,
        ]);
    }

    protected function updateProntuaryIdentificationData($userId, Array $data){
        ProntuaryIdentificationData::where("id_user", $userId)
        ->update([
            'full_name' => ucwords($data['fields']['name']),
            'birth_date' => $data['fields']['birthdate'],
            'sex' => ucwords($data['fields']['sex']),
            'phone' => $data['fields']['phone'],
            'city_of_birth' => ucwords($data['fields']['cityOfBirth']),
            'city_of_origin' => ucwords($data['fields']['cityOfOrigin']),
            'marital_status' => $data['fields']['maritalStatus'],
            'breed' => $data['fields']['breed'],
            'status' => $data['status'],
        ]);
    }

    protected function updateProntuarySocioeconomicData($userId, Array $data){
        ProntuarySocioeconomicData::where("id_user", $userId)
        ->update([
            'education_level' => $data['fields']['educationLevel'],
            'per_capita_income' => $data['fields']['perCapitaIncome'],
            'number_of_inhabitants' => $data['fields']['numberOfInhabitants'],
            'work_status' => $data['fields']['workSituation'],
            'profission' => $data['fields']['profission'],
            'status' => $data['status'],
        ]);
    }

    protected function updateProntuaryEpidemicData($userId, Array $data){
        ProntuaryEpidemicData::where("id_user", $userId)
        ->update([
            'has_dc' => $data['fields']['hasDc'],
            'has_serology' => $data['fields']['serology'],
            'dc_in_family' => $data['fields']['caseInTheFamily'],
            'dc_in_family_who' => ucwords($data['fields']['caseInTheFamilyYes']),
            'dc_in_family_vf' => $data['fields']['numberOfCaseInFamily'],
            'know_the_vector' => $data['fields']['knowTheVector'],
            'lived_in_a_mud_house' => $data['fields']['dwellingArea'],
            'time_in_a_mud_house' => $data['fields']['dwellingAreaYears'],
            'dwelling_area' => $data['fields']['livedTaipa'],
            'has_breeding' => $data['fields']['breedingResidence'],
            'donated_blood' => $data['fields']['donatedBlood'],
            'received_blood' => $data['fields']['receivedBlood'],
            'status' => $data['status'],
        ]);
    }

    protected function updateProntuaryAnthropomedicalData($userId, Array $data){
        ProntuaryAnthropomedicalData::where("id_user", $userId)
        ->update([
            'weight' => $data['fields']['weight'],
            'height' => $data['fields']['height'],
            'imc' => $data['fields']['imc'],
            'status' => $data['status'],
        ]);
    }

    protected function updateProntuaryPersonalBackground($userId, Array $data){
        ProntuaryPersonalBackground::where("id_user", $userId)
        ->update([
            'neoplasm' => $data['fields']['neoplasm'],
            'syphilis_history_dsts' => $data['fields']['syphilis'],
            'others_dsts_explane' => ucwords($data['fields']['syphilisOthers']),
            'viral_hepatitis' => $data['fields']['viralHepatitis'],
            'arterial_hypertension' => $data['fields']['arterialHypertension'],
            'diabetes_mellitus' => $data['fields']['diabetesMellitus'],
            'coronary_disease' => $data['fields']['coronaryArteryDisease'],
            'dyslipidemia' => $data['fields']['dyslipidemia'],
            'neuropsychiatric_disorders' => $data['fields']['neuropsychiatricDisorders'],
            'neuropsychiatric_disorders_explane' => $data['fields']['neuropsychiatricDisordersYes'],
            'smoking' => $data['fields']['smoking'],
            'alcoholism' => $data['fields']['alcoholism'],
            'megaesophagus' => $data['fields']['megaesophagus'],
            'megacolon' => $data['fields']['megacolon'],
            'avc' => $data['fields']['avc'],
            'chronic_lung_disease' => $data['fields']['pulmonaryDisease'],
            'cardiac_insufficiency' => $data['fields']['cardiacInsufficiency'],
            'status' => $data['status'],
        ]);
    }

    protected function updateProntuaryExamsAndProcedures($userId, Array $data){
        ProntuaryExamsAndProcedure::where("id_user", $userId)
        ->update([
            'rx_chest' => $data['fields']['chestXray'],
            'rx_esophagus' => $data['fields']['esophagealRadiography'],
            'electrocardiogram' => $data['fields']['electrocardiogram'],
            'pacemaker' => $data['fields']['pacemaker'],
            'heart_transplantation' => $data['fields']['heartTransplantation'],
            'status' => $data['status'],
        ]);
    }

    protected function updateProntuaryBenznidazol($userId, Array $data){
        ProntuaryBenznidazol::where("id_user", $userId)
        ->update([
            'benznidazol' => $data['fields']['benznidazol'],
            'year_benznidazol' => $data['fields']['benznidazolYear'],
            'form_of_presentation' => $data['fields']['formOfPresentation'],
            'daily_dosage' => $data['fields']['dailyDosage'],
            'usage_time_benznidazol' => $data['fields']['usageTime'],
            'status' => $data['status'],
        ]);
    }

    protected function updateProntuaryMedicinesInUse($userId, Array $data){
        $pmu = ProntuaryMedicinesInUse::where("id_user", $userId)
        ->update([
            'diuretic' => $data['fields']['diuretic'],
            'blocker' => $data['fields']['blocker'],
            'angiotensin_inhibitor' => $data['fields']['enzymeInhibitor'],
            'amiodarone' => $data['fields']['amiodarona'],
            'usage_time_amidarone' => $data['fields']['usageTimeAmiodarona'],
            'statins' => $data['fields']['estatinas'],
            'spironolactone' => $data['fields']['espironolactona'],
            'usage_time_spironolactone' => $data['fields']['usageTimeEspironolactona'],
            'hypoglycemics' => $data['fields']['hipoglicemiantes'],
            'benzodiazepines' => $data['fields']['benzodiazepinicos'],
            'aas' => $data['fields']['aas'],
            'hydralazine' => $data['fields']['hidralazina'],
            'levothyroxine_sodium' => $data['fields']['levotiroxina'],
            'anlodipine' => $data['fields']['anlodipino'],
            'status' => $data['status'],
        ]);
    }
}
