<template>
    <div>
        <div class="card green lighten-5">
            <div class="card-content black-text" >
                <span class="card-title black-text">Filtro</span>
                <sc-loading v-show="isLoadingContas"></sc-loading>
                <div id="cardFiltroTransacao" v-show="!isLoadingContas">
                    <div class="row" >
                        <div class="input-field col s4">
                            <select name="tipo" v-model="filtro.tipo">
                                <option value="T" selected>Todas</option>
                                <option value="E">Entrada</option>
                                <option value="S">Saída</option>
                            </select>
                            <label>Tipo de transação</label>
                        </div>
                        <div class="input-field col s4">
                            <select name="conta" v-model="filtro.conta_id" required>
                                <option value="T" selected>Todas</option>
                                <option v-for="conta in contas" :value="conta.conta_id">{{ conta.nome }}</option>
                            </select>
                            <label>Conta</label>
                        </div>
                    </div>
                    <div class="card-action">
                        <button class="btn waves-effect waves-light indigo darken-4 right"
                                name="action" v-on:click="carregarTransacoes">Filtrar
                            <i class="material-icons right">send</i>
                        </button>
                    </div>

                    <div class="card-content black-text">
                        <sc-loading v-show="isLoading"></sc-loading>
                        <table v-show="!isLoading">
                            <thead class="green lighten-3" id="tableTransacoes" >
                            <tr>
                                <th>Tipo</th>
                                <th>ID Transação</th>
                                <th>Conta</th>
                                <th>Data</th>
                                <th>Valor (R$)</th>
                            </tr>
                            </thead>
                            <tbody class="green lighten-5 linhaTabela">
                            <tr v-for="transacao in transacoes">
                                <td v-if="transacao.tipo === 'E'"><span class="green-text"><i class="material-icons">trending_up</i></span></td>
                                <td v-if="transacao.tipo === 'S'"><span class="red-text"><i class="material-icons">trending_down</i></span></td>
                                <td>{{ transacao.trans_id }}</td>
                                <td>{{ transacao.conta_nome }}</td>
                                <td>{{ transacao.data }}</td>
                                <th>{{ transacao.valor }}</th>
                            </tr>
                            </tbody>
                        </table>
                        <ul class="pagination center hide">
                            <li class="disabled"><a href="#!"><i class="material-icons">chevron_left</i></a></li>
                            <li class="active green lighten-3 black-text"><a href="#!">1</a></li>
                            <li class="waves-effect"><a href="#!">2</a></li>
                            <li class="waves-effect"><a href="#!">3</a></li>
                            <li class="waves-effect"><a href="#!">4</a></li>
                            <li class="waves-effect"><a href="#!">5</a></li>
                            <li class="waves-effect"><a href="#!"><i class="material-icons">chevron_right</i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>




    </div>
</template>

<script>
    export default {
        mounted() {
            this.carregarTransacoes();
            this.getContas();
            bus.$on('nova-movimentacao', () => {
                this.getTransacoes();
            });
        },
        data () {
            return {
                transacoes : [],
                contas: [],
                filtro: {'tipo': 'T', 'conta': 'T'},
                isLoadingContas: false,
                isLoading: false
            }
        },
        methods: {
            carregarTransacoes(){
                this.showLoading();
                this.getTransacoes();
            },
            getTransacoes () {
                this.$http.get('/contas/transacoes/json', {params:  this.filtro}).then(
                    response=> {
                        this.transacoes = response.body.transacoes;
                    },
                    error=>{
                        console.log(error)
                    }).finally(function () {
                    this.hideLoading();
                });
            },
            showLoading(){
                this.isLoading=true;
            },
            hideLoading(){
                this.isLoading=false;
            },
            getContas: function () {
                this.isLoadingContas = true;
                this.$http.get('/contas/getContas/json').then((response) => {
                    this.contas = response.body.contas;
                }, (response) => {
                    this.formErrors = response.data;
                }).finally(function () {
                    this.isLoadingContas = false;
                    jQuery('select').select();
                });
            },
        },
    }
</script>

<style scoped>
    .linhaTabela :hover {
        background-color: #c8e6c9;
    }
</style>