<?php

namespace App\Http\Middleware;

use App\helpers;
use Closure;
use Illuminate\Http\Request;

class checkUserStatus
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->guard('sanctum')->check()) {
            return $next($request);
        }

        $response = [
            'status' => 400,
            'code_status' => 1,
            'errors' => __('messages.user_is_not_active'),
            'message' => __('messages.user_is_not_active'),
            'data' => []
        ];

        return response()->json($response, 400);
    }
}
