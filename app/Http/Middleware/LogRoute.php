<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;

class LogRoute
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
        $res = $next($req);

        if (app()->environment('local')){
            $log = [
                'uri' => $req->getUri(),
                'method' => $req->getMethod(),
                'request' => $req->all(),
                'response' => $res->getContent()
            ];
            Log::info(json_encode($log));
        }
        return $res;
    }
}
