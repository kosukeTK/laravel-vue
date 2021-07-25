<template>
  <div class="w-full h-full" ref="refMap"></div>
</template>

<script>
import { ref, reactive, onMounted, computed } from 'vue';
import { useRouter } from 'vue-router';
import GoogleMapsApiLoader from 'google-maps-api-loader';
import moment from 'moment';

export default {
  setup() {
    const state = reactive({
      google: null,
      mapConfig: {
        center: {
          lat: 35.6811673,
          lng: 139.7670516,
        },
        zoom: 15,
      },
    });
    const router = useRouter();
    const refMap = ref(null);

    //googlemap選択時、marker、message表示
    const makerPlace = (lat_lng, map, marker, infoWindow) => {
      //markerインスタンス生成
      // let marker = new state.google.maps.Marker({
      //   position: lat_lng,
      //  map: map,
      // });
      marker.setMap(null);
      marker.setPosition(lat_lng);
      marker.setMap(map);
      //ジオコードインスタンス作成
      const geocoder = new state.google.maps.Geocoder();
      geocoder.geocode(
        {
          latLng: lat_lng,
        },
        function (results, status) {
          //選択箇所の住所が有効だった場合
          if (status == state.google.maps.GeocoderStatus.OK) {
            if (results[0].geometry) {
              //住所
              let address = results[0].formatted_address.replace(/^日本、/, '');

              let message = {
                content:
                  '<div style="width:300px; height:120px;">' +
                  '<p class="text-center text-base font-bold">' +
                  address +
                  '</p>' +
                  '<br />' +
                  '<button id="album" class="py-2 px-4  bg-indigo-600 hover:bg-indigo-700 focus:ring-indigo-500 focus:ring-offset-indigo-200 text-white w-full transition ease-in duration-200 text-center text-base font-semibold shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 rounded-lg">アルバム作成</button>' +
                  '</div>',
              };
              infoWindow.setOptions(message);
              infoWindow.open(map, marker);
              console.log(address);

              // let handle = map.addListener(infoWindow, 'domready', () => {
              //   document.getElementById('album').addEventListener('click', () => {
              //     albumCreate(address);
              //   });
              // });
              // console.log(handle);
              google.maps.event.clearListeners(infoWindow, 'domready');
              infoWindow.addListener('domready', () => {
                document.getElementById('album').addEventListener('click', () => {
                  albumCreate(address);
                });
              });
            }
          }
        }
      );
      map.panTo(lat_lng);
    };

    //アルバム作成画面へ遷移
    const albumCreate = (address) => {
      console.log('test');
      router.push({
        name: 'albumUpload',
        params: {
          date: moment().format('YYYY-MM-DD'),
          address: address,
        },
      });
    };

    onMounted(async () => {
      //googlemap認証
      state.google = await GoogleMapsApiLoader({
        apiKey: 'AIzaSyDVcINCNOxYqEzXVm1TmUHy8OVeLuDB2mA',
      });
      //googlemapインスタンス生成
      const map = new state.google.maps.Map(refMap.value, state.mapConfig);
      //markerインスタンス生成
      const marker = new state.google.maps.Marker();
      //
      const infoWindow = new state.google.maps.InfoWindow();
      //googlemapのclickイベント
      map.addListener('click', (e) => {
        makerPlace(e.latLng, map, marker, infoWindow);
      });
      // const myfunc = document.getElementById('album');
      // // myfunc.onclick = albumCreate('test112');
      // console.log(myfunc);
      // myfunc.addEventListener(click, () => {
      //   console.log(fffd);
      // });
    });

    return {
      state,
      refMap,
      makerPlace,
      albumCreate,
    };
  },
};
</script>
