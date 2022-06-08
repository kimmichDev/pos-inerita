<?php

namespace App\Http\Middleware;

use App\Models\DailySaleReport;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DailySaleReportMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (DailySaleReport::where("date", now()->format("Y-m-d"))->exists()) {
            return Inertia::render("Welcome", ["error_page" => "Daily sale is closed and come back tomorrow"]);
        }
        return $next($request);
    }
}
