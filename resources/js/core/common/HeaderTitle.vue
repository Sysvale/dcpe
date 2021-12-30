<template>
    <div class="header">
        <div class="title">
            <h2>{{ title }}</h2>
            <info-icon v-if="hasTooltip" v-b-tooltip.hover :title="tooltip" size="1.5x" class="pos-tooltip"></info-icon>
        </div>
        <span class="subtitle">{{ subtitle }}</span>
        <hr/>
    </div>
</template>

<script>
import { InfoIcon } from 'vue-feather-icons';

export default {
    components: {
        InfoIcon,
    },

    props: {
        title: String,
        subtitle: String,
        tooltip: String,
        hasTooltip: Boolean,
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

.title {
    display: flex;
}

.pos-tooltip {
    margin: 8px 0px 0px 10px;
    color: #5d5d5d;
}

.subtitle {
    font-size: 1rem;
}
</style>