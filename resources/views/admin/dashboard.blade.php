@extends('layouts.admin')

@section('title', 'Dashboard')

@section('subtitle', 'Ringkasan data armada kendaraan listrik')

@section('content')
<div class="content">
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:20px;margin-bottom:24px;">
        <div style="background:white;padding:20px;border-radius:12px;border:1px solid #e2e8f0;">
            <div style="font-size:28px;font-weight:700;color:#4f46e5;">{{ \App\Models\Brand::count() }}</div>
            <div style="color:#64748b;font-size:14px;">Total Brand</div>
        </div>
        <div style="background:white;padding:20px;border-radius:12px;border:1px solid #e2e8f0;">
            <div style="font-size:28px;font-weight:700;color:#4f46e5;">{{ \App\Models\ModelList::count() }}</div>
            <div style="color:#64748b;font-size:14px;">Total Kendaraan</div>
        </div>
        <div style="background:white;padding:20px;border-radius:12px;border:1px solid #e2e8f0;">
            <div style="font-size:28px;font-weight:700;color:#4f46e5;">{{ \App\Models\User::count() }}</div>
            <div style="color:#64748b;font-size:14px;">Total User</div>
        </div>
        <div style="background:white;padding:20px;border-radius:12px;border:1px solid #e2e8f0;">
            <div style="font-size:28px;font-weight:700;color:#4f46e5;">{{ \App\Models\Comment::count() }}</div>
            <div style="color:#64748b;font-size:14px;">Total Komentar</div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .content {
        padding: 24px 32px;
    }
    @media (max-width: 768px) {
        .content {
            padding: 16px;
        }
    }
</style>
@endpush
@endsection