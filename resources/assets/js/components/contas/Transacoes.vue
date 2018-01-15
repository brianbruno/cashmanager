<template>
    <div>
        <table>
            <thead class="green lighten-3" id="tableTransacoes">
            <tr>
                <th>Tipo</th>
                <th>ID Transação</th>
                <th>Conta</th>
                <th>Data</th>
                <th>Valor (R$)</th>
            </tr>
            </thead>

            <tbody class="green lighten-5 linhaTabela">
                <tr>
                    <td><span class="green-text"><i class="material-icons">trending_up</i></span></td>
                    <td>14011817390016785484</td>
                    <td>Conta Padrão</td>
                    <td>15/01/2018 - 19:59</td>
                    <th>12,25</th>
                </tr>
                <tr>
                    <td><span class="red-text"><i class="material-icons">trending_down</i></span></td>
                    <td>14011817390026785484</td>
                    <td>Conta Padrão</td>
                    <td>15/01/2018 - 19:59</td>
                    <th>-43,50</th>
                </tr>
            </tbody>
        </table>
        <ul class="pagination center">
            <li class="disabled"><a href="#!"><i class="material-icons">chevron_left</i></a></li>
            <li class="active green lighten-3 black-text"><a href="#!">1</a></li>
            <li class="waves-effect"><a href="#!">2</a></li>
            <li class="waves-effect"><a href="#!">3</a></li>
            <li class="waves-effect"><a href="#!">4</a></li>
            <li class="waves-effect"><a href="#!">5</a></li>
            <li class="waves-effect"><a href="#!"><i class="material-icons">chevron_right</i></a></li>
        </ul>
    </div>
</template>

<script>
    export default {
        mounted() {

        },
        data () {
            return {
                newTransacao : {'tipo': 'S', 'valor': '', 'conta_id': ''},
                contas: {'conta_id': '', 'nome': ''},
                isLoading: false
            }
        },
        methods: {

        },
    }
</script>

<style scoped>
    .linhaTabela :hover {
        background-color: #c8e6c9;
    }
</style>