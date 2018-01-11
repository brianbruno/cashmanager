<template>
        <div class="col s12 m6">
            <div class="card light-green lighten-3">
                <div class="card-content" id="divSaldo">
                    <span class="card-title black-text">Saldo</span>
                    <div class="center-align">
                        <a class="waves-effect waves-light btn-large orange accent-4"
                           v-on:click="clickExibirSaldo" v-show="!exibirSaldo" id="btnExibirSaldo">
                            Exibir saldo
                        </a>
                        <div id="exibirSaldo" v-show="exibirSaldo">
                            <sc-loading v-show="isLoading"></sc-loading>
                            <div id="saldoConta" class="center-align" v-show="!isLoading">
                                <h5>R$ {{ saldo }}</h5>
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
                isLoading: false,
                exibirSaldo: false
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

                this.$http.get('/home/getSaldo/json').then(
                    response=> {
                        t.saldo = response.body.saldo[0].saldo;
                    },
                    error=>{
                        console.log(error)
                    }).finally(function () {
                    t.hideLoading();
                })

            },
            clickExibirSaldo(){
                this.exibirSaldo = true;
                this.carregarInvestimentos();
            },
        },
    }
</script>

<style>
    #divSaldo {
        alignment: center !important;
    }
</style>


