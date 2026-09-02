<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@if($count === 1) Detail Kendaraan @else Perbandingan Kendaraan @endif</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&display=swap" rel="stylesheet">
<style>
    * { margin:0; padding:0; box-sizing:border-box; font-family:'Inter',-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif; }
    :root {
        --primary:#1a56db; --primary-light:#3b82f6; --primary-dark:#1e3a8a;
        --bg:#f8fafc; --card-bg:#ffffff; --text:#0f172a; --text-secondary:#475569;
        --text-muted:#94a3b8; --border:#e2e8f0; --shadow:0 4px 24px rgba(0,0,0,0.06);
        --radius:16px; --radius-sm:10px; --transition:0.25s cubic-bezier(0.4,0,0.2,1);
    }
    body {
        background: var(--bg);
        color: var(--text);
        line-height: 1.6;
        padding: 0;
    }
    ::-webkit-scrollbar { width:6px; height:6px; }
    ::-webkit-scrollbar-track { background: var(--bg); }
    ::-webkit-scrollbar-thumb { background: var(--border); border-radius:10px; }

    .main-wrapper {
        max-width: 1280px;
        margin: 0 auto;
        padding: 24px 24px 40px;
    }

    .back-link {
        display: inline-block;
        color: var(--text-secondary);
        text-decoration: none;
        font-size: 0.9rem;
        font-weight: 500;
        margin-bottom: 24px;
    }
    .back-link:hover { color: var(--primary); }

    .compare-container {
        display:flex;
        align-items:stretch;
        justify-content:center;
        gap:16px;
        padding:0 0 32px;
        flex-wrap:wrap;
    }

    .card {
        background: var(--card-bg);
        border-radius: var(--radius);
        padding:18px;
        width:240px;
        box-shadow: var(--shadow);
        border:1px solid var(--border);
        transition: var(--transition);
        flex-shrink:0;
        position: relative;
    }
    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 32px rgba(0,0,0,0.08);
    }

    .score-badge {
        position: absolute;
        top: 12px;
        right: 12px;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 0.9rem;
        background: #eff6ff;
        border: 2px solid var(--primary);
        color: var(--primary);
    }

    .card-header {
        display:flex;
        align-items:center;
        gap:10px;
        margin-bottom:10px;
        padding-right: 40px;
    }
    .color-dot {
        width:12px;
        height:12px;
        border-radius:4px;
        flex-shrink:0;
    }
    .card-info h3 {
        font-size:0.9rem;
        font-weight:700;
        color: var(--text);
        line-height:1.3;
    }
    .card-info .sub-model {
        font-size:0.65rem;
        color: var(--text-muted);
        font-weight:500;
        text-transform:uppercase;
        letter-spacing:0.3px;
    }

    .trim-badge {
        display: inline-block;
        font-size: 0.65rem;
        font-weight: 600;
        color: var(--text-secondary);
        background: var(--bg);
        padding: 3px 8px;
        border-radius: 6px;
        margin-bottom: 10px;
    }

    .card-image {
        width:100%;
        height:140px;
        background: linear-gradient(135deg,#f1f5f9 0%,#e2e8f0 100%);
        border-radius: var(--radius-sm);
        display:flex;
        align-items:center;
        justify-content:center;
        color: var(--text-muted);
        font-size:0.75rem;
        border:2px dashed var(--border);
        overflow:hidden;
    }
    .card-image img {
        width:100%;
        height:100%;
        object-fit:cover;
        border-radius: var(--radius-sm);
        border:none;
    }
    .card-image .placeholder-icon {
        font-size:2rem;
        opacity:0.4;
        margin-bottom:4px;
    }
    .card-image .placeholder-text {
        display:flex;
        flex-direction:column;
        align-items:center;
        gap:2px;
    }

    .vs-divider {
        display:flex;
        align-items:center;
        justify-content:center;
        flex-shrink:0;
        width:40px;
        height:40px;
        border-radius:50%;
        background: var(--card-bg);
        border:2px solid var(--border);
        font-weight:800;
        font-size:0.6rem;
        letter-spacing:0.5px;
        color: var(--text-muted);
        text-transform:uppercase;
        box-shadow: var(--shadow);
        align-self:center;
    }

    .add-compare-section {
        display:flex;
        align-items:center;
        flex-shrink:0;
    }
    .btn-add-compare {
        background: var(--card-bg);
        border:2px dashed var(--border);
        border-radius: var(--radius);
        padding:14px 20px;
        font-size:0.8rem;
        font-weight:600;
        color: var(--text-secondary);
        cursor:pointer;
        transition: var(--transition);
        display:flex;
        align-items:center;
        gap:8px;
        height:100%;
        min-height:150px;
        justify-content:center;
        text-decoration:none;
        width:240px;
    }
    .btn-add-compare:hover {
        border-color: var(--primary-light);
        color: var(--primary);
        background:#f8faff;
    }
    .btn-add-compare i { font-size:1.2rem; }

    .specs-section {
        background: var(--card-bg);
        padding:32px 40px 40px;
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        border:1px solid var(--border);
        margin-top: 0;
    }

    .specs-legend {
        display:flex;
        justify-content:flex-start;
        gap:24px;
        padding-bottom:16px;
        border-bottom:2px solid var(--bg);
        margin-bottom:24px;
        flex-wrap:wrap;
    }
    .legend-item {
        display:flex;
        align-items:center;
        gap:8px;
        font-size:0.75rem;
        font-weight:600;
    }
    .legend-dot {
        width:12px;
        height:12px;
        border-radius:4px;
        flex-shrink:0;
    }

    .spec-group { margin-bottom:28px; }
    .spec-group:last-child { margin-bottom:0; }
    .spec-group-title {
        font-size:1rem;
        font-weight:700;
        color: var(--text);
        margin-bottom:12px;
        padding-bottom:6px;
        border-bottom:2px solid var(--bg);
    }

    .spec-row {
        display:grid;
        grid-template-columns: 1.6fr repeat({{ $count }}, 2fr);
        padding:8px 0;
        border-bottom:1px solid #f1f5f9;
        font-size:0.82rem;
        align-items:center;
        gap:10px;
    }
    .spec-row:last-child { border-bottom:none; }
    .spec-label {
        color: var(--text-secondary);
        font-weight:600;
        font-size:0.75rem;
        text-transform:uppercase;
        letter-spacing:0.2px;
    }
    .spec-val { font-weight:500; }

    .visual-comparison-section { margin-top: 32px; }
    .visual-grid {
        display:grid;
        grid-template-columns: repeat(auto-fill, minmax(300px,1fr));
        gap:16px;
    }
    .visual-card {
        background: var(--card-bg);
        border:1px solid var(--border);
        border-radius: var(--radius);
        padding:18px 20px 18px;
        box-shadow: var(--shadow);
    }
    .visual-card h4 {
        font-size:0.72rem;
        font-weight:700;
        text-transform:uppercase;
        letter-spacing:0.5px;
        color: var(--text-secondary);
        margin-bottom:12px;
        padding-bottom:8px;
        border-bottom:1px solid var(--bg);
    }
    .visual-row { margin-bottom:12px; }
    .visual-row:last-of-type { margin-bottom:0; }
    .visual-row-header {
        display:flex;
        justify-content:space-between;
        font-size:0.75rem;
        font-weight:500;
        margin-bottom:3px;
    }
    .visual-name { color: var(--text-secondary); }
    .visual-val { color: var(--text); font-weight:600; }
    .progress-bar-container {
        width:100%;
        height:5px;
        background: var(--bg);
        border-radius:10px;
        overflow:hidden;
    }
    .progress-bar {
        height:100%;
        border-radius:10px;
        transition: width 0.6s ease;
    }
    .empty-data-row {
        display:flex;
        align-items:center;
        gap:6px;
        color: var(--text-muted);
        font-size:0.7rem;
        padding:3px 0 2px;
    }

    .empty-state {
        text-align:center;
        padding:30px 0;
        color: var(--text-muted);
    }
    .empty-state i {
        font-size:1.8rem;
        display:block;
        margin-bottom:10px;
    }

    @media (max-width: 1100px) {
        .card { width:210px; padding:14px; }
        .btn-add-compare { width:210px; min-height:130px; padding:12px 16px; }
        .card-image { height:120px; }
        .score-badge { width:32px; height:32px; font-size:0.75rem; top:10px; right:10px; }
        .card-header { padding-right: 32px; }
        .card-info h3 { font-size:0.8rem; }
    }

    @media (max-width: 900px) {
        .compare-container {
            flex-wrap: nowrap;
            overflow-x: auto;
            justify-content:flex-start;
            padding:0 0 20px;
            gap:12px;
            -webkit-overflow-scrolling: touch;
        }
        .compare-container::-webkit-scrollbar {
            height:4px;
        }
        .compare-container::-webkit-scrollbar-track {
            background: var(--bg);
            border-radius:10px;
        }
        .compare-container::-webkit-scrollbar-thumb {
            background: var(--border);
            border-radius:10px;
        }
        .card {
            width:200px;
            flex-shrink:0;
            padding:12px;
        }
        .btn-add-compare {
            width:200px;
            min-height:120px;
            padding:10px 14px;
            flex-shrink:0;
        }
        .card-image { height:110px; }
        .specs-section { padding:20px 16px 24px; }
        .spec-row {
            grid-template-columns: 1fr !important;
            gap:2px;
            padding:10px 0;
        }
        .spec-label {
            font-size:0.65rem;
            color: var(--text-muted);
        }
        .visual-grid { grid-template-columns: 1fr; }
        .score-badge { width:28px; height:28px; font-size:0.65rem; top:8px; right:8px; }
        .card-header { padding-right: 28px; }
        .card-info h3 { font-size:0.75rem; }
        .main-wrapper { padding: 16px; }
        .back-link { font-size:0.8rem; margin-bottom:16px; }
    }

    @media (max-width: 480px) {
        .card { width:170px; padding:10px; }
        .btn-add-compare { width:170px; min-height:100px; padding:8px 12px; font-size:0.7rem; }
        .card-image { height:90px; }
        .card-info h3 { font-size:0.7rem; }
        .card-info .sub-model { font-size:0.55rem; }
        .trim-badge { font-size:0.55rem; padding:2px 6px; }
        .score-badge { width:24px; height:24px; font-size:0.55rem; top:6px; right:6px; }
        .card-header { padding-right: 24px; gap:6px; }
        .color-dot { width:10px; height:10px; }
        .vs-divider { width:30px; height:30px; font-size:0.5rem; }
    }
</style>
</head>
<body>

{{-- NAVBAR --}}
@include('components.navbar')

<div class="main-wrapper">
    <a href="{{ route('compare.index') }}" class="back-link">
        <i class="fa-regular fa-arrow-left"></i> Kembali ke Daftar Perbandingan
    </a>

    <!-- ===== COMPARE CARDS ===== -->
    <section class="compare-container">
        @foreach($models as $i => $model)
            <div class="card">
                @if(isset($scores[$i]) && $scores[$i] !== null)
                    <div class="score-badge" style="border-color: {{ $colors[$i % count($colors)] }}; color: {{ $colors[$i % count($colors)] }};">
                        {{ $scores[$i] }}
                    </div>
                @endif

                <div class="card-header">
                    <span class="color-dot" style="background: {{ $colors[$i % count($colors)] }};"></span>
                    <div class="card-info">
                        <h3>{{ e($model->model_name) }}</h3>
                        <span class="sub-model">
                            {{ e(implode(' · ', array_filter(getSpecTagsFromBas($basPerModel[$i] ?? []))) ?: ($model->brand->brand_name ?? '')) }}
                        </span>
                    </div>
                </div>

                @if(!empty($detailPerModel[$i]['trim']))
                    <div class="trim-badge">{{ e($detailPerModel[$i]['trim']) }}</div>
                @endif

                <div class="card-image">
                    @if(!empty($model->url_photo))
                        <img src="{{ $model->url_photo }}" alt="{{ e($model->model_name) }}">
                    @else
                        <div class="placeholder-text">
                            <i class="fa-solid fa-car placeholder-icon"></i>
                            <span>Foto tidak tersedia</span>
                        </div>
                    @endif
                </div>
            </div>

            @if($count === 2 && $i === 0)
                <div class="vs-divider">vs</div>
            @endif
        @endforeach

        @if($canAdd)
            <div class="add-compare-section">
                <a class="btn-add-compare" href="{{ route('brands.index') }}">
                    <i class="fa-regular fa-square-plus"></i>
                    Tambah Perbandingan
                </a>
            </div>
        @endif
    </section>

    <!-- ===== SPECIFICATIONS TABLE ===== -->
    <section class="specs-section">
        <div class="specs-legend">
            @foreach($models as $i => $model)
                <div class="legend-item">
                    <span>{{ e($model->model_name) }}</span>
                    <span class="legend-dot" style="background: {{ $colors[$i % count($colors)] }};"></span>
                </div>
            @endforeach
        </div>

        @if(!empty($allSpecsKeys))
            @foreach($allSpecsKeys as $groupName => $keys)
                <div class="spec-group">
                    <h2 class="spec-group-title">{{ e($groupName) }}</h2>

                    @foreach($keys as $key => $label)
                        <div class="spec-row">
                            <span class="spec-label">{{ e($label) }}</span>
                            @foreach($models as $i => $model)
                                @php
                                    $val = $allSpecsData[$i][$groupName][$key]['value'] ?? '—';
                                    $val = $val === '' ? '—' : $val;
                                @endphp
                                <span class="spec-val" style="color: {{ $colors[$i % count($colors)] }};">
                                    {{ e($val) }}
                                </span>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            @endforeach
        @else
            <div class="empty-state">
                <i class="fa-regular fa-file-lines"></i>
                <p>Belum ada data spesifikasi untuk kendaraan yang dibandingkan.</p>
            </div>
        @endif
    </section>

    <!-- ===== VISUAL COMPARISON (Progress Bars) ===== -->
    @if($count > 1)
    <section class="visual-comparison-section">
        <div class="visual-grid">
            @foreach($basTags as $tagNum => $def)
                @php
                    if (!$def['numeric']) continue;

                    $numericVals = [];
                    $hasData = false;
                    foreach ($models as $i => $model) {
                        $raw = $basPerModel[$i][$tagNum]['value'] ?? null;
                        $numericVals[$i] = parseNumericValue($raw);
                        if ($numericVals[$i] !== null) {
                            $hasData = true;
                        }
                    }

                    if (!$hasData) continue;

                    $maxVal = max(array_filter($numericVals, function($v) { return $v !== null; }));
                @endphp

                <div class="visual-card">
                    <h4>{{ e($def['label']) }}</h4>

                    @foreach($models as $i => $model)
                        @php
                            $rawVal = $basPerModel[$i][$tagNum]['value'] ?? null;
                            $numVal = $numericVals[$i];
                            $percent = ($numVal !== null && $maxVal > 0) ? round(($numVal / $maxVal) * 100) : 0;
                        @endphp
                        <div class="visual-row">
                            <div class="visual-row-header">
                                <span class="visual-name">{{ e($model->model_name) }}</span>
                                <span class="visual-val">{{ $rawVal !== null ? e($rawVal) : '&mdash;' }}</span>
                            </div>
                            <div class="progress-bar-container">
                                <div class="progress-bar" style="width: {{ $percent }}%; background: {{ $colors[$i % count($colors)] }};"></div>
                            </div>
                            @if($rawVal === null)
                                <div class="empty-data-row">
                                    <i class="fa-regular fa-circle-question"></i>
                                    <span>Data tidak tersedia</span>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
    </section>
    @endif
</div>
<x-footer />
</body>
</html>
