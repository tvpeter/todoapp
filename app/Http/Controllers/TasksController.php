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
}
