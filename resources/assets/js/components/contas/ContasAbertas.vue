<template>

    <div>
        <div class="col s12">
            <div class="card green lighten-5">
                <div class="card-content" id="divSaldo">
                    <div class="row">
                        <div class="col s12">
                            <span class="card-title black-text titulo-cartao">Contas</span>
                            <sc-loading v-show="isLoading"></sc-loading>
                            <table v-show="!isLoading">
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
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            this.getContas();
        },
        data () {
            return {
                novaConta: { 'nome': '' },
                criandoConta: true,
                contas: [],
                isLoading: true,
            }
        },
        methods: {
            showLoading(){
                this.isLoading = true;
            },
            hideLoading(){
                this.isLoading = false;
            },
            criarNovaConta(){

            },
            getContas: function () {
                this.showLoading();
                this.$http.get('/contas/getContas/json').then((response) => {
                    this.hideLoading();
                    this.contas = response.body.contas;
                }, (response) => {
                    this.formErrors = response.data;
                });
            },
        },
    }
</script>
