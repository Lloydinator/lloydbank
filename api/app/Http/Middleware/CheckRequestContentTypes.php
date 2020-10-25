<?php

namespace App\Http\Middleware;

use Closure;

class CheckRequestContentTypes
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $req
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($req, Closure $next)
    {
        if (!$req->isMethod('post')){
            return $next($req);
        }

        $accepted = $req->header('Accept');
        if ($accepted != 'application/json'){
            return response()->json([], 406);
        }

        return $next($req);
    }
}
