import {createRouter, createWebHistory} from 'vue-router';

import Top from './pages/Top.vue';
import Album from './pages/Album.vue';
import AlbumDetail from './pages/AlbumDetail.vue';
import Todo from './pages/Todo.vue';
import Login from './pages/Login.vue';
import register from './pages/register.vue';

import jwtToken from './helpers/jwt_token.js';
//import store from './store/index.js';

const routes = [
    {
        path: '/',
        name: 'top',
        component: Top,
        meta: {}
    },
    {
        path: '/login',
        name: 'login',
        component: Login,
        meta: {}
    //    meta: {requiresGuest: true}
    },
    {
        path: '/register',
        name: 'register',
        component: register,
        meta: {}
    //    meta: {requiresGuest: true}
    },
    {
        path: '/album',
        name: 'album',
        component: Album,
        meta: {}
    //    meta: {requiresAuth: true}
    },
    {
        path: '/album/albumDetail',
        name: 'albumDetail',
        component: AlbumDetail,
        meta: {}
    //    meta: {requiresAuth: true}
    },
    {
        path: '/todo',
        name: 'todo',
        component: Todo,
        meta: {}
    //    meta: {requiresAuth: true}
    }
]

// const router = new VueRouter({
//     mode: 'history',
//     routes
// })
const router = createRouter({
    history: createWebHistory(),
    routes
})

//router.beforeEach(async (to, from, next) => {
router.beforeEach((to, from, next) => {
	// トークンあり／ステータスなし
//	if (jwtToken.getToken() && !store.getters.isLoggedIn) {
//    if (jwtToken.getToken() && !store.getUser()) {
//    if (jwtToken.getToken()){
//		let {data: authUser} = axios.get('user');
//		await store.dispatch('setAuthUser', authUser);
//        store.setName(authUser);
//	}
	if (to.meta.requiresAuth) {
//		if (store.getters.isLoggedIn || jwtToken.getToken())
//		if (store.getUser() || jwtToken.getToken())
    if (jwtToken.getToken())
			return next();
		else
			return next({name: 'login'});
	}
	if (to.meta.requiresGuest) {
//		if (store.getters.isLoggedIn || jwtToken.getToken())
//        if (store.getUser() || jwtToken.getToken())
        if (jwtToken.getToken())
			return next({name: 'top'});
		else
			return next();
	}
	next();
});

export default router

