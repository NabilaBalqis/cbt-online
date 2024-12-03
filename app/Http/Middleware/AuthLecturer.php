<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthLecturer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        //check if user is logged in
        $lecturer = auth()->guard('lecturer')->user();

        //if not, redirect to login page
        if (!$lecturer) {
            return redirect('/logindosen');
        }

        //if user is logged in, continue to next middleware
        return $next($request);
    }
}
