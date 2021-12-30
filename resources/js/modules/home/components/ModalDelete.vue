<template>
    <div>
        <b-modal id="modalDelete" ref="modalDelete" hide-footer>
            <template #modal-title>
                Deletar usuário?
            </template>
            <div>
                {{ name }}
            </div>
            <b-button variant="secondary" class="mt-3" @click="cancel">Cancelar</b-button>
            <b-button variant="danger" class="mt-3" @click="deleteUser(id)">Deletar</b-button>
        </b-modal>
    </div>
</template>

<script>
export default {
    props: {
        id: String,
        name: String,
    },

    data(){
        return {
            
        };
    },

    methods: {
        cancel(){
            this.$refs['modalDelete'].hide();
        },

        deleteUser(id){
            axios.post('/user/delete', {
                idUser: id,
            }).then(() => {
                this.$bvToast.toast('Deletado com sucesso', {
                    autoHideDelay: 3000,
                    appendToast: false,
                    variant: 'success',
                });
                // fecha modal
                this.cancel();
                // atualiza os dados
                this.$emit('update');
            }).catch((error) => {
                console.log('Error');
                this.$bvToast.toast('Erro ao deletar usuário', {
                    autoHideDelay: 3000,
                    appendToast: false,
                    variant: 'danger',
                });
            });
        }
    },

}
</script>