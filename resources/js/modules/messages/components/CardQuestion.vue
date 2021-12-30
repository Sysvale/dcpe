<template>
    <div>
        <b-card-header :id="id" header-tag="header" v-b-toggle="id" class="p-1 b-hover" role="tab">
            <div class="card-info">
                <div>
                    <div class="card-title">Dúvida de: {{ name }}</div>
                    <div class="card-body">"{{ message }}"</div>
                </div>
                <div style="font-size: 14px;">
                    <h6><b-badge variant="secondary">{{ time }}</b-badge></h6>
                </div>
            </div>
        </b-card-header>
        <b-collapse :id="id" visible accordion="my-accordion" role="tabpanel">
            <b-card-body>
                <h4>Responder</h4>
                <div  class="input-type">
                    <form method="post" @submit.prevent="sendAnswer()">
                        <input type="text" name="sent_message" placeholder="Digite..." v-model="form.input" autofocus autocomplete="off"/>
                        <b-button class="btn-send" variant="outline-primary" type="submit"><send-icon size="1.5x"></send-icon></b-button>
                    </form>
                </div>
            </b-card-body>
        </b-collapse>       
    </div>
</template>

<script>
import { SendIcon } from 'vue-feather-icons';

export default {
    components: {
        SendIcon,
    },

    props: {
        id: String,
        idUseR: String,
        name: String,
        message: String,
        time: String,
    },

    data(){
        return {
            form: {
                input: '',
            }
        };
    },

    methods: {
        sendAnswer(){
            axios.post('/professional/doubts/answer', {
                message: this.form.input,
                idDoubt: this.id,
            }).then(() => {
                console.log(this.form.input, this.id);
                this.form.input = '';
                this.$emit('update');
            });
        }
    }
   
}
</script>

<style lang="scss" scoped>
*{
    box-sizing: border-box;
    padding: 0px;
}

.input-type {
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

.card-info {
    padding: 15px;
    display: flex;
    justify-content: space-between;
    
    .image {
        min-width: 120px;
        width: 120px !important;
        height: 120px !important;
        border-radius: 50%;
        margin-right: 15px;
    }

    .card-title{
        font-weight: 500;
        font-size: 20px;
        padding: 0px 20px;
    }

    .card-body {
        padding: 0px 20px;
    }
}

.b-hover:hover,
.card-info:hover {
    background-color: #e4e0e0;
    cursor: pointer;
}

.card-content {
    display: none;
    padding: 20px;
    transition: all .1s ease;
}

@media(max-width: 1200px){
    .card-info {
        flex-wrap: wrap;
        justify-content: center;

        .image {
            margin-bottom: 20px;
        }
    }
}

</style>