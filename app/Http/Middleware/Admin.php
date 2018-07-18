<?php

namespace App\Http\Middleware;

use Closure;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role = null)
    {
        if($role){
          if($request->user()->hasRole($role)){
              abort(403, "you can't");
          }
      }
         return $next($request);

    }
}
