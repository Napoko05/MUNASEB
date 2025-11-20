<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PermissionCheck
{
    public function handle(Request $request, Closure $next, $permission)
    {
        $user = Auth::user();

        if (!$user || !$user->can($permission)) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => "Vous n'avez pas la permission pour accéder à cette page."
                ], 403);
            } else {
                return view('errors.no-permission'); // Vue avec le modal
            }
        }

        return $next($request);
    }
}
