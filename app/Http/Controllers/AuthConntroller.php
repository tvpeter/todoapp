<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthConntroller extends Controller
{
    /**
     * create a new user
     * 
     */
    public function store(Request $request){

        $validator = $this->validateCreateUser($request);

        if($validator->fails()){
            return $this->formatResponse(false, 400, 'Invalid user input', $validator->errors());
        }


        $user = User::firstOrCreate(
            ['email' => $request->email],
            [
                'name' => $request->name,
                'password' => Hash::make($request->password),
                'email_verified_at' => now(),
            ]
        );

        return $this->formatResponse(true, 201, 'User created successfullly', $user);
        
    }

    /**
     * validate create user inputs
     */
    protected function validateCreateUser($request){

        return Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);
    }

    /**
     * format responsse data
     */
    protected function formatResponse($status, $statusCode, $message, $data){

        return response()->json([
            'status' => $status,
            'statusCode' => $statusCode,
            'message' => $message,
            'data' => $data
        ], $statusCode);
    }

}
