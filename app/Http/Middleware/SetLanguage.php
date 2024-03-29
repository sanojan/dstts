<?php

namespace App\Http\Middleware;

use Closure;
use App;
use Session;
use Config;
class SetLanguage
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
        App::setLocale($request->language);
        return $next($request);
    }
}
