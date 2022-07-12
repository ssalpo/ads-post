require('./bootstrap');

import Vue from 'vue'
import VueRouter from 'vue-router'
import routes from './routes'
import App from './components/App.vue'
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'

Vue.use(VueRouter)
Vue.use(BootstrapVue)
Vue.use(IconsPlugin)

const app = new Vue({
    el: '#app',
    components: { App },
    router: new VueRouter(routes)
})
