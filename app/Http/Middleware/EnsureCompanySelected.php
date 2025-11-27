<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Session;

class EnsureCompanySelected
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
        public function handle(Request $request, Closure $next) {
            if (!Session::has('company_id') || !Session::has('financial_year_id')) {
                return redirect()->route('company.select')->with('error', 'Please select a company and financial year.');
            }
            return $next($request);
        }
        //return $next($request);
}
