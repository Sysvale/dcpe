<template>
    <div>
        {{ title }}
    </div>
</template>

<script> 
export default {
    data(){
        return {
            title: 'Page not found',
        };
    },

    beforeMount(){
        document.title = `${this.$route.meta.alias} - Elo Chagas`;
    },
};
</script>