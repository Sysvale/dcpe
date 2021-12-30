<template>
    <div>
        <header-title
            :title="'Autodiagnóstico'"
            :subtitle="`O autodiagnóstico não garante nada, apenas fornece a necessidade de fazer uma 
            testagem para Doença de Chagas.`"
            :hasTooltip="true"
            :tooltip="'Cada pergunta possui um peso, e com base nas respostas uma nota será dada.'"
        />
        <router-view :questions="questions"/>        
    </div>
</template>

<script> 
import HeaderTitle from '../../../core/common/HeaderTitle';

export default {
    components: {
        HeaderTitle,
    },

    data(){
        return {
            questions: [
                {
                    id: 1,
                    step: 1,
                    question: 'Na sua família existe algum registro de Doença de Chagas?',
                    options: [
                        { answer: 'Não', weight: 0 },
                        { answer: 'Sim', weight: 1 },
                        { answer: 'Não sabe informar', weight: 0 },
                    ],
                    tooltip: 'Se alguém (vivo/falecido) da família é/foi portador(a) da Doença de Chagas'
                },
                {
                    id: 2,
                    step: 2,
                    question: 'Você conhece o vetor?',
                    options: [
                        { answer: 'Não', weight: 1 },
                        { answer: 'Sim', weight: 0 },
                        { answer: 'Não sabe informar', weight: 1 },
                    ],
                    tooltip: 'Vetor: organismo que serve de veículo para a transmissão de algum causador de doença. Na doença de chagas é o inseto triatomíneo (barbeiro)',
                }
            ],
            // total de perguntas: 7
            // se respostas >= 5 -> recomendação alta para fazer o teste
            // se respostas > 3 e respostas < 5 -> recomendação média para fazer o teste
            // se respostas <= 3 -> recomendação baixa para fazer o teste
            // 1 -Na sua família existe algum registro de Doença de Chagas? (tooltip)
            // Sim, não, não sabe informar

            // 2 - Você conhece o vetor? (tooltip)
            // Sim, não, não sabe informar

            // 3 - Qual a sua zona de moradia? (tooltip)
            // Zona rual, zona urbana

            // 4 - Você já morou/mora em casa de taipa? (tooltip)
            // Sim, não, não sabe informar

            // 5 - Na sua residência tem/tinha criadouro? (tooltip)
            // Sim, não, não sabe informar

            // 6 - Você já doou sangue? 
            // Sim, não, não sabe informar

            // 7 - Você já recebeu sangue (transfusão sanguínea)? 
            // Sim, não, não sabe informar

            // 8 - 
        };
    },

    beforeMount(){
        document.title = `${this.$route.meta.alias} - Elo Chagas`;
    },
};
</script>
