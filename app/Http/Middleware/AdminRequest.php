<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminRequest
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->user() != null && $request->user()->is_admin == true)
            return $next($request);

        return response(array('message' => 'Недостаточно прав для данного запроса.'), 403);
    }
}
