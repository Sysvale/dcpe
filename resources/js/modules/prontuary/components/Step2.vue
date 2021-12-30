<template>
    <div>
        <b-form @change="save()">
            <b-row style="margin-bottom: 10px">
                <b-col>
                    <strong><b-form-group
                        label="Grau de Instrução"
                        label-align-sm="left"
                        class="mb-0"
                    >
                        <b-form-select id="educationLevel" v-model="form.fields.educationLevel" :options="form.educationLevelOptions"></b-form-select>
                    </b-form-group></strong>
                </b-col>
                <b-col>
                    <strong><b-form-group
                        label="Renda per Capita"
                        label-align-sm="left"
                        class="mb-0"
                    >
                        <b-form-select id="perCapitaIncome" v-model="form.fields.perCapitaIncome" :options="form.perCapitaIncomeOptions"></b-form-select>
                    </b-form-group></strong>
                </b-col>
            </b-row>

            <b-row>
                <b-col cols="3">
                    <strong><b-form-group
                        label="Número de Habitantes"
                        label-for="numberOfInhabitants"
                        label-align-sm="left"
                    >
                        <b-form-spinbutton id="numberOfInhabitants" v-model="form.fields.numberOfInhabitants" min="1"></b-form-spinbutton>
                    </b-form-group></strong>
                </b-col>

                <b-col>
                    <strong><b-form-group
                        label="Situação Laborativa"
                        label-align-sm="left"
                        class="mb-0"
                    >
                        <b-form-select id="workSituation" v-model="form.fields.workSituation" :options="form.workSituationOptions"></b-form-select>
                    </b-form-group></strong>
                </b-col>

                <b-col>
                    <strong><b-form-group
                        label="Profissão"
                        label-align-sm="left"
                        class="mb-0"
                    >
                        <b-form-select id="profission" v-model="form.fields.profission" :options="form.profissionOptions"></b-form-select>
                    </b-form-group></strong>
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
                id: 2,
                length: 5,
                status: '',
                educationLevelOptions: [
                    { value: 'Analfabeto', text: 'Analfabeto' },
                    { value: '1ª a 4ª série incompleta do Ensino Fundamental', text: '1ª a 4ª série incompleta do Ensino Fundamental (antigo primário ou 1º grau)' },
                    { value: '4ª Série completa do Ensino Fundamental', text: '4ª Série completa do Ensino Fundamental' },
                ],
                perCapitaIncomeOptions: [
                    { value: 'Sem renda', text: 'Sem renda' },
                    { value: 'Até 1 Salário Mínimo,', text: 'Até 1 Salário Mínimo' },
                    { value: 'Até 2 Salários Mínimos', text: 'Até 2 Salários Mínimos' },
                    { value: 'Até 3 Salários Mínimos', text: 'Até 3 Salários Mínimos' },
                    { value: 'Até 4 Salários Mínimos', text: 'Até 4 Salários Mínimos' },
                    { value: 'Até 5 Salários Mínimos', text: 'Até 5 Salários Mínimos' },
                    { value: 'Até 6 Salários Mínimos', text: 'Até 6 Salários Mínimos' },
                    { value: 'Mais de 6 Salários Mínimos', text: 'Mais de 6 Salários Mínimos' },
                ],
                workSituationOptions: [
                    { value: 'Aposentado', text: 'Aposentado' },
                    { value: 'Ativo', text: 'Ativo' },
                    { value: 'Desempregado', text: 'Desempregado' },
                    { value: 'Benefício', text: 'Benefício' },
                    { value: 'Outros', text: 'Outros' },
                ],
                profissionOptions: [
                    { value: 'Lar', text: 'Lar' },
                    { value: 'Técnico', text: 'Técnico' },
                    { value: 'Motorista', text: 'Motorista' },
                    { value: 'Trabalhador rural-agricultor', text: 'Trabalhador rural-agricultor' },
                    { value: 'Comerciante', text: 'Comerciante' },
                    { value: 'Secretário', text: 'Secretário' },
                    { value: 'Professor', text: 'Professor' },
                    { value: 'Profissional Liberal', text: 'Profissional Liberal' },
                    { value: 'Doméstica', text: 'Doméstica' },
                ],
                fields: {
                    educationLevel: '',
                    perCapitaIncome: '',
                    numberOfInhabitants: 1,
                    workSituation: '',
                    profission: '',
                },
            }
        };
    },

    mounted(){
        axios.get('/prontuary/get/2').then((response) => {
            let items = response.data[0][0];
            
            this.form.status                     = items.status;
            this.form.fields.educationLevel      = items.education_level;
            this.form.fields.perCapitaIncome     = items.per_capita_income;
            this.form.fields.numberOfInhabitants = items.number_of_inhabitants;
            this.form.fields.workSituation       = items.work_status;
            this.form.fields.profission          = items.profission;

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
                if (this.form.fields[item] != null && this.form.fields[item] != '') filled++;
            
            // verifica o status atual do form
            if (filled == this.form.length) this.form.status = 'completed';
            else this.form.status = 'inProgress';

            // manda para o pai o status atual do form (para atualizar o stepper)
            this.$emit('progress', this.form.id, this.form.status);
        }
    },
};
</script>
