<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>管理画面｜投稿一覧</title>
</head>
<body>
    <h1>管理画面｜投稿一覧</h1>

    <p><a href="{{ route('posts.create') }}">＋ 新しい投稿を作成する</a></p>
    <p><a href="{{ url('/') }}">← トップページに戻る</a></p>

    @if (session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <table border="1" cellpadding="8">
        <thead>
            <tr>
                <th>タイトル</th>
                <th>説明</th>
                <th>メディア</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($posts as $post)
            <li style="margin-bottom: 40px;">
                <h2>{{ $post->title }}</h2>
                <p>{{ $post->description }}</p>

                @if ($post->url)
                    <p><a href="{{ $post->url }}" target="_blank">リンクを見る</a></p>
                @endif

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
        </tbody>
    </table>
</body>
</html>
