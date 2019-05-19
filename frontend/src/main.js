import Vue from "vue";
import './plugins/vuetify'
import App from "./App.vue";
import router from "./router";

Vue.config.productionTip = false;

const authInfo = {
  authStatus: 0,
  accessLevel: null,
  userId: null
}

new Vue({
  router,
  render: h => h(App),
  data: {
    authInfo
  }
}).$mount("#app");
