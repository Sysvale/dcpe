<template>
    <div>
    <div class="card-msg" @click="redirectIfPossible()">
        <div class="msg-left-content">
            <div class="cover-msg">
                <img :src="cover" alt="">
            </div>
            <div class="msg-info" :id="id">
                <div class="name-msg">{{ name }}</div>
                <div class="short-content-msg">{{ short }}</div>
            </div>
        </div>
        <div class="msg-right-content">
            <b-badge variant="dark">{{ badge }}</b-badge>
        </div>
    </div>
    </div>
</template>

<script>
export default {
    name: 'CardMessage',

    props: {
        role: String,
        id: {
            type: String,
        },
        cover: {
            type: String,
            default: 'storage/images/default-user.png',
        },
        name: {
            type: String,
            default: 'Indefinido',
        },
        short: {
            type: String,
            default: 's',
        },
        badge: {
            type: Number,
            default: 0,
        },
        enable: {
            type: Boolean,
            default: false,
        }
    },
    
    methods: {
        redirectIfPossible(){

            if(this.role == 'patient'){
                if (this.id == 0 || (this.id == 1 && this.enable)) this.$router.push({ name: 'chat.message', params: { id: this.id} });
                else this.$bvToast.toast('Se você é portador da Doença de Chagas, atualize seu prontuário.',{
                    title: 'Para portadores da Doença de Chagas',
                    autoHideDelay: 5000,
                    appendToast: false,
                    variant: 'warning',
                });
            }

            if (this.role == 'professional' && this.name == 'Responder dúvidas'){
                this.$router.push({ name: 'doubt.messages' });
            }

            if (this.role == 'professional' && this.name == 'Acompanhamento'){
                this.$router.push({ name: 'follow.request' });
            }
        },
    },

};
</script>

<style scoped>
*{
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

.custom-toast {
    position: absolute;
}

.card-msg {
    background-color: #F7F7F7;
    height: 100px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px;
    padding-right: 20px;
    border: 1px solid rgba(0, 0, 0, .1);
    margin-bottom: 2px;
}

.msg-left-content {
    display: flex;
    align-items: center;
}

.card-msg.read {
    background: #fff;
}

.card-msg:hover {
    background-color: #E4E0E0;
    cursor: pointer;
}

.card-msg .cover-msg img {
    width: 55px;
}

.msg-info {
    margin-left: 18px;
    color: rgb(82, 82, 82);
}

.msg-info .name-msg {
    font-weight: 500;
    margin-bottom: -5px;
}

.msg-info .short-content-msg{
    font-size: .8rem;
}
</style>