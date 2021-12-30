<template>
    <div class="content">
        <header-title title="Caixa de Entrada" subtitle=""/>
        <div v-if="isLoading" class="spinner-loading">
            <b-spinner variant="primary" label="Spinning"></b-spinner>
        </div>
        <div v-else>
            <div v-if="role == 'patient'">
                <div v-for="{ id, coverMessage, nameMessage, shortMessage, numMsg } in items" :key="id">
                    <card-message 
                        :role="role"
                        :id="id.toString()"
                        :cover="coverMessage"
                        :name="nameMessage"
                        :short="shortMessage"
                        :badge="numMsg"
                        :enable="user.hasDc"
                    />
                </div>
            </div>

            <div v-else v-for="{ id, coverMessage, nameMessage, shortMessage, numMsg } in itemsProfessional" :key="id">
                <card-message 
                    :role="role"
                    :id="id.toString()"
                    :cover="coverMessage"
                    :name="nameMessage"
                    :short="shortMessage"
                    :badge="numMsg"
                    :enable="user.hasDc"
                />
            </div>

        </div>
        <router-view :updateBadge="updateCardMessage"/>
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
            role: '',
            isLoading: true,
            user: {
                hasDc: false,
            },
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
            ],
            itemsProfessional: [
                { 
                    id: 0,
                    coverMessage: '/storage/images/checar.png',
                    nameMessage: 'Responder dúvidas',
                    shortMessage: 'Responda perguntas de pacientes',                
                    numMsg: 2,
                },
                { 
                    id: 1,
                    coverMessage: '/storage/images/cuidados-de-saude2.png',
                    nameMessage: 'Acompanhamento',
                    shortMessage: 'Acompanhe um paciente portador da Doença de Chagas',                
                    numMsg: 6,
                },
            ],
        };
    },

    beforeMount(){
        this.updateCardMessage();
        document.title = `${this.$route.meta.alias} - Elo Chagas`;
    },

    mounted(){
        axios.get('/user/role').then((response) => {
            this.role = response.data;
        }).catch((error) => console.log("error"));

        axios.get('/prontuary/get/3').then((response) => {
            let items = response.data;
            if (typeof(items[0][0]) != "undefined")
                this.user.hasDc = (items[0][0]['has_dc'] == 'Sim');
            this.isLoading = false;
        });
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
.spinner-loading{
    display: flex;
    justify-content: center;
    margin: 30px 0px;
}
</style>