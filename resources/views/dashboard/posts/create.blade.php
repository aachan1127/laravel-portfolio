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
            <p>Ctrl / Command で複数選択可能</p>
            <input type="file" name="files[]" multiple accept="image/*,video/*">
            
        </div>

        <button type="submit">投稿する</button>
    </form>

    <p><a href="{{ route('posts.index') }}">← 投稿一覧に戻る</a></p>

    {{-- アップロードできない拡張子にはアラートを表示 --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const fileInput = document.querySelector('input[type="file"]');

            if (fileInput) {
                fileInput.addEventListener('change', () => {
                    const validExtensions = ['jpg', 'jpeg', 'png', 'gif', 'mp4', 'mov', 'avi'];
                    for (const file of fileInput.files) {
                        const ext = file.name.split('.').pop().toLowerCase();
                        if (!validExtensions.includes(ext)) {
                            alert('拡張子が対応していません: ' + file.name);
                            fileInput.value = ''; // 入力リセット
                            break;
                        }
                    }
                });
            }
        });
        </script>


</body>
</html>
