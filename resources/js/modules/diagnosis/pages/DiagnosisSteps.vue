<template>
    <div>
        <div v-for="{ id, step, question, options, tooltip } in questions" :key="id">
            <ul v-if="step == $route.params.step">
                <li>{{ id }}</li>
                <li>{{ question }}</li>
                <li>
                    <ol>
                        <li v-for="{ answer } in options" :key="answer">{{ answer }}</li>
                    </ol>
                </li>
                <li>{{ tooltip }}</li>
            </ul>
        </div>
        <div v-if="$route.params.step == 1" class="buttons">
            <b-button variant="secondary" @click="$router.push({ name: 'diagnosis.init' })">Cancelar</b-button>
            <b-button variant="primary" @click="$router.push({ name: 'diagnosis.step', params: { step: ++$route.params.step } })">Avançar</b-button>
        </div>
        <div v-else class="buttons">
            <b-button variant="secondary" @click="$router.push({ name: 'diagnosis.init' })">Cancelar</b-button>
            <div>
                <b-button variant="secondary" @click="$router.go(-1)">Voltar</b-button>
                <b-button variant="primary" @click="$router.push({ name: 'diagnosis.step', params: { step: ++$route.params.step } })">Avançar</b-button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        questions: {
            type: Array,
            require: true,
        },
    },

    data(){
        return {};
    }
};
</script>

<style lang="scss" scoped>
.buttons {
    display: flex; 
    justify-content: space-between;
}
</style>