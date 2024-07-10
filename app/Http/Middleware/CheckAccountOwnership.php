<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;


class CheckAccountOwnership
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Get the ID from the route parameter
        $id = $request->route('id');


        // Check if the authenticated user's ID matches the ID in the route
        if (Auth::check() && Auth::id() == $id) {
            return $next($request);
        }

        // If the user is not authenticated or the IDs don't match, redirect to a different page or return an error
        return redirect()->route('account', ['id' => Auth::id()]);
    }
}
