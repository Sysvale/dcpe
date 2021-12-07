<template>
    <div class="card-msg" @click="redirect(`/messages/${id}`)">
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
</template>

<script>
export default {
    name: 'CardMessage',

    props: {
        id: {
            type: Number,
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
    },
    
    methods: {
        redirect(path_name){
            if (this.$route.path != path_name)
                this.$router.push(path_name);
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

.card-msg {
    background-color: #ddd;
    height: 60px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px;
    padding-right: 20px;
}

.msg-left-content {
    display: flex;
}

.card-msg.read {
    background: #fff;
}

.card-msg:hover {
    background-color: #ccc;
    cursor: pointer;
}

.card-msg .cover-msg img {
    width: 40px;
}

.msg-info {
    margin-left: 10px;
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