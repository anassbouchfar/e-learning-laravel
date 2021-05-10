<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class userRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Auth::user()->role_id==2){
            if ((Auth::user()->password_reseted==1)) 
                return redirect(route("changePasswordForm"));
             
            return $next($request);
        }
            
        return abort(403,'Unauthorized action.');
    }
}
