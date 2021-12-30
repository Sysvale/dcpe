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
                    <strong><label>Portador da Doença de Chagas?</label></strong>
                        <b-form-radio-group
                            class="pt-2"
                            v-model="form.fields.hasDc"
                            :options="['Sim', 'Não']"
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
                    <strong><label>Possui Sorologia?</label></strong>
                        <b-form-radio-group
                            class="pt-2"
                            v-model="form.fields.serology"
                            :options="['Sim', 'Não']"
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
                    <strong><label>Doença de chagas na família?</label></strong>
                        <b-form-radio-group
                            class="pt-2"
                            v-model="form.fields.caseInTheFamily"
                            :options="['Sim', 'Não']"
                            :aria-describedby="ariaDescribedby"
                        ></b-form-radio-group>
                    </b-form-group>
                </b-col>
                <b-col>
                    <strong><b-form-group
                        label="Quem?"
                        label-for="caseInTheFamilyYes"
                        label-align-sm="left"
                        v-if="form.fields.caseInTheFamily === 'Sim'"
                    >
                        <b-form-input class="margin-input" id="caseInTheFamilyYes" type="text" v-model="form.fields.caseInTheFamilyYes"></b-form-input>
                    </b-form-group></strong>
                </b-col>
            </b-row>

            <b-row class="align-rows">
                <b-col cols="4">
                    <strong><b-form-group
                        label="Doença de Chagas na família (vivos/falecidos)"
                        label-for="numberOfCaseInFamily"
                        label-align-sm="left"
                    >
                        <b-form-spinbutton class="margin-input" id="numberOfCaseInFamily" v-model="form.fields.numberOfCaseInFamily" min="0"></b-form-spinbutton>
                    </b-form-group></strong>
                </b-col>
                <b-col>
                    <b-form-group
                        label-align-sm="left"
                        class="mb-0"
                        v-slot="{ ariaDescribedby }"
                    ><strong><label>Conhece o vetor?</label></strong>
                        <b-form-radio-group
                            class="pt-2"
                            v-model="form.fields.knowTheVector"
                            :options="['Sim', 'Não', 'Não sabe informar']"
                            :aria-describedby="ariaDescribedby"
                        ></b-form-radio-group>
                    </b-form-group>
                </b-col>
            </b-row>

            <b-row class="align-rows">
                <b-col cols="4">
                    <b-form-group
                        label-align-sm="left"
                        class="mb-0"
                        v-slot="{ ariaDescribedby }"
                    ><strong><label>Morou/Mora em casa de taipa?</label></strong>
                        <b-form-radio-group
                            class="pt-2"
                            v-model="form.fields.livedTaipa"
                            :options="['Sim', 'Não', 'Não sabe informar']"
                            :aria-describedby="ariaDescribedby"
                        ></b-form-radio-group>
                    </b-form-group>
                </b-col>
                <b-col cols="4">
                    <b-form-group
                        label-align-sm="left"
                        class="mb-0"
                        v-slot="{ ariaDescribedby }"
                    ><strong><label>Zona de moradia</label></strong>
                        <b-form-radio-group
                            class="pt-2"
                            v-model="form.fields.dwellingArea"
                            :options="['Zona Rural', 'Zona Urbana']"
                            :aria-describedby="ariaDescribedby"
                        ></b-form-radio-group>
                    </b-form-group>
                </b-col>
                <b-col cols="4">
                    <b-form-group
                        label-align-sm="left"
                        label-for="dwellingAreaYears"
                        class="mb-0"
                        v-if="form.fields.dwellingArea == 'Zona Rural'"
                    ><strong><label>Tempo de moradia na área rural (em anos)</label></strong>
                        <b-form-spinbutton class="margin-input" id="dwellingAreaYears" v-model="form.fields.dwellingAreaYears" min="0"></b-form-spinbutton>
                    </b-form-group>
                </b-col>
            </b-row>
            <b-row class="align-rows">
                <b-col cols="4">
                    <b-form-group
                        label-align-sm="left"
                        class="mb-0"
                        v-slot="{ ariaDescribedby }"
                    ><strong><label>Residência tem ou tinha criadouro?</label></strong>
                        <b-form-radio-group
                            class="pt-2"
                            v-model="form.fields.breedingResidence"
                            :options="['Sim', 'Não', 'Não sabe informar']"
                            :aria-describedby="ariaDescribedby"
                        ></b-form-radio-group>
                    </b-form-group>
                </b-col>
                <b-col cols="4">
                    <b-form-group
                        label-align-sm="left"
                        class="mb-0"
                        v-slot="{ ariaDescribedby }"
                    ><strong><label>Já doou sangue?</label></strong>
                        <b-form-radio-group
                            class="pt-2"
                            v-model="form.fields.donatedBlood"
                            :options="['Sim', 'Não', 'Não sabe informar']"
                            :aria-describedby="ariaDescribedby"
                        ></b-form-radio-group>
                    </b-form-group>
                </b-col>
                <b-col cols="4">
                    <b-form-group
                        label-align-sm="left"
                        class="mb-0"
                        v-slot="{ ariaDescribedby }"
                    ><strong><label>Já recebeu sangue?</label></strong>
                        <b-form-radio-group
                            class="pt-2"
                            v-model="form.fields.receivedBlood"
                            :options="['Sim', 'Não', 'Não sabe informar']"
                            :aria-describedby="ariaDescribedby"
                        ></b-form-radio-group>
                    </b-form-group> 
                </b-col>
            </b-row>
        </b-form>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            form: {
                id: 3,
                length: 9,
                status: '',
                fields: {
                    hasDc: '',
                    serology: '',
                    caseInTheFamily: '',
                    caseInTheFamilyYes: '',
                    numberOfCaseInFamily: 0,
                    knowTheVector: '',
                    dwellingArea: '',
                    dwellingAreaYears: 0,
                    livedTaipa: '',
                    breedingResidence: '',
                    donatedBlood: '',
                    receivedBlood: '',
                },
            }
        };
    },

    mounted(){
        axios.get(`/prontuary/get/${this.form.id}`).then((response) => {
            let items = response.data[0][0];
            
            this.form.status                      = items.status;
            this.form.fields.hasDc                = items.has_dc;
            this.form.fields.serology             = items.has_serology;
            this.form.fields.caseInTheFamily      = items.dc_in_family;
            this.form.fields.caseInTheFamilyYes   = items.dc_in_family_who;
            this.form.fields.numberOfCaseInFamily = items.dc_in_family_vf;
            this.form.fields.knowTheVector        = items.know_the_vector;
            this.form.fields.dwellingArea         = items.lived_in_a_mud_house;
            this.form.fields.dwellingAreaYears    = items.time_in_a_mud_house;
            this.form.fields.livedTaipa           = items.dwelling_area;
            this.form.fields.breedingResidence    = items.has_breeding;
            this.form.fields.donatedBlood         = items.donated_blood;
            this.form.fields.receivedBlood        = items.received_blood;
            
            this.updateFormProgress();
        }).catch((error) => { console.log(`${error}, elocode: 101`); });
    },

    methods: {
        save(){
            // salva os dados do form inclusive o status
            setTimeout(() => {
                this.verifyAlternatives();
                this.$emit('save', this.form);
            }, 400);
            this.updateFormProgress();
        },

        verifyAlternatives(){
            let length = this.form.length;

            if (this.form.fields.caseInTheFamily === 'Sim')     length++;
            if (this.form.fields.dwellingArea === 'Zona Rural') length++;
            
            this.form.length = length;
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
        }
    },

    watch: {
        'form.fields.numberOfCaseInFamily': function(){
            this.save();
        },

        'form.fields.dwellingAreaYears': function(){
            this.save();
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