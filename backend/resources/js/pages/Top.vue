<template>
  <div class="max-w-full max-h-full z-0">
    <div class="max-w-full relative overflow-hidden" style="height:700px">
      <div class="absolute" v-for="(slide, index) in state.slides" :key="index">
        <transition name="fade">
          <img class="object-cover" v-if="state.current_slide === index" :src="slide.img">
        </transition>
      </div>
    </div>
    <!-- <h1 class="cover-heading">
      <input type="button" v-on:click="ondecrement" value="-" />
      {{count}}
      <input type="button" v-on:click="onincrement" value="+" />
    </h1> -->
    <!-- 
    <p class="lead">
      <a href="#" class="btn btn-lg btn-secondary" @click="scrollMap()">↓ 友達を探そう！</a>
    </p> -->
    <!-- <div class="row">
      <div class="col-md-2">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">地域</h4>
          </div>
          <ul class="list-group list-group-flush">
            <li class="list-group-item list-group-item-light" v-for="pos in state.position" :key="pos.index">
              <span>{{ pos }}</span>
            </li>
          </ul>
        </div>
      </div>
      <div class="col-md-10">  
        <div id="aichi"></div>
      </div>
    </div> -->
  </div>
</template>

<script>
import "leaflet/dist/leaflet.css";
import { reactive, onMounted, computed } from "vue";
import axios from "axios";
import L from "leaflet";
import store from "../store/index";

export default {
  setup() {
    //レイヤー初期化
    const state = reactive({
      position: [],
      sakujoFlg: false,
      current_slide: 0,
      slides: [
        {img: '/storage/スクリーンショット (1).png'},
        {img: '/storage/スクリーンショット (3).png'}
      ]
    });

    const scrollMap = () => {
      $('html, body').animate({scrollTop: $('#aichi').offset().top}, 800);
    }

    onMounted(() => {
      setInterval(() => {
        state.current_slide = state.current_slide < state.slides.length -1 ? state.current_slide +1 : 0
        }, 7000)
    //   //MAP表示
    //   const map = L.map("aichi", {
    //     center: L.latLng(35.135461, 137.145459),
    //     zoom: 9.5,
    //     maxBounds: [
    //       [35.378212, 136.680559],
    //       [34.579942, 137.848071],
    //     ],
    //     scrollWheelZoom: false,
    //     boxZoom: false,
    //     dragging: false,
    //     zoomControl: false,
    //     doubleClickZoom: false,
    //     preferCanvas: true,
    //   }).addLayer(
    //     L.tileLayer(
    //       "https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png",
    //       {
    //         attribution:
    //           '© <a href="http://osm.org/copyright">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>',
    //       }
    //     )
    //   );

    //   //GeoJsonファイルを取得
    //   axios.get("/json").then((response) => {
    //     const layers = {};
    //     const data = response.data;
    //     console.log(data);
    //     const filePath = "N03-19_23_190101.geojson";
    //     layers[filePath] = L.geoJson(data, {
    //       style: function (feature) {
    //         return {
    //           weight: 1,
    //           opacity: 1,
    //           color: "white",
    //           dashArray: "",
    //           fillOpacity: 0,
    //           fillColor: "green",
    //         };
    //       },
    //       onEachFeature: function (feature, layer) {
    //         layer.on("mouseover", function (e) {
    //           this.openPopup();
    //         });
    //         layer.on("mouseout", function (e) {
    //           this.closePopup();
    //         });
    //         layer.on("click", function (e) {
    //           state.sakujoFlg = false;
    //           state.position.forEach((value) => {
    //             if (value === feature.properties.N03_004) {
    //               state.sakujoFlg = true;
    //             }
    //           });
    //           if (state.sakujoFlg) {
    //             layer.setStyle({
    //               fillOpacity: 0,
    //             });
    //             let val = feature.properties.N03_004;
    //             let index = state.position.indexOf(val);
    //             state.position.splice(index, 1);
    //             console.log(state.position);
    //           } else {
    //             layer.setStyle({
    //               fillOpacity: 0.7,
    //               fillColor: "red",
    //             });
    //             state.position.push(feature.properties.N03_004);
    //             console.log(state.position);
    //           }
    //         });
    //         layer.bindPopup(feature.properties.N03_004);
    //       },
    //     }).addTo(map);
    //   });
    });

    // const count = computed(() => {
    //   return store.state.count
    // });
    
    // const onincrement = () => {
    //   store.dispatch('increment')
    // };

    // const ondecrement = () => {
    //   store.commit('decrement')
    // };

    return {
      state,
      scrollMap
      // count,
      // onincrement,
      // ondecrement,
    };
  },
};

</script>

<style>
/* html,
body,
#aichi {
  height: 800px;
}
body {
  margin: 20;
} */
.fade-enter-active, .fade-leave-active {
  transition: all 3s ease;
}
.fade-enter-from, .fade-leave-to {
  opacity: 0;
}
.fade-enter-to, .fade-leave-from {
  opacity: 1;
}
</style>