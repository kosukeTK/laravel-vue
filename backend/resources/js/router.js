import {createRouter, createWebHistory} from 'vue-router';

import Top from './pages/Top.vue';
import Album from './pages/Album.vue';
import AlbumDetail from './pages/AlbumDetail.vue';
import Todo from './pages/Todo.vue';
import Login from './pages/Login.vue';
import Register from './pages/Register.vue';
import Profile from './pages/Profile.vue';
import store from './store/index.js';

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
    meta: {requiresGuest: true}
  },
  {
    path: '/register',
    name: 'register',
    component: Register,
    meta: {requiresGuest: true}
  },
  {
    path: '/album',
    name: 'album',
    component: Album,
    meta: {requiresAuth: true}
  },
  {
    path: '/album/albumDetail',
    name: 'albumDetail',
    component: AlbumDetail,
    meta: {requiresAuth: true}
  },
  {
    path: '/profile',
    name: 'profile',
    component: Profile,
    meta: {requiresAuth: true}
  },
  {
    path: '/todo',
    name: 'todo',
    component: Todo,
    meta: {requiresAuth: true}
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

router.beforeEach((to, from, next) => {
  //ログイン状態
  if (to.meta.requiresAuth) {
    if (store.getters.getLoginInfo.loginName.length > 0) {
        return next();
    } else {
        return next({name: 'login'});
    }
  //ログイン前
  } else if (to.meta.requiresGuest) {
    return next();
  } else {
    return next();
  }
});

export default router

