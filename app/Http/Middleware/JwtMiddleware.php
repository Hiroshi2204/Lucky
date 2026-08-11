<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenInvalidException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenExpiredException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;

class JwtMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            JWTAuth::parseToken()->authenticate();

        } catch (TokenInvalidException $e) {

            return response()->json([
                'status' => 'Token is Invalid'
            ], 401);

        } catch (TokenExpiredException $e) {

            return response()->json([
                'status' => 'Token is Expired'
            ], 401);

        } catch (JWTException $e) {

            return response()->json([
                'status' => 'Authorization Token not found'
            ], 401);

        } catch (Exception $e) {

            return response()->json([
                'status' => 'Authorization Token not found'
            ], 401);
        }

        return $next($request);
    }
}