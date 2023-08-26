<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserTransaction;
use Validator;
use Auth;
use Exception;
use Log;
use Session;
use Paginate;

class UserTransactionController extends Controller
{
    /**
     * list of financial transaction API
     * Created by Manisha Meshiya on 26th Aug 2023.
     * @method GET
     * @return JSON
    */
    public function index()
    {
        try
        {
            $userTransaction = UserTransaction::where('user_id',Auth::guard('api')->user()->id)->paginate(10);
            return $this->success('Get Transaction List successfully',$userTransaction);
        }
        catch(Exception $e)
        {
            log::Debug($e);
            return $this->error('Something went wrong!');
        }
    }
    /**
     * store financial transaction API
     * Created by Manisha Meshiya on 26th Aug 2023.
     * @method POST
     * @return JSON
    */
    public function store(Request $request)
    {
        try
        {

            $validator = Validator::make($request->all(), [
                'user_code' => 'required|exists:users,code,id,'.Auth::guard('api')->user()->id,
                'amount' => 'required|numeric|between:100,10000',
            ]);
            if ($validator->fails()) {
                return $this->error($validator->errors()->first(),422);
            }
            $userTransaction = new UserTransaction;
            $userTransaction->user_id = Auth::guard('api')->user()->id;
            $userTransaction->user_code = $request->user_code;
            $userTransaction->amount = $request->amount;
            $userTransaction->note = $request->note ?? '';
            $userTransaction->save();
            return $this->success('Create Transaction Successfully',$userTransaction);
        }
        catch(Exception $e)
        {
            log::Debug($e);
            return $this->error('Something went wrong!');
        }
    }

    /**
     * Update financial transaction API
     * Created by Manisha Meshiya on 26th Aug 2023.
     * @method PUT
     * @return JSON
    */

    public function update(Request $request,$id)
    {

        try
        {
            $validator = Validator::make($request->all(), [
                'user_id' => 'required|exists:users,id',
            ]);
            if ($validator->fails()) {
                return $this->error($validator->errors()->first(),422);
            }
            $checkUser = UserTransaction::where('id',$id)->where('user_id',Auth::guard('api')->user()->id)->first();
            if(empty($checkUser))
            {
                Session::flush();
                $user = Auth::guard('api')->user()->token();
                $user->revoke();
                Auth::logout();
                return $this->error('Something went wrong!',422);
            }
            $userTransaction = UserTransaction::find($id)->update($request->all());
            $userTransaction = UserTransaction::find($id);
            return $this->success('Transaction Update Successfully',$userTransaction);

        }
        catch(Exception $e)
        {
            log::Debug($e);
            return $this->error('Something went wrong!');
        }
    }

    /**
     * Delete financial transaction API
     * Created by Manisha Meshiya on 26th Aug 2023.
     * @method PUT
     * @return JSON
    */

    public function delete($id)
    {
        try
        {
            $userTransaction = UserTransaction::find($id)->delete();
            return $this->success('Transaction Delete Successfully',[]);

        }
        catch(Exception $e)
        {
            log::Debug($e);
            return $this->error('Something went wrong!');
        }
    }
}
