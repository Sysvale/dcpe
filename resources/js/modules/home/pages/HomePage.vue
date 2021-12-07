<template>
    <div>
        <router-link :to="{ name: 'home.registration.step', params: { step: 1 } }">Registrar</router-link>
        <router-link :to="{ name: 'home.welcome'}">Welcome</router-link>
        <router-view/>
        <div v-if="profileCompleted | completeCancel">
            <header-title 
                :title="'Bem vindo ao EloChagas, '+user.name"
                :subtitle="'Alguma descrição aqui'"
            ></header-title>
            <div class="carousel-cards">
                <div class="navigation-left" @click="handleLeftArrow">
                    <chevron-left-icon size="1.5x"></chevron-left-icon>
                </div>
                <div class="navigation-right" @click="handleRightArrow">
                    <chevron-right-icon size="1.5x"></chevron-right-icon>
                </div>
                <div class="cards">
                    <div class="card-item">
                        <b-card
                            title="Faça seu auto-diagnóstico"
                            img-src="https://static.wixstatic.com/media/00ef04_a77cef516d4e4158a6e5b21f4be411df~mv2.jpg/v1/fill/w_560,h_318,al_c,q_80,usm_0.66_1.00_0.01/autodiagnostico.webp"
                            img-alt="Image"
                            img-top
                            tag="article"
                            style="max-width: 20rem;"
                            class="mb-2"
                        >
                            <b-card-text>
                            Esse questionário vai te definir a necessidade de fazer uma testagem para Chagas agudo ou crônico.
                            </b-card-text>

                            <b-button href="#" variant="success">Responder</b-button>
                        </b-card>
                    </div>

                    <div class="card-item">
                        <b-card
                            title="Precisa tirar dúvidas ou ter acompanhamento?"
                            img-src="https://img.pebmed.com.br/wp-content/uploads/2016/11/relacao-medico-paciente.jpg.webp"
                            img-alt="Image"
                            img-top
                            tag="article"
                            style="max-width: 20rem;"
                            class="mb-2"
                        >
                            <b-card-text>
                            Acesse nosso chat para tirar dúvidas ou fazer um acompanhamento com profissionais da saúde.
                            </b-card-text>

                            <b-button href="#" variant="primary">Acessar</b-button>
                        </b-card>
                    </div>

                    <div class="card-item">
                        <b-card
                            title="Saiba como identificar um barbeiro"
                            img-src="https://www.revistacircuito.com/wp-content/uploads/2019/08/chagas-1.jpg"
                            img-alt="Image"
                            img-top
                            tag="article"
                            style="max-width: 20rem;"
                            class="mb-2"
                        >
                            <b-card-text>
                            Saiba de forma correta e segura como realizar a captura de um barbeiro e também onde levá-los.
                            </b-card-text>

                            <b-button href="#" variant="primary">Acessar</b-button>
                        </b-card>
                    </div>

                    <div class="card-item">
                        <b-card
                            title="Saiba como identificar um barbeiro"
                            img-src="https://www.revistacircuito.com/wp-content/uploads/2019/08/chagas-1.jpg"
                            img-alt="Image"
                            img-top
                            tag="article"
                            style="max-width: 20rem;"
                            class="mb-2"
                        >
                            <b-card-text>
                            Saiba de forma correta e segura como realizar a captura de um barbeiro e também onde levá-los.
                            </b-card-text>

                            <b-button href="#" variant="primary">Acessar</b-button>
                        </b-card>
                    </div>

                    <div class="card-item">
                        <b-card
                            title="Saiba como identificar um barbeiro"
                            img-src="https://www.revistacircuito.com/wp-content/uploads/2019/08/chagas-1.jpg"
                            img-alt="Image"
                            img-top
                            tag="article"
                            style="max-width: 20rem;"
                            class="mb-2"
                        >
                            <b-card-text>
                            Saiba de forma correta e segura como realizar a captura de um barbeiro e também onde levá-los.
                            </b-card-text>

                            <b-button href="#" variant="primary">Acessar</b-button>
                        </b-card>
                    </div>

                </div>
            </div>
        </div>
        <div v-else>
            <header-title 
                :title="'Complete seu cadastro'"
                :subtitle="'Os dados serão salvos automaticamente'"
            ></header-title>
            <cds-stepper
                v-model="currentStepIndex"
                :steps="steps"
            />
        </div>
        
        <!-- <div style="margin-top: 80px;">

            <b-form v-if="show">
            <b-form-group
                id="input-group-1"
                label="Email address:"
                label-for="input-1"
                description="We'll never share your email with anyone else."
            >
                <b-form-input
                id="input-1"
                v-model="form.email"
                type="email"
                placeholder="Enter email"
                required
                ></b-form-input>
            </b-form-group>

            <b-form-group id="input-group-2" label="Your Name:" label-for="input-2">
                <b-form-input
                id="input-2"
                v-model="form.name"
                placeholder="Enter name"
                required
                ></b-form-input>
            </b-form-group>

            <b-form-group id="input-group-3" label="Food:" label-for="input-3">
                <b-form-select
                id="input-3"
                v-model="form.food"
                :options="foods"
                required
                ></b-form-select>
            </b-form-group>

            <b-form-group id="input-group-4" v-slot="{ ariaDescribedby }">
                <b-form-checkbox-group
                v-model="form.checked"
                id="checkboxes-4"
                :aria-describedby="ariaDescribedby"
                >
                <b-form-checkbox value="me">Check me out</b-form-checkbox>
                <b-form-checkbox value="that">Check that out</b-form-checkbox>
                </b-form-checkbox-group>
            </b-form-group>

            <b-button type="submit" variant="primary">Submit</b-button>
            <b-button type="reset" variant="danger">Reset</b-button>
            </b-form>
        </div> -->

    </div>
