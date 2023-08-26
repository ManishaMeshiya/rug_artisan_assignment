<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Validator;
use Auth;
use Exception;

class UserController extends Controller
{
    /**
     * Register API
     * Created by Manisha Meshiya on 26th Aug 2023.
     * @method POST
     * @return JSON
    */

    public function signup(Request $request)
    {
        try
        {
            $rule = [
                'name' => 'required|unique:users',
                'email' => 'required|email|unique:users',
                'code' => 'required|digits:4|unique:users',
                'mobile_number' => 'required|numeric|unique:users|digits_between:1,10|digits:10',
                'password' => 'required|string|min:6|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
            ];

            $validator = validator::make($request->all(),$rule,[
                'password.regex' => 'Password Must have at least 1 lowercase AND 1 uppercase AND 1 number AND 1 symbol',
            ]);

            if($validator->fails())
            {
                return $this->error($validator->errors()->first(),422);
            }
            
            $requestData = $request->all();
            $requestData['password'] = Hash::make($request->password);
            $requestData['role'] = 2;
            $user = User::create($requestData);
            return $this->success('Register Successfully',$user);
        }
        catch(Exception $e)
        {
            log::Debug($e);
            return $this->error('Something went wrong!');
        }
    }

    /**
     * Login API
     * Created by Manisha Meshiya on 26th Aug 2023.
     * @method POST
     * @return JSON
    */

    public function login(Request $request)
    {
        try
        {
            $input = $request->post();
            $rule =  [
                'username' => 'required',
                'password' => 'required',
            ];
    
            $validator = validator::make($request->all(),$rule);

            if($validator->fails())
            {
                return $this->error($validator->errors()->first(),422);
            }
            $fieldType = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'name';
            if(auth()->attempt(array($fieldType => $input['username'], 'password' => $input['password'])))
            {
                $user = Auth::user(); 
                $success['token'] =  $user->createToken('rugArtisan')->accessToken;
                $success['name'] =  $user->name;
                return $this->success('Login Successfully',$success);
            }
            else
            {
                return $this->error('Invalid Credentials. Please try again!');
            }
        }
        catch(Exception $e)
        {
            log::Debug($e);
            return $this->error('Something went wrong!');
        }
    }

    /**
     * Logout API
     * Created by Manisha Meshiya on 26th Aug 2023.
     * @method GET
    */
    public function logout() {
        Session::flush();
        $user = Auth::guard('api')->user()->token();
        $user->revoke();
        Auth::logout();
        return $this->success('Logout Successfully',[]);
    }
}
