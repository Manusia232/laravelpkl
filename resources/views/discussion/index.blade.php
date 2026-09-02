<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Forum Diskusi - {{ e($model->model_name) }}</title>
<meta name="csrf-token" content="{{ csrf_token() }}">
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
  .breadcrumb .current { color: #c7c7c7; }
  .breadcrumb .sep { color: #d5d5d5; }

  .page-title {
    font-size: 24px;
    font-weight: 700;
    color: #1a1a1a;
    margin-bottom: 28px;
  }

  .discussion-wrap {
    max-width: 640px;
    margin: 0 auto;
  }

  .vehicle-image {
    width: 100%;
    height: 190px;
    border-radius: 12px;
    background-color: #f4f4f5;
    background-image:
      linear-gradient(45deg, #eaeaea 25%, transparent 25%),
      linear-gradient(-45deg, #eaeaea 25%, transparent 25%),
      linear-gradient(45deg, transparent 75%, #eaeaea 75%),
      linear-gradient(-45deg, transparent 75%, #eaeaea 75%);
    background-size: 16px 16px;
    background-position: 0 0, 0 8px, 8px -8px, -8px 0px;
    overflow: hidden;
  }

  .vehicle-image img { width: 100%; height: 100%; object-fit: cover; }

  .vehicle-name {
    text-align: center;
    font-size: 14px;
    font-weight: 700;
    color: #1a1a1a;
    margin-top: 12px;
    margin-bottom: 26px;
  }

  .discussion-toolbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding-bottom: 16px;
    flex-wrap: wrap;
    gap: 10px;
  }

  .comment-count { font-size: 13px; color: #6b6b6b; font-weight: 500; }

  .login-link {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 13px;
    font-weight: 600;
    color: #1a1a1a;
    text-decoration: none;
    cursor: pointer;
  }

  .login-avatar {
    width: 20px;
    height: 20px;
    border-radius: 50%;
    background-color: #ef4444;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #ffffff;
    font-size: 11px;
    overflow: hidden;
  }
  .login-avatar img { width: 100%; height: 100%; object-fit: cover; }

  .comment-input-row {
    display: flex;
    align-items: center;
    gap: 12px;
    border: 1px solid #e5e5e5;
    border-radius: 12px;
    padding: 10px 14px;
    margin-bottom: 12px;
    background: #ffffff;
  }

  .comment-input-row.disabled {
    background: #f9fafb;
    cursor: pointer;
  }

  .avatar {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background-color: #f4f4f5;
    flex-shrink: 0;
    overflow: hidden;
  }
  .avatar img { width: 100%; height: 100%; object-fit: cover; }

  .comment-input {
    flex: 1;
    border: none;
    outline: none;
    font-size: 13.5px;
    color: #1a1a1a;
    background: transparent;
  }
  .comment-input::placeholder { color: #b0b0b0; }

  .send-btn {
    border: none;
    background: #2563eb;
    color: #fff;
    font-size: 12.5px;
    font-weight: 600;
    padding: 8px 14px;
    border-radius: 8px;
    cursor: pointer;
    transition: background 0.15s ease;
  }
  .send-btn:hover { background: #1d4ed8; }
  .send-btn:disabled { opacity: 0.6; cursor: not-allowed; }

  .actions-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 22px;
    flex-wrap: wrap;
    gap: 10px;
  }

  .share-btn {
    display: flex;
    align-items: center;
    gap: 6px;
    background: none;
    border: none;
    font-size: 13px;
    color: #6b6b6b;
    cursor: pointer;
    padding: 4px 8px;
    border-radius: 6px;
    transition: background 0.15s ease;
  }
  .share-btn:hover { background: #f3f4f6; }

  .sort-options { display: flex; gap: 14px; font-size: 13px; }
  .sort-options a { 
    cursor: pointer; 
    color: #9a9a9a; 
    font-weight: 500; 
    text-decoration: none;
    padding: 2px 6px;
    border-radius: 4px;
    transition: all 0.15s ease;
  }
  .sort-options a:hover { color: #2563eb; }
  .sort-options a.active { 
    color: #2563eb; 
    font-weight: 700;
    background: #eff6ff;
  }

  .comment-list { display: flex; flex-direction: column; gap: 22px; }
  .comment-item { display: flex; gap: 12px; }
  .comment-body { flex: 1; }

  .comment-header {
    display: flex;
    align-items: baseline;
    gap: 8px;
    margin-bottom: 4px;
    flex-wrap: wrap;
  }

  .comment-author { font-size: 13.5px; font-weight: 700; color: #1a1a1a; }
  .comment-time { font-size: 12px; color: #b0b0b0; }

  .report-btn {
    margin-left: auto;
    background: none;
    border: none;
    color: #9ca3af;
    font-size: 14px;
    cursor: pointer;
    line-height: 1;
    padding: 0 4px;
    transition: color 0.15s ease;
  }
  .report-btn:hover { color: #ef4444; }

  .delete-btn {
    background: none;
    border: none;
    color: #9ca3af;
    font-size: 14px;
    cursor: pointer;
    line-height: 1;
    padding: 0 4px;
    transition: color 0.15s ease;
  }
  .delete-btn:hover { color: #dc2626; }

  .comment-text {
    font-size: 13.5px;
    color: #3a3a3a;
    line-height: 1.5;
    margin-bottom: 8px;
  }

  .comment-actions {
    display: flex;
    align-items: center;
    gap: 16px;
    font-size: 12px;
    color: #9a9a9a;
  }

  .comment-actions button {
    background: none;
    border: none;
    font-size: 12px;
    color: #9a9a9a;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 4px;
    font-weight: 600;
    padding: 4px 8px;
    border-radius: 6px;
    transition: all 0.15s ease;
  }
  .comment-actions button:hover { 
    color: #2563eb; 
    background: #eff6ff;
  }

  .reply-list {
    margin-top: 16px;
    display: flex;
    flex-direction: column;
    gap: 16px;
    padding-left: 0;
  }

  .reply-list .comment-item {
    margin-left: 20px;
    border-left: 2px solid #e5e7eb;
    padding-left: 16px;
  }

  .empty-state { 
    text-align: center; 
    font-size: 13px; 
    color: #b0b0b0; 
    padding: 40px 0; 
  }

  .alert {
    padding: 10px 14px;
    border-radius: 8px;
    margin-bottom: 15px;
    font-size: 14px;
  }
  .alert-success {
    background: #dcfce7;
    color: #166534;
    border: 1px solid #bbf7d0;
  }
  .alert-error {
    background: #fee2e2;
    color: #b91c1c;
    border: 1px solid #fecaca;
  }

  .back-link {
    display: inline-block;
    margin-top: 24px;
    color: #6b7280;
    text-decoration: none;
    font-size: 14px;
    font-weight: 500;
  }
  .back-link:hover { color: #2563eb; }

  @media (max-width: 560px) {
    .main-content { padding: 24px; }
    .vehicle-image { height: 150px; }
    .discussion-toolbar { flex-direction: column; align-items: stretch; }
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
    <a href="{{ route('models.index', ['brand_id' => $model->brand_id]) }}">{{ e($model->brand->brand_name ?? 'Merek') }}</a>
    <span class="sep">›</span>
    <span class="current">{{ e($model->model_name) }}</span>
  </div>

  <h1 class="page-title">Forum diskusi</h1>

  <div class="discussion-wrap">

    <div class="vehicle-image">
      @if(!empty($model->url_photo))
        <img src="{{ $model->url_photo }}" alt="{{ e($model->model_name) }}">
      @endif
    </div>
    <div class="vehicle-name">{{ e($model->model_name) }}</div>

    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
      <div class="alert alert-error">{{ $errors->first() }}</div>
    @endif

    <div class="discussion-toolbar">
      <span class="comment-count">{{ $totalComments }} Comments</span>

      @auth
        <a href="{{ route('profile.index') }}" class="login-link">
          <span class="login-avatar">
            @if(!empty(Auth::user()->url_photo))
              <img src="{{ Auth::user()->url_photo }}" alt="">
            @else
              {{ strtoupper(substr(Auth::user()->username, 0, 1)) }}
            @endif
          </span>
          {{ e(Auth::user()->username) }}
        </a>
      @else
        <a href="{{ route('login') }}" class="login-link">
          <span class="login-avatar">●</span>
          Login
        </a>
      @endauth
    </div>

    @auth
      <form method="POST" action="{{ route('discussion.store', $modelId) }}">
        @csrf
        <input type="hidden" name="sort" value="{{ $sort }}">
        <div class="comment-input-row">
          <div class="avatar">
            @if(!empty(Auth::user()->url_photo))
              <img src="{{ Auth::user()->url_photo }}" alt="">
            @endif
          </div>
          <input type="text" name="content" class="comment-input" placeholder="Mulai lah berdiskusi :)" required>
          <button type="submit" class="send-btn">Kirim</button>
        </div>
      </form>
    @else
      <a href="{{ route('login') }}" style="text-decoration:none;">
        <div class="comment-input-row disabled">
          <div class="avatar"></div>
          <span class="comment-input" style="color:#b0b0b0;">Login untuk mulai diskusi...</span>
        </div>
      </a>
    @endauth

    <div class="actions-row">
      <button class="share-btn" onclick="shareDiscussion()">
        ♡ Share
      </button>
      <div class="sort-options">
        <a href="{{ route('discussion.index', ['id' => $modelId, 'sort' => 'newest']) }}" 
           class="{{ $sort === 'newest' ? 'active' : '' }}">Newest</a>
        <a href="{{ route('discussion.index', ['id' => $modelId, 'sort' => 'oldest']) }}" 
           class="{{ $sort === 'oldest' ? 'active' : '' }}">Oldest</a>
      </div>
    </div>

    <div class="comment-list" id="diskusi">
      @if(empty($byParent[0]))
        <div class="empty-state">Belum ada komentar. Jadilah yang pertama berkomentar!</div>
      @else
        @foreach($byParent[0] as $comment)
          @include('discussion._comment', [
            'comment' => $comment, 
            'byParent' => $byParent, 
            'modelId' => $modelId,
            'sort' => $sort
          ])
        @endforeach
      @endif
    </div>

  </div>

  <a href="{{ route('models.index', ['brand_id' => $model->brand_id]) }}" class="back-link">
    ← Kembali ke Daftar Model
  </a>
</div>

<script>
  const isLoggedIn = @json(Auth::check());
  const currentUsername = @json(Auth::check() ? Auth::user()->username : null);

  function toggleReplyForm(commentId) {
    if (!isLoggedIn) {
      alert('Silakan login terlebih dahulu untuk membalas komentar.');
      window.location.href = '{{ route("login") }}';
      return;
    }
    const form = document.getElementById('reply-form-' + commentId);
    if (form) {
      form.style.display = form.style.display === 'none' ? 'block' : 'none';
      if (form.style.display === 'block') {
        form.querySelector('input[name="content"]').focus();
      }
    }
  }

  function shareDiscussion() {
    const url = window.location.href;
    if (navigator.share) {
      navigator.share({ url }).catch(() => {});
    } else {
      navigator.clipboard.writeText(url).then(() => {
        alert('Tautan diskusi disalin.');
      }).catch(() => {
        alert('Salin tautan: ' + url);
      });
    }
  }

  function reportComment(commentId, btn) {
    if (!isLoggedIn) {
      alert('Silakan login terlebih dahulu untuk melaporkan komentar.');
      window.location.href = '{{ route("login") }}';
      return;
    }
    if (!confirm('Laporkan komentar ini?')) return;

    btn.disabled = true;
    const originalText = btn.textContent;
    btn.textContent = '...';

    fetch('{{ route("discussion.report") }}', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
      },
      body: JSON.stringify({
        comment_id: commentId
      })
    })
    .then(res => res.json())
    .then(data => {
      alert(data.message || 'Laporan terkirim.');
    })
    .catch(() => {
      alert('Gagal mengirim laporan. Coba lagi.');
    })
    .finally(() => {
      btn.disabled = false;
      btn.textContent = originalText;
    });
  }

  function deleteComment(commentId) {
    if (!confirm('Yakin ingin menghapus komentar ini?')) return;
    
    fetch('{{ route("discussion.delete", "") }}/' + commentId, {
      method: 'DELETE',
      headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
      }
    })
    .then(response => {
      if (response.ok) {
        window.location.reload();
      } else {
        alert('Gagal menghapus komentar.');
      }
    })
    .catch(() => {
      alert('Gagal menghapus komentar.');
    });
  }

  document.addEventListener('DOMContentLoaded', function() {
    if (window.location.hash === '#diskusi') {
      document.getElementById('diskusi').scrollIntoView({ behavior: 'smooth' });
    }
  });
</script>
    <x-footer />

</body>
</html>