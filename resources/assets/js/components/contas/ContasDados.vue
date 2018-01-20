<template>
    <div>
        <div class="col s6">
            <div class="card green lighten-5 hoverable">
                <div class="card-content" id="divContas">
                    <div class="row">
                        <div class="col s12">
                            <sc-loading v-show="isLoading"></sc-loading>
                            <div v-show="!isLoading" class="center">
                                <h4>2</h4><p class="card-box">Contas</p>
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
                                <h4>125</h4><p class="card-box">Transações (mês)</p>
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
            this.getContas();
        },
        data () {
            return {
                novaConta: { 'nome': '' },
                criandoConta: true,
                dados: [],
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
            getContas: function () {
                this.showLoading();
                this.$http.get('/contas/getDadosContas/json').then((response) => {
                    this.hideLoading();
                    this.contas = response.body.dados;
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