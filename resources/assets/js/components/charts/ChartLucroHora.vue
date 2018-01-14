<script>

    export default {
        extends: VueCharts.Line,
        data () {
            return {
                dados: [],
                horarios: [],
                isLoading: false
            }
        },
        mounted () {
            this.carregarDadosGrafico();
        },
        methods: {
            carregarDadosGrafico () {
                this.$http.get('/chart/dashboard/dia/json').then(
                    response=> {
                        this.dados = response.body.lucro;
                        this.horarios = response.body.horas;
                        this.$emit('carregou');
                        this.renderizarGrafico();
                    },
                    error=>{
                        console.log(error)
                    });
            },
            renderizarGrafico() {
                this.renderChart({
                    labels: this.horarios,
                    datasets: [
                        {
                            label: 'Lucro',
                            backgroundColor: '#827717',
                            data: this.dados
                        }
                    ]
                }, {responsive: true, maintainAspectRatio: false});
            },
        }
    }
</script>