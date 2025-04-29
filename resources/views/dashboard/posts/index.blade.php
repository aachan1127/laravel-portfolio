<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>管理画面｜投稿一覧</title>
</head>
<body>
    <h1>管理画面｜投稿一覧</h1>

    <p>
        <a href="{{ route('posts.create') }}">＋ 新しい投稿を作成する</a>
    </p>

    <p>
        <a href="{{ url('/') }}">← トップページに戻る</a>
    </p>


    @if (session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <table border="1" cellpadding="8">
        <thead>
            <tr>
                <th>タイトル</th>
                <th>説明</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($posts as $post)
                <tr>
                    <td>{{ $post->title }}</td>
                    <td>{{ $post->description }}</td>
                    <td>
                        <a href="{{ route('posts.edit', $post->id) }}">編集</a> |
                        <form action="{{ route('posts.destroy', $post->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit">削除</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
