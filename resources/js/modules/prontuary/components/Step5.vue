<template>
    <div>
        <b-form @change="save()">
            <b-row class="align-rows">
                <b-col cols="3">
                    <b-form-group
                        label-align-sm="left"
                        class="mb-0"
                        v-slot="{ ariaDescribedby }"
                    >
                    <strong><label>Neoplasia</label></strong>
                        <b-form-radio-group
                            class="pt-2"
                            v-model="form.fields.neoplasm"
                            :options="['Sim', 'Não']"
                            :aria-describedby="ariaDescribedby"
                        ></b-form-radio-group>
                    </b-form-group>
                </b-col>

                <b-col cols="4">
                    <b-form-group
                        label-align-sm="left"
                        class="mb-0"
                        v-slot="{ ariaDescribedby }"
                    >
                    <strong><label>História de sífilis e outras DST</label></strong>
                        <b-form-radio-group
                            class="pt-2"
                            v-model="form.fields.syphilis"
                            :options="['Sífilis', 'Não Sífilis', 'Outras DSTs']"
                            :aria-describedby="ariaDescribedby"
                        ></b-form-radio-group>
                    </b-form-group>
                </b-col>

                <b-col>
                    <strong><b-form-group
                        label="Outros (especificar)"
                        label-for="syphilisOthers"
                        label-align-sm="left"
                        v-if="form.fields.syphilis === 'Outras DSTs'"
                    >
                        <b-form-input class="margin-input" id="syphilisOthers" type="text" v-model="form.fields.syphilisOthers"></b-form-input>
                    </b-form-group></strong>
                </b-col>
            </b-row>

            <b-row class="align-rows">
                <b-col cols="3">
                    <b-form-group
                        label-align-sm="left"
                        class="mb-0"
                        v-slot="{ ariaDescribedby }"
                    >
                    <strong><label>Hepatites virais</label></strong>
                        <b-form-radio-group
                            class="pt-2"
                            v-model="form.fields.viralHepatitis"
                            :options="['Sim', 'Não']"
                            :aria-describedby="ariaDescribedby"
                        ></b-form-radio-group>
                    </b-form-group>
                </b-col>

                <b-col cols="4">
                    <b-form-group
                        label-align-sm="left"
                        class="mb-0"
                        v-slot="{ ariaDescribedby }"
                    >
                    <strong><label>Hipertensão Arterial Sistêmica</label></strong>
                        <b-form-radio-group
                            class="pt-2"
                            v-model="form.fields.arterialHypertension"
                            :options="['Sim', 'Não']"
                            :aria-describedby="ariaDescribedby"
                        ></b-form-radio-group>
                    </b-form-group>
                </b-col>

                <b-col cols="4">
                    <b-form-group
                        label-align-sm="left"
                        class="mb-0"
                        v-slot="{ ariaDescribedby }"
                    >
                    <strong><label>Diabetes Mellitus</label></strong>
                        <b-form-radio-group
                            class="pt-2"
                            v-model="form.fields.diabetesMellitus"
                            :options="['Sim', 'Não', 'Intolerância à glicose']"
                            :aria-describedby="ariaDescribedby"
                        ></b-form-radio-group>
                    </b-form-group>
                </b-col>
            </b-row>

            <b-row class="align-rows">
                <b-col cols="3">
                    <b-form-group
                        label-align-sm="left"
                        class="mb-0"
                        v-slot="{ ariaDescribedby }"
                    >
                    <strong><label>Doença Arterial Coronariana</label></strong>
                        <b-form-radio-group
                            class="pt-2"
                            v-model="form.fields.coronaryArteryDisease"
                            :options="['Sim', 'Não']"
                            :aria-describedby="ariaDescribedby"
                        ></b-form-radio-group>
                    </b-form-group>
                </b-col>

                <b-col cols="3">
                    <b-form-group
                        label-align-sm="left"
                        class="mb-0"
                        v-slot="{ ariaDescribedby }"
                    >
                    <strong><label>Dislipidemia</label></strong>
                        <b-form-radio-group
                            class="pt-2"
                            v-model="form.fields.dyslipidemia"
                            :options="['Sim', 'Não']"
                            :aria-describedby="ariaDescribedby"
                        ></b-form-radio-group>
                    </b-form-group>
                </b-col>

                <b-col cols="3">
                    <b-form-group
                        label-align-sm="left"
                        class="mb-0"
                        v-slot="{ ariaDescribedby }"
                    >
                    <strong><label>Desordens Neuropsiquiátricas</label></strong>
                        <b-form-radio-group
                            class="pt-2"
                            v-model="form.fields.neuropsychiatricDisorders"
                            :options="['Sim', 'Não']"
                            :aria-describedby="ariaDescribedby"
                        ></b-form-radio-group>
                    </b-form-group>
                </b-col>

                <b-col>
                    <strong><b-form-group
                        label="Esclarecer"
                        label-for="neuropsychiatricDisordersYes"
                        label-align-sm="left"
                        v-if="form.fields.neuropsychiatricDisorders === 'Sim'"
                    >
                        <b-form-input class="margin-input" id="neuropsychiatricDisordersYes" type="text" v-model="form.fields.neuropsychiatricDisordersYes"></b-form-input>
                    </b-form-group></strong>
                </b-col>
            </b-row>

            <b-row class="align-rows">
                <b-col cols="3">
                    <strong><b-form-group
                        label="Tabagismo"
                        label-align-sm="left"
                        class="mb-0"
                    >
                        <b-form-select id="smoking" v-model="form.fields.smoking" :options="form.smokingOptions"></b-form-select>
                    </b-form-group></strong>
                </b-col>
                <b-col cols="4">
                    <strong><b-form-group
                        label="Etilismo"
                        label-align-sm="left"
                        class="mb-0"
                    >
                        <b-form-select id="alcoholism" v-model="form.fields.alcoholism" :options="form.alcoholismOptions"></b-form-select>
                    </b-form-group></strong>
                </b-col>
                <b-col>
                    <b-form-group
                        label-align-sm="left"
                        class="mb-0"
                        v-slot="{ ariaDescribedby }"
                    >
                    <strong><label>Megaesôfago</label></strong>
                        <b-form-radio-group
                            class="pt-2"
                            v-model="form.fields.megaesophagus"
                            :options="['Sim', 'Não', 'Não existe informação']"
                            :aria-describedby="ariaDescribedby"
                        ></b-form-radio-group>
                    </b-form-group>
                </b-col>
            </b-row>

            <b-row class="align-rows">
                <b-col cols="5">
                    <b-form-group
                        label-align-sm="left"
                        class="mb-0"
                        v-slot="{ ariaDescribedby }"
                    >
                    <strong><label>Megacolón</label></strong>
                        <b-form-radio-group
                            class="pt-2"
                            v-model="form.fields.megacolon"
                            :options="['Sim', 'Não', 'Não existe informação']"
                            :aria-describedby="ariaDescribedby"
                        ></b-form-radio-group>
                    </b-form-group>
                </b-col>
                
                <b-col>
                    <b-form-group
                        label-align-sm="left"
                        class="mb-0"
                        v-slot="{ ariaDescribedby }"
                    >
                    <strong><label>Acidente Vascular Cerebral</label></strong>
                        <b-form-radio-group
                            class="pt-2"
                            v-model="form.fields.avc"
                            :options="['Sim', 'Não', 'Não existe informação']"
                            :aria-describedby="ariaDescribedby"
                        ></b-form-radio-group>
                    </b-form-group>
                </b-col>
            </b-row>

            <b-row class="align-rows">
                <b-col cols="5">
                    <b-form-group
                        label-align-sm="left"
                        class="mb-0"
                        v-slot="{ ariaDescribedby }"
                    >
                    <strong><label>Doença Pulmonar Obstrutiva Crônica</label></strong>
                        <b-form-radio-group
                            class="pt-2"
                            v-model="form.fields.pulmonaryDisease"
                            :options="['Sim', 'Não', 'Não existe informação']"
                            :aria-describedby="ariaDescribedby"
                        ></b-form-radio-group>
                    </b-form-group>
                </b-col>
                <b-col>
                    <b-form-group
                        label-align-sm="left"
                        class="mb-0"
                        v-slot="{ ariaDescribedby }"
                    >
                    <strong><label>Insuficiência Cardíaca</label></strong>
                        <b-form-radio-group
                            class="pt-2"
                            v-model="form.fields.cardiacInsufficiency"
                            :options="['Sim', 'Não', 'Não existe informação']"
                            :aria-describedby="ariaDescribedby"
                        ></b-form-radio-group>
                    </b-form-group>
                </b-col>
            </b-row>
        </b-form>
    </div>
