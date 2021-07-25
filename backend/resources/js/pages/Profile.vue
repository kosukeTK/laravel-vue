<template>
  <div class="relative max-w-full max-h-full z-0">
    <Header></Header>
    <Load :show="state.show"></Load>
    <!-- <div class="px-4 sm:px-0 flex justify-center">
      <div class="w-full max-w-xs mx-auto">
        <h3 class="text-lg font-medium leading-6 text-gray-900">プロフィール</h3>
        <p class="mt-1 text-sm text-gray-600">Use a permanent address where you can receive mail.</p>
      </div>
    </div> -->
    <div class="content mt-5 md:mt-0">
      <div class="shadow overflow-hidden sm:rounded-md">
        <div class="px-4 pb-5 bg-white sm:p-6">
          <div class="my-4">
            <label for="name" class="block text-sm font-medium text-gray-700">名前</label>
            <input type="text" v-model="state.form.name" id="name" autocomplete="name" class="px-2 py-2 focus:ring-indigo-500 focus:border-indigo-500 block shadow-sm sm:text-sm border-2 border-gray-300 rounded-lg" />
          </div>

          <div class="my-4">
            <label for="email" class="block text-sm font-medium text-gray-700">メールアドレス</label>
            <input type="text" v-model="state.form.email" id="email" autocomplete="email" class="px-2 py-2 w-64 focus:ring-indigo-500 focus:border-indigo-500 block shadow-sm sm:text-sm border-2 border-gray-300 rounded-lg" />
          </div>

          <div class="my-4">
            <label for="prefectures" class="block text-sm font-medium text-gray-700">都道府県</label>
            <select id="prefectures" @change="selectCity()" v-model="state.form.prefectures" autocomplete="prefectures" class="w-36 mt-1 block py-2 px-2 border-2 border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
              <option v-for="prefecture in state.pref_city" :key="prefecture.id" :value="prefecture.name">
                {{ prefecture.name }}
              </option>
            </select>
          </div>

          <div class="my-4">
            <label for="city" class="block text-sm font-medium text-gray-700">市町村</label>
            <select id="city" v-model="state.form.city" autocomplete="city" class="w-36 mt-1 block py-2 px-2 border-2 border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
              <option v-for="city in state.city" :key="city.citycode" :value="city.city">
                {{ city.city }}
              </option>
            </select>
          </div>
          <div>
            <div class="my-4">
              <label class="block text-sm font-medium text-gray-700"> Photo </label>
              <div class="mt-1 flex items-center">
                <span class="inline-block h-20 w-20 rounded-full overflow-hidden bg-gray-100">
                  <!-- 既に写真が登録される -->
                  <div v-if="state.form.photo">
                    <!-- <img class="h-full w-full" :src="'storage/1/20190615 アラジン🧙♂️_210314_2.jpg'" /> -->
                    <img class="h-full w-full" :src="state.form.photo_path" />
                  </div>
                  <!-- 写真の登録なし -->
                  <div v-else>
                    <svg class="h-full w-full text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                      <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                  </div>
                </span>
                <input type="file" accept="image/*" @change="selectPhoto($event)" class="ml-5 bg-white py-2 px-3 border border-gray-300 rounded-md shadow-sm text-sm leading-4 font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" />
              </div>
            </div>
            <div class="my-4">
              <label class="block text-sm font-medium text-gray-700"> Cover photo </label>
              <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                <!-- 既に登録されている -->
                <div v-if="state.form.photo_cover">
                  <label for="photo-cover" class="relative cursor-pointer">
                    <img class="h-full w-full" :src="state.form.photo_cover_path" />
                    <input id="photo-cover" @change="selectCoverPhoto($event)" name="file-upload" type="file" class="sr-only" />
                  </label>
                </div>
                <!-- 写真の登録なし -->
                <div v-else class="space-y-1 text-center">
                  <div>
                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                      <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                  </div>
                  <div class="flex text-sm text-gray-600">
                    <label for="file-upload" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                      <span>Upload a file</span>
                      <input id="file-upload" @change="selectCoverPhoto($event)" name="file-upload" type="file" class="sr-only" />
                    </label>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
          <button type="submit" @click="update()" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Save</button>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { reactive, onMounted } from 'vue';
