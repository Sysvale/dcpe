<template>
    <div>
        <h4 style="margin: 30px 0 30px 0">Solicitações</h4>

        <div v-if="patients.length == 0">
            <b-alert variant="success" show>
                Nenhuma solicitação encontrada.
            </b-alert>
        </div>
        <div v-else>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Data</th>
                        <th scope="col">Nome</th>
                        <th scope="col"><center>Ações</center></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="{ id_user, name, date } in patients" :key="id_user">
                        <td width="170">{{ date }}</td>
                        <td>{{ name }}</td>
                        <td width="200"><center>
                            <b-button 
                                variant="primary" 
                                @click="$router.push({ path: `/prontuary/${id_user}/view` })" 
                                v-b-tooltip.hover title="Prontuário do paciente"><file-text-icon size="1x" class="custom-class"></file-text-icon></b-button>
                            <b-button variant="success" @click="acceptRequest(id_user)" v-b-tooltip.hover title="Acompanhar paciente"><check-icon size="1x" class="custom-class"></check-icon></b-button>
                        </center></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
import { FileTextIcon, CheckIcon } from 'vue-feather-icons';

export default {
    components: { 
        FileTextIcon,
        CheckIcon,
    },

    data(){
        return {
            patients: [],
        };
    },
    
    beforeMount(){
        document.title = `Solicitações de Acompanhamento - Elo Chagas`;
    },

    mounted(){
        this.getRequests();
    },

    methods: {
        acceptRequest(id_user){
            axios.post('/user/follow-up/accept', {
                user: id_user,
            }).then(() => {
                this.getRequests();
            }).catch(error => console.log('error'));
        },

        getRequests(){
            // verificar pacientes que requisitaram acompanhamento
            axios.get('/professional/follow-up/requests').then(response => {
                this.patients = response.data;
            }).catch(error => console.log('error'));
        }
    }
};
</script>
