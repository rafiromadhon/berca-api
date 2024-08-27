<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LoggerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $contents = json_decode($response->getContent(), true, 512);
        
        $headers  = $request->header();

    
        $dt = new Carbon();
        $data = [
            'path'         => $request->getPathInfo(),
            'method'       => $request->getMethod(),
            'ip'           => $request->ip(),
            'http_version' => $_SERVER['SERVER_PROTOCOL'],
            'timestamp'    => $dt->toDateTimeString(),
            'headers'      => [
                'user-agent' => $headers['user-agent'],
            ], 
        ];

        if ($request->user()) {
            $data['user_id'] = $request->user()->id;
        }

        if (count($request->all()) > 0) {
            $hiddenKeys = ['password'];

            $data['request'] = $request->except($hiddenKeys);
        }

        if (!empty($contents['message'])) {
            $data['response']['message'] = $contents['message'];
        }

        if (!empty($contents['errors'])) {
            $data['response']['errors'] = $contents['errors'];
        }

        if (!empty($contents['result'])) {
            $data['response']['result'] = $contents['result'];
        }

        $data['response']['all'] = $contents;

        $message     = str_replace('/', '_', trim($request->getPathInfo(), '/'));

        Log::info($message, $data);

        return $response;
    }
}
