<template>
    <div>
        <div class="stepper-pos">
            <cds-stepper
                v-model="currentStepIndex"
                :steps="steps"
            />
        </div>
        <b-card style="margin-bottom: 50px;">
            <div v-if="role == 'patient'">
                <title-step
                    :title="steps[currentStepIndex-1].label"
                    :show="false"
                    :id="steps[currentStepIndex-1].id"
                    :visible="true"
                />
            </div>
            <div v-if="role == 'professional'">
                <title-step
                    :title="steps[currentStepIndex-1].label"
                    :show="false"
                    :id="steps[currentStepIndex-1].id"
                    :visible="false"
                />
            </div>
            <div v-if="isLoading" class="spinner-loading">
                <b-spinner variant="primary" label="Spinning"></b-spinner>
            </div>
            <div v-else>
                <div v-if="steps[currentStepIndex-1].id == 1" class="step-content">
                    <table class="table">
                        <tbody>
                            <tr>
                                <th scope="row" style="width: 350px"><strong>Nome completo: </strong></th>
                                <td>{{ items['full_name'] }}</td>
                            </tr>
                            <tr>
                                <th scope="row" style="width: 200px"><strong>Data de nascimento: </strong></th>
                                <td>{{ getBirthDate }}</td>
                            </tr>
                            <tr>
                                <th scope="row" style="width: 200px"><strong>Município de Naturalidade: </strong></th>
                                <td>{{ items['city_of_birth'] }}</td>
                            </tr>
                            <tr>
                                <th scope="row" style="width: 200px"><strong>Município de Procedência: </strong></th>
                                <td>{{ items['city_of_origin'] }}</td>
                            </tr>
                            <tr>
                                <th scope="row" style="width: 200px"><strong>Telefone: </strong></th>
                                <td>{{ items['phone'] }}</td>
                            </tr>
                            <tr>
                                <th scope="row" style="width: 200px"><strong>Estado Civil: </strong></th>
                                <td>{{ items['marital_status'] }}</td>
                            </tr>
                            <tr>
                                <th scope="row" style="width: 200px"><strong>Raça/Cor: </strong></th>
                                <td>{{ items['breed'] }}</td>
                            </tr>
                            <tr>
                                <th scope="row" style="width: 200px"><strong>Sexo: </strong></th>
                                <td>{{ items['sex'] }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div v-if="steps[currentStepIndex-1].id == 2" class="step-content">
                    <table class="table">
                        <tbody>
                            <tr>
                                <th scope="row" style="width: 350px"><strong>Grau de Instrução: </strong></th>
                                <td>{{ items['education_level'] }}</td>
                            </tr>
                            <tr>
                                <th scope="row" style="width: 200px"><strong>Renda per Capita: </strong></th>
                                <td>{{ items['per_capita_income'] }}</td>
                            </tr>
                            <tr>
                                <th scope="row" style="width: 200px"><strong>Número de Habitantes: </strong></th>
                                <td>{{ items['number_of_inhabitants'] }}</td>
                            </tr>
                            <tr>
                                <th scope="row" style="width: 200px"><strong>Situação Laborativa: </strong></th>
                                <td>{{ items['work_status'] }}</td>
                            </tr>
                            <tr>
                                <th scope="row" style="width: 200px"><strong>Profissão: </strong></th>
                                <td>{{ items['profission'] }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div v-if="steps[currentStepIndex-1].id == 3" class="step-content">
                    <table class="table">
                        <tbody>
                            <tr>
                                <th scope="row" style="width: 350px"><strong>Portador da Doença de Chagas: </strong></th>
                                <td>{{ items['has_dc'] }}</td>
                            </tr>
                            <tr>
                                <th scope="row" style="width: 350px"><strong>Possui Sorologia: </strong></th>
                                <td>{{ items['has_serology'] }}</td>
                            </tr>
                            <tr>
                                <th scope="row" style="width: 200px"><strong>Doença de chagas na família: </strong></th>
                                <td>{{ items['dc_in_family'] }}</td>
                            </tr>
                            <tr>
                                <template v-if="items['dc_in_family'] == 'Sim'">
                                    <th scope="row" style="width: 200px"><strong>Quem:</strong></th>
                                    <td>{{ items['dc_in_family_who'] }}</td>
                                </template>
                            </tr>
                            <tr>
                                <th scope="row" style="width: 200px"><strong>Doença de Chagas na família (vivos/falecidos): </strong></th>
                                <td>{{ items['dc_in_family_vf'] }}</td>
                            </tr>
                            <tr>
                                <th scope="row" style="width: 200px"><strong>Conhece o vetor: </strong></th>
                                <td>{{ items['know_the_vector'] }}</td>
                            </tr>
                            <tr>
                                <th scope="row" style="width: 200px"><strong>Morou/Mora em casa de taipa: </strong></th>
                                <td>{{ items['lived_in_a_mud_house'] }}</td>
                            </tr>
                            <tr>
                                <th scope="row" style="width: 200px"><strong>Zona de moradia: </strong></th>
                                <td>{{ items['dwelling_area'] }}</td>
                            </tr>
                            <tr>
                                <template v-if="items['dwelling_area'] == 'Sim'">
                                    <th scope="row" style="width: 200px"><strong>Tempo de moradia na área rural (em anos)</strong></th>
                                    <td>{{ items['time_in_a_mud_house'] }}</td>
                                </template>
                            </tr>
                            <tr>
                                <th scope="row" style="width: 200px"><strong>Residência tem ou tinha criadouro: </strong></th>
                                <td>{{ items['has_breeding'] }}</td>
                            </tr>
                            <tr>
                                <th scope="row" style="width: 200px"><strong>Já doou sangue: </strong></th>
                                <td>{{ items['donated_blood'] }}</td>
                            </tr>
                            <tr>
                                <th scope="row" style="width: 200px"><strong>Já recebeu sangue: </strong></th>
                                <td>{{ items['received_blood'] }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div v-if="steps[currentStepIndex-1].id == 4" class="step-content">
                    <table class="table">
                        <tbody>
                            <tr>
                                <th scope="row" style="width: 350px"><strong>Peso: </strong></th>
                                <td>{{ items['weight'] }} kg</td>
                            </tr>
                            <tr>
                                <th scope="row" style="width: 200px"><strong>Altura: </strong></th>
                                <td>{{ items['height'] }} m</td>
                            </tr>
                            <tr>
                                <th scope="row" style="width: 200px"><strong>IMC: </strong></th>
                                <td>{{ items['imc'] }} kg/m²</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div v-if="steps[currentStepIndex-1].id == 5" class="step-content">
                    <table class="table">
                        <tbody>
                            <tr>
                                <th scope="row" style="width: 350px"><strong>Neoplasia: </strong></th>
                                <td>{{ items['neoplasm'] }}</td>
                            </tr>
                            <tr>
                                <th scope="row" style="width: 200px"><strong>História de sífilis e outras DST: </strong></th>
                                <td>{{ items['syphilis_history_dsts'] }}</td>
                            </tr>
                            <tr>
                                <template v-if="items['syphilis_history_dsts'] == 'Sim'">
                                    <th scope="row" style="width: 200px"><strong>Outros (especificar)</strong></th>
                                    <td>{{ items['others_dsts_explane'] }}</td>
                                </template>
                            </tr>
                            <tr>
                                <th scope="row" style="width: 200px"><strong>Hepatites virais: </strong></th>
                                <td>{{ items['viral_hepatitis'] }}</td>
                            </tr>
                            <tr>
                                <th scope="row" style="width: 200px"><strong>Hipertensão Arterial Sistêmica: </strong></th>
                                <td>{{ items['arterial_hypertension'] }}</td>
                            </tr>
                            <tr>
                                <th scope="row" style="width: 200px"><strong>Diabetes Mellitus: </strong></th>
                                <td>{{ items['diabetes_mellitus'] }}</td>
                            </tr>
                            <tr>
                                <th scope="row" style="width: 200px"><strong>Doença Arterial Coronariana: </strong></th>
                                <td>{{ items['coronary_disease'] }}</td>
                            </tr>
                            <tr>
                                <th scope="row" style="width: 200px"><strong>Dislipidemia: </strong></th>
                                <td>{{ items['dyslipidemia'] }}</td>
                            </tr>
                            <tr>
                                <th scope="row" style="width: 200px"><strong>Desordens Neuropsiquiátricas: </strong></th>
                                <td>{{ items['neuropsychiatric_disorders'] }}</td>
                            </tr>
                            <tr>
                                <template v-if="items['neuropsychiatric_disorders'] == 'Sim'">
                                    <th scope="row" style="width: 200px"><strong>Desordens Neuropsiquiátricas (esclarecimento): </strong></th>
                                    <td>{{ items['neuropsychiatric_disorders_explane'] }}</td>
                                </template>
                            </tr>
                            <tr>
                                <th scope="row" style="width: 200px"><strong>Tabagismo: </strong></th>
                                <td>{{ items['smoking'] }}</td>
                            </tr>
                            <tr>
                                <th scope="row" style="width: 200px"><strong>Etilismo: </strong></th>
                                <td>{{ items['alcoholism'] }}</td>
                            </tr>
                            <tr>
                                <th scope="row" style="width: 200px"><strong>Megaesôfago: </strong></th>
                                <td>{{ items['megaesophagus'] }}</td>
                            </tr>
                            <tr>
                                <th scope="row" style="width: 200px"><strong>Megacolón: </strong></th>
                                <td>{{ items['megacolon'] }}</td>
                            </tr>
                            <tr>
                                <th scope="row" style="width: 200px"><strong>Acidente Vascular Cerebral (AVC): </strong></th>
                                <td>{{ items['avc'] }}</td>
                            </tr>
                            <tr>
                                <th scope="row" style="width: 200px"><strong>Doença Pulmonar Obstrutiva Crônica: </strong></th>
                                <td>{{ items['chronic_lung_disease'] }}</td>
                            </tr>
                            <tr>
                                <th scope="row" style="width: 200px"><strong>Insuficiência Cardíaca: </strong></th>
                                <td>{{ items['cardiac_insufficiency'] }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div v-if="steps[currentStepIndex-1].id == 6" class="step-content">
                    <table class="table">
                        <tbody>
                            <tr>
                                <th scope="row" style="width: 350px"><strong>Radiografia do Toráx: </strong></th>
                                <td>{{ items['rx_chest'] }}</td>
                            </tr>
                            <tr>
                                <th scope="row" style="width: 200px"><strong>Radiografia do Esôfago: </strong></th>
                                <td>{{ items['rx_esophagus'] }}</td>
                            </tr>
                            <tr>
                                <th scope="row" style="width: 200px"><strong>Eletrocardiograma: </strong></th>
                                <td>{{ items['electrocardiogram'] }}</td>
                            </tr>
                            <tr>
                                <th scope="row" style="width: 350px"><strong>Marca-passo: </strong></th>
                                <td>{{ items['pacemaker'] }}</td>
                            </tr>
                            <tr>
                                <th scope="row" style="width: 200px"><strong>Transplante Cardíaco: </strong></th>
                                <td>{{ items['heart_transplantation'] }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div v-if="steps[currentStepIndex-1].id == 7" class="step-content">
                    <table class="table">
                        <tbody>
                            <tr>
                                <th scope="row" style="width: 350px"><strong>Uso de Benznidazol: </strong></th>
                                <td>{{ items['benznidazol'] }}</td>
                            </tr>
                            <template v-if="items['benznidazol'] != 'Não'">
                                <tr>
                                    <th scope="row" style="width: 200px"><strong>Ano de uso do Benznidazol: </strong></th>
                                    <td>{{ items['year_benznidazol'] }}</td>
                                </tr>
                                <tr>
                                    <th scope="row" style="width: 200px"><strong>Forma de apresentação: </strong></th>
                                    <td>{{ items['form_of_presentation'] }}</td>
                                </tr>
                                <tr>
                                    <th scope="row" style="width: 350px"><strong>Dosagem diária do tratamento: </strong></th>
                                    <td>{{ items['daily_dosage'] }} mg</td>
                                </tr>
                                <tr>
                                    <th scope="row" style="width: 200px"><strong>Tempo de uso: </strong></th>
                                    <td>{{ items['usage_time_benznidazol'] }} dias</td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>

                <div v-if="steps[currentStepIndex-1].id == 8" class="step-content">
                    <table class="table">
                        <tbody>
                            <tr>
                                <th scope="row" style="width: 450px"><strong>Diurético (Furosemida/Hidroclotiazida-HCTZ): </strong></th>
                                <td>{{ items['diuretic'] }}</td>
                            </tr>
                            <tr>
                                <th scope="row" style="width: 200px"><strong>Bloqueador (Carvedilol/Metroprol/Bisoprol): </strong></th>
                                <td>{{ items['blocker'] }}</td>
                            </tr>
                            <tr>
                                <th scope="row" style="width: 200px"><strong>Inibidor da Enzima Conversora de Angiotensina</strong></th>
                                <td>{{ items['angiotensin_inhibitor'] }}</td>
                            </tr>
                            <tr>
                                <th scope="row" style="width: 200px"><strong>Amiodarona (Ancoron): </strong></th>
                                <td>{{ items['amiodarone'] }}</td>
                            </tr>
                            <tr>
                                <template v-if="items['amiodarone'] == 'Sim'">
                                    <th scope="row" style="width: 200px"><strong>Tempo de uso de Amiodarona: </strong></th>
                                    <td>{{ items['usage_time_amidarone'] }} anos</td>
                                </template>
                            </tr>
                            <tr>
                                <th scope="row" style="width: 200px"><strong>Estatinas: </strong></th>
                                <td>{{ items['statins'] }}</td>
                            </tr>
                            <tr>
                                <th scope="row" style="width: 200px"><strong>Espíronolactona (Aldactone): </strong></th>
                                <td>{{ items['spironolactone'] }}</td>
                            </tr>
                            <tr>
                                <template v-if="items['spironolactone'] == 'Sim'">
                                    <th scope="row" style="width: 200px"><strong>Tempo de uso de Espíronolactona: </strong></th>
                                    <td>{{ items['usage_time_spironolactone'] }} anos</td>
                                </template>
                            </tr>
                            <tr>
                                <th scope="row" style="width: 200px"><strong>Hipoglicemiantes: </strong></th>
                                <td>{{ items['hypoglycemics'] }}</td>
                            </tr>
                            <tr>
                                <th scope="row" style="width: 200px"><strong>Benzodiazepinicos: </strong></th>
                                <td>{{ items['benzodiazepines'] }}</td>
                            </tr>
                            <tr>
                                <th scope="row" style="width: 200px"><strong>AAS: </strong></th>
                                <td>{{ items['aas'] }}</td>
                            </tr>
                            <tr>
                                <th scope="row" style="width: 200px"><strong>Hidralazina: </strong></th>
                                <td>{{ items['hydralazine'] }}</td>
                            </tr>
                            <tr>
                                <th scope="row" style="width: 200px"><strong>Levotiroxina Sódica: </strong></th>
                                <td>{{ items['levothyroxine_sodium'] }}</td>
                            </tr>
                            <tr>
                                <th scope="row" style="width: 200px"><strong>Anlodipino: </strong></th>
                                <td>{{ items['anlodipine'] }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </b-card>
    </div>
</template>

<script>
import TitleStep from '../components/TitleStep';

export default {
    props: {
        id: String,
        view: {
            type: Boolean,
            default: false,
        }
    },

    components: {
        TitleStep,
    },

    data() {
        return {
            role: '',
            isLoading: true,
            currentStepIndex: 1,
            steps: [
                {"id": 1, "label":"Dados de Identificação","completed":false,"inProcessing":false,"error":false},
                {"id": 2, "label":"Dados Socioeconômicos","completed":false,"inProcessing":false,"error":false},
                {"id": 3, "label":"Dados Epidemológicos","completed":false,"inProcessing":false,"error":false},
                {"id": 4, "label":"Dados Antropomédicos","completed":false,"inProcessing":false,"error":false},
                {"id": 5, "label":"Antecedentes Pessoais","completed":false,"inProcessing":false,"error":false},
                {"id": 6, "label":"Exames e Procedimentos","completed":false,"inProcessing":false,"error":false},
                {"id": 7, "label":"Benznidazol","completed":false,"inProcessing":false,"error":false},
                {"id": 8, "label":"Medicamentos em Uso","completed":false,"inProcessing":false,"error":false},
            ],
            items: [],
        };
    },

    mounted(){
        axios.get('/user/role').then((response) => {
            this.role = response.data;
        }).catch((error) => console.log("error"));

        this.getItems();
    },

    methods: {
        getItems(){
            this.isLoading = true;

            if (!this.view){
                axios.get(`/prontuary/get/${this.steps[this.currentStepIndex-1].id}`).then((response) => {
                    let items = response.data;
                    this.items = items[0][0];
                    this.isLoading = false;
                }).catch((error) => console.log(`${error}, elocode: 104`));
            } else {
                axios.get(`/prontuary/${this.id}/view/${this.steps[this.currentStepIndex-1].id}`).then((response) => {
                    let items = response.data;
                    this.items = items[0][0];
                    this.isLoading = false;
                }).catch((error) => console.log(`${error}, elocode: 104`));
            }
            
        }
    },

    computed: {
        getBirthDate(){
            let data = new Date(this.items['birth_date'])
            return (data.getDate()+1) + "/" + ("00" + ((data.getMonth() + 1))).slice(-2) + "/" + data.getFullYear()
        }
    },

    watch: {
        currentStepIndex: function(){
            this.getItems();
        }
    },
};
</script>

<style lang="scss" scoped>
.step-content{
    line-height: 30px;
}
</style>