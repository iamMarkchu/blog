import Vue from 'vue'
import 'element-ui/lib/theme-chalk/index.css'
import ElementUI from 'element-ui'

import router from './router/routes'
import Admin from './components/Admin'
import './permission'

Vue.use(ElementUI)
const app = new Vue({
    el: '#app',
    router,
    render: h => h(Admin)
})