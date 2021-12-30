<template>
    <div>
        <b-form @change="save()">
            <b-row class="align-rows">
                <b-col cols="4">
                    <b-form-group
                        label-align-sm="left"
                        class="mb-0"
                        v-slot="{ ariaDescribedby }"
                    >
                        <strong><label>Diurético (Furosemida/Hidroclotiazida-HCTZ)</label></strong>
                        <b-form-radio-group
                            class="pt-2"
                            v-model="form.fields.diuretic"
                            :options="['Não', 'Sim']"
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
                        <strong><label>Bloqueador (Carvedilol/Metroprol/Bisoprol)</label></strong>
                        <b-form-radio-group
                            class="pt-2"
                            v-model="form.fields.blocker"
                            :options="['Não', 'Sim']"
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
                    >
                        <strong><label>Inibidor da Enzima Conversora de Angiotensina</label></strong>
                        <b-form-radio-group
                            class="pt-2"
                            v-model="form.fields.enzymeInhibitor"
                            :options="['Não', 'IECA', 'BRA']"
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
                        <strong><label>Amiodarona (Ancoron)</label></strong>
                        <b-form-radio-group
                            class="pt-2"
                            v-model="form.fields.amiodarona"
                            :options="['Não', 'Sim']"
                            :aria-describedby="ariaDescribedby"
                        ></b-form-radio-group>
                    </b-form-group>
                </b-col>
                <b-col v-if="form.fields.amiodarona == 'Sim'" cols="3">
                    <strong><b-form-group
                        label="Tempo de uso"
                        label-for="usageTimeAmiodarona"
                        label-align-sm="left"
                        class="margin-input"
                    >
                    <b-input-group append="anos">
                        <b-form-input id="usageTimeAmiodarona" type="number" v-model="form.fields.usageTimeAmiodarona"></b-form-input>
                    </b-input-group>
                    </b-form-group></strong>
                </b-col>
            </b-row>

            <b-row class="align-rows">
                <b-col cols="4">
                    <b-form-group
                        label-align-sm="left"
                        class="mb-0"
                        v-slot="{ ariaDescribedby }"
                    >
                        <strong><label>Estatinas</label></strong>
                        <b-form-radio-group
                            class="pt-2"
                            v-model="form.fields.estatinas"
                            :options="['Não', 'Sim']"
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
                        <strong><label>Espíronolactona (Aldactone)</label></strong>
                        <b-form-radio-group
                            class="pt-2"
                            v-model="form.fields.espironolactona"
                            :options="['Não', 'Sim']"
                            :aria-describedby="ariaDescribedby"
                        ></b-form-radio-group>
                    </b-form-group>
                </b-col>

                <b-col v-if="form.fields.espironolactona == 'Sim'" cols="3">
                    <strong><b-form-group
                        label="Tempo de uso"
                        label-for="usageTimeEspironolactona"
                        label-align-sm="left"
                        class="margin-input"
                    >
                    <b-input-group append="anos">
                        <b-form-input id="usageTimeEspironolactona" type="number" v-model="form.fields.usageTimeEspironolactona"></b-form-input>
                    </b-input-group>
                    </b-form-group></strong>
                </b-col>
            </b-row>

            <b-row class="align-rows">
                <b-col cols="4">
                    <b-form-group
                        label-align-sm="left"
                        class="mb-0"
                        v-slot="{ ariaDescribedby }"
                    >
                        <strong><label>Hipoglicemiantes</label></strong>
                        <b-form-radio-group
                            class="pt-2"
                            v-model="form.fields.hipoglicemiantes"
                            :options="['Não', 'Sim']"
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
                        <strong><label>Benzodiazepinicos</label></strong>
                        <b-form-radio-group
                            class="pt-2"
                            v-model="form.fields.benzodiazepinicos"
                            :options="['Não', 'Sim']"
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
                        <strong><label>AAS</label></strong>
                        <b-form-radio-group
                            class="pt-2"
                            v-model="form.fields.aas"
                            :options="['Não', 'Sim']"
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
                    >
                        <strong><label>Hidralazina</label></strong>
                        <b-form-radio-group
                            class="pt-2"
                            v-model="form.fields.hidralazina"
                            :options="['Não', 'Sim']"
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
                        <strong><label>Levotiroxina Sódica</label></strong>
                        <b-form-radio-group
                            class="pt-2"
                            v-model="form.fields.levotiroxina"
                            :options="['Não', 'Sim']"
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
                        <strong><label>Anlodipino</label></strong>
                        <b-form-radio-group
                            class="pt-2"
                            v-model="form.fields.anlodipino"
                            :options="['Não', 'Sim']"
                            :aria-describedby="ariaDescribedby"
                        ></b-form-radio-group>
                    </b-form-group>
                </b-col>
            </b-row>
        </b-form>
    </div>
