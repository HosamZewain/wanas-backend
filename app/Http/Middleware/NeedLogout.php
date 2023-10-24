<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class NeedLogout
{
    /**
     * @param Request $request
     * @param Closure $next
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(auth('web')->check()){
            $user = auth('web')->user();
            if($user?->need_logout){
                $user->update(['need_logout'=>false]);
                auth('web')->logout();
                return \response()->json(['status'=>false,'message'=>__('user re login required')],401);
            }
        }
        return $next($request);
    }

}
