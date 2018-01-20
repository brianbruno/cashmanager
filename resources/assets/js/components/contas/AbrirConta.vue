<template>
    <div>
        <div class="row">
            <div class="col s12 m6">
                <contas-abertas></contas-abertas>
            </div>
            <div class="col s12 m6">
                <div class="col s12">
                    <contas-dados></contas-dados>
                </div>
                <div class="col s12">
                    <form action="#" v-on:submit.prevent="criarConta">
                        <input type="hidden" name="_token" v-model="csrf_token">
                        <div class="card green lighten-5">
                            <div class="card-content black-text">
                                <span class="card-title black-text">Criar conta</span>
                                <sc-loading v-show="isLoading"></sc-loading>
                                <div id="cardCriarConta" v-show="!isLoading">
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <input id="nome" type="text" v-model="novaConta.nome" placeholder="Conta do banco quadrado" name="nome" required>
                                            <label for="nome">Nome da conta</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-action">
                                    <button class="btn waves-effect waves-blue-grey blue-grey darken-4 right"
                                            type="submit" name="action" id="btnEnviar">
                                        Enviar <i class="material-icons right">send</i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
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
                novaConta : {'nome': '', '_token': ''},
                contas: {'conta_id': '', 'nome': ''},
                isLoading: false,
                csrf_token: jQuery('meta[name="csrf-token"]').attr('content'),
            }
        },
        methods: {
            criarConta: function(){
                this.showLoading();
                var input = this.novaConta;
                input._token = this.csrf_token;

                this.$http.post('/contas/criar',input).then((response) => {
                    M.toast({html: response.body.message, classes: 'rounded'});
                }, (response) => {
                    M.toast({html: response.body.message, classes: 'rounded'});
                    this.formErrors = response.data;
                }).finally(function () {
                    this.isLoading=false;
                    this.novaConta = {'nome': '', '_token': ''};
                });
            },
            showLoading(){
                this.isLoading=true;
            },
            hideLoading(){
                this.isLoading=false;
            },
        },
    }
</script>
