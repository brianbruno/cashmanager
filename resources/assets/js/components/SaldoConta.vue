<template>
        <div class="col s12 m6">
            <div class="card green lighten-5">
                <div class="card-content" id="divSaldo">
                    <span class="card-title black-text">Saldo</span>
                    <div class="center-align">
                        <a class="waves-effect waves-light btn-large orange accent-4"
                           v-on:click="clickExibirSaldo" v-show="!exibirSaldo" id="btnExibirSaldo">
                            Exibir saldo
                        </a>
                        <div id="exibirSaldo" v-show="exibirSaldo">
                            <sc-loading v-show="isLoadingSaldo"></sc-loading>
                            <div id="saldoConta" class="center-align" v-show="!isLoadingSaldo">
                                <h5>R$ {{ saldo }}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card green lighten-5">
                <div class="card-content" id="divLucro">
                    <span class="card-title black-text">Lucro últimos sete dias</span>
                    <div class="center-align">
                        <a class="waves-effect waves-light btn-large orange accent-4"
                           v-on:click="clickExibirLucro" v-show="!exibirLucro" id="btnExibirLucro">
                            Exibir lucro
                        </a>
                        <div id="exibirLucro" v-show="exibirLucro">
                            <sc-loading v-show="isLoadingLucro"></sc-loading>
                            <div id="lucroContas" class="center-align" v-show="!isLoadingLucro">
                                <h5>R$ {{ lucro }}</h5>
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

        },
        data () {
            return {
                investimentosHoje: 0,
                saldo: [],
                lucro: [],
                isLoadingSaldo: false,
                isLoadingLucro: false,
                exibirSaldo: false,
                exibirLucro: false,
            }
        },
        methods: {
            showLoadingSaldo(){
                    this.isLoadingSaldo = true;
            },
            hideLoadingSaldo(){
                    this.isLoadingSaldo = false;
            },
            showLoadingLucro(){
                this.isLoadingLucro = true;
            },
            hideLoadingLucro(){
                this.isLoadingLucro = false;
            },
            carregarInvestimentos(){

                let t = this;
                this.showLoadingSaldo();

                this.$http.get('/home/getSaldo/json').then(
                    response=> {
                        t.saldo = response.body.saldo[0].saldo;
                    },
                    error=>{
                        console.log(error)
                    }).finally(function () {
                    t.hideLoadingSaldo();
                })

            },
            carregarSaldo(){

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
            clickExibirSaldo(){
                this.exibirSaldo = true;
                this.carregarInvestimentos();
            },
            clickExibirLucro(){
                this.exibirLucro = true;
                this.carregarSaldo();
            },
        },
    }
</script>

<style>
    #divSaldo {
        alignment: center !important;
    }
</style>


