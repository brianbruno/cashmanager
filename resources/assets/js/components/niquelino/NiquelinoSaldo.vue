<template>
    <div class="col s12">
        <div class="card orange lighten-5 z-depth-2">
            <div class="card-content" id="divLucro">
                <span class="card-title black-text">Lucro Niquelino</span>
                <div class="center-align">
                    <div id="exibirLucro">
                        <sc-loading v-show="isLoadingLucro"></sc-loading>
                        <div id="lucroContas" class="center-align" v-show="!isLoadingLucro">
                            <h5 class="black-text">{{ lucro }} BTC</h5>
                            <h6 class="black-text">R$ {{ lucrobrl }}</h6>
                            <h6 class="black-text">U$ {{ lucrousd }}</h6>
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
                lucrobrl: [],
                lucrousd: [],
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
                        t.lucrobrl = response.body.lucrobrl;
                        t.lucrousd = response.body.lucrousd;
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


