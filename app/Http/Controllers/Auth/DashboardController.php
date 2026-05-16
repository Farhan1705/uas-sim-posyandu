<?php

namespace App\Http\Controllers;

use App\Models\PregnantWoman;
use App\Models\Child;
use App\Models\Measurement;
use App\Models\Immunization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        if ($user->role == 'bidan') {
            // Data untuk dashboard bidan
            $totalPregnant = PregnantWoman::count();
            $totalChildren = Child::count();
            $totalMeasurements = Measurement::count();
            $totalImmunizations = Immunization::count();
            $pendingImmunizations = Immunization::where('status', 'pending')->count();
            
            $normalCount = Child::where('nutrition_status', 'normal')->count();
            $waspadaCount = Child::where('nutrition_status', 'waspada')->count();
            $kurangCount = Child::where('nutrition_status', 'kurang')->count();
            $obesitasCount = Child::where('nutrition_status', 'obesitas')->count();
            
            $recentChildren = Child::with('mother')->latest()->take(5)->get();
            $overdueChildren = Child::with('mother')
                ->where('birth_date', '<=', now()->subYears(5))
                ->get();
            
            return view('dashboard.bidan', compact(
                'totalPregnant', 'totalChildren', 'totalMeasurements', 
                'totalImmunizations', 'pendingImmunizations',
                'normalCount', 'waspadaCount', 'kurangCount', 'obesitasCount',
                'recentChildren', 'overdueChildren'
            ));
        } 
        else {
            // Data untuk dashboard orang tua
            $pregnantWoman = PregnantWoman::where('user_id', $user->id)->first();
            
            if ($pregnantWoman) {
                $children = Child::where('mother_id', $pregnantWoman->id)->get();
                return view('dashboard.orangtua', compact('pregnantWoman', 'children'));
            }
            
            return view('dashboard.orangtua', ['pregnantWoman' => null, 'children' => collect()]);
        }
    }
}