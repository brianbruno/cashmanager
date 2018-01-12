<template>
    <form action="#" v-on:submit.prevent="createInvestimento">
        <div class="row">
            <div class="col s12">
                <div v-show="!isLoading" class="card green lighten-5">
                    <div class="card-content black-text">
                        <div class="row">
                            <div class="input-field col s12">
                                <select name="tipo" v-model="newInvestimento.tipo">
                                    <option value="OPCAO"  selected>Opção</option>
                                    <option value="CRIPTO">Criptomoeda</option>
                                </select>
                                <label>Tipo de investimento</label>
                            </div>
                            <div class="input-field col s6">
                                <input placeholder="0,00" id="valor" type="number" name="valor" v-model="newInvestimento.valor" step="0.01" min="0" required>
                                <label for="valor">Valor</label>
                            </div>
                            <div class="input-field col s6">
                                <input placeholder="0,00" id="lucro" type="number" name="lucro" v-model="newInvestimento.lucro" step="0.01" required>
                                <label for="valor">Lucro</label>
                            </div>
                        </div>
                    </div>
                    <div class="card-action">
                        <button class="btn waves-effect waves-light" name="action">Enviar
                            <i class="material-icons right">send</i>
                        </button>
                    </div>
                </div>
                <div class="card-content black-text">
                    <sc-loading v-show="isLoading"></sc-loading>
                </div>

            </div>
        </div>
    </form>
</template>

<script>
    export default {
        mounted() {
            $(document).ready(function() {
                jQuery('select').select();
            });
        },
        data () {
            return {
                investimentosHoje: 0,
                valor: '',
                tipo: 'OPCAO',
                lucro: '',
                newInvestimento : {'tipo':'OPCAO', 'valor': '','lucro':''},
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
                }, (response) => {
                    this.formErrors = response.data;
                }).finally(function () {
                    this.hideLoading();
                });
            },
        },
    }
</script>