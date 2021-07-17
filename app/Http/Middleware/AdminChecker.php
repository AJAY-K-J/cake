<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class AdminChecker
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
        if(Auth::user()->role->name=='ADMIN' || Auth::user()->role->name=='BILLING')
        {              
            return $next($request);
        }
        else
        {
            abort(403, 'Unauthorized action.');
        }
    }
}
