<template>
<div class="">
    <section class="todoapp">
        <!-- todo入力 section -->
        <div class="header">
            <h1>todos</h1>
            <input class="new-todo" autofocus autocomplete="off"
            placeholder="するべきことは？" v-model="state.newTodo" @keyup.enter="addTodo()">
            <h2>{{ state.newTodo }}</h2>
        </div>
        <!-- todoList section -->
        <section class="main" v-show="state.todos.length" v-cloak>
            <!-- チェックボックス -->
            <!-- <input id="toggle-all" class="toggle-all" type="checkbox">
            <label for="toggle-all"></label> -->
            <!-- todoList -->
            <ul class="todo-list">
                <li v-for="todo in state.todos" class="todo" :key="todo.id"
                    :class="{completed: todo.is_complete, editing: todo == state.editedTodo}">
                    <div class="view">
                        <!-- 完了フラグ切替 -->
                        <input class="toggle" type="checkbox" v-model="todo.is_complete"
                        @change="activeTodoNow(todo.id,todo.is_complete)">
                        <!-- todo編集 -->
                        <label @dblclick="editTodo(todo)">{{todo.name}}</label>
                        <!-- todo削除 -->
                        <button class="destroy" @click="deleteTodo(todo.id)"></button>
                    </div>
                    <input class="edit" type="text" v-model="state.name"
                    @blur="doneEdit(todo.id)"
                    @keyup.enter="doneEdit(todo.id)"
                    @keyup.esc="cancelEdit(todo.id)">
                </li>
            </ul>
        </section>
        <footer class="footer" v-if="state.hasTodo">
            <span class="todo-count">
                <strong>{{state.activeTodo}}</strong> left
            </span>
            <ul class="filters">
                <li><a href="javascript:void(0)" :class="{selected: state.visibility == 'all'}" @click="filterNow('all')">All</a></li>
                <li><a href="javascript:void(0)" :class="{selected: state.visibility == 'active' }" @click="filterNow('active')">Active</a></li>
                <li><a href="javascript:void(0)" :class="{selected: state.visibility == 'completed' }" @click="filterNow('completed')">Completed</a></li>
            </ul>
            <button class="clear-completed" v-if="state.hasCompleted" @click="deleteTodo('')">Clear completed</button>
        </footer>
    </section>
    <Child1 :message="state.msg" @change-message="changeMessage" />
    <p>{{ state.msg }}</p>
</div>
</template>

<script>
import { reactive, onMounted } from "vue";
import axios from 'axios';
import Child1 from '../components/Child1.vue';
import Header from '../components/Header.vue';

let token = document.head.querySelector('meta[name="csrf-token"]');
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
if (token) {
    axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
}

export default {

    components:{
        Child1
    },

    setup() {
        const state = reactive({
            newTodo: '',
            selected: false,
            activeTodo: '',
            todos: [],
            visibility: '',
            editedTodo: null,
            beforeEditCache: '',
            hasTodo: false,
            hasCompleted: false,
            name: '',
            msg: 'tomato'
        });

        //コーポネント間の受渡しテスト
        const changeMessage = (msg) => {
            state.msg = msg
        };

        //todoテーブルにINSERT
        // const addTodo = () => {
        //     axios.post('todo/add',{name: state.newTodo})
        //     .then((response)=>state.newTodo = '')
        //         //再取得
        //         axios.get('todo/get',{params: {type:state.visibility}})
        //         .then((response)=>{
        //             state.todos = response.data.todo
        //             if(state.todos.length>0){
        //                 state.hasTodo = true
        //             }
        //             state.activeTodo = response.data.active_now
        //         })
        // };

        const addTodo = async() => {
            try {
                const res1 = await axios.post('todo/add',{name: state.newTodo})
                console.log(res1.data)
                state.newTodo = ''
                    //再取得
                const response = await axios.get('todo/get',{params: {type:state.visibility}})
                console.log(response.data)
                state.todos = response.data.todo
                if(state.todos.length>0){
                    state.hasTodo = true
                }
                state.activeTodo = response.data.active_now
            } catch (err) {
                console.log(err)
            }
        };

        //指定のレコードをDELETE
        const deleteTodo = (e) => {
            axios.get('todo/delete', {
                params: {type: e !== '' ? 'single' : '', id: e}
            }).then((response)=>{
                axios.get('todo/get', {
                    params: {
                        type: state.visibility
                        }
                }).then((response)=>{
                    state.todos = response.data.todo
                    state.activeTodo = response.data.active_now
                    if(response.data.hasCompleted > 0){
                        state.hasCompleted = true
                    }else{
                        state.hasCompleted = false
                    }
                    if(response.data.total > 0){
                        state.hasTodo = true
                    }else{
                        state.hasTodo = false
                    }
                })
            })
        };

        //完了切替
        const activeTodoNow = (id, comp) => {
            axios.get('todo/action', {
                params:{
                    type: comp ? 'complete' : ' ',
                    id: id
                    }
            }).then((response)=>{
                axios.get('todo/get', {
                    params:{type: state.visibility}
                }).then((response)=>{
                    state.activeTodo = response.data.active_now
                    if(response.data.has_completed > 0) {
                        state.hasCompleted = true
                    }else{
                        state.hasCompleted = false
                    }
                })
            })
        };

        //状態でフィルター
        const filterNow = (e) => {
            state.visibility = e
            axios.get('todo/get',{
                params: {
                    type: state.visibility
                }
            }).then((response)=>{
                if (response.data.todo.length > 0) {
                    state.activeTodo = response.data.active_now
                }
                state.todos = response.data.todo
            })

        };

        //todoを編集
        const editTodo = (todo) => {
            state.name = todo.name
            state.editedTodo = todo
        };

        //編集を登録
        const doneEdit = (id) => {
            axios.get('todo/update',{
                params: {
                    id: id,
                    name: state.name
                }
            }).then((response)=>{
                if(!state.editedTodo) {
                    return
                }
                state.editedTodo = null
                axios.get('todo/get',{
                    params:{
                        type: state.visibility
                    }
                }).then((response)=>{
                    state.todos = response.data.todo
                    state.activeTodo = response.data.active_now
                })
            })
        };

        //編集キャンセル
        const cancelEdit = () => {
            state.editedTodo = null
        };

        // createdは書かずにsetup関数内に直書き
        axios.get('todo/get', {
            params: {
                type: 'all'
            }
        }).then((response)=>{
            state.todos = response.data.todo
            state.activeTodo = response.data.active_now
            if(response.data.has_completed > 0) {
                state.hasCompleted = true
            }
            if(state.todos.length > 0){
                state.hasTodo = true
            }
        });

        return {
            state,
            changeMessage,
            addTodo,
            deleteTodo,
            activeTodoNow,
            filterNow,
            editTodo,
            doneEdit,
            cancelEdit
        };
    }
}
</script>
