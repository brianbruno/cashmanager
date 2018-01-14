<template>
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
                            <th>Data</th>
                            <th>Editar</th>
                        </tr>
                        </thead>

                        <tbody>
                        <tr v-for="investimento in investimentos">
                            <td>{{ investimento.tipo_investimento }}</td>
                            <td>{{ investimento.valor }}</td>
                            <td>{{ investimento.lucro }}</td>
                            <td>{{ investimento.data }}</td>
                            <td><a href="#" class="black-text"><i class="material-icons">mode_edit</i></a></td>
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

                this.$http.get('/investimentos/tabela/json').then(
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
