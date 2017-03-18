<?php

namespace App\Http\Middleware;

use Closure;

class Admin
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
        if(!$request->session()->has('login')) {
            return redirect()->route('home')->send();
        }
        // Check for rights
        if(!in_array($request->session()->get('login'),config('election.referer.login'))) {
            if($request->route()->getName() != 'admin_panel'
                || !in_array($request->session()->get('login'), config('election.viewer'))) {
                return redirect()->route('home')->send();
            }
        }
        return $next($request);
    }
}
