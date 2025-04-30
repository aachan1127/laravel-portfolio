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
                <th>メディア</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($posts as $post)
                <tr>
                    <td>{{ $post->title }}</td>
                    <td>{{ $post->description }}</td>

                    {{-- 画像投稿 --}}
                    <td>
                        @foreach ($post->files as $file)
                            @if ($file->file_type === 'image')
                                <img src="{{ asset('storage/' . $file->file_path) }}" alt="画像" width="150" style="margin-bottom: 10px;">
                            @elseif ($file->file_type === 'video')
                                <video width="200" controls style="margin-bottom: 10px;">
                                    <source src="{{ asset('storage/' . $file->file_path) }}">
                                    お使いのブラウザは video タグに対応していません。
                                </video>
                            @endif
                        @endforeach
                    </td>


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
