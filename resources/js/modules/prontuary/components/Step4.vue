<template>
    <div>
        <b-form @change="save()">
            <b-row class="align-rows">
                <b-col cols="4">
                    <strong><b-form-group
                        label="Peso"
                        label-for="weight"
                        label-align-sm="left"
                    >
                    <b-input-group append="kg">
                        <b-form-input v-mask="['##,##','###,##']" id="weight" type="text" v-model="form.fields.weight"></b-form-input>
                    </b-input-group>
                    </b-form-group></strong>
                </b-col>

                <b-col cols="4">
                    <strong><b-form-group
                        label="Altura"
                        label-for="height"
                        label-align-sm="left"
                    >
                    <b-input-group append="m">
                        <b-form-input v-mask="'#,##'" id="height" type="text" v-model="form.fields.height"></b-form-input>
                    </b-input-group>
                    </b-form-group></strong>
                </b-col>

                <b-col cols="4">
                    <strong><b-form-group
                        label="IMC"
                        label-for="imc"
                        label-align-sm="left"
                    >
                    <b-input-group append="kg/m²">
                        <b-form-input id="imc" type="text" v-model="getIMC" disabled></b-form-input>
                    </b-input-group>
                    </b-form-group></strong>
                </b-col>

            </b-row>
        </b-form>
    </div>
</template>

<script>
import { mask } from 'vue-the-mask';

export default {
    directives: { mask },

    data() {
        return {
            form: {
                id: 4,
                length: 3,
                status: '',
                fields: {
                    weight: '',
                    height: '',
                    imc: '',
                },
            }
        };
    },

    mounted(){
        axios.get(`/prontuary/get/${this.form.id}`).then((response) => {
            let items = response.data[0][0];
            
            this.form.status        = items.status;
            this.form.fields.weight = items.weight;
            this.form.fields.height = items.height;
            this.form.fields.imc    = items.imc;
            
            this.updateFormProgress();
        }).catch((error) => { console.log(`${error}, elocode: 101`); });
    },

    methods: {
        save(){
            // salva os dados do form inclusive o status
            setTimeout(() => {
                this.$emit('save', this.form);
            }, 400);
            this.updateFormProgress();
        },

        updateFormProgress(){
            let filled = 0;

            // percorre os fields do form contanto quantos
            // já foram preenchidos
            for (let item in this.form.fields)
                if (this.form.fields[item] != null && this.form.fields[item].toString() != '') filled++;

            // verifica o status atual do form
            if (filled == this.form.length || filled == this.form.length+2) this.form.status = 'completed';
            else this.form.status = 'inProgress';

            // manda para o pai o status atual do form (para atualizar o stepper)
            this.$emit('progress', this.form.id, this.form.status);
        },
    },

    computed: {
        getIMC(){
            if (this.form.fields.weight != '' && this.form.fields.height != '' && parseInt(this.form.fields.height, 10) != 0){
                let formatedWeight = parseFloat(this.form.fields.weight.replace(',','.'));
                let formatedHeight = parseFloat(this.form.fields.height.replace(',','.'));
                
                this.form.fields.imc = formatedWeight/Math.pow(formatedHeight, 2);
                this.form.fields.imc = this.form.fields.imc.toFixed(1).toString().replace('.',',');

                return this.form.fields.imc;
            } else 
                return this.form.fields.imc;
        },
    }
};
</script>