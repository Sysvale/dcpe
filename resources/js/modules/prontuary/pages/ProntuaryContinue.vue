<template>
    <div>
        <div v-if="isLoading" class="spinner-loading">
            <b-spinner variant="primary" label="Spinning"></b-spinner>
        </div>
        <div v-else>
            <title-step
                :title="steps[currentStep].label"
                :button="buttonState"
                :variant="buttonVariant"
            />

            <div v-if="$route.params.step-1 == 0"><step-1 @save="saveModifield" @progress="formProgress"/></div>
            <div v-if="$route.params.step-1 == 1"><step-2 @save="saveModifield" @progress="formProgress"/></div>
            <div v-if="$route.params.step-1 == 2"><step-3 @save="saveModifield" @progress="formProgress"/></div>
            <div v-if="$route.params.step-1 == 3"><step-4 @save="saveModifield" @progress="formProgress"/></div>
            <div v-if="$route.params.step-1 == 4"><step-5 @save="saveModifield" @progress="formProgress"/></div>
            <div v-if="$route.params.step-1 == 5"><step-6 @save="saveModifield" @progress="formProgress"/></div>
            <div v-if="$route.params.step-1 == 6"><step-7 @save="saveModifield" @progress="formProgress"/></div>
            <div v-if="$route.params.step-1 == 7"><step-8 @save="saveModifield" @progress="formProgress"/></div>

            <div class="adflex">
                <div>
                    <b-button variant="dark" @click="$router.push({ name: 'prontuary' })">Cancelar</b-button>
                    <b-button v-if="$route.params.step != 1" variant="secondary" @click="nextStep(2)">Voltar</b-button>
                </div>
                <div>
                    <b-button v-if="$route.params.step == 8" variant="success" @click="finish" :disabled="isCompleted">Finalizar</b-button>
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
        isCompleted: {
            type: Boolean,
            require: true,
        },
    },

    data(){
        return {
            isLoading: true,
            currentStep: 0,
            buttonState: 'Salvo',
            buttonVariant: 'success',
        };
    },

    beforeRouteUpdate(to, from, next){
        this.currentStep = to.params.step-1;
        next();
    },

    mounted(){
        this.currentStep = this.$route.params.step-1;
        this.completedSteps2 = this.completedSteps;
        this.nextStep(0);
        
        setTimeout(() => {
            this.isLoading = false;
        }, 300);
    },

    methods: {
        saveModifield(inputs){
            this.buttonState = 'Salvando...';

            axios.post('/prontuary/add', {
                form: inputs,
            }).then(() => {
                this.buttonState = 'Salvo';
                this.buttonVariant = 'success';
            }).catch((error) => {
                console.log(`${error}, elocode: 100`);
                this.buttonState = ' Erro';
                this.buttonVariant = 'danger';
            });
        },

        formProgress(id, status){
            // manda para o paizão o estado atual do form (atualiza o stepper)
            this.$emit('progress', id, status);
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
            axios.post('/prontuary/finish').then(() => {
                this.isLoading = true;
                setTimeout(() => {
                    this.$router.push({ name: 'prontuary'});
                    this.$router.go();
                    this.isLoading = false;
                }, 300);
            }).catch((error) => {
                console.log(`${error}, elocode: 103`);
            });
        },
    },
};
</script>

<style lang="scss" scoped>
.adflex{
    margin: 15px 0px;
    display: flex;
    justify-content: space-between;
}
</style>

<style lang="scss">
.spinner-loading{
    display: flex;
    justify-content: center;
    margin: 30px 0px;
}

option {
    margin: 5px 0px;
}
.set-display{
    display: flex;

    .icon-tooltip {
        margin: 3px 0px 0px 3px;
        color: #3A7EDF;
    }
}
</style>