<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>新規投稿</title>
</head>
<body>
    <h1>新しい投稿を作成</h1>

    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div>
            <label>タイトル</label><br>
            <input type="text" name="title" value="{{ old('title') }}">
        </div>

        <div>
            <label>説明</label><br>
            <textarea name="description">{{ old('description') }}</textarea>
        </div>

        <div>
            <label>URL</label><br>
            <input type="url" name="url" value="{{ old('url') }}">
        </div>

        <div>
            <label>画像・動画ファイル（複数可）</label><br>
            <p>複数ファイルを選択したい場合はCtrl / Command キーを押しながらファイルをクリック</p><br>
            <input type="file" name="files[]" multiple accept="image/*,video/*">

        </div>

        <button type="submit">投稿する</button>
    </form>

    <p><a href="{{ route('posts.index') }}">← 投稿一覧に戻る</a></p>
</body>
</html>
