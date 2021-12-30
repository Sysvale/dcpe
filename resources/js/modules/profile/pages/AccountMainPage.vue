<template>
    <div>
        <header-title 
            :title="'Meu Perfil'"
            :subtitle="'Dados da conta'"
        ></header-title>
        
        <div v-if="!isLoading">
            <div>
                <b-alert
                    :show="dismissCountDownSuccess"
                    dismissible
                    variant="success"
                    @dismissed="dismissCountDownSuccess=0"
                    @dismiss-count-down="countDownChangedSuccess"
                    >
                    <p>Dados alterados com sucesso!</p>
                    <b-progress
                        variant="success"
                        :max="3"
                        :value="dismissCountDownSuccess"
                        height="4px"
                    ></b-progress>
                </b-alert>

                <b-alert
                    :show="dismissCountDownError"
                    dismissible
                    variant="danger"
                    @dismissed="dismissCountDownError=0"
                    @dismiss-count-down="countDownChangedError"
                    >
                    <p>Ocorreu algum erro, tente novamente mais tarde.</p>
                    <b-progress
                        variant="danger"
                        :max="3"
                        :value="dismissCountDownError"
                        height="4px"
                    ></b-progress>
                </b-alert>
            </div>

            <div class="user">
                <div class="cover">
                    <div class="cover-img"></div>
                    <b-form-group>
                        <b-form-file
                            :file-name-formatter="setType"
                            v-model="form.file"
                            :state="fileState"
                            placeholder="Selecione ou arraste..."
                            drop-placeholder="Arraste aqui..."
                            name="file"
                            accept="image/png, image/jpeg"
                        ></b-form-file>
                        <b-form-invalid-feedback>{{ fileInvalidFeedback }}</b-form-invalid-feedback>
                    </b-form-group>
                </div>
                <div class="user-info">
                    <b-form-input v-model="form.name" :state="nameState" class="input"></b-form-input>
                    <b-form-group>
                        <b-form-input v-model="form.email" :state="emailState"></b-form-input>
                        <b-form-invalid-feedback>{{ emailFeedback }}</b-form-invalid-feedback>
                    </b-form-group>
                    <b-button variant="secondary" v-b-modal.passwordModal>Alterar senha</b-button>
                    <b-button variant="success" :disabled="isUpdated" @click="save">Salvar</b-button>
                </div> 
            </div>
        </div>
        <div v-else class="spinner-loading">
            <b-spinner variant="success" label="Spinning"></b-spinner>
        </div>
        <!--- modal --->
        <modal/>
    </div>
</template>

<script>
import axios from 'axios';
import { email as emailValidator } from 'vuelidate/lib/validators';
import HeaderTitle from "../../../core/common/HeaderTitle";
import Modal from '../components/Modal';

export default {
    components: {
        HeaderTitle,
        Modal,
    },

    data() {
        return {
            isLoading: true,
            dismissCountDownSuccess: 0,
            dismissCountDownError: 0,
            currentImageType: null,
            user: [],
            form: {
                name: '',
                email: '',
                file: null,
            },
            isUpdated: false,
            feedback: false,
            isUnique: false,
            states: {
                name: false,
                email: false,
                file: false,
            }
        };        
    },

    validations() {
        return {
            form: {
                email: { emailValidator },
            }
        };
    },

    beforeMount(){
        document.title = `${this.$route.meta.alias} - Elo Chagas`;
        
        axios.get('/user').then((response) => {
            this.user = response.data;
            this.isLoading = false;
        }).finally(() => {
            let cover = document.querySelector(".cover-img");
            cover.style.background = `url(${this.user.cover})`;
            cover.style.backgroundSize = 'cover';
            cover.style.backgroundPosition = 'center';

            this.form.name = this.user.name;
            this.form.email = this.user.email;
        });
    },

    computed:{
        nameState(){
            if (this.form.name != this.user.name){
                this.states.name = true;
                this.isUpdated = this.updated();
                return this.states.name;
            } else {
                this.states.name = false;
                this.isUpdated = this.updated();
                return ;
            }
        },

        emailFeedback(){
            if (!this.$v.form.email.emailValidator){
                this.feedback = true;
                return 'E-mail inválido.';
            } 

            this.isUniqueEmail();

            if (!this.isUnique){
                this.feedback = true;
                return 'E-mail já em uso.';
            }

            this.feedback = false;
            return '';
        },

        fileInvalidFeedback(){
            return 'Formatos aceitos: jpeg, png';
        },

        emailState(){
            if (this.form.email != this.user.email){
                this.isUniqueEmail();
                if (this.$v.form.email.emailValidator && this.isUnique && this.form.email != ''){
                    this.states.email = true;
                    this.isUpdated = this.updated();
                    return this.states.email;
                } else return false;
            } else {
                this.states.email = false;
                this.isUpdated = this.updated();
                return ;
            }
        },

        fileState(){
            const validImageTypes = ['image/jpeg', 'image/png'];
            
            if (this.form.file != null){
                if (!validImageTypes.includes(this.currentImageType)) {
                    this.states.file = false;
                    this.isUpdated = this.updated();
                    return false;
                } else {
                    this.states.file = true;
                    this.isUpdated = this.updated();
                    return this.states.file;
                }
            } else {
                this.states.file = false;
                this.isUpdated = this.updated();
                return ;
            }
        },
    },

    methods: {
        setType(files){
            this.currentImageType = files[0].type;
            return files[0].name;
        },

        updated(){
            return !(this.states.name || this.states.email || this.states.file);
        },

        isUniqueEmail(){
            axios.post('/user/unique-mail', {
                isUnique: this.form.email,
            }).then((response) => {
                this.isUnique = response.data;
            });
        },

        countDownChangedSuccess(dismissCountDownSuccess) {
            this.dismissCountDownSuccess = dismissCountDownSuccess;
        },

        countDownChangedError(dismissCountDownError) {
            this.dismissCountDownError = dismissCountDownError;
        },

        sendData(data){
            if(this.states.name || this.states.email) {
                this.isLoading = true;
                axios.post('/user/update/profile', {
                    data,
                }).then((response) => {
                    this.dismissCountDownSuccess = 3;
                    this.isLoading = false;
                }).catch((error) => {
                    this.dismissCountDownError = 3;
                });
            }
        },
        
        save(){
            let data = [];
            let file = new FormData();

            if (this.states.name)  data.push({ name: this.form.name, type: 'name'});
            if (this.states.email) data.push({ email: this.form.email, type: 'email'});
            
            if (this.states.file)  {
                file.append('file', this.form.file);

                axios.post('/user/update/profile', file, {
                    headers: { 'Content-Type': 'multipart/form-data' }
                }).then((response) => {
                    this.sendData(data);
                    this.dismissCountDownSuccess = 3;
                }).catch((error) => {
                    this.dismissCountDownError = 3;
                });
            } else this.sendData(data);
        },
    },

    watch: {
        dismissCountDownSuccess: function(){
            if (this.dismissCountDownSuccess == 0) window.location.reload();
        }
    }
};
</script>
<style lang="scss" scoped>

.spinner-loading{
    display: flex;
    justify-content: center;
    margin-top: 70px;
}

.user {
    display: flex;

    .cover {
        max-width: 280px;
        margin-right: 30px;
        display: flex;
        flex-direction: column;
        align-items: center;

        .cover-img {
            width: 200px;
            height: 200px;
            border-radius: 50%;
            margin-bottom: 20px;
            background: url('/storage/images/default-user.png');
            background-size: cover;
            background-position: center;
        }
    }


    .user-info {
        width: 100%;

        .input {
            margin-bottom: 10px;
        }
    }
}
</style>