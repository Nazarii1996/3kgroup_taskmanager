<?php

namespace App\Helpers;

use App\Models\TaskHistory;
use App\Models\Tasks;

class TaskHistoryHelper{
    public static function prepareChanges(Tasks $task,Array $updatedTask){
        $fields=[
            'title','description','status','user_id','execution_time'
        ];

        foreach($fields as $field){
        if($task->{$field}!=$updatedTask[$field]){
            $taskHistory=new TaskHistory;
            $taskHistory->task_id=$task->id;
            $taskHistory->type=$field;
            $taskHistory->from=$task->{$field};
            $taskHistory->to=$updatedTask[$field];
            $taskHistory->save();
        }
        }

    }
}
