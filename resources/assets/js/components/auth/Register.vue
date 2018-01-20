<template>
    <div id="container">
        <form method="POST" action="/register">
            <input type="hidden" name="_token" v-model="csrf_token">
            <div id="loginForm" class="row">
                <div class="col s12 center">
                    <div class="row">
                        <div id="titulo" class="col s12">
                            <a href="/"><h1 class="black-text">CashManager</h1></a>
                            <h5 class="textoWriter">Cadastro</h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 m8 offset-m2">
                            <input id="nome" type="text" name="name" required>
                            <label for="nome">Nome</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 m8 offset-m2">
                            <input id="email" type="email" name="email" required>
                            <label for="email">E-mail</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 m8 offset-m2">
                            <input id="senha" type="password" name="password" required>
                            <label for="senha">Senha</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 m8 offset-m2">
                            <input id="senha-confirm" type="password" name="password_confirmation" required>
                            <label for="senha-confirm">Confirme sua senha</label>
                        </div>
                    </div>
                    <div class="row">
                        <button id="btnLoginHome" type="submit" class="btn waves-effect teal darken-4 waves-light z-depth-3">
                            Cadastrar <i class="material-icons right">send</i>
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

        },
        data () {
            return {
                csrf_token: jQuery('meta[name="csrf-token"]').attr('content'),
            }
        },
        methods: {

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
        margin-top: 2.525rem;
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
