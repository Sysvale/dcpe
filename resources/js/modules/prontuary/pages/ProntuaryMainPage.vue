<template>
    <div>
        <div v-if="$route.name == 'prontuary.edit'">
            <header-title 
                :title="'Editar Prontuário'"
                :subtitle="'Os dados serão salvos automaticamente.'"
            ></header-title>
            <prontuary-edit/>
        </div>
        <div v-else>
            <div v-if="profileCompleted">
                <header-title 
                    :title="'Meu Prontuário'"
                    :subtitle="'Prontuário eletrônico'"
                ></header-title>
                <!-- prontuário pronto aqui  -->
                <my-prontuary/>
            </div>
            <div v-else>            
                <div v-if="$route.name == 'prontuary.step'">
                    <header-title 
                        :title="'Complete seu prontuário'"
                        :subtitle="'Os dados serão salvos automaticamente'"
                    ></header-title>
                    <div class="stepper-pos">
                        <cds-stepper
                            v-model="currentStepIndex"
                            :steps="steps"
                        />
                    </div>
                    <b-card style="margin-bottom: 50px;">
                        <router-view :isCompleted="prontuaryIsCompleted" :steps="steps" @progress="updateFormProgress" @nextStep="updateStep"/>
                    </b-card>
                </div>
                <div v-else id="actions-buttons">
                    <header-title 
                        :title="'Meu Prontuário'"
                    ></header-title>
                    <div class="card-not-completed">
                        <b-img class="card-cover" src="/storage/images/relatorio-medico.png" fluid></b-img>
                        <h3>Ops, parece que você ainda não concluiu seu prontuário</h3>
                        <p>Termine agora de preencher seu prontuário</p>
                        <b-button variant="success" @click="$router.push({ name: 'prontuary.step', params: { step: 1 }})">Prencher Prontuário</b-button>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</template>

<script> 
import MyProntuary from './MyProntuary';
import ProntuaryEdit from './ProntuaryEdit';

export default {
    components: {
        MyProntuary,
        ProntuaryEdit,
    },

    data(){
        return {
            isLoading: true,
            profileCompleted: false, // pegar do banco de dados
            currentStepIndex: 1,
            completedSteps: [],
            prontuaryIsCompleted: true,
            steps: [
                {"label":"Dados de Identificação","completed":false,"inProcessing":false,"error":false},
                {"label":"Dados Socioeconômicos","completed":false,"inProcessing":false,"error":false},
                {"label":"Dados Epidemológicos","completed":false,"inProcessing":false,"error":false},
                {"label":"Dados Antropomédicos","completed":false,"inProcessing":false,"error":false},
                {"label":"Antecedentes Pessoais","completed":false,"inProcessing":false,"error":false},
                {"label":"Exames e Procedimentos","completed":false,"inProcessing":false,"error":false},
                {"label":"Benznidazol","completed":false,"inProcessing":false,"error":false},
                {"label":"Medicamentos em Uso","completed":false,"inProcessing":false,"error":false},
            ],
        };
    },

    beforeMount(){
        document.title = `${this.$route.meta.alias} - Elo Chagas`;
        this.isLoading = false;
    },

    mounted(){
        this.updateStep(this.$route.params.step);

        // verifica se o prontuário já foi todo preenchido
        axios.get('/prontuary/get/0').then((response) => {
            let prontuaryStatus = response.data[0][0].status;
            this.profileCompleted = (prontuaryStatus == 'completed');
        }).catch((error) => { console.log(`${error} code: 102`) });

        // pega todos os estados dos forms do prontuário (completed, progress)
        for(let item = 1; item <= this.steps.length; item++){
            axios.get(`/prontuary/get/${item}`).then((response) => {
                let items = response.data[0][0];
                this.updateFormProgress(item, items.status);
            }).catch((error) => console.log(`${error} code: 102`));
        }
    },

    methods: {
        updateStep(step){
            this.currentStepIndex = parseInt(step, 10);
        },

        updateFormProgress(id, status){
            if (status == 'completed'){
                this.updateCompletedSteps(1, id);
                this.steps[id-1].completed = true;
                this.steps[id-1].inProcessing = false;
            } else if (status == 'inProgress'){
                this.updateCompletedSteps(0, id);
                this.steps[id-1].completed = false;
                this.steps[id-1].inProcessing = true;
            } else {
                this.steps[id-1].completed = false;
                this.steps[id-1].inProcessing = false;
            }
        },

        updateCompletedSteps(action, id){
            if (action === 0){
                if(this.completedSteps.includes(id)){
                    let index = this.completedSteps.indexOf(id);
                    this.completedSteps.splice(index ,1);
                }
            } else {
                if(!this.completedSteps.includes(id)){
                    this.completedSteps.push(id);
                }
            }
            this.prontuaryIsCompleted = !(this.completedSteps.length == 8);
        },
    },

    watch: {
        currentStepIndex: function(){
            this.isLoading = true;

            if (this.currentStepIndex <= 8)
                this.$router.push({ name: 'prontuary.step', params: { step: this.currentStepIndex, }});
            
            setTimeout(() => {
                this.isLoading = false;
            }, 200);
        },
    },

};
</script>

<style lang="scss" scoped>
.spinner-loading{
    display: flex;
    justify-content: center;
    margin-top: 30px;
}

.card-not-completed {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    margin-top: 50px;

    .card-cover {
        width: 350px;
        margin-bottom: 15px;
    }
}
</style>

<style lang="scss">
.stepper-pos {
    margin: 50px 0px;
}
</style>