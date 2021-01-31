<template>
    <div>
        <div class="alert alert-danger" v-if="state.error">
            <p>ログイン情報が不正です</p>
        </div>
        <div class="content">
            <div class="form-group">
                <label for="email">E-mail</label>
                <input type="email" id="email" class="form-control" placeholder="example@gmail.com" v-model="state.email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" class="form-control" v-model="state.password" required>
            </div>
            <button class="btn btn-default" @click="signIn()">Sign in</button>
        </div>
    </div>
</template>
<script>
import { reactive } from 'vue';
import axios from 'axios';
import jwtToken from '../helpers/jwt_token.js';

export default {

    setup() {
        const state = reactive({
            email: null,
            password: null,
            error: false
        });

        const signIn = () => {
            axios.get('login', {
                params:{
                    email: state.email,
                    password: state.password
                }
            }).then(response => {
            //    jwtToken.setItem(response.data.token);
                console.log(response.data);
            }).catch(error => {
                console.log(error.data)
            })
        };

        return {
            state,
            signIn
        }
    }
}
</script>
