
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

window.Vue = require('vue');
window.VueResource = require('vue-resource');
window.VueCharts = require('vue-chartjs');
window.Datepicker  = require('vuejs-datepicker');
window.Moment = require('moment');
window.jQuery = require('jquery');
window.Chart = require('chart.js');

window.bus = new Vue();
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example-component', require('./components/ExampleComponent.vue'));
Vue.component('dashboard', require('./components/Dashboard.vue'));
Vue.component('saldo-conta', require('./components/contas/SaldoConta.vue'));
Vue.component('investimentos', require('./components/Investimentos.vue'));
Vue.component('sc-loading', require('./components/ScreenService/Loading.vue'));
Vue.component('line-chart', require('./components/charts/ChartDashboard.vue'));
Vue.component('line-chart-lucro-hora', require('./components/charts/ChartLucroHora.vue'));

Vue.component('lucro', require('./components/dashboard/Lucro.vue'));

Vue.component('minha-conta', require('./components/auth/MinhaConta.vue'));

/**
 * Componentes Login
 */
Vue.component('login', require('./components/auth/Login.vue'));
Vue.component('registro', require('./components/auth/Register.vue'));


/**
 * Componentes Invetimentos
 */
Vue.component('novo-investimento', require('./components/investimentos/NovoInvestimento.vue'));
Vue.component('tabela-investimentos', require('./components/investimentos/TabelaInvestimentos.vue'));
Vue.component('invetimentos-finalizados', require('./components/investimentos/RelatorioInvetimentosFinalizados.vue'));

/**
 * Componentes Conta
 */
Vue.component('contas', require('./components/contas/Contas.vue'));
Vue.component('nova-movimentacao', require('./components/contas/NovaMovimentacao.vue'));
Vue.component('tabela-transacoes', require('./components/contas/Transacoes.vue'));
Vue.component('abrir-conta', require('./components/contas/AbrirConta.vue'));
Vue.component('contas-abertas', require('./components/contas/ContasAbertas.vue'));
Vue.component('contas-dados', require('./components/contas/ContasDados.vue'));

/**
 * Componentes externos
 */
Vue.component('date-picker', Datepicker);

/**
 * Componentes Niquelino
 */
Vue.component('niquelino-dashboard', require('./components/niquelino/NiquelinoDashboard.vue'));
Vue.component('niquelino-configuracoes', require('./components/niquelino/NiquelinoConfiguracoes.vue'));
Vue.component('niquelino-saldo', require('./components/niquelino/NiquelinoSaldo.vue'));
Vue.component('niquelino-ordens', require('./components/niquelino/NiquelinoOrdens.vue'));
Vue.component('niquelino-chart-lucro-dia', require('./components/niquelino/charts/LucroPorDia.vue'))

/**
 * Dashboard
 */
Vue.component('valores-mercado', require('./components/dashboard/ValoresMercado.vue'));


const app = new Vue({
    el: '#app'
});
