<?php

namespace App\Http\Middleware;

use Closure;
use DateTime;
use App\User;

class Vote
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

        $now = new DateTime();
        if($now < config('election.start') || $now > config('election.end')) {
            return redirect()->route('home')->send();
        }

        // Check if the user has voted
        if($request->route()->getName() != 'vote_already') {
            $count = User::where('login', $request->session()->get('login'))->count();
            if($count > 0) {
                return redirect()->route('vote_already')->send();
            }
        }

        // Verification cotisant

        return $next($request);
    }
}
