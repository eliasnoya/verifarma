<?php

namespace Src\Shared\Infrastructure\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Src\Shared\Infrastructure\Eloquent\Log;

class HttpLoggerMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $log = new Log;
        $log->path = $request->path();
        $log->method = $request->method();
        $log->request_body = json_encode($request->all());
        $log->request_headers = json_encode($request->headers->all());

        /** @var Response $response */
        $response = $next($request);

        $log->response_status = $response->status();
        $log->response_body = $response->getContent();
        $log->response_headers = json_encode($response->headers->all());
        $log->ip = $request->ip();
        $log->save();

        return $response;
    }
}
