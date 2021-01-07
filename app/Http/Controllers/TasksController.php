<?php

namespace App\Http\Controllers;

use App\Models\Tasks;
use App\Traits\FormatResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class TasksController extends Controller
{
    use FormatResponse;

    /**
     * return all user tasks
     * 
     * @param Request
     * @param Task
     * @return Response
     */
    public function index(Request $request){

        $tasks = $request->user()->tasks;

        return $this->formatResponse(true, 200, 'Users tasks retrieved successfully', $tasks);
    }

    /**
     * creates a new task
     * 
     * @param Request
     * @return Response
     */
    public function store(Request $request){
       
       $validator = Validator::make($request->all(), [
            'name' => 'required|unique:tasks',
        ]);

        if($validator->fails()){
            return $this->formatResponse(false, 400, 'Bad request', $validator->errors());
        }

       $task = Tasks::create([
                'name' => $request->name,
                'user_id' => $request->user()->id,
                'description' => $request->description
        ]);

        return $this->formatResponse(true, 201, 'Task added successfully', $task);
    }

    /**
     * update task
     * 
     * @param Request
     * @param Task
     * @return Response
     */
    public function update(Request $request, Tasks $task){

        if($task->user_id !== $request->user()->id){
            return $this->formatResponse(false, 403, 'Unauthorized', ['message' => 'You do not have access to the resource']);
        }

        $validator = Validator::make($request->all(), [
            'status' => [
                'nullable',
                Rule::in(['archived', 'completed']),
            ],
        ]);

        if($validator->fails()){
            return $this->formatResponse(false, 400, 'Bad request', $validator->errors());
        }


        foreach($request->all() as $key => $value){
            if($request->filled($key)){
                $task->$key = $value;
            }
        }

        $task->save();

        return $this->formatResponse(true, 200, 'Task updated successfully', $task);
    }

    /**
     * delete task
     * 
     * @param Request
     * @param Task
     * @return Response
     */
    public function destroy(Request $request, Tasks $task){

        if(!$task){
            return $this->formatResponse(false, 404, 'Not found', ['message' => 'Requested resource not found']);
        }

        if($task->user_id !== $request->user()->id){
            return $this->formatResponse(false, 403, 'Unauthorized', ['message' => 'You do not have access to the resource']);
        }

        $task->delete();

        return $this->formatResponse(true, 200, 'Task deleted successfully', $task);
    }

}
