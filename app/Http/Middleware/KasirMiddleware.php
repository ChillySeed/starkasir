<?php
// app/Http/Middleware/KasirMiddleware.php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KasirMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check() || !Auth::user()->isKasir()) {
            return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman kasir.');
        }

        return $next($request);
    }
}