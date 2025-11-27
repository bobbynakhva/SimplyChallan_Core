<?php

namespace App\Http\Controllers\Inward;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Purpose;

class InwardPurposeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // Protects all methods
    }

    public function index()
    {
        $purposes = Purpose::all();
        return view('front.inward.purposes.index', compact('purposes'));
    }

    public function create()
    {
        return view('front.inward.purposes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:purposes,name|max:255'
        ]);

        Purpose::create($request->all());

        return redirect()->route('inward.purposes.index')->with('success', 'Purpose created successfully.');
    }

    public function show(Purpose $purpose)
    {
        return view('front.inward.purposes.show', compact('purpose'));
    }

    public function edit($id)
    {
         $purpose = Purpose::findOrFail($id);
        return view('front.inward.purposes.edit', compact('purpose'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $purpose = Purpose::findOrFail($id);
        $purpose->name = $request->name;
        $purpose->save();

        return redirect()->route('inward.purposes.index')
                         ->with('success', 'Purpose updated successfully.');
    }


    /*public function destroy(Purpose $purpose)
    {
        $purpose->delete();

        return redirect()->route('inward.purposes.index')->with('success', 'Purpose deleted successfully.');
    }*/

    public function destroy($id)
    {
        $purpose = Purpose::findOrFail($id);
        $purpose->delete(); // Soft delete
        return redirect()->back()->with('success', 'Challan deleted successfully.');
    }
}
