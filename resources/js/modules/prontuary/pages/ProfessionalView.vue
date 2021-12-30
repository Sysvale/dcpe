<template>
    <div>
        <header-title 
            :title="`Paciente: ${ patient }`"
        />
        <my-prontuary 
            :id="$route.params.id"
            :view="true"
        />
    </div>
</template>

<script>
import MyProntuary from './MyProntuary';
import HeaderTitle from '../../../core/common/HeaderTitle';

export default {
    components: { MyProntuary, HeaderTitle },

    data() {
        return {
            patient: '',
        };
    },

    beforeMount(){
        document.title = `${this.$route.meta.alias} - Elo Chagas`;
    },

    mounted(){
        axios.get(`/user/get/${this.$route.params.id}`).then(response => {
            this.patient = response.data;
        }).catch((error) => console.log("Error"));
    }

};
</script>
