<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>トップページ</title>
</head>

<body>
    <h1>投稿一覧</h1>

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    @if ($posts->isEmpty())
        <p>まだ投稿がありません。</p>
    @else
        <ul>
            @foreach ($posts as $post)
                <li>
                    <h2>{{ $post->title }}</h2>
                    <p>{{ $post->description }}</p>
                    @if ($post->url)
                        <p><a href="{{ $post->url }}" target="_blank">リンクを見る</a></p>
                    @endif
                </li>
            @endforeach
        </ul>
    @endif

    <p><a href="{{ route('posts.create') }}">新しい投稿を作成する</a></p>
</body>

</html>
