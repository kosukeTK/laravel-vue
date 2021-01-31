<template>
    <div class="content">
        <h2>カレンダー{{displayDate}}</h2>
        <div class="button-area">
            <button class="button" @click="prevMonth">前の月</button>
            <button class="button" @click="nextMonth">次の月</button>
        </div>
        <div class="calendar">
            <div class="calendar-weekly">
                <div class="calendar-youbi" v-for="n in 7" :key="n">
                    {{youbi(n-1)}}
                </div>
            </div>
            <div class="calendar-weekly" v-for="(week, index) in calendars" :key="index">
                <div class="calendar-daily" :class="{outside: currentMonth !== day.month}"
                v-for="(day, index) in week" :key="index" @click="albumDetail(currentMonth, day.day)">
                    <div class="calendar-day">
                        {{ day.day }}
                    </div>
                    <div class="" v-for="(album, index) in state.albums" :key="index">
                        <!-- <div v-if="album.day === day.day && album.month === day.month"> -->
                        <div v-if="album.day === day.day && state.albumYM === day.month">
                            <p>{{ album.user_name }}</p>
                            <p>{{ album.album_name }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import moment from 'moment';
import {reactive, computed, onMounted} from 'vue';
import {useRouter} from 'vue-router';
export default {

    setup(){
        const router = useRouter();
        //data
        const state = reactive({
            currentDate: moment(),
            albums:[],
            albumYM: ''
            });
        //曜日
        const youbi = (dayIndex) => {
            const week = ["日", "月", "火", "水", "木", "金", "土"];
            return week[dayIndex];
        };
        //前月
        const prevMonth = () => {
            state.currentDate = moment(state.currentDate).subtract(1, "month");
            getAlbumInfo();
        };
        //次月
        const nextMonth = () => {
            state.currentDate = moment(state.currentDate).add(1, "month");
            getAlbumInfo();
        };
        //月の頭日
        const getStartDate = () => {
            let date = moment(state.currentDate);
            date.startOf("month");
            let youbiNum = date.day();
            return date.subtract(youbiNum, "days");
        };
        //月の末日
        const getEndDate = () => {
            let date = moment(state.currentDate);
            date.endOf("month");
            let youbiNum = date.day();
            return date.add(6 - youbiNum, "days");
        };
        //カレンダー作成
        const getCalendar = () => {
            let startDate = getStartDate();
            const endDate = getEndDate();
            const weekNumber = Math.ceil(endDate.diff(startDate, "days") / 7);

            let calendars = [];
            let calendarDate = getStartDate();
            for(let week = 0; week < weekNumber; week++){
                let weekRow = [];
                for(let day = 0; day < 7; day++){
                    weekRow.push({
                        day: calendarDate.get("date"),
                        month: calendarDate.format("YYYYM")
                    });
                    calendarDate.add(1, "days");
                }
                calendars.push(weekRow);
            }
            return calendars;
        };
        //カレンダー作成実行
        const calendars = computed(() => {
            return getCalendar();
            }
        );
        //年月表示
        const displayDate = computed(() => {
            return state.currentDate.format('YYYY[年]M[月]');
        });
        //正しい表示月
        const currentMonth = computed(() => {
            return state.currentDate.format('YYYYM');
        });

        //画面遷移
        const albumDetail = (date, day) => {
            let year    = date.substr(0, 4);
            let month   = date.substr(4);
            router.push({
                name: 'albumDetail',
                    params: {
                        year: year,
                        month: month,
                        day: day
                    }
            });
        };

        const getAlbumInfo = () => {
        //アルバム情報取得
            axios.get('album/albumInfo', {
                params: {
                    year: state.currentDate.format('YYYY'),
                    month: state.currentDate.format('M')
                    }
            })
            .then(response => {
                state.albums = response.data.album
                state.albumYM = String(state.albums[0].year) + String(state.albums[0].month)
            })
            .catch(error => {
                console.log(error)
            })
        }

        onMounted(() => {
        //アルバム情報取得
            axios.get('album/albumInfo', {
                params: {
                    year: state.currentDate.format('YYYY'),
                    month: state.currentDate.format('M')
                    }
            })
            .then(response => {
                state.albums = response.data.album
                state.albumYM = String(state.albums[0].year) + String(state.albums[0].month)
            })
            .catch(error => {
                console.log(error)
            })
        });

        return {
            state,
            youbi,
            prevMonth,
            nextMonth,
            getStartDate,
            getEndDate,
            getCalendar,
            calendars,
            displayDate,
            currentMonth,
            albumDetail,
            getAlbumInfo
        };
    }
}
</script>
