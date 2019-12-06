import Vue from 'vue'
import App from './App.vue'
import axios from 'axios'
import moment from 'moment'
import vSelect from 'vue-select'
import 'vue-select/dist/vue-select.css';

import "bootstrap/dist/css/bootstrap.min.css"

Vue.config.productionTip = false

window.axios = axios
window.moment = moment

Vue.component('v-select', vSelect);
new Vue({
  render: h => h(App),
}).$mount('#app')
