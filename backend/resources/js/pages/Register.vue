<template>
    <div>
        <div class="alert alert-danger" v-if="state.error && !success">
            <p>登録できなーい！</p>
        </div>
        <div class="alert alert-success" v-if="state.success">
            <p>登録完了！</p>
        </div>
        <div>
            <div class="form-group" :class="{ 'has-error': state.error && state.errMsg.username }">
                <label for="name">Name</label>
                <input type="text" id="name" class="form-control" v-model="state.name" required>
                <span class="help-block" v-if="state.error && state.errMsg.name">{{ state.errMsg.name }}</span>
            </div>
            <div class="form-group" v-bind:class="{ 'has-error': state.error && state.errMsg.email }">
                <label for="email">E-mail</label>
                <input type="email" id="email" class="form-control" placeholder="gavin.belson@hooli.com" v-model="state.email" required>
                <span class="help-block" v-if="state.error && state.errMsg.email">{{ state.errMsg.email }}</span>
            </div>
            <div class="form-group" v-bind:class="{ 'has-error': state.error && state.errMsg.password }">
                <label for="password">Password</label>
                <input type="password" id="password" class="form-control" v-model="state.password" required>
                <span class="help-block" v-if="state.error && state.errMsg.password">{{ state.errMsg.password }}</span>
            </div>
            <button class="btn btn-default" @click="register()">Submit</button>
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
            name: null,
            email: null,
            password: null,
            success: false,
            error: false,
            errMsg: []
        });

        const register = async() => {
            try {
                const response = await axios.post('register/reg', {
                    name: state.name,
                    email: state.email,
                    password: state.password
                })
//                const response = await axios.get('register')
                //    jwtToken.setItem(response.data.token);
                console.log(response.data);
               // const response2 = await axios.get('register')
               // console.log(response2.data);
            } catch (error) {
                    state.errMsg = error.data
                    console.log(error.data)
            }
        };

        return {
            state,
            register
        };
    }
}
</script>
