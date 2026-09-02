@extends('layouts.admin')

@section('title', isset($type) ? 'Edit Tipe' : 'Tambah Tipe')

@section('subtitle', 'Kolom sesuai tabel types: type_name, url_photo')

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
                <h2>{{ isset($type) ? 'Edit Tipe' : 'Tambah Tipe' }}</h2>
                <p>Kolom sesuai tabel <code>types</code>: type_name, url_photo</p>
            </div>
            <a href="{{ route('admin.types.index') }}" class="btn btn-outline">Kembali ke Daftar</a>
        </div>
        <div class="panel-body">
            <form action="{{ isset($type) ? route('admin.types.update', $type->id) : route('admin.types.store') }}"
                  method="POST"
                  enctype="multipart/form-data">
                @csrf
                @if(isset($type))
                    @method('PUT')
                @endif

                <div class="form-grid">
                    <div class="field span-2">
                        <label for="type_name">Nama Tipe</label>
                        <input class="form-control" id="type_name" name="type_name" type="text"
                               placeholder="Misal: MPV" required
                               value="{{ old('type_name', isset($type) ? $type->type_name : '') }}">
                    </div>
                    <div class="field span-2">
                        <label>Foto Ilustrasi Tipe</label>
                        <div class="upload-row">
                            @if(isset($type) && $type->url_photo)
                                <span class="thumb-lg" style="background-image: url('{{ e($type->url_photo) }}');"></span>
                            @else
                                <span class="thumb-lg"></span>
                            @endif
                            <input class="form-control" type="file" name="foto" accept="image/*">
                        </div>
                        <span class="hint">Disimpan ke kolom url_photo, dipakai sebagai ikon kategori pada halaman katalog. Maks 2MB.</span>
                    </div>
                </div>
                <div class="form-actions">
                    <button class="btn btn-primary" type="submit">Simpan Tipe</button>
                    <a href="{{ route('admin.types.index') }}" class="btn btn-outline">Batal</a>
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

    .form-actions {
        margin-top: 24px;
        display: flex;
        gap: 12px;
    }

    .span-2 {
        grid-column: span 2;
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
    }
</style>
@endpush
@endsection
