import Vue from 'vue';
import router from './router.js';
import SocialSharing from 'vue-social-sharing';

Vue.use(SocialSharing);

new Vue({
  router: router,
}).$mount('#app');