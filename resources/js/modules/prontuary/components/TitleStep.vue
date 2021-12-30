<template>
    <div class="header">
        <div class="title">
            <div>
                <h2>{{ title }}</h2>
            </div>
            <div v-if="show">
                <div v-if="button == 'Salvo'">
                    <b-button variant="success" disabled>{{ button }}</b-button>
                </div>
                <div v-else>
                    <b-button :variant="variant">
                        <b-spinner small class="spinner-loadingx"></b-spinner> {{ button }}
                    </b-button>
                </div>
            </div>
            <div v-else>
                <b-button v-if="visible" variant="success" @click="$router.push({ name: 'prontuary.edit', params: { id: id } })"><edit-icon size="1x" class="icon-btn"></edit-icon> Editar</b-button>
            </div>
        </div>
    </div>
</template>

<script>
import { EditIcon } from 'vue-feather-icons'

export default {
    components: {
        EditIcon
    },

    props: {
        title: String,
        id: Number,
        show: {
            type: Boolean,
            default: true,
        },
        button: {
            type: String,
            default: 'Salvo',
        },
        variant: String,
        visible: {
            type: Boolean,
            default: true,
        }
    },

    data() {
        return {
        };
    },

};

</script>

<style scoped>

.icon-btn {
    margin-top: -5px;
}

.header {
    margin-top: 10px;
    margin-bottom: 20px;
}

.title {
    display: flex;
    justify-content: space-between;
}

.spinner-loadingx {
    margin-right: 3px;
}
</style>