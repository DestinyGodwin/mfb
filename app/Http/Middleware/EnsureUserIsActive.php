<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
      public function handle($request, Closure $next)
    {
        $user = auth()->user();
        if (! $user->approved) {
            auth()->logout();
            return redirect()->route('login')
                ->withErrors(['email' => 'Account pending admin approval']);
        }

        if ($user->status !== 'active') {
            auth()->logout();
            return redirect()->route('login')
                ->withErrors(['email' => 'Account suspended or blocked']);
        }

        return $next($request);
    }
}
