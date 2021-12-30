<template>
    <div>
        <b-modal id="modalRole" ref="modalRole" hide-footer>
            <template #modal-title>
                Alterar Nível de Acesso
            </template>
            <div>
                <b-form-select v-model="selected" :options="options"></b-form-select>
            </div>
            <b-button variant="secondary" class="mt-3" @click="cancel">Cancelar</b-button>
            <b-button variant="success" class="mt-3" @click="updateRole(id)">Atualizar</b-button>
        </b-modal>
    </div>
</template>

<script>
export default {
    props: {
        id: String,
        role: String,
    },

    data(){
        return {
            selected: '',
            options: [
                { value: "patient", text: "patient" },
                { value: "professional", text: "professional" },
            ],
        };
    },

    methods: {
        cancel(){
            this.$refs['modalRole'].hide();
        },

        updateRole(id){
            console.log(id, this.selected);
            axios.post('/user/update/role', {
                idUser: id,
                value: this.selected,
            }).then(() => {
                this.$bvToast.toast('Atualizado com sucesso', {
                    autoHideDelay: 5000,
                    appendToast: false,
                    variant: 'success',
                });
                // fecha modal
                this.cancel();
                // atualiza os dados
                this.$emit('update');
            }).catch((error) => {
                console.log('Error');
                this.$bvToast.toast('Erro ao atualizar', {
                    autoHideDelay: 5000,
                    appendToast: false,
                    variant: 'danger',
                });
            });
        }
    },

    watch: {
        'role': function(){
            this.selected = this.role;
        },
    }
}
</script>