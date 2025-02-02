<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Log;

class LogActivity
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $action = $request->method() . ' ' . $request->path();

            Log::create([
                'user_id' => $user->id,
                'action' => $action,
            ]);
        }

        return $next($request);
    }
}