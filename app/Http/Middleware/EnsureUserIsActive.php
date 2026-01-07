<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsActive
{
    public function handle($request, Closure $next)
    {
        $user = $request->user();

        if (! $user) {
            return redirect()->route('login');
        }

        if (! $user->approved) {
            Auth::logout();
            return redirect()
                ->route('login')
                ->withErrors(['email' => 'Account pending admin approval']);
        }

        if ($user->status !== 'active') {
            Auth::logout();
            return redirect()
                ->route('login')
                ->withErrors(['email' => 'Account suspended']);
        }

        return $next($request);
    }
}

