window._ = require('lodash');

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

import vue from 'vue';
import vuetify from 'vuetify';
vue.use(vuetify);
import Api from "@/services/api.js";
vue.use(Api);

import Helpers from "@/services/helpers";

vue.use(Helpers);


import 'vuetify/dist/vuetify.min.css';
import gameIndex from '@/components/games/index'
import gameShow from '@/components/games/show'
import register from '@/components/auth/register';
import login from '@/components/auth/login';
// import 'material-design-icons-iconfont/dist/material-design-icons.css';

/**
 * For the demo it will use a simple event bus
 */
window.Bus = new vue();

new vue({
  el: '#app',
  components: {
    gameIndex,
    register,
    login,
    gameShow
  },
  data: () => ({
    loggedIn: false
  }),
  vuetify: new vuetify({
    theme: {
      dark: true,
    },
  }),
  methods: {
    checkToken() {
      const token = this.$api.getToken();
      this.loggedIn = !!token;
    }
  },
  created() {
    this.checkToken();

    Bus.$on('checkToken', payload => {
      this.checkToken();
    });

  }
});

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     forceTLS: true
// });
