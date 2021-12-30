<template>
    <div>
        <b-card-header :id="id" header-tag="header" v-b-toggle="id" class="p-1 b-hover" role="tab">
            <div class="card-info">
                <div :class="'image image-'+id"></div>
                <div>
                    <div class="card-title"><h4>{{ title }}</h4></div>
                    <div class="card-body">{{ resume }}</div>
                </div>
            </div>
        </b-card-header>
        <b-collapse :id="id" visible accordion="my-accordion" role="tabpanel">
            <b-card-body>
                <b-card-text :id="'text-'+id" style="text-align: justify;"></b-card-text>
            </b-card-body>
        </b-collapse>       
    </div>
</template>

<script>
export default {
    props: {
        id: {
            type: String,
        },
        title: {
            type: String,
        },
        resume: {
            type: String,
        },
        cover: {
            type: String,
        },
        text: {
            type: String,
        },
    },

    mounted(){
        let cover = document.querySelector(`.image-${this.id}`);
        let text = document.querySelector(`#text-${this.id}`);

        cover.style.background = `url(${this.cover})`;
        cover.style.backgroundSize = 'cover';
        cover.style.backgroundPosition = 'center';

        text.innerHTML = this.text;
    },
}
</script>

<style lang="scss" scoped>
*{
    box-sizing: border-box;
    padding: 0px;
}

.card-info {
    padding: 15px;
    display: flex;
    
    .image {
        min-width: 120px;
        width: 120px !important;
        height: 120px !important;
        border-radius: 50%;
        margin-right: 15px;
    }

    .card-title{
        font-weight: 500;
        padding: 0px 20px;
    }

    .card-body {
        padding: 0px 20px;
    }
}

.b-hover:hover,
.card-info:hover {
    background-color: #e4e0e0;
    cursor: pointer;
}

.card-content {
    display: none;
    padding: 20px;
    transition: all .1s ease;
}

@media(max-width: 1200px){
    .card-info {
        flex-wrap: wrap;
        justify-content: center;

        .image {
            margin-bottom: 20px;
        }
    }
}

</style>