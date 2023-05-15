<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;
use Symfony\Component\HttpFoundation\Response;

class AccountActivated
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
            return response()->json(['error' => 'Invalid token'], 404);
        }
        
        if (!in_array('activate-account', $user_token->toArray()["abilities"])) {
            abort(403, 'Unauthorized');
        }
        
        return $next($request);
    }
}
