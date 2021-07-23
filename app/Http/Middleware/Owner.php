<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Owner
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
        $merchandise = $request->route('merchandise');

        if($merchandise==null) {
            return response()->json(['message'=>'Item not found'], 404);
        }


        if($merchandise->user_id != auth()->user()->id) {
            return response()->json(['message'=>'You are not the owner'], 401);
        }
        
        return $next($request);
    }
}
