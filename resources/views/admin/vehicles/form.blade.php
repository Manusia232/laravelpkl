@extends('layouts.admin')

@section('title', isset($vehicle) ? 'Edit Kendaraan' : 'Tambah Kendaraan')

@section('subtitle', 'Data model & spesifikasi disimpan bersamaan pada satu formulir')

@section('content')
<div class="content">
    <!-- Tampilkan pesan error -->
    @if($errors->any())
        <div class="message message-error">
            <ul style="margin:0;padding-left:20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <section class="panel">
        <div class="panel-head">
            <div>
                <h2>{{ isset($vehicle) ? 'Edit Kendaraan' : 'Tambah Kendaraan' }}</h2>
                <p>Data model &amp; spesifikasi disimpan bersamaan pada satu formulir</p>
            </div>
            <a href="{{ route('admin.vehicles.index') }}" class="btn btn-outline">Kembali ke Daftar</a>
        </div>
        <div class="panel-body">
            <form action="{{ isset($vehicle) ? route('admin.vehicles.update', $vehicle->id) : route('admin.vehicles.store') }}"
                  method="POST"
                  enctype="multipart/form-data"
                  onsubmit="return syncAllSpecJson();">
                @csrf
                @if(isset($vehicle))
                    @method('PUT')
                @endif

                <div class="form-grid">
                    <div class="field span-2">
                        <label for="model_name">Nama Model</label>
                        <input class="form-control" id="model_name" name="model_name" type="text"
                               placeholder="Misal: Avanza Veloz" required
                               value="{{ old('model_name', isset($vehicle) ? $vehicle->model_name : '') }}">
                    </div>
                    <div class="field">
                        <label for="brand_id">Brand</label>
                        <select class="form-control" id="brand_id" name="brand_id" required>
                            <option value="">Pilih Brand</option>
                            @foreach($brands as $brand)
                                <option value="{{ $brand->id }}"
                                        {{ (old('brand_id', isset($vehicle) ? $vehicle->brand_id : '') == $brand->id) ? 'selected' : '' }}>
                                    {{ $brand->brand_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="field">
                        <label for="type_id">Tipe Kendaraan</label>
                        <select class="form-control" id="type_id" name="type_id">
                            <option value="">Pilih Tipe</option>
                            @foreach($types as $type)
                                <option value="{{ $type->id }}"
                                        {{ (old('type_id', isset($vehicle) ? $vehicle->type_id : '') == $type->id) ? 'selected' : '' }}>
                                    {{ $type->type_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="field span-2">
                        <label>Foto Kendaraan</label>
                        <div class="upload-row">
                            @if(isset($vehicle) && $vehicle->url_photo)
                                <span class="thumb-lg" style="background-image: url('{{ e($vehicle->url_photo) }}');"></span>
                            @else
                                <span class="thumb-lg"></span>
                            @endif
                            <input class="form-control" type="file" name="foto" accept="image/*">
                            <span class="hint">Maks 2MB. Format: JPG, PNG, WEBP</span>
                        </div>
                        <span class="hint">Disimpan ke kolom url_photo pada tabel models.</span>
                    </div>
                </div>

                <div class="section-title">
                    Spesifikasi Kendaraan
                    <span class="sub">Setiap bagian diedit sebagai tabel key–value (bukan JSON mentah). Baris bisa ditambah/dihapus, tipe value bisa Teks atau List, dan value bisa ditandai tag BAS1–BAS10. Hasilnya otomatis dirakit jadi JSON saat disimpan.</span>
                </div>

                @foreach($specDefs as $fieldName => $def)
                    <div class="spec-block" data-field="{{ $fieldName }}">
                        <div class="spec-block-head">
                            <div class="k">
                                <span class="dot"></span>
                                {{ $def['label'] }}
                                <span class="hint" style="margin-left:8px;">kolom: {{ $fieldName }}</span>
                            </div>
                            <button type="button" class="btn btn-outline btn-sm" onclick="addSpecRow('{{ $fieldName }}')">+ Tambah Baris</button>
                        </div>
                        <div class="spec-block-body">
                            <table class="kv-table">
                                <thead>
                                    <tr>
                                        <th style="width:24%;">Key</th>
                                        <th>Value</th>
                                        <th style="width:110px;">Tipe</th>
                                        <th style="width:140px;">Tag BAS</th>
                                        <th style="width:60px;"></th>
                                    </tr>
                                </thead>
                                <tbody id="rows-{{ $fieldName }}">
                                    @foreach($def['rows'] as $row)
                                        <tr>
                                            <td>
                                                <input type="text" class="kv-key" value="{{ e($row['key']) }}" placeholder="key" oninput="syncSpecJson('{{ $fieldName }}')">
                                            </td>
                                            <td>
                                                <input type="text" class="kv-value" value="{{ e($row['value']) }}" placeholder="value" oninput="syncSpecJson('{{ $fieldName }}')">
                                                @if($row['type'] === 'list')
                                                    <div class="list-hint">List: pisahkan tiap item dengan titik koma ( ; )</div>
                                                @endif
                                            </td>
                                            <td>
                                                <select class="kv-type" onchange="onTypeChange(this, '{{ $fieldName }}')">
                                                    <option value="text" {{ $row['type'] === 'text' ? 'selected' : '' }}>Teks</option>
                                                    <option value="list" {{ $row['type'] === 'list' ? 'selected' : '' }}>List</option>
                                                </select>
                                            </td>
                                            <td>
                                                <select class="kv-bas" onchange="applyBasTag(this, '{{ $fieldName }}')">
                                                    <option value="">Tanpa tag</option>
                                                    @foreach($basTags as $tag)
                                                        <option value="{{ $tag }}" {{ $row['bas'] === $tag ? 'selected' : '' }}>
                                                            {{ strtoupper($tag) }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-danger btn-sm" onclick="removeSpecRow(this, '{{ $fieldName }}')">Hapus</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="kv-preview" id="preview-{{ $fieldName }}">{}</div>
                        </div>
                        <input type="hidden" name="{{ $fieldName }}" id="hidden-{{ $fieldName }}">
                    </div>
                @endforeach

                <div class="form-actions">
                    <button class="btn btn-primary" type="submit">Simpan Kendaraan &amp; Spesifikasi</button>
                    <a href="{{ route('admin.vehicles.index') }}" class="btn btn-outline">Batal</a>
                </div>
            </form>
        </div>
    </section>
</div>

@push('styles')
<style>
    .content {
        padding: 24px 32px;
    }

    .message {
        padding: 12px 18px;
        border-radius: 8px;
        margin-bottom: 16px;
        font-weight: 500;
    }

    .message-error {
        background: #fee2e2;
        color: #991b1b;
        border: 1px solid #fca5a5;
    }

    .panel {
        background: white;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        overflow: hidden;
    }

    .panel-head {
        padding: 20px 24px;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        flex-wrap: wrap;
        gap: 16px;
    }

    .panel-head h2 {
        font-size: 18px;
        font-weight: 600;
    }

    .panel-head p {
        color: #64748b;
        font-size: 14px;
    }

    .panel-body {
        padding: 24px;
    }

    .btn {
        padding: 8px 18px;
        border: none;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        text-decoration: none;
    }

    .btn-primary {
        background: #4f46e5;
        color: white;
    }

    .btn-primary:hover {
        background: #4338ca;
    }

    .btn-outline {
        background: transparent;
        color: #4f46e5;
        border: 1px solid #4f46e5;
    }

    .btn-outline:hover {
        background: #eef2ff;
    }

    .btn-danger {
        background: #ef4444;
        color: white;
    }

    .btn-danger:hover {
        background: #dc2626;
    }

    .btn-sm {
        padding: 5px 12px;
        font-size: 13px;
    }

    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .field {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .field label {
        font-weight: 500;
        font-size: 14px;
        color: #334155;
    }

    .form-control {
        padding: 10px 14px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        font-size: 14px;
        transition: border-color 0.2s;
        width: 100%;
        background: white;
    }

    .form-control:focus {
        outline: none;
        border-color: #4f46e5;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
    }

    .upload-row {
        display: flex;
        align-items: center;
        gap: 16px;
        flex-wrap: wrap;
    }

    .thumb-lg {
        display: inline-block;
        width: 80px;
        height: 80px;
        background: #f1f5f9;
        border-radius: 8px;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
    }

    .hint {
        font-size: 13px;
        color: #64748b;
    }

    .span-2 {
        grid-column: span 2;
    }

    .form-actions {
        margin-top: 24px;
        display: flex;
        gap: 12px;
    }

    /* ===== SPECIFICATION SECTION ===== */
    .section-title {
        margin: 32px 0 16px 0;
        padding-bottom: 12px;
        border-bottom: 2px solid #e2e8f0;
        font-size: 18px;
        font-weight: 600;
    }

    .section-title .sub {
        display: block;
        font-size: 14px;
        font-weight: 400;
        color: #64748b;
        margin-top: 4px;
    }

    .spec-block {
        margin-bottom: 28px;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        overflow: hidden;
    }

    .spec-block-head {
        padding: 12px 16px;
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
    }

    .spec-block-head .k {
        font-weight: 600;
        font-size: 15px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .spec-block-head .k .dot {
        display: inline-block;
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #4f46e5;
        flex-shrink: 0;
    }

    .spec-block-body {
        padding: 14px 16px;
    }

    .kv-table {
        width: 100%;
        border-collapse: collapse;
    }

    .kv-table th {
        font-size: 12px;
        padding: 8px 8px;
        background: #ffffff;
        border-bottom: 1px solid #e2e8f0;
    }

    .kv-table td {
        padding: 6px 6px;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: top;
    }

    .kv-table input[type="text"] {
        padding: 8px 10px;
        border: 1px solid #d1d5db;
        border-radius: 6px;
        font-size: 13.5px;
        width: 100%;
    }

    .kv-table input[type="text"]:focus {
        outline: none;
        border-color: #4f46e5;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
    }

    .kv-table select {
        padding: 8px 6px;
        border: 1px solid #d1d5db;
        border-radius: 6px;
        font-size: 12.5px;
        background: white;
        width: 100%;
    }

    .kv-preview {
        margin-top: 10px;
        background: #0f172a;
        color: #a5f3fc;
        padding: 10px 12px;
        border-radius: 8px;
        font-family: "SFMono-Regular", Consolas, monospace;
        font-size: 12px;
        white-space: pre-wrap;
        word-break: break-all;
        max-height: 140px;
        overflow-y: auto;
    }

    .list-hint {
        font-size: 11.5px;
        color: #94a3b8;
        margin-top: 3px;
    }

    @media (max-width: 768px) {
        .content {
            padding: 16px;
        }
        .form-grid {
            grid-template-columns: 1fr;
        }
        .span-2 {
            grid-column: span 1;
        }
        .panel-head {
            flex-direction: column;
        }
        .upload-row {
            flex-direction: column;
            align-items: flex-start;
        }
        .kv-table {
            display: block;
            overflow-x: auto;
        }
        .spec-block-head {
            flex-direction: column;
            align-items: flex-start;
        }
    }
</style>
@endpush

@push('scripts')
<script>
// ===== DAFTAR BAGIAN SPESIFIKASI =====
var SPEC_FIELDS = ['detail', 'body', 'performa', 'kelistrikan', 'keselamatan', 'fiturlainya'];

function escapeAttr(str) {
    return String(str)
        .replace(/&/g, '&amp;')
        .replace(/"/g, '&quot;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;');
}

function basOptionsHtml(selected) {
    var html = '<option value="">Tanpa tag</option>';
    for (var i = 1; i <= 10; i++) {
        var val = 'bas' + i;
        html += '<option value="' + val + '"' + (selected === val ? ' selected' : '') + '>' + val.toUpperCase() + '</option>';
    }
    return html;
}

// Tambah baris baru ke tabel key-value
function addSpecRow(field, key, value, type) {
    key = key || '';
    value = value || '';
    type = type || 'text';

    var tbody = document.getElementById('rows-' + field);
    var tr = document.createElement('tr');

    tr.innerHTML =
        '<td><input type="text" class="kv-key" value="' + escapeAttr(key) + '" placeholder="key" oninput="syncSpecJson(\'' + field + '\')"></td>' +
        '<td><input type="text" class="kv-value" value="' + escapeAttr(value) + '" placeholder="value" oninput="syncSpecJson(\'' + field + '\')">' +
            (type === 'list' ? '<div class="list-hint">List: pisahkan tiap item dengan titik koma ( ; )</div>' : '') +
        '</td>' +
        '<td><select class="kv-type" onchange="onTypeChange(this, \'' + field + '\')">' +
            '<option value="text"' + (type === 'text' ? ' selected' : '') + '>Teks</option>' +
            '<option value="list"' + (type === 'list' ? ' selected' : '') + '>List</option>' +
        '</select></td>' +
        '<td><select class="kv-bas" onchange="applyBasTag(this, \'' + field + '\')">' + basOptionsHtml('') + '</select></td>' +
        '<td><button type="button" class="btn btn-danger btn-sm" onclick="removeSpecRow(this, \'' + field + '\')">Hapus</button></td>';

    tbody.appendChild(tr);
    syncSpecJson(field);
}

function removeSpecRow(btn, field) {
    var tr = btn.closest('tr');
    tr.parentNode.removeChild(tr);
    syncSpecJson(field);
}

// Saat "Tipe" diganti (Teks <-> List)
function onTypeChange(select, field) {
    var td = select.closest('tr').querySelector('.kv-value').parentNode;
    var existingHint = td.querySelector('.list-hint');
    if (select.value === 'list') {
        if (!existingHint) {
            var hint = document.createElement('div');
            hint.className = 'list-hint';
            hint.textContent = 'List: pisahkan tiap item dengan titik koma ( ; )';
            td.appendChild(hint);
        }
    } else if (existingHint) {
        existingHint.parentNode.removeChild(existingHint);
    }
    syncSpecJson(field);
}

// Menambahkan / mengganti tag "(basN)" di akhir value
function applyBasTag(select, field) {
    var tr = select.closest('tr');
    var valueInput = tr.querySelector('.kv-value');
    var val = valueInput.value;

    // Buang tag bas lama jika ada
    val = val.replace(/\s*\(\s*bas([1-9]|10)\s*\)\s*/gi, '').trim();

    if (select.value) {
        val = val + ' (' + select.value + ')';
    }

    valueInput.value = val;
    syncSpecJson(field);
}

// Merakit semua baris tabel satu bagian spesifikasi menjadi objek JSON
function syncSpecJson(field) {
    var rows = document.querySelectorAll('#rows-' + field + ' tr');
    var obj = {};

    rows.forEach(function (tr) {
        var keyInput = tr.querySelector('.kv-key');
        var valueInput = tr.querySelector('.kv-value');
        var typeSelect = tr.querySelector('.kv-type');
        if (!keyInput) return;

        var k = keyInput.value.trim();
        if (k === '') return;

        var rawVal = valueInput ? valueInput.value : '';
        var type = typeSelect ? typeSelect.value : 'text';

        if (type === 'list') {
            var items = rawVal.split(';').map(function (s) { return s.trim(); }).filter(function (s) { return s !== ''; });
            obj[k] = items;
        } else {
            obj[k] = rawVal;
        }
    });

    var json = JSON.stringify(obj);
    var hiddenInput = document.getElementById('hidden-' + field);
    if (hiddenInput) hiddenInput.value = json;

    var preview = document.getElementById('preview-' + field);
    if (preview) preview.textContent = JSON.stringify(obj, null, 2);

    return obj;
}

// Sinkronkan semua bagian sekaligus (dipanggil saat submit form)
function syncAllSpecJson() {
    SPEC_FIELDS.forEach(function (field) {
        syncSpecJson(field);
    });
    return true;
}

// Inisialisasi preview saat halaman dimuat
document.addEventListener('DOMContentLoaded', function () {
    SPEC_FIELDS.forEach(function (field) {
        syncSpecJson(field);
    });
});
</script>
@endpush
@endsection
