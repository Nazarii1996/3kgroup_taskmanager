<template>
<div>
    <simple-modal v-model="isShow">
        <template slot="body">
        <div class="form-group">
                <b>
                    Название задания
                </b>
                <input  type="text" :class="{'form-control':true,'alert-input':errors.title}" v-model="form.title" >
                <span class="alert-message" v-if="errors.title">{{errors.title.join('\r\n')}}</span>
            </div>
            <div class="form-group">
                <b>
                    Описание задания
                </b>
                <textarea :class="{'form-control':true,'alert-input':errors.description}" v-model="form.description" cols="30" rows="10"></textarea>
                <span class="alert-message" v-if="errors.description">{{errors.description.join('\r\n')}}</span>
            </div>
            <div class="form-group">
                <b>
                    Дата выполнения - дедлайн
                </b>
                <input type="date" class="form-control" v-model="form.execution_time">
            </div>
            <div class="form-group">
                <b>
                    Исполнитель( если путо то задание приваиваеться вам)
                </b>
                <Select2     v-model="form.user_id"
                             :options="users"
                             :settings="{ multiple: false, placeholder :'Виберите исполнителя', ajax:{
                                url: '/api/users',
                                dataType: 'json',
                                data: function (params) {
                                    return {
                                        search: params.term
                                    }
                                },
                                processResults: function (data) {
                                    return {
                                        results: data.data,
                                    }
                                }
                            }}" />

            </div>
            <div class="form-group">
                <b>
                    Статус
                </b>
                <select  :class="{'form-control':true,'alert-input':errors.status}" v-model="form.status">
                    <option v-for="(name,status) in statuses " :value="status">{{name}}</option>
                </select>
                <span class="alert-message" v-if="errors.status">{{errors.status.join('\r\n')}}</span>
            </div>

            <button type="button" @click="isShow=false;" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
           {{type}}
            <button type="button" @click="type=='create'?addTask():updateTask(task_id)" class="btn btn-primary">{{type=='create'?'Створити завдання':'Зберегти'}}</button>

        </template>

    </simple-modal>

</div>
</template>

<script>
    // main.js
    import Vue from 'vue';
    import VueSweetalert2 from 'vue-sweetalert2';

    import 'sweetalert2/dist/sweetalert2.min.css';
    import SimpleModal from 'simple-modal-vue'

    Vue.use(VueSweetalert2);
    import {bus} from "../../app";

    import Select2 from 'v-select2-component';

    Vue.component('Select2', Select2);

    export default {
        name:'task-form',
        props:['statuses'],
        components: { SimpleModal },
        data() {
            return {
                isShow: false,
                task_id:false,
                type:'create',
                users:[],
                form:{
                    title:null,
                    description:null,
                    execution_time:null,
                    user_id:null,
                    status:null
                },
                errors:{},
            }
        },
        mounted() {
            var it=this;
            bus.$on('showAddTaskModal', function(){
                it.isShow=true;
                it.type='create';
                it.task_id=false;
            });
            bus.$on('editTask', function(id){
                it.editTask(id);
                it.type='edit';
            });
        },
        methods:{
            editTask(id){
                this.isShow=true;
                this.task_id=id;
                axios.get('/api/task/'+id).then((resp)=>{
                    this.form=resp.data.data;
                    this.users.push({id:this.form.user.id,text:this.form.user.name});
                    console.log(this.users);
                });

            },
            updateTask:function(task_id){
                this.errors={};
                axios.put('/api/task/'+task_id,this.form)
                    .then((response)=>{
                        if(response.data.message){
                            bus.$emit('getList', true);
                            this.isShow=false;
                            this.form={};
                            Vue.swal(response.data.message);
                        }
                    })
                    .catch((err) => {
                        if(err.response.data.errors){
                            this.errors=err.response.data.errors;
                        }
                    });
            },
            addTask: function(){
                this.errors={};
                axios.post('/api/task',this.form)
                    .then((response)=>{
                        if(response.data.message){
                            bus.$emit('getList', true);
                            this.isShow=false;
                            this.form={};
                            Vue.swal(response.data.message);
                        }
                    })
                    .catch((err) => {
                            if(err.response.data.errors){
                                this.errors=err.response.data.errors;
                            }
                });

            }
        }
    }
</script>
<style>
    span.select2{
        width:100%!important;
    }
</style>
