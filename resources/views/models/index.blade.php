<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Pilih Tipe Kendaraan{{ $brandName ? ' ' . e($brandName) : '' }}</title>
<style>
  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
  }

  body {
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
    background-color: #ffffff;
    color: #1a1a1a;
    padding: 0;
  }

  .main-content {
    padding: 32px 48px;
  }

  .breadcrumb {
    font-size: 13px;
    color: #9a9a9a;
    display: flex;
    align-items: center;
    gap: 6px;
    margin-bottom: 10px;
    flex-wrap: wrap;
  }

  .breadcrumb a {
    color: #9a9a9a;
    text-decoration: none;
  }

  .breadcrumb a:hover {
    color: #2563eb;
    text-decoration: underline;
  }

  .breadcrumb .current {
    color: #c7c7c7;
  }

  .breadcrumb .sep {
    color: #d5d5d5;
  }

  .page-title {
    font-size: 26px;
    font-weight: 700;
    color: #1a1a1a;
  }

  .page-title .highlight {
    color: #2563eb;
  }

  .product-grid {
    margin-top: 26px;
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
  }

  .product-card {
    background-color: #ffffff;
    border: 1px solid #ececec;
    border-radius: 16px;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
  }

  .product-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
  }

  .product-image {
    position: relative;
    width: 100%;
    height: 150px;
    background-color: #f4f4f5;
    background-image:
      linear-gradient(45deg, #eaeaea 25%, transparent 25%),
      linear-gradient(-45deg, #eaeaea 25%, transparent 25%),
      linear-gradient(45deg, transparent 75%, #eaeaea 75%),
      linear-gradient(-45deg, transparent 75%, #eaeaea 75%);
    background-size: 16px 16px;
    background-position: 0 0, 0 8px, 8px -8px, -8px 0px;
  }

  .product-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  .brand-mark {
    position: absolute;
    bottom: 10px;
    right: 10px;
    width: 26px;
    height: 26px;
    border-radius: 50%;
    background-color: #ffffff;
    box-shadow: 0 1px 4px rgba(0, 0, 0, 0.15);
  }

  .product-body {
    padding: 16px 16px 18px;
    display: flex;
    flex-direction: column;
    flex: 1;
  }

  .category-label {
    font-size: 10.5px;
    font-weight: 700;
    letter-spacing: 0.4px;
    color: #b0b0b0;
    text-transform: uppercase;
    margin-bottom: 6px;
  }

  .product-name {
    font-size: 16px;
    font-weight: 700;
    color: #1a1a1a;
    margin-bottom: 14px;
  }

  .spec-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-bottom: 18px;
    min-height: 28px;
  }

  .spec-tag {
    background-color: #f5f6f8;
    color: #5a5a5a;
    font-size: 11.5px;
    font-weight: 600;
    padding: 5px 10px;
    border-radius: 8px;
    white-space: nowrap;
  }

  .card-footer {
    margin-top: auto;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 8px;
    padding-top: 14px;
    border-top: 1px solid #f0f0f0;
  }

  .footer-links {
    display: flex;
    gap: 14px;
  }

  .link-btn {
    background: none;
    border: none;
    font-size: 12.5px;
    font-weight: 600;
    color: #2563eb;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 3px;
    padding: 0;
    text-decoration: none;
  }

  .link-btn:hover {
    color: #1d4ed8;
    text-decoration: underline;
  }

  .compare-btn {
    background-color: #2563eb;
    color: #ffffff;
    border: none;
    border-radius: 8px;
    padding: 8px 16px;
    font-size: 12.5px;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
    transition: background-color 0.15s ease;
  }

  .compare-btn:hover {
    background-color: #1d4ed8;
  }

  .empty-info {
    margin-top: 24px;
    color: #9a9a9a;
    font-size: 14px;
  }

  .back-link {
    display: inline-block;
    margin-top: 24px;
    color: #2563eb;
    text-decoration: none;
    font-weight: 600;
    font-size: 14px;
  }

  .back-link:hover {
    text-decoration: underline;
  }

  .brand-filter-info {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-top: 8px;
    flex-wrap: wrap;
  }

  .brand-filter-badge {
    display: inline-block;
    background: #eff6ff;
    color: #2563eb;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 600;
  }

  .clear-filter {
    color: #6b7280;
    text-decoration: none;
    font-size: 13px;
    font-weight: 500;
  }

  .clear-filter:hover {
    color: #dc2626;
    text-decoration: underline;
  }

  @media (max-width: 1000px) {
    .product-grid {
      grid-template-columns: repeat(2, 1fr);
    }
  }

  @media (max-width: 560px) {
    .main-content {
      padding: 24px;
    }
    .product-grid {
      grid-template-columns: 1fr;
    }
    .card-footer {
      flex-wrap: wrap;
    }
  }
</style>
</head>
<body>

{{-- NAVBAR --}}
@include('components.navbar')

<div class="main-content">
  <div class="breadcrumb">
    <a href="{{ route('brands.index') }}">Home</a>
    <span class="sep">›</span>
    <a href="{{ route('brands.index') }}">Merek</a>
    <span class="sep">›</span>
    <span class="current">{{ $brandName ? e($brandName) : 'Semua Merek' }}</span>
  </div>

  <h1 class="page-title">Pilih Tipe Kendaraan <span class="highlight">{{ $brandName ? e($brandName) : 'Semua' }}</span></h1>

  @if($brandName)
    <div class="brand-filter-info">
      <span class="brand-filter-badge">✓ {{ e($brandName) }}</span>
      <a href="{{ route('models.index') }}" class="clear-filter">✕ Hapus filter</a>
    </div>
  @endif

  @if($models->isEmpty())
    <p class="empty-info">Belum ada model kendaraan untuk merek ini.</p>
  @else
    <div class="product-grid">

      @foreach($models as $model)
        @php
          $tags = [];
          if ($model->specification) {
            $performa = $model->specification->performa ?? [];
            $kelistrikan = $model->specification->kelistrikan ?? [];
            $body = $model->specification->body ?? [];

            // Kumpulkan semua tag
            $allTags = array_merge(
              is_array($performa) ? array_values($performa) : [],
              is_array($kelistrikan) ? array_values($kelistrikan) : [],
              is_array($body) ? array_values($body) : []
            );

            // Filter dan ambil 3 tag pertama
            $tags = array_slice(array_filter($allTags, function($tag) {
              return !empty($tag) && $tag !== '-' && !is_array($tag);
            }), 0, 3);
          }
        @endphp

        <div class="product-card">
          <div class="product-image">
            @if(!empty($model->url_photo))
              <img src="{{ $model->url_photo }}" alt="{{ e($model->model_name) }}">
            @endif
            {{-- <span class="brand-mark"></span> --}}
          </div>
          <div class="product-body">
            <div class="category-label">{{ $model->type ? e($model->type->type_name) : '&nbsp;' }}</div>
            <div class="product-name">{{ e($model->model_name) }}</div>

            @if(!empty($tags))
              <div class="spec-tags">
                @foreach($tags as $tag)
                  <span class="spec-tag">{{ e($tag) }}</span>
                @endforeach
              </div>
            @endif

            <div class="card-footer">
              <div class="footer-links">
                <a class="link-btn" href="{{ route('compare.detail', $model->id) }}">Detail Spek</a>
                <a class="link-btn" href="{{ route('discussion.index', $model->id) }}#diskusi">Diskusi</a>
              </div>
              <a class="compare-btn" href="{{ route('compare.add', $model->id) }}">Bandingkan</a>
            </div>
          </div>
        </div>
      @endforeach

    </div>
  @endif

  <a class="back-link" href="{{ route('brands.index') }}">← Kembali ke Pilihan Merek</a>
</div>
<x-footer />
</body>
</html>
