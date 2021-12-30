<template>
    <div>
        <b-form @change="save()">
            <b-row>
                <b-col cols="8">
                    <strong><b-form-group
                        label="Nome completo"
                        label-for="name"
                        label-align-sm="left"
                    >
                        <b-form-input id="name" type="text" v-model="form.fields.name"></b-form-input>
                    </b-form-group></strong>
                </b-col>

                <b-col cols="3">
                    <strong><b-form-group
                        label="Data de nascimento"
                        label-for="birthday"
                        label-align-sm="left"
                    >
                        <b-form-input name="birthday" type="date" v-model="form.fields.birthdate"></b-form-input>
                    </b-form-group></strong>
                </b-col>
            </b-row>
            <b-row>
                <b-col>
                    <strong><b-form-group label-align-sm="left">
                        <div class="set-display">
                            <label for="cityOfBirth">Município de Naturalidade</label>
                            <info-icon class="icon-tooltip" size="1x" v-b-tooltip.hover title="Município de naturalidade é a indicação do nome da cidade onde determinada pessoa nasceu. "></info-icon>
                        </div>
                        <b-form-input id="cityOfBirth" type="text" v-model="form.fields.cityOfBirth"></b-form-input>
                    </b-form-group></strong>
                    
                </b-col>

                <b-col>
                    <strong><b-form-group
                        label="Município de Procedência"
                        label-for="cityOfOrigin"
                        label-align-sm="left"
                    >
                        <b-form-input id="cityOfOrigin" type="text" v-model="form.fields.cityOfOrigin"></b-form-input>
                    </b-form-group></strong>
                </b-col>

                <b-col>
                    <strong><b-form-group
                        label="Telefone"
                        label-for="phone"
                        label-align-sm="left"
                    >
                        <b-form-input id="phone" type="text" v-mask="'(##) #####-####'" placeholder="(55) 88888-8888" v-model="form.fields.phone"></b-form-input>
                    </b-form-group></strong>
                </b-col>
            </b-row>

            <b-row>
                <b-col>
                    <strong><b-form-group
                        label="Estado Civil"
                        label-align-sm="left"
                        class="mb-0"
                    >
                        <b-form-select id="maritalStatus" v-model="form.fields.maritalStatus" :options="form.maritalOptions"></b-form-select>
                    </b-form-group></strong>
                </b-col>
                <b-col>
                    <strong><b-form-group
                        label="Raça/ Cor"
                        label-align-sm="left"
                        class="mb-0"
                    >
                        <b-form-select id="breed" v-model="form.fields.breed" :options="form.breedOptions"></b-form-select>
                    </b-form-group></strong>
                </b-col>
                <b-col>
                    <b-form-group
                        label-align-sm="left"
                        class="mb-0"
                        v-slot="{ ariaDescribedby }"
                    >
                        <strong><label>Sexo</label></strong>
                        <b-form-radio-group
                            class="pt-2"
                            v-model="form.fields.sex"
                            :options="['Masculino', 'Feminino']"
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
import { mask } from 'vue-the-mask';
import { InfoIcon } from 'vue-feather-icons';

export default {
    components: { InfoIcon, },
    directives: { mask },

    data() {
        return {
            form: {
                id: 1,
                length: 8,
                status: '',
                maritalOptions: [
                    { value: 'Solteiro(a)', text: 'Solteiro(a)' },
                    { value: 'Casado/Tem companheiro(a)', text: 'Casado/Tem companheiro(a)' },
                    { value: 'Divorciado(a)', text: 'Divorciado(a)' },
                    { value: 'Viúvo(a)', text: 'Viúvo(a)' }
                ],
                breedOptions: [
                    { value: 'Branco', text: 'Branco' },
                    { value: 'Preto', text: 'Preto' },
                    { value: 'Pardo', text: 'Pardo' },
                    { value: 'Amarela', text: 'Amarela' },
                    { value: 'Indigena', text: 'Indigena' },
                ],
                fields: {
                    name: '',
                    birthdate: '',
                    sex: '',
                    phone: '',
                    cityOfBirth: '',
                    cityOfOrigin: '',
                    maritalStatus: '',
                    breed: '',
                }
            }
        };
    },

    mounted(){
        axios.get('/prontuary/get/1').then((response) => {
            let items = response.data[0][0];
            
            this.form.status               = items.status;
            this.form.fields.name          = items.full_name;
            this.form.fields.birthdate     = items.birth_date;
            this.form.fields.sex           = items.sex;
            this.form.fields.phone         = items.phone;
            this.form.fields.cityOfBirth   = items.city_of_birth;
            this.form.fields.cityOfOrigin  = items.city_of_origin;
            this.form.fields.maritalStatus = items.marital_status;
            this.form.fields.breed         = items.breed;
            
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
}
</script>

