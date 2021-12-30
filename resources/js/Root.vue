<template>
    <div>
		<nav-bar/>
		<b-container>
        	<router-view/>
		</b-container>
    </div>
</template>

<script>
import NavBar from './core/common/NavBar';

export default {

	components: {
		NavBar,
	},
};
</script>
