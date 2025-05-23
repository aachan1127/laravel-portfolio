<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>トップページ</title>
  {{-- <link rel="stylesheet" href="{{ asset('css/style.css') }}"> --}}

  <link rel="stylesheet" href="{{ asset('css/style.css') }}?v={{ filemtime(public_path('css/style.css')) }}">
</head>

<body class="home">

  <div class="container">
    <div style="text-align: right; margin-bottom: 20px;">
      @guest
        <a href="{{ route('login') }}" class="button-link">ログイン</a>
        <a href="{{ route('register') }}" class="button-link">新規登録</a>
      @else
        <span>ようこそ、{{ Auth::user()->name }} さん</span> |
        <a href="{{ route('posts.index') }}" class="button-link">管理画面</a>
        <form method="POST" action="{{ route('logout') }}" style="display: inline;">
          @csrf
          <button type="submit" class="button-link">ログアウト</button>
        </form>
      @endguest
    </div>

    <h1>制作物一覧</h1>

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

            {{-- ★ 改行保持して説明文を表示させる ★ --}}
            <p>{!! nl2br(e($post->description)) !!}</p>

            @if ($post->url)
              <a href="{{ $post->url }}" target="_blank" class="button-link">🔗 リンクを見る</a>
            @endif
          </li>
        @endforeach
      </ul>
    @endif
  </div>
</body>

</html>
