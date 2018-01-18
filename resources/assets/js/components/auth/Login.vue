<template>
    <div id="container">
        <form method="POST" action="/login">
            <input type="hidden" name="_token" v-model="csrf_token">
            <div id="loginForm" class="row">
                <div class="col s12 center">
                    <div class="row">
                        <div id="titulo" class="col s12">
                            <h1>Cash Manager</h1>
                            <h5 class="textoWriter"></h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 m8 offset-m2">
                            <input id="email" type="email" name="email" class="validate" required>
                            <label for="email">E-mail</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 m8 offset-m2">
                            <input id="senha" type="password" name="password" class="validate" required>
                            <label for="senha">Senha</label>
                        </div>
                    </div>
                    <div class="row">
                        <a class="btn-flat waves-effect waves-light" href="/register">Cadastrar</a>
                        <button id="btnLoginHome" type="submit" class="btn waves-effect teal darken-4 waves-light z-depth-3">
                            Login <i class="material-icons right">send</i>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
    export default {
        mounted() {
            let index = Math.floor((Math.random() * 9));
            setTimeout(this.typeWriter(this.frases[index], 0), 1000);
            console.log(this.csrf_token);
        },
        data () {
            return {
                frases: [
                    'Olá! Sentimos sua falta.',
                    'O que está esperando?',
                    'Melhore seus rendimentos.',
                    'Seja bem vindo!',
                    'Comece a ganhar dinheiro.',
                    'Tenho boas notícias para você.',
                    'Você pode ter se tornado milionario.',
                    'Seu sonho vai se realizar.',
                    'Não desista!'

                ],
                frase: '',
                show: true,
                csrf_token: jQuery('meta[name="csrf-token"]').attr('content'),
            }
        },
        methods: {
            typeWriter(text, n) {
                let self = this;
                if (n < (text.length)) {
                    jQuery('.textoWriter').html(text.substring(0, n + 1));
                    n++;
                    setTimeout(function () {
                        self.typeWriter(text, n)
                    }, 100);
                }
            },
            createTransacao: function(){
                this.showLoading();
                var input = this.newTransacao;
                this.$http.post('/contas/transacao/save',input).then((response) => {
                    bus.$emit('nova-movimentacao', this.newTransacao);
                    this.newTransacao = {'tipo': 'E', 'valor': '', 'conta': ''};
                }, (response) => {
                    this.formErrors = response.data;
                }).finally(function () {
                    this.hideLoading();
                });
            },
        },
    }
</script>

<style scoped>
    @import url('https://fonts.googleapis.com/css?family=Didact+Gothic');
    @import url('https://fonts.googleapis.com/css?family=Raleway:100,600');

    #titulo {
        font-family: 'Didact Gothic', sans-serif;
    }

    #loginForm {
        margin-top: 4.125rem;
    }

    #btnLoginHome {
        border-radius: 10px;
    }

    #rightBack {
        font-family : 'Raleway', sans-serif;
        height      : 100%;
        width       : 100%;
        font-weight: 100;
    }

    input:focus {
        border-bottom: 1px solid #004d40 !important;
        -webkit-box-shadow: 0 1px 0 0 #004d40 !important;
        -moz-box-shadow: 0 1px 0 0 #004d40 !important;
        box-shadow: 0 1px 0 0 #004d40 !important;
    }

    label {
        color: #004d40 !important;
    }

    input {
        color: #01579b !important;
    }

    body {
        background-color: #f5f5f5;
    }
</style>
