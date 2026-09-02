<?php

namespace App\Http\Controllers;

use App\Models\ModelList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CompareController extends Controller
{
    protected $colors = ['#1a56db', '#ff3b30', '#16a34a', '#f59e0b'];

    public function index()
    {
        $compareIds = session('compare', []);
        $models = [];

        if (!empty($compareIds)) {
            $models = ModelList::with(['brand', 'type', 'specification'])
                ->whereIn('id', $compareIds)
                ->get()
                ->keyBy('id');

            $orderedModels = [];
            foreach ($compareIds as $id) {
                if (isset($models[$id])) {
                    $orderedModels[] = $models[$id];
                }
            }
            $models = $orderedModels;
        }

        $count = count($models);
        $canAdd = $count < 4;
        $canCompare = $count >= 1;
        $msg = session('compare_msg');
        session()->forget('compare_msg');

        return view('compare.index', compact('models', 'count', 'canAdd', 'canCompare', 'msg'));
    }

    public function detail($id)
    {
        // Kosongkan session compare dan hanya tampilkan 1 mobil
        session(['compare' => [$id]]);

        // Redirect ke halaman compare result
        return redirect()->route('compare.result');
    }

    public function add($id)
    {
        $compareIds = session('compare', []);

        $model = ModelList::find($id);
        if (!$model) {
            session()->flash('compare_msg', 'Kendaraan tidak ditemukan.');
            return redirect()->route('compare.index');
        }

        if (in_array($id, $compareIds)) {
            session()->flash('compare_msg', 'Kendaraan sudah ada di daftar perbandingan.');
            return redirect()->route('compare.index');
        }

        if (count($compareIds) >= 4) {
            session()->flash('compare_msg', 'Maksimal 4 kendaraan dapat dibandingkan.');
            return redirect()->route('compare.index');
        }

        $compareIds[] = $id;
        session(['compare' => $compareIds]);
        session()->flash('compare_msg', 'Kendaraan berhasil ditambahkan ke perbandingan.');

        return redirect()->route('compare.index');
    }

    public function remove($id)
    {
        $compareIds = session('compare', []);

        if (($key = array_search($id, $compareIds)) !== false) {
            unset($compareIds[$key]);
            session(['compare' => array_values($compareIds)]);
            session()->flash('compare_msg', 'Kendaraan dihapus dari daftar perbandingan.');
        }

        return redirect()->route('compare.index');
    }

    public function clear()
    {
        session()->forget('compare');
        session()->flash('compare_msg', 'Semua kendaraan dihapus dari daftar perbandingan.');
        return redirect()->route('compare.index');
    }

    public function compare()
    {
        $compareIds = session('compare', []);

        if (count($compareIds) < 1) {
            session()->flash('compare_msg', 'Pilih minimal 1 kendaraan.');
            return redirect()->route('compare.index');
        }

        $models = ModelList::with(['brand', 'type', 'specification'])
            ->whereIn('id', $compareIds)
            ->get()
            ->keyBy('id');

        $orderedModels = [];
        foreach ($compareIds as $id) {
            if (isset($models[$id])) {
                $orderedModels[] = $models[$id];
            }
        }
        $models = $orderedModels;
        $count = count($models);
        $colors = $this->colors;

        // Extract bas tags untuk setiap model
        $basPerModel = [];
        $detailPerModel = [];
        foreach ($models as $i => $model) {
            $basPerModel[$i] = extractBasTags($model);
            $detailPerModel[$i] = [
                'trim' => $this->getDetailField($model, 'trim'),
            ];
        }

        // Hitung skor
        $scores = $this->computeScores($basPerModel);

        // Ambil semua data spesifikasi
        $allSpecsData = [];
        $allSpecsKeys = [];
        foreach ($models as $i => $model) {
            $specs = getAllSpecs($model);
            $allSpecsData[$i] = $specs;
            foreach ($specs as $group => $items) {
                foreach ($items as $key => $item) {
                    if (!isset($allSpecsKeys[$group])) {
                        $allSpecsKeys[$group] = [];
                    }
                    $allSpecsKeys[$group][$key] = $item['label'];
                }
            }
        }

        // Definisikan BAS_TAGS
        $basTags = basDefinitions();

        $canAdd = $count < 4;

        return view('compare.compare', compact(
            'models',
            'count',
            'colors',
            'basPerModel',
            'detailPerModel',
            'scores',
            'allSpecsData',
            'allSpecsKeys',
            'canAdd',
            'basTags'
        ));
    }

    // ============== HELPER METHODS ==============

    private function getDetailField($model, $key)
    {
        $source = $model->specification ?? null;
        if (!$source || empty($source->detail)) return null;

        $data = is_string($source->detail) ? json_decode($source->detail, true) : $source->detail;
        if (!is_array($data)) return null;

        $val = $data[$key] ?? null;
        if (is_string($val)) {
            return trim(preg_replace('/\s*\(bas\d+\)/i', '', $val));
        }
        return $val;
    }

    private function computeScores($basPerModel)
    {
        $scores = [];
        $numericTags = [1, 3, 4, 5, 6, 7, 8, 9, 10];

        // cari nilai max tiap tag numerik
        $maxPerTag = [];
        foreach ($numericTags as $tag) {
            $vals = [];
            foreach ($basPerModel as $i => $bas) {
                $raw = $bas[$tag]['value'] ?? null;
                $num = parseNumericValue($raw);
                if ($num !== null) $vals[] = $num;
            }
            $maxPerTag[$tag] = !empty($vals) ? max($vals) : null;
        }

        foreach ($basPerModel as $i => $bas) {
            $percents = [];
            foreach ($numericTags as $tag) {
                $raw = $bas[$tag]['value'] ?? null;
                $num = parseNumericValue($raw);
                if ($num !== null && $maxPerTag[$tag] > 0) {
                    $percents[] = ($num / $maxPerTag[$tag]) * 100;
                }
            }
            $scores[$i] = !empty($percents) ? (int) round(array_sum($percents) / count($percents)) : null;
        }

        return $scores;
    }
}
