<?php

namespace Tmdan\ApiLogger\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tmdan\ApiLogger\Models\ApiLogger;

class ApiLoggerMiddleware
{
    private $enabled;

    public function __construct()
    {
        $this->enabled = config('api-logger.enabled', false);
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if ($request->route()->getName() != "api.logger" && $this->enabled) {

            ApiLogger::create([
                'request_full_url' => $request->fullUrl(),
                'request_method' => $request->method(),
                'request_body' => $request->all(),
                'request_ip' => $request->ip(),
                'request_header' => $request->header(),
                'request_agent' => $request->header('User-Agent'),
                'response_content' => $response->getData(true),
                'response_status_code' => $response->getStatusCode(),
                'user_id' => $request->user()->id ?? null,
                'user_timezone' => $request->user()->timezone ?? null,
            ]);

        }

        return $response;
    }


}
