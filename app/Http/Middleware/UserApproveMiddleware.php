<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
class UserApproveMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if(Auth::user()->role == 0 && Auth::user()->approve == 1){
            return $next($request);
        }

        return redirect()->route('user_login.get')->with('approval_warn',"Please wait for admin approval. Once your account is approved, you can log in.");

    }
}
