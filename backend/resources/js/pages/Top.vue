<template>
  <div class="relative max-w-full max-h-full z-0">
    <Header></Header>
    <div class="bg-white dark:bg-gray-800 flex relative z-10 items-center">
      <div class="container mx-auto px-6 flex flex-col justify-between items-center relative py-8">
        <div class="flex flex-col">
          <h1 class="font-light w-full uppercase text-center text-4xl sm:text-5xl dark:text-white text-gray-800">The React Framework for Production</h1>
          <h2 class="font-light max-w-2xl mx-auto w-full text-xl dark:text-white text-gray-500 text-center py-8">Next.js gives you the best developer experience with all the features you need for production: hybrid static &amp; server rendering, TypeScript support, smart bundling, route pre-fetching, and more. No config needed.</h2>
          <div class="flex items-center justify-center mt-4">
            <a href="#" class="uppercase py-2 px-4 bg-gray-800 border-2 border-transparent text-white text-md mr-4 hover:bg-gray-900"> Get started </a>
            <a href="#" class="uppercase py-2 px-4 bg-transparent border-2 border-gray-800 text-gray-800 dark:text-white hover:bg-gray-800 hover:text-white text-md"> Documentation </a>
          </div>
        </div>
        <div class="block w-full mx-auto mt-6 md:mt-0 relative">
          <!-- <img src="/images/object/12.svg" class="max-w-xs md:max-w-2xl m-auto" /> -->
        </div>
      </div>
    </div>
    <div v-show="loginState" class="containerrounded-lg mx-auto w-full relative flex items-center" style="height: 1080px">
      <GoogleMap></GoogleMap>
    </div>
  </div>
</template>

<script>
import 'leaflet/dist/leaflet.css';
import { reactive, onMounted, computed } from 'vue';
import store from '../store/index';
import Header from '../components/Header.vue';
import GoogleMap from '../components/GoogleMap.vue';

export default {
  components: {
    Header,
    GoogleMap,
  },

  setup() {
    //レイヤー初期化
    const state = reactive({
      login_states: false,
      login_id: '',
      login_name: '',
    });

    const loginState = computed(() => {
      return store.getters.getLoginInfo.loginState;
    });

    // onMounted(() => {
    //   if (store.getters.getLoginInfo.loginState) {
    //     state.login_status = true;
    //     state.login_id = store.getters.getLoginInfo.loginId;
    //     state.login_name = store.getters.getLoginInfo.loginName;
    //   }
    // });

    return {
      state,
      loginState,
    };
  },
};
</script>

<style>
.fade-enter-active,
.fade-leave-active {
  transition: all 3s ease;
}
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
.fade-enter-to,
.fade-leave-from {
  opacity: 1;
}
</style>
