<?php

namespace App\Http\Controllers;

use App\Models\PregnantWoman;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PregnantWomanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        Gate::authorize('bidan');
        $search = request('search');
        $pregnantWomen = PregnantWoman::with('user')
            ->when($search, function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('husband_name', 'like', "%$search%");
            })
            ->get();
        return view('pregnant_women.index', compact('pregnantWomen', 'search'));
    }

    public function show($id)
    {
        $pregnantWoman = PregnantWoman::with('children')->findOrFail($id);
        Gate::authorize('aksesIbuHamil', $pregnantWoman);
        return view('pregnant_women.show', compact('pregnantWoman'));
    }

    public function create()
    {
        Gate::authorize('bidan');
        $unlinkedUsers = User::where('role', 'orang_tua')
            ->whereDoesntHave('pregnantWoman')
            ->get();
        return view('pregnant_women.form', compact('unlinkedUsers'));
    }

    public function store(Request $request)
    {
        Gate::authorize('bidan');

        $request->validate([
            'existing_user_id' => 'required|exists:users,id',
            'husband_name'     => 'required',
            'due_date'         => 'nullable|date',
            'gestational_age'  => 'nullable|integer|min:0|max:42',
        ]);

        $user = User::findOrFail($request->existing_user_id);

        PregnantWoman::create([
            'name'            => $user->name,
            'husband_name'    => $request->husband_name,
            'due_date'        => $request->due_date,
            'gestational_age' => $request->gestational_age,
            'user_id'         => $user->id,
        ]);

        return redirect()->route('pregnant-women.index')
            ->with('success', 'Data ibu hamil berhasil ditambahkan');
    }

    public function edit($id)
    {
        Gate::authorize('bidan');
        $pregnantWoman = PregnantWoman::findOrFail($id);
        return view('pregnant_women.form', compact('pregnantWoman'));
    }

    public function update(Request $request, $id)
    {
        Gate::authorize('bidan');
        
        $request->validate([
            'name' => 'required',
            'husband_name' => 'required',
            'due_date' => 'nullable|date',
            'gestational_age' => 'nullable|integer|min:0|max:42',
        ]);

        $pregnantWoman = PregnantWoman::findOrFail($id);
        $pregnantWoman->update([
            'name' => $request->name,
            'husband_name' => $request->husband_name,
            'due_date' => $request->due_date,
            'gestational_age' => $request->gestational_age,
        ]);

        $pregnantWoman->user->update(['name' => $request->name]);

        return redirect()->route('pregnant-women.index')
            ->with('success', 'Data ibu hamil berhasil diupdate');
    }

    public function destroy($id)
    {
        Gate::authorize('bidan');
        $pregnantWoman = PregnantWoman::findOrFail($id);
        $user = $pregnantWoman->user;
        $pregnantWoman->delete();
        $user->delete();

        return redirect()->route('pregnant-women.index')
            ->with('success', 'Data ibu hamil berhasil dihapus');
    }
}   