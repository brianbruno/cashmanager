<template>

    <div>
        <div class="col s12">
            <div class="card green lighten-5">
                <div class="card-content" id="divSaldo">
                    <div class="center-align">

                        <a class="waves-effect waves-light btn-large purple darken-4 modal-trigger"
                            id="btnAbrirConta" href="#modalAbrirConta">
                            Editar contas
                        </a>

                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Structure -->
        <div id="modalAbrirConta" class="modal">
            <div>
                <a class="red-text modal-close right" href="#"><i class="material-icons">close</i></a>
            </div>
            <div class="modal-content">
                <div class="row">
                    <div class="col s12">
                        <h4>Criar nova conta</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s10">
                        <input placeholder="Conta do Banco Moedinhas" id="valor" type="text" name="valor" v-model="novaConta.nome" maxlength="20" required>
                        <label for="valor">Nome</label>
                    </div>
                    <div class="input-field col s2">
                        <a href="#!" class="btn modal-action modal-close waves-effect waves-green green">Salvar</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12">
                        <h4>Minhas contas</h4>
                    </div>
                </div>
                <div class="row">
                    <table>
                        <thead>
                        <tr>
                            <th>ID Conta</th>
                            <th>Nome</th>
                            <th>Editar</th>
                        </tr>
                        </thead>

                        <tbody>
                        <tr v-for="conta in contas">
                            <td>{{ conta.conta_id }}</td>
                            <td>{{ conta.nome }}</td>
                            <td><a href="#" class="black-text"><i class="material-icons">mode_edit</i></a></td>
                        </tr>
                        </tbody>
                    </table>
                    </div>

                </div>
            </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            jQuery(document).ready(function(){
                jQuery('.modal').modal();
            });
            this.getContas();
        },
        data () {
            return {
                novaConta: { 'nome': '' },
                criandoConta: true,
                contas: [],
            }
        },
        methods: {
            showLoading(){
                this.isLoadingSaldo = true;
            },
            hideLoading(){
                this.isLoadingSaldo = false;
            },
            criarNovaConta(){

            },
            getContas: function () {

                this.$http.get('/contas/getContas/json').then((response) => {
                    this.contas = response.body.contas;
                }, (response) => {
                    this.formErrors = response.data;
                });
            },
        },
    }
</script>
