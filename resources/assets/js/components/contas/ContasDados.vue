<template>
    <div>
        <div class="col s6">
            <div class="card green lighten-5 hoverable">
                <div class="card-content" id="divContas">
                    <div class="row">
                        <div class="col s12">
                            <sc-loading v-show="isLoading"></sc-loading>
                            <div v-show="!isLoading" class="center">
                                <h4>{{ contas }}</h4><p class="card-box">Contas</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col s6">
            <div class="card green lighten-5 hoverable">
                <div class="card-content" id="divConta">
                    <div class="row">
                        <div class="col s12">
                            <sc-loading v-show="isLoading"></sc-loading>
                            <div v-show="!isLoading" class="center">
                                <h4>{{ transacoes }}</h4><p class="card-box">Transações (mês)</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            this.getDados();
            bus.$on('nova-conta', () => {
                this.getDados();
            });
        },
        data () {
            return {
                novaConta: { 'nome': '' },
                criandoConta: true,
                transacoes: '0',
                contas: '0',
                isLoading: true,
            }
        },
        methods: {
            showLoading(){
                this.isLoading = true;
            },
            hideLoading(){
                this.isLoading = false;
            },
            getDados: function () {
                this.showLoading();
                this.$http.get('/contas/getDadosContas/json').then((response) => {
                    this.hideLoading();
                    this.contas = response.body.contas[0].contas;
                    this.transacoes = response.body.transacoes[0].transacoes;
                }, (response) => {
                    let formErrors = response.body;
                    M.toast({html: "Erro: " + formErrors.message, classes: 'rounded'});
                });
            },
        },
    }
</script>

<style scoped>
    .card-box {
        font-family: 'Julius Sans One', sans-serif ;
        font-size: medium;
    }
</style>