<template>
    <div class="content">
        <header-title title="Caixa de Entrada" subtitle=""/>
        <div v-for="{ id, coverMessage, nameMessage, shortMessage, numMsg } in items" :key="id">
            <card-message 
                :id="id"
                :cover="coverMessage"
                :name="nameMessage"
                :short="shortMessage"
                :badge="numMsg"
            />
        </div>
        <router-view v-on:updateBadge="updateCardMessage"/>
    </div>
</template>

<script> 
import axios from 'axios';
import CardMessage from '../components/CardMessage';
import HeaderTitle from '../../../core/common/HeaderTitle';

export default {
    components: {
        CardMessage,
        HeaderTitle,
    },

    data(){
        return {
            items: [
                { 
                    id: 0,
                    coverMessage: '/storage/images/saude-mental.png',
                    nameMessage: 'Dúvidas',
                    shortMessage: 'Tire suas dúvidas com profissionais da área',                
                    numMsg: 2,
                },
                { 
                    id: 1,
                    coverMessage: '/storage/images/cuidados-de-saude.png',
                    nameMessage: 'Acompanhamento',
                    shortMessage: 'Solicite acompanhamento (para portadores de Chagas)',                
                    numMsg: 6,
                },
            ]
        };
    },

    beforeMount(){
        this.updateCardMessage();
        document.title = `${this.$route.meta.alias} - Elo Chagas`;
    },

    methods: {
        updateCardMessage(){
            axios.get('/user/doubts')
            .then( response => {
                let count = 0;
                
                for(let key = 0; key < response.data.length; key++){
                    if (response.data[key]['status'] == 'answered' &&
                        response.data[key]['read'] == false)
                        count++;
                }
                this.items[0].numMsg = count;
            }); 
        }
    }
};
</script>

<style lang="scss" scoped>
.content {
    padding: 20px 0px;
}
.actived-card {
    color: rgb(53, 52, 52);
}
</style>