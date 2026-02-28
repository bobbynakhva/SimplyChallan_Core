<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\FinancialYear;
use App\Models\User;
use Illuminate\Support\Facades\Session;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (!Session::has('company_id') || !Session::has('financial_year')) {
            // Fetch companies associated with logged in user
            $companies = User::where('parent_id', \Illuminate\Support\Facades\Auth::id())->get();
            $financial_years = FinancialYear::all();
            return view('front.index',compact('companies','financial_years'));
        }else{
            return redirect()->route('dashboard');
        }
    }

    
    public function privacypolicy()
    {
        return view('front.privacy-policy');
    }

    public function termscondition()
    {
        return view('front.terms-conditions');
    }
}
