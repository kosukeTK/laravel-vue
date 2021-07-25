<template>
  <div>
    <Header></Header>
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
      <Load :show="state.show"></Load>
      <div class="max-w-md w-full space-y-8">
        <div>
          <img class="mx-auto h-12 w-auto" src="https://tailwindui.com/img/logos/workflow-mark-indigo-600.svg" alt="Workflow" />
          <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">Sign in to your account</h2>
        </div>
        <div class="mt-8 space-y-6">
          <div class="rounded-md -space-y-px">
            <div class="my-4">
              <label for="name" class="block text-sm font-medium text-gray-700">名前</label>
              <input type="text" v-model="state.profile.name" id="name" autocomplete="name" class="w-48 px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500 block shadow-sm sm:text-sm border-2 border-gray-300 rounded-lg" />
              <div v-show="state.form.name_err" class="my-2">
                <div v-for="(e_name, index) in state.form.name_err" :key="index" class="block text-sm font-medium text-red-700">
                  {{ e_name }}
                </div>
              </div>
            </div>

            <div class="my-4">
              <label for="email" class="block text-sm font-medium text-gray-700">メールアドレス</label>
              <input type="text" v-model="state.profile.email" id="email" autocomplete="email" class="w-full px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500 block shadow-sm sm:text-sm border-2 border-gray-300 rounded-lg" />
              <div v-show="state.form.email_err" class="my-2">
                <div v-for="(e_mail, index) in state.form.email_err" :key="index" class="block text-sm font-medium text-red-700">
                  {{ e_mail }}
                </div>
              </div>
            </div>

            <div class="my-4">
              <label for="prefectures" class="block text-sm font-medium text-gray-700">都道府県</label>
              <select id="prefectures" @change="citySelect()" v-model="state.profile.prefectures" autocomplete="prefectures" class="w-36 mt-1 block py-2 px-3 border-2 border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                <option v-for="prefecture in state.pref_city" :key="prefecture.id" :value="prefecture.name">
                  {{ prefecture.name }}
                </option>
              </select>
              <div v-show="state.form.prefectures_err" class="my-2">
                <div v-for="(e_prefectures, index) in state.form.prefectures_err" :key="index" class="block text-sm font-medium text-red-700">
                  {{ e_prefectures }}
                </div>
              </div>
            </div>

            <div class="my-4">
              <label for="city" class="block text-sm font-medium text-gray-700">市町村</label>
              <select id="city" v-model="state.profile.city" autocomplete="city" class="w-36 mt-1 block py-2 px-3 border-2 border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                <option v-for="(city, index) in state.citys" :key="index" :value="city.city">
                  {{ city.city }}
                </option>
              </select>
              <div v-show="state.form.city_err" class="my-2">
                <div v-for="(e_city, index) in state.form.city_err" :key="index" class="block text-sm font-medium text-red-700">
                  {{ e_city }}
                </div>
              </div>
            </div>

            <div class="my-4">
              <label for="password" class="block text-sm font-medium text-gray-700">パスワード</label>
              <input type="password" v-model="state.profile.password" id="password" autocomplete="password" class="w-full px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500 block shadow-sm sm:text-sm border-2 border-gray-300 rounded-lg" />
              <div v-show="state.form.password_err" class="my-2">
                <div v-for="(e_password, index) in state.form.password_err" :key="index" class="block text-sm font-medium text-red-700">
                  {{ e_password }}
                </div>
              </div>
            </div>

            <button @click="register()" type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
              <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                <LockClosedIcon class="h-5 w-5 text-indigo-500 group-hover:text-indigo-400" aria-hidden="true" />
              </span>
              Sign in
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { reactive, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import axios from 'axios';
import store from '../store/index';
import { LockClosedIcon } from '@heroicons/vue/solid';
import prefCity from '../../../storage/app/private/pref_city.json';
import Load from '../components/Load.vue';
import Header from '../components/Header.vue';

export default {
  components: {
    LockClosedIcon,
    Load,
    Header,
  },

  setup() {
    const state = reactive({
      show: false,
      profile: {
        name: '',
        email: '',
        prefectures: '',
        city: '',
        password: '',
      },
      form: {
        name_err: [],
        email_err: [],
        prefectures_err: [],
        city_err: [],
        password_err: [],
      },
      pref_city: [],
      citys: [],
    });

    const router = useRouter();

    const citySelect = () => {
      state.pref_city.map((prefs) => {
        if (prefs.name === state.profile.prefectures) {
          state.citys = prefs.city;
        }
      });
      console.log(state.city);
    };

    const register = () => {
      state.show = true;
      axios
        .post('register/reg', {
          profile: state.profile,
        })
        .then((response) => {
          state.show = false;
          if (response.data.success) {
            console.log(response.data);
            store.commit('loginInfo', {
              loginState: response.data.success,
              loginId: response.data.user.id,
              loginName: response.data.user.name,
            });
            router.push({ name: 'top' });
          }
        })
        .catch((error) => {
          console.log(error.data);
          state.show = false;
          state.form = {};
          state.form.name_err = response.data.validator.name;
          state.form.email_err = response.data.validator.email;
          state.form.prefectures_err = response.data.validator.prefectures;
          state.form.city_err = response.data.validator.city;
          state.form.password_err = response.data.validator.password;
        });
    };

    onMounted(() => {
      state.pref_city = prefCity;
    });

    return {
      state,
      citySelect,
      register,
    };
  },
};
</script>
