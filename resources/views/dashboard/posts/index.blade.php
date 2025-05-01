<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>管理画面｜制作物一覧</title>

  <link rel="stylesheet"
  href="{{ asset('css/style.css') }}?v={{ filemtime(public_path('css/style.css')) }}">

  {{-- <link rel="stylesheet" href="{{ asset('css/style.css') }}"> --}}
</head>
<body>

  <div class="container">
    <h1>管理画面｜制作物一覧</h1>

    <div style="margin-bottom: 20px;">
        <a href="{{ url('/') }}" class="button-link">← トップページに戻る</a>
      <a href="{{ route('posts.create') }}" class="button-link-up">＋ 新しい投稿を作成</a>
    </div>

    @if (session('success'))
      <p style="color: green;">{{ session('success') }}</p>
    @endif

    @if ($posts->isEmpty())
      <p>まだ投稿がありません。</p>
    @else
    <ul class="post-grid">
        @foreach ($posts as $post)
          <li>
            <h2>{{ $post->title }}</h2>

            @if ($post->files->isNotEmpty())
              @foreach ($post->files as $file)
                @if ($file->file_type === 'image')
                  <img src="{{ Storage::disk('s3')->url($file->file_path) }}" alt="画像">
                @elseif ($file->file_type === 'video')
                  <video controls>
                    <source src="{{ Storage::disk('s3')->url($file->file_path) }}">
                    このブラウザは video タグに対応していません。
                  </video>
                @endif
              @endforeach
            @endif

            <p>{{ $post->description }}</p>

            @if ($post->url)
              <a href="{{ $post->url }}" target="_blank" class="button-link">🔗 リンクを見る</a>
            @endif

            <div style="margin-top: 10px;">
              <a href="{{ route('posts.edit', $post->id) }}" class="button-link">✏ 編集</a>

              <form action="{{ route('posts.destroy', $post->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="button-link" onclick="return confirm('本当に削除しますか？')">🗑 削除</button>
              </form>
            </div>
          </li>
        @endforeach
      </ul>
    @endif
  </div>

</body>
</html>
