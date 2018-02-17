<template>
    <div id="cripto-values">
        <div class="chip" v-bind:style="bitcoin_bgc">
            <img src="http://cashmanager.brian.place/public/img/btc.png" alt="btc">
            <span class="blue-grey-text">$ {{ bitcoin_market.price_usd }} </span> <span v-bind:class="{ 'red-text': bitcoin_perda, 'green-text': bitcoin_lucro }">{{ bitcoin_market.percent_change_24h }}%</span>
        </div>
        <div class="chip" v-bind:style="coins_bgc">
            <img src="http://cashmanager.brian.place/public/img/ltc.png" alt="ltc">
            <span class="blue-grey-text">{{ market[5].price_btc }} </span> <span class="red-text" v-bind:class="{ 'red-text': litecoin_perda, 'green-text': litecoin_lucro }">{{ market[5].percent_change_24h }}%</span>
        </div>
        <div class="chip" v-bind:style="coins_bgc">
            <img src="http://cashmanager.brian.place/public/img/eth.png" alt="eth">
            <span class="blue-grey-text">{{ market[1].price_btc }} </span> <span class="red-text" v-bind:class="{ 'red-text': eth_perda, 'green-text': eth_lucro }">{{ market[1].percent_change_24h }}%</span>
        </div>
        <div class="chip" v-bind:style="coins_bgc">
            <img src="http://cashmanager.brian.place/public/img/dash.png" alt="dash">
            <span class="blue-grey-text">{{ market[11].price_btc }} </span><span class="red-text" v-bind:class="{ 'red-text': dash_perda, 'green-text': dash_lucro }">{{ market[11].percent_change_24h }}%</span>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            let t = this;
            t.carregarMercadoBitCoin();
            t.carregarMercado();
            setInterval(function(){
                t.carregarMercadoBitCoin();
                t.carregarMercado();
            }, 60000);
        },
        data () {
            return {
                bitcoin_market: {
                    percent_change_24h: '0%',
                    price_usd: '00000.00'
                },
                market: [
                    {
                        percent_change_24h: '0%',
                        price_btc: '00000.00'
                    },
                    {
                        percent_change_24h: '0%',
                        price_btc: '00000.00'
                    },
                    {
                        percent_change_24h: '0%',
                        price_btc: '00000.00'
                    },
                    {
                        percent_change_24h: '0%',
                        price_btc: '00000.00'
                    },
                    {
                        percent_change_24h: '0%',
                        price_btc: '00000.00'
                    },
                    {
                        percent_change_24h: '0%',
                        price_btc: '00000.00'
                    },
                    {
                        percent_change_24h: '0%',
                        price_btc: '00000.00'
                    },
                    {
                        percent_change_24h: '0%',
                        price_btc: '00000.00'
                    },
                    {
                        percent_change_24h: '0%',
                        price_btc: '00000.00'
                    },
                    {
                        percent_change_24h: '0%',
                        price_btc: '00000.00'
                    },
                    {
                        percent_change_24h: '0%',
                        price_btc: '00000.00'
                    },
                    {
                        percent_change_24h: '0%',
                        price_btc: '00000.00'
                    }

                ],
                bitcoin_bgc: {
                    backgroundColor: '#f1f1f1'
                },
                coins_bgc: {
                    backgroundColor: '#f1f1f1'
                },
                bitcoin_lucro: false,
                bitcoin_perda: true,
                litecoin_lucro: false,
                litecoin_perda: true,
                eth_lucro: false,
                eth_perda: true,
                dash_lucro: false,
                dash_perda: true,
                isLoadingLucro: false,
                exibirLucro: false,
            }
        },
        methods: {
            efeitoFlash(){
                let t = this;
                t.coins_bgc.backgroundColor = '#e0f2f1';
                setTimeout(function(){
                    t.coins_bgc.backgroundColor = '#f1f1f1';
                }, 1500);
            },
            efeitoFlashBitCoin(){
                let t = this;
                t.bitcoin_bgc.backgroundColor = '#e0f2f1';
                setTimeout(function(){
                    t.bitcoin_bgc.backgroundColor = '#f1f1f1';
                }, 1500);
            },
            carregarMercado(){

                let t = this;

                this.$http.get('https://api.coinmarketcap.com/v1/ticker/').then(
                    response=> {
                        t.efeitoFlash();
                        t.market = response.body;

                        if(t.market[5].percent_change_24h > 0){
                            t.litecoin_lucro = true;
                            t.litecoin_perda = false;
                        }
                        else {
                            t.litecoin_lucro = false;
                            t.litecoin_perda = true;
                        }

                        if(t.market[1].percent_change_24h > 0){
                            t.eth_lucro = true;
                            t.eth_perda = false;
                        }
                        else {
                            t.eth_lucro = false;
                            t.eth_perda = true;
                        }

                        if(t.market[11].percent_change_24h > 0){
                            t.dash_lucro = true;
                            t.dash_perda = false;
                        }
                        else {
                            t.dash_lucro = false;
                            t.dash_perda = true;
                        }
                    },
                    error=>{
                        console.log(error)
                    });

            },
            carregarMercadoBitCoin(){

                let t = this;

                this.$http.get('https://api.coinmarketcap.com/v1/ticker/bitcoin/?convert=BRL').then(
                    response=> {
                        t.efeitoFlashBitCoin();
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
        /*padding-left: 20px;*/
    }

    .chip-css img {
        float: left;
        margin: 0 10px 0 -25px;
        height: 35px;
        width: 35px;
        vertical-align: center;
        border-radius: 50%;
    }

</style>