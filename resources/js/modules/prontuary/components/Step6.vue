<template>
    <div>
        <b-form @change="save()">
            <b-row class="align-rows">
                <b-col>
                    <strong><b-form-group
                        label="Radiografia do Toráx"
                        label-align-sm="left"
                        class="mb-0"
                    >
                        <b-form-select id="chestXray" v-model="form.fields.chestXray" :options="form.chestXrayOptions"></b-form-select>
                    </b-form-group></strong>
                </b-col>

                <b-col>
                    <strong><b-form-group
                        label="Radiografia do Esôfago"
                        label-align-sm="left"
                        class="mb-0"
                    >
                        <b-form-select id="esophagealRadiography" v-model="form.fields.esophagealRadiography" :options="form.esophagealRadiographyOptions"></b-form-select>
                    </b-form-group></strong>
                </b-col>
            </b-row>

            <b-row class="align-rows">
                <b-col cols="3">
                    <strong><b-form-group
                        label="Eletrocardiograma"
                        label-align-sm="left"
                        class="mb-0"
                    >
                        <b-form-select id="electrocardiogram" v-model="form.fields.electrocardiogram" :options="form.electrocardiogramOptions"></b-form-select>
                    </b-form-group></strong>
                </b-col>
                <b-col>
                    <b-form-group
                        label-align-sm="left"
                        class="mb-0"
                        v-slot="{ ariaDescribedby }"
                    >
                        <strong><label>Marca-passo</label></strong>
                        <b-form-radio-group
                            class="pt-2"
                            v-model="form.fields.pacemaker"
                            :options="['Não', 'Sim', 'Não existe informação']"
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
                        <strong><label>Transplante Cardíaco</label></strong>
                        <b-form-radio-group
                            class="pt-2"
                            v-model="form.fields.heartTransplantation"
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
                id: 6, 
                length: 5,
                status: '',
                chestXrayOptions: [
                    { value: 'Não realizado', text: 'Não realizado' },
                    { value: 'Normal', text: 'Normal' },
                    { value: 'Aumento da Área Cardíaca (AC)', text: 'Aumento da Área Cardíaca (AC)' },
                    { value: 'Infiltrado', text: 'Infiltrado' },
                ],
                esophagealRadiographyOptions: [
                    { value: 'Não realizado', text: 'Não realizado' },
                    { value: 'Normal', text: 'Normal' },
                    { value: 'Alterado', text: 'Alterado' },
                    { value: 'Não existe informação', text: 'Não existe informação' },
                ],
                electrocardiogramOptions: [
                    { value: 'Normal', text: 'Normal' },
                    { value: 'Apresenta alterações', text: 'Apresenta alterações' },
                    { value: 'Outros', text: 'Outros' },
                    { value: 'Não existe informação', text: 'Não existe informação' },
                ],
                fields: {
                    chestXray: '',
                    esophagealRadiography: '',
                    electrocardiogram: '',
                    pacemaker: '',
                    heartTransplantation: '',
                },
            }
        };
    },

    mounted(){
        axios.get(`/prontuary/get/${this.form.id}`).then((response) => {
            let items = response.data[0][0];
            
            this.form.status                        = items.status;
            this.form.fields.chestXray              = items.rx_chest;
            this.form.fields.esophagealRadiography  = items.rx_esophagus;
            this.form.fields.electrocardiogram      = items.electrocardiogram;
            this.form.fields.pacemaker              = items.pacemaker;
            this.form.fields.heartTransplantation   = items.heart_transplantation;
            
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
            if (filled == this.form.length) this.form.status = 'completed';
            else this.form.status = 'inProgress';

            // manda para o pai o status atual do form (para atualizar o stepper)
            this.$emit('progress', this.form.id, this.form.status);
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