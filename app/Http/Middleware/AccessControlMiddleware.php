<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Route;

use Closure;

class AccessControlMiddleware
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
        if ($request->user()->cannot($request->route()[1]['as']) /* && !$request->user()->is_admin */) {
            return response()->json(array("success" => false, "data" => array(), "erros" => array("message" => "Access Denied.")), 401);
        }
        return $next($request);
    }
}
