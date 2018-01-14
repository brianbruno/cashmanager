
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

window.Vue = require('vue');
window.VueResource = require('vue-resource');
window.VueCharts = require('vue-chartjs');
window.jQuery = require('jquery');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example-component', require('./components/ExampleComponent.vue'));
Vue.component('dashboard', require('./components/Dashboard.vue'));
Vue.component('saldo-conta', require('./components/SaldoConta.vue'));
Vue.component('investimentos', require('./components/Investimentos.vue'));
Vue.component('sc-loading', require('./components/ScreenService/Loading.vue'));
Vue.component('novo-investimento', require('./components/investimentos/NovoInvestimento.vue'));
Vue.component('nova-movimentacao', require('./components/contas/NovaMovimentacao.vue'));
Vue.component('tabela-investimentos', require('./components/investimentos/TabelaInvestimentos.vue'));
Vue.component('line-chart', require('./components/charts/ChartDashboard.vue'));

const app = new Vue({
    el: '#app'
});