import axios from 'axios';
import store from '../store/index';
import prefCity from '../../../storage/app/private/pref_city.json';
import ImageUtil from '../helpers/imageUtil.js';
import Load from '../components/Load.vue';
import Header from '../components/Header.vue';

export default {
  components: {
    Load,
    Header,
  },

  setup() {
    const state = reactive({
      form: {},
      file: '',
      cfile: '',
      pref_city: [],
      city: [],
      show: false,
    });
    //都道府県を選択時、該当の市町村をセット
    const selectCity = () => {
      let city = state.pref_city.find((pref) => pref.name === state.form.prefectures);
      state.city = city.city;
      console.log(state.city);
    };
    //写真を選択
    const selectPhoto = (event) => {
      console.log(event.target.files);

      let file = event.target.files[0];
      if (file.lenght === 0 || file.type.indexOf('image') !== 0) {
        return;
      }
      // state.form.photo = file.name;
      fileProcessing(file, 1);
    };
    //カバー写真を選択
    const selectCoverPhoto = (event) => {
      let file = event.target.files[0];
      if (file.lenght === 0 || file.type.indexOf('image') !== 0) {
        return;
      }
      // state.form.cover_photo = file.name;
      fileProcessing(file, 2);
    };
    //画像圧縮、リサイズ、プレビュー
    const fileProcessing = async (file, kbn) => {
      try {
        let size;
        if (kbn === 1) {
          size = 200;
        } else {
          size = 400;
        }
        let compFile = await ImageUtil.getCompressImageFileAsync(file, size);
        let obj = {};
        obj.fileName = file.name;
        obj.fileUrl = await ImageUtil.getDataUrlFromFile(compFile);
        if (kbn === 1) {
          state.file = compFile;
          state.form.photo = obj.fileName;
          state.form.photo_path = obj.fileUrl;
        } else {
          state.cfile = compFile;
          state.form.photo_cover = obj.fileName;
          state.form.photo_cover_path = obj.fileUrl;
        }
      } catch (err) {
        console.log(err);
      }
    };
    //プロフィールを更新
    const update = () => {
      let form = new FormData();
      let config = { headers: { 'content-type': 'multipart/form-data' } };
      let { name, email, prefectures, city, photo, photo_path, photo_cover, photo_cover_path } = state.form;
      form.append('id', store.getters.getLoginInfo.loginId);
      form.append('name', name);
      form.append('email', email);
      form.append('prefectures', prefectures);
      form.append('city', city);
      form.append('photo', photo);
      form.append('photo_path', photo_path);
      form.append('photo_cover', photo_cover);
      form.append('photo_cover_path', photo_cover_path);
      form.append('file', state.file);
      form.append('cfile', state.cfile);
      state.show = true;
      axios
        .post('/profile/update', form, config)
        .then((response) => {
          console.log(response.data);
          state.show = false;
          store.commit('loginInfo', {
            loginState: true,
            loginId: response.data.id,
            loginName: response.data.name,
            photoPath: response.data.photo_path,
          });
        })
        .catch((error) => {
          console.log(error);
          state.show = false;
        });
    };

    onMounted(() => {
      state.show = true;
      axios
        .get('/profile/get', {
          params: {
            id: store.getters.getLoginInfo.loginId,
          },
        })
        .then((response) => {
          state.form = response.data;
          state.pref_city = prefCity;
          selectCity();
          state.show = false;
        })
        .catch((error) => {
          state.show = false;
          console.log(error.data);
        });
    });

    return {
      state,
      selectCity,
      selectPhoto,
      fileProcessing,
      update,
      selectCoverPhoto,
    };
  },
};
</script>
