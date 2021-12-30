<template>
    <div>
        <div v-if="isLoading" class="spinner-loading">
            <b-spinner variant="success" label="Spinning"></b-spinner>
        </div>
        <div v-else>
            <header-title 
                v-if="user.roles != 'sudo'"
                :title="`Bem vindo ao EloChagas, ${user.name}`"
                :subtitle="'Sistema voltado para portadores da Doença de Chagas'"
            ></header-title>
        </div>
        <div v-if="user.roles == 'patient'">
            <div class="carousel-cards">
                <div class="carousel">
                    <div class="card-item" v-for="{ id, title, description, buttonName, buttonVariant, url, cover } in items" :key="id">
                        <b-card
                            :title="title"
                            :img-src="cover"
                            img-top
                            tag="article"
                            class="mb-2 self-card"
                        >
                            <b-card-text>{{ description }}</b-card-text>

                            <b-button :href="url" :variant="buttonVariant">{{ buttonName }}</b-button>
                        </b-card>
                    </div>
                </div>
            </div>

        </div>
        <div v-else-if="user.roles == 'sudo'">
            <header-title 
                :title="`Gerência de usuários`"
                :subtitle="'Lista de usuários ativos'"
            ></header-title>

            <table class="table">
                <thead>
                    <tr>
                        <th scope="col" v-for="item in fields" :key="item">
                            <div v-if="item == 'Prontuário'">
                                <center>{{ item }}</center>
                            </div>
                            <div v-else>
                                {{ item }}
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="{ id, name, email, email_verified_at, roles } in users" :key="id">
                        <td class="custom-table">{{ id }}</td>
                        <td>{{ name }}</td>
                        <td>{{ email }}</td>
                        <td>{{ email_verified_at }}</td>
                        <td>{{ roles }}</td>
                        <td width="200"><center>
                            <b-button variant="primary" @click="updateRole(id, roles)" v-b-tooltip.hover title="Alterar nível de acesso"><edit-icon size="1x" class="custom-class"></edit-icon></b-button>
                            <b-button variant="danger" @click="deleteUser(id, name)" v-b-tooltip.hover title="Excluir usuário"><user-x-icon size="1x" class="custom-class"></user-x-icon></b-button>
                        </center></td>
                    </tr>
                </tbody>
            </table>
            <modal-role :id="userId" :role="role" @update="getAllUsers"/>
            <modal-delete :id="userId" :name="name" @update="getAllUsers"/>
        </div>
        <div v-else>
            <h3>Pacientes</h3>
            <div style="margin-top: 15px;">
                <div v-if="hasPatients">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col" v-for="item in fieldsPatient" :key="item">
                                    <div v-if="item == 'Ações'">
                                        <center>{{ item }}</center>
                                    </div>
                                    <div v-else>
                                        {{ item }}
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="{ id_patient, name } in patients" :key="id_patient">
                                <td class="custom-table">{{ name }}</td>
                                <td width="200"><center>
                                    <b-button variant="primary" @click="$router.push(`/prontuary/${id_patient}/view`)" v-b-tooltip.hover title="Prontuário do paciente"><file-text-icon size="1x" class="custom-class"></file-text-icon></b-button>
                                    <b-button variant="success" @click="$router.push(`/message/${id_patient}/chat/1`)" v-b-tooltip.hover title="Conversar com paciente"><message-square-icon size="1x" class="custom-class"></message-square-icon></b-button>
                                </center></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div v-else>
                    <b-alert variant="warning" show>Você não está acompanhando nenhum paciente.</b-alert>
                </div>
            </div>
        </div>
    </div>
</template>

<script> 
import axios from 'axios';
import HeaderTitle from "../../../core/common/HeaderTitle";
import { ChevronRightIcon, ChevronLeftIcon, FileTextIcon, MessageSquareIcon, EditIcon, UserXIcon, } from 'vue-feather-icons';

import ModalRole from '../components/ModalRole';
import ModalDelete from '../components/ModalDelete';

