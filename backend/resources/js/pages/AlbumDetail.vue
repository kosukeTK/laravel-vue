<template>
  <div class="container">
    <div class="drop_area" accept="image/*" :class="{ enter: state.isEnter }" @dragenter="dragEnter()" @dragleave="dragLeave()" @dragover.prevent @drop.prevent="dropFile()">
      <label for="selectFile">
        画像をドラッグ＆ドロップ または クリックしてファイル選択
        <input type="file" id="selectFile" accept="image/*" @change="selectFile($event)" style="display: none" multiple />
      </label>
    </div>
    <ul class="flex">
      <li class="flex-col" v-for="(preview, index) in state.newFiles" :key="index" @click="fileDel(index)">
        <div style="position: relative">
          <span class="delete-mark">×</span>
          <img :src="preview.fileUrl" />
        </div>
        <span>{{ preview.fileName }}</span>
      </li>
    </ul>
    <!-- <ul class="flex">
            <li class="flex-col" v-for="(newFile, index) in state.newFiles" :key="index">
                {{ newFile }}
            </li>
        </ul> -->
    <div v-show="state.newFiles.length">
      <button class="button" @click="fileSend()">送信！</button>
    </div>
  </div>
</template>

<script>
import { reactive, onMounted } from 'vue';
import axios from 'axios';
import ImageUtil from '../helpers/imageUtil.js';
import { useRoute } from 'vue-router';
export default {
  setup() {
    const route = useRoute();
    const state = reactive({
      isEnter: false,
      files: [],
      //    newFileUrls:[],
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
    //ファイル送信
    const fileSend = () => {
      let form = new FormData();
      let { year, month, day } = route.params;
      state.files.forEach((file, index) => {
        form.append('file[' + index + ']', file);
      });
      //  form.append('file', state.files)
      form.append('year', year);
      form.append('month', month);
      form.append('day', day);
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

    onMounted(() => {});

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
