<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Pilih Merek Kendaraan</title>
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
    padding: 32px 48px 60px;
    max-width: 1280px;
    margin: 0 auto;
  }

  .page-title {
    font-size: 28px;
    font-weight: 700;
    color: #1a1a1a;
  }

  .page-title .highlight {
    color: #2563eb;
  }

  .page-subtitle {
    margin-top: 8px;
    font-size: 14px;
    color: #8a8a8a;
    max-width: 480px;
    line-height: 1.5;
  }

  .brand-grid {
    margin-top: 28px;
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
  }

  .brand-card {
    background-color: #ffffff;
    border: 1px solid #ececec;
    border-radius: 14px;
    padding: 18px;
    position: relative;
    display: flex;
    flex-direction: column;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
  }

  .brand-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
  }

  .model-badge {
    position: absolute;
    top: 14px;
    right: 14px;
    background-color: #f2f2f2;
    color: #6b6b6b;
    font-size: 11px;
    font-weight: 600;
    padding: 3px 9px;
    border-radius: 20px;
  }

  .brand-logo {
    width: 100%;
    height: 110px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    margin-bottom: 14px;
  }

  .brand-logo img {
    max-width: 80%;
    max-height: 80%;
    object-fit: contain;
  }

  .brand-logo.placeholder {
    background-color: #f4f4f5;
    background-image:
      linear-gradient(45deg, #eaeaea 25%, transparent 25%),
      linear-gradient(-45deg, #eaeaea 25%, transparent 25%),
      linear-gradient(45deg, transparent 75%, #eaeaea 75%),
      linear-gradient(-45deg, transparent 75%, #eaeaea 75%);
    background-size: 16px 16px;
    background-position: 0 0, 0 8px, 8px -8px, -8px 0px;
  }

  .brand-logo.placeholder::after {
    content: "Logo";
    font-size: 12px;
    color: #b0b0b0;
    font-weight: 500;
  }

  .brand-name {
    text-align: center;
    font-size: 16px;
    font-weight: 700;
    color: #1a1a1a;
  }

  .brand-tagline {
    text-align: center;
    font-size: 12px;
    color: #9a9a9a;
    margin-top: 4px;
    margin-bottom: 16px;
  }

  .brand-button {
    margin-top: auto;
    background-color: #f5f6f8;
    border: none;
    border-radius: 10px;
    padding: 10px 0;
    font-size: 13px;
    font-weight: 600;
    color: #1a1a1a;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    transition: background-color 0.15s ease;
    text-decoration: none;
    width: 100%;
  }

  .brand-button:hover {
    background-color: #ebedf0;
  }

  .brand-card.utility .brand-logo.placeholder::after {
    content: "";
  }

  .empty-info {
    margin-top: 24px;
    color: #9a9a9a;
    font-size: 14px;
  }

  @media (max-width: 1000px) {
    .brand-grid {
      grid-template-columns: repeat(2, 1fr);
    }
  }

  @media (max-width: 560px) {
    .main-content {
      padding: 24px;
    }
    .brand-grid {
      grid-template-columns: 1fr;
    }
  }
</style>
</head>
<body>

{{-- NAVBAR --}}
@include('components.navbar')

<div class="main-content">
  <h1 class="page-title">Pilih <span class="highlight">Merek</span> Kendaraan</h1>
  <p class="page-subtitle">Temukan berbagai merek kendaraan listrik terbaik dan bandingkan spesifikasi mereka secara mendalam.</p>

  @if($brands->isEmpty())
    <p class="empty-info">Belum ada data merek di database.</p>
  @endif

  <div class="brand-grid">

    @foreach($brands as $brand)
      <div class="brand-card">
        <span class="model-badge">{{ $brand->models_count }} Model</span>

        <div class="brand-logo {{ empty($brand->url_logo) ? 'placeholder' : '' }}">
          @if(!empty($brand->url_logo))
            <img src="{{ $brand->url_logo }}" alt="{{ $brand->brand_name }}">
          @endif
        </div>

        <div class="brand-name">{{ $brand->brand_name }}</div>
        <div class="brand-tagline">&nbsp;</div>

        <a class="brand-button" href="{{ route('models.index', ['brand_id' => $brand->id]) }}">
          Lihat Produk <span class="arrow">›</span>
        </a>
      </div>
    @endforeach

    <!-- Pilih semua -->
    <div class="brand-card utility">
      <div class="brand-logo placeholder"></div>
      <div class="brand-name">Pilih semua</div>
      <div class="brand-tagline">&nbsp;</div>
      <a class="brand-button" href="{{ route('models.index') }}">Lihat Produk</a>
    </div>

    <!-- Cari sesuai keinginan -->
    <div class="brand-card utility">
      <div class="brand-logo placeholder"></div>
      <div class="brand-name">Cari sesuai keinginan</div>
      <div class="brand-tagline">&nbsp;</div>
    </div>

  </div>
</div>
<x-footer />
</body>
</html>