<template>
    <form action="#" v-on:submit.prevent="createInvestimento">
        <div class="row">
            <div class="col s12">
                <div class="card green lighten-5">
                    <div class="card-content black-text">
                        <span class="card-title black-text">Novo investimento</span>
                        <sc-loading v-show="isLoading"></sc-loading>
                        <div id="cardInvestimento" v-show="!isLoading">
                            <div class="row">
                                <div class="input-field col s12">
                                    <select name="tipo" v-model="newInvestimento.tipo">
                                        <option value="OPCAO"  selected>Opção</option>
                                        <option value="CRIPTO">Criptomoeda</option>
                                    </select>
                                    <label>Tipo de investimento</label>
                                </div>
                                <div class="input-field col s12">
                                    <select name="conta" v-model="newInvestimento.conta_id" required>
                                        <option value="" disabled selected>Escolha a conta</option>
                                        <option v-for="conta in contas" :value="conta.conta_id">{{ conta.nome }}</option>
                                    </select>
                                    <label>Conta</label>
                                </div>
                                <div class="input-field col s12">
                                    <input placeholder="0,00" id="valor" type="number" name="valor" v-model="newInvestimento.valor" step="0.01" min="0" required>
                                    <label for="valor">Valor</label>
                                </div>
                                <div class="input-field col s12">
                                    <input placeholder="0,00" id="lucro" type="number" name="lucro" v-model="newInvestimento.lucro" step="0.01" required>
                                    <label for="valor">Lucro</label>
                                </div>
                            </div>
                            <div class="card-action">
                            <button class="btn waves-effect waves-light" name="action">Enviar
                                <i class="material-icons right">send</i>
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
            this.getContas();
        },
        data () {
            return {
                newInvestimento : {'tipo':'OPCAO', 'valor': '','lucro':'','conta_id': ''},
                contas: {'conta_id': '', 'nome': ''},
                isLoading: false,
                exibirSaldo: false
            }
        },
        methods: {
            showLoading(){
                this.isLoading=true;
            },
            hideLoading(){
                this.isLoading=false;
            },
            createInvestimento: function(){
                this.showLoading();
                var input = this.newInvestimento;
                this.$http.post('/investimentos/save',input).then((response) => {
                    this.newInvestimento = {'tipo':'OPCAO', 'valor': '','lucro':''};
                    this.$emit('atualizou');
                }, (response) => {
                    this.formErrors = response.data;
                }).finally(function () {
                    this.hideLoading();
                });
            },
            getContas: function () {
                this.showLoading();
                this.$http.get('/contas/getContas/json').then((response) => {
                    this.contas = response.body.contas;
                }, (response) => {
                    this.formErrors = response.data;
                }).finally(function () {
                    this.hideLoading();
                    jQuery('select').select();
                });
            },
        },
    }
</script>