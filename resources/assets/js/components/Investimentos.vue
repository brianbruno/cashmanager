<template>
    <div class="col s12 m6">
        <div class="card light-green lighten-3">
            <div class="card-content">
                <span class="card-title black-text">Últimos cinco investimentos registrados</span>
                <sc-loading v-show="isLoading"></sc-loading>
                <div id="ultimosCincoInvestimentos" v-show="!isLoading">
                    <table>
                        <thead>
                        <tr>
                            <th>Investimento</th>
                            <th>Valor</th>
                            <th>Lucro</th>
                        </tr>
                        </thead>

                        <tbody>
                        <tr v-for="investimento in investimentos">
                            <td>{{ investimento.tipo_investimento }}</td>
                            <td>{{ investimento.valor }}</td>
                            <td>{{ investimento.lucro }}</td>
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
            this.carregarInvestimentos();
        },
        data () {
            return {
                investimentosHoje: 0,
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

                this.$http.get('/home/ultimosInvestimentos/json').then(
                    response=> {
                        t.investimentos = response.body.investimentos;
                    },
                    error=>{
                        console.log(error)
                    }).finally(function () {
                    t.hideLoading();
                })

            },
        },
    }
</script>
