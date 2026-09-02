@php
    $avatar = !empty($comment->user->url_photo) 
        ? '<img src="' . e($comment->user->url_photo) . '" alt="' . e($comment->user->name) . '">' 
        : '';
    $isOwner = Auth::check() && Auth::id() === $comment->user_id;
    $isAdmin = Auth::check() && Auth::user()->role === 'admin';
    $canDelete = $isOwner || $isAdmin;
@endphp

<div class="comment-item" id="comment-{{ $comment->id }}">
  <div class="avatar">{!! $avatar !!}</div>
  <div class="comment-body">
    <div class="comment-header">
      <span class="comment-author">{{ e($comment->user->name) }}</span>
      <span class="comment-time">{{ $comment->created_at->diffForHumans() }}</span>
      <button class="report-btn" title="Laporkan komentar" onclick="reportComment({{ $comment->id }}, this)">▲</button>
      @if($canDelete)
        <button class="delete-btn" title="Hapus komentar" onclick="deleteComment({{ $comment->id }})">✕</button>
      @endif
    </div>
    <p class="comment-text">{{ nl2br(e($comment->content)) }}</p>
    <div class="comment-actions">
      <button onclick="toggleReplyForm({{ $comment->id }})">Reply</button>
    </div>

    @auth
      <form class="reply-form" id="reply-form-{{ $comment->id }}" 
            method="POST" action="{{ route('discussion.store', $modelId) }}" 
            style="display:none; margin-top:10px;">
        @csrf
        <input type="hidden" name="parent_id" value="{{ $comment->id }}">
        <input type="hidden" name="sort" value="{{ $sort }}">
        <div class="comment-input-row" style="margin-bottom:0;">
          <div class="avatar">
            @if(!empty(Auth::user()->url_photo))
              <img src="{{ Auth::user()->url_photo }}" alt="">
            @endif
          </div>
          <input type="text" name="content" class="comment-input" placeholder="Tulis balasan..." required>
          <button type="submit" class="send-btn">Kirim</button>
        </div>
      </form>
    @endauth

    @if(!empty($byParent[$comment->id]))
      <div class="reply-list">
        @foreach($byParent[$comment->id] as $reply)
          @include('discussion._comment', [
            'comment' => $reply, 
            'byParent' => $byParent, 
            'modelId' => $modelId,
            'sort' => $sort
          ])
        @endforeach
      </div>
    @endif

  </div>
</div>