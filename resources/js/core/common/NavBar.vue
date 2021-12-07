<template>
    <div class="container-nav">
        <b-navbar toggleable="lg" type="light" variant="light">
            <b-navbar-brand>
                <router-link to="">
                    <img class="logo-img" :src="'/storage/images/identidade-r.png'">
                </router-link>
            </b-navbar-brand>
            <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>
            <b-collapse id="nav-collapse" is-nav>
                <b-navbar-nav @click.prevent="redirect">
                    <b-nav-item @click.prevent="redirect('/')">Início</b-nav-item>
                    <b-nav-item @click.prevent="redirect('/diagnosis')">Autodiagnóstico</b-nav-item>
                    <b-nav-item @click.prevent="redirect('/info')">Informações</b-nav-item>
                </b-navbar-nav>
                <b-navbar-nav class="ml-auto">
                    <b-nav-item-dropdown right>
                        <template #button-content>
                            <user-icon></user-icon>
                        </template>
                        <b-dropdown-item @click.prevent="redirect('/account')">Perfil</b-dropdown-item>
                        <b-dropdown-item @click.prevent="redirect('/prontuary')">Prontuário</b-dropdown-item>
                        <b-dropdown-item @click.prevent="redirect('/messages')">Mensagens <b-badge>5</b-badge></b-dropdown-item>
                        <b-dropdown-item @click="logout">Sair</b-dropdown-item>
                    </b-nav-item-dropdown>
                </b-navbar-nav>
            </b-collapse> 
        </b-navbar>
    </div>
</template>

<script>
import axios from 'axios';
import { UserIcon } from 'vue-feather-icons';

export default {
    components: {
        UserIcon,
    },

    data(){
        return {
        };
    },

    methods:{
        logout(){
            return axios.post('/logout').then(() => {
                window.location.reload();
            });
        },

        redirect(path_name){
            if (this.$route.path != path_name)
                this.$router.push(path_name);
        },
    },
};
</script>

<style lang="scss" scoped>
.logo-img {
    max-width: 200px;
}

</style>