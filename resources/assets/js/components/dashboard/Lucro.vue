<template>
    <div class="col s12">
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
    #divSaldo {
        alignment: center !important;
    }
</style>


