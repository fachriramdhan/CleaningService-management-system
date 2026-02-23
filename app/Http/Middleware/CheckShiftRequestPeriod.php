<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\ShiftRequest;

class CheckShiftRequestPeriod
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if current date is in request period (23-24)
        if (!ShiftRequest::isRequestPeriod()) {
            return redirect()->route('cs.shift.index')
                ->withErrors([
                    'period' => 'Request libur hanya dapat dilakukan pada tanggal 23-24 setiap bulan.'
                ]);
        }

        return $next($request);
    }
}
