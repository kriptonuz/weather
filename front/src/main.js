import Vue from 'vue'
import App from './App.vue'
import axios from 'axios'

import "bootstrap/dist/css/bootstrap.min.css"

Vue.config.productionTip = false

window.axios = axios

new Vue({
  render: h => h(App),
}).$mount('#app')
