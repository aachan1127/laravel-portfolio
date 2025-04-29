<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>投稿編集</title>
</head>
<body>
    <h1>投稿編集</h1>

    <form action="{{ route('posts.update', $post->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div>
            <label>タイトル</label><br>
            <input type="text" name="title" value="{{ old('title', $post->title) }}">
        </div>

        <div>
            <label>説明</label><br>
            <textarea name="description">{{ old('description', $post->description) }}</textarea>
        </div>

        <div>
            <label>URL</label><br>
            <input type="text" name="url" value="{{ old('url', $post->url) }}">
        </div>

        <button type="submit">更新する</button>
    </form>

    <p><a href="{{ route('posts.index') }}">一覧に戻る</a></p>
</body>
</html>