</template>

<script> 
import axios from 'axios';
import HeaderTitle from "../../../core/common/HeaderTitle";
import { ChevronRightIcon, ChevronLeftIcon } from 'vue-feather-icons';

export default {
    components: { 
        HeaderTitle, 
        ChevronRightIcon,
        ChevronLeftIcon,
    },

    props: {
        user: {
            type: Object,
            require: true,
        },
    },

    data(){
        return {
            selector: (el) => document.querySelector(el),
            scrollX: 0,
            maxScroll: 0,
            profileCompleted: false, // pegar do banco de dados
            completeCancel: true, // pegar do formulário

            currentStepIndex: 1,
            steps: [
                {"label":"Prontuário","completed":false,"inProcessing":true,"error":false},
                {"label":"Bandeira 2","completed":false,"inProcessing":false,"error":false},
                {"label":"Bandeira 5","completed":false,"inProcessing":false,"error":false}
            ],
            
            form: {
                email: '',
                name: '',
                food: null,
                checked: []
            },
            foods: [{ text: 'Select One', value: null }, 'Carrots', 'Beans', 'Tomatoes', 'Corn'],
            show: true
        };
    },

    beforeMount(){
        document.title = `${this.$route.meta.alias} - Elo Chagas`;
    },

    watch: {
        currentStepIndex: function(){
            
        }
    },

    methods: {
        handleLeftArrow(){
            this.scrollX += Math.round(window.innerWidth/2);
            if (this.scrollX > 0) this.scrollX = 0;
            this.selector('.cards').style.marginLeft = this.scrollX+'px';
        },

        handleRightArrow(){
            this.scrollX -= Math.round(window.innerWidth/2);
            console.log(window.innerWidth);
            if ((window.innerWidth - 1600) > this.scrollX){
                this.scrollX = window.innerWidth - 2000;
            }
            this.selector('.cards').style.marginLeft = this.scrollX+'px';
        },
    }
};
</script>

<style lang="scss" scoped>
$len: 320px;

.carousel-cards {
    overflow-x: hidden;
    position: relative;
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

.navigation-left,
.navigation-right {
    position: absolute;
    width: 40px;
    height: 100px;
    background-color:rgba(158, 156, 156, 0.6);
    z-index: 99;
    display: flex;
    justify-content: center;
    align-items: center;
    overflow: hidden;
    margin-top: 150px;
    cursor: pointer;
}

.navigation-left {
    left: 0;
}

.navigation-right {
    right: 0;
}
</style>