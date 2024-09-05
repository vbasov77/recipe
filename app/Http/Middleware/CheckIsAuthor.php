<?php

namespace App\Http\Middleware;

use App\Models\Recipe;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckIsAuthor
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    public function handle($request, Closure $next)
    {
        if(Auth::user() == (new \App\Models\Recipe)->isAuthor()){
            return $next($request);
        }

        return redirect('/');
    }
}
