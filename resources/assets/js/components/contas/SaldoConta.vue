<template>
        <div class="col s12">
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
        </div>
</template>

<script>
    export default {
        mounted() {
            bus.$on('nova-movimentacao', (transacao) => {
                this.atualizarComponenteSaldo();
            });
        },
        data () {
            return {
                saldo: [],
                isLoadingSaldo: false,
                exibirSaldo: false,
            }
        },
        methods: {
            showLoadingSaldo(){
                    this.isLoadingSaldo = true;
            },
            hideLoadingSaldo(){
                    this.isLoadingSaldo = false;
            },
            atualizarComponenteSaldo(){
                this.showLoadingSaldo();
                this.atualizarSaldo();
            },
            atualizarSaldo(){
                this.$http.get('/home/getSaldo/json').then(
                    response=> {
                        this.saldo = response.body.saldo[0].saldo;
                    },
                    error=>{
                        console.log(error)
                    }).finally(function () {
                        this.hideLoadingSaldo();
                });
            },
            clickExibirSaldo(){
                this.exibirSaldo = true;
                this.atualizarComponenteSaldo();
            },
        },
    }
</script>

<style>
    #divSaldo {
        alignment: center !important;
    }
</style>


