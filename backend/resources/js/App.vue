<template>
  <!-- <div class="back"> -->
  <div class="">
    <!-- <header-view></header-view> -->
    <!-- <router-view v-slot="slotProps">
      <transition name="route" mode="out-in">
      <component :is="slotProps.component"></component>
      </transition>
    </router-view> -->
    <router-view></router-view>
    <footer-view></footer-view>
  </div>
</template>
<script>
// import Header from './components/Header.vue';
import Footer from './components/Footer.vue';

export default {
  components: {
    // 'header-view': Header,
    'footer-view': Footer,
  },
};
</script>
<style>
.route-enter-from,
.route-leave-to {
  opacity: 0;
  transform: translateY(-30px);
}
.route-enter-active,
.route-leave-active {
  transition: all 0.3s ease;
}
.route-enter-to,
.route-leave-from {
  opacity: 1;
  transform: translateY(0);
}
</style>
