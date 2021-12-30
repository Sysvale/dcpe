<template>
    <div class="box-message">
        <div class="message-title">
            <div class="title"><h3>{{ title }}</h3></div>
            <div class="professional-name" v-if="this.$route.params.id == 1 && user.acceptedBy != false">
                Profissional: {{ (user.acceptedBy != null)?user.acceptedBy:"Aguardando" }}
            </div>
        </div>
        <div v-if="id == 0">
            <div class="message-body">
                <div  v-for="{_id, id_doubt, type, message /*,status*/, created_at,
                            answer, answered_by, read } in chat.messagesDoubts" :key="`${_id || id_doubt}-${type}`">
                    <div class="message-send" v-if="type == 1">
                        <div class="text-send">
                            <div><strong>Você</strong></div>
                            <div>{{ message }}</div>
                            <div class="message-info">{{ created_at }}</div>
                        </div>
                    </div>
                    <div class="message-receive" v-if="type == 2">
                        <div class="text-receive" v-b-tooltip.hover :title="tooltip" @mouseenter="feedbackMessage(read)">
                            <b-alert show variant="light">Resposta de: {{ message }}</b-alert>
                            <div><strong>{{ answered_by }}</strong></div>
                            <div>{{ answer }}</div>
                            <div class="message-info">{{ created_at }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="input-type">
                <!-- @submit="$emit('updateBadge')" -->
                <form method="post" @submit.prevent="sendMessage()">
                    <input type="text" name="sent_message" placeholder="Digite..." v-model="form.input" autofocus autocomplete="off"/>
                    <b-button class="btn-send" variant="outline-primary" type="submit"><send-icon size="1.5x"></send-icon></b-button>
                </form>
            </div>
        </div>

        <!--- acompanhamento --->
        <div v-if="id == 1">
            <div v-if="role == 'patient'">
                <div class="message-body">
                    <div v-if="!user.requested" class="img-container">
                        <b-img class="cover-img" src="/storage/images/medico.png" fluid></b-img>
                        <h3>Parece que você ainda não solicitou acompanhamento</h3>
                        <p>Deseja solicitar acompanhamento? O profissional da saúde terá acesso ao seu prontuário</p><br/>
                        <b-button variant="success" @click="requestFollowUp">Solicitar</b-button>
                    </div>
                    <div v-else>
                        <div v-if="user.requested && user.acceptedBy == null">
                            <div class="img-container">
                                <b-img class="cover-img" src="/storage/images/sala-de-espera.png" fluid></b-img>
                                <h3>Na fila de espera</h3>
                                <p>Aguarde até que um profissional da saúde aceite sua solicitação.</p><br/>
                                <b-button variant="danger" @click="cancelRequestFollowUp">Cancelar Solicitação</b-button>
                            </div>
                        </div>
                        <div v-else v-for="{id, id_user, message, created_at, type } in chat.messagesFollowUp" :key="`${id}-${type}`">
                            <div class="message-send" v-if="type == 1">
                                <div class="text-send">
                                    <div><strong>Você</strong></div>
                                    <div>{{ message }}</div>
                                    <div class="message-info">{{ created_at }}</div>
                                </div>
                            </div>
                            <div class="message-receive" v-if="type == 2">
                                <div class="text-receive">
                                    <div><strong>{{ id_user }}</strong></div>
                                    <div>{{ message }}</div>
                                    <div class="message-info">{{ created_at }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div v-if="user.requested && user.acceptedBy != null" class="input-type">
                    <!-- @submit="$emit('updateBadge')" -->
                    <form method="post" @submit.prevent="sendMessageFollowUp()">
                        <input type="text" name="sent_message" placeholder="Digite..." v-model="form.input" autofocus autocomplete="off"/>
                        <b-button class="btn-send" variant="outline-primary" type="submit"><send-icon size="1.5x"></send-icon></b-button>
                    </form>
                </div>
            </div>
            
            <div v-if="role == 'professional'">
                <div class="message-body">
                    <div>
                        <div v-for="{id, id_user, message, created_at, type } in chat.messagesFollowUpProfessional" :key="`${id}-${type}`">
                            <div class="message-send" v-if="type == 1">
                                <div class="text-send">
                                    <div><strong>Você</strong></div>
                                    <div>{{ message }}</div>
                                    <div class="message-info">{{ created_at }}</div>
                                </div>
                            </div>
                            <div class="message-receive" v-if="type == 2">
                                <div class="text-receive">
                                    <div><strong>{{ id_user }}</strong></div>
                                    <div>{{ message }}</div>
                                    <div class="message-info">{{ created_at }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="input-type">
                    <!-- @submit="$emit('updateBadge')" -->
                    <form method="post" @submit.prevent="sendMessageFollowUpProfessional()">
                        <input type="text" name="sent_message" placeholder="Digite..." v-model="form.input" autofocus autocomplete="off"/>
                        <b-button class="btn-send" variant="outline-primary" type="submit"><send-icon size="1.5x"></send-icon></b-button>
                    </form>
                </div>
            </div>
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

    props: {
        title: String,
        id: Number,
    },

    data(){
        return {
            role: '',
            tooltip: '',
            user: {
                requested: false,
                acceptedBy: false,
                chatId: 0,
            },
            chat: {
                messagesDoubts: [],
                messagesFollowUp: [],
                messagesFollowUpProfessional: [],
            },
            form: {
                input: '',
            }
        };
    },

    beforeMount(){
        document.title = `Chat - Elo Chagas`;
    },

    mounted(){
        document.title = `${this.title} - Elochagas`;

        axios.get('/user/role').then((response) => {
            this.role = response.data;
            this.isLoading = false;
            this.getContent(this.$route.params.id);
        }).catch((error) => console.log("error"));

    },

    methods: {
        scrollToDown(){
            $(".message-body").scrollTop($(".message-body")[0].scrollHeight);
        },

        getContent(id){
            var interval;

            if (id == 0){
                // pega as dúvidas
                clearInterval(interval);
                this.getDoubts();
            } else {
                if (this.role == 'patient'){
                    // acompanhamento
                    this.hasFollowUp();
                    this.statsFollowUp();
                    this.getMessages();
                    
                    if (this.$route.path == '/messages/1'){
                        interval = setInterval(() =>  {
                            this.getMessages();
                        }, 3000);
                    } else {
                        clearInterval(interval);
                    }
                }

                if (this.role == 'professional'){
                    this.statsFollowUp();
                    this.getMessagesProfessional();
                    
                    if (this.$route.name == 'message.patient'){
                        interval = setInterval(() =>  {
                            this.getMessagesProfessional();
                        }, 3000);
                    } else {
                        clearInterval(interval);
                    }
                }
            }
        },

        getDoubts(){
            axios.get('/user/doubts')
            .then( (response) => {
                this.chat.messagesDoubts = response.data;
            }).finally(() => {
                this.form.input = '';
                this.scrollToDown();
            }); 
        },

        sendMessage(){
            if (this.$route.params.id == 0){
                axios.post('/user/doubts/add', {
                    message: this.form.input,
                }).then(() => {
                    this.getDoubts();
                });
            }
        },

        markAsRead(read, message_id){
            if (read === false){
                axios.post('/user/doubts/mr', {
                    id: message_id,
                }).then(() => {
                    this.getDoubts();
                });
            }
        },

        // testar com computed dps
        feedbackMessage(read){
            this.tooltip = (read === false)?'Marcar como lida':'Lida';
        },

        // acompanhamento ----------------------------------------------
        requestFollowUp(){
            axios.post('/user/request/follow-up').then(() => {
                window.location.reload();
            }).catch((error) => {
                console.log("erro");
            });
        },

        hasFollowUp(){
            axios.get('/user/requested/follow-up').then((response) => {
                this.user.requested = response.data;
            }).catch((error) => {
                console.log("erro");
            });
        },

        statsFollowUp(){
            axios.get('/user/stats/follow-up').then((response) => {
                if (this.$route.name == 'chat.message'){
                    this.user.acceptedBy = response.data['name'];
                    if (this.user.acceptedBy != null){
                        this.user.chatId = response.data['id_chat'];
                    }
                } 

                if (this.$route.name == 'message.patient'){
                    this.user.chatId = response.data;
                }
            }).catch((error) => {
                console.log("erro");
            });
        },

        getMessages(){
            axios.get('/user/follow-up/get/messages').then((response) => {
                this.chat.messagesFollowUp = response.data;
            }).catch((error) => {
                console.log("erro");
            }).finally(() => {
                this.scrollToDown();
            });
        },

        getMessagesProfessional(){
            axios.get('/professional/follow-up/get/messages').then((response) => {
                console.log(response.data);
                this.chat.messagesFollowUpProfessional = response.data;
            }).catch((error) => {
                console.log("erro");
            }).finally(() => {
                this.scrollToDown();
            });
        },

        sendMessageFollowUp(){
            if (this.$route.params.id == 1){
                axios.post('/user/follow-up/add', {
                    message: this.form.input,
                    idChat: this.user.chatId,
                }).then(() => {
                    this.getMessages();
                    this.form.input = '';
                });
            }
        },

        sendMessageFollowUpProfessional(){
            if (this.$route.name == 'message.patient'){
                axios.post('/user/follow-up/add', {
                    message: this.form.input,
                    idChat: this.user.chatId,
                }).then(() => {
                    this.getMessagesProfessional();
                    this.form.input = '';
                });
            }
        },

        cancelRequestFollowUp(){
            axios.post('/user/cancel-request/follow-up').then(() => {
                console.log('Cancelado');
                window.location.reload();
            }).catch(error => console.log('Error'));
        },
    },

    watch: {
        '$route.path': function(){
            if (this.$route.name == 'chat.message')
                this.getContent(this.$route.params.id);
        }
    }

};
</script>

<style lang="scss" scoped>
*{
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

.professional-name {
    padding: 0px 15px 15px 15px;
}

.img-container {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    margin-top: 50px;

    .cover-img {
        width: 250px;
        margin-bottom: 15px;
    }
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
    padding: 15px 15px 0px 15px;
}

.box-message .message-body { 
    height: 522px;
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