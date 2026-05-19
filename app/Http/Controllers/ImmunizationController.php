<?php

namespace App\Http\Controllers;

use App\Models\Child;
use App\Models\Immunization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ImmunizationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        Gate::authorize('bidan');
        $search = request('search');
        $immunizations = Immunization::with('child')
            ->when($search, function ($q) use ($search) {
                $q->whereHas('child', function ($q) use ($search) {
                    $q->where('name', 'like', "%$search%");
                })->orWhere('vaccine_name', 'like', "%$search%");
            })
            ->get();
        return view('immunizations.index', compact('immunizations', 'search'));
    }

    public function create()
    {
        Gate::authorize('bidan');
        $children = Child::all();
        return view('immunizations.form', compact('children'));
    }

    public function store(Request $request)
    {
        Gate::authorize('bidan');
        
        $request->validate([
            'child_id' => 'required|exists:children,id',
            'vaccine_name' => 'required',
            'age_target' => 'required|integer',
            'date_given' => 'nullable|date',
        ]);

        Immunization::create($request->only(['child_id', 'vaccine_name', 'age_target', 'date_given']));

        return redirect()->route('immunizations.index')
            ->with('success', 'Data imunisasi berhasil ditambahkan');
    }

    public function edit($id)
    {
        Gate::authorize('bidan');
        $immunization = Immunization::findOrFail($id);
        $children = Child::all();
        return view('immunizations.form', compact('immunization', 'children'));
    }

    public function update(Request $request, $id)
    {
        Gate::authorize('bidan');
        
        $request->validate([
            'child_id' => 'required|exists:children,id',
            'vaccine_name' => 'required',
            'age_target' => 'required|integer',
            'date_given' => 'nullable|date',
        ]);

        $immunization = Immunization::findOrFail($id);
        $immunization->update($request->only(['child_id', 'vaccine_name', 'age_target', 'date_given']));

        return redirect()->route('immunizations.index')
            ->with('success', 'Data imunisasi berhasil diupdate');
    }

    public function destroy($id)
    {
        Gate::authorize('bidan');
        $immunization = Immunization::findOrFail($id);
        $immunization->delete();

        return redirect()->route('immunizations.index')
            ->with('success', 'Data imunisasi berhasil dihapus');
    }
}