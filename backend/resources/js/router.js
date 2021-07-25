import {createRouter, createWebHistory} from 'vue-router';

import Top from './pages/Top.vue';
import Login from './pages/Login.vue';
import Register from './pages/Register.vue';
import Profile from './pages/Profile.vue';
import albumUpload from './pages/AlbumUpload.vue';
import AlbumList from './pages/AlbumList.vue';
import AlbumListDetail from './pages/AlbumListDetail.vue';
import Todo from './pages/Todo.vue';
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
    path: '/albumList',
    name: 'albumList',
    component: AlbumList,
    meta: {requiresAuth: true}
  },
  {
    path: '/albumListDetail',
    name: 'albumListDetail',
    component: AlbumListDetail,
    meta: {requiresAuth: true}
  },
  {
    path: '/albumUpload',
    name: 'albumUpload',
    component: albumUpload,
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
    if (store.getters.getLoginInfo.loginState) {
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

