<template>
    <div>
		<nav-bar/>
		<b-container>
        	<router-view :user="user"/>
		</b-container>
    </div>
</template>

<script>
import NavBar from './core/common/NavBar';

export default {

	components: {
		NavBar,
	},

    data() {
        return {
            user: {},
        };
    },

	mounted(){
        axios.get('user').then(response => {
            this.user = response.data;
        });
    },

    // methods: {
    //     backPage(){
    //         this.$router.go(-1);
    //     }
    // },
};
</script>
