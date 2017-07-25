<?php

namespace Oglasi\Http\Middleware;

use Closure;
use Session;

class CheckUserLoggedIn
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
        if(!session()->has('username')){
          return redirect()->route('/');
        }

        return $next($request);
    }
}
