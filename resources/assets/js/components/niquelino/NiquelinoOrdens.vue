<template>
    <div class="col s12">
        <div class="card orange lighten-5 z-depth-2">
            <div class="card-content" id="divLucro">
                <span class="card-title black-text">Últimas ordens</span>
                <div>
                    <table v-show="!isLoading">
                        <thead class="orange lighten-3" id="tableTransacoes" >
                        <tr>
                            <th>Tipo</th>
                            <th>ID Transação</th>
                            <th>Conta</th>
                            <th>Data</th>
                            <th>Quantidade</th>
                            <th>Valor Compra</th>
                            <th>Valor Venda</th>
                            <th>Lucro</th>
                        </tr>
                        </thead>
                        <tbody class="orange lighten-5 linhaTabela">
                        <tr>
                            <td class="bold">BUY</td>
                            <td>17011818070016942195</td>
                            <td>Carteira BTC</td>
                            <td>17-01-2018 18:07:07</td>
                            <th>BTC 0,000056</th>
                            <th>U$ 14.368,96</th>
                            <th><span class="brow-text"><i class="material-icons">not_interested</i></span></th>
                            <th><span class="brow-text"><i class="material-icons">not_interested</i></span></th>
                        </tr>
                        <tr>
                            <td class="bold">SELL</td>
                            <td>17011818070046942195</td>
                            <td>Carteira BTC</td>
                            <td>17-01-2018 18:18:12</td>
                            <th>BTC 0,000056</th>
                            <th>U$ 14.368,96</th>
                            <th>U$ 14.370,01</th>
                            <th>2,58 %</th>
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

        },
        data () {
            return {
                lucro: [],
                isLoadingLucro: false,
                exibirLucro: false,
            }
        },
        methods: {
            showLoadingLucro(){
                this.isLoadingLucro = true;
            },
            hideLoadingLucro(){
                this.isLoadingLucro = false;
            },
        },
    }
</script>

<style>
    #divSaldo {
        alignment: center !important;
    }
</style>


