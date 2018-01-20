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
                                    <th class="center">Fechar</th>
                                </tr>
                                </thead>

                                <tbody>
                                <tr v-for="conta in contas">
                                    <td>{{ conta.conta_id }}</td>
                                    <td>{{ conta.nome }}</td>
                                    <td class="center"><a href="#modal1" v-on:click="confimarDelete(conta.conta_id, conta.nome)" class="black-text modal-trigger"><i class="material-icons">close</i></a></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Structure -->
        <div id="modal1" class="modal">
            <div class="modal-content">
                <h4>Confirma fechar conta {{ fechar.nome }}?</h4>
            </div>
            <div class="modal-footer">
                <a href="#" class="modal-action modal-close waves-effect waves-green btn-flat">Cancelar</a>
                <a href="#" v-on:click="deletarConta(fechar.conta_id)" class="modal-action modal-close waves-effect red darken-4 waves-red btn">Fechar conta</a>
            </div>
        </div>

    </div>
</template>

<script>
    export default {
        mounted() {
            this.getContas();
            jQuery(document).ready(function(){
                jQuery('#modal1').modal();
            });

            bus.$on('nova-conta', () => {
                this.getContas();
            });
        },
        data () {
            return {
                novaConta: { 'nome': '' },
                criandoConta: true,
                contas: [],
                fechar: {'nome': '', 'conta_id': '000000000'},
                isLoading: true,
                csrf_token: jQuery('meta[name="csrf-token"]').attr('content'),
                elem: '',
                instance: '',
            }
        },
        methods: {
            showLoading(){
                this.isLoading = true;
            },
            hideLoading(){
                this.isLoading = false;
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
            deletarConta: function(conta_id){
                var input = this.fechar;
                input._token = this.csrf_token;

                if(this.fechar.conta_id === '000000000' || !this.fechar.conta_id)
                    M.toast({html: 'Ocorreu um erro e a conta não poderá ser fechada agora. Tente novamente mais tarde', classes: 'rounded'});
                else if (this.fechar.nome === 'Conta Padrão') {
                    M.toast({html: 'Não é possível deletar a conta padrão.', classes: 'rounded'});
                }
                else {
                    this.showLoading();
                    this.$http.post('/contas/apagar', input).then((response) => {
                        M.toast({html: response.body.message, classes: 'rounded'});
                        bus.$emit('nova-conta');
                    }, (response) => {
                        M.toast({html: response.body.message, classes: 'rounded'});
                        this.formErrors = response.data;
                    }).finally(function () {
                        this.fechar = {'nome': '', 'conta_id': '000000000'};
                    });
                }
            },
            confimarDelete: function (conta_id, nome) {
                this.fechar.nome = nome;
                this.fechar.conta_id = conta_id;
                jQuery('#modal1').modal('open');
            }

        },
    }
</script>
