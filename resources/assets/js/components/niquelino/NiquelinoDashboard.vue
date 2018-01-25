<template>
    <div class="col s12">
        <div class="row">
            <div class="col s6">
                <niquelino-saldo></niquelino-saldo>
            </div>
            <div class="col s6">
                <div class="col s12">
                    <div class="card orange lighten-5 z-depth-2">
                        <div class="card-content" id="divLucro">
                            <span class="card-title black-text">Niquelino Bot</span>
                            <div class="center-align">
                                <div id="exibirLucro">
                                    <sc-loading v-show="isLoadingLucro"></sc-loading>
                                    <div id="lucroContas" class="center-align" v-show="!isLoadingLucro">
                                        <h5 class="black-text">Vendendo 0,00054 BTC a U$ 14.369,85</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col s12">
                <niquelino-ordens></niquelino-ordens>
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
            carregarLucro(){

                let t = this;
                this.showLoadingLucro();

                this.$http.get('/home/getLucro/json').then(
                    response=> {
                        t.lucro = response.body.lucro[0].lucro;
                    },
                    error=>{
                        console.log(error)
                    }).finally(function () {
                    t.hideLoadingLucro();
                })

            },
            clickExibirLucro(){
                this.exibirLucro = true;
                this.carregarLucro();
            },
        },
    }
</script>

<style>

</style>


