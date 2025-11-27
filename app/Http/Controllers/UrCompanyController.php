<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class UrCompanyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // Protects all methods
    }

    public function index()
    {
        $companies = User::where('parent_id', Auth::id())->get();
        return view('urcompanies.index', compact('companies'));
    }

    public function create()
    {
        return view('urcompanies.create');
    }

    /**
     * Store a newly created company in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'phone' => 'required|unique:users',
            'gstin'   => 'nullable|regex:/^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}[Z]{1}[0-9A-Z]{1}$/',
            'address' => 'nullable|string|max:20'
        ]);

        $user = User::create([
            'role' => "company",
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'gstin' => $request->gstin,
            'address' => $request->address,
            'password' => Hash::make("Company@123"),
            'parent_id' => Auth::id(), // Assign logged-in user's ID
            'is_used' => 1,
            'email_verified_at' => now(),
        ]);

        return redirect()->route('urcompanies.index')->with('success', 'Company created successfully.');
    }

    /**
     * Display the specified company.
     */
    public function show(UrCompany $urCompany)
    {
        return view('urcompanies.show', compact('urCompany'));
    }

    /**
     * Show the form for editing the specified company.
     */
    public function edit(UrCompany $urCompany)
    {
        return view('urcompanies.edit', compact('urCompany'));
    }

    /**
     * Update the specified company in storage.
     */
    public function update(Request $request, UrCompany $urCompany)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $urCompany->update($request->all());

        return redirect()->route('urcompanies.index')->with('success', 'Company updated successfully.');
    }

    public function destroy($id)
    {
        $urCompany = User::findOrFail($id); // Ensure the record exists
        $urCompany->delete();

        return redirect()->route('urcompanies.index')->with('success', 'Company deleted successfully.');
    }
}
