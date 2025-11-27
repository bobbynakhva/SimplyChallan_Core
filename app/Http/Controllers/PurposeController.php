<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Purpose;

class PurposeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // Protects all methods
    }

    public function index()
    {
        $purposes = Purpose::all();
        return view('front.purposes.index', compact('purposes'));
    }

    public function create()
    {
        return view('front.purposes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:purposes,name|max:255'
        ]);

        Purpose::create($request->all());

        return redirect()->route('purposes.index')->with('success', 'Purpose created successfully.');
    }

    public function show(Purpose $purpose)
    {
        return view('front.purposes.show', compact('purpose'));
    }

    public function edit(Purpose $purpose)
    {
        return view('front.purposes.edit', compact('purpose'));
    }

    public function update(Request $request, Purpose $purpose)
    {
        $request->validate([
            'name' => 'required|unique:purposes,name,' . $purpose->id . '|max:255'
        ]);

        $purpose->update($request->all());

        return redirect()->route('purposes.index')->with('success', 'Purpose updated successfully.');
    }

    public function destroy(Purpose $purpose)
    {
        $purpose->delete();

        return redirect()->route('purposes.index')->with('success', 'Purpose deleted successfully.');
    }
}
