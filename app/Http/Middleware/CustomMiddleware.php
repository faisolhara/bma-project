<?php

namespace App\Http\Middleware;

use Closure;

class CustomMiddleware 
{
    /**
     * Run the request filter.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure                  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(empty(\Session::get('user'))){
            return redirect('/');
        }

        return $next($request);
    }
}
