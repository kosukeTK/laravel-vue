<template>
  <div class="relative max-w-full max-h-full z-0">
    <Header></Header>
    <div class="max-h-screen py-12 px-4 sm:px-6 lg:px-8">
      <div class="max-w-lg mx-auto w-full space-y-6">
        <div class="relative">
          <div for="date-label" class="text-gray-700 w-full">
            日付
            <span class="text-red-500 required-dot"> * </span>
          </div>
          <input type="date" id="date-label" v-model="state.form.date" class="ring-red-500 ring-2 rounded-lg border-transparent flex-1 appearance-none border border-gray-300 w-2/3 py-2 px-4 bg-white text-gray-700 placeholder-gray-400 shadow-sm text-base focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent" name="email" placeholder="Your email" />
          <div v-show="state.formError.date">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" class="absolute text-red-500 left-36 bottom-3" viewBox="0 0 1792 1792">
              <path
                d="M1024 1375v-190q0-14-9.5-23.5t-22.5-9.5h-192q-13 0-22.5 9.5t-9.5 23.5v190q0 14 9.5 23.5t22.5 9.5h192q13 0 22.5-9.5t9.5-23.5zm-2-374l18-459q0-12-10-19-13-11-24-11h-220q-11 0-24 11-10 7-10 21l17 457q0 10 10 16.5t24 6.5h185q14 0 23.5-6.5t10.5-16.5zm-14-934l768 1408q35 63-2 126-17 29-46.5 46t-63.5 17h-1536q-34 0-63.5-17t-46.5-46q-37-63-2-126l768-1408q17-31 47-49t65-18 65 18 47 49z"
              ></path>
            </svg>
            <p class="absolute text-sm text-red-500 -bottom-6">日付を入力してください。</p>
          </div>
        </div>
        <div class="relative">
          <label for="address-label" class="text-gray-700">
            住所
            <span class="text-red-500 required-dot"> * </span>
          </label>
          <input type="text" id="address-label" v-model="state.form.address" class="rounded-lg flex-1 appearance-none border border-gray-300 w-full py-2 px-4 bg-white text-gray-700 shadow-sm text-base" readonly />
        </div>
        <div class="relative">
          <label for="title-label" class="text-gray-700">
            タイトル
            <span class="text-red-500 required-dot"> * </span>
          </label>
          <input type="text" id="date-label" v-model="state.form.title" class="ring-red-500 ring-2 rounded-lg border-transparent flex-1 appearance-none border border-gray-300 w-full py-2 px-4 bg-white text-gray-700 placeholder-gray-400 shadow-sm text-base focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent" />
          <div v-show="state.formError.title">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" class="absolute text-red-500 right-2 bottom-3" viewBox="0 0 1792 1792">
              <path
                d="M1024 1375v-190q0-14-9.5-23.5t-22.5-9.5h-192q-13 0-22.5 9.5t-9.5 23.5v190q0 14 9.5 23.5t22.5 9.5h192q13 0 22.5-9.5t9.5-23.5zm-2-374l18-459q0-12-10-19-13-11-24-11h-220q-11 0-24 11-10 7-10 21l17 457q0 10 10 16.5t24 6.5h185q14 0 23.5-6.5t10.5-16.5zm-14-934l768 1408q35 63-2 126-17 29-46.5 46t-63.5 17h-1536q-34 0-63.5-17t-46.5-46q-37-63-2-126l768-1408q17-31 47-49t65-18 65 18 47 49z"
              ></path>
            </svg>
            <p class="absolute text-sm text-red-500 -bottom-6">タイトルを入力してください。</p>
          </div>
        </div>
        <div class="relative">
          <label class="text-gray-700" for="name">コメント</label>
          <textarea v-model="state.form.comment" class="flex-1 appearance-none border border-gray-300 w-full py-2 px-2 bg-white text-gray-700 placeholder-gray-400 rounded-lg text-base focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent" id="comment" placeholder="Enter your comment" name="comment" rows="3" cols="40"> </textarea>
        </div>
      </div>
      <div class="mx-auto my-4 drop_area" accept="image/*" :class="{ enter: state.isEnter }" @dragenter="dragEnter()" @dragleave="dragLeave()" @dragover.prevent @drop.prevent="dropFile()">
        <label for="selectFile">
          画像をドラッグ＆ドロップ または クリックしてファイル選択
          <input type="file" id="selectFile" accept="image/*" @change="selectFile($event)" style="display: none" multiple />
        </label>
      </div>
      <div v-show="state.newFiles.length" class="max-w-lg mx-auto my-6 w-full">
        <button type="button" @click="fileSend()" class="py-2 px-6 bg-blue-600 hover:bg-blue-700 focus:ring-blue-500 focus:ring-offset-blue-200 text-white w-full transition ease-in duration-200 text-center text-base font-semibold shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 rounded-full">送信</button>
      </div>
      <ul class="grid grid-cols-8 justify-center items-center">
        <li class="col-span-1" v-for="(preview, index) in state.newFiles" :key="index" @click="fileDel(index)">
          <div class="relative">
            <div class="absolute right-8">
              <span class="delete-mark z-10 font-bold" style="cursor: pointer">x</span>
            </div>
            <img :src="preview.fileUrl" />
          </div>
          <span>{{ preview.fileName }}</span>
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
import { reactive, onMounted } from 'vue';
import axios from 'axios';
import ImageUtil from '../helpers/imageUtil.js';
import { useRoute } from 'vue-router';
import Header from '../components/Header.vue';
import Footer from '../components/Footer.vue';
export default {
  components: {
    Header,
    Footer,
  },

  setup() {
    const route = useRoute();
    const state = reactive({
      form: {
        date: '',
        address: '',
        title: '',
        comment: '',
      },
      formError: {
        date: false,
        title: false,
      },
      isEnter: false,
      files: [],
      newFiles: [],
    });
    //ドラッグIN
    const dragEnter = () => {
      state.isEnter = true;
    };
    //ドラッグOUT
    const dragLeave = () => {
      state.isEnter = false;
    };
    //ドロップ追加
    const dropFile = () => {
      //    state.bufFiles = [...event.dataTransfer.files]
      [...event.dataTransfer.files].forEach((file, index) => {
        if (file.length === 0 || file.type.indexOf('image') !== 0) {
          return;
        }
        //    state.urls[index] = URL.createObjectURL(file)
        //    state.files[index] = file
        fileProcessing(file, index);
      });
      //state.files = [...event.dataTransfer.files]
      state.isEnter = false;
      state.files = [...event.dataTransfer.files];
    };
    //選択追加
    const selectFile = (event) => {
      [...event.target.files].forEach((file, index) => {
        if (file.length === 0 || file.type.indexOf('image') !== 0) {
          return;
        }
        //    state.urls[index] = URL.createObjectURL(file)
        //    state.files[index] = file
        fileProcessing(file, index);
      });
      state.isEnter = false;
      state.files = [...event.target.files];
    };
    //画像圧縮、リサイズ、プレビュー
    const fileProcessing = async (file, index) => {
      try {
        let compFile = await ImageUtil.getCompressImageFileAsync(file, 200);
        //    state.upimage.blob = compFile
        let obj = {};
        //    state.newFileUrls[index] = await ImageUtil.getDataUrlFromFile(compFile)
        //    state.newFiles[index] = file.name
        obj.fileUrl = await ImageUtil.getDataUrlFromFile(compFile);
        obj.fileName = file.name;
        state.newFiles.push(obj);
      } catch (err) {
        console.log(err);
      }
    };
    //ファイル削除
    const fileDel = (index) => {
      state.newFiles.splice(index, 1);
    };
    //フォームチェック
    const formCheck = () => {
      if (!state.form.date) {
        state.formError.date = true;
        return;
      }
      if (!state.form.title) {
        state.formError.title = true;
        return;
      }
    };
    //ファイル送信
    const fileSend = () => {
      //errorチェック
      formCheck();
      let form = new FormData();
      state.files.forEach((file, index) => {
        form.append('file[' + index + ']', file);
      });
      form.append('date', state.form.date);
      form.append('address', state.form.address);
      form.append('title', state.form.title);
      form.append('comment', state.form.comment);
      let config = { headers: { 'content-type': 'multipart/form-data' } };
      axios
        .post('albumDetail/upload', form, config)
        .then((res) => {
          console.log(res.data);
        })
        .catch((err) => {
          console.log(err);
        });
    };
    onMounted(() => {
      state.form.date = route.params.date;
      state.form.address = route.params.address;
    });

    return {
      state,
      dragEnter,
      dragLeave,
      dropFile,
      selectFile,
      fileDel,
      fileSend,
      fileProcessing,
    };
  },
};
</script>
