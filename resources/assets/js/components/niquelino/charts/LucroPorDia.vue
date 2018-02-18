<template>

    <div class="col s12">
        <div class="card orange lighten-5 z-depth-2">
            <div class="card-content" id="divLucro">
                <span class="card-title black-text">Niquelino - Lucro por dia</span>
                <div class="center-align">
                    <sc-loading v-show="isLoading"></sc-loading>
                    <div v-show="!isLoading">
                        <canvas id="chartLucroDia"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    export default {

        mounted() {
            let t = this;
            t.carregarDados();
        },
        data () {
            return {
                isLoading: false,
                isLoadingHora: false,
                labels: ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
                data: [12, 19, 3, 5, 2, 3]
            }
        },
        methods: {
            showLoading(){
                this.isLoading = true;
            },
            hideLoading(){
                this.isLoading=false;
            },
            carregarDados () {
                let t = this;
                t.showLoading();
                this.$http.get('/niquelino/charts/getLucroPorDia').then(
                    response=> {
                        t.data = response.body.lucros;
                        t.labels = response.body.dias;
                        t.montarGrafico();
                        t.hideLoading();
                    },
                    error=>{
                        console.log(error);
                    });

            },
            montarGrafico () {
                let t = this;
                let chartLucroDia = document.getElementById("chartLucroDia").getContext('2d');
                let chart = new Chart(chartLucroDia, {
                    type: 'line',
                    data: {
                        labels: t.labels,
                        datasets: [{
                            label: 'Lucro',
                            data: t.data,
                            borderColor: [
                                '#d50000'
                            ],
                            backgroundColor: [
                                '#ffcdd2'
                            ],
                            borderWidth: 1,
                            lineTension: 0.1,
                            fill: true
                        }]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero:true
                                }
                            }]
                        },
                        responsive: true,
                    }
                });
            }
        },
    }
</script>
