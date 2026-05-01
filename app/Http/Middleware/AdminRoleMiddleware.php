<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminRoleMiddleware
{
    /**
     * Handle an incoming request.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role (superadmin|admin)
     * @return Response
     */
    public function handle(Request $request, Closure $next, string $role = 'admin'): Response
    {
        // Check if logged in
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Check if admin account is active
        if (!session('admin_active', true)) {
            return redirect()->route('admin.login')->with('error', 'Akun Anda nonaktif. Hubungi superadmin untuk mengaktifkan.')->withInput();
        }

        // Get the required role
        $requiredRole = $role;

        // Get current admin role from session
        $currentRole = session('admin_role', 'admin');

        // For superadmin role, only superadmin can access
        if ($requiredRole === 'superadmin' && $currentRole !== 'superadmin') {
            return redirect()->route('admin.dashboard')->with('error', 'Anda tidak memiliki akses ke halaman tersebut. Hanya superadmin yang boleh mengakses.');
        }

        // For admin role, both superadmin and admin can access
        // This is handled automatically, so no extra check needed

        return $next($request);
    }
}
