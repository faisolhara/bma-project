<?php

namespace App\Http\Middleware;

use Closure;

class LanguageMiddleware  
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
        if(!empty(\Session::get('language'))){
            \App::setLocale(\Session::get('language'));
        }else{
            \App::setLocale('en');
        }

        return $next($request);
    }
}
