<template>
    <div>
        {{ title }}
    </div>
</template>

<script>

export default {
    data() {
        return {
            title: 'No steps',
        };        
    },

    beforeMount(){
        document.title = `${this.$route.meta.alias} - Elo Chagas`;
    },
};
</script>
