<template>
    <form action="#" v-on:submit.prevent="changePreferences">
        <input type="hidden" name="_token" v-model="csrf_token">
        <div class="row">
            <div class="col s12">
                <div class="card green lighten-5">
                    <div class="card-content black-text">
                        <span class="card-title black-text">Preferências</span>
                        <sc-loading v-show="isLoading"></sc-loading>
                        <div id="cardInvestimento" v-show="!isLoading">
                            <div class="row">
                                <div class="input-field col s4">
                                    <select name="conta" v-model="userPreferences.conta_principal" required>
                                        <option v-for="conta in contas" :value="conta.conta_id">{{ conta.nome }}</option>
                                    </select>
                                    <label>Conta Principal</label>
                                </div>

                                <div class="input-field col s4">
                                    <select v-model="userPreferences.niquelino_ativo" required>
                                        <option value="S">Ativado</option>
                                        <option value="N">Desativado</option>
                                    </select>
                                    <label>Niquelino</label>
                                </div>

                                <div class="input-field col s4">
                                    <select v-model="userPreferences.mostrar_saldo" required>
                                        <option value="S">Ativado</option>
                                        <option value="N">Desativado</option>
                                    </select>
                                    <label>Mostrar saldo no menu lateral</label>
                                </div>
                            </div>
                            <div class="card-action">
                                <button class="btn waves-effect waves-light waves-blue-grey blue-grey darken-4 right"
                                   type="submit" name="action" id="btnEnviar">
                                    Enviar <i class="material-icons right">send</i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</template>

<script>
    export default {
        mounted() {
            jQuery(document).ready(function() {
                jQuery('select').select();
            });
            this.getPreferencesAndContas();
        },
        data () {
            return {
                userPreferences : {'conta_principal': '', 'niquelino_ativo': 1, 'mostrar_saldo': 'S','_token': ''},
                contas: {'conta_id': '', 'nome': ''},
                isLoading: false,
                csrf_token: jQuery('meta[name="csrf-token"]').attr('content'),
            }
        },
        methods: {
            showLoading(){
                this.isLoading=true;
            },
            hideLoading(){
                this.isLoading=false;
            },
            changePreferences: function(){
                this.showLoading();

                var input = this.userPreferences;
                input._token = this.csrf_token;

                this.$http.post('/auth/preferencias',input).then((response) => {
                    M.toast({html: response.body.message, classes: 'rounded'});
                }, (response) => {
                    M.toast({html: response.data.message, classes: 'rounded'});
                }).finally(function () {
                    this.getPreferencesAndContas();
                });
            },
            getPreferencesAndContas: function () {
                this.showLoading();
                this.$http.get('/auth/getPreferences/json').then((response) => {
                    this.contas = response.body.contas;
                    this.userPreferences = response.body.preferencias[0];

                }, (response) => {
                    this.formErrors = response.data;
                }).finally(function () {
                    this.hideLoading();
                    jQuery('select').select();
                });
            }
        },
    }
</script>