<template>
    <div>
        <b-modal id="passwordModal" ref="passwordModal" hide-footer>
            <template #modal-title>
                Alterar Senha
            </template>
            <div>
                <!--- alerts --->
                <div>
                    <b-alert
                        :show="countDownSuccess"
                        dismissible
                        variant="success"
                        @dismissed="countDownSuccess=0"
                        @dismiss-count-down="modalCountDownChangedSuccess"
                        >
                        <p>Senha alterada com sucesso!</p>
                        <b-progress
                            variant="success"
                            :max="2"
                            :value="countDownSuccess"
                            height="4px"
                        ></b-progress>
                    </b-alert>

                    <b-alert
                        :show="countDownError"
                        dismissible
                        variant="warning"
                        @dismissed="countDownError=0"
                        @dismiss-count-down="modalCountDownChangedError"
                        >
                        <p>Senha incorreta.</p>
                        <b-progress
                            variant="warning"
                            :max="2"
                            :value="countDownError"
                            height="4px"
                        ></b-progress>
                    </b-alert>
                </div>

                <div>
                    <b-form-group
                        description="Digite sua senha atual"
                        label="Senha atual"
                        label-for="actual-password"
                        :state="ActualPasswordState"
                    >
                        <b-form-input id="actual-password" :state="ActualPasswordState" v-model="form.actualPassword" type="password" trim></b-form-input>
                    </b-form-group>
                </div>

                <div>
                    <b-form-group
                        description="Digite sua nova senha"
                        label="Nova senha"
                        label-for="new-password"
                        :invalid-feedback="NewPasswordInvalidFeedback"
                        :state="NewPasswordState"
                    >
                        <b-form-input id="new-password" :state="NewPasswordState" v-model="form.newPassword" type="password" trim></b-form-input>
                    </b-form-group>
                </div>

                <div>
                    <b-form-group
                        description="Digite novamente sua nova senha"
                        label="Confirmar nova senha"
                        label-for="new-password-confirm"
                        :invalid-feedback="NewPasswordConfirmInvalidFeedback"
                        :state="NewPasswordConfirmState"
                    >
                        <b-form-input id="new-password-confirm" :state="NewPasswordConfirmState" v-model="form.newPasswordConfirm" type="password" trim></b-form-input>
                    </b-form-group>
                </div>

            </div>
            <b-button variant="secondary" class="mt-3" @click="cancel">Cancelar</b-button>
            <b-button variant="success" class="mt-3" :disabled="isDisabled" @click="updatePassword">Atualizar</b-button>
        </b-modal>
    </div>
</template>

<script>
export default {
    data(){
        return {
            hasFeedback: true,
            isDisabled: true,
            countDownSuccess: 0,
            countDownError: 0,
            form: {
                actualPassword: '',
                newPassword: '',
                newPasswordConfirm: '',
            },
            state: {
                actualPassword: false,
                newPassword: false,
                newPasswordConfirm: false,
            },
        };
    },

    computed: {
        ActualPasswordState() {
            if (this.form.actualPassword.length >= 1) {
                this.state.actualPassword = true;
                this.isReady();
                return true;
            } else {
                this.state.actualPassword = false;
                this.isReady();
                return false;
            } 
        },

        NewPasswordState() {
            if (this.form.newPassword.length >= 6) {
                this.state.newPassword = true;
                this.isReady();
                return true;
            } else {
                this.state.newPassword = false;
                this.isReady();
                return false;
            } 
        },

        NewPasswordConfirmState() {
            if (this.form.newPassword != ''){
                if (!(this.form.newPasswordConfirm != this.form.newPassword)){
                    this.state.newPasswordConfirm = true;
                    this.isReady();
                    return true;
                } else {
                    this.state.newPasswordConfirm = false;
                    this.isReady();
                    return false;
                } 
            }

            return ;
        },

        NewPasswordInvalidFeedback() {
            if (this.form.newPassword.length > 0) {
                return `${this.form.newPassword.length} caracteres.`;
            }
            return 'Sua senha deve ter no mínimo 6 caracteres. ';
        },

        NewPasswordConfirmInvalidFeedback() {
            if (this.form.newPasswordConfirm != this.form.newPassword){
                return 'As senhas não correspondem.';
            }
            return ;
        },
    },

    methods: {
        cancel(){
            this.form.actualPassword = '';
            this.form.newPassword = '';
            this.form.newPasswordConfirm = '';

            this.$refs['passwordModal'].hide();
        },

        updatePassword(){
            axios.post('/user/update/password', {
                actualPassword: this.form.actualPassword,
                newPassword: this.form.newPassword,
            }).then((response) => {
                if (response.data) this.countDownSuccess = 2;
                else this.countDownError = 2;
            });
            
        },
        
        isReady(){
            this.isDisabled = !(this.state.actualPassword && this.state.newPassword && this.state.newPasswordConfirm);
        },

        modalCountDownChangedSuccess(countDownSuccess) {
            this.countDownSuccess = countDownSuccess;
        },

        modalCountDownChangedError(countDownError) {
            this.countDownError = countDownError;
        },
    },

    watch: {
        countDownSuccess: function(){
            if (this.countDownSuccess == 0) window.location.reload();
        }
    }
}
</script>