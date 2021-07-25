<template>
  <div class="relative max-w-full max-h-full z-0">
    <Header></Header>
    <Load :show="state.show"></Load>
    <section class="text-gray-600 body-font overflow-hidden">
      <div v-for="(form, index) in state.form" :key="index" class="container px-5 py-12 mx-auto">
        <div class="-my-8 divide-y-2 divide-gray-100">
          <div @click="albumListDetail(form.user_id, form.album_no)" class="py-8 flex justify-evenly items-center flex-wrap md:flex-nowrap">
            <div class="md:w-2/5 md:mb-0 mb-6 flex-shrink-0 flex flex-col mr-10">
              <img class="w-full h-full" :src="form.file_path" />
            </div>
            <div class="">
              <p class="text-lg font-medium text-gray-900 title-font mb-2">{{ form.date }}</p>
              <p class="text-2xl font-medium text-gray-900 title-font mb-2">{{ form.title }}</p>
              <p class="text-base font-medium text-gray-900 title-font mb-2">{{ form.address }}</p>
              <p class="leading-relaxed">{{ form.comment }}</p>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script>
import { reactive, onMounted } from 'vue';
import axios from 'axios';
import store from '../store/index';
import Header from '../components/Header.vue';
import Load from '../components/Load.vue';
import { useRoute, useRouter } from 'vue-router';

export default {
  components: {
    Load,
    Header,
  },

  setup() {
    const route = useRoute();
    const router = useRouter();

    const state = reactive({
      show: false,
      form: [],
    });

    const albumListDetail = (user_id, album_no) => {
      console.log(user_id + '+' + album_no);
      router.push({
        name: 'albumListDetail',
        params: {
          user_id: user_id,
          album_no: album_no,
        },
      });
    };

    onMounted(() => {
      state.show = true;
      axios
        .get('/albumList/get', {
          params: {
            id: route.params.user_id,
          },
        })
        .then((response) => {
          state.show = false;
          state.form = response.data;
          console.log(state.form);
        })
        .catch((error) => {
          console.log(error.data);
          state.show = false;
        });
    });

    return {
      state,
      albumListDetail,
    };
  },
};
</script>
