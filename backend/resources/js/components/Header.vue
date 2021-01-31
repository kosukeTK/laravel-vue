<template>
<div class="containter" style="padding-bottom: 80px;">
    <nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#" @click="topPage()">Navbar</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">  
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#" 
                    @click="albumPage()"
                    >探す<span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" @click="registerPage()">新規登録</a>
                    <!-- <router-link to="/register">新規登録</router-link> -->
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" @click="loginPage()">ログイン</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" @click="todoPage()">TODO</a>
                </li>
            </ul>       
        </div>
    </nav>
</div>
    <!-- <img :src="'/storage/スクリーンショット (1).png'"> -->
</template>

<script>
import {useRouter} from 'vue-router';
//import {ref} from 'vue';
export default {

    setup(){
        const router = useRouter();

        const topPage = () => {
            router.push({name: 'top'})

        };

        const loginPage = () => {
            router.push({name: 'login'})
        };

        const albumPage = () => {
            router.push({name: 'album'})
        };

        const todoPage = () => {
            router.push({name: 'todo'})
        };

        const registerPage = () => {
            router.push({name: 'register'})
        };

        return{
            topPage,
            loginPage,
            albumPage,
            todoPage,
            registerPage
        };
    }
}
</script>
