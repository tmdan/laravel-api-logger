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
        return $next($request);
    }


    /**
     * Handle tasks after the response has been sent to the browser.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Http\Response $response
     * @return void
     */
    public function terminate($request, $response)
    {
        if ($request->route()->getName() != "api.logger" && $this->enabled && $request->wantsJson()) {

            ApiLogger::create([
                'request_full_url' => $request->fullUrl()?? null,
                'request_method' => $request->method()?? null,
                'request_body' => $request->all()?? null,
                'request_ip' => $request->ip()?? null,
                'request_header' => $request->header()?? null,
                'request_agent' => $request->header('User-Agent'),
                'response_content' => $response->getData(true) ?? null,
                'response_status_code' => $response->getStatusCode()?? null,
                'user_id' => $request->user()->id ?? null,
                'user_timezone' => $request->user()->timezone ?? null,
            ]);

        }
    }

}
