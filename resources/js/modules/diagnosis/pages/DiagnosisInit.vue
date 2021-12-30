<template>
    <div>
         <b-card bg-variant="light" text-variant="black" title="Por que responder este questionário?">
            <b-card-text>
                Em muitos casos, a Doença de Chagas é descoberta de forma inusitada. Seja ela em um exame de sangue, 
                doação de órgãos ou até mesmo em um acidente de trânsito. A Doença de Chagas na sua fase aguda, pode passar despercebida.
                Por esse motivo, o questionário vai te dizer se você deve ou não fazer um teste. Pois, se portador da Doença,
                quanto mais cedo descobrir, mais cedo será o tratamento e menor será o risco de evoluir a doença para sua fase
                crônica (que é a fase mais delicada da doença).
            </b-card-text>
            <b-button @click="$router.push({ name: 'diagnosis.step', params: { step: 1 } })" variant="primary">Responder agora</b-button>
        </b-card>
    </div>
</template>

<script>

export default {
    data() {
        return {};
    },
};
</script>
