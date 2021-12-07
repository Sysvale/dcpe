<template>
    <div class="box-message">
        <div class="message-title">
            <div class="title"><h3>{{ title }}</h3></div>
        </div>
        <div class="message-body">
            <div  v-for="{_id, message, status, answered, answered_by, updated_at, created_at } in messages" :key="_id">
                <div class="message-send">
                    <div class="text-send">
                        <div><strong>Você</strong></div>
                        <div>{{ message }}</div>
                        <div class="message-info">{{ created_at }}</div>
                    </div>
                </div>
                <div class="message-receive" v-if="status != 'waiting'" @click="markAsRead(_id)">
                    <div class="text-receive" v-b-tooltip.hover title="Clique para marcar como lida">
                        <div><strong>{{ answered_by }}</strong></div>
                        <div>{{ answered }}</div>
                        <div class="message-info">{{ updated_at }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="input-type">
            <form method="post" @submit.prevent="sendMsg" @submit="$emit('updateBadge')">
                <input type="text" name="sent_message" placeholder="Digite..." v-model="form.input" autofocus autocomplete="off"/>
                <b-button class="btn-send" variant="outline-primary" type="submit"><send-icon size="1.5x"></send-icon></b-button>
            </form>
        </div>
    </div>
</template> 

<script>
import axios from 'axios';
import { SendIcon } from 'vue-feather-icons';

export default {
    components: {
        SendIcon,
    },

    data(){
        return {
            messages: () => [],
            title: '',
            form: {
                input: '',
            },
        };
    },

    beforeRouteUpdate (to, from, next){
        if (to.params.id == 0){
            this.getDoubts();
        } else {
            this.messages = [];
            // getFollowUps
        }

        this.updateMessageTitle(to.params.id);
        this.updateDocumentTitle(to.params.id);
        next();
    },

    mounted(){
        if (this.$route.params.id == 0){
            this.getDoubts();
        } else {
            this.messages = [];
            // getFollowUps
        }

        this.scrollToDown();
        this.updateMessageTitle(this.activeCard());
        this.updateDocumentTitle(this.activeCard());
    },

    methods: {
        sendMsg(){
            if (this.$route.params.id == 0){
                axios.post('/user/doubts/add', {
                    message: this.form.input,
                }).then(() => {
                    this.getDoubts();
                });
            }
        },

        scrollToDown(){
            $(".message-body").scrollTop($(".message-body")[0].scrollHeight);
        },

        activeCard(){
            return this.$route.params.id;
        },

        updateDocumentTitle(actived){
            document.title = (actived == 1)?'Acompanhamento - Elo Chagas':'Dúvidas - Elo Chagas';
        },

        updateMessageTitle(actived){
            this.title = (actived == 1)?'Acompanhamento':'Tire suas dúvidas';
        },

        getDoubts(){
            axios.get('/user/doubts')
            .then( response => {
                this.messages = response.data;
            }).finally(() => {
                this.form.input = '';
                this.scrollToDown();
            }); 
        },

        markAsRead(message_id){
             axios.post('/user/doubts/mr', {
                id: message_id,
            }).then(() => {
                console.log("marcado");
            });
        },
    },    
}

</script>

<style scoped>
*{
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

.box-message {
    margin-top: 20px;
    box-shadow: 1px 1px 5px #ccc;
    height: 640px;
    display: flex;
    flex-direction: column;
}

.box-message .message-title .title{
    color: #000;
    padding: 15px;
}

.box-message .message-body { 
    height: 100%;
    padding: 15px;
    overflow-y: auto;
    background-color: #F8F9FB;
    display: flex;
    flex-direction: column;
}

.message-body .message-send,
.message-body .message-receive {
    display: flex;
    margin-bottom: 15px;
}

.message-receive .text-receive {
    cursor: pointer;
}

.message-send {
    justify-content: flex-end;
}

.message-receive .text-receive,
.message-send .text-send {
    padding: 7px 10px;
    max-width: 70%;
    display: flex;
    flex-direction: column;
}

.text-send .message-info,
.text-receive .message-info {
    margin-top: 10px;
    font-size: 12px;
    text-align: right;
}

.message-send .text-send{
    background: #d9d9d9;
    border-radius: 3px;
    color: rgb(105, 105, 105);
    font-size: 15px;
}


.message-receive .text-receive{
    background: rgb(0, 119, 254);
    border-radius: 3px;
    color: white;
    font-size: 15px;
}

.box-message .input-type {
    padding: 15px;
    position: relative;
    border: 1px solid #ccc;
}

.input-type input {
    width: 100%;
    padding: 0 60px 0 10px;
    outline: none;
    border: transparent;
}

.input-type .btn-send {
    position: absolute;
    right: 0;
    top: 0;
    padding: 2px;
    margin-top: 10px;
    margin-right: 25px;
}

::-webkit-scrollbar{
    width: 3px;
    border-radius: 25px;
}

::-webkit-scrollbar-track {
    background-color: #f1f1f1;
}

::-webkit-scrollbar-thumb {
    background-color: #5aa3f7;
}

::-webkit-scrollbar-thumb:hover {
    background-color: #2889f7;
}
</style>