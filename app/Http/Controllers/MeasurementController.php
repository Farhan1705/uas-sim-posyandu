<?php

namespace App\Http\Controllers;

use App\Models\Child;
use App\Models\Measurement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class MeasurementController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($childId)
    {
        $child = Child::findOrFail($childId);
        Gate::authorize('aksesAnak', $child);
        
        $measurements = $child->measurements()->orderBy('measurement_date', 'desc')->get();
        return view('measurements.index', compact('child', 'measurements'));
    }

    public function create($childId)
    {
        Gate::authorize('bidan');
        $child = Child::findOrFail($childId);
        return view('measurements.form', compact('child'));
    }

    public function store(Request $request, $childId)
    {
        Gate::authorize('bidan');
        
        $request->validate([
            'measurement_date' => 'required|date',
            'weight' => 'required|numeric',
            'height' => 'required|numeric',
            'head_circumference' => 'required|numeric',
        ]);

        $data = $request->only(['measurement_date', 'weight', 'height', 'head_circumference']);
        $data['child_id'] = $childId;
        $data['color_zone'] = $this->calculateColorZone($childId, $request->measurement_date, $request->weight);
        
        Measurement::create($data);
        
        $this->updateNutritionStatus($childId);

        return redirect()->route('measurements.index', $childId)
            ->with('success', 'Data pengukuran berhasil ditambahkan');
    }

    public function edit($childId, $id)
    {
        Gate::authorize('bidan');
        $child = Child::findOrFail($childId);
        $measurement = Measurement::findOrFail($id);
        return view('measurements.form', compact('child', 'measurement'));
    }

    public function update(Request $request, $childId, $id)
    {
        Gate::authorize('bidan');
        
        $request->validate([
            'measurement_date' => 'required|date',
            'weight' => 'required|numeric',
            'height' => 'required|numeric',
            'head_circumference' => 'required|numeric',
        ]);

        $measurement = Measurement::findOrFail($id);
        $measurement->update(array_merge(
            $request->only(['measurement_date', 'weight', 'height', 'head_circumference']),
            ['color_zone' => $this->calculateColorZone($childId, $request->measurement_date, $request->weight)]
        ));
        
        $this->updateNutritionStatus($childId);

        return redirect()->route('measurements.index', $childId)
            ->with('success', 'Data pengukuran berhasil diupdate');
    }

    public function destroy($childId, $id)
    {
        Gate::authorize('bidan');
        $measurement = Measurement::findOrFail($id);
        $measurement->delete();
        
        $this->updateNutritionStatus($childId);

        return redirect()->route('measurements.index', $childId)
            ->with('success', 'Data pengukuran berhasil dihapus');
    }

    private function calculateColorZone($childId, $measurementDate, $weight)
    {
        $child = Child::findOrFail($childId);
        $umurBulan = $child->birth_date->diffInMonths($measurementDate);

        if ($umurBulan <= 6) {
            $idealWeight = 3.0 + ($umurBulan * 0.7);
        } else {
            $idealWeight = 7.0 + (($umurBulan - 6) * 0.25);
        }

        if ($weight >= $idealWeight + 1.5) {
            return 'biru'; // obesitas
        } elseif ($weight >= $idealWeight - 0.5) {
            return 'hijau'; // normal
        } elseif ($weight >= $idealWeight - 1.5) {
            return 'kuning'; // waspada
        } else {
            return 'merah'; // kurang
        }
    }

    private function updateNutritionStatus($childId)
    {
        $child = Child::findOrFail($childId);
        $latestMeasurement = $child->measurements()->latest('measurement_date')->first();
        
        if ($latestMeasurement) {
            $umurBulan = $child->birth_date->diffInMonths($latestMeasurement->measurement_date);
            $berat = $latestMeasurement->weight;
            
            if ($umurBulan <= 6) {
                $idealWeight = 3.0 + ($umurBulan * 0.7);
            } else {
                $idealWeight = 7.0 + (($umurBulan - 6) * 0.25);
            }
            
            if ($berat >= $idealWeight + 1.5) {
                $status = 'obesitas';
            } elseif ($berat >= $idealWeight - 0.5) {
                $status = 'normal';
            } elseif ($berat >= $idealWeight - 1.5) {
                $status = 'waspada';
            } else {
                $status = 'kurang';
            }
            
            $child->update(['nutrition_status' => $status]);
        }
    }
}