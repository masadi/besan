import Vue from 'vue'
import store from '~/store'
import router from '~/router'
import i18n from '~/plugins/i18n'
import App from '~/components/App'

import '~/plugins'
import '~/components'

Vue.config.productionTip = false
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
Vue.use(BootstrapVue)
Vue.use(IconsPlugin)
import 'bootstrap-vue/dist/bootstrap-vue.css'
import VueLoading from 'vuejs-loading-plugin'
Vue.use(VueLoading)
/* eslint-disable no-new */
new Vue({
  i18n,
  store,
  router,
  ...App
})
