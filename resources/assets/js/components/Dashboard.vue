<template>

    <div>
    <div class="row">
        <saldo-conta></saldo-conta>
        <investimentos></investimentos>
    </div>
    <div class="row">
        <div class="col s12">
            <div class="card green lighten-5">
                <div class="card-content black-text">
                    <span class="card-title black-text">Lucro por dia</span>
                    <sc-loading v-show="isLoading"></sc-loading>
                    <line-chart v-on:carregou="hideLoading"></line-chart>
                </div>
            </div>

        </div>
    </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            this.showLoading();
        },
        data () {
            return {
                isLoading: false
            }
        },
        methods: {
            showLoading(){
                this.isLoading=true;
            },
            hideLoading(){
                this.isLoading=false;
            },
        },
    }
</script>
