<template>
  <div class="bg-gray-800">
    <Load :show="state.show"></Load>
    <header class="container mx-auto text-white">
      <div class="px-48 h-20 flex justify-between items-center">
        <a href="#" @click="topPage()" class="transition duration-500 ease-in-out transform hover:scale-110 navbar-brand d-flex align-items-center hover:text-white">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2">
            <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path>
            <circle cx="12" cy="13" r="4"></circle>
          </svg>
          <strong class="text-xl">Album</strong>
        </a>
        <div>
          <button class="md:hidden" @click="state.isOpen = !state.isOpen">
            <svg class="h-6 w-6 fill-current" viewBox="0 0 24 24">
              <path v-show="state.isOpen" d="M24 6h-24v-4h24v4zm0 4h-24v4h24v-4zm0 8h-24v4h24v-4z" />
              <path v-show="!state.isOpen" d="M24 20.188l-8.315-8.209 8.2-8.282-3.697-3.697-8.212 8.318-8.31-8.203-3.666 3.666 8.321 8.24-8.206 8.313 3.666 3.666 8.237-8.318 8.285 8.203z" />
            </svg>
          </button>
        </div>
        <div :class="state.isOpen ? 'hidden' : 'block'">
          <div class="md:flex md:justify-between md:items-center space-x-8">
            <div class="border-b md:border-none">
              <a href="#" @click="albumPage()" class="transition duration-500 ease-in-out transform hover:scale-110 block text-base px-8 py-2 hover:bg-gray-600 hover:text-white rounded">探す</a>
            </div>
            <div class="border-b md:border-none">
              <a href="#" @click="todoPage()" class="transition duration-500 ease-in-out transform hover:scale-110 block text-base px-4 py-2 hover:bg-gray-600 hover:text-white rounded">TODOリスト</a>
            </div>
            <div v-if="state.login_status == false" class="border-b md:border-none">
              <a href="#" @click="registerPage()" class="transition duration-500 ease-in-out transform hover:scale-110 block text-base px-8 py-2 hover:bg-gray-600 hover:text-white rounded">会員登録</a>
            </div>
            <div v-if="state.login_status == false" class="border-b md:border-none">
              <a href="#" @click="loginPage()" class="transition duration-500 ease-in-out transform hover:scale-110 block text-base px-8 py-2 hover:bg-gray-600 hover:text-white rounded">ログイン</a>
            </div>
            <div v-if="state.login_status == false" class="my-4">
              <button type="button" @click="simpleLogin()" class="transition ease-in-out duration-500 transform hover:scale-110 inline-flex items-center px-2 py-2 ml-2 border border-transparent text-base leading-6 font-medium rounded-md text-white bg-red-600 hover:bg-red-500 focus:border-red-700 active:bg-red-700">簡単ログイン</button>
            </div>
            <div v-else class="my-4">
              <!-- <button @click="state.login_status=false" class="px-4 py-2 ml-2 text-base bg-red-500 hover:bg-red-400 hover:text-white rounded">ログアウト</button> -->
              <Menu as="div" class="ml-3 relative">
                <MenuButton class="max-w-xs bg-gray-800 rounded-full text-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white">
                  <span class="sr-only">Open user menu</span>
                  <div v-if="photoPath">
                    <img class="h-12 w-12 mx-auto rounded-full border border-white" :src="photoPath" />
                  </div>
                  <div v-else>
                    <svg class="h-12 w-12 mx-auto rounded-full border border-white" fill="currentColor" viewBox="0 0 24 24">
                      <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                  </div>
                  <div>{{ loginName }}さん</div>
                </MenuButton>
                <transition enter-active-class="transition ease-out duration-100" enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
                  <MenuItems class="z-20 origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none">
                    <MenuItem v-for="item in profile" :key="item" v-slot="{ active }">
                      <a href="#" @click="userInfo(item)" :class="[active ? 'bg-gray-100' : '', 'block px-4 py-2 text-sm text-gray-700']">{{ item }}</a>
                    </MenuItem>
                  </MenuItems>
                </transition>
              </Menu>
            </div>
          </div>
        </div>
      </div>
    </header>
  </div>
  <!-- <img :src="'/storage/スクリーンショット (1).png'"> -->
</template>

<script>
import { Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue';
import { useRouter } from 'vue-router';
import store from '../store/index';
import axios from 'axios';
import { reactive, onMounted, computed } from 'vue';
import Load from '../components/Load.vue';

const profile = ['Profile', 'Sign out'];

export default {
  components: {
    Menu,
    MenuButton,
    MenuItem,
    MenuItems,
    Load,
  },

  setup() {
    const state = reactive({
      guest: '',
      login_status: false,
      login_id: '',
      login_name: '',
      photo_path: '',
      isOpen: false,
      show: false,
    });

    const router = useRouter();

    const topPage = () => {
      router.push({ name: 'top' });
    };

    const loginPage = () => {
      router.push({ name: 'login' });
    };

    const albumPage = () => {
      router.push({ name: 'album' });
    };

    const todoPage = () => {
      router.push({ name: 'todo' });
    };

    const registerPage = () => {
      router.push({ name: 'register' });
    };

    const userInfo = (item) => {
      switch (item) {
        case 'Sign out':
          state.login_status = false;
          sessionStorage.removeItem('loginStates');
          router.push({ name: 'top' });
          break;
        case 'Profile':
          router.push({ name: 'profile' });
          break;
      }
    };

    const simpleLogin = () => {
      state.show = true;
      axios
        .get('simpleLogin', {
          params: {
            id: 1,
          },
        })
        .then((response) => {
          state.show = false;
          state.login_status = true;
          state.guest = response.data.guest;
          console.log(state.guest);
          store.commit('loginInfo', {
            loginState: true,
            loginId: state.guest[0].id,
            loginName: state.guest[0].name,
            photoPath: state.guest[0].photo_path,
          });
          router.routes[{ redirect: '/' }];
        })
        .catch((error) => {
          state.show = false;
          console.log(error);
        });
    };
    const loginName = computed(() => {
      return store.getters.getLoginInfo.loginName;
    });

    const photoPath = computed(() => {
      return store.getters.getLoginInfo.photoPath;
    });

    onMounted(() => {
      if (store.getters.getLoginInfo.loginState) {
        state.login_status = true;
        state.login_id = store.getters.getLoginInfo.loginId;
        state.login_name = store.getters.getLoginInfo.loginName;
        state.photo_path = store.getters.getLoginInfo.photoPath;
      }
    });

    return {
      state,
      topPage,
      loginPage,
      albumPage,
      todoPage,
      registerPage,
      userInfo,
      simpleLogin,
      profile,
      loginName,
      photoPath,
    };
  },
};
</script>
