<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FinancialYear;
use Illuminate\Support\Facades\Session;

class FinancialYearController extends Controller
{
    public function store(Request $request)
    {
        $inputYear = trim($request->input('year', ''));

        // Handle numeric start year input like 2026 -> 2026-2027
        if (preg_match('/^\d{4}$/', $inputYear)) {
            $startYear = (int)$inputYear;
            $endYear = $startYear + 1;
            $formattedYear = "{$startYear}-{$endYear}";
        } elseif (preg_match('/^\d{4}-\d{2}$/', $inputYear)) {
            // Convert 2026-27 -> 2026-2027
            $parts = explode('-', $inputYear);
            $startYear = (int)$parts[0];
            $endYear = 2000 + (int)$parts[1];
            $formattedYear = "{$startYear}-{$endYear}";
        } else {
            $formattedYear = $inputYear;
        }

        $request->merge(['year' => $formattedYear]);

        $request->validate([
            'year' => 'required|string|regex:/^\d{4}-\d{4}$/|unique:financial_years,year',
        ], [
            'year.required' => 'Financial year is required.',
            'year.regex' => 'Financial year format must be YYYY-YYYY (e.g. 2026-2027).',
            'year.unique' => 'This financial year already exists.',
        ]);

        $financialYear = FinancialYear::create([
            'year' => $formattedYear,
        ]);

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Financial year added successfully.',
                'financial_year' => $financialYear
            ]);
        }

        return redirect()->back()->with('success', 'Financial year added successfully.');
    }

    public function switch(Request $request)
    {
        $request->validate([
            'financial_year_id' => 'required|exists:financial_years,id',
        ]);

        Session::put('financial_year_id', $request->financial_year_id);

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Financial year switched successfully.',
                'financial_year_id' => $request->financial_year_id
            ]);
        }

        return redirect()->back()->with('success', 'Financial year switched successfully.');
    }
}
