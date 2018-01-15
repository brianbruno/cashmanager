<template>
    <div>
        <form action="#" v-on:submit.prevent="createTransacao">
            <div class="row">
                <div class="col s12">
                    <div class="card green lighten-5">
                        <div class="card-content black-text" >
                            <span class="card-title black-text">Nova transação</span>
                            <sc-loading v-show="isLoading"></sc-loading>
                            <div id="cardNovaTransacao" v-show="!isLoading">
                                <div class="row" >
                                    <div class="input-field col s4">
                                        <select name="tipo" v-model="newTransacao.tipo">
                                            <option value="E">Entrada</option>
                                            <option value="S" selected>Saída</option>
                                        </select>
                                        <label>Tipo de transação</label>
                                    </div>
                                    <div class="input-field col s4">
                                        <select name="conta" v-model="newTransacao.conta_id" required>
                                            <option value="" disabled selected>Escolha a conta</option>
                                            <option v-for="conta in contas" :value="conta.conta_id">{{ conta.nome }}</option>
                                        </select>
                                        <label>Conta</label>
                                    </div>
                                    <div class="input-field col s4">
                                        <input placeholder="0,00" id="valor" type="number" name="valor" v-model="newTransacao.valor" step="0.01" min="0" required>
                                        <label for="valor">Valor</label>
                                    </div>
                                </div>
                                <div class="card-action">
                                    <button class="btn waves-effect waves-light green darken-4 right" name="action">Enviar
                                        <i class="material-icons right">send</i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
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
                newTransacao : {'tipo': 'S', 'valor': '', 'conta_id': ''},
                contas: {'conta_id': '', 'nome': ''},
                isLoading: false
            }
        },
        methods: {
            showLoading(){
                this.isLoading=true;
            },
            hideLoading(){
                this.isLoading=false;
            },
            createTransacao: function(){
                this.showLoading();
                var input = this.newTransacao;
                this.$http.post('/contas/transacao/save',input).then((response) => {
                    bus.$emit('nova-movimentacao', this.newTransacao);
                    this.newTransacao = {'tipo': 'E', 'valor': '', 'conta': ''};
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