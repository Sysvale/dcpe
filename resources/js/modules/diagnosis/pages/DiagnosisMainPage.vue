<template>
    <div>
        {{ $route.meta.alias }}
    </div>
</template>

<script> 

export default {
    data(){
        return {
        };
    },

    beforeMount(){
        document.title = `${this.$route.meta.alias} - Elo Chagas`;
    },
};
</script>
