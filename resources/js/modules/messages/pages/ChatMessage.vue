<template>
    <div>
        <div v-if="$route.params.id == 0">
            <chat
                title="Tire suas dúvidas"
                :id="parseInt($route.params.id)"
            />
        </div>
        <div v-if="$route.params.id == 1">
            <chat
                title="Acompanhamento"
                :id="parseInt($route.params.id)"
            />
        </div>
    </div>
</template> 

<script>
import axios from 'axios';
import Chat from '../components/Chat';

export default {
    components: {
        Chat,
    },

    beforeMount(){
        document.title = `Mensagens - Elo Chagas`;
    },
}

</script>