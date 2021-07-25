<template>
  <div class="relative max-w-full max-h-full z-0">
    <Header></Header>
    <Load :show="state.show"></Load>
    <section class="text-gray-600 body-font">
      <div class="container px-5 py-12 mx-auto">
        <div class="flex flex-wrap -m-4">
          <div v-for="(form, index) in state.form" :key="index" class="lg:w-1/4 md:w-1/2 p-4 w-full">
            <a class="block relative h-48 rounded overflow-hidden">
              <img alt="ecommerce" class="object-cover object-center w-full h-full block" :src="form.file_path" />
            </a>
            <div class="">
              <h2 class="text-gray-900 title-font w-full text-lg font-medium">{{ form.file_name }}</h2>
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
import { useRoute } from 'vue-router';

export default {
  components: {
    Load,
    Header,
  },

  setup() {
    const route = useRoute();

    const state = reactive({
      show: false,
      form: [],
    });

    onMounted(() => {
      console.log(route.params.user_id);
      state.show = true;
      axios
        .get('/albumListDetail/getDetail', {
          params: {
            user_id: route.params.user_id,
            album_no: route.params.album_no,
          },
        })
        .then((response) => {
          state.show = false;
          console.log(response.data);
          state.form = response.data;
        })
        .catch((error) => {
          state.show = false;
          console.log(error.data);
        });
    });

    return {
      state,
    };
  },
};
</script>
