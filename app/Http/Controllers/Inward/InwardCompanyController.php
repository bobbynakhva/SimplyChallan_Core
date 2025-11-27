<?php
namespace App\Http\Controllers\Inward;

use App\Http\Controllers\Controller;
use App\Models\Challan;
use App\Models\Company;
use App\Models\User;
use App\Models\FinancialYear;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth; 

class InwardCompanyController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth'); // Protects all methods
    }
    
    public function index()
    {
        //$companies = Company::all();
        $companies = Company::where('user_id', Session::get('company_id'))->get();
        return view('front.inward.companies.index', compact('companies'));
    }

    public function create()
    {
        return view('front.inward.companies.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'industry_name' => 'nullable|string|max:255',
            'industry_gstin'   => 'nullable|regex:/^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}[Z]{1}[0-9A-Z]{1}$/',
            'industry_number' => 'nullable|string|max:20',
            'industry_address' => 'nullable|string',
        ]);

        /*Company::create($request->all());*/
        Company::create([
            'user_id' => Session::get('company_id'),
            'industry_name' => $request->industry_name,
            'industry_gstin' => $request->industry_gstin,
            'industry_number' => $request->industry_number,
            'industry_address' => $request->industry_address,
        ]);
        return redirect()->route('companies.index')->with('success', 'Company created.');
    }

    public function edit($id)
    {
        $company = Company::findOrFail($id);
        return view('front.companies.edit', compact('company'));
    }

    public function update(Request $request, Company $company)
    {
        $request->validate([
            'industry_name' => 'nullable|string|max:255',
            'industry_gstin'   => 'nullable|regex:/^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}[Z]{1}[0-9A-Z]{1}$/',
            'industry_number' => 'nullable|string|max:20',
            'industry_address' => 'nullable|string',
        ]);

        $company->update($request->all());

        return redirect()->route('companies.index')->with('success', 'Company updated successfully!');
    }

    public function search(Request $request) {
        $query = $request->input('query');
        
        // Fetch matching companies
        $companies = User::where('name', 'LIKE', "%{$query}%")
                 ->where('parent_id', auth()->id()) // Fetch only companies under logged-in admin
                 ->select('id', 'name')
                 ->get();
        return response()->json($companies);
    }


    public function challanstore(Request $request) {
        $request->validate([
            'company' => 'required',
        ]);

        // Get the last challan number
        $lastChallan = Challan::orderBy('id', 'desc')->first();
        $newChallanNumber = $lastChallan ? $lastChallan->challan_no + 1 : 1;

        // Store new challan
        Challan::create([
            'challan_no' => $newChallanNumber,
            'company' => $request->company,
        ]);

        return redirect()->route('challan.index')->with('success', 'Challan created successfully.');
    }

    public function storeSelection(Request $request) {
        $request->validate([
            'company_id' => 'required|exists:users,id',
            'financial_year' => 'required|exists:financial_years,id'
        ]);

        Session::put('company_id', $request->company_id);
        Session::put('financial_year_id', $request->financial_year);

        return redirect()->route('flow-tab');
    }

    public function dashboard()
    {
        if (!Session::has('company_id') || !Session::has('financial_year')) {
            return redirect()->route('company.select')->with('error', 'Please select company and financial year first.');
        }
        return view('dashboard');
    }

    public function destroy($id)
    {
        $company = Company::withTrashed()->findOrFail($id);
        $company->delete();
        return redirect()->route('companies.index')->with('success', 'Company deleted successfully.');
    }    

    public function getCompanyDetails(Request $request)
    {
        $company = Company::find($request->id);
        if (!$company) {
            return response()->json(['error' => 'Company not found'], 404);
        }
        return response()->json([
            'industry_name'         => $company->industry_name,
            'industry_number'       => $company->industry_number,
            'industry_gstin'        => $company->industry_gstin,
            'industry_address'      => $company->industry_address,
        ]);
    }

}