export default {
    components: { 
        HeaderTitle, 
        ChevronRightIcon,
        ChevronLeftIcon,
        FileTextIcon,
        MessageSquareIcon,
        EditIcon,
        UserXIcon,
        ModalRole,
        ModalDelete,
    },

    data(){
        return {
            userId: '',
            role: '',
            name: '',
            user: [],
            hasPatients: true,
            isLoading: true,
            fields: ['ID', 'Nome', 'Email', 'Email Verificado', 'Role', 'Ações'],
            fieldsPatient: ['Nome', 'Ações'],
            patients: [],
            users: [],
            items: [
                { 
                    id: 0,
                    title: 'Mantenha seu prontuário atualizado', 
                    description: 'Os profissionais da saúde têm acesso ao seu prontuário, portanto, um prontuário mais atualizado vai ajudar ambas as partes.',
                    buttonName: 'Atualizar',
                    buttonVariant: 'success',
                    url: '/prontuary/home',
                    cover: 'https://static.wixstatic.com/media/00ef04_a77cef516d4e4158a6e5b21f4be411df~mv2.jpg/v1/fill/w_560,h_318,al_c,q_80,usm_0.66_1.00_0.01/autodiagnostico.webp',
                },
                { 
                    id: 1,
                    title: 'É portador da Doença de Chagas?', 
                    description: 'Usuários portadores da DC podem solicitar acompanhamento médico por meio do chat.',
                    buttonName: 'Solicitar',
                    buttonVariant: 'success',
                    url: '/messages',
                    cover: 'https://static.wixstatic.com/media/00ef04_a77cef516d4e4158a6e5b21f4be411df~mv2.jpg/v1/fill/w_560,h_318,al_c,q_80,usm_0.66_1.00_0.01/autodiagnostico.webp',
                },
                { 
                    id: 2,
                    title: 'Saiba como capturar um "barbeiro" com segurança', 
                    description: 'Achou um "barbeiro"? Todo cuidado na captura desse inseto é necessário, veja como capturá-lo com segurança.',
                    buttonName: 'Acessar',
                    buttonVariant: 'primary',
                    url: '/info#8',
                    cover: 'https://static.wixstatic.com/media/00ef04_a77cef516d4e4158a6e5b21f4be411df~mv2.jpg/v1/fill/w_560,h_318,al_c,q_80,usm_0.66_1.00_0.01/autodiagnostico.webp',
                },
                { 
                    id: 3,
                    title: 'Tire dúvidas com profissionais da saúde', 
                    description: 'Tire suas dúvidas com profissionais da saúde à respeito da Doença de Chagas.',
                    buttonName: 'Acessar',
                    buttonVariant: 'primary',
                    url: '/messages/0',
                    cover: 'https://static.wixstatic.com/media/00ef04_a77cef516d4e4158a6e5b21f4be411df~mv2.jpg/v1/fill/w_560,h_318,al_c,q_80,usm_0.66_1.00_0.01/autodiagnostico.webp',
                },
                { 
                    id: 4,
                    title: 'Saiba mais sobre a Doença de Chagas', 
                    description: 'Saiba mais sobre a Doença de Chagas na nossa aba de informações.',
                    buttonName: 'Acessar',
                    buttonVariant: 'primary',
                    url: '/messages/0',
                    cover: 'https://static.wixstatic.com/media/00ef04_a77cef516d4e4158a6e5b21f4be411df~mv2.jpg/v1/fill/w_560,h_318,al_c,q_80,usm_0.66_1.00_0.01/autodiagnostico.webp',
                },
            ],
        };
    },

    beforeMount(){
        document.title = `${this.$route.meta.alias} - Elo Chagas`;
    },

    mounted(){
        this.getUser();
    },

    methods: {
        getUser(){
            axios.get('/user').then((response) => {
                this.user = response.data;
                console.log(this.user.roles);
                if (this.user.roles == 'patient')
                    this.jquery();
                
                if (this.user.roles == 'professional')
                    this.getPatients();

                if (this.user.roles == 'sudo')
                    this.getAllUsers();
            
                this.isLoading = false;
            }).catch((error) => {
                console.log('Error HomePage: ', error);
            });
        },

        jquery(){
            $(function(){
                verifyViewport();
                applyStyleArrowCarousel();

                $(window).resize(function() {
                    $('.carousel').slick('unslick');
                    verifyViewport();
                    applyStyleArrowCarousel();
                });

                function verifyViewport(){
                    let viewportWidht = $(window).width();

                    if (viewportWidht >= 768 && viewportWidht < 994){
                        resizeCarousel(2);
                    } else if (viewportWidht < 768){
                        let cardItem = document.querySelectorAll(".self-card");
                        
                        cardItem.forEach((el) => {
                            el.style.width = "100%";
                        });

                        resizeCarousel(1);
                    } else {
                        resizeCarousel(3);
                    }
                }

                function resizeCarousel(numItems, numScroll){
                    $('.carousel').slick({
                        autoplay: true,
                        pauseOnDotsHover: true,
                        dots: true,
                        speed: 500,
                        slidesToShow: numItems,
                        slidesToScroll: 1,
                    });
                }

                function applyStyleArrowCarousel(){
                    $(".slick-arrow").css({
                        backgroundColor: "rgba(158, 156, 156, 0.6)",
                        height: "50px",
                        width: "30px",
                    });
                }

            });
        },

        getPatients(){
            axios.get('/professional/get/patients').then(response => {
                this.patients = response.data;
                this.hasPatients = (this.patients.length != 0);
            }).catch(error => console.log('error'));
        },

        getAllUsers(){
            axios.get('/user/get-all').then((response) => {
                this.users = response.data;
            }).catch(error => console.log('error'));
        },

        updateRole(id, roles){
            this.userId = id;
            this.role = roles;
            this.$bvModal.show('modalRole');
        },

        deleteUser(id, name){
            this.userId = id;
            this.name = name;
            this.$bvModal.show('modalDelete');
        }
    },
};
</script>

<style lang="scss" scoped>
$len: 320px;

.custom-table {
    background-color: rgb(250, 248, 248);
}

.spinner-loading{
    display: flex;
    justify-content: center;
    margin-top: 30px;
}
.carousel-cards {
    padding: 0px 30px;
}

.cards {
    width: calc($len * 5);
    display: flex;
    transition: all .5s ease;
}

.card-item {
    width: $len;
    transform: scale(.9);
    transition: .5s ease;
}

.card-item:hover {
    transform: scale(1);
}

</style>