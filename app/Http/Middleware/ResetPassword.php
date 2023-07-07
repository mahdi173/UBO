<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;
use Symfony\Component\HttpFoundation\Response;

class ResetPassword
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user_token = PersonalAccessToken::where('token', $request->token)->first();
       
        if (!$user_token) {
            return response()->json(['error' => 'Invalid token'], 419);
        }

        if ( Carbon::parse($user_token->expires_at)->isPast()) {
            return response()->json(['error' => 'Token expired'], 419);
        }
        
        if (!in_array('reset-password', $user_token->toArray()["abilities"])) {
            abort(403, 'Forbidden');
        }
        
        return $next($request);
    }
}
