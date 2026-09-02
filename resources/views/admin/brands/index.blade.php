@extends('layouts.admin')

@section('title', 'Kelola Brand')

@section('content')
<div class="content">
    <!-- Tampilkan pesan -->
    @if(session('success'))
        <div class="message message-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="message message-error">
            {{ session('error') }}
        </div>
    @endif

    <!-- LIST VIEW -->
    <section class="panel">
        <div class="panel-head">
            <div>
                <h2>Daftar Brand</h2>
                <p>{{ $brands->count() }} brand terdaftar</p>
            </div>
            <div class="toolbar">
                <form method="GET" style="display:flex;gap:8px;align-items:center;">
                    <input class="search" type="text" name="search" placeholder="Cari brand..." value="{{ $search }}">
                    <button type="submit" class="btn btn-outline btn-sm">Cari</button>
                    @if($search)
                        <a href="{{ route('admin.brands.index') }}" class="btn btn-outline btn-sm">Reset</a>
                    @endif
                </form>
                <a href="{{ route('admin.brands.create') }}" class="btn btn-primary">Tambah Brand</a>
            </div>
        </div>
        <table>
            <thead>
                <tr>
                    <th style="width:52px;">ID</th>
                    <th>Logo</th>
                    <th>Nama Brand</th>
                    <th>URL Logo</th>
                    <th style="width:170px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @if($brands->isEmpty())
                    <tr>
                        <td colspan="5" style="text-align:center;padding:40px;color:#94a3b8;">
                            {{ $search ? 'Brand "' . e($search) . '" tidak ditemukan' : 'Belum ada brand yang terdaftar' }}
                        </td>
                    </tr>
                @else
                    @foreach($brands as $brand)
                        <tr>
                            <td>{{ $brand->id }}</td>
                            <td>
                                <span class="thumb" style="background-image: url('{{ e($brand->url_logo ?? '') }}');"></span>
                            </td>
                            <td>{{ e($brand->brand_name) }}</td>
                            <td style="max-width:200px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                                {{ e($brand->url_logo ?? '-') }}
                            </td>
                            <td class="actions">
                                <a href="{{ route('admin.brands.edit', $brand->id) }}" class="btn btn-outline btn-sm">Edit</a>
                                <form action="{{ route('admin.brands.destroy', $brand->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus brand ini?');">Hapus</button>
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
    /* ====== ADMIN STYLES ====== */
    .content {
        padding: 24px 32px;
    }

    .message {
        padding: 12px 18px;
        border-radius: 8px;
        margin-bottom: 16px;
        font-weight: 500;
    }

    .message-success {
        background: #dcfce7;
        color: #166534;
        border: 1px solid #86efac;
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

    .toolbar {
        display: flex;
        gap: 12px;
        align-items: center;
        flex-wrap: wrap;
    }

    .search {
        padding: 8px 14px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        font-size: 14px;
        min-width: 200px;
        transition: border-color 0.2s;
    }

    .search:focus {
        outline: none;
        border-color: #4f46e5;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
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

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th {
        text-align: left;
        padding: 12px 16px;
        background: #f8fafc;
        font-weight: 600;
        color: #475569;
        font-size: 13px;
        border-bottom: 1px solid #e2e8f0;
    }

    td {
        padding: 12px 16px;
        border-bottom: 1px solid #f1f5f9;
        font-size: 14px;
        vertical-align: middle;
    }

    tr:hover td {
        background: #f8fafc;
    }

    .actions {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }

    .thumb {
        display: inline-block;
        width: 40px;
        height: 40px;
        background: #f1f5f9;
        border-radius: 8px;
        background-size: contain;
        background-position: center;
        background-repeat: no-repeat;
    }

    @media (max-width: 768px) {
        .content {
            padding: 16px;
        }
        .panel-head {
            flex-direction: column;
        }
        .toolbar {
            width: 100%;
        }
        .search {
            flex: 1;
            min-width: 120px;
        }
        table {
            display: block;
            overflow-x: auto;
            white-space: nowrap;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    // Auto-hide messages after 5 seconds
    setTimeout(function() {
        const messages = document.querySelectorAll('.message');
        messages.forEach(function(msg) {
            msg.style.transition = 'opacity 0.5s';
            msg.style.opacity = '0';
            setTimeout(function() {
                msg.style.display = 'none';
            }, 500);
        });
    }, 5000);
</script>
@endpush
@endsection