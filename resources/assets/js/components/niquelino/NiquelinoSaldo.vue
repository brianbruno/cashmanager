<template>
    <div class="col s12">
        <div class="card orange lighten-5 z-depth-2">
            <div class="card-content" id="divLucro">
                <span class="card-title black-text">Saldo Niquelino Bot</span>
                <div class="center-align">
                    <div id="exibirLucro">
                        <sc-loading v-show="isLoadingLucro"></sc-loading>
                        <div id="lucroContas" class="center-align" v-show="!isLoadingLucro">
                            <h5 class="deep-orange-text">{{ lucro }} BTC</h5>
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
            this.carregarLucro();
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

                this.$http.get('/niquelino/getlucro').then(
                    response=> {
                        t.lucro = response.body.lucro;
                    },
                    error=>{
                        console.log(error)
                    }).finally(function () {
                    t.hideLoadingLucro();
                })

            },
        },
    }
</script>

<style>
    #divSaldo {
        alignment: center !important;
    }
</style>


