<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureKioskUnlocked
{
    public function handle(Request $request, Closure $next): Response
    {
        if (
            $request->session()->get('kiosk_locked') === true &&
            !$request->is('library/attendance/kiosk*')
        ) {
            return redirect('/library/attendance/kiosk');
        }

        return $next($request);
    }
}
