<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RestrictManagers
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->user()?->role_id == 2) {
            return redirect()->route('forms.incident.index');
        }

        return $next($request);
    }
}
