<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Pilih yang Ingin Dibandingkan</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
  * { box-sizing: border-box; margin: 0; padding: 0; }

  body {
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Arial, sans-serif;
    background: #ffffff;
    color: #1a1a2e;
    padding: 0;
  }

  .main-content {
    max-width: 1000px;
    margin: 0 auto;
    padding: 32px 48px 60px;
  }

  .top-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 24px;
    flex-wrap: wrap;
    gap: 10px;
  }

  h1 { font-size: 18px; font-weight: 700; color: #1a1a2e; }

  .clear-link {
    font-size: 12.5px;
    font-weight: 600;
    color: #9aa0b4;
    text-decoration: none;
    padding: 4px 8px;
    border-radius: 4px;
    transition: background 0.15s ease;
  }
  .clear-link:hover { 
    color: #ff5a6e; 
    background: #fff5f6;
  }

  .flash-msg {
    background: #fff4e5;
    color: #9a5b00;
    border: 1px solid #ffe0b2;
    padding: 10px 14px;
    border-radius: 8px;
    font-size: 13px;
    margin-bottom: 20px;
  }

  .cards-wrapper {
    overflow-x: auto;
    overflow-y: visible;
    padding-bottom: 12px;
    margin: 0 -8px;
    -webkit-overflow-scrolling: touch;
  }

  .cards-wrapper::-webkit-scrollbar {
    height: 6px;
  }

  .cards-wrapper::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
  }

  .cards-wrapper::-webkit-scrollbar-thumb {
    background: #c1c7d0;
    border-radius: 10px;
  }

  .cards-wrapper::-webkit-scrollbar-thumb:hover {
    background: #a0a7b2;
  }

  .cards-row {
    display: flex;
    gap: 5px;
    flex-wrap: nowrap;
    justify-content: flex-start;
    padding: 0 8px;
    min-width: min-content;
  }

  .card {
    width: 220px;
    flex-shrink: 0;
    border: 1px solid #e4e6ef;
    border-radius: 10px;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    background: #fff;
    box-shadow: 0 1px 3px rgba(0,0,0,0.04);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
  }

  .card:hover {
    transform: translateY(-4px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
  }

  .card-image-wrap {
    position: relative;
    width: 100%;
    height: 130px;
    overflow: hidden;
    background: #f4f5f9;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #c3c7d6;
    font-size: 28px;
  }

  .card-image-wrap img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
  }

  .badge-logo {
    position: absolute;
    bottom: 8px;
    right: 8px;
    background: #ffffff;
    border-radius: 50%;
    width: 26px;
    height: 26px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 9px;
    font-weight: 700;
    color: #3b5bfd;
    box-shadow: 0 1px 2px rgba(0,0,0,0.15);
    overflow: hidden;
  }
  .badge-logo img { width: 100%; height: 100%; object-fit: cover; }

  .card-body {
    padding: 12px 14px 14px;
    display: flex;
    flex-direction: column;
    gap: 6px;
  }

  .category-label {
    font-size: 9px;
    font-weight: 700;
    letter-spacing: 0.5px;
    color: #9aa0b4;
    text-transform: uppercase;
  }

  .product-name { font-size: 14px; font-weight: 700; color: #1a1a2e; }

  .specs-row {
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
    margin-top: 2px;
    min-height: 24px;
  }

  .spec-pill {
    background: #f2f3f8;
    color: #6b7280;
    font-size: 9.5px;
    font-weight: 500;
    padding: 3px 8px;
    border-radius: 4px;
  }

  .remove-btn {
    margin-top: 10px;
    width: 100%;
    background: #ff5a6e;
    color: #fff;
    border: none;
    border-radius: 6px;
    padding: 8px 0;
    font-size: 11px;
    font-weight: 600;
    cursor: pointer;
    text-align: center;
    text-decoration: none;
    display: block;
    transition: background 0.15s ease;
  }
  .remove-btn:hover { background: #e8465b; }

  .add-card {
    width: 220px;
    flex-shrink: 0;
    min-height: 244px;
    border: 1.5px dashed #d7dae4;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #fff;
    text-decoration: none;
    transition: border-color 0.15s ease, background 0.15s ease;
  }
  .add-card:hover { border-color: #3b5bfd; background: #f7f8ff; }

  .add-card-content {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 8px;
    color: #6b7280;
    font-size: 12px;
    font-weight: 600;
  }

  .add-icon {
    width: 22px;
    height: 22px;
    border-radius: 50%;
    border: 1.5px solid #6b7280;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    line-height: 1;
  }

  .add-icon img {
    width: 14px;
    height: 14px;
  }

  .empty-state {
    padding: 60px 20px;
    text-align: center;
    color: #9aa0b4;
    font-size: 14px;
  }

  .empty-state a {
    color: #3b5bfd;
    font-weight: 600;
    text-decoration: none;
  }
  .empty-state a:hover {
    text-decoration: underline;
  }

  .compare-btn-wrap { display: flex; justify-content: center; margin-top: 36px; }

  .compare-btn, .compare-btn-disabled {
    border: none;
    border-radius: 8px;
    padding: 12px 60px;
    font-size: 14px;
    font-weight: 700;
    text-decoration: none;
    display: inline-block;
    transition: background 0.15s ease;
  }

  .compare-btn {
    background: #3b5bfd;
    color: #fff;
    cursor: pointer;
  }
  .compare-btn:hover { background: #2e49d6; }

  .compare-btn-disabled {
    background: #c3cbf5;
    color: #fff;
    cursor: not-allowed;
  }

  .back-link {
    display: inline-block;
    margin-top: 20px;
    color: #6b7280;
    text-decoration: none;
    font-size: 13px;
    font-weight: 500;
  }
  .back-link:hover {
    color: #3b5bfd;
  }

  @media (max-width: 640px) {
    .main-content { padding: 24px; }
    .compare-btn, .compare-btn-disabled { padding: 12px 40px; }
  }

  @media (max-width: 480px) {
    .card, .add-card {
      width: 180px;
    }
    .card-image-wrap {
      height: 110px;
    }
    .product-name {
      font-size: 12px;
    }
  }
</style>
</head>
<body>

{{-- NAVBAR --}}
@include('components.navbar')

<div class="main-content">
  <div class="top-bar">
    <h1>Pilih yang ingin dibandingkan ({{ $count }}/4)</h1>
    @if($count > 0)
      <a class="clear-link" href="{{ route('compare.clear') }}">
        <i class="fa-regular fa-trash-can"></i> Kosongkan semua
      </a>
    @endif
  </div>

  @if($msg)
    <div class="flash-msg">{{ e($msg) }}</div>
  @endif

  @if($count === 0)
    <div class="empty-state">
      Belum ada kendaraan yang dipilih.<br>
      <a href="{{ route('brands.index') }}">Cari kendaraan untuk dibandingkan &rsaquo;</a>
    </div>
  @else
    <div class="cards-wrapper">
      <div class="cards-row">
        @foreach($models as $model)
          @php
            $tags = [];
            if ($model->specification) {
              $performa = $model->specification->performa ?? [];
              $kelistrikan = $model->specification->kelistrikan ?? [];
              $body = $model->specification->body ?? [];
              
              $allTags = array_merge(
                is_array($performa) ? array_values($performa) : [],
                is_array($kelistrikan) ? array_values($kelistrikan) : [],
                is_array($body) ? array_values($body) : []
              );
              
              $tags = array_slice(array_filter($allTags, function($tag) {
                return !empty($tag) && $tag !== '-' && !is_array($tag);
              }), 0, 3);
            }
          @endphp

          <div class="card">
            <div class="card-image-wrap">
              @if(!empty($model->url_photo))
                <img src="{{ $model->url_photo }}" alt="{{ e($model->model_name) }}">
              @else
                <i class="fa-solid fa-car"></i>
              @endif

              @if(!empty($model->brand->url_logo))
                <span class="badge-logo"><img src="{{ $model->brand->url_logo }}" alt=""></span>
              @endif
            </div>
            <div class="card-body">
              <span class="category-label">{{ $model->type->type_name ?? $model->brand->brand_name ?? '' }}</span>
              <span class="product-name">{{ e($model->model_name) }}</span>

              @if(!empty($tags))
                <div class="specs-row">
                  @foreach($tags as $tag)
                    <span class="spec-pill">{{ e($tag) }}</span>
                  @endforeach
                </div>
              @endif

              <a class="remove-btn" href="{{ route('compare.remove', $model->id) }}">
                <i class="fa-regular fa-circle-xmark"></i> Hapus dari sini
              </a>
            </div>
          </div>
        @endforeach

        @if($canAdd)
          <a class="add-card" href="{{ route('brands.index') }}">
            <div class="add-card-content">
              <span class="add-icon">
                <img src="https://www.svgrepo.com/show/393166/plus.svg" alt="Tambah">
              </span>
              <span>Tambah Perbandingan</span>
            </div>
          </a>
        @endif
      </div>
    </div>

    <div class="compare-btn-wrap">
      @if($canCompare)
        <a class="compare-btn" href="{{ route('compare.result') }}">Bandingkan</a>
      @else
        <span class="compare-btn-disabled">Pilih minimal 2 kendaraan</span>
      @endif
    </div>
  @endif

  <a class="back-link" href="{{ route('brands.index') }}">← Kembali ke Pilihan Merek</a>
</div>
<x-footer />
</body>
</html>