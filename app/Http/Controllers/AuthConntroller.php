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
     * login a user 
     * returns token for the logged in user
     */
    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        if($validator->fails()){
            return $this->formatResponse(false, 400, 'Invalid login input', $validator->errors());
        }

        $user = User::where('email', $request->email)->first();

            if (!$user || !Hash::check($request->password, $user->password)) {
                return $this->formatResponse(false, 404, 'User not found with given credentials');
            }

            $token = $user->createToken('AuthToken')->plainTextToken;

            return $this->formatResponse(true, 200, 'Login successful', [ 'email' => $request->email, 'token' => $token]);
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
    protected function formatResponse($status, $statusCode, $message, $data=null){

        return response()->json([
            'status' => $status,
            'statusCode' => $statusCode,
            'message' => $message,
            'data' => $data
        ], $statusCode);
    }

}
