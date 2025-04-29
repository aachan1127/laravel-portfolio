<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>新規投稿</title>
</head>
<body>
    <h1>新しい投稿を作成</h1>

    <form action="{{ route('posts.store') }}" method="POST">
        @csrf

        <div>
            <label>タイトル</label><br>
            <input type="text" name="title">
        </div>

        <div>
            <label>説明</label><br>
            <textarea name="description"></textarea>
        </div>

        <div>
            <label>URL</label><br>
            <input type="text" name="url">
        </div>

        <button type="submit">投稿する</button>
    </form>

    <p><a href="{{ route('posts.index') }}">← 投稿一覧に戻る</a></p>
</body>
</html>
