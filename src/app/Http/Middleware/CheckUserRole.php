<?php

namespace App\Http\Middleware;

use Closure;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, ...$role)
    {   
        if ($request->user() == null) { 
            return redirect("/");
        }
        
        if (! $request->user()->hasRole($role)) {
            return redirect("/");
        }

        return $next($request);
    }
}
