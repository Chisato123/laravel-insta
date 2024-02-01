<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;  //add
use App\Models\User;  //add

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // if user is logged in & if user is Admin フィルター
        if (Auth::check() && Auth::user()->role_id == User::ADMIN_ROLE_ID) //ADMIN_ROLE_ID is from User
        {
            return $next($request); //allow to see the page = general response
        } else {
            return redirect()->route('index');
        }
    }
}
