<?php

namespace App\Http\Middleware;

use App\Exceptions\CustomUnAuthorizedException;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class CheckAuthToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

            if (!$request->bearerToken()) {
                return response()->json([
                    'message' => 'شما دسترسی ندارید!'
                ], 403);
            }
            $user = JWTAuth::parseToken()->authenticate();
            return $next($request);

    }
}
