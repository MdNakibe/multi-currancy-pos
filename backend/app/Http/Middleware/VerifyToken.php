<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;

class VerifyToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            // $secretkey = config('app.tokenKey');
            $secretkey = '<?[js@nill!CMT1!]?>';
            
            $jwt = $request->header('Authorization');
            
            if (!$jwt) {
                return response()->json(['message' => 'Authorization required'], 403);
            }

            JWT::$leeway = 60; // $leeway in seconds

            // $decoded = JWT::decode($jwt, $key, array('HS256'));
            $decoded = JWT::decode($jwt, new Key($secretkey, 'HS256'));

            app()->singleton('userId', function () use ($decoded) {
                return $decoded->userId;
            });

            app()->singleton('userType', function () use ($decoded) {
                return $decoded->userType;
            });

            app()->singleton('branchId', function () use ($decoded) {
                return $decoded->branchId;
            });

            return $next($request);
        } catch (Exception $e) {
            return response()->json(false);
        }
    }
}
