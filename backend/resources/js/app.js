/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

// import 'bootstrap/dist/css/bootstrap.css'
// import 'bootstrap-vue/dist/bootstrap-vue.css'
// import BootstrapVue from 'bootstrap-vue'

import { createApp } from 'vue'
import App from './App.vue'
import router from './router.js'
//import { createStore } from 'vuex'
// import store from './store/index.js'
// import jwtToken from './helpers/jwt_token.js';

//リクエスト
// axios.interceptors.request.use(config => {
// 	config.headers['X-CSRF-TOKEN'] = window.Laravel.csrfToken;
// 	config.headers['X-Requested-With'] = 'XMLHttpRequest';

// 	if (jwtToken.getToken()) {
// 		config.headers['Authorization'] = 'Bearer ' + jwtToken.getToken();
// 	}

// 	return config;
// }, error => {
// 	return Promise.reject(error);
// });
// //レスポンス
// axios.interceptors.response.use(response => {
// 	return response;
// }, error => {
// 	let errorResponseData = error.response.data;

// 	const errors = ["token_invalid", "token_expired", "token_not_provided"];

// 	if (errorResponseData.error && errors.includes(errorResponseData.error)) {
// 		store.dispatch('unsetAuthUser')
// 			.then(() => {
// 				jwtToken.removeToken();
// 				router.push({name: 'login'});
// 			});
// 	}
// 	return Promise.reject(error);
// });

const app = createApp(App);
//app.use(store)
// app.use(BootstrapVue)
app.use(router);
app.mount('#app');
// router.isReady().then(() => {
//     app.mount('#app');
// });

//window.Vue = require('vue').default;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

//Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

//const app = new Vue({
//    el: '#app',
//});
