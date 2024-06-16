<?php

namespace App\Http\Middleware;

use App\Helpers\JsonResult;
use Closure;
use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\JWTException;

class VerifyJwtToken extends BaseMiddleware
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
            $user = JWTAuth::parseToken()->authenticate();
        } catch (TokenInvalidException  $e) {
            return JsonResult::errors(['token_expired' => true, "status_code" => 1], $e->getMessage());
        } catch (TokenExpiredException  $e) {
            return JsonResult::errors(['token_invalid' => true, "status_code" => 2], $e->getMessage());
        } catch (JWTException  $e) {
            // dd($e);
            return JsonResult::errors(['token_absent' => true], $e->getMessage());
        }


        return $next($request);
    }
}
