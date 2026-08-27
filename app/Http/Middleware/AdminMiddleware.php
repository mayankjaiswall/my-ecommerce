<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Allow the request through only for authenticated admin accounts.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! Auth::check()) {
            return redirect()->guest(route('admin.login'));
        }

        if (! Auth::user()->isAdmin()) {
            abort(403, 'You do not have permission to access the admin area.');
        }

        return $next($request);
    }
}
