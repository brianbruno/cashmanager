<template>
    <div class="col s12">
        <div class="card green lighten-5 z-depth-2">
            <div class="card-content">
                <span class="card-title black-text">Últimos cinco investimentos registrados</span>
                <sc-loading v-show="isLoading"></sc-loading>
                <div id="ultimosCincoInvestimentos" v-show="!isLoading">
                    <table class="striped">
                        <thead>
                        <tr>
                            <th>Investimento</th>
                            <th>Valor</th>
                            <th>Lucro</th>
                        </tr>
                        </thead>

                        <tbody>
                        <tr class="linhaTable" v-for="investimento in investimentos">
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

<style scoped>
    .linhaTabela :hover {
        background-color: #e0e0e0;
    }
    th {
        font-family: 'Quicksand', sans-serif;
        font-size: 15px;
        text-transform: uppercase;
    }

    td {
        font-size: 14px;
        text-transform: capitalize;
    }
</style>
