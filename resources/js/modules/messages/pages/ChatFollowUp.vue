<template>
    <div>
        <header-title 
            :title="`Acompanhamento`"
            :subtitle="`Paciente: ${patient}`"
        ></header-title>

        <chat :title="patient" :id="parseInt(id)"/>
    </div>
</template>

<script>
import Chat from '../../messages/components/Chat';

export default {
    components: {
        Chat,
    },

    data() {
        return {
            id: null,
            patient: '',
        };
    },
    
    beforeMount(){
        document.title = `Acompanhamento - Elo Chagas`;
    },

    mounted(){
        axios.get(`/user/get/${this.$route.params.id}`).then((response) => {
            this.patient = response.data;
            this.id = this.$route.params.chat;
        }).catch(error => console.log('Error'));
    }
};
</script>
