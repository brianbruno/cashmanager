<template>

    <div>
        <div class="row">
            <div class="col s12 m6">
                <niquelino-saldo></niquelino-saldo>
                <saldo-conta></saldo-conta>
            </div>
            <div class="col s12 m6">
                <niquelino-chart-lucro-dia></niquelino-chart-lucro-dia>
            </div>
        </div>
        <div class="row">
            <div class="col s12 m12 l6">
                <div class="card green lighten-5 z-depth-2 card-chart">
                    <div class="card-content black-text">
                        <span class="card-title black-text">Lucro por dia</span>
                        <sc-loading v-show="isLoading"></sc-loading>
                        <line-chart v-on:carregou="hideLoading" style="height:30vh;"></line-chart>
                    </div>
                </div>
            </div>
            <div class="col s12 m12 l6">
                <div class="card green lighten-5 z-depth-2 card-chart">
                    <div class="card-content black-text">
                        <span class="card-title black-text">Lucro por hora</span>
                        <sc-loading v-show="isLoading"></sc-loading>
                        <line-chart-lucro-hora v-on:carregou="hideLoadingHora" style="height:30vh;"></line-chart-lucro-hora>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col s12">
                <investimentos></investimentos>
            </div>
        </div>
    </div>
</template>

<script>
    import ChartLucroHora from "./charts/ChartLucroHora";

    export default {
        components: {ChartLucroHora},
        mounted() {
            this.showLoading();
        },
        data () {
            return {
                isLoading: false,
                isLoadingHora: false,
            }
        },
        methods: {
            showLoading(){
                this.isLoading = true;
                this.isLoadingHora = true;
            },
            hideLoading(){
                this.isLoading=false;
            },
            hideLoadingHora() {
                this.isLoadingHora = false;
            },

        },
    }
</script>

<style scoped>
.card-chart {
    height: 40vh;
}
</style>
