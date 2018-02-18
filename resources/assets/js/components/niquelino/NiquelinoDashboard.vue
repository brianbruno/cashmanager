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
                            <span class="card-title black-text">Ultima venda</span>
                            <div class="center-align">
                                <div id="exibirLucro">
                                    <sc-loading v-show="isLoading"></sc-loading>
                                    <div id="lucroContas" class="center-align" v-show="!isLoading">
                                        <h5 class="black-text">{{ ultimaVenda }}</h5>
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
            this.carregarUltimaVenda();
        },
        data () {
            return {
                isLoading: false,
                ultimaVenda: '01/02/2018',
            }
        },
        methods: {
            showLoading(){
                this.isLoading = true;
            },
            hideLoading(){
                this.isLoading = false;
            },
            carregarUltimaVenda(){

                let t = this;
                this.showLoading();

                this.$http.get('/niquelino/ultimavenda').then(
                    response=> {
                        t.ultimaVenda = response.body.ultimaVenda;
                    },
                    error=>{
                        console.log(error)
                    }).finally(function () {
                        t.hideLoading();
                });
            },
        },
    }
</script>

<style>

</style>


