<template>
    <div>
        <div class="card green lighten-5">
            <div class="card-content black-text" >
                <span class="card-title black-text">Extrato</span>
                <sc-loading v-show="isLoadingContas"></sc-loading>
                <div id="cardFiltroTransacao">
                    <div class="row" v-show="!isLoadingContas">
                        <div class="input-field col s3">
                            <select name="tipo" v-model="filtro.tipo">
                                <option value="T" selected>Todas</option>
                                <option value="E">Entrada</option>
                                <option value="S">Saída</option>
                            </select>
                            <label>Tipo de transação</label>
                        </div>
                        <div class="input-field col s3">
                            <select name="conta" v-model="filtro.conta_id" required>
                                <option value="T" selected>Todas</option>
                                <option v-for="conta in contas" :value="conta.conta_id">{{ conta.nome }}</option>
                            </select>
                            <label>Conta</label>
                        </div>
                        <div class="input-field col s3">
                            <div class="col s12">
                                <date-picker id="date-picker" v-model="filtro.data" language="pt-br"
                                             :format="customFormatter" :placeholder="'Data'"></date-picker>
                            </div>
                        </div>
                        <div class="input-field col s3">
                            <select name="conta" v-model="filtro.per_page" required>
                                <option value="10" selected>10</option>
                                <option value="20" selected>20</option>
                                <option value="30" selected>30</option>
                                <option value="40" selected>40</option>
                                <option value="50" selected>50</option>
                            </select>
                            <label>Itens por página</label>
                        </div>
                    </div>
                    <div class="card-action" v-show="!isLoadingContas">
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
                        <ul v-show="!isLoading" class="pagination center">
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
        extends: Datepicker,
        mounted() {
            this.carregarTransacoes();
            this.getContas();
            jQuery(document).ready(function(){
                jQuery('select').select();
            });
            bus.$on('nova-movimentacao', () => {
                this.getTransacoes();
            });
        },
        data () {
            return {
                transacoes : [],
                contas: [],
                filtro: {'tipo': 'T', 'conta': 'T', 'per_page': 10, 'data': new Date()},
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
                let data_backup = this.filtro.data;
                this.filtro.data = Moment(this.filtro.data).format('DD-MM-YY');
                this.$http.get('/contas/transacoes/json', {params:  this.filtro}).then(
                    response=> {
                        this.transacoes = response.body.transacoes;
                    },
                error=>{
                    console.log(error)
                }).finally(function () {
                    this.hideLoading();
                });
                this.filtro.data = data_backup;
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
            customFormatter(date) {
                return Moment(date).format('DD/MM/YY');
            },
        },
    }
</script>

<style scoped>
    .linhaTabela :hover {
        background-color: #c8e6c9;
    }
</style>