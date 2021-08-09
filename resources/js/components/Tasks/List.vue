<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Список заданий   <add-task :statuses="statuses" ></add-task></div>

                    <div class="card-body">
                        <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <td>Задание</td>
                                        <td>Описание</td>
                                        <td>Исполнитель</td>
                                        <td>Дедлайн</td>
                                        <td>Статус</td>
                                        <td>Действия</td>
                                    </tr>
                                </thead>
                            <tbody>
                                <tr v-for="item in list">
                                    <td>{{item.title}}</td>
                                    <td>{{item.description}}</td>
                                    <td>{{item.user.name}}</td>
                                    <td>{{item.execution_time}}</td>
                                    <td>{{item.status_text}}</td>
                                    <td>
                                        <button class="btn btn-primary" @click="editTask(item.id)">Редатировать</button>
                                        <button class="btn btn-danger" @click="deleteTask(item.id)">Удалить</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <pagination :data="data" @pagination-change-page="getList"></pagination>

                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
    import {bus} from "../../app";
    import TaskForm from "./Form";
    export default {
        name:'list',
        mounted() {
            this.getList();
            var it=this;
            bus.$on('getList', function(){
                it.getList();
            });
        },
        props:['statuses'],
        data(){
            return {
                list:{},
                data: {},
                task_id:0,
            }
        },
        methods:{
            getList:function(page = 1){
                axios.get('/api/task?page=' + page).then((resp)=>{
                    this.list=resp.data.data.data;
                    this.data=resp.data.data;
                });
            },
            editTask(id){
                bus.$emit('editTask', id);
            },
            deleteTask(id){
                axios.delete('api/task/'+id).then((resp)=>{
                    this.getList();
                })
            }
        }
    }
</script>
