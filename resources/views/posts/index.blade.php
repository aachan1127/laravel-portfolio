<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>トップページ</title>
</head>
<body>
  <!-- 🔐 ログイン・登録ボタン表示 -->
  <div style="text-align: right; margin-bottom: 20px;">
    @guest
      <a href="{{ route('login') }}">ログイン</a> |
      <a href="{{ route('register') }}">新規登録</a>
    @else
      <span>ようこそ、{{ Auth::user()->name }} さん</span> |
      <a href="{{ route('posts.index') }}">ダッシュボード</a> |
      <form method="POST" action="{{ route('logout') }}" style="display: inline;">
        @csrf
        <button type="submit" style="background: none; border: none; color: blue; cursor: pointer;">ログアウト</button>
      </form>
    @endguest
  </div>

  <h1>投稿一覧</h1>

  @if(session('success'))
    <p style="color: green;">{{ session('success') }}</p>
  @endif

  @if ($posts->isEmpty())
    <p>まだ投稿がありません。</p>
  @else
    <ul>
      @foreach ($posts as $post)
        <li style="margin-bottom: 40px;">
          <h2>{{ $post->title }}</h2>
          <p>{{ $post->description }}</p>

          @if ($post->url)
            <p><a href="{{ $post->url }}" target="_blank">リンクを見る</a></p>
          @endif

          {{-- 画像・動画表示 --}}
          @if ($post->files->isNotEmpty())
            <div style="margin-top: 10px;">
              @foreach ($post->files as $file)
                @if ($file->file_type === 'image')
                  <img src="{{ asset('storage/' . $file->file_path) }}" alt="画像" width="200" style="margin-bottom: 10px;">
                @elseif ($file->file_type === 'video')
                  <video width="300" controls style="margin-bottom: 10px;">
                    <source src="{{ asset('storage/' . $file->file_path) }}">
                    お使いのブラウザは video タグに対応していません。
                  </video>
                @endif
              @endforeach
            </div>
          @endif
        </li>
      @endforeach
    </ul>
  @endif

</body>
</html>
