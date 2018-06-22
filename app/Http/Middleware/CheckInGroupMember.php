<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Carbon;

class CheckInGroupMember
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
        if (auth()->check()) {
            auth()->user()->update([
                'last_checked_in_at' => Carbon::now()
            ]);
        }

        return $next($request);
    }
}
