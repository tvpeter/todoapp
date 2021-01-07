<?php

namespace App\Http\Controllers;

use App\Models\Tasks;
use App\Traits\FormatResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TasksController extends Controller
{
    use FormatResponse;

    // add a task
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
}
