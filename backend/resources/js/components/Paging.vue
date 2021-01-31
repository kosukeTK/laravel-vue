
<template>
	<div class="container">
		<ul class="">
			<li :class="(state.current_page = 1) ? disable : ''" @click="changePage(page -1)">＜</li>
			<li :class="curSelect(page) ? active : nonactive" v-for="page in firstPage()" :key="page" @click="changePage(page)">{{ page }}</li>
			<li class="" v-show="front_dot">...</li>
			<li :class="curSelect(page) ? active : nonactive" v-for="page in midPage()" :key="page" @click="changePage(page)">{{ page }}</li>
			<li class="" v-show="end_dot">...</li>
			<li :class="curSelect(page) ? active : nonactive" v-for="page in endPage()" :key="page" @click="changePage(page)">{{ page }}</li>
			<li :class="(state.current_page = state.last_page) ? disable : ''" @click="changePage(page +1)">＞</li>
		</ul>
	</div>
</template>

<script>
import { reactive } from 'vue';
import axios from 'axios';

export default {

    setup() {
        const state = reactive({
            pictures: [],
            current_page:1,
            last_page: '',
            range: 5,
            isSelect: false,
            front_dot: false,
            end_dot: false
        })
        //現在ページの写真取得
        const getPicture = () => {
            axios.get('album/albumDetail?page=${ state.current_page }'
            .then(res => {
                state.pictures = res.data
                state.current_page = res.data.current_page
                state.last_page = res.data.last_page
            })
            .catch(res => {
                console.log(res.error)
            })
            )
        }
        //ページ範囲
        const calPage = (start, end) => {
            let range = []
            for (let i=start; start<end; i++) {
                range.push(i)
            }
            return range
        }
        //ページ変更
        const changePage = (page) => {
            state.current_page = page
            getPicture()
        }
        //1,2ページ
        const firstPage = computed(() => {
            return calPage(1, 2)
        })
        //中央5ページ
        const midPage = computed(() => {
            let start = "";
            let end = "";
            if (state.current_page <= state.range) { //指定ページが5以下
            start = 3;
            end = state.range + 2;
            state.front_dot = false
            　state.end_dot = true
            } else if (state.current_page > state.last_page - state.range) { //指定ページがMAX-5
            start = state.last_page - state.range - 1;
            end = state.last_page - 2;
            state.front_dot = true
            　state.end_dot = false
            } else {  // 5 ～ MAX-5 の間
            start = state.current_page - Math.floor(state.range / 2);
            end = state.current_page + Math.floor(state.range / 2);
            state.front_dot = true
            　state.end_dot = true
            }
            return state.calRange(start, end);
        })
        //last-1, lastページ
        const endPage = computed(() => {
            return calPage(state.last_page -1, state.last_page)
        })
        //選択中ページ？true : false
        const curSelect = (page) => {
            return page === state.currentPage
        }

        return {
            state,
            getPicture,
            calPage,
            changePage,
            firstPage,
            midPage,
            endPage,
            curSelect
        }
    }
}
</script>
