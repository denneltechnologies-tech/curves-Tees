<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureFullAdmin
{
    /**
     * Handle an incoming request.
     * Restricts sensitive administration actions (user management, branding, leads, deletions)
     * to full administrators while limiting storekeepers to inventory and orders.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if (!$user || !$user->hasFullAdminAccess()) {
            if ($request->wantsJson()) {
                return response()->json([
                    'message' => 'Access Restricted: Administrator privileges required.',
                ], 403);
            }

            return redirect()->route('admin.dashboard')->with('error', 'Access Restricted: Storekeeper role is limited to inventory, orders, and products.');
        }

        return $next($request);
    }
}
