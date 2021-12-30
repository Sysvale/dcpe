<template>
    <div>
        <b-form @change="save()">
            <b-row class="align-rows">
                <b-col>
                    <b-form-group
                        label-align-sm="left"
                        class="mb-0"
                        v-slot="{ ariaDescribedby }"
                    >
                        <strong><label>Uso de Benznidazol</label></strong>
                        <b-form-radio-group
                            class="pt-2"
                            v-model="form.fields.benznidazol"
                            :options="['Não', 'Sim', 'Tratamento incompleto', 'BENEFIT']"
                            :aria-describedby="ariaDescribedby"
                        ></b-form-radio-group>
                    </b-form-group>
                </b-col>
            </b-row>
            <div v-if="form.fields.benznidazol != 'Não' && form.fields.benznidazol != ''">
                <b-row class="align-rows">
                    <b-col cols="3">
                        <strong><b-form-group
                            label="Ano de uso do Benznidazol"
                            label-align-sm="left"
                            class="mb-0"
                        >
                            <b-form-input type="number" v-model="form.fields.benznidazolYear"></b-form-input>
                        </b-form-group></strong>
                    </b-col>

                    <b-col cols="3">
                        <b-form-group
                            label-align-sm="left"
                            class="mb-0"
                            v-slot="{ ariaDescribedby }"
                        >
                            <strong><label>Forma de apresentação</label></strong>
                            <b-form-radio-group
                                class="pt-2"
                                v-model="form.fields.formOfPresentation"
                                :options="['Adulto', 'Pediátrico']"
                                :aria-describedby="ariaDescribedby"
                            ></b-form-radio-group>
                        </b-form-group>
                    </b-col>
                </b-row>

                <b-row class="align-rows">
                    <b-col cols="4">
                        <strong><b-form-group
                            label="Dosagem diária do tratamento"
                            label-for="dailyDosage"
                            label-align-sm="left"
                        >
                        <b-input-group append="mg">
                            <b-form-input v-mask="['#,##', '##,##', '###,###']" id="dailyDosage" type="text" v-model="form.fields.dailyDosage"></b-form-input>
                        </b-input-group>
                        </b-form-group></strong>
                    </b-col>
                    <b-col cols="4">
                        <strong><b-form-group
                            label="Tempo de uso "
                            label-for="usageTime"
                            label-align-sm="left"
                        >
                        <b-input-group append="dias">
                            <b-form-input id="usageTime" type="number" v-model="form.fields.usageTime"></b-form-input>
                        </b-input-group>
                        </b-form-group></strong>
                    </b-col>
                </b-row>
            </div>
        </b-form>
    </div>
</template>

<script>
import { InfoIcon } from 'vue-feather-icons';
import { mask } from 'vue-the-mask';

export default {
    components: { InfoIcon, },
    directives: { mask },

    data() {
        return {
            form: {
                id: 7,
                length: 1,
                status: '',
                fields: {
                    benznidazol: '',
                    benznidazolYear: '',
                    formOfPresentation: '',
                    dailyDosage: 0,
                    usageTime: 0,
                }
            }
        };
    },

    mounted(){
        axios.get(`/prontuary/get/${this.form.id}`).then((response) => {
            let items = response.data[0][0];
            
            this.form.status                    = items.status;
            this.form.fields.benznidazol        = items.benznidazol;
            this.form.fields.benznidazolYear    = items.year_benznidazol;
            this.form.fields.formOfPresentation = items.form_of_presentation;
            this.form.fields.dailyDosage        = items.daily_dosage;
            this.form.fields.usageTime          = items.usage_time_benznidazol;
            
            this.verifyAlternatives();
            this.updateFormProgress();
        }).catch((error) => { console.log(`${error}, elocode: 101`); });
    },

    methods: {
        save(){
            // salva os dados do form inclusive o status
            setTimeout(() => {
                this.$emit('save', this.form);
            }, 400);
            this.verifyAlternatives();
            this.updateFormProgress();
        },

        updateFormProgress(){
            let filled = 0;

            // percorre os fields do form contanto quantos
            // já foram preenchidos
            if (this.form.length != 1){
                for (let item in this.form.fields)
                    if (this.form.fields[item] != null && this.form.fields[item].toString() != '') filled++;
            } else {
                filled = 1;
            }

            // verifica o status atual do form
            if (filled == this.form.length) this.form.status = 'completed';
            else this.form.status = 'inProgress';

            // manda para o pai o status atual do form (para atualizar o stepper)
            this.$emit('progress', this.form.id, this.form.status);
        },
        
        verifyAlternatives(){
            let length = this.form.length;

            if (this.form.fields.benznidazol != 'Não' &&
                this.form.fields.benznidazol != '' &&
                this.form.fields.benznidazol != null){
                length += (this.form.length == 5)?0:4;
                
                this.form.length = length;
            } 

            if (this.form.length > 1 && this.form.fields.benznidazol === 'Não')
                this.form.length = 1;
        },
    },
}
</script>

<style lang="scss" scoped>
.set-display{
    display: flex;

    .icon-tooltip {
        margin: 3px 0px 0px 3px;
        color: #3A7EDF;
    }
}

.align-rows {
    margin-bottom: 35px;
}
</style>