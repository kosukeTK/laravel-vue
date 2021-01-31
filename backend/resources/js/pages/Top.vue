<template>
    <div class="container marketing">
        <div class="row inner cover">
            <h1 class="cover-heading">Cover your page.</h1>
            <p class="lead">
                Cover is a one-page template for building simple and beautiful
                home pages. Download, edit the text, and add your own fullscreen
                background photo to make it your own.
            </p>
            <p class="lead">
                <a href="#" class="btn btn-lg btn-secondary">Learn more</a>
            </p>
        </div>
        <div id="aichi"></div>
    </div>
</template>

<script>
import "leaflet/dist/leaflet.css";
import { reactive, onMounted } from "vue";
import axios from "axios";
import L from "leaflet";

export default {
    setup() {
        //レイヤー初期化
        const state = reactive({
            position: [],
            sakujoFlg: false,
        });

        onMounted(() => {
            //MAP表示
            const map = L.map("aichi", {
                center: L.latLng(35.135461, 137.145459),
                zoom: 9.5,
                maxBounds: [
                    [35.378212, 136.680559],
                    [34.579942, 137.848071],
                ],
                scrollWheelZoom: false,
                boxZoom: false,
                dragging: false,
                zoomControl: false,
                doubleClickZoom: false,
                preferCanvas: true,
            }).addLayer(
                L.tileLayer(
                    "https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png",
                    {
                        attribution:
                            '© <a href="http://osm.org/copyright">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>',
                    }
                )
            );

            //GeoJsonファイルを取得
            axios.get("/json").then((response) => {
                const layers = {};
                const data = response.data;
                console.log(data);
                const filePath = "N03-19_23_190101.geojson";
                layers[filePath] = L.geoJson(data, {
                    style: function (feature) {
                        return {
                            weight: 2,
                            opacity: 1,
                            color: "white",
                            dashArray: "",
                            fillOpacity: 0.3,
                            fillColor: "green",
                        };
                    },
                    onEachFeature: function (feature, layer) {
                        layer.on("mouseover", function (e) {
                            this.openPopup();
                        });
                        layer.on("mouseout", function (e) {
                            this.closePopup();
                        });
                        layer.on("click", function (e) {
                            state.sakujoFlg = false;
                            state.position.forEach((value) => {
                                if (value === feature.properties.N03_004) {
                                    state.sakujoFlg = true;
                                }
                            });
                            if (state.sakujoFlg) {
                                layer.setStyle({
                                    fillColor: "green",
                                });
                                let val = feature.properties.N03_004;
                                let index = state.position.indexOf(val);
                                state.position.splice(index, 1);
                                console.log(state.position);
                            } else {
                                layer.setStyle({
                                    fillOpacity: 0.7,
                                    fillColor: "red",
                                });
                                state.position.push(feature.properties.N03_004);
                                console.log(state.position);
                            }
                        });
                        layer.bindPopup(feature.properties.N03_004);
                    },
                }).addTo(map);
            });
        });
        return {
            state,
        };
    },
};
</script>

<style>
html,
body,
#aichi {
    height: 800px;
}
body {
    margin: 20;
}
</style>

// var myPolygonStyle={ // "color": "#FF00FF", // "weight": 1, // "opacity":
0.9, // "lineCap": "butt", // "lineJoin": "square", // "dashArray": "5 2", //
"dashOffset": 1, // "fillColor": "#00FF00", // "fillOpacity": 0.3, // }
//).on('moveend', moveInitLatLng); // ).on('click', onMapClick); // function
onMapClick(e) { // var mk = L.marker(e.latlng).on('click',
onMarkerClick).addTo(map); // } // function onMarkerClick(e) { //
map.removeLayer(e.target); // } // function moveInitLatLng(e) { //
map.panTo(mapInitLatLng); // } //.on('click', onMapClick) //
.panTo(mapInitLatLng); //クリック時 // const popup = L.popup(); // function
onMapClick(e) { // popup // .setLatLng(e.latlng) // .setContent("You clicked the
map at " + e.latlng.toString()) // .openOn(map); // }
