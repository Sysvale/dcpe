<template>
    <div>
        {{
			user
		}}
    </div>
</template>

<script>

export default ({
    data() {
        return {
			user: 'goku',
        };
    },

	// mounted(){
    //     axios.get('panel/user').then(response => (
    //         this.user = response.data
    //     ));
    // },

    // methods: {
    //     backPage(){
    //         this.$router.go(-1);
    //     }
    // },
})
</script>

<style>

@import url('https://fonts.googleapis.com/css?family=Roboto:300,400,500,700"');
*{
	margin: 0;
	padding: 0;
	box-sizing: border-box;
	font-family: 'Roboto', sans-serif;
}

body{
	min-height: 100vh;
	overflow-x: hidden;
}

:root {
	--grey: #223333;
	--dark-blue: #0085FF;
	--blue: #85C3FF;
	--d-blue: #287bff;
	--light-grey: #bab9b9;
	--white: #FFFFFF;
	--black1: #222;
	--black2: #999;
	--bee: #2d323e;
	--bee2: #c0c2c5;
	--green: rgb(51, 179, 90);
	--bg-navigation: rgb(41, 41, 41);
}

.container{
	position: relative;
	width: 100%;
}

.navigation {
	position: fixed;
	width: 250px;
	height: 100%;
	background: var(--bg-navigation);
	transition: .5s;
	overflow: hidden;
}

.navigation .title {
	color: var(--white);
	font-size: 1.1em;
	transition: .2s;
    margin-left: -18px;
}

.navigation.active {
	width: 60px;
}

.navigation ul {
	position: absolute;
	left: 0;
	top: 0;
	width: 100%;
}

.navigation ul li {
	position: relative;
	width: 100%;
	list-style: none;
	transition: .3s;
}

.navigation ul li:hover{
	background: var(--green);
}

.navigation ul li a {
	position: relative;
	display: block;
	width: 100%;
	display: flex;
	text-decoration: none;
	color: var(--white);
}

.hovered {
	background: var(--white);
}

.navigation ul li a span {
	position: relative;
	display: block;
	min-width: 60px;
	height: 60px;
	line-height: 70px;
	text-align: center;
}

.title.active {
	margin-left: 8px;
}

.navigation ul li a .icon {
    margin-left: 18px;
	width: 1.75em;
}

.navigation ul li a span {
	position: relative;
	display: block;
	height: 55px;
	line-height: 55px;
	text-align: start;
	white-space: nowrap;
}

.group-col {
	padding-top: 15px;
	background-color: rgb(57,56,54);
	margin-top: 140px;
	display: flex;
	flex-direction: column;
	height: calc(100vh - 140px);
	justify-content: space-between;
	transition: .5s;
}

.group-col.active {
	margin-top: 65px;
	height: calc(100vh - 65px);
}

.main {
	position: absolute;
	width: calc(100% - 250px);
	left: 250px;
	min-height: 100vh;
	background: var(--white);
	transition: .5s;
}

.main.active {
	width: calc(100% - 60px);
	left: 60px;
}

.main-content {
    padding: 15px;
}

/* responsividade */
@media (max-width: 991px){
	.navigation {
		left: -250px;
	}

	.navigation.active {
		width: 250px;
		left: 0;
	}

	.main {
		width: 100%;
		left: 0;
	}

	.main.active {
		left: 250px;
	}

	.cardbox {
		grid-template-columns: repeat(2, 1fr);
	}
}

@media (max-width: 768px) {
	.details {
		grid-template-columns: repeat(1, 1fr);
	}
}

@media (max-width: 480px){
	.cardbox {
		grid-template-columns: repeat(1, 1fr);
	}
	.user {
		min-width: 40px;
	}
	.navigation {
		width: 100%;
		left: -100%;
		z-index: 1000;
	}
	.navigation.active {
		width: 100%;
		left: 0;
		overflow-x: hidden;
	}
	.toggle {
		z-index: 10001;
	}
	.main.active .toggle {
		position: relative;
		top: 0;
	}
}
</style>