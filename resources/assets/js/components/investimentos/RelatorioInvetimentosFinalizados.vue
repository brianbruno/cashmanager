<template>
    <div>
        <div class="col s12">
            <div class="card green lighten-5">
                <div class="card-content">
                    <span class="card-title black-text">Investimentos</span>
                    <sc-loading v-show="isLoading"></sc-loading>
                    <div id="ultimosCincoInvestimentos" v-show="!isLoading">
                        <table>
                            <thead>
                            <tr>
                                <th>Investimento</th>
                                <th>Valor</th>
                                <th>Lucro</th>
                                <th class="center">Porcentagem</th>
                            </tr>
                            </thead>

                            <tbody>
                            <tr v-for="investimento in investimentos">
                                <td>{{ investimento.tipo_investimento }}</td>
                                <td>R$ {{ investimento.valor }}</td>
                                <td>R$ {{ investimento.lucro }}</td>
                                <td class="center">{{ investimento.porcentagem }}%</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            this.carregarInvestimentos();
            this.$on('atualizar-tabela-investimentos', () => this.carregarInvestimentos());
        },
        data () {
            return {
                investimentos: [],
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
            carregarInvestimentos(){

                let t = this;
                this.showLoading();

                this.$http.get('/investimentos/relatorios/json').then(
                    response=> {
                        t.investimentos = response.body.investimentos;
                    },
                    error=>{
                        M.toast({html: response.body.message, classes: 'rounded'});
                        console.log(error)
                    }).finally(function () {
                    t.hideLoading();
                });

            },
        },
    }
</script>
