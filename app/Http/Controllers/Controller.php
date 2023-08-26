<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Return success message in json format
     */
    public function success($msg,$data)
    {
        return response()->json(["status"=> true,'message'=>$msg,'data'=>$data],200);
    }

    /**
     * Return error message in json format
     */
    public function error($msg,$code=500)
    {
        return response()->json(["status"=> false,'message'=>$msg],$code);
    }
}
