@extends('layouts.admin')

@section('title', 'Kelola Kendaraan')

@section('subtitle', 'Model kendaraan · tabel models + specifications')

@section('content')
<div class="content">
    @if(session('success'))
        <div class="message message-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="message message-error">{{ session('error') }}</div>
    @endif

    <section class="panel">
        <div class="panel-head">
            <div>
                <h2>Daftar Model Kendaraan</h2>
                <p>{{ $vehicles->count() }} model terdaftar dari {{ $totalBrands }} brand</p>
            </div>
            <div class="toolbar">
                <form method="GET" style="display:flex;gap:8px;align-items:center;flex-wrap:wrap;">
                    <select class="form-control" name="brand" style="width:150px;" onchange="this.form.submit()">
                        <option value="">Semua Brand</option>
                        @foreach($brands as $brand)
                            <option value="{{ $brand->id }}" {{ $brandFilter == $brand->id ? 'selected' : '' }}>
                                {{ $brand->brand_name }}
                            </option>
                        @endforeach
                    </select>
                    <input class="search" type="text" name="search" placeholder="Cari model..." value="{{ $search }}">
                    <button type="submit" class="btn btn-outline btn-sm">Cari</button>
                    @if($search || $brandFilter)
                        <a href="{{ route('admin.vehicles.index') }}" class="btn btn-outline btn-sm">Reset</a>
                    @endif
                </form>
                <a href="{{ route('admin.vehicles.create') }}" class="btn btn-primary">Tambah Kendaraan</a>
            </div>
        </div>
        <table>
            <thead>
                <tr>
                    <th style="width:52px;">ID</th>
                    <th>Foto</th>
                    <th>Nama Model</th>
                    <th>Brand</th>
                    <th>Tipe</th>
                    <th>Spesifikasi</th>
                    {{-- <th>Komentar</th> --}}
                    <th style="width:170px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @if($vehicles->isEmpty())
                    <tr>
                        <td colspan="8" style="text-align:center;padding:40px;color:#94a3b8;">
                            {{ ($search || $brandFilter) ? 'Kendaraan tidak ditemukan' : 'Belum ada kendaraan yang terdaftar' }}
                        </td>
                    </tr>
                @else
                    @foreach($vehicles as $vehicle)
                        <tr>
                            <td>{{ $vehicle->id }}</td>
                            <td>
                                <span class="thumb" style="background-image: url('{{ e($vehicle->url_photo ?? '') }}');"></span>
                            </td>
                            <td>{{ e($vehicle->model_name) }}</td>
                            <td>{{ e($vehicle->brand->brand_name ?? '-') }}</td>
                            <td>{{ e($vehicle->type->type_name ?? '-') }}</td>
                            <td>
                                <span class="tag {{ $vehicle->status_spesifikasi == 'Lengkap' ? 'tag-success' : 'tag-amber' }}">
                                    {{ $vehicle->status_spesifikasi }}
                                </span>
                            </td>
                            {{-- <td><span class="tag tag-danger">{{ $vehicle->comments_count ?? 0 }}</span></td> --}}
                            <td class="actions">
                                <a href="{{ route('admin.vehicles.edit', $vehicle->id) }}" class="btn btn-outline btn-sm">Edit</a>
                                <form action="{{ route('admin.vehicles.destroy', $vehicle->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus kendaraan ini? Semua data terkait akan terhapus.');">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </section>
</div>

@push('styles')
<style>
    .content { padding: 24px 32px; }
    .message { padding: 12px 18px; border-radius: 8px; margin-bottom: 16px; font-weight: 500; }
    .message-success { background: #dcfce7; color: #166534; border: 1px solid #86efac; }
    .message-error { background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; }
    .panel { background: white; border-radius: 12px; border: 1px solid #e2e8f0; overflow: hidden; }
    .panel-head { padding: 20px 24px; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 16px; }
    .panel-head h2 { font-size: 18px; font-weight: 600; }
    .panel-head p { color: #64748b; font-size: 14px; }
    .toolbar { display: flex; gap: 12px; align-items: center; flex-wrap: wrap; }
    .search { padding: 8px 14px; border: 1px solid #d1d5db; border-radius: 8px; font-size: 14px; min-width: 200px; }
    .search:focus { outline: none; border-color: #4f46e5; box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1); }
    .btn { padding: 8px 18px; border: none; border-radius: 8px; font-size: 14px; font-weight: 500; cursor: pointer; transition: all 0.2s; display: inline-flex; align-items: center; gap: 6px; text-decoration: none; }
    .btn-primary { background: #4f46e5; color: white; }
    .btn-primary:hover { background: #4338ca; }
    .btn-outline { background: transparent; color: #4f46e5; border: 1px solid #4f46e5; }
    .btn-outline:hover { background: #eef2ff; }
    .btn-danger { background: #ef4444; color: white; }
    .btn-danger:hover { background: #dc2626; }
    .btn-sm { padding: 5px 12px; font-size: 13px; }
    .form-control { padding: 8px 12px; border: 1px solid #d1d5db; border-radius: 8px; font-size: 14px; background: white; }
    table { width: 100%; border-collapse: collapse; }
    th { text-align: left; padding: 12px 16px; background: #f8fafc; font-weight: 600; color: #475569; font-size: 13px; border-bottom: 1px solid #e2e8f0; }
    td { padding: 12px 16px; border-bottom: 1px solid #f1f5f9; font-size: 14px; vertical-align: middle; }
    tr:hover td { background: #f8fafc; }
    .actions { display: flex; gap: 8px; flex-wrap: wrap; }
    .thumb { display: inline-block; width: 40px; height: 40px; background: #f1f5f9; border-radius: 8px; background-size: cover; background-position: center; background-repeat: no-repeat; }
    .tag { display: inline-block; padding: 2px 10px; border-radius: 20px; font-size: 12px; font-weight: 500; }
    .tag-success { background: #dcfce7; color: #166534; }
    .tag-danger { background: #fee2e2; color: #991b1b; }
    .tag-amber { background: #fef3c7; color: #92400e; }
    @media (max-width: 768px) {
        .content { padding: 16px; }
        .panel-head { flex-direction: column; }
        .toolbar { width: 100%; }
        .search { flex: 1; min-width: 120px; }
        table { display: block; overflow-x: auto; white-space: nowrap; }
    }
</style>
@endpush
@endsection
