<template>
    <div>
        <h4 style="margin: 30px 0 30px 0">Dúvidas em aberto</h4>
        <div v-for="{ id_doubt, id_user, name, message, created_at } in doubts" :key="id_doubt">
            <b-card no-body class="mb-1">
                <card-question
                    :id="id_doubt"
                    :idUser="id_user"
                    :name="name"
                    :message="message"
                    :time="created_at"
                    @update="updateList"
                />
            </b-card>
        </div>
    </div>
</template>

<script>
import CardQuestion from './CardQuestion.vue';

export default {
    components: { CardQuestion },

    data() {
        return {
            doubts: [],
        };
    },

    beforeMount(){
        document.title = `Dúvidas em Aberto - Elo Chagas`;
    },

    mounted(){
        this.updateList();
    },

    methods: {
        updateList(){
            axios.get('/user/doubts/unread').then((response) => {
                this.doubts = response.data;
                console.log("re: ",response.data);
            }).catch((error) => console.log('Error'));
        }
    }
};
</script>
