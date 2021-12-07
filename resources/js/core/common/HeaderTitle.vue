<template>
    <div class="header">
        <div class="title"><h2>{{ title }}</h2></div>
        <span class="subtitle">{{ subtitle }}</span>
        <hr/>
    </div>
</template>

<script>

export default {
    props: {
        title: String,
        subtitle: String,
    },

    data() {
        return {

        };
    },
};

</script>

<style scoped>

.header {
    margin-top: 20px;
    margin-bottom: 20px;
}

.subtitle {
    font-size: 1rem;
}
</style>