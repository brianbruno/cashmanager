<script>

    export default {
        extends: VueCharts.Line,
        data () {
            return {
                dados: [],
                dias: [],
                isLoading: false
            }
        },
        mounted () {
            this.carregarDadosGrafico();
        },
        methods: {
            carregarDadosGrafico () {
                this.$http.get('/chart/dashboard/json').then(
                    response=> {
                        this.dados = response.body.lucro;
                        this.dias = response.body.dias;
                        this.$emit('carregou');
                        this.renderizarGrafico();
                    },
                    error=>{
                        console.log(error)
                    });
            },
            renderizarGrafico() {
                this.renderChart({
                    labels: this.dias,
                    datasets: [
                        {
                            label: 'Lucro por dia',
                            backgroundColor: '#a5d6a7',
                            data: this.dados
                        }
                    ]
                }, {responsive: true, maintainAspectRatio: false});
            },
        }
    }
</script>