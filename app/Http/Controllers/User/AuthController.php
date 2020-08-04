<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use JWTAuth;
use Validator;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    //
    protected $user;
       
    public function __construct()
    {
        $this->user = new User;
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),
        [
            'firstname'=>'required|string',
            'lastname'=>'required|string',
            'email'=>'required|email',
            'password'=>'required|string|min:6',
        ]);
        
        if($validator->fails())
        {
            return response()->json([
                'success'=> false,
                'message'=> $validator->messages()->toArray(),
            ], 400);
        }

        $check_email = $this->user->where('email',$request->email)->count();
        if($check_email > 0)
        {
            return response()->json([
                'success'=> false,
                'message'=> 'Please email already exist'
            ], 400);
        }

       $registerComplete =  $this->user::create([
            'firstname'=> $request->firstname,
            'lastname'=> $request->lastname,
            'email'=> $request->email,
            'password'=> Hash::make($request->password),
        ]);

        if($registerComplete)
        {
           return $this->login($request);
        }
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->only('email','password'),
            [
                'email'=>'required|email',
                'password'=>'required|string|min:6', 
            ]
            );

        if($validator->fails())
        {
            return response()->json([
                'success'=> false,
                'message'=> $validator->messages()->toArray()
            ],400);
        }

        $jwt_token = null;

        $input = $request->only('email','password');

        if(!$jwt_token = auth('users')->attempt($input))
        {
            return response()->json([
                'success'=> false,
                'message'=> 'Invalid email or password',
            ]);
        }
        return response()->json([
            'success'=> true,
            'token'=> $jwt_token
        ]);
    }

    public function getUser(Request $request)
    {
       try {
        $user_token = $request->token;
        $user = auth('users')->authenticate($user_token);
        $user_id = $user->id;

        $findUser = $this->user::find($user_id);
     
        return response()->json([
            'success'=>true,
            'data'=>$findUser
        ], 200);
    
       } catch (\Throwable $th) {
            return response()->json([
            'success'=>false,
            'error'=>$th
        ], 500);
       }
    }
}
