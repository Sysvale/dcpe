<template>
    <div>
        <div v-if="isLoading" class="spinner-loading">
            <b-spinner variant="primary" label="Spinning"></b-spinner>
        </div>
        <div v-else>
            <title-step
                :title="steps[currentStep].label"
                :button="buttonState"
            />

            <div v-if="$route.params.step-1 == 0"><step-1 @sendState="updateState"/></div>
            <div v-if="$route.params.step-1 == 1"><step-2 @sendState="updateState"/></div>
            <div v-if="$route.params.step-1 == 2"><step-3 @sendState="updateState"/></div>
            <div v-if="$route.params.step-1 == 3"><step-4 @sendState="updateState"/></div>
            <div v-if="$route.params.step-1 == 4"><step-5 @sendState="updateState"/></div>
            <div v-if="$route.params.step-1 == 5"><step-6 @sendState="updateState"/></div>
            <div v-if="$route.params.step-1 == 6"><step-7 @sendState="updateState"/></div>
            <div v-if="$route.params.step-1 == 7"><step-8 @sendState="updateState"/></div>

            <div class="adflex">
                <div>
                    <b-button variant="dark" @click="$router.push({ name: 'prontuary' })">Cancelar</b-button>
                    <b-button v-if="$route.params.step != 1" variant="secondary" @click="nextStep(2)">Voltar</b-button>
                </div>
                <div>
                    <b-button v-if="$route.params.step == 8" variant="success" @click="finish" :disabled="isReady">Finalizar</b-button>
                    <b-button v-else variant="primary" @click="nextStep(1)">Próximo</b-button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { Step1, Step2, Step3, Step4, Step5, Step6, Step7, Step8, TitleStep } from '../components/';

export default {
    components: {
        TitleStep,
        Step1,
        Step2,
        Step3,
        Step4, 
        Step5,
        Step6,
        Step7,
        Step8,
    },

    props: {
        steps: {
            type: Array,
            require: true,
        },
    },

    data(){
        return {
            isLoading: true,
            isReady: true,
            completedSteps: [],
            currentStep: 0,
            buttonState: 'Salvo',
        };
    },

    beforeRouteUpdate(to, from, next){
        this.currentStep = to.params.step-1;
        next();
    },

    mounted(){
        this.currentStep = this.$route.params.step-1;
        this.nextStep(0);
        this.getStates();
        
        setTimeout(() => {
            this.isLoading = false;
        }, 300);
    },

    methods: {
        updateState(form, items, progressActual){
            this.buttonState = 'Salvando...',
            setTimeout(()=>{
                let count = 0;
                
                try {
                    for(let item in form)
                        if (form[item] != '' && !Array.isArray(form[item])) count++;
                } catch (error){ 
                    console.log("updteState: "+error);
                    this.buttonState = 'Erro';
                } 

                let progress = count*100/(items?items:1);
                console.log(progress+'%', count, items);

                // envia para o banco
                this.saveModifield(form, this.currentStep+1, this.completedSteps, progress); // data, current form
                
                if (progress == 100){
                    // this.verifyContainsCompletedSteps(1); // adiciona
                    this.$emit('updateStateStep', this.completedSteps);
                } else {
                    // this.verifyContainsCompletedSteps(0); // remove
                    this.$emit('updateStateStep', this.completedSteps);
                }

                this.buttonState = 'Salvo';
            }, 500);
        },

        verifyContainsCompletedSteps(action){
            if (action === 0){
                if(this.completedSteps.includes(this.currentStep)){
                    let index = this.completedSteps.indexOf(this.currentStep);
                    this.completedSteps.splice(index ,1);
                }
            } else {
                if(!this.completedSteps.includes(this.currentStep)){
                    this.completedSteps.push(this.currentStep);
                }
            }
        },

        nextStep(value){
            this.isLoading = true;

            if (value == 0) // atualiza para o atual
                this.$emit('nextStep', this.$route.params.step);
            else if(value == 2) // volta
                this.$emit('nextStep', --this.$route.params.step);
            else // atualiza para o próximo
                this.$emit('nextStep', ++this.$route.params.step);
            
            setTimeout(() => {
                this.isLoading = false;
            }, 200);
        },

        finish(){
            console.log('finalizar');
        },

        saveModifield(values, current, completed, progress){
            axios.post('/prontuary/add', {
                data: values,
                form: current,
                steps: completed,
                progressForm: progress,
            }).then((response) => {
                console.log(response.data);
            }).catch((error) => {
                console.log(`saveModifield: ${error}`);
            });
        },

        getStates(){
            axios.get('/prontuary/getStates').then((response) => {
                this.completedSteps = response.data;
                console.log("é isso: "+this.completedSteps)
            }).catch((error) => console.log("getStates: "+error));
        }
    },

    watch: {
        completedSteps: function(){
            console.log(this.completedSteps.length);
            if (this.completedSteps.length-1 == 8)
                this.isReady = false;
        },
    }
};
</script>

<style lang="scss" scoped>
.spinner-loading{
    display: flex;
    justify-content: center;
    margin: 30px 0px;
}

.adflex{
    margin: 15px 0px;
    display: flex;
    justify-content: space-between;
}
</style>

<style lang="scss">
option {
    margin: 5px 0px;
}
</style>