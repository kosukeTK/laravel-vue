require('./bootstrap');

// import 'bootstrap/dist/css/bootstrap.css'
// import 'bootstrap-vue/dist/bootstrap-vue.css'
// import BootstrapVue from 'bootstrap-vue'

import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import store from './store/index'
//import jwtToken from './helpers/jwt_token.js';

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
app.use(store);
app.use(router);
app.mount('#app');
// router.isReady().then(() => {
//     app.mount('#app');
// });