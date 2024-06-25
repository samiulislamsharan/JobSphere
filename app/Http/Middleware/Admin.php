<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->user()->role == NULL) {
            return redirect()->route('home');
        }

        if (auth()->user()->role != 'admin') {
            session()->flash('error', 'You are not authorized to access this route.');

            return redirect()->route('profile.show');
        }

        return $next($request);
    }
}
