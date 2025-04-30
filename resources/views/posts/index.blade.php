<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>トップページ</title>
</head>
<body>
    <div style="text-align: right; margin-bottom: 20px;">
        @guest
            <a href="{{ route('login') }}">ログイン</a> |
            <a href="{{ route('register') }}">新規登録</a>
        @else
            <span>ようこそ、{{ Auth::user()->name }} さん</span> |
            <a href="{{ route('posts.index') }}">ダッシュボード</a> |
            <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                @csrf
                <button type="submit" style="background: none; border: none; color: blue; cursor: pointer;">
                    ログアウト
                </button>
            </form>
        @endguest
    </div>

    <h1>投稿一覧</h1>

    @if (session('success'))
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

                {{-- メディア表示 --}}
                @if ($post->files->isNotEmpty())
                    <div style="margin-top: 10px;">
                        @foreach ($post->files as $file)

                            {{-- debug: 今だけ URL を表示して様子を見る --}}
                            {{-- <p style="font-size:12px;color:#888;">{{ $file->url }}</p> --}}

                            @if ($file->file_type === 'image')
                                <img src="{{ $file->url }}"
                                     alt="画像"
                                     width="150"
                                     style="margin-bottom: 10px;">
                            @elseif ($file->file_type === 'video')
                                <video width="300" controls style="margin-bottom: 10px;">
                                    <source src="{{ $file->url }}">
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