</template>
<script>

export default {
    data() {
        return {
            form: {
                id: 5, 
                length: 15,
                status: '',
                smokingOptions: [
                    { value: 'Não', text: 'Não' },
                    { value: 'Sim', text: 'Sim' },
                    { value: 'Ex-tabagista, abandonou há mais de 1 ano', text: 'Ex-tabagista, abandonou há mais de 1 ano' },
                    { value: 'Ex-tabagista, abandonou há mais de 2 anos', text: 'Ex-tabagista, abandonou há mais de 2 anos' },
                ],
                alcoholismOptions: [
                    { value: 'Não', text: 'Não' },
                    { value: 'Sim', text: 'Sim' },
                    { value: 'Ex-etilista, abandonou há mais de 1 ano', text: 'Ex-etilista, abandonou há mais de 1 ano' },
                    { value: 'Ex-etilista, abandonou há mais de 2 anos', text: 'Ex-etilista, abandonou há mais de 2 anos' },
                ],
                fields: {
                    neoplasm: '',
                    syphilis: '',
                    syphilisOthers: '',
                    viralHepatitis: '',
                    arterialHypertension: '',
                    diabetesMellitus: '',
                    dyslipidemia: '',
                    coronaryArteryDisease: '',
                    neuropsychiatricDisorders: '',
                    neuropsychiatricDisordersYes: '',
                    smoking: '',
                    alcoholism: '',
                    megaesophagus: '',
                    megacolon: '',
                    avc: '',
                    pulmonaryDisease: '',
                    cardiacInsufficiency: '',
                },
            }
        };
    },

    mounted(){
        axios.get(`/prontuary/get/${this.form.id}`).then((response) => {
            let items = response.data[0][0];
            
            this.form.status                              = items.status;
            this.form.fields.neoplasm                     = items.neoplasm;
            this.form.fields.syphilis                     = items.syphilis_history_dsts;
            this.form.fields.syphilisOthers               = items.others_dsts_explane;
            this.form.fields.viralHepatitis               = items.viral_hepatitis;
            this.form.fields.arterialHypertension         = items.arterial_hypertension;
            this.form.fields.diabetesMellitus             = items.diabetes_mellitus;
            this.form.fields.dyslipidemia                 = items.coronary_disease;
            this.form.fields.coronaryArteryDisease        = items.dyslipidemia;
            this.form.fields.neuropsychiatricDisorders    = items.neuropsychiatric_disorders;
            this.form.fields.neuropsychiatricDisordersYes = items.neuropsychiatric_disorders_explane;
            this.form.fields.smoking                      = items.smoking;
            this.form.fields.alcoholism                   = items.alcoholism;
            this.form.fields.megaesophagus                = items.megaesophagus;
            this.form.fields.megacolon                    = items.megacolon;
            this.form.fields.avc                          = items.avc;
            this.form.fields.pulmonaryDisease             = items.chronic_lung_disease;
            this.form.fields.cardiacInsufficiency         = items.cardiac_insufficiency;
            
            this.stateSyphilis();
            this.stateNeuropsychiatricDisorders();
            this.updateFormProgress();
        }).catch((error) => { console.log(`${error}, elocode: 101`); });
    },

    methods: {
        save(){
            // salva os dados do form inclusive o status
            setTimeout(() => {
                this.$emit('save', this.form);
            }, 400);
            // this.verifyAlternatives();
            this.updateFormProgress();
        },

        updateFormProgress(){
            let filled = 0;

            // percorre os fields do form contanto quantos
            // já foram preenchidos
            for (let item in this.form.fields)
                if (this.form.fields[item] != null && 
                    this.form.fields[item].toString() != '') filled++;
            
            console.log(this.form.length, filled);

            // verifica o status atual do form
            if (filled == this.form.length) this.form.status = 'completed';
            else this.form.status = 'inProgress';

            // manda para o pai o status atual do form (para atualizar o stepper)
            this.$emit('progress', this.form.id, this.form.status);
        },

        stateSyphilis(){
            if (this.form.fields.syphilis != 'Outras DSTs'){
                this.form.fields.syphilisOthers = '';
                if (this.form.length > 15) this.form.length--;
            } 
            
            if (this.form.fields.syphilis == 'Outras DSTs' && this.form.length < 17){
                this.form.length++;
            }
        },

        stateNeuropsychiatricDisorders(){
            if (this.form.fields.neuropsychiatricDisorders == 'Não'){
                this.form.fields.neuropsychiatricDisordersYes = '';
                if (this.form.length > 15) this.form.length--;
            } 
            
            if (this.form.fields.neuropsychiatricDisorders == 'Sim' && this.form.length < 17){
                this.form.length++;
            }
        },
    },

    watch: {
        'form.fields.syphilis': function(){
            this.stateSyphilis();
        },

        'form.fields.neuropsychiatricDisorders': function(){
            this.stateNeuropsychiatricDisorders();
        },
    }
};
</script>

<style lang="scss" scoped>
.align-rows {
    margin-bottom: 50px;
}

.margin-input {
    margin-bottom: -25px;
}
</style>