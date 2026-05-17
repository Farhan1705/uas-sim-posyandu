<?php

namespace App\Http\Controllers;

use App\Models\Child;
use App\Models\PregnantWoman;
use App\Ai\Agents\AcademicAgent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Carbon\Carbon;

class ChildController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        Gate::authorize('bidan');
        
        $search = request('search');
        $children = Child::with('mother')
            ->when($search, function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhereHas('mother', function ($q) use ($search) {
                      $q->where('name', 'like', "%$search%");
                  });
            })
            ->get();
        return view('children.index', compact('children', 'search'));
    }

    public function create()
    {
        Gate::authorize('bidan');
        
        $mothers = PregnantWoman::all();
        return view('children.form', compact('mothers'));
    }

    public function store(Request $request)
    {
        Gate::authorize('bidan');
        
        $request->validate([
            'name' => 'required|string|max:100',
            'mother_id' => 'required|exists:pregnant_women,id',
            'birth_date' => 'required|date',
            'gender' => 'required|in:L,P',
        ]);

        Child::create(array_merge($request->only(['name', 'mother_id', 'birth_date', 'gender']), [
            'nutrition_status' => 'normal',
        ]));

        return redirect()->route('children.index')
            ->with('success', 'Data balita berhasil ditambahkan');
    }

    public function show($id)
    {
        $child = Child::with(['mother', 'measurements' => function($query) {
            $query->orderBy('measurement_date', 'desc');
        }, 'immunizations'])->findOrFail($id);
        
        if (auth()->user()->role == 'orang_tua') {
            $mother = PregnantWoman::where('user_id', auth()->id())->first();
            if (!$mother || $child->mother_id != $mother->id) {
                abort(403, 'Anda tidak memiliki akses ke data ini');
            }
        }
        
        $umurBulan = (int) $child->birth_date->diffInMonths(Carbon::now());

        return view('children.show', compact('child', 'umurBulan'));
    }

    public function edit($id)
    {
        Gate::authorize('bidan');
        
        $child = Child::findOrFail($id);
        $mothers = PregnantWoman::all();
        return view('children.form', compact('child', 'mothers'));
    }

    public function update(Request $request, $id)
    {
        Gate::authorize('bidan');
        
        $request->validate([
            'name' => 'required|string|max:100',
            'mother_id' => 'required|exists:pregnant_women,id',
            'birth_date' => 'required|date',
            'gender' => 'required|in:L,P',
        ]);

        $child = Child::findOrFail($id);
        $child->update($request->only(['name', 'mother_id', 'birth_date', 'gender']));

        return redirect()->route('children.index')
            ->with('success', 'Data balita berhasil diupdate');
    }

    public function destroy($id)
    {
        Gate::authorize('bidan');
        
        $child = Child::findOrFail($id);
        $child->delete();

        return redirect()->route('children.index')
            ->with('success', 'Data balita berhasil dihapus');
    }

    public function growthChart($id)
    {
        $child = Child::with(['measurements' => function($query) {
            $query->orderBy('measurement_date', 'asc');
        }, 'mother'])->findOrFail($id);
        
        if (auth()->user()->role == 'orang_tua') {
            $mother = PregnantWoman::where('user_id', auth()->id())->first();
            if (!$mother || $child->mother_id != $mother->id) {
                abort(403, 'Anda tidak memiliki akses ke data ini');
            }
        }
        
        if ($child->measurements->isEmpty()) {
            return view('children.growth-chart', compact('child'))
                ->with('error', 'Belum ada data pengukuran untuk balita ini');
        }
        
        $labels = [];
        $weights = [];
        $heights = [];
        $zones = [];
        
        foreach ($child->measurements as $measurement) {
            $labels[] = $measurement->measurement_date->format('d/m/Y');
            $weights[] = $measurement->weight;
            $heights[] = $measurement->height;
            $zones[] = $measurement->color_zone;
        }
        
        $umurBulan = (int) $child->birth_date->diffInMonths(Carbon::now());
        
        return view('children.growth-chart', compact('child', 'labels', 'weights', 'heights', 'zones', 'umurBulan'));
    }

    public function aiRecommendation($id)
    {
        if (auth()->user()->role !== 'orang_tua') {
            abort(403, 'Fitur ini hanya untuk orang tua.');
        }

        $child = Child::with(['mother', 'measurements' => function($query) {
            $query->latest('measurement_date');
        }])->findOrFail($id);
        
        $latestMeasurement = $child->measurements()->latest('measurement_date')->first();
        
        $umurBulan = (int) $child->birth_date->diffInMonths(Carbon::now());
        
        $statusGiziText = [
            'normal' => 'Normal (Gizi Baik)',
            'waspada' => 'Waspada (Risiko Kurang Gizi)',
            'kurang' => 'Kurang Gizi'
        ];
        
        $prompt = "Anda adalah asisten kesehatan ibu dan anak yang berpengalaman di posyandu.
Berikan rekomendasi gizi untuk balita berikut:

=== DATA BALITA ===
Nama: {$child->name}
Usia: {$umurBulan} bulan
Jenis Kelamin: " . ($child->gender == 'L' ? 'Laki-laki' : 'Perempuan') . "
Status Gizi: " . ($statusGiziText[$child->nutrition_status] ?? $child->nutrition_status) . "

=== DATA PENGUKURAN TERBARU ===
" . ($latestMeasurement ? "
Tanggal: " . $latestMeasurement->measurement_date->format('d/m/Y') . "
Berat Badan: {$latestMeasurement->weight} kg
Tinggi Badan: {$latestMeasurement->height} cm
Lingkar Kepala: {$latestMeasurement->head_circumference} cm
Zona KMS: " . ucfirst($latestMeasurement->color_zone) : "Belum ada data pengukuran") . "

=== INSTRUKSI ===
Berdasarkan data di atas, berikan rekomendasi dengan format PERSIS seperti berikut:

1. Kondisi Gizi Saat Ini
[tulis analisis 2-3 kalimat di sini]

2. Saran Makanan
- [makanan 1]
- [makanan 2]
- [makanan 3]
- [makanan 4]
- [makanan 5]

3. Saran Tindakan
- [tindakan 1]
- [tindakan 2]
- [tindakan 3]

Gunakan bahasa Indonesia yang hangat dan mudah dipahami. Jangan gunakan tanda ** atau format markdown lainnya. Jangan berikan pertanyaan balik.";
        
        try {
            $agent = AcademicAgent::make();
            $response = $agent->prompt($prompt);
            $responseText = (string) $response;
            
        } catch (\Exception $e) {
            $responseText = "Maaf, layanan AI sedang sibuk. Silakan coba lagi nanti.\n\n";
            $responseText .= "Sementara itu, berikut saran umum untuk balita usia {$umurBulan} bulan:\n\n";
            $responseText .= "**Kondisi Umum:**\n";
            $responseText .= "- Pantau berat badan setiap bulan di posyandu\n";
            $responseText .= "- Pastikan imunisasi lengkap sesuai jadwal\n";
            $responseText .= "- Berikan makanan bergizi seimbang\n";
            $responseText .= "- Segera konsultasi ke bidan jika ada keluhan\n\n";
            $responseText .= "*Error teknis: " . $e->getMessage() . "*";
        }
        
        $responseText = $this->markdownToHtml($responseText);

        return view('children.ai-result', compact('child', 'responseText', 'umurBulan'));
    }

    private function markdownToHtml(string $text): string
    {
        $text = preg_replace('/\*\*(.+?)\*\*/s', '$1', $text);
        $text = preg_replace('/\*(.+?)\*/s', '$1', $text);

        $lines = explode("\n", trim($text));
        $html = '';
        $inList = false;

        foreach ($lines as $line) {
            $line = trim($line);

            if ($line === '') {
                if ($inList) {
                    $html .= '</ul>';
                    $inList = false;
                }
                continue;
            }

            if (preg_match('/^(\d+)\.\s+(.+)$/', $line, $m)) {
                if ($inList) { $html .= '</ul>'; $inList = false; }
                $html .= '<p class="font-semibold text-slate-800 mt-4 mb-1">' . $m[1] . '. ' . htmlspecialchars($m[2]) . '</p>';
                continue;
            }

            if (preg_match('/^- (.+)$/', $line, $m)) {
                if (!$inList) {
                    $html .= '<ul class="list-disc ml-5 space-y-1 mb-2">';
                    $inList = true;
                }
                $html .= '<li class="text-slate-700 text-sm">' . htmlspecialchars($m[1]) . '</li>';
                continue;
            }

            if ($inList) { $html .= '</ul>'; $inList = false; }
            $html .= '<p class="text-slate-700 text-sm mb-2">' . htmlspecialchars($line) . '</p>';
        }

        if ($inList) { $html .= '</ul>'; }

        return $html;
    }
}