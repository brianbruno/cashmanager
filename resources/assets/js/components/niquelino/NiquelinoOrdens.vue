<template>
    <div class="col s12">
        <div class="card orange lighten-5 z-depth-2">
            <div class="card-content" id="divLucro">
                <span class="card-title black-text">Últimas ordens</span>
                <div>
                    <table v-show="!isLoading">
                        <thead class="orange lighten-3" id="tableTransacoes">
                        <tr>
                            <th>Tipo</th>
                            <th>Moeda</th>
                            <th>Quantidade</th>
                            <th>Total</th>
                            <th>Preço</th>
                            <th>Exchange</th>
                            <th>Data da Ordem</th>
                        </tr>
                        </thead>
                        <tbody class="orange lighten-5 linhaTabela">
                            <tr>
                                <td class="bold"><span class="left badge green new" data-badge-caption="Compra"></span></td>
                                <td>LTC</td>
                                <td>0.0184873</td>
                                <td>17-01-2018 18:18:12</td>
                                <th>BTC 0,000056</th>
                                <th>BitTrex</th>
                                <th>17-01-2018 18:07:07</th>
                            </tr>
                            <tr>
                                <td class="bold"><span class="left badge red new" data-badge-caption="Venda"></span></td>
                                <td>LTC</td>
                                <td>0.0184873</td>
                                <td>0.0184873</td>
                                <th>BTC 0,000096</th>
                                <th>BitTrex</th>
                                <th>17-01-2018 18:07:07</th>
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

<style scoped>

</style>


