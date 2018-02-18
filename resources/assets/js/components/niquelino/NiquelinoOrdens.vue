<!-- -->

<template>
    <div class="col s12">
        <div class="card orange lighten-5 z-depth-2">
            <div class="card-content" id="divLucro">
                <span class="card-title black-text">Últimas ordens</span>
                <div>
                    <sc-loading v-show="isLoading"></sc-loading>
                    <table v-show="!isLoading">
                        <thead class="orange lighten-3" id="tableTransacoes">
                        <tr>
                            <th>Tipo</th>
                            <th></th>
                            <th>Moeda</th>
                            <th>Quantidade</th>
                            <th>Total Restante</th>
                            <th>Preço</th>
                            <th>Exchange</th>
                            <th>Data da Ordem</th>
                        </tr>
                        </thead>
                        <tbody class="orange lighten-5 linhaTabela">
                            <tr v-for="ordem in ordens">
                                <td v-if="ordem.TYPE === 'LIMIT_SELL'"><span class="left badge green new" data-badge-caption="Venda"></span></td>
                                <td v-if="ordem.TYPE === 'LIMIT_BUY'"><span class="left badge red new" data-badge-caption="Compra"></span></td>
                                <td>{{  }}</td>
                                <td>{{ ordem.MARKET }} </td>
                                <td>{{ ordem.QUANTITY }}</td>
                                <td>{{ ordem.QUANTITYREMAINING }}</td>
                                <th>{{ ordem.RATE }}</th>
                                <th>BitTrex</th>
                                <th>{{ ordem.OPENED }}</th>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            this.getOrdens();
        },
        data () {
            return {
                ordens: [],
                isLoading: false,
            }
        },
        methods: {
            showLoading(){
                this.isLoading = true;
            },
            hideLoading(){
                this.isLoading = false;
            },
            getOrdens: function () {
                let t = this;
                this.showLoading();
                this.$http.get('/niquelino/getOrdens').then((response) => {
                    t.hideLoading();
                    t.ordens = response.body.ordens;
                }, (response) => {
                    this.formErrors = response.data;
                });
            },
        },
    }
</script>

<style scoped>

</style>