</template>

<script>
import { InfoIcon } from 'vue-feather-icons';

export default {
    components: { InfoIcon, },

    data() {
        return {
            form: {
                id: 8,
                length: 12,
                status: '',
                fields: {
                    diuretic: '',
                    blocker: '',
                    enzymeInhibitor: '',
                    amiodarona: '',
                    usageTimeAmiodarona: 0,
                    estatinas: '',
                    espironolactona: '',
                    usageTimeEspironolactona: 0,
                    hipoglicemiantes: '',
                    benzodiazepinicos: '',
                    aas: '',
                    hidralazina: '',
                    levotiroxina: '',
                    anlodipino: '',
                },
            }
        };
    },

    mounted(){
        axios.get(`/prontuary/get/${this.form.id}`).then((response) => {
            let items = response.data[0][0];
            
            this.form.status                          = items.status;
            this.form.fields.diuretic                 = items.diuretic;
            this.form.fields.blocker                  = items.blocker;
            this.form.fields.enzymeInhibitor          = items.angiotensin_inhibitor;
            this.form.fields.amiodarona               = items.amiodarone;
            this.form.fields.usageTimeAmiodarona      = items.usage_time_amidarone;
            this.form.fields.estatinas                = items.statins;
            this.form.fields.espironolactona          = items.spironolactone;
            this.form.fields.usageTimeEspironolactona = items.usage_time_spironolactone;
            this.form.fields.hipoglicemiantes         = items.hypoglycemics;
            this.form.fields.benzodiazepinicos        = items.benzodiazepines;
            this.form.fields.aas                      = items.aas;
            this.form.fields.hidralazina              = items.hydralazine;
            this.form.fields.levotiroxina             = items.levothyroxine_sodium;
            this.form.fields.anlodipino               = items.anlodipine;

            this.stateEspironolactona();
            this.stateAmiodarona();
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
                if (this.form.fields[item] != null && this.form.fields[item].toString() != '') filled++;

            // verifica o status atual do form
            if (filled == this.form.length) this.form.status = 'completed';
            else this.form.status = 'inProgress';

            // manda para o pai o status atual do form (para atualizar o stepper)
            this.$emit('progress', this.form.id, this.form.status);
        },

        stateEspironolactona(){
            if (this.form.fields.espironolactona == 'Não'){
                this.form.fields.usageTimeEspironolactona = '';
                if (this.form.length > 12) this.form.length--;
            } 
            if (this.form.fields.espironolactona == 'Sim' && this.form.length < 14){
                this.form.length++;
            } 
        },

        stateAmiodarona(){
            if (this.form.fields.amiodarona == 'Não'){
                this.form.fields.usageTimeAmiodarona = '';
                if (this.form.length > 12) this.form.length--;
            } 
            
            if (this.form.fields.amiodarona == 'Sim' && this.form.length < 14){
                this.form.length++;
            }
        }
    },

    watch: {
        'form.fields.espironolactona': function(){
            this.stateEspironolactona();
        },

        'form.fields.amiodarona': function(){
            this.stateAmiodarona();
        },
    }
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

.margin-input {
    margin-bottom: -25px;
}
</style>