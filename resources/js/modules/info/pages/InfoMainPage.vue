<template>
    <div>
        <header-title 
            :title="'Informações'"
        ></header-title>

        <div v-if="!isLoading" role="tablist" style="margin-bottom: 50px;">
            <div v-if="role == 'patient'">
                <b-card no-body class="mb-1" v-for="{id, title, resume, text, cover} in info" :key="id">
                    <card-infor
                        :id="id"
                        :title="title"
                        :resume="resume"
                        :text="text"
                        :cover="cover"
                    />
                </b-card>
            </div>
            <div v-if="role == 'professional'">
                <b-card no-body class="mb-1" v-for="{id, title, resume, text, cover} in infoP" :key="id">
                    <card-infor
                        :id="id"
                        :title="title"
                        :resume="resume"
                        :text="text"
                        :cover="cover"
                    />
                </b-card>
            </div>
        </div>
        <div v-else class="spinner-loading">
            <b-spinner variant="success" label="Spinning"></b-spinner>
        </div>
    </div>
</template>

<script> 
import HeaderTitle from '../../../core/common/HeaderTitle';
import CardInfor from '../components/CardInfo';
import Informations from '../informations';
import InformationsProfessional from '../informationsProfessional';

export default {
    components: {
        HeaderTitle,
        CardInfor,
    },

    data(){
        return {
            role: '',
            isLoading: true,
            info: Informations,
            infoP: InformationsProfessional,
        };
    },

    beforeMount(){
        document.title = `${this.$route.meta.alias} - Elo Chagas`;
    },

    mounted(){
        axios.get('/user/role').then((response) => {
            this.role = response.data;
            this.isLoading = false;
        }).catch((error) => console.log("error"));
    }
};
</script>

<style lang="scss" scoped>
.spinner-loading{
    display: flex;
    justify-content: center;
    margin-top: 70px;
}
</style>