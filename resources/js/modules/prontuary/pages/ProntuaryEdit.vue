<template>
    <div>
        <div v-if="this.$route.params.id == 1">
            <title-step
                :title="'Dados de Identificação'"
                :button="buttonState"
                :variant="buttonVariant"
            />
            <step-1 @save="saveModifield"/>
        </div>

        <div v-if="this.$route.params.id == 2">
            <title-step
                :title="'Dados Socioeconômicos'"
                :button="buttonState"
                :variant="buttonVariant"
            />
            <step-2 @save="saveModifield"/>
        </div>

        <div v-if="this.$route.params.id == 3">
            <title-step
                :title="'Dados Epidemológicos'"
                :button="buttonState"
                :variant="buttonVariant"
            />
            <step-3 @save="saveModifield"/>
        </div>

        <div v-if="this.$route.params.id == 4">
            <title-step
                :title="'Dados Antropomédicos'"
                :button="buttonState"
                :variant="buttonVariant"
            />
            <step-4 @save="saveModifield"/>
        </div>

        <div v-if="this.$route.params.id == 5">
            <title-step
                :title="'Antecedentes Pessoais'"
                :button="buttonState"
                :variant="buttonVariant"
            />
            <step-5 @save="saveModifield"/>
        </div>

        <div v-if="this.$route.params.id == 6">
            <title-step
                :title="'Exames e Procedimentos'"
                :button="buttonState"
                :variant="buttonVariant"
            />
            <step-6 @save="saveModifield"/>
        </div>

        <div v-if="this.$route.params.id == 7">
            <title-step
                :title="'Benznidazol'"
                :button="buttonState"
                :variant="buttonVariant"
            />
            <step-7 @save="saveModifield"/>
        </div>

        <div v-if="this.$route.params.id == 8">
            <title-step
                :title="'Medicamentos em Uso'"
                :button="buttonState"
                :variant="buttonVariant"
            />
            <step-8 @save="saveModifield"/>
        </div>

        <div style="margin: 40px 0px;">
            <b-button variant="secondary" @click="goBack()">Voltar</b-button>
        </div>
    </div>
</template>

<script>
import {
    Step1, Step2, Step3, Step4, Step5, Step6, Step7, Step8,
    TitleStep,
} from '../components';

export default {
    components: {
        Step1, Step2, Step3, Step4, Step5, Step6, Step7, Step8,
        TitleStep,
    },

    data(){
        return {
            buttonState: 'Salvo',
            buttonVariant: 'success',
        };
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

        goBack(){
            setTimeout(() => {
                this.$router.go(-1);
            }, 200);
        }
    },
};
</script>
