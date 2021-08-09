<template>
    <div>
        <button class="btn btn-primary" @click="showAddTaskModal()">Добавить задание</button>
        <task-form :statuses="statuses" type="create"></task-form>
    </div>
</template>

<script>
    import TaskForm from "./Form";
    import {bus} from "../../app";
    export default {
        name:'add-task',
        components: {TaskForm},
        props:['statuses'],
        methods:{
            showAddTaskModal:function(){
                bus.$emit('showAddTaskModal', true);
            }
        }
    }
</script>
