<template>
    <div class="navbar-fixed hide-on-med-and-down">
        <nav>
            <div class="nav-wrapper blue-grey lighten-5" id="cripto-values">
                <div class="chip-css" v-bind:style="bitcoin_bgc">
                    <img src="http://cashmanager.brian.place/public/img/btc.png" alt="Person">
                    <span class="blue-grey-text">U$ {{ bitcoin_market.price_usd }} </span> <span v-bind:class="{ 'red-text': bitcoin_perda, 'green-text': bitcoin_lucro }">{{ bitcoin_market.percent_change_24h }}%</span>
                </div>
                <div class="chip-css hide">
                    <img src="http://cashmanager.brian.place/public/img/ltc.png" alt="Person">
                    <span class="blue-grey-text">BTC {{ market.price_ltc_btc }} </span> <span class="red-text">-12,53%</span>
                </div>
                <div class="chip-css hide">
                    <img src="http://cashmanager.brian.place/public/img/eth.png" alt="Person">
                    <span class="blue-grey-text">142.65 </span> <span class="red-text">-12,53%</span>
                </div>
                <div class="chip-css hide">
                    <img src="http://cashmanager.brian.place/public/img/dash.png" alt="Person">
                    <span class="blue-grey-text">142.65 </span><span class="red-text">-12,53%</span>
                </div>
                <div class="chip-css hide">
                    <img src="http://cashmanager.brian.place/public/img/ubq.png" alt="Person">
                    <span class="blue-grey-text">142.65 </span><span class="red-text">-12,53%</span>
                </div>
            </div>
        </nav>
    </div>
</template>

<script>
    export default {
        mounted() {
            let t = this;
            t.carregarMercadoBitCoin();
            //t.carregarMercado();
            setInterval(function(){
                t.carregarMercadoBitCoin();
                //t.carregarMercado();
            }, 10000);
        },
        data () {
            return {
                bitcoin_market: {
                    percent_change_24h: '0%',
                    price_usd: '00000.00'
                },
                market: {
                    price_ltc_btc: 0

                },
                bitcoin_bgc: {
                    backgroundColor: '#f1f1f1'
                },
                bitcoin_lucro: false,
                bitcoin_perda: true,
                isLoadingLucro: false,
                exibirLucro: false,
            }
        },
        methods: {
            efeitoFlash(){
                let t = this;
                t.bitcoin_bgc.backgroundColor = '#e0f2f1';
                setTimeout(function(){
                    t.bitcoin_bgc.backgroundColor = '#f1f1f1';
                }, 1000);
            },
            carregarMercado(){

                let t = this;

                this.$http.get('https://bittrex.com/api/v1.1/public/getmarketsummary?market=BTC-LTC').then(
                    response=> {
                        t.efeitoFlash();
                        t.market.price_ltc_btc = response.body[0].result[0].Last;
                    },
                    error=>{
                        console.log(error)
                    });

            },
            carregarMercadoBitCoin(){

                let t = this;


                this.$http.get('https://api.coinmarketcap.com/v1/ticker/bitcoin/?convert=BRL').then(
                    response=> {
                        t.efeitoFlash();
                        t.bitcoin_market = response.body[0];

                        if(t.bitcoin_market.percent_change_24h > 0){
                            t.bitcoin_lucro = true;
                            t.bitcoin_perda = false;
                        }
                        else {
                            t.bitcoin_lucro = false;
                            t.bitcoin_perda = true;
                        }
                    },
                    error=>{
                        console.log(error)
                    });

            },
        },
    }
</script>

<style scoped>

    #cripto-values {
        padding-left: 15px;
    }

    .chip-css {
        display: inline-block;
        padding: 0 15px;
        height: 50px;
        font-size: 16px;
        line-height: 50px;
        border-radius: 15px;
        background-color: #f1f1f1;
        transition: 1.5s;
    }

    .chip-css img {
        float: left;
        margin: 0 10px 0 -25px;
        height: 35px;
        width: 35px;
        border-radius: 50%;
    }

</style>