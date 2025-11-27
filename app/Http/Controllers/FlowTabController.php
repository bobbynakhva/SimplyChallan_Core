<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\User;
use App\Models\FinancialYear;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth; 

class FlowTabController extends Controller
{
    public function show()
    {
        if (!session('company_id') || !session('financial_year_id')) {
            return redirect()->route('company.selection')->with('error', 'Please select company and financial year.');
        }
        $company = User::where('id', Session::get('company_id'))->first();
		$financial_year = FinancialYear::where('id', Session::get('financial_year_id'))->first();
        return view('front.flow-tab', compact('company','financial_year'));
    }

    public function selectFlow(Request $request)
    {
        $request->validate([
            'flow_type' => 'required|in:inward,outward'
        ]);

        session(['flow_type' => $request->flow_type]);

        if ($request->flow_type === 'inward') {
            return redirect()->route('inward.dashboard');
        }

        return redirect()->route('dashboard'); // outward
    }
}
