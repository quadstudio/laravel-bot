<?php

namespace QuadStudio\Bot\Http\Middleware;

use Closure;

class VerifyBot
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Load configuration
        $config = config('bot', ['user' => 'bot', 'password' => 'bot', 'ip' => []]);
        $lang = trans('bot::messages', ['error' => 'test']);

        if(in_array($request->ip(), $config['ip'])){
            return $next($request);
        } elseif(!($request->getUser() == $config['user'] && $request->getPassword() == $config['password'])){
            return response($lang['error'], 401, ['WWW-Authenticate' => 'Basic']);
        }

        return $next($request);
    }
}
