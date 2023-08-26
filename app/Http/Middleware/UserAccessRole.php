<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;

class UserAccessRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next,$userRole)
    {
        if(Auth::guard('api')->user()->role == $userRole)
        {
            return $next($request);
        }
        return response()->json(['status'=>false,'msg'=>"You don't have to permission to access this route"],403);
    }
}
