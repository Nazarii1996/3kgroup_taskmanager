<?php

namespace App\Http\Controllers\Api;

use App\Helpers\TaskHistoryHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRequestTask;
use App\Http\Requests\UpdateRequestTask;
use App\Models\Tasks;
use App\Models\TaskHistory;
use Illuminate\Http\Request;

class TaskManagerApiController extends MainApiController
{

    public $user;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = \Auth::user();
            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks=Tasks::with('user')->where('user_id',$this->user->id)->orderBy('id','desc');

        return response()->json($this->response($tasks->paginate(20)));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequestTask $request)
    {
        try {
            $fill = $request->all();
            if(!$request->user_id) {
                $fill['user_id'] = $this->user->id;
            }
            $task = Tasks::create($fill);
            $this->message='Задание успешно создано';
        }catch (\Exception $e){
            $this->status = 'error';
            $this->errors['all'][] = $e->getMessage();
        }

        return response()->json($this->response());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{
            $task=Tasks::with('user')->where('id',$id)->where('user_id',$this->user->id)->firstOrFail();

        }catch(\Exception $e){
            $this->status = 'error';
            $this->errors['all'][] = $e->getMessage();
        }

        return response()->json($this->response($task));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequestTask $request, Tasks $task)
    {
        try {
            if ($task->user_id != $this->user->id) {
                abort(404);
            }
            $fill = $request->all();
            if (!$request->user_id) {
                $fill['user_id'] = $this->user->id;
            }

            TaskHistoryHelper::prepareChanges($task,$fill);
            $task = $task->fill($fill)->save();
            if($task){
                $this->message='Задание успешно отредактировано';
            }
        }catch (\Exception $e){
            $this->status = 'error';
            $this->errors['all'][] = $e->getMessage();
        }
        return response()->json($this->response());

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        TaskHistory::where('task_id',$id)->delete();
        Tasks::where('id',$id)->delete();
        return response()->json($this->response());
    }

}
